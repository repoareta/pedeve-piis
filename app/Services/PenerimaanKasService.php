<?php

namespace App\Services;

use App\Http\Resources\PenerimaanKasResource;
use App\Models\Kasdoc;
use App\Models\Kasline;
use App\Models\MtrDeposito;
use App\Models\SaldoStore;
use App\Models\StoreJK;
use DB;
use Illuminate\Http\Request;

class PenerimaanKasService
{
    protected $kasHeader;
    protected $kasLine;
    protected $stringDate;
    protected $saldoStore;
    protected $storeJK;
    protected $request;

    public function __construct(
        Kasdoc $kasHeader,
        Kasline $kasLine,
        Request $request,
        SaldoStore $saldoStore,
        StoreJK $storeJK
    ) {
        $this->kasHeader = $kasHeader;
        $this->kasLine = $kasLine;
        $this->saldoStore = $saldoStore;
        $this->storeJK = $storeJK;
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
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" value="' . $formattedKasData['no_dok'] . '" class="btn-radio" name="btn-radio">
                        <span></span>
                    </label>';
            })
            ->addColumn('status', function ($formattedKasData) {
                return '
                <span class="mt-1 badge badge-' . ($formattedKasData['status_verified'] == 'N' ? 'danger' : 'success') . '">' . ($formattedKasData['status_verified'] == 'N' ? 'Belum Diverifikasi' : 'Terverifikasi') . '</span>
                <span class="mt-1 badge badge-' . ($formattedKasData['status_paid'] == 'N' ? 'danger' : 'success') . '">' . ($formattedKasData['status_paid'] == 'N' ? 'Belum Terbayar' : 'Telah Terbayar') . '</span>
                ';
            })
            ->addColumn('action', function ($formattedKasData) {
                $onClickAction = 'onclick="redirectToApproval(`' . str_replace('/', '-', $formattedKasData['no_dok']) . '`, ' . ($formattedKasData['status_paid'] == 'Y' ? 'true' : 'false') . ')"';

                $titleButton = $formattedKasData['status_paid'] == 'Y' ? 'Batalkan Pembayaran' : 'Klik untuk melakukan Pembayaran';

                $actionButtonOpenTag = '<button class="btn btn-sm btn-clean btn-icon" title="' . $titleButton . '" ' . $onClickAction . '>';
                
                $actionButtonCloseTag = '</button>';

                $iconButton = '<i class="la la-' . ($formattedKasData['status_paid'] == 'Y' ? 'times' : 'check') . '"></i>';

                $detailButton = '<a href="' . route('penerimaan_kas.input-detail', str_replace('/', '-', $formattedKasData['no_dok'])) . '" class="btn btn-sm btn-clean btn-icon" title="Input detail Perbendaharaan"><i class="la la-list"></i></a>';

                $actionButton = $actionButtonOpenTag . $iconButton . $actionButtonCloseTag . ($formattedKasData['status_paid'] == 'Y' ? null : $detailButton);

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

    public function getTotalPrice($documentId)
    {
        return $this->kasLine
                    ->where('docno', str_replace('-', '/', $documentId))
                    ->where('keterangan', '<>', 'PENUTUP')
                    ->sum('totprice');
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

        $debet = 0;
        $kredit = 0;

        if ($selisih >= 0) {
            $debet = $selisih;
        } else {
            $kredit = $selisih;
        }

        $saldo = $this->saldoStore
            ->where('jk', $kasHeader->jk)
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

    public function createDocumentNumber($bagian, $tanggalBuku, $mpCode)
    {
        $number = $this->kasHeader
            ->where(DB::raw('substr(docno, 3, 5)'), $bagian)
            ->where('thnbln', $tanggalBuku)
            ->where(DB::raw('substr(docno, 1, 1)'), $mpCode)
            ->select([
                DB::raw('max(substr(docno, 13, 3)) as id')
            ])
            ->first()->id;

        return (!$number ? '000' : $number);
    }

    public function getLocations($jenisKartu, $currencyIndex)
    {
        return $this->storeJK
            ->where('jeniskartu', $jenisKartu)
            ->where('ci', $currencyIndex)
            ->select([
                DB::raw('kodestore as kode_store'),
                DB::raw('namabank as nama_bank'),
                DB::raw('norekening as nomor_rekening'),
                '*'
            ])
            ->orderBy('kodestore', 'asc')
            ->get();
    }

    public function getVerNumber($tanggalBuku)
    {
        $noVer = $this->kasHeader
            ->where(DB::raw('substr(docno, 1, 1)'), 'P')
            ->where(DB::raw('left(thnbln, 4)'), $tanggalBuku)
            ->select(DB::raw('max(left(mrs_no, 4)) as no_ver'))
            ->first()->no_ver;

        return (!$noVer ? '0001' : '2' . $noVer + 1);
    }

    public function getNomorBukti($tanggalBuku, $lokasi, $mpCode)
    {
        $bukti = $this->kasHeader
            ->where(DB::raw('substr(thnbln, 1, 4)'), $tanggalBuku)
            ->where('store', $lokasi)
            ->where(DB::raw('substr(docno, 1, 1)'), $mpCode)
            ->select(DB::raw('max(voucher) as no_bukti'))
            ->first()->no_bukti;

        return (!$bukti ? '0001' : '2' . $bukti + 1);
    }

    public function getKasLineByNumber($documentId, $lineNumber)
    {
        return $this->kasLine
            ->where('docno', '=', str_replace('-', '/', $documentId))
            ->where('lineno', '=', $lineNumber)
            ->first();
    }

    public function getKasLine($documentId)
    {
        return $this->kasLine
            ->where('docno', str_replace('-', '/', $documentId))
            ->where('keterangan', '<>', 'PENUTUP')
            ->orderBy('lineno')
            ->get();
    }

    public function kasLineLastNumber($documentId)
    {
        $lineNumber = $this->kasLine->where('docno', str_replace('-', '/', $documentId))->max('lineno');

        return $lineNumber == null ? 1 : $lineNumber + 1;
    }

    public function getAccounts(?string $searchQuery)
    {
        $searchQuery = strtoupper($searchQuery);

        if (!$searchQuery) {
            return (object) [
                [
                    'kodeacct' => 'Ketik minimal 3 karakter.'
                ],
            ];
        }

        $account = DB::table('account')
            ->where(DB::raw('length(kodeacct)'), '=', 6)
            ->where('kodeacct', 'NOT ILIKE', '%x%')
            ->where('kodeacct', 'ILIKE', $searchQuery . '%')
            ->orWhere('descacct', 'ILIKE', $searchQuery . '%')
            ->orderBy('kodeacct', 'desc')
            ->select([
                'kodeacct',
                'descacct',
            ])
            ->get();

        return $account;
    }

    public function getKepada(?string $searchQuery)
    {
        if (!$searchQuery) {
            return (object) [
                [
                    'kepada' => 'Ketik minimal 3 karakter.'
                ],
            ];
        }

        $kepada = $this->kasHeader
            ->where('kepada', 'ILIKE', '%' . $searchQuery . '%')
            ->select(DB::raw('distinct kepada'))
            ->orderBy('kepada', 'asc')
            ->get();

        return $kepada;
    }

    public function getJenisBiaya(?string $searchQuery)
    {
        $jenisBiaya = DB::table('jenisbiaya')
            ->where('kode', 'ILIKE', $searchQuery . '%')
            ->orWhere('keterangan', 'ILIKE', $searchQuery . '%')
            ->orderBy('kode')
            ->select([
                'kode',
                'keterangan'
            ])
            ->get();

        return $jenisBiaya;
    }

    public function getCashJudex(?string $searchQuery)
    {
        $cashJudex = DB::table('cashjudex')
            ->where('kode', 'ILIKE', $searchQuery . '%')
            ->orWhere('nama', 'ILIKE', $searchQuery . '%')
            ->orderBy('kode')
            ->select([
                'kode',
                'nama'
            ])
            ->get();

        return $cashJudex;
    }

    public function getBagian(?string $searchQuery)
    {
        $bagian = DB::table('sdm_tbl_kdbag')
            ->where('kode', 'ILIKE', $searchQuery . '%')
            ->orWhere('nama', 'ILIKE', $searchQuery . '%')
            ->select([
                'kode',
                'nama'
            ])
            ->orderBy('kode')
            ->get();

        return $bagian;
    }

    public function storeKasLine(array $attributes)
    {
        $current = $this->kasLine
            ->where('docno', '=', $attributes['nodok'])
            ->where('lineno', '=', $attributes['nourut'])
            ->first();

        if ($current) {
            $this->kasLine
                ->where('docno', '=', $attributes['nodok'])
                ->where('lineno', '=', $attributes['nourut'])
                ->update([
                    'account' =>  $attributes['sanper'],
                    'area' =>  '0',
                    'lokasi'  =>  $attributes['lapangan'] ?? null,
                    'bagian' =>  $attributes['bagian'],
                    'pk' =>  $attributes['pk'],
                    'jb' =>  $attributes['jb'],
                    'cj' =>  $attributes['cj'],
                    'totprice'  =>  str_replace(',', '.', $attributes['nilai']),
                    'keterangan'  =>  $attributes['rincian'],
                ]);

            return $this->resultJson(2, 'success', 'Detail berhasil diupdate.');
        }
        
        if ($attributes['cj'] == '50' && $attributes['mp']) {
            MtrDeposito::insert([
                'docno' =>  $attributes['nodok'],
                'lineno' =>  $attributes['nourut'],
                'kdbank' =>  $attributes['sanper'],
                'nominal' =>  str_replace(',', '.', $attributes['nilai']),
                'asal' =>  $attributes['lapangan'] ?? null,
                'keterangan' =>  $attributes['rincian'],
                'proses' =>  'N',
            ]);
        }

        $this->kasLine->insert([
            'docno' =>  $attributes['nodok'],
            'lineno' =>  $attributes['nourut'],
            'account' =>  $attributes['sanper'],
            'area' =>  '0',
            'lokasi'  =>  $attributes['lapangan'] ?? null,
            'bagian' =>  $attributes['bagian'],
            'pk' =>  $attributes['pk'],
            'jb' =>  $attributes['jb'],
            'cj' =>  $attributes['cj'],
            'totprice'  =>  str_replace(',', '.', $attributes['nilai']),
            'keterangan'  =>  $attributes['rincian'],
        ]);

        return $this->resultJson(1, 'success', 'Detail berhasil ditambahkan.');
    }

    public function storeKas(array $attributes, $statusTimeTrans)
    {
        $attributes = $this->objectMappingKasDoc($attributes);

        if ($statusTimeTrans !== 'gtopening') {    
            return $this->resultJson(
                2, 
                'info', 
                'Bulan buku tidak ada, atau sudah diposting.'
            );
        }

        $checkHeaderDocs = $this->kasHeader
            ->where('docno', $attributes['docno'])
            ->first();

        if (!empty($checkHeaderDocs)) {
            return $this->resultJson(0, 'error', 'Data yang anda input sudah ada.');
        }

        $this->kasHeader
            ->insert($attributes);

        return $this->resultJson(1, 'success', 'Data berhasil ditambahkan. Silahkan isi detail pada form dibawah.');
    }

    private function resultJson($status, $type, $message)
    {
        return [
            'status' => $status,
            'type' => $type,
            'message' => $message,
            'text' => ($status == 1 ? 'Berhasil' : 'Gagal'),
        ];
    }

    private function objectMappingKasDoc(array $attributes)
    {
        $attributes = [
            'docno' => $attributes['mp'] . '/' . $attributes['bagian'] . '/' . $attributes['nomor'],
            'thnbln' => $attributes['tanggal_buku'],
            'jk' => $attributes['jenis_kartu'],
            'ci' => $attributes['currency_index'],
            'store' => $attributes['lokasi'],
            'voucher' => $attributes['no_bukti'],
            'kepada' => strtoupper($attributes['kepada']),
            'debet' => 0,
            'kredit' => 0,
            'original' => 'Y',
            'originaldate' => $attributes['tanggal'],
            'verified' => 'N',
            'paid' => 'N',
            'inputdate' => $attributes['tanggal'],
            'inputpwd' => $attributes['user_id'],
            'updatedate' => $attributes['tanggal'],
            'updatepwd' => $attributes['user_id'],
            'rate' => $attributes['kurs'],
            'nilai_dok' => str_replace(',', '.', $attributes['nilai']),
            'originalby' => $attributes['user_id'],
            'ket1' => $attributes['keterangan-1'],
            'ket2' => $attributes['keterangan-2'],
            'ket3' => $attributes['keterangan-3'],
            'mrs_no' => $attributes['no_ver'],
        ];

        return $attributes;
    }
}
