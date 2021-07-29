<?php

namespace App\Http\Controllers\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanAfiliasi;
use DB;
use Illuminate\Http\Request;
use PDF;

class PencapaianKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tgl = date_create(now());
        $bulan = date_format($tgl, 'm'); 
        $tahun = date_format($tgl, 'Y'); 
        $data_perusahaan = PerusahaanAfiliasi::all();
        $data = DB::select("SELECT a.*, b.nama,b.id, c.* from tbl_monitoring a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id, tbl_rencana_kerja c  where a.kd_perusahaan=c.kd_perusahaan and a.bulan='$bulan' and a.tahun='$tahun'");
        
        return view('modul-customer-management.pencapaian-kinerja.index',compact('data','data_perusahaan'));
    }

    public function search(Request $request)
    {   
        if($request->perusahaan <> null){
            $perusahaan = "and a.kd_perusahaan = '$request->perusahaan'";
        }else{
            $perusahaan = "";
        }
        $data_perusahaan = PerusahaanAfiliasi::all();
        $data =DB::select("SELECT a.*, b.nama,b.id, c.* from tbl_monitoring a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id, tbl_rencana_kerja c  where a.kd_perusahaan=c.kd_perusahaan and a.bulan='$request->bulan' and a.tahun='$request->tahun' $perusahaan");
        return view('modul-customer-management.pencapaian-kinerja.index',compact('data','data_perusahaan'));
            
    }

    public function export(Request $request)
    {
        if($request->perusahaan == 'A'){
            $perusahaan = '';
        }else{
            $perusahaan = "and a.kd_perusahaan = '$request->perusahaan'";
        }
        
        $data = DB::select("SELECT a.*, b.nama, c.* from tbl_monitoring a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id, tbl_rencana_kerja c  where a.kd_perusahaan=c.kd_perusahaan and a.bulan=c.bulan and a.tahun=c.tahun $perusahaan and a.tahun='$request->tahun'");

        $pdf = PDF::loadview('pencapaian_kerja.export_pencapaian_pdf',compact('data'))
        ->setPaper('a4', 'portrait')
        ->setOption('footer-right', 'Halaman [page] dari [toPage]')
        ->setOption('footer-font-size', 7)
        ->setOption('header-html', view('pencapaian_kerja.export_pencapaian_pdf_header'))
        ->setOption('margin-top', 30)
        ->setOption('margin-bottom', 10);

        return $pdf->stream('rekap_pencapaian_'.date('Y-m-d H:i:s').'.pdf');
    }
}
