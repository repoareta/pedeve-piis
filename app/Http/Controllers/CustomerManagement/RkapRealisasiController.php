<?php

namespace App\Http\Controllers\CustomerManagement;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\PerusahaanAfiliasi;
use App\Models\RencanaKerja;
use DB;
use Illuminate\Http\Request;
use PDF;

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

        $perusahaanList = PerusahaanAfiliasi::all();

        return view('modul-customer-management.rkap-realisasi.index', compact('rkapRealisasiTahunList', 'perusahaanList'));
    }

    public function indexJson(Request $request)
    {
        if ($request->perusahaan) {
            $perusahaan = "b.id = '$request->perusahaan'";
        } else {
            $perusahaan = "b.id IS NOT NULL";
        }

        $data = DB::select("
            SELECT 
                a.*, 
                b.nama,
                b.id
            FROM tbl_rencana_kerja a 
            JOIN cm_perusahaan_afiliasi b 
            ON a.kd_perusahaan = b.id 
            WHERE 
                a.tahun = '$request->tahun'
            AND
                $perusahaan
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
            return currency_format($data->tkp_r);
        })
        ->addColumn('kpi', function ($data) {
            return currency_format($data->kpi_r);
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

    /**
     * Undocumented function
     *
     * @return void
     */
    public function export(Request $request)
    {
        if ($request->tahun) {
            $tahun = "tahun = '$request->tahun'";
            $tahun_pdf = $request->tahun;
        } else {
            $tahun = "tahun IS NOT NULL";
            $tahun_pdf = "Semua Tahun";
        }

        if ($request->perusahaan) {
            $perusahaan = "kd_perusahaan = '$request->perusahaan'";
            $perusahaan_trk = "trk.kd_perusahaan = '$request->perusahaan'";
            $perusahaan_pdf = $request->perusahaan_nama;
        } else {
            $perusahaan = "kd_perusahaan IS NOT NULL";
            $perusahaan_trk = "trk.kd_perusahaan IS NOT NULL";
            $perusahaan_pdf = "Semua Perusahaan";
        }
        
        
        $rkapRealisasiList = DB::select("
        SELECT 

            case
                when trk.ci_r = 1 then 'IDR'
            else 
                'USD'
            end AS ci_r,

            trk.kd_perusahaan,
            trk.tahun,

            cm_pa.nama,

            COALESCE(trk.aset_r, 0) AS aset_r,
            COALESCE(trk_jan.aset_r, 0) AS trk_jan_aset_r,
            COALESCE(trk_feb.aset_r, 0) AS trk_feb_aset_r,
            COALESCE(trk_mar.aset_r, 0) AS trk_mar_aset_r,
            COALESCE(trk_apr.aset_r, 0) AS trk_apr_aset_r,
            COALESCE(trk_mei.aset_r, 0) AS trk_mei_aset_r,
            COALESCE(trk_jun.aset_r, 0) AS trk_jun_aset_r,
            COALESCE(trk_jul.aset_r, 0) AS trk_jul_aset_r,
            COALESCE(trk_agu.aset_r, 0) AS trk_agu_aset_r,
            COALESCE(trk_sep.aset_r, 0) AS trk_sep_aset_r,
            COALESCE(trk_okt.aset_r, 0) AS trk_okt_aset_r,
            COALESCE(trk_nov.aset_r, 0) AS trk_nov_aset_r,
            COALESCE(trk_des.aset_r, 0) AS trk_des_aset_r,

            COALESCE(trk.revenue_r, 0) AS revenue_r,
            COALESCE(trk_jan.revenue_r, 0) AS trk_jan_revenue_r,
            COALESCE(trk_feb.revenue_r, 0) AS trk_feb_revenue_r,
            COALESCE(trk_mar.revenue_r, 0) AS trk_mar_revenue_r,
            COALESCE(trk_apr.revenue_r, 0) AS trk_apr_revenue_r,
            COALESCE(trk_mei.revenue_r, 0) AS trk_mei_revenue_r,
            COALESCE(trk_jun.revenue_r, 0) AS trk_jun_revenue_r,
            COALESCE(trk_jul.revenue_r, 0) AS trk_jul_revenue_r,
            COALESCE(trk_agu.revenue_r, 0) AS trk_agu_revenue_r,
            COALESCE(trk_sep.revenue_r, 0) AS trk_sep_revenue_r,
            COALESCE(trk_okt.revenue_r, 0) AS trk_okt_revenue_r,
            COALESCE(trk_nov.revenue_r, 0) AS trk_nov_revenue_r,
            COALESCE(trk_des.revenue_r, 0) AS trk_des_revenue_r,

            COALESCE(trk.beban_pokok_r, 0) AS beban_pokok_r,
            COALESCE(trk_jan.beban_pokok_r, 0) AS trk_jan_beban_pokok_r,
            COALESCE(trk_feb.beban_pokok_r, 0) AS trk_feb_beban_pokok_r,
            COALESCE(trk_mar.beban_pokok_r, 0) AS trk_mar_beban_pokok_r,
            COALESCE(trk_apr.beban_pokok_r, 0) AS trk_apr_beban_pokok_r,
            COALESCE(trk_mei.beban_pokok_r, 0) AS trk_mei_beban_pokok_r,
            COALESCE(trk_jun.beban_pokok_r, 0) AS trk_jun_beban_pokok_r,
            COALESCE(trk_jul.beban_pokok_r, 0) AS trk_jul_beban_pokok_r,
            COALESCE(trk_agu.beban_pokok_r, 0) AS trk_agu_beban_pokok_r,
            COALESCE(trk_sep.beban_pokok_r, 0) AS trk_sep_beban_pokok_r,
            COALESCE(trk_okt.beban_pokok_r, 0) AS trk_okt_beban_pokok_r,
            COALESCE(trk_nov.beban_pokok_r, 0) AS trk_nov_beban_pokok_r,
            COALESCE(trk_des.beban_pokok_r, 0) AS trk_des_beban_pokok_r,

            COALESCE(trk.beban_pokok_r + trk.revenue_r, 0) AS laba_kotor_r,
            COALESCE(trk_jan.beban_pokok_r + trk_jan.revenue_r, 0) AS trk_jan_laba_kotor_r,
            COALESCE(trk_feb.beban_pokok_r + trk_feb.revenue_r, 0) AS trk_feb_laba_kotor_r,
            COALESCE(trk_mar.beban_pokok_r + trk_mar.revenue_r, 0) AS trk_mar_laba_kotor_r,
            COALESCE(trk_apr.beban_pokok_r + trk_apr.revenue_r, 0) AS trk_apr_laba_kotor_r,
            COALESCE(trk_mei.beban_pokok_r + trk_mei.revenue_r, 0) AS trk_mei_laba_kotor_r,
            COALESCE(trk_jun.beban_pokok_r + trk_jun.revenue_r, 0) AS trk_jun_laba_kotor_r,
            COALESCE(trk_jul.beban_pokok_r + trk_jul.revenue_r, 0) AS trk_jul_laba_kotor_r,
            COALESCE(trk_agu.beban_pokok_r + trk_agu.revenue_r, 0) AS trk_agu_laba_kotor_r,
            COALESCE(trk_sep.beban_pokok_r + trk_sep.revenue_r, 0) AS trk_sep_laba_kotor_r,
            COALESCE(trk_okt.beban_pokok_r + trk_okt.revenue_r, 0) AS trk_okt_laba_kotor_r,
            COALESCE(trk_nov.beban_pokok_r + trk_nov.revenue_r, 0) AS trk_nov_laba_kotor_r,
            COALESCE(trk_des.beban_pokok_r + trk_des.revenue_r, 0) AS trk_des_laba_kotor_r,

            COALESCE(trk.biaya_operasi_r) AS biaya_operasi_r,
            COALESCE(trk_jan.biaya_operasi_r, 0) AS trk_jan_biaya_operasi_r,
            COALESCE(trk_feb.biaya_operasi_r, 0) AS trk_feb_biaya_operasi_r,
            COALESCE(trk_mar.biaya_operasi_r, 0) AS trk_mar_biaya_operasi_r,
            COALESCE(trk_apr.biaya_operasi_r, 0) AS trk_apr_biaya_operasi_r,
            COALESCE(trk_mei.biaya_operasi_r, 0) AS trk_mei_biaya_operasi_r,
            COALESCE(trk_jun.biaya_operasi_r, 0) AS trk_jun_biaya_operasi_r,
            COALESCE(trk_jul.biaya_operasi_r, 0) AS trk_jul_biaya_operasi_r,
            COALESCE(trk_agu.biaya_operasi_r, 0) AS trk_agu_biaya_operasi_r,
            COALESCE(trk_sep.biaya_operasi_r, 0) AS trk_sep_biaya_operasi_r,
            COALESCE(trk_okt.biaya_operasi_r, 0) AS trk_okt_biaya_operasi_r,
            COALESCE(trk_nov.biaya_operasi_r, 0) AS trk_nov_biaya_operasi_r,
            COALESCE(trk_des.biaya_operasi_r, 0) AS trk_des_biaya_operasi_r,

            COALESCE(trk.biaya_operasi_r + (trk.beban_pokok_r + trk.revenue_r)) AS laba_operasi_r,
            COALESCE(trk_jan.biaya_operasi_r + (trk_jan.beban_pokok_r + trk_jan.revenue_r), 0) AS trk_jan_laba_operasi_r,
            COALESCE(trk_feb.biaya_operasi_r + (trk_feb.beban_pokok_r + trk_feb.revenue_r), 0) AS trk_feb_laba_operasi_r,
            COALESCE(trk_mar.biaya_operasi_r + (trk_mar.beban_pokok_r + trk_mar.revenue_r), 0) AS trk_mar_laba_operasi_r,
            COALESCE(trk_apr.biaya_operasi_r + (trk_apr.beban_pokok_r + trk_apr.revenue_r), 0) AS trk_apr_laba_operasi_r,
            COALESCE(trk_mei.biaya_operasi_r + (trk_mei.beban_pokok_r + trk_mei.revenue_r), 0) AS trk_mei_laba_operasi_r,
            COALESCE(trk_jun.biaya_operasi_r + (trk_jun.beban_pokok_r + trk_jun.revenue_r), 0) AS trk_jun_laba_operasi_r,
            COALESCE(trk_jul.biaya_operasi_r + (trk_jul.beban_pokok_r + trk_jul.revenue_r), 0) AS trk_jul_laba_operasi_r,
            COALESCE(trk_agu.biaya_operasi_r + (trk_agu.beban_pokok_r + trk_agu.revenue_r), 0) AS trk_agu_laba_operasi_r,
            COALESCE(trk_sep.biaya_operasi_r + (trk_sep.beban_pokok_r + trk_sep.revenue_r), 0) AS trk_sep_laba_operasi_r,
            COALESCE(trk_okt.biaya_operasi_r + (trk_okt.beban_pokok_r + trk_okt.revenue_r), 0) AS trk_okt_laba_operasi_r,
            COALESCE(trk_nov.biaya_operasi_r + (trk_nov.beban_pokok_r + trk_nov.revenue_r), 0) AS trk_nov_laba_operasi_r,
            COALESCE(trk_des.biaya_operasi_r + (trk_des.beban_pokok_r + trk_des.revenue_r), 0) AS trk_des_laba_operasi_r,

            COALESCE(trk.laba_bersih_r, 0) AS laba_bersih_r,
            COALESCE(trk_jan.laba_bersih_r, 0) AS trk_jan_laba_bersih_r,
            COALESCE(trk_feb.laba_bersih_r, 0) AS trk_feb_laba_bersih_r,
            COALESCE(trk_mar.laba_bersih_r, 0) AS trk_mar_laba_bersih_r,
            COALESCE(trk_apr.laba_bersih_r, 0) AS trk_apr_laba_bersih_r,
            COALESCE(trk_mei.laba_bersih_r, 0) AS trk_mei_laba_bersih_r,
            COALESCE(trk_jun.laba_bersih_r, 0) AS trk_jun_laba_bersih_r,
            COALESCE(trk_jul.laba_bersih_r, 0) AS trk_jul_laba_bersih_r,
            COALESCE(trk_agu.laba_bersih_r, 0) AS trk_agu_laba_bersih_r,
            COALESCE(trk_sep.laba_bersih_r, 0) AS trk_sep_laba_bersih_r,
            COALESCE(trk_okt.laba_bersih_r, 0) AS trk_okt_laba_bersih_r,
            COALESCE(trk_nov.laba_bersih_r, 0) AS trk_nov_laba_bersih_r,
            COALESCE(trk_des.laba_bersih_r, 0) AS trk_des_laba_bersih_r,

            COALESCE(trk.tkp_r) AS tkp_r,
            COALESCE(trk_jan.tkp_r, 0) AS trk_jan_tkp_r,
            COALESCE(trk_feb.tkp_r, 0) AS trk_feb_tkp_r,
            COALESCE(trk_mar.tkp_r, 0) AS trk_mar_tkp_r,
            COALESCE(trk_apr.tkp_r, 0) AS trk_apr_tkp_r,
            COALESCE(trk_mei.tkp_r, 0) AS trk_mei_tkp_r,
            COALESCE(trk_jun.tkp_r, 0) AS trk_jun_tkp_r,
            COALESCE(trk_jul.tkp_r, 0) AS trk_jul_tkp_r,
            COALESCE(trk_agu.tkp_r, 0) AS trk_agu_tkp_r,
            COALESCE(trk_sep.tkp_r, 0) AS trk_sep_tkp_r,
            COALESCE(trk_okt.tkp_r, 0) AS trk_okt_tkp_r,
            COALESCE(trk_nov.tkp_r, 0) AS trk_nov_tkp_r,
            COALESCE(trk_des.tkp_r, 0) AS trk_des_tkp_r,

            COALESCE(trk.kpi_r) AS kpi_r,
            COALESCE(trk_jan.kpi_r, 0) AS trk_jan_kpi_r,
            COALESCE(trk_feb.kpi_r, 0) AS trk_feb_kpi_r,
            COALESCE(trk_mar.kpi_r, 0) AS trk_mar_kpi_r,
            COALESCE(trk_apr.kpi_r, 0) AS trk_apr_kpi_r,
            COALESCE(trk_mei.kpi_r, 0) AS trk_mei_kpi_r,
            COALESCE(trk_jun.kpi_r, 0) AS trk_jun_kpi_r,
            COALESCE(trk_jul.kpi_r, 0) AS trk_jul_kpi_r,
            COALESCE(trk_agu.kpi_r, 0) AS trk_agu_kpi_r,
            COALESCE(trk_sep.kpi_r, 0) AS trk_sep_kpi_r,
            COALESCE(trk_okt.kpi_r, 0) AS trk_okt_kpi_r,
            COALESCE(trk_nov.kpi_r, 0) AS trk_nov_kpi_r,
            COALESCE(trk_des.kpi_r, 0) AS trk_des_kpi_r

        FROM tbl_rencana_kerja trk

        JOIN cm_perusahaan_afiliasi cm_pa
        ON trk.kd_perusahaan = cm_pa.id

        -- trk jan START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '01'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_jan
        ON trk_jan.kd_perusahaan = trk.kd_perusahaan
        -- trk jan END 


        -- trk feb START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '02'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_feb
        ON trk_feb.kd_perusahaan = trk.kd_perusahaan
        -- trk feb END 

        -- trk mar START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '03'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_mar
        ON trk_mar.kd_perusahaan = trk.kd_perusahaan
        -- trk mar END 

        -- trk apr START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '04'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_apr
        ON trk_apr.kd_perusahaan = trk.kd_perusahaan
        -- trk apr END 

        -- trk mei START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '05'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_mei
        ON trk_mei.kd_perusahaan = trk.kd_perusahaan
        -- trk mei END

        -- trk jun START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '06'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_jun
        ON trk_jun.kd_perusahaan = trk.kd_perusahaan
        -- trk jun END 

        -- trk jul START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '07'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_jul
        ON trk_jul.kd_perusahaan = trk.kd_perusahaan
        -- trk jul END

        -- trk agu START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '08'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_agu
        ON trk_agu.kd_perusahaan = trk.kd_perusahaan
        -- trk agu END

        -- trk sep START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '09'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_sep
        ON trk_sep.kd_perusahaan = trk.kd_perusahaan
        -- trk sep END

        -- trk okt START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '10'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_okt
        ON trk_okt.kd_perusahaan = trk.kd_perusahaan
        -- trk okt END 

        -- trk nov START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '11'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_nov
        ON trk_nov.kd_perusahaan = trk.kd_perusahaan
        -- trk nov END 

        -- trk des START
        LEFT JOIN (
        SELECT 
            kd_perusahaan, 
            SUM(aset_r) AS aset_r,
            SUM(revenue_r) AS revenue_r,
            SUM(beban_pokok_r) AS beban_pokok_r,
            SUM(biaya_operasi_r) AS biaya_operasi_r,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(tkp_r) AS tkp_r,
            SUM(kpi_r) AS kpi_r
        FROM tbl_rencana_kerja
        WHERE 
            bulan = '12'
        AND $tahun
        AND $perusahaan
        GROUP BY kd_perusahaan
        ) AS trk_des
        ON trk_des.kd_perusahaan = trk.kd_perusahaan
        -- trk des END 

        WHERE $tahun
        AND $perusahaan_trk
        AND bulan IS NULL");

        // return default PDF
        $headerHtml = view()->make(
            'modul-customer-management.rkap-realisasi.report-export-pdf-header',
            compact('tahun_pdf', 'perusahaan_pdf')
        )->render();

        $pdf = PDF::loadView(
            'modul-customer-management.rkap-realisasi.report-export-pdf',
            compact('rkapRealisasiList', 'tahun_pdf')
        )
        ->setPaper('a4', 'landscape')
        ->setOption('margin-top', '10mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('header-html', $headerHtml)
        ->setOption('footer-right', 'Halaman [page] dari [topage]')
        ->setOption('footer-font-name', 'sans-serif')
        ->setOption('footer-font-size', 8);

        return $pdf->download('report_rkap_realisasi_'.date('Y-m-d H:i:s').'.pdf');
    }
}
