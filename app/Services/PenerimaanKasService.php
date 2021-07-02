<?php

namespace App\Services;

use App\Models\Kasdoc;
use Illuminate\Http\Request;

class PenerimaanKasService
{
    protected $kasHeader;

    public function __construct(
        Kasdoc $kasHeader,
    ) {
        $this->kasHeader = $kasHeader;
    }

    public function datatables(Request $request, string $stringDate)
    {
        // ->where('thnbln', '202105')->where('kd_kepada', null)

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $bukti = $request->bukti;

        $dataKasHeader = $this->kasHeader
            ->with('storejk')
            ->where('kasdoc.kd_kepada', '=', null);

        if (is_null($bulan) && is_null($tahun) && is_null($bukti)) {
            $dataKasHeader = $dataKasHeader->where('thnbln', $stringDate);
        }

        // if ($tahun !== null) {
        //     $dataKasHeader = $dataKasHeader->where('tahun', $tahun);
        // }

        return $dataKasHeader
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
    }
}
