<?php

namespace App\Http\Controllers\Kontroler;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Fiosd201;
use App\Models\JurumDoc;
use App\Models\JurumLine;
use Auth;
use DB;
use DomPDF as GlobalDomPDF;
use Illuminate\Http\Request;

class JurnalUmumController extends Controller
{
    public function index()
    {
        $data_tahunbulan = DB::select("select max(thnbln) as bulan_buku from bulankontroller where status='1' and length(thnbln)='6'");
            if(!empty($data_tahunbulan)) {
                foreach ($data_tahunbulan as $data_bul) {
                    $tahun = substr($data_bul->bulan_buku,0,-2); 
                    $bulan = substr($data_bul->bulan_buku,4); 
                }
            }else{
                $bulan ='00';
                $tahun ='0000';
            }
        return view('modul-kontroler.jurnal-umum.index',compact('tahun','bulan'));
    }

    public function indexJson(Request $request)
    {
        $rsbulan = DB::select("select max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        
        if(!empty($rsbulan)){
            foreach($rsbulan as $dat)
            {
                if(is_null($dat->thnbln)){
                    $thnblopen2 = "";
                }else{
                    $thnblopen2 = $dat->thnbln;
                }
            }
        }else{
            $thnblopen2 = "";
        }

        if($request->bulan<>"" and $request->tahun<>""){
            $data = DB::select("select  docno, keterangan, jk, store, voucher, posted from jurumdoc  where thnbln ='$request->tahun$request->bulan' order by voucher");
        }else{
            $data = DB::select("select  docno, keterangan, jk, store, voucher, posted from jurumdoc  where thnbln ='$thnblopen2' order by voucher");
        }

        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" docno="'. str_replace('/', '-', $data->docno).'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->addColumn('action', function ($data) {
            if(Auth::user()->userid <> 'PWC'){
                $action = '<a href="'. route('modul_kontroler.jurnal_umum.copy',['no' => str_replace('/', '-', $data->docno)]).'"><span><i class="fas fa-2x fa-paste text-primary"></i></span></a>';
            }else{
                $action = '<span><i class="fas fa-2x fa-paste text-success"></i></span>';
            }               
            return $action;
        })
        ->rawColumns(['action','radio'])
        ->make(true); 
    }

    public function create()
    {
        $rsbulan = DB::select("select max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($rsbulan)){
            foreach($rsbulan as $dat)
            {
                if(is_null($dat->thnbln)){
                    $thnblopen2 = "";
                }else{
                    $thnblopen2 = $dat->thnbln;
                }
            }
        }else{
            $thnblopen2 = "";
        }

        $mp = "J";
        $s = $thnblopen2;
        if($s == ""){
            Alert::info("Bulan buku tidak ada atau sudah di posting", 'Failed')->persistent(true);
            return redirect()->route('modul-kontroler.jurnal-umum.create');
        }else{  
            $thnbln = $s;
            $suplesi = 0; 
            $tahun = substr($s,0,-2); 
            $bulan = substr($s,4); 
        }

        $rate = "1";
        $nama_ci = "1.Rp";
        $bagian = "B3000";
        $nama_bagian = "KONTROLER";
            $carinomor = DB::select("select max(substr(docno,13,3)) as id from jurumdoc where substr(docno,3,5)='B3000' and thnbln='$thnbln' and substr(docno,1,1)='J'");
            if(!empty($carinomor)){
                foreach($carinomor as $cari)
                {
                    $id = sprintf("%03s", abs(vf($cari->id) + 1));
                    $nobukti='AA'.$id;
                    $nomor = substr($tahun,2,2).''.$bulan.''.$id;
                }
            }else{
                $nobukti = "AA001";
                $nomor = substr($tahun,2,2).''.$bulan.'001';
            }
        return view('modul-kontroler.jurnal-umum.create',compact(
        'mp',
        'rate',
        'nama_ci',
        'bagian',
        'nama_bagian',
        'suplesi',
        'nobukti',
        'nomor',
        'tahun',
        'bulan' 
        ));
    }

    public function store(Request $request)
    {
        $userid = $request->userid;
        $mp = $request->mp;
        $nomor = $request->nomor;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $suplesi = $request->suplesi;
        $bagian = $request->bagian;
        $jk = $request->jk;
        $kurs = $request->kurs;
        $ci = $request->ci;
        $nokas = $request->nokas;
        $nobukti = $request->nobukti;
        $kepada = $request->kepada;
        $scurrdoc = $request->mp.'/'.$request->bagian.'/'.$request->nomor;
        $docno = $scurrdoc;
        $thnbln = $tahun.''.$bulan;
        $tanggal = $request->tanggal;
        
        $data_cek = DB::select("select a.* from jurumdoc a where a.docno='$docno'");	 
        if(!empty($data_cek)){
            $data = 0;
            return response()->json($data);
        }else{
            JurumDoc::insert([
                            'docno' => $docno,
                            'thnbln' => $thnbln,
                            'jk' => $jk,
                            'suplesi' => $suplesi,
                            'store' => $nokas,
                            'keterangan' => $kepada,
                            'ci' => $ci,
                            'rate' => $kurs,
                            'posted' => 'N',
                            'inputid' => $userid,
                            'inputdate' => $tanggal,
                            'voucher' => $nobukti
                ]);
                $data = 1;
                return response()->json($data);
        }

    }

    public function edit($no)
    {
            $docno = str_replace('-', '/', $no);
            $data_jur =  DB::select("select docno, left(docno,1) mp, substr(docno, 3, 5) bagian, substr(docno,9) nomor, 
                                    thnbln, right(thnbln,2) bulan,  left(thnbln, 4) tahun,jk,suplesi,store,keterangan,ci,rate,
                                    debet,kredit,voucher,posted, (select a.nama from sdm_tbl_kdbag a where a.kode=substr(docno, 3, 5)) nama_bagian
                                    from jurumdoc where docno='$docno'");        
            $data_detail = DB::select("select * from jurumline where docno= '$docno' order by lineno");
            $data_no = DB::select("select max(lineno) as nu from jurumline where docno='$docno'");
            if(!empty($data_no)){
                foreach($data_no as $no)
                {
                    $nu = $no->nu+1;
                }
            }else{
                $nu=1;
            }  
            $data_lapang = DB::select("select kodelokasi,nama from lokasi");
            $data_sandi = DB::select("select kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct");
            $data_bagian = DB::select("select kode,nama from sdm_tbl_kdbag order by kode");
            $data_jenis = DB::select("select kode,keterangan from jenisbiaya order by kode");
            $sum = DB::select("select sum(debet - kredit) as tot from jurumline where docno='$docno'");
               
                   if(!empty($sum)){
                        foreach($sum as $data_sum)
                        {
                            $jumlahnya = $data_sum->tot;
                            if($data_sum->tot < 0 ){
                                $lab2 = "CR";
                            }elseif($data_sum->tot > 0){
                                $lab2 = "DR";
                            }else{
                                $lab2 = "";
                            }
                        }
                   }else{
                        $jumlahnya = 0;
                   }

           return view('modul-kontroler.jurnal-umum.edit',compact('data_jur','data_detail','nu','data_lapang','data_sandi','data_bagian','data_jenis','jumlahnya','lab2'));
    }
    public function update(Request $request)
    {
        $docno = $request->docno;
        $suplesi = $request->suplesi;
        $jk = $request->jk;
        $rate = $request->kurs;
        $ci = $request->ci;
        $nokas = $request->nokas;
        $nobukti = $request->nobukti;
        $keterangan = $request->kepada;
        $updateid = $request->userid;
        $thnbln = $request->tahun.''.$request->bulan;
        
        if(stbbuku2($thnbln,$suplesi) <> 'gtopening'){ 
            $data = 2;
            return response()->json($data);
        }else{
            $data_rscekjurnal = DB::select("select a.thnbln,a.posted from jurumdoc a where a.docno='$docno'");
            foreach($data_rscekjurnal as $data_cekjur)
            {
                if($data_cekjur->posted == "Y"){
                    $data = 3;
                    return response()->json($data);
                }else{
                    Jurumdoc::where('docno', $docno)
                    ->update([
                        'suplesi' => $suplesi,
                        'jk' => $jk,
                        'store' => $nokas,
                        'keterangan' => $keterangan,
                        'ci' => $ci,
                        'rate' => $rate,
                        'updatedate' => $request->tanggal,
                        'updateid' => $updateid,
                        'voucher' => $nobukti
                    ]);
                    $data = 1;
                    return response()->json($data);
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $docno = str_replace('-', '/', $request->docno);
        $data_rscekjurnal = DB::select("select a.thnbln,a.posted from jurumdoc a where a.docno='$docno'");
        foreach($data_rscekjurnal as $data_cekjur)
        {
            if(stbbuku2($data_cekjur->thnbln,"0") > 'gtopening'){
                $data = 2;
                return response()->json($data);
            }else{
            
                if($data_cekjur->posted == "Y"){
                    $data = 3;
                    return response()->json($data);
                }else{
                    Jurumdoc::where('docno', $docno)->delete();
                    JurumLine::where('docno', $docno)->delete();
                    $data = 1;
                    return response()->json($data);
                }
            }
        }
    }

    public function storeDetail(Request $request)
    {
        $docno=$request->kode;
        $nourut=$request->nourut;
        $sanper =$request->sanper;
        $lapangan =$request->lapangan;
        $bagian =$request->bagian;
        $wo =$request->wo;
        $jnsbiaya= $request->jnsbiaya;
        $rincian =$request->rincian;

        if($request->rate == ""){
            $data_carirate = DB::select("select rate from jurumdoc where docno='$docno'");
            if(!empty($data_carirate)){
                foreach($data_carirate as $data_car)
                {
                    $rate = $data_car->rate;
                }
            }else{
                $rate = "1";
            }
        }else{
            $rate = $request->rate;
        }

        if($request->debet == ""){
            $debet="0"; 
        }else{
            $debet= $request->debet; 
        }
        if($request->kredit == ""){
            $kredit="0"; 
        }else{
            $kredit= $request->kredit; 
        }

        $data_jurum = DB::select("select * from jurumline where docno='$docno' and lineno='$nourut'");
	  if(!empty($data_jurum)){
        $data = 2;
        return response()->json($data);
      }else{ 
            $data_coun = DB::select("select * from account where kodeacct='$sanper'");
            if(!empty($data_coun)){

                Jurumline::insert([
                    'docno' => $docno,
                    'lineno' => $nourut,
                    'account' => $sanper,
                    'lokasi' => $lapangan,
                    'bagian' => $bagian,
                    'pk' => $wo,
                    'jb' => $jnsbiaya,
                    'rate' => $rate,
                    'keterangan' => $rincian,
                    'inputdate' => $request->tanggal,
                    'debet' => $debet,
                    'kredit' => $kredit 
                ]);
                $data = 1;
                return response()->json($data);
            }else{
                $data = 3;
                return response()->json($data);
            }
	  }	
    }

    public function editDetail($no,$id)
    {
        $docno=str_replace('-', '/', $no);
        $data = Jurumline::where('docno', $docno)->where('lineno', $id)->get();
        return response()->json($data[0]);
    }
    public function updateDetail(Request $request)
    {
        $lineno=$request->nourut;
        $docno=$request->kode;
        $nourut=$request->nourut;
        $sanper =$request->sanper;
        $lapangan =$request->lapangan;
        $bagian =$request->bagian;
        $wo =$request->wo;
        $jnsbiaya= $request->jnsbiaya;
        $rate = $request->rate;
        $rincian =$request->rincian;
        $debet =$request->debet;
        $kredit =$request->kredit;
        Jurumline::where('docno', $docno)->where('lineno', $lineno)
        ->update([
            'docno' => $docno,
            'lineno' => $nourut,
            'account' => $sanper,
            'lokasi' => $lapangan,
            'bagian' => $bagian,
            'pk' => $wo,
            'jb' => $jnsbiaya,
            'rate' => $rate,
            'keterangan' => $rincian,
            'updatedate' => $request->tanggal,
            'debet' => $debet,
            'kredit' => $kredit 
        ]);
        return response()->json();
    }
    public function deleteDetail(Request $request)
    {
        $docno=str_replace('-', '/', $request->no);
        Jurumline::where('docno', $docno)->where('lineno', $request->id)->delete();
        return response()->json();
    }


    public function posting($no, $status)
    {
        return view('modul-kontroler.jurnal-umum.posting',compact('no','status'));
    }
    public function storePosting(Request $request)
    {
        $data_rsbulan = DB::select("select max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($data_rsbulan)){
            foreach($data_rsbulan as $data_rs)
            {
                if(is_null($data_rs)){
                    $thnblopen3 = '0';
                }else{
                    $thnblopen3 = trim($data_rs->thnbln);
                }
            }
        }else{
            $thnblopen3 = "";
        }
        $docno = str_replace('-', '/', $request->docno);
        
        $data_cekbulbuk = DB::select("select * from jurumdoc where docno='$docno'");
        foreach($data_cekbulbuk as $data_cekbuk)
        {
            $bulbuk = $data_cekbuk->thnbln;
        }
        
        if($bulbuk <> $thnblopen3){
            Alert::info('Proses Posting Jurnal Gagal, Bulan Buku Aktif: '.$bulbuk, 'Info')->persistent(true);
            return redirect()->route('modul-kontroler.jurnal-umum.edit', ['no' => $request->docno]);
        }else{
            if($request->status =="N"){
                $data_cekdetail = DB::select("select (sum(debet) - sum(kredit)) as total from jurumline where docno='$docno'");
                foreach($data_cekdetail as $data_cekde)
                {
                    $cekdetail = $data_cekde->total;
                }
                if($cekdetail == "0"){
                    $data_crdoc = DB::select("select * from jurumdoc where docno='$docno'");
                    $data_crline = DB::select("select * from jurumline where docno='$docno'");

                    foreach($data_crdoc as $d)
                    {
                        $tahun = substr($d->thnbln,0,4);
                        $bulan = substr($d->thnbln,4); 
                        Fiosd201::where('docno', $docno)
                        ->where('jk', $d->jk)
                        ->where('tahun', $tahun)
                        ->where('bulan', $bulan)->delete();

                        foreach($data_crline as $l)
                        {
                            if($d->ci=='2'){
                                $totpricerp = $l->rate*($l->debet-$l->kredit);
                            }else{
                                $totpricerp = $l->debet-$l->kredit;
                            };

                            if($d->ci=='2'){
                                $totpricedl = $l->debet-$l->kredit;
                            }else{
                                $totpricedl = '0';
                            }

                            Fiosd201::insert([
                                'tahun' => $tahun ,
                                'bulan' => $bulan ,
                                'supbln' => $d->suplesi ,
                                'jk' => $d->jk ,
                                'store' => $d->store ,
                                'account' => $l->account ,
                                'bagian' => $l->bagian , 
                                'vc' => $d->voucher ,  
                                'ci' => $d->ci ,
                                'area' => '0' ,  
                                'lokasi' => $l->lokasi ,
                                'wono' => $l->pk ,  
                                'cj' => '00' ,   
                                'jb' => '000' ,
                                'totprice' => ($l->debet-$l->kredit) ,  
                                'rate' => $l->rate , 
                                'docno' => $docno ,  
                                'keterangan' => $l->keterangan ,  
                                'lineno' => $l->lineno ,     
                                'docdate' => $d->posteddate ,
                                'rate_pajak' => '0.00' ,
                                'rate_trans' => $l->rate, 
                                'totpricerp' => $totpricerp,
                                'totpricedl' => $totpricedl 
                            ]);
                        }
                    }
                    $posteddate = date('Y-m-d H:i:s');
                    Jurumdoc::where('docno', $docno)
                    ->update([
                        'posted' => 'Y',
                        'posteddate' => $posteddate,
                        'postid' => $request->userid,
                        'postedid' => $request->userid,
                    ]);
                    Alert::success('Data Berhasil Diposting', 'Berhasil')->persistent(true);
                    return redirect()->route('modul-kontroler.jurnal-umum.edit', ['no' => $request->docno]);
                }else{
                    Alert::info('Posting Gagal, Debet Kredit Tidak Balance', 'Info')->persistent(true);
                    return redirect()->route('modul-kontroler.jurnal-umum.edit', ['no' => $request->docno]);
                }
            }else{
                Fiosd201::where('docno', $docno)->delete();
                Jurumdoc::where('docno', $docno)
                    ->update([
                        'posted' => 'N',
                        'postid' => null,
                        'postedid' => null,
                        'posteddate' => null,
                    ]);
                    Alert::success('Data Posting Berhasil Dibatalkan', 'Berhasil')->persistent(true);
                    return redirect()->route('modul-kontroler.jurnal-umum.edit', ['no' => $request->docno]);
            }
        }
    }

    public function copy($no)
    {
        $docno = str_replace('-', '/', $no);
        return view('modul-kontroler.jurnal-umum.copy',compact('docno'));
    }
    public function storeCopy(Request $request)
    {
        $rsbulan = DB::select("select max(thnbln) as thnbln from bulankontroller where status='1' and length(thnbln)=6");
        if(!empty($rsbulan)){
            foreach($rsbulan as $dat)
            {
                if(is_null($dat->thnbln)){
                    $thnblopen2 = "";
                }else{
                    $thnblopen2 = $dat->thnbln;
                }
            }
        }else{
            $thnblopen2 = "";
        }
        $mp = "J";
        $s = $thnblopen2;
        $tahun = substr($s,0,-2); 
        $bulan = substr($s,4);   
        $rate = "1";
        $nama_ci = "1.Rp";
        $bagian = "B3000";
        $nama_bagian = "KONTROLER";
        $carinomor = DB::select("select max(substr(docno,13,3)) as id from jurumdoc where substr(docno,3,5)='B3000' and thnbln='$thnblopen2' and substr(docno,1,1)='J'");
            if(!empty($carinomor)){
                foreach($carinomor as $cari)
                {
                    $id = sprintf("%03s", abs(vf($cari->id) + 1));
                    $nobukti='AA'.$id;
                    $nomor = substr($tahun,2,2).''.$bulan.''.$id;
                }
            }else{
                $nobukti = "AA001";
                $nomor = substr($tahun,2,2).''.$bulan.'001';
            }    
        $docnobaru = $mp.'/'.$bagian.'/'.$nomor;
        $docno = $request->docno;
        $inputdate = date('Y-m-d H:i:s');

        $data_crawal = DB::select("select * from jurumdoc where docno='$docno'");
        $data_crawaldet = DB::select("select * from jurumline where docno='$docno' order by lineno");
        foreach($data_crawal as $t)
        {
            Jurumdoc::insert([
                'docno' => $docnobaru ,
                'thnbln' => $thnblopen2 ,
                'jk' => $t->jk ,
                'suplesi' => '0' ,
                'store' => $t->store ,
                'keterangan' => $t->keterangan ,
                'ci' => $t->ci ,
                'rate' => $t->rate ,
                'posted' => 'N' ,
                'voucher' => $nobukti ,
                'kepada' => $t->kepada ,
                'inputdate' => $inputdate ,
                'inputid' => $request->userid 
            ]);
            foreach($data_crawaldet as $d){
                Jurumline::insert([
                    'docno' => $docnobaru ,
                    'lineno' => $d->lineno ,
                    'account' => $d->account ,
                    'lokasi' => $d->lokasi ,
                    'bagian' => $d->bagian ,
                    'pk' => $d->pk ,
                    'jb' => $d->jb ,
                    'rate' => $d->rate ,
                    'keterangan' => $d->keterangan ,
                    'debet' => $d->debet ,
                    'kredit' => $d->kredit  
                ]);
            }
        }
        Alert::success('Copy Jurnal', 'Berhasil')->persistent(true);
        return redirect()->route('modul-kontroler.jurnal-umum.index');
    }

    public function rekap($docno)
    {
        $dibuat ="WASONO H";
        $diperiksa="WASONO H";
        $disetujui="WASONO H";
        return view('modul-kontroler.jurnal-umum.rekap',compact(
            'docno',
            'dibuat',
            'diperiksa',
            'disetujui'
        ));
    }

    public function export(Request $request)
    {
            $docno = str_replace('-', '/', $request->docno);   
            $data_list= DB::select("select right(a.thnbln,2) bulan,  left(a.thnbln, 4) tahun,a.jk as jka,a.ci as cia,a.voucher as vouchera,a.keterangan, b.* from jurumdoc a join jurumline b on a.docno=b.docno where a.docno='$docno'");
        if(!empty($data_list)){
            foreach($data_list as $dataa)
            {
                $jk = $dataa->jka;
                $ci = $dataa->cia;
                $voucher = $dataa->vouchera;
                $docno = $dataa->docno;
                $bulan = $dataa->bulan;
                $tahun = $dataa->tahun;
            }
            $pdf = GlobalDomPDF::loadview('modul-kontroler.jurnal-umum.export',compact('request','data_list','jk','ci','voucher','docno','bulan','tahun'))->setPaper('letter', 'landscape');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
        
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(105, 75, "{PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        }else{
            Alert::info("Tidak ditemukan data", 'Failed')->persistent(true);
            return redirect()->route('modul-kontroler.jurnal-umum.index');
        }
    }
}
