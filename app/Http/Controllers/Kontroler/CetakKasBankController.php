<?php

namespace App\Http\Controllers\Kontroler;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Kasdoc;
use Auth;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class CetakKasBankController extends Controller
{
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from bulankontroller where status='1' and length(thnbln)='6'");
        if(!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                $tahun = substr($data_bul->bulan_buku,0,-2); 
                $bulan = substr($data_bul->bulan_buku,4); 
            }
        } else {
            $bulan ='00';
            $tahun ='0000';
        }
        return view('modul-kontroler.cetak-kas-bank.index',compact('tahun','bulan'));
    }

    public function indexJson(Request $request)
    {
        $rsbulan = DB::select("SELECT max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($rsbulan)){
            foreach($rsbulan as $dat)
            {
                if(is_null($dat->thnbln)){
                    $thnblopen2 = "";
                } else {
                    $thnblopen2 = $dat->thnbln;
                }
            }
        } else {
            $thnblopen2 = "";
        }
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $nodok = $request->nodok;
        if ($nodok == null and $tahun == null and $bulan == null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where a.thnbln='$bulan' and a.kd_kepada is null  order by a.store,a.voucher asc");
        } elseif ($nodok == null and $tahun <> null and $bulan == null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where left(a.thnbln, 4)='$tahun' and a.kd_kepada is null  order by a.store,a.voucher asc");
        } elseif ($nodok <> null and $tahun == null and $bulan == null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where a.voucher='$nodok' and a.kd_kepada is null  order by a.store,a.voucher asc");
        } elseif ($nodok <> null and $tahun <> null and $bulan == null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where a.voucher='$nodok' and left(a.thnbln, 4)='$tahun' and a.kd_kepada is null  order by a.store,a.voucher asc");
        } elseif ($nodok == null and $tahun <> null and $bulan <> null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where left(thnbln, 4)='$tahun' and right(thnbln,2)='$bulan' and a.kd_kepada is null  order by a.store,a.voucher asc");
        } elseif ($nodok <> null and $tahun <> null and $bulan <> null) {
            $data = DB::select("SELECT a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.paid,a.verified,b.namabank from kasdoc a join storejk b on a.store=b.kodestore where a.voucher='$nodok' and left(thnbln, 4)='$tahun' and right(thnbln, 2)='$bulan' and a.kd_kepada is null  order by a.store,a.voucher asc");
        }
        
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
            if($data->paid == 'Y'){
                return '<span title="Batalkan Pembayaran"><i class="fas fa-check-circle fa-2x text-success"></i></span>';
            } else {
                return '<span class="pointer-link" title="Klik Untuk Pembayaran"><i class="fas fa-ban fa-2x text-danger"></i></span>';
            }
       })
        ->addColumn('tahun', function ($data) {
            return $data->thnbln;
       })
        ->addColumn('nobukti', function ($data) {
            return $data->voucher;
       })
        ->addColumn('nokas', function ($data) {
            return $data->store.'.'.$data->namabank;
       })
        ->addColumn('kurs', function ($data) {
            return $data->rate;
       })
        ->addColumn('nilai', function ($data) {
            if ($data->nilai_dok == "") {
                return  '0';
            } else {
                return number_format($data->nilai_dok,2,'.',',');
            }
       })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.str_replace('/', '-', $data->docno).'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio','action'])
        ->make(true); 
    }

    public function rekap($docs)
    {
        $doc = str_replace('-', '/', $docs);   
        $data_list = DB::select("SELECT * from kasdoc where docno='$doc'");
        foreach($data_list as $data_kasd)
        {
            $docno = $data_kasd->docno;
            $thnbln = $data_kasd->thnbln;
            $jk = $data_kasd->jk;
            $store = $data_kasd->store;
            $ci = $data_kasd->ci;
            $voucher = $data_kasd->voucher;
            $kepada = $data_kasd->kepada;
            $rate = $data_kasd->rate;
            $nilai_dok = $data_kasd->nilai_dok;
            $ket1 = $data_kasd->ket1;
            $ket2 = $data_kasd->ket2;
            $ket3 = $data_kasd->ket3;
            $mp =  substr($data_kasd->docno,0,1);
            $kd_kepada = $data_kasd->kd_kepada; 
        
        
            if (Auth::user()->userid == "WASONO") {
                $id = "W";
            }elseif(Auth::user()->userid == "TASMAN"){
                $id = "T";
            }elseif(Auth::user()->userid == "AA"){
                $id = "A";
            } else {
                $id = "K";
            }

            
            $data_pbd = DB::select("SELECT * from ttdakt");
            foreach($data_pbd as $rsparam)
            {            
                if ($mp == "P" or $mp == "p") {
                    $minta1 = $rsparam->minta1;
                    $nminta1 = $rsparam->nminta1;
                    $verifikasi1 = $rsparam->verifikasi1;
                    $nverifikasi1 = $rsparam->nverifikasi1;
                    $setuju1 = $rsparam->setuju1;
                    $nsetuju1 = $rsparam->nsetuju1;
                    $buku1 = $rsparam->buku1;
                    $nbuku1 = $rsparam->nbuku1;
                    $setuju2 ="";
                    $nsetuju2 = "";
                    $buku2 = "";
                    $nbuku2 = "";
                    $kas2 = "";
                    $nkas2 = "";
                } else {
                    $minta1 = "";
                    $nminta1 = "";
                    $verifikasi1 = "";
                    $nverifikasi1 = "";
                    $setuju1 = "";
                    $nsetuju1 = "";
                    $buku1 = "";
                    $nbuku1 = "";
                    $setuju2 = $rsparam->setuju2;
                    $nsetuju2 = $rsparam->nsetuju2;
                    $buku2 = $rsparam->buku2;
                    $nbuku2 = $rsparam->nbuku2;
                    $kas2 = $rsparam->kas2;
                    $nkas2 = $rsparam->nkas2;
                }
            }
        } 
        return view('modul-kontroler.tabel.kas-bank-kontroler.rekap',compact(
            'docs',
            'minta1',
            'nminta1',
            'verifikasi1',
            'nverifikasi1',
            'setuju1',
            'nsetuju1',
            'buku1',
            'nbuku1',
            'setuju2',            
            'nsetuju2',
            'buku2',          
            'nbuku2',           
            'kas2',         
            'nkas2',
            'docno',
            'nilai_dok',
            'ci',
            'kd_kepada',
            'mp'    
         ));
    }

    public function export(Request $request)
    {
        $docno = str_replace('-', '/', $request->docno);   
            Kasdoc::where('docno', $docno)
            ->update([
                'tgl_kurs' =>  $request->tanggal,
            ]);
            $data_list= DB::select("SELECT a.docno,a.nilai_dok,a.mrs_no,a.kepada,a.tgl_kurs,a.jk,right(a.thnbln,2) bulan, left(a.thnbln, 4) tahun,a.store,a.ci,a.rate,a.ket1,a.ket2,a.ket3, b.*,a.voucher from kasdoc a join kasline b on a.docno=b.docno where a.docno='$docno' and b.cj not in ('99') ");    
    
        if(!empty($data_list)){
            foreach($data_list as $data){
                $jk = $data->jk;
                $docno = $data->docno;
                $tahun = $data->tahun;
                $bulan = $data->bulan;
                $store = $data->store;
                $voucher = $data->voucher;
                $ci = $data->ci;
                $rate = $data->rate;
                $ket1 = $data->ket1;
                $ket2 = $data->ket2;
                $ket3 = $data->ket3;
                $mrs_no = $data->mrs_no;
                $tgl_kurs = $data->tgl_kurs;
                $kepada = $data->kepada;
                $nilai_dok = $data->nilai_dok;
            }
            $mp = substr($docno,0,1);
            if($mp == "M" or $mp == "m"){
                $reportname = "export_merah";
            } else {
                $reportname = "export_putih";
            }
            $pdf = DomPDF::loadview("modul-kontroler.tabel.kas-bank-kontroler.$reportname",compact(
                'request',
                'data_list',
                'jk',
                'bulan',
                'tahun',
                'store',
                'voucher',
                'ci',
                'rate',
                'ket1',
                'ket2',
                'ket3',
                'mrs_no',
                'tgl_kurs',
                'kepada',
                'nilai_dok',
                'docno'
                ))->setPaper('A4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
        
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(105, 75,"", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data", 'Failed')->persistent(true);
            return redirect()->route('cetak_kas_bank.index');
        }
    }
}
