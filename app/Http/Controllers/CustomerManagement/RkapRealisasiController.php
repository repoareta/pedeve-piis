<?php

namespace App\Http\Controllers\CustomerManagement;

use Alert;
use App\Exports\RekapRKAPRealisasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\RKAPStoreRequest;
use App\Http\Requests\RKAPUpdateRequest;
use App\Models\PerusahaanAfiliasi;
use App\Models\RencanaKerja;
use DB;
use DomPDF;
use Excel;
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

        $rkapRealisasiPerusahaanList = RencanaKerja::pluck('kd_perusahaan')
        ->toArray();

        $perusahaanList = PerusahaanAfiliasi::whereIn('id', $rkapRealisasiPerusahaanList)
        ->get();

        return view('modul-customer-management.rkap-realisasi.index', compact('rkapRealisasiTahunList', 'perusahaanList'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
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
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-id="'.$data->kd_rencana_kerja.'" value="'.$data->kd_rencana_kerja.'" name="btn-radio"><span></span></label>';
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
        ->addColumn('pendapatan_usaha', function ($data) {
            return currency_format($data->pendapatan_usaha);
        })
        ->addColumn('beban_usaha', function ($data) {
            return currency_format($data->beban_usaha);
        })
        ->addColumn('laba_kotor', function ($data) {
            return currency_format($data->beban_usaha + $data->pendapatan_usaha);
        })
        ->addColumn('pendapatan_or_beban_lain', function ($data) {
            return currency_format($data->pendapatan_or_beban_lain);
        })
        ->addColumn('laba_operasi', function ($data) {
            return currency_format($data->pendapatan_or_beban_lain + ($data->beban_usaha + $data->pendapatan_usaha));
        })
        ->addColumn('laba_bersih', function ($data) {
            return currency_format($data->laba_bersih_r);
        })
        ->addColumn('ebitda', function ($data) {
            return currency_format($data->ebitda);
        })
        ->addColumn('investasi_bd', function ($data) {
            return currency_format($data->investasi_bd);
        })
        ->addColumn('investasi_nbd', function ($data) {
            return currency_format($data->investasi_nbd);
        })
        ->addColumn('tkp', function ($data) {
            return currency_format($data->tkp_r);
        })
        ->addColumn('kpi', function ($data) {
            return currency_format($data->kpi_r);
        })
        ->rawColumns(['radio'])
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
    public function store(RKAPStoreRequest $request, RencanaKerja $rencanaKerja)
    {
        if ($request->kategori == 'rkap') {
            $bulan = null;
        } else if($request->kategori == 'realisasi') {
            $bulan = $request->bulan;
        }
        
        $rencanaKerja->kd_perusahaan = $request->nama;
        $rencanaKerja->ci_r = $request->ci;
        $rencanaKerja->tahun = $request->tahun;
        $rencanaKerja->bulan = $bulan;
        $rencanaKerja->rate_r = sanitize_nominal($request->kurs);
        $rencanaKerja->aset_r = sanitize_nominal($request->aset);
        $rencanaKerja->pendapatan_usaha = sanitize_nominal($request->pendapatan_usaha);
        $rencanaKerja->beban_usaha = sanitize_nominal($request->beban_usaha);
        $rencanaKerja->pendapatan_or_beban_lain = sanitize_nominal($request->pendapatan_beban_lain);
        $rencanaKerja->laba_bersih_r = sanitize_nominal($request->laba_bersih);
        $rencanaKerja->ebitda = sanitize_nominal($request->ebitda);
        $rencanaKerja->investasi_bd = sanitize_nominal($request->investasi_bd);
        $rencanaKerja->investasi_nbd = sanitize_nominal($request->investasi_nbd);
        $rencanaKerja->tkp_r = sanitize_nominal($request->tkp);
        $rencanaKerja->kpi_r = sanitize_nominal($request->kpi);

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
    public function edit(RencanaKerja $kd_rencana_kerja)
    {
        $rkapRealisasi = $kd_rencana_kerja;
        $perusahaanList = PerusahaanAfiliasi::all();

        return view('modul-customer-management.rkap-realisasi.edit', compact('rkapRealisasi', 'perusahaanList'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(RKAPUpdateRequest $request, $id)
    {
        $rencanaKerja = RencanaKerja::find($id);
        $rencanaKerja->kd_perusahaan = $request->nama;
        $rencanaKerja->ci_r = $request->ci;
        $rencanaKerja->tahun = $request->tahun;
        $rencanaKerja->bulan = $request->bulan;
        $rencanaKerja->rate_r = sanitize_nominal($request->kurs);
        $rencanaKerja->aset_r = sanitize_nominal($request->aset);
        $rencanaKerja->pendapatan_usaha = sanitize_nominal($request->pendapatan_usaha);
        $rencanaKerja->beban_usaha = sanitize_nominal($request->beban_usaha);
        $rencanaKerja->pendapatan_or_beban_lain = sanitize_nominal($request->pendapatan_beban_lain);
        $rencanaKerja->laba_bersih_r = sanitize_nominal($request->laba_bersih);
        $rencanaKerja->ebitda = sanitize_nominal($request->ebitda);
        $rencanaKerja->investasi_bd = sanitize_nominal($request->investasi_bd);
        $rencanaKerja->investasi_nbd = sanitize_nominal($request->investasi_nbd);
        $rencanaKerja->tkp_r = sanitize_nominal($request->tkp);
        $rencanaKerja->kpi_r = sanitize_nominal($request->kpi);

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
     * @param Request $request
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

            COALESCE(trk.pendapatan_usaha, 0) AS pendapatan_usaha,
            COALESCE(trk_jan.pendapatan_usaha, 0) AS trk_jan_pendapatan_usaha,
            COALESCE(trk_feb.pendapatan_usaha, 0) AS trk_feb_pendapatan_usaha,
            COALESCE(trk_mar.pendapatan_usaha, 0) AS trk_mar_pendapatan_usaha,
            COALESCE(trk_apr.pendapatan_usaha, 0) AS trk_apr_pendapatan_usaha,
            COALESCE(trk_mei.pendapatan_usaha, 0) AS trk_mei_pendapatan_usaha,
            COALESCE(trk_jun.pendapatan_usaha, 0) AS trk_jun_pendapatan_usaha,
            COALESCE(trk_jul.pendapatan_usaha, 0) AS trk_jul_pendapatan_usaha,
            COALESCE(trk_agu.pendapatan_usaha, 0) AS trk_agu_pendapatan_usaha,
            COALESCE(trk_sep.pendapatan_usaha, 0) AS trk_sep_pendapatan_usaha,
            COALESCE(trk_okt.pendapatan_usaha, 0) AS trk_okt_pendapatan_usaha,
            COALESCE(trk_nov.pendapatan_usaha, 0) AS trk_nov_pendapatan_usaha,
            COALESCE(trk_des.pendapatan_usaha, 0) AS trk_des_pendapatan_usaha,

            COALESCE(trk.beban_usaha, 0) AS beban_usaha,
            COALESCE(trk_jan.beban_usaha, 0) AS trk_jan_beban_usaha,
            COALESCE(trk_feb.beban_usaha, 0) AS trk_feb_beban_usaha,
            COALESCE(trk_mar.beban_usaha, 0) AS trk_mar_beban_usaha,
            COALESCE(trk_apr.beban_usaha, 0) AS trk_apr_beban_usaha,
            COALESCE(trk_mei.beban_usaha, 0) AS trk_mei_beban_usaha,
            COALESCE(trk_jun.beban_usaha, 0) AS trk_jun_beban_usaha,
            COALESCE(trk_jul.beban_usaha, 0) AS trk_jul_beban_usaha,
            COALESCE(trk_agu.beban_usaha, 0) AS trk_agu_beban_usaha,
            COALESCE(trk_sep.beban_usaha, 0) AS trk_sep_beban_usaha,
            COALESCE(trk_okt.beban_usaha, 0) AS trk_okt_beban_usaha,
            COALESCE(trk_nov.beban_usaha, 0) AS trk_nov_beban_usaha,
            COALESCE(trk_des.beban_usaha, 0) AS trk_des_beban_usaha,

            COALESCE(trk.beban_usaha + trk.pendapatan_usaha, 0) AS laba_kotor_r,
            COALESCE(trk_jan.beban_usaha + trk_jan.pendapatan_usaha, 0) AS trk_jan_laba_kotor_r,
            COALESCE(trk_feb.beban_usaha + trk_feb.pendapatan_usaha, 0) AS trk_feb_laba_kotor_r,
            COALESCE(trk_mar.beban_usaha + trk_mar.pendapatan_usaha, 0) AS trk_mar_laba_kotor_r,
            COALESCE(trk_apr.beban_usaha + trk_apr.pendapatan_usaha, 0) AS trk_apr_laba_kotor_r,
            COALESCE(trk_mei.beban_usaha + trk_mei.pendapatan_usaha, 0) AS trk_mei_laba_kotor_r,
            COALESCE(trk_jun.beban_usaha + trk_jun.pendapatan_usaha, 0) AS trk_jun_laba_kotor_r,
            COALESCE(trk_jul.beban_usaha + trk_jul.pendapatan_usaha, 0) AS trk_jul_laba_kotor_r,
            COALESCE(trk_agu.beban_usaha + trk_agu.pendapatan_usaha, 0) AS trk_agu_laba_kotor_r,
            COALESCE(trk_sep.beban_usaha + trk_sep.pendapatan_usaha, 0) AS trk_sep_laba_kotor_r,
            COALESCE(trk_okt.beban_usaha + trk_okt.pendapatan_usaha, 0) AS trk_okt_laba_kotor_r,
            COALESCE(trk_nov.beban_usaha + trk_nov.pendapatan_usaha, 0) AS trk_nov_laba_kotor_r,
            COALESCE(trk_des.beban_usaha + trk_des.pendapatan_usaha, 0) AS trk_des_laba_kotor_r,

            COALESCE(trk.pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            COALESCE(trk_jan.pendapatan_or_beban_lain, 0) AS trk_jan_pendapatan_or_beban_lain,
            COALESCE(trk_feb.pendapatan_or_beban_lain, 0) AS trk_feb_pendapatan_or_beban_lain,
            COALESCE(trk_mar.pendapatan_or_beban_lain, 0) AS trk_mar_pendapatan_or_beban_lain,
            COALESCE(trk_apr.pendapatan_or_beban_lain, 0) AS trk_apr_pendapatan_or_beban_lain,
            COALESCE(trk_mei.pendapatan_or_beban_lain, 0) AS trk_mei_pendapatan_or_beban_lain,
            COALESCE(trk_jun.pendapatan_or_beban_lain, 0) AS trk_jun_pendapatan_or_beban_lain,
            COALESCE(trk_jul.pendapatan_or_beban_lain, 0) AS trk_jul_pendapatan_or_beban_lain,
            COALESCE(trk_agu.pendapatan_or_beban_lain, 0) AS trk_agu_pendapatan_or_beban_lain,
            COALESCE(trk_sep.pendapatan_or_beban_lain, 0) AS trk_sep_pendapatan_or_beban_lain,
            COALESCE(trk_okt.pendapatan_or_beban_lain, 0) AS trk_okt_pendapatan_or_beban_lain,
            COALESCE(trk_nov.pendapatan_or_beban_lain, 0) AS trk_nov_pendapatan_or_beban_lain,
            COALESCE(trk_des.pendapatan_or_beban_lain, 0) AS trk_des_pendapatan_or_beban_lain,

            COALESCE(trk.pendapatan_or_beban_lain + (trk.beban_usaha + trk.pendapatan_usaha)) AS laba_operasi_r,
            COALESCE(trk_jan.pendapatan_or_beban_lain + (trk_jan.beban_usaha + trk_jan.pendapatan_usaha), 0) AS trk_jan_laba_operasi_r,
            COALESCE(trk_feb.pendapatan_or_beban_lain + (trk_feb.beban_usaha + trk_feb.pendapatan_usaha), 0) AS trk_feb_laba_operasi_r,
            COALESCE(trk_mar.pendapatan_or_beban_lain + (trk_mar.beban_usaha + trk_mar.pendapatan_usaha), 0) AS trk_mar_laba_operasi_r,
            COALESCE(trk_apr.pendapatan_or_beban_lain + (trk_apr.beban_usaha + trk_apr.pendapatan_usaha), 0) AS trk_apr_laba_operasi_r,
            COALESCE(trk_mei.pendapatan_or_beban_lain + (trk_mei.beban_usaha + trk_mei.pendapatan_usaha), 0) AS trk_mei_laba_operasi_r,
            COALESCE(trk_jun.pendapatan_or_beban_lain + (trk_jun.beban_usaha + trk_jun.pendapatan_usaha), 0) AS trk_jun_laba_operasi_r,
            COALESCE(trk_jul.pendapatan_or_beban_lain + (trk_jul.beban_usaha + trk_jul.pendapatan_usaha), 0) AS trk_jul_laba_operasi_r,
            COALESCE(trk_agu.pendapatan_or_beban_lain + (trk_agu.beban_usaha + trk_agu.pendapatan_usaha), 0) AS trk_agu_laba_operasi_r,
            COALESCE(trk_sep.pendapatan_or_beban_lain + (trk_sep.beban_usaha + trk_sep.pendapatan_usaha), 0) AS trk_sep_laba_operasi_r,
            COALESCE(trk_okt.pendapatan_or_beban_lain + (trk_okt.beban_usaha + trk_okt.pendapatan_usaha), 0) AS trk_okt_laba_operasi_r,
            COALESCE(trk_nov.pendapatan_or_beban_lain + (trk_nov.beban_usaha + trk_nov.pendapatan_usaha), 0) AS trk_nov_laba_operasi_r,
            COALESCE(trk_des.pendapatan_or_beban_lain + (trk_des.beban_usaha + trk_des.pendapatan_usaha), 0) AS trk_des_laba_operasi_r,

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

            COALESCE(trk.ebitda, 0) AS ebitda,
            COALESCE(trk_jan.ebitda, 0) AS trk_jan_ebitda,
            COALESCE(trk_feb.ebitda, 0) AS trk_feb_ebitda,
            COALESCE(trk_mar.ebitda, 0) AS trk_mar_ebitda,
            COALESCE(trk_apr.ebitda, 0) AS trk_apr_ebitda,
            COALESCE(trk_mei.ebitda, 0) AS trk_mei_ebitda,
            COALESCE(trk_jun.ebitda, 0) AS trk_jun_ebitda,
            COALESCE(trk_jul.ebitda, 0) AS trk_jul_ebitda,
            COALESCE(trk_agu.ebitda, 0) AS trk_agu_ebitda,
            COALESCE(trk_sep.ebitda, 0) AS trk_sep_ebitda,
            COALESCE(trk_okt.ebitda, 0) AS trk_okt_ebitda,
            COALESCE(trk_nov.ebitda, 0) AS trk_nov_ebitda,
            COALESCE(trk_des.ebitda, 0) AS trk_des_ebitda,

            COALESCE(trk.investasi_bd, 0) AS investasi_bd,
            COALESCE(trk_jan.investasi_bd, 0) AS trk_jan_investasi_bd,
            COALESCE(trk_feb.investasi_bd, 0) AS trk_feb_investasi_bd,
            COALESCE(trk_mar.investasi_bd, 0) AS trk_mar_investasi_bd,
            COALESCE(trk_apr.investasi_bd, 0) AS trk_apr_investasi_bd,
            COALESCE(trk_mei.investasi_bd, 0) AS trk_mei_investasi_bd,
            COALESCE(trk_jun.investasi_bd, 0) AS trk_jun_investasi_bd,
            COALESCE(trk_jul.investasi_bd, 0) AS trk_jul_investasi_bd,
            COALESCE(trk_agu.investasi_bd, 0) AS trk_agu_investasi_bd,
            COALESCE(trk_sep.investasi_bd, 0) AS trk_sep_investasi_bd,
            COALESCE(trk_okt.investasi_bd, 0) AS trk_okt_investasi_bd,
            COALESCE(trk_nov.investasi_bd, 0) AS trk_nov_investasi_bd,
            COALESCE(trk_des.investasi_bd, 0) AS trk_des_investasi_bd,

            COALESCE(trk.investasi_nbd, 0) AS investasi_nbd,
            COALESCE(trk_jan.investasi_nbd, 0) AS trk_jan_investasi_nbd,
            COALESCE(trk_feb.investasi_nbd, 0) AS trk_feb_investasi_nbd,
            COALESCE(trk_mar.investasi_nbd, 0) AS trk_mar_investasi_nbd,
            COALESCE(trk_apr.investasi_nbd, 0) AS trk_apr_investasi_nbd,
            COALESCE(trk_mei.investasi_nbd, 0) AS trk_mei_investasi_nbd,
            COALESCE(trk_jun.investasi_nbd, 0) AS trk_jun_investasi_nbd,
            COALESCE(trk_jul.investasi_nbd, 0) AS trk_jul_investasi_nbd,
            COALESCE(trk_agu.investasi_nbd, 0) AS trk_agu_investasi_nbd,
            COALESCE(trk_sep.investasi_nbd, 0) AS trk_sep_investasi_nbd,
            COALESCE(trk_okt.investasi_nbd, 0) AS trk_okt_investasi_nbd,
            COALESCE(trk_nov.investasi_nbd, 0) AS trk_nov_investasi_nbd,
            COALESCE(trk_des.investasi_nbd, 0) AS trk_des_investasi_nbd,

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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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

        $pdf = DomPDF::loadView('modul-customer-management.rkap-realisasi.report-all-dompdf', compact(
            'rkapRealisasiList', 
            'tahun_pdf',
            'perusahaan_pdf'
        ));
        $pdf->setOptions([
            'isPhpEnabled' => true,
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true,
            'tempDir' => public_path(),
            'chroot'  => public_path(),
        ]);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('report_rkap_realisasi_'.date('Y-m-d H:i:s').'.pdf');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function exportXLSX(Request $request)
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

            COALESCE(trk.pendapatan_usaha, 0) AS pendapatan_usaha,
            COALESCE(trk_jan.pendapatan_usaha, 0) AS trk_jan_pendapatan_usaha,
            COALESCE(trk_feb.pendapatan_usaha, 0) AS trk_feb_pendapatan_usaha,
            COALESCE(trk_mar.pendapatan_usaha, 0) AS trk_mar_pendapatan_usaha,
            COALESCE(trk_apr.pendapatan_usaha, 0) AS trk_apr_pendapatan_usaha,
            COALESCE(trk_mei.pendapatan_usaha, 0) AS trk_mei_pendapatan_usaha,
            COALESCE(trk_jun.pendapatan_usaha, 0) AS trk_jun_pendapatan_usaha,
            COALESCE(trk_jul.pendapatan_usaha, 0) AS trk_jul_pendapatan_usaha,
            COALESCE(trk_agu.pendapatan_usaha, 0) AS trk_agu_pendapatan_usaha,
            COALESCE(trk_sep.pendapatan_usaha, 0) AS trk_sep_pendapatan_usaha,
            COALESCE(trk_okt.pendapatan_usaha, 0) AS trk_okt_pendapatan_usaha,
            COALESCE(trk_nov.pendapatan_usaha, 0) AS trk_nov_pendapatan_usaha,
            COALESCE(trk_des.pendapatan_usaha, 0) AS trk_des_pendapatan_usaha,

            COALESCE(trk.beban_usaha, 0) AS beban_usaha,
            COALESCE(trk_jan.beban_usaha, 0) AS trk_jan_beban_usaha,
            COALESCE(trk_feb.beban_usaha, 0) AS trk_feb_beban_usaha,
            COALESCE(trk_mar.beban_usaha, 0) AS trk_mar_beban_usaha,
            COALESCE(trk_apr.beban_usaha, 0) AS trk_apr_beban_usaha,
            COALESCE(trk_mei.beban_usaha, 0) AS trk_mei_beban_usaha,
            COALESCE(trk_jun.beban_usaha, 0) AS trk_jun_beban_usaha,
            COALESCE(trk_jul.beban_usaha, 0) AS trk_jul_beban_usaha,
            COALESCE(trk_agu.beban_usaha, 0) AS trk_agu_beban_usaha,
            COALESCE(trk_sep.beban_usaha, 0) AS trk_sep_beban_usaha,
            COALESCE(trk_okt.beban_usaha, 0) AS trk_okt_beban_usaha,
            COALESCE(trk_nov.beban_usaha, 0) AS trk_nov_beban_usaha,
            COALESCE(trk_des.beban_usaha, 0) AS trk_des_beban_usaha,

            COALESCE(trk.beban_usaha + trk.pendapatan_usaha, 0) AS laba_kotor_r,
            COALESCE(trk_jan.beban_usaha + trk_jan.pendapatan_usaha, 0) AS trk_jan_laba_kotor_r,
            COALESCE(trk_feb.beban_usaha + trk_feb.pendapatan_usaha, 0) AS trk_feb_laba_kotor_r,
            COALESCE(trk_mar.beban_usaha + trk_mar.pendapatan_usaha, 0) AS trk_mar_laba_kotor_r,
            COALESCE(trk_apr.beban_usaha + trk_apr.pendapatan_usaha, 0) AS trk_apr_laba_kotor_r,
            COALESCE(trk_mei.beban_usaha + trk_mei.pendapatan_usaha, 0) AS trk_mei_laba_kotor_r,
            COALESCE(trk_jun.beban_usaha + trk_jun.pendapatan_usaha, 0) AS trk_jun_laba_kotor_r,
            COALESCE(trk_jul.beban_usaha + trk_jul.pendapatan_usaha, 0) AS trk_jul_laba_kotor_r,
            COALESCE(trk_agu.beban_usaha + trk_agu.pendapatan_usaha, 0) AS trk_agu_laba_kotor_r,
            COALESCE(trk_sep.beban_usaha + trk_sep.pendapatan_usaha, 0) AS trk_sep_laba_kotor_r,
            COALESCE(trk_okt.beban_usaha + trk_okt.pendapatan_usaha, 0) AS trk_okt_laba_kotor_r,
            COALESCE(trk_nov.beban_usaha + trk_nov.pendapatan_usaha, 0) AS trk_nov_laba_kotor_r,
            COALESCE(trk_des.beban_usaha + trk_des.pendapatan_usaha, 0) AS trk_des_laba_kotor_r,

            COALESCE(trk.pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            COALESCE(trk_jan.pendapatan_or_beban_lain, 0) AS trk_jan_pendapatan_or_beban_lain,
            COALESCE(trk_feb.pendapatan_or_beban_lain, 0) AS trk_feb_pendapatan_or_beban_lain,
            COALESCE(trk_mar.pendapatan_or_beban_lain, 0) AS trk_mar_pendapatan_or_beban_lain,
            COALESCE(trk_apr.pendapatan_or_beban_lain, 0) AS trk_apr_pendapatan_or_beban_lain,
            COALESCE(trk_mei.pendapatan_or_beban_lain, 0) AS trk_mei_pendapatan_or_beban_lain,
            COALESCE(trk_jun.pendapatan_or_beban_lain, 0) AS trk_jun_pendapatan_or_beban_lain,
            COALESCE(trk_jul.pendapatan_or_beban_lain, 0) AS trk_jul_pendapatan_or_beban_lain,
            COALESCE(trk_agu.pendapatan_or_beban_lain, 0) AS trk_agu_pendapatan_or_beban_lain,
            COALESCE(trk_sep.pendapatan_or_beban_lain, 0) AS trk_sep_pendapatan_or_beban_lain,
            COALESCE(trk_okt.pendapatan_or_beban_lain, 0) AS trk_okt_pendapatan_or_beban_lain,
            COALESCE(trk_nov.pendapatan_or_beban_lain, 0) AS trk_nov_pendapatan_or_beban_lain,
            COALESCE(trk_des.pendapatan_or_beban_lain, 0) AS trk_des_pendapatan_or_beban_lain,

            COALESCE(trk.pendapatan_or_beban_lain + (trk.beban_usaha + trk.pendapatan_usaha)) AS laba_operasi_r,
            COALESCE(trk_jan.pendapatan_or_beban_lain + (trk_jan.beban_usaha + trk_jan.pendapatan_usaha), 0) AS trk_jan_laba_operasi_r,
            COALESCE(trk_feb.pendapatan_or_beban_lain + (trk_feb.beban_usaha + trk_feb.pendapatan_usaha), 0) AS trk_feb_laba_operasi_r,
            COALESCE(trk_mar.pendapatan_or_beban_lain + (trk_mar.beban_usaha + trk_mar.pendapatan_usaha), 0) AS trk_mar_laba_operasi_r,
            COALESCE(trk_apr.pendapatan_or_beban_lain + (trk_apr.beban_usaha + trk_apr.pendapatan_usaha), 0) AS trk_apr_laba_operasi_r,
            COALESCE(trk_mei.pendapatan_or_beban_lain + (trk_mei.beban_usaha + trk_mei.pendapatan_usaha), 0) AS trk_mei_laba_operasi_r,
            COALESCE(trk_jun.pendapatan_or_beban_lain + (trk_jun.beban_usaha + trk_jun.pendapatan_usaha), 0) AS trk_jun_laba_operasi_r,
            COALESCE(trk_jul.pendapatan_or_beban_lain + (trk_jul.beban_usaha + trk_jul.pendapatan_usaha), 0) AS trk_jul_laba_operasi_r,
            COALESCE(trk_agu.pendapatan_or_beban_lain + (trk_agu.beban_usaha + trk_agu.pendapatan_usaha), 0) AS trk_agu_laba_operasi_r,
            COALESCE(trk_sep.pendapatan_or_beban_lain + (trk_sep.beban_usaha + trk_sep.pendapatan_usaha), 0) AS trk_sep_laba_operasi_r,
            COALESCE(trk_okt.pendapatan_or_beban_lain + (trk_okt.beban_usaha + trk_okt.pendapatan_usaha), 0) AS trk_okt_laba_operasi_r,
            COALESCE(trk_nov.pendapatan_or_beban_lain + (trk_nov.beban_usaha + trk_nov.pendapatan_usaha), 0) AS trk_nov_laba_operasi_r,
            COALESCE(trk_des.pendapatan_or_beban_lain + (trk_des.beban_usaha + trk_des.pendapatan_usaha), 0) AS trk_des_laba_operasi_r,

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

            COALESCE(trk.ebitda, 0) AS ebitda,
            COALESCE(trk_jan.ebitda, 0) AS trk_jan_ebitda,
            COALESCE(trk_feb.ebitda, 0) AS trk_feb_ebitda,
            COALESCE(trk_mar.ebitda, 0) AS trk_mar_ebitda,
            COALESCE(trk_apr.ebitda, 0) AS trk_apr_ebitda,
            COALESCE(trk_mei.ebitda, 0) AS trk_mei_ebitda,
            COALESCE(trk_jun.ebitda, 0) AS trk_jun_ebitda,
            COALESCE(trk_jul.ebitda, 0) AS trk_jul_ebitda,
            COALESCE(trk_agu.ebitda, 0) AS trk_agu_ebitda,
            COALESCE(trk_sep.ebitda, 0) AS trk_sep_ebitda,
            COALESCE(trk_okt.ebitda, 0) AS trk_okt_ebitda,
            COALESCE(trk_nov.ebitda, 0) AS trk_nov_ebitda,
            COALESCE(trk_des.ebitda, 0) AS trk_des_ebitda,

            COALESCE(trk.investasi_bd, 0) AS investasi_bd,
            COALESCE(trk_jan.investasi_bd, 0) AS trk_jan_investasi_bd,
            COALESCE(trk_feb.investasi_bd, 0) AS trk_feb_investasi_bd,
            COALESCE(trk_mar.investasi_bd, 0) AS trk_mar_investasi_bd,
            COALESCE(trk_apr.investasi_bd, 0) AS trk_apr_investasi_bd,
            COALESCE(trk_mei.investasi_bd, 0) AS trk_mei_investasi_bd,
            COALESCE(trk_jun.investasi_bd, 0) AS trk_jun_investasi_bd,
            COALESCE(trk_jul.investasi_bd, 0) AS trk_jul_investasi_bd,
            COALESCE(trk_agu.investasi_bd, 0) AS trk_agu_investasi_bd,
            COALESCE(trk_sep.investasi_bd, 0) AS trk_sep_investasi_bd,
            COALESCE(trk_okt.investasi_bd, 0) AS trk_okt_investasi_bd,
            COALESCE(trk_nov.investasi_bd, 0) AS trk_nov_investasi_bd,
            COALESCE(trk_des.investasi_bd, 0) AS trk_des_investasi_bd,

            COALESCE(trk.investasi_nbd, 0) AS investasi_nbd,
            COALESCE(trk_jan.investasi_nbd, 0) AS trk_jan_investasi_nbd,
            COALESCE(trk_feb.investasi_nbd, 0) AS trk_feb_investasi_nbd,
            COALESCE(trk_mar.investasi_nbd, 0) AS trk_mar_investasi_nbd,
            COALESCE(trk_apr.investasi_nbd, 0) AS trk_apr_investasi_nbd,
            COALESCE(trk_mei.investasi_nbd, 0) AS trk_mei_investasi_nbd,
            COALESCE(trk_jun.investasi_nbd, 0) AS trk_jun_investasi_nbd,
            COALESCE(trk_jul.investasi_nbd, 0) AS trk_jul_investasi_nbd,
            COALESCE(trk_agu.investasi_nbd, 0) AS trk_agu_investasi_nbd,
            COALESCE(trk_sep.investasi_nbd, 0) AS trk_sep_investasi_nbd,
            COALESCE(trk_okt.investasi_nbd, 0) AS trk_okt_investasi_nbd,
            COALESCE(trk_nov.investasi_nbd, 0) AS trk_nov_investasi_nbd,
            COALESCE(trk_des.investasi_nbd, 0) AS trk_des_investasi_nbd,

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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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
            SUM(pendapatan_usaha) AS pendapatan_usaha,
            SUM(beban_usaha) AS beban_usaha,
            SUM(pendapatan_or_beban_lain) AS pendapatan_or_beban_lain,
            SUM(laba_bersih_r) AS laba_bersih_r,
            SUM(ebitda) AS ebitda,
            SUM(investasi_bd) AS investasi_bd,
            SUM(investasi_nbd) AS investasi_nbd,
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

        $pdf = DomPDF::loadView('modul-customer-management.rkap-realisasi.report-all-dompdf', compact(
            'rkapRealisasiList', 
            'tahun_pdf',
            'perusahaan_pdf'
        ));
        
        return Excel::download(new RekapRKAPRealisasi($rkapRealisasiList, $tahun_pdf, $perusahaan_pdf), 'report_rkap_realisasi_'.date('Y-m-d H:i:s').'.xlsx');
    }
}
