<?php

namespace App\Http\Controllers\CustomerManagement;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\PerusahaanAfiliasi;
use App\Models\RencanaKerja;
use DB;
use Illuminate\Http\Request;

class RkapRealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rkapRealisasiTahunList = DB::table('tbl_rencana_kerja')
        ->distinct('tahun')
        ->orderBy('tahun', 'DESC')
        ->get();
        return view('modul-customer-management.rkap-realisasi.index', compact('rkapRealisasiTahunList'));
    }

    public function indexJson(Request $request)
    {
        $data = DB::select("
            SELECT 
                a.*, 
                b.nama 
            FROM tbl_rencana_kerja a 
            JOIN cm_perusahaan_afiliasi b 
            ON a.kd_perusahaan = b.id 
            WHERE 
                a.tahun = '$request->tahun'
            ORDER BY a.tahun, a.kd_perusahaan DESC, a.bulan NULLS FIRST");
        
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
            $radio = '<label  class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-id="'.$data->kd_rencana_kerja.'" value="'.$data->kd_rencana_kerja.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->addColumn('ci', function ($data) {
            if ($data->ci_r == 1) {
                return "IDR";
            } elseif ($data->ci_r == 2) {
                return "USD";
            }
        })
        ->addColumn('bulan', function ($data) {
            return bulan($data->bulan);
        })
        ->addColumn('aset', function ($data) {
            return currency_format($data->aset_r);
        })
        ->addColumn('revenue', function ($data) {
            return currency_format($data->revenue_r);
        })
        ->addColumn('beban_pokok', function ($data) {
            return currency_format($data->beban_pokok_r);
        })
        ->addColumn('laba_kotor', function ($data) {
            return currency_format($data->beban_pokok_r + $data->revenue_r);
        })
        ->addColumn('biaya_operasi', function ($data) {
            return currency_format($data->biaya_operasi_r);
        })
        ->addColumn('laba_operasi', function ($data) {
            return currency_format($data->biaya_operasi_r + ($data->beban_pokok_r + $data->revenue_r));
        })
        ->addColumn('laba_bersih', function ($data) {
            return currency_format($data->laba_bersih_r);
        })
        ->addColumn('tkp', function ($data) {
            return round($data->tkp_r);
        })
        ->addColumn('kpi', function ($data) {
            return round($data->kpi_r);
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $perusahaanList = PerusahaanAfiliasi::all();
        return view('modul-customer-management.rkap-realisasi.create', compact('perusahaanList'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request, RencanaKerja $rencanaKerja)
    {
        $rencanaKerja->kd_perusahaan = $request->nama;
        $rencanaKerja->ci_r = $request->ci;
        $rencanaKerja->tahun = $request->tahun;
        $rencanaKerja->bulan = $request->bulan;
        $rencanaKerja->rate_r = $request->kurs;
        $rencanaKerja->aset_r = str_replace(',', '', $request->aset);
        $rencanaKerja->revenue_r = str_replace(',', '', $request->revenue);
        $rencanaKerja->beban_pokok_r = str_replace(',', '', $request->beban_pokok);
        $rencanaKerja->biaya_operasi_r = str_replace(',', '', $request->biaya_operasi);
        $rencanaKerja->laba_bersih_r = str_replace(',', '', $request->laba_bersih);
        $rencanaKerja->tkp_r = str_replace(',', '', $request->tkp);
        $rencanaKerja->kpi_r = str_replace(',', '', $request->kpi);

        $rencanaKerja->save();

        Alert::success('Tambah Rkap & Realisasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.rkap_realisasi.index');
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $rkapRealisasi = RencanaKerja::find($id);
        $perusahaanList = PerusahaanAfiliasi::all();

        return view('modul-customer-management.rkap-realisasi.edit', compact('rkapRealisasi', 'perusahaanList'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request, $id)
    {
        $rencanaKerja = RencanaKerja::find($id);
        $rencanaKerja->kd_perusahaan = $request->nama;
        $rencanaKerja->ci_r = $request->ci;
        $rencanaKerja->tahun = $request->tahun;
        $rencanaKerja->bulan = $request->bulan;
        $rencanaKerja->rate_r = $request->kurs;
        $rencanaKerja->aset_r = str_replace(',', '', $request->aset);
        $rencanaKerja->revenue_r = str_replace(',', '', $request->revenue);
        $rencanaKerja->beban_pokok_r = str_replace(',', '', $request->beban_pokok);
        $rencanaKerja->biaya_operasi_r = str_replace(',', '', $request->biaya_operasi);
        $rencanaKerja->laba_bersih_r = str_replace(',', '', $request->laba_bersih);
        $rencanaKerja->tkp_r = str_replace(',', '', $request->tkp);
        $rencanaKerja->kpi_r = str_replace(',', '', $request->kpi);

        $rencanaKerja->save();

        Alert::success('Ubah Rkap & Realisasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.rkap_realisasi.index');
    }

    public function delete(Request $request)
    {
        DB::table('tbl_rencana_kerja')->where('kd_rencana_kerja', $request->id)->delete();
        return response()->json();
    }
}
