<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\ViewCashFlowMutasi;
use DB;
use Illuminate\Http\Request;
use PDF;

class CashFlowController extends Controller
{
    public function mutasi()
    {
        return view('modul-treasury.cash-flow.mutasi');
    }

    public function mutasiExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $data_list = ViewCashFlowMutasi::select(
            DB::raw('
                status,
                urutan,
                jenis,
                tahun,
                bulan,
                totpricerp
            ')
        )
        ->when(request('bulan'), function ($query) {
            return $query->where('bulan', request('bulan'));
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->orderBy('status', 'asc')
        ->orderBy(DB::raw('cast(urutan as integer)'), 'asc')
        ->get();

        // return default PDF
        $pdf = PDF::loadview('modul-treasury.cash-flow.mutasi-pdf', compact(
            'tahun',
            'bulan',
            'data_list'
        ))
        ->setPaper('a4', 'Portrait');

        return $pdf->inline('laporan_arus_kas_mutasi_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function perBulan()
    {
        $kurs = DB::table('kurs_rekap')->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->orderBy('created_at', 'DESC')->first()->kurs;

        return view('modul-treasury.cash-flow.perbulan', compact(
            'kurs',
        ));
    }

    public function perBulanExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $data_list = ViewCashFlowMutasi::select(
            DB::raw('
                status,
                urutan,
                jenis,
                tahun,
                bulan,
                totpricerp
            ')
        )
        ->when(request('bulan'), function ($query) use ($bulan) {
            return $query->where('bulan', $bulan);
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->orderBy('status', 'asc')
        ->orderBy(DB::raw('cast(urutan as integer)'), 'asc')
        ->get();

        $kurs = DB::table('kurs_rekap');

        $oldKurs = $kurs->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->orderBy('created_at', 'DESC')->first();

        if ($oldKurs->tahun == $tahun && $oldKurs->bulan == $bulan) {
            $kurs->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->orderBy('created_at', 'DESC')->update([
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
                'kurs' => sanitize_nominal($request->kurs),
                'created_at' => now(),
            ]);
        } else {
            $kurs->insert([
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
                'kurs' => sanitize_nominal($request->kurs),
                'created_at' => now(),
            ]);
        }


        // return default PDF
        $pdf = PDF::loadview('modul-treasury.cash-flow.perbulan-pdf', compact(
            'tahun',
            'bulan',
            'data_list'
        ))
        ->setPaper('a4', 'Portrait');

        return $pdf->inline('laporan_arus_kas_perbulan_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function perPeriode()
    {
        return view('modul-treasury.cash-flow.per-periode');
    }

    public function perPeriodeExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan_mulai = $request->bulan_mulai;
        $bulan_sampai = $request->bulan_sampai;

        $data_list = ViewCashFlowMutasi::select(
            DB::raw('
                status,
                urutan,
                jenis,
                tahun,
                bulan,
                totpricerp
            ')
        )
        ->whereBetween('bulan', [$bulan_mulai, $bulan_sampai])
        ->where('tahun', $tahun)
        ->orderBy('status', 'asc')
        ->orderBy(DB::raw('cast(urutan as integer)'), 'asc')
        ->get();

        // return default PDF
        $pdf = PDF::loadview('modul-treasury.cash-flow.per-periode-pdf', compact(
            'tahun',
            'bulan_mulai',
            'bulan_sampai',
            'data_list'
        ))
        ->setPaper('a4', 'Portrait');

        return $pdf->inline('laporan_arus_kas_per_periode_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function lengkap()
    {
        return view('modul-treasury.cash-flow.lengkap');
    }

    public function lengkapExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan_mulai = $request->bulan_mulai;
        $bulan_sampai = $request->bulan_sampai;

        $data_list = ViewCashFlowMutasi::select(
            DB::raw('
                status,
                urutan,
                jenis,
                tahun,
                bulan,
                totpricerp
            ')
        )
        ->when(request('bulan'), function ($query) use ($bulan_mulai, $bulan_sampai) {
            return $query->whereBetween('bulan', [$bulan_mulai, $bulan_sampai]);
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->orderBy('status', 'asc')
        ->orderBy(DB::raw('cast(urutan as integer)'), 'asc')
        ->get();

        // dd($data_list);


        // return default PDF
        $pdf = PDF::loadview('modul-treasury.cash-flow.lengkap-pdf', compact(
            'tahun',
            'bulan_mulai',
            'bulan_sampai',
            'data_list'
        ))
        ->setPaper('a4', 'Portrait');

        return $pdf->inline('laporan_arus_kas_lengkap_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function perMataUang()
    {
        return view('modul-treasury.cash-flow.per-mata-uang');
    }

    public function perMataUangExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $kurs  = $request->kurs;

        $data_list = ViewCashFlowMutasi::select(
            DB::raw('
                status,
                urutan,
                jenis,
                tahun,
                bulan,
                totpricerp
            ')
        )
        ->when(request('bulan'), function ($query) {
            return $query->where('bulan', request('bulan'));
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->orderBy('status', 'asc')
        ->orderBy(DB::raw('cast(urutan as integer)'), 'asc')
        ->get();

        // dd($data_list);

        // return default PDF
        $pdf = PDF::loadview('modul-treasury.cash-flow.per-mata-uang-pdf', compact(
            'tahun',
            'bulan',
            'data_list'
        ))
        ->setPaper('a4', 'Portrait');

        return $pdf->inline('laporan_arus_kas_per_mata_uang_'.date('Y-m-d H:i:s').'.pdf');
    }
}
