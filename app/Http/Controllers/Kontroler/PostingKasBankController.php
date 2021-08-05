<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Fiosd201;
use App\Models\Kasdoc;
use App\Models\Kasline;
use Auth;
use DB;
use Illuminate\Http\Request;

class PostingKasBankController extends Controller
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
    return view('posting_kas_bank.index',compact('tahun','bulan'));
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
        if($request->bulan <>"" and $request->tahun<>""){
            $data = DB::select("SELECT a.* from kasdoc a where a.thnbln ='$request->tahun$request->bulan' and a.verified='Y' and a.posted='N' order by a.store,a.voucher,a.paiddate asc");
        } else {
            $data = DB::select("SELECT a.* from kasdoc a where a.thnbln ='$thnblopen2' and a.verified='Y' and a.posted='N' order by a.store,a.voucher,a.paiddate asc");
        }		
        return datatables()->of($data)
        ->addColumn('paiddate', function ($data) {
            if($data->paiddate <>""){
                $tgl = date_create($data->paiddate);
                return date_format($tgl, 'd/m/Y');
            } else {
                return '0';
            }
       })
        ->addColumn('docno', function ($data) {
            return $data->docno;
       })
        ->addColumn('thnbln', function ($data) {
            return $data->thnbln;
       })
        ->addColumn('keterangan', function ($data) {
            return $data->kepada;
       })
        ->addColumn('jk', function ($data) {
            return $data->jk;
       })
        ->addColumn('store', function ($data) {
            return $data->store;
       })
        ->addColumn('voucher', function ($data) {
            return $data->voucher;
       })
        ->addColumn('nilai', function ($data) {
            return number_format($data->nilai_dok,2,'.',',');
       })
        ->addColumn('action', function ($data) {
            if($data->verified == 'Y'){
                $action = '<a href="'. route('postingan_kas_bank.verkas',['no' => str_replace('/', '-', $data->docno),'id' => $data->verified]).'"><span class="pointer-link" title="Batalkan Verifikasi" style="cursor:hand"><i class="fas fa-check-circle fa-2x text-success"></i></span></a>';
            } else {
                $action = '<a href="'. route('postingan_kas_bank.verkas',['no' => str_replace('/', '-', $data->docno),'id' => $data->verified]).'"><span class="pointer-link" title="" style="cursor:hand"><i class="fas fa-ban fa-2x text-danger"></i></span></a>';
            }               
            return $action;
        })
        ->rawColumns(['action'])
        ->make(true); 
    }

    public function verkas($no)
    {
        $docno = str_replace('-', '/', $no);
            $data_objrs = DB::select("SELECT * from kasdoc where docno='$docno'");
            foreach($data_objrs as $objrs )
            {
                $docno = $objrs->docno;
                $thnbln = $objrs->thnbln;
                $jk  = $objrs->jk;
                $nokas = $objrs->store;
                $ci = $objrs->ci;
                $nobukti = $objrs->voucher;
                $kepada = $objrs->kepada;
                $kurs = $objrs->rate;
                $nilai = number_format($objrs->nilai_dok);
                $verified = $objrs->verified;
                $mp = substr($objrs->docno,0,1);
                $bagian = substr($objrs->docno,2,5);
                $nomor = substr($objrs->docno,8,7);
                $bulan = substr($objrs->thnbln,4,2);
                $tahun = substr($objrs->thnbln,0,4);
                $status1=$objrs->verified;
                $paiddate = $objrs->paiddate;
                if($mp == "P"){
                    $darkep = "Kepada";
                } else { 
                    $darkep = "Dari";
                }

                if($jk == "13"){
                    $namajk = "Bank (Dollar)";
                    $namaci = "2.US$";
                }elseif($jk == "11"){
                    $namajk = "Bank (Rupiah)";
                    $namaci = "1.Rp";
                } else {
                    $namajk = "Kas (Rupiah)";
                    $namaci = "1.Rp";
                }

                    $data_rsbagian = DB::select("SELECT nama from sdm_tbl_kdbag where kode ='$bagian'");
                    if(!empty($data_rsbagian)){
                        foreach($data_rsbagian as $rsbagian)
                        {
                        $nama_bagian = $rsbagian->nama;
                        }
                    } else {
                        $nama_bagian = "";
                    }

                    $data_rskas = DB::select("SELECT namabank from storejk where kodestore ='$nokas'");
                    if(!empty($data_rskas)){
                        foreach($data_rskas as $rskas)
                        {
                            $nama_kas = $rskas->namabank;
                        }
                    } else {
                        $nama_kas = "-";
                    }
            }
            $data_no = DB::select("SELECT max(lineno) as nu from kasline where docno='$docno'");
            if(!empty($data_no)){
                foreach($data_no as $no)
                {
                    $nu = $no->nu+1;
                }
            } else {
                $nu=1;
            }  
            $data_detail = DB::select("SELECT a.* from kasline a where a.docno='$docno' order by a.lineno");
            $data_lapang = DB::select("SELECT kodelokasi,nama from lokasi");
            $data_sandi = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct");
            $data_bagian = DB::select("SELECT kode,nama from sdm_tbl_kdbag order by kode");
            $data_jenis = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
            $data_cjudex = DB::select("SELECT kode,nama from cashjudex order by kode");
            $verifieds = DB::select("SELECT verified from kasdoc where docno='$docno'");
            foreach($verifieds as $dat)
            {
                $verified = $dat->verified;
            }
            $sum = DB::select("SELECT sum(totprice) as tot from kasline where docno='$docno'");
            foreach($sum as $sums)
            {
                if($sums->tot <> ""){
                    $jumlahnya = $sums->tot;
                } else {
                    $jumlahnya = 0;
                }
            }
            $data_rsjurnal = DB::select("SELECT distinct(store) from kasdoc where paid='Y' and verified='N'");
            return view('posting_kas_bank.verkas',compact(
                                                        'jumlahnya',
                                                        'verified',
                                                        'data_detail',
                                                        'nu',
                                                        'data_lapang',
                                                        'data_cjudex',
                                                        'data_sandi',
                                                        'data_bagian',
                                                        'data_jenis',
                                                        'sum',
                                                        'docno',
                                                        'thnbln',
                                                        'jk',
                                                        'nokas',
                                                        'ci',
                                                        'nobukti',
                                                        'kepada',
                                                        'kurs',
                                                        'nilai',
                                                        'verified',
                                                        'mp',
                                                        'bagian',
                                                        'nomor',
                                                        'bulan',
                                                        'tahun',
                                                        'status1',
                                                        'paiddate',
                                                        'darkep',
                                                        'namaci',
                                                        'namajk',
                                                        'nama_bagian',
                                                        'nama_kas',
                                                        'data_rsjurnal'
                                                            ));
    }
    public function verkass()
    {
        
            
                $docno = '';
                $thnbln = '';
                $jk  = '';
                $nokas = '';
                $ci = '';
                $nobukti = '';
                $kepada = '';
                $kurs = '';
                $nilai = '';
                $verified = '';
                $mp = '';
                $bagian = '';
                $nomor = '';
                $bulan = '';
                $tahun = '';
                $status1='';
                $paiddate = '';
                $darkep = "";
                $namajk = "";
                $namaci = "";
                $nama_bagian = "";
                $nama_kas = "-";
                $nu='';
            $data_detail = DB::select("SELECT a.* from kasline a where a.docno='$docno' order by a.lineno");
            $data_lapang = DB::select("SELECT kodelokasi,nama from lokasi");
            $data_sandi = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct");
            $data_bagian = DB::select("SELECT kode,nama from sdm_tbl_kdbag order by kode");
            $data_jenis = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
            $data_cjudex = DB::select("SELECT kode,nama from cashjudex order by kode");
            $verifieds = DB::select("SELECT verified from kasdoc where docno='$docno'");
            foreach($verifieds as $dat)
            {
                $verified = $dat->verified;
            }
            $sum = DB::select("SELECT sum(totprice) as tot from kasline where docno='$docno'");
            foreach($sum as $sums)
            {
                if($sums->tot <> ""){
                    $jumlahnya = $sums->tot;
                } else {
                    $jumlahnya = 0;
                }
            }
        
            $data_rsjurnal = DB::select("SELECT distinct(store) from kasdoc where paid='Y' and verified='N'");

        return view('posting_kas_bank.verkas',compact(
                                                        'jumlahnya',
                                                        'verified',
                                                        'data_detail',
                                                        'nu',
                                                        'data_lapang',
                                                        'data_cjudex',
                                                        'data_sandi',
                                                        'data_bagian',
                                                        'data_jenis',
                                                        'sum',
                                                        'docno',
                                                        'thnbln',
                                                        'jk',
                                                        'nokas',
                                                        'ci',
                                                        'nobukti',
                                                        'kepada',
                                                        'kurs',
                                                        'nilai',
                                                        'verified',
                                                        'mp',
                                                        'bagian',
                                                        'nomor',
                                                        'bulan',
                                                        'tahun',
                                                        'status1',
                                                        'paiddate',
                                                        'darkep',
                                                        'namaci',
                                                        'namajk',
                                                        'nama_bagian',
                                                        'nama_kas',
                                                        'data_rsjurnal'
                                                            ));
    }
    public function verkasJson(Request $request)
    {
        $data_rsjurnal = DB::select("SELECT distinct(store) from kasdoc where paid='Y' and verified='N'");
        foreach($data_rsjurnal as $sjurnal)
        {
            $data = DB::select("SELECT docno,verified, store from kasdoc where store='$sjurnal->store' and paid='Y' and verified='N' order by docno asc");
        }

        return datatables()->of($data)
        ->addColumn('docno', function ($data) {
            $action = '<p align="left"><a href="'. route('postingan_kas_bank.verkas',['no' => str_replace('/', '-', $data->docno),'id' => $data->verified]).'"><span class="kt-font-primary pointer-link"  title="" style="cursor:hand">'.$data->docno.'</i></span></a>';
            return $action;
       })
        ->rawColumns(['docno'])
        ->make(true); 
    }

    public function editDetail($no,$id)
    {
        $docno=str_replace('-', '/', $no);
        $data = Kasline::where('docno', $docno)->where('lineno', $id)->get();
        return response()->json($data[0]);
    }
    public function storeDetail(Request $request)
    {
            $docno = $request->kode;	
            $nourut=$request->nourut;
            $rincian = $request->rincian;
            $lapangan = $request->lapangan;
            $sanper = $request->sanper;
            $bagian = $request->bagian;
            $wo = $request->wo;
            $jnsbiaya=$request->jnsbiaya;
            $jumlah = str_replace(',', '.', $request->jumlah);
            $cjudex = $request->cjudex;
            
        $data_objrs = DB::select("SELECT * from kasdoc a where a.docno='$docno'");
        if(!empty($data_objrs)){
            foreach($data_objrs as $objrs)
            {
                if($objrs->posted == "Y"){
                    $data = 2;
                    return response()->json($data);
                } else {
                    
                    Kasline::insert([
                        'docno' => $docno ,
                        'lineno' => $nourut ,
                        'account' => $sanper ,
                        'lokasi' => $lapangan ,
                        'bagian' => $bagian ,
                        'pk' => $wo ,
                        'jb' => $jnsbiaya ,
                        'cj' => $cjudex ,
                        'totprice' => $jumlah ,
                        'keterangan' => $rincian  
                    ]);
                    $data = 1;
                    return response()->json($data);
                }
            }
        }
    }
    public function updateDetail(Request $request)
    {
            $docno = $request->kode;	
            $nourut=$request->nourut;
            $rincian = $request->rincian;
            $lapangan = $request->lapangan;
            $sanper = $request->sanper;
            $bagian = $request->bagian;
            $wo = $request->wo;
            $jnsbiaya=$request->jnsbiaya;
            $jumlah = str_replace(',', '.', $request->jumlah);
            $cjudex = $request->cjudex;
            
        $data_objrs = DB::select("SELECT * from kasdoc a where a.docno='$docno'");
        if(!empty($data_objrs)){
            foreach($data_objrs as $objrs)
            {
                if($objrs->posted == "Y"){
                    $data = 2;
                    return response()->json($data);
                } else {
                    Kasline::where('docno', $docno)
                    ->where('lineno', $nourut)
                    ->update([
                        'keterangan' => $rincian,
                        'lokasi' => $lapangan,
                        'account' => $sanper,
                        'bagian' => $bagian,
                        'pk' => $wo,
                        'jb' => $jnsbiaya,
                        'totprice' => $jumlah,
                        'cj' => $cjudex
                    ]);
                    $data = 1;
                    return response()->json($data);
                }
            }
         }
    }

    public function deleteDetail(Request $request)
    {
        $docno=str_replace('-', '/', $request->no);
        Kasline::where('docno', $docno)->where('lineno', $request->id)->delete();
        return response()->json();
    }

    public function prsposting()
    {
        $data_kas = DB::select("SELECT distinct(store) as store,(select namabank from storejk where kodestore=store) as bank,(select jeniskartu from storejk where kodestore=store) as jk from kasdoc where verified='Y' and posted='N'");
        return view('posting_kas_bank.prsposting',compact('data_kas'));
    }
    public function storePrsposting(Request $request)
    {
        $data_rsbulan = DB::select("SELECT max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($data_rsbulan)){
            foreach($data_rsbulan as $data)
            {
                $thnblopen3 = vf($data->thnbln);
            }
        } else {
            $thnblopen3 = "";
        }
        $nokas = $request->nokas;
        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;
        $tgl = date_create($request->tanggal);
        $tahunbulan1 = date_format($tgl, 'Ym');
        $tgl2 = date_create($request->tanggal2);
        $tahunbulan2 = date_format($tgl2, 'Ym');
        $tabulasli = $thnblopen3;
        
        if(($tahunbulan1 <> $tabulasli) or ($tahunbulan1 <> $tabulasli)){
            $data = 2;
            return response()->json($data);
        } else {
            $data_cekposting = DB::select("SELECT * from kasdoc where paiddate between '$tanggal' and '$tanggal2' and posted <>'Y' and verified='Y' and store='$nokas'");
            if(!empty($data_cekposting)){
                $data_kitaposting = DB::select("SELECT * from kasdoc where store='$nokas' and verified='Y' and posted <> 'Y' and paiddate between '$tanggal' and '$tanggal2'");
                foreach($data_kitaposting as $data_kit)
                { 
                    $docno = $data_kit->docno;
                    $verifieddate = date('Y-m-d H:i:s');
                    $pk = date('mY');
                    $data_kas = DB::select("SELECT ltrim(to_char(paiddate,'yyyymm')) as v_thnbln,thnbln as v_thnbln_b from kasdoc where docno='$docno'");
                    foreach($data_kas as $data_ka)
                    {
                        if($data_ka->v_thnbln<>$data_ka->v_thnbln_b){
                            $data = 3;
                            return response()->json($data);
                        } else {
                            
                            $data_crdoc = DB::select("SELECT * from kasdoc where docno='$docno'");
                            $ada = false;
                            foreach($data_crdoc as $d)
                            {
                                $crstore_jk = DB::select("SELECT * from storejk s where s.kodestore='$d->store' and  s.jeniskartu='$d->jk'");
                                foreach($crstore_jk as $j)
                                {
                                    $ada = true;
                                    $data_crline = DB::select("SELECT max(lineno) as jum,coalesce(sum(totprice),0) as total from kasline where docno='$docno'");
                                    if(!empty($data_crline)){
                                        foreach($data_crline as $n)
                                        {
                                            $sno = $n->jum+1;
                                            $nilaitot = -$n->total;
                                        }
                                    } else {
                                            $sno = 1;
                                            $nilaitot = 0;
                                    }
                                    Kasline::where('docno', $docno)
                                    ->where('penutup', 'Y')->delete();
                                    Kasline::insert([
                                        'docno' => $docno ,
                                        'totprice' => $nilaitot ,
                                        'voucher' => $d->voucher,
                                        'lineno' => $sno ,
                                        'account' => $j->account , 
                                        'area' => $j->area , 
                                        'lokasi' => $j->lokasi , 
                                        'bagian' => $j->bagian ,
                                        'verified' => 'Y',
                                        'verifieddate' => $verifieddate ,
                                        'pk' => $pk ,
                                        'jb' => $j->jenisbiaya , 
                                        'keterangan' => 'PENUTUP' ,
                                        'cj' => '99' ,
                                        'penutup' => 'Y' ,
                                        'pau' => 'N' 
                                    ]);
                                }
                            }
                            if(!($ada)){
                                $data = 4;
                                return response()->json($data);
                                // raise exception '~~lokasi jk dan bank tidak sesuai';
                            }


                        $dat_crdoc = DB::select("SELECT * from kasdoc where docno='$docno'");
                            foreach($dat_crdoc as $dd)
                            {
                                $tahun = substr($dd->thnbln,0,4);
                                $bulan = substr($dd->thnbln,4); 
                                Fiosd201::where('docno', $docno)
                                ->where('jk', $dd->jk)
                                ->where('tahun',$tahun)
                                ->where('bulan', $bulan)->delete();
                                
                                $dat_crline = DB::select("SELECT * from kasline where docno='$docno'");
                                foreach($dat_crline as $ll)
                                {
                                    $account = substr($ll->account,0,3);
                                    if($dd->ci == '2'){
                                        if($account == '178'){ //--- item transaksi dengan rate pajak
                                            $vrate = $dd->rate_pajak;
                                        } else {
                                            $vrate = $dd->rate;
                                        }
                                            $v_rp = $ll->totprice*$vrate;
                                            $v_dl = $ll->totprice;
                                    } else {
                                        $vrate = 1;               //--- item transaksi dengan rate transaksi biasa
                                        $v_rp  = $ll->totprice;
                                        $v_dl  = 0;
                                    }
                                    Fiosd201::insert([
                                        'tahun' => $tahun, 
                                        'bulan' => $bulan , 
                                        'supbln' => '0',  
                                        'jk' => $dd->jk,  
                                        'vc' => $dd->voucher, 
                                        'store' => $dd->store, 
                                        'docno' => $ll->docno , 
                                        'lineno' => $ll->lineno, 
                                        'account' => $ll->account, 
                                        'area' => $ll->area, 
                                        'lokasi' => $ll->lokasi, 
                                        'bagian' => $ll->bagian, 
                                        'wono' => $ll->pk, 
                                        'jb' => $ll->jb, 
                                        'totprice' => $ll->totprice, 
                                        'keterangan' => $ll->keterangan, 
                                        'ci' => $dd->ci, 
                                        'rate' => $vrate, 
                                        'rate_pajak' => round($dd->rate_pajak),
                                        'rate_trans' => round($dd->rate),
                                        'cj' => $ll->cj,
                                        'totpricerp' => $v_rp,
                                        'totpricedl' => $v_dl 
                                    ]);
                                }
                            }
                        }
                    }
                    $userid = Auth::user()->userid;
                    $posteddate = date('Y-m-d H:i:s');
                    Kasdoc::where('docno', $docno)
                    ->update([
                        'posted' => 'Y',
                        'postedby' => $userid,
                        'posteddate' => $posteddate
                    ]);	
                }
                $data = 1;
                return response()->json($data);
            } else { 
                $data = 5;
                return response()->json($data);
            }
        }
    }

    public function btlposting()
    {
        $data_kas = DB::select("SELECT distinct(store),(select namabank from storejk where kodestore=store) as bank,(select jeniskartu from storejk where kodestore = store) as jk from kasdoc where verified='Y' and posted='Y'");
        return view('posting_kas_bank.btlposting',compact('data_kas'));
    }
    public function storeBtlposting(Request $request)
    {
        $data_rsbulan = DB::select("SELECT max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($data_rsbulan)){
            foreach($data_rsbulan as $data)
            {
                $thnblopen3 = vf($data->thnbln);
            }
        } else {
            $thnblopen3 = "";
        }
        $nokas = $request->nokas;
        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;
        $tgl = date_create($request->tanggal);
        $tahunbulan1 = date_format($tgl, 'Ym');
        $tgl2 = date_create($request->tanggal2);
        $tahunbulan2 = date_format($tgl2, 'Ym');
        $tabulasli = $thnblopen3;

        if(($tahunbulan1 <> $tabulasli) or ($tahunbulan1 <> $tabulasli)){
            $data = 2;
            return response()->json($data);
        } else {
            $data_kitabatal = DB::select("SELECT * from kasdoc where store='$nokas' and posted='Y' and paiddate between '$tanggal' and '$tanggal2'");
            if(!empty($data_kitabatal)){ 
                foreach($data_kitabatal as $kitabatal)
                {
                    $docno = $kitabatal->docno;
                    $data_cr = DB::select("SELECT thnbln from kasdoc where docno='$docno'");
                        foreach($data_cr as $t)
                        {
                            $tahun = substr($t->thnbln,0,4);
                            $bulan = substr($t->thnbln,4); 
                            Fiosd201::where('docno', $docno)
                                ->where('tahun',$tahun)
                                ->where('bulan', $bulan)->delete();
                            Kasline::where('docno', $docno)
                                ->where('penutup', 'Y')->delete();
                        }
                    $userid = Auth::user()->userid;
                    $posteddate = date('Y-m-d H:i:s');
                    Kasdoc::where('docno', $docno)
                    ->update([
                        'posted' => 'N',
                        'postedby' => $userid,
                        'posteddate' => $posteddate
                    ]);	
                }
                $data = 1;
                return response()->json($data);
            } else {
                $data = 3;
                return response()->json($data);
            }
        }
    }


    public function verifikasi(Request $request)
    {
        if($request->status1 <>"N"){
            $status1 = $request->status1;
            $docno = $request->mp.'/'.$request->bagian.'/'.$request->nomor;

            Kasdoc::where('docno', $docno)
                    ->update([
                        'verified' => 'Y',
                        'verifieddate' => $request->tanggal
                    ]);
                    $data = 1;
                    return response()->json($data);
        } else {
            $status1 = $request->status1;
            $docno = $request->mp.'/'.$request->bagian.'/'.$request->nomor;
        
            $datacek = DB::select("SELECT * from kasdoc a where a.docno='$docno'");
            if(!empty($datacek)){
                foreach($datacek as $datac)
                {
                    if($datac->posted == "Y"){
                        $data = 2;
                        return response()->json($data);
                    } else {
                        Kasdoc::where('docno', $docno)
                        ->update([
                            'verified' => 'N',
                            'verifieddate' => $request->tanggal
                        ]);
                        $data = 3;
                        return response()->json($data);
                    }
                }
            } else {
                Kasdoc::where('docno', $docno)
                ->update([
                    'verified' => 'N',
                    'verifieddate' => $request->tanggal
                ]);
                $data = 4;
                return response()->json($data);
            }
        }

    }
}
