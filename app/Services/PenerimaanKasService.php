<?php

namespace App\Services;

use App\Http\Resources\PenerimaanKasResource;
use App\Models\Kasdoc;
use DB;
use Illuminate\Http\Request;

class PenerimaanKasService
{
    protected $kasHeader;
    protected $stringDate;
    protected $request;

    public function __construct(
        Kasdoc $kasHeader,
        Request $request,
    ) {
        $this->kasHeader = $kasHeader;
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
                return '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" value="' . $formattedKasData['no_dok'] . '" class="btn-radio" name="btn-radio"><span></span></label>';
            })
            ->addColumn('status', function ($formattedKasData) {
                return '<span class="badge badge-' . ($formattedKasData['status_verified'] == 'N' ? 'danger' : 'success') . '">' . ($formattedKasData['status_verified'] == 'N' ? 'Belum Diverivikasi' : 'Terverivikasi') . '</span>';
            })
            ->rawColumns(['radio', 'status'])
            ->make(true);
    }
}
