<?php

namespace App\Http\Controllers\Gcg;

use App\Exports\ReportBoundary;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use Illuminate\Http\Request;

class ReportBoundaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-gcg.report-boundary.index');
    }

    public function export(Request $request)
    {
        $report_list = DB::table('userpdv AS u')
        ->selectRaw("
            DISTINCT u.nopeg,
            gcg_fungsi.nama AS nama_fungsi,
            gcg_jabatan.nama AS nama_jabatan,
            sdm_master_pegawai.nama AS nama_pekerja,
            COUNT(DISTINCT gcg_coc.*) AS total_coc,
            COUNT(DISTINCT gcg_coi.*) AS total_coi,
            COUNT(DISTINCT gcg_sosialisasi.*) AS total_sosialisasi,
            COUNT(DISTINCT gcg_lhkpn.*) AS total_lhkpn,
            COUNT(CASE WHEN (gcg_gratifikasi.jenis_gratifikasi = 'pemberian') THEN gcg_gratifikasi.jenis_gratifikasi ELSE NULL END) AS pemberian,
            COUNT(CASE WHEN (gcg_gratifikasi.jenis_gratifikasi = 'penerimaan') THEN gcg_gratifikasi.jenis_gratifikasi ELSE NULL END) AS penerimaan,
            COUNT(CASE WHEN (gcg_gratifikasi.jenis_gratifikasi = 'permintaan') THEN gcg_gratifikasi.jenis_gratifikasi ELSE NULL END) AS permintaan
        ")
        ->leftJoin(
            DB::raw("(
                SELECT
                    DISTINCT nopeg,
                    EXTRACT(MONTH FROM created_at) AS coc_month,
                    EXTRACT(DAY FROM created_at) AS coc_day

                FROM
                    gcg_coc

                GROUP BY
                    nopeg,
                    coc_month,
                    coc_day
            ) AS gcg_coc"),
            'gcg_coc.nopeg',
            'u.nopeg'
        )
        ->leftJoin(
            DB::raw("(
                SELECT
                    DISTINCT nopeg,
                    EXTRACT(MONTH FROM created_at) AS coi_month,
                    EXTRACT(DAY FROM created_at) AS coi_day

                FROM
                    gcg_coi

                GROUP BY
                nopeg,
                coi_month,
                coi_day
            ) AS gcg_coi"),
            'gcg_coi.nopeg',
            'u.nopeg'
        )
        ->leftJoin('gcg_sosialisasi', 'gcg_sosialisasi.nopeg', 'u.nopeg')
        ->leftJoin('gcg_lhkpn', 'gcg_lhkpn.nopeg', 'u.nopeg')
        ->leftJoin('gcg_gratifikasi', 'gcg_gratifikasi.nopeg', 'u.nopeg')
        ->join('gcg_fungsi', 'gcg_fungsi.id', 'u.gcg_fungsi_id')
        ->join('gcg_jabatan', 'gcg_jabatan.id', 'u.gcg_jabatan_id')
        ->join('sdm_master_pegawai', 'sdm_master_pegawai.nopeg', 'u.nopeg')
        ->whereNotNull('u.nopeg')
        ->whereNotNull('u.gcg_jabatan_id')
        ->whereNotNull('u.gcg_fungsi_id')
        ->groupBy('u.nopeg', 'nama_fungsi', 'nama_jabatan', 'nama_pekerja')
        ->get();
        
        $bulan = date('m');
        $tahun = date('Y');

        return Excel::download(new ReportBoundary(
            $report_list,
            $bulan,
            $tahun
        ), 'gcg_report_boundary'.date('Y-m-d H:i:s').".xlsx");
    }
}
