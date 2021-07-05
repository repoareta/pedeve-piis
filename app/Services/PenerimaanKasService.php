<?php

namespace App\Services;

use App\Http\Resources\PenerimaanKasResource;
use App\Models\Kasdoc;
use App\Models\Kasline;
use App\Models\SaldoStore;
use DB;
use Illuminate\Http\Request;

class PenerimaanKasService
{
    protected $kasHeader;
    protected $kasLine;
    protected $stringDate;
    protected $saldoStore;
    protected $request;

    public function __construct(
        Kasdoc $kasHeader,
        Kasline $kasLine,
        Request $request,
        SaldoStore $saldoStore
    ) {
        $this->kasHeader = $kasHeader;
        $this->kasLine = $kasLine;
        $this->saldoStore = $saldoStore;
        $this->request = $request;
    }

    public function getCollection(string $stringDate)
    {
        $bulan = $this->request->bulan;
        $tahun = $this->request->tahun;
        $bukti = $this->request->bukti;

        $dataKasHeader = $this->kasHeader
            ->with('storejk')
            ->where('kasdoc.kd_kepada', '=', null);

        if (is_null($bulan) && is_null($tahun) && is_null($bukti)) {
            $dataKasHeader = $dataKasHeader->where('thnbln', $stringDate);
        }

        if ($tahun !== null) {
            $dataKasHeader = $dataKasHeader->where(DB::raw('LEFT(thnbln, 4)'), '=', $tahun);
        }

        if ($bulan !== null) {
            $dataKasHeader = $dataKasHeader->where(DB::raw('RIGHT(thnbln, 2)'), '=', $bulan);
        }

        if ($bukti !== null) {
            $dataKasHeader = $dataKasHeader->where('voucher', '=', $bukti);
        }

        $dataKasHeader = $dataKasHeader
            ->orderBy('kasdoc.store', 'asc')
            ->orderBy('kasdoc.voucher', 'asc')
            ->get([
                'docno',
                'originaldate',
                'thnbln',
                'jk',
                'store',
                'ci',
                'voucher',
                'kepada',
                'rate',
                'nilai_dok',
                'paid',
                'verified',
            ]);

        return PenerimaanKasResource::collection($dataKasHeader);
    }

    public function getDatatables(string $stringDate)
    {
        $formattedKasData = collect($this->getCollection($stringDate));

        return datatables()->of($formattedKasData)
            ->addColumn('radio', function ($formattedKasData) {
                return '
                    <label class="kt-radio kt-radio--bold kt-radio--brand">
                        <input type="radio" value="' . $formattedKasData['no_dok'] . '" class="btn-radio" name="btn-radio">
                        <span></span>
                    </label>';
            })
            ->addColumn('status', function ($formattedKasData) {
                return '
                <span class="badge badge-' . ($formattedKasData['status_verified'] == 'N' ? 'danger' : 'success') . '">' . ($formattedKasData['status_verified'] == 'N' ? 'Belum Diverifikasi' : 'Terverifikasi') . '</span>
                <span class="badge badge-' . ($formattedKasData['status_paid'] == 'N' ? 'danger' : 'success') . '">' . ($formattedKasData['status_paid'] == 'N' ? 'Belum Terbayar' : 'Telah Terbayar') . '</span>
                ';
            })
            ->addColumn('action', function ($formattedKasData) {
                $onClickAction = 'onclick="redirectToApproval(`' . str_replace('/', '-', $formattedKasData['no_dok']) . '`, ' . ($formattedKasData['status_paid'] == 'Y' ? 'true' : 'false') . ')"';

                $titleButton = $formattedKasData['status_paid'] == 'Y' ? 'Batalkan Pembayaran' : 'Klik untuk melakukan Pembayaran';

                $actionButtonOpenTag = '<button class="btn btn-sm btn-clean btn-icon" title="' . $titleButton . '" ' . $onClickAction . '>';
                
                $actionButtonCloseTag = '</button>';

                $iconButton = '<i class="la la-' . ($formattedKasData['status_paid'] == 'Y' ? 'times' : 'check') . '"></i>';

                $actionButton = $actionButtonOpenTag . $iconButton . $actionButtonCloseTag;

                if ($formattedKasData['status_verified'] == 'Y') {
                    $actionButton = null;
                }

                return $formattedKasData['status_verified'] == 'N' ? $actionButton : null;
            })
            ->rawColumns(['radio', 'status', 'action'])
            ->make(true);
    }

    public function getKasDocument($documentId, ?array $relations = null)
    {
        $documentId = str_replace('-', '/', $documentId);

        $document = $this->kasHeader;

        if ($relations) {
            $document = $document->with($relations);
        }

        return $document->where('docno', $documentId)->first();
    }

    public function getTotalKasline($documentId)
    {
        return $this->kasLine->where([
            'penutup' => 'N',
            'docno' => str_replace('-', '/', $documentId),
        ])->sum('totprice');
    }

    public function approval($documentId, $request, bool $cancelation = false)
    {
        $bayar = $cancelation ? -1 : 1;

        $kasHeader = $this->getKasDocument($documentId);

        $angkaAkhir = -9999999999999999;

        $tanggalRekap = DB::table('rekapkas')
                            ->select(DB::raw('max(tglrekap) as tanggal_rekap'))
                            ->where('jk', $kasHeader->jk)
                            ->where('store', $kasHeader->store)
                            ->first();

        if (empty($tanggalRekap)) {
            $tanggalRekap = date(now());
        }

        $totalKasLine = $this->getTotalKasline($documentId);

        $selisih = round($totalKasLine, 0) * $bayar;

        if (($selisih + $angkaAkhir) >= 0) {
            return false;
        }

        if ($selisih >= 0) {
            $debet = $selisih;
            $kredit = 0;
        } else {
            $debet = 0;
            $kredit = $selisih;
        }

        $saldo = $this->saldoStore->where('jk', $kasHeader->jk)
                            ->where('nokas', $kasHeader->store)
                            ->first();

        $saldo->update([
            'saldoakhir' => round($saldo->saldoakhir) + round($selisih),
            'debet' => round($saldo->debet) + $debet,
            'kredit' => round($saldo->kredit) + $kredit
        ]);

        $kasHeader->update([
            'paid' => $cancelation ? 'N' : 'Y',
            'paidby' => $request->userid,
            'paiddate' => $request->tanggal_approval,
        ]);

        return true;
    }
}
