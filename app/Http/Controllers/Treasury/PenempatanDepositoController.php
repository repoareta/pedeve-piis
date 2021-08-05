<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\DtlDepositoTest;
use App\Models\Kasline;
use App\Models\MtrDeposito;
use App\Models\PenempatanDepo;
use DB;
use DomPDF;
use Illuminate\Http\Request;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class PenempatanDepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_akses = DB::table('usermenu')->where('userid', auth()->user()->userid)->where('menuid', 509)->first();

        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                $bulan = substr($data_bul->bulan_buku, 4, 2);
                $tahun = substr($data_bul->bulan_buku, 0, 4);
            }
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }

        return view('modul-treasury.penempatan-deposito.index', compact('tahun', 'bulan', 'data_akses'));
    }

    public function indexJson(Request $request)
    {        
            $bulan = ltrim($request->bulan, '0');
            $tahun = $request->tahun;
            if($bulan <> "" and $tahun <> ""){
                $data = DB::select("SELECT a.kurs,a.docno,a.lineno,a.noseri,a.nominal,a.tgldep,a.tgltempo,a.perpanjangan,EXTRACT(day from tgltempo)-EXTRACT(day from date(now())) selhari,EXTRACT(month from tgltempo)-EXTRACT(month from date(now())) selbulan,EXTRACT(year from tgltempo)-EXTRACT(year from date(now())) seltahun,b.haribunga,a.bungatahun,b.bungabulan,b.pph20,b.netbulan,a.asal,a.kdbank,a.keterangan,b.accharibunga,b.accbungabulan,b.accpph20,b.accnetbulan,b.bulan,b.tahun,c.descacct as namabank from mtrdeposito a join account c on a.kdbank=c.kodeacct,dtldepositotest b where a.proses = 'Y' and b.docno=a.docno and a.lineno=b.lineno and a.perpanjangan=b.perpanjangan and b.bulan='$bulan' and b.tahun='$tahun' order by a.tgltempo asc");
            }elseif($bulan == "" and $tahun <> ""){ 
                $data = DB::select("SELECT a.kurs,a.docno,a.lineno,a.noseri,a.nominal,a.tgldep,a.tgltempo,a.perpanjangan,EXTRACT(day from tgltempo)-EXTRACT(day from date(now())) selhari,EXTRACT(month from tgltempo)-EXTRACT(month from date(now())) selbulan,EXTRACT(year from tgltempo)-EXTRACT(year from date(now())) seltahun,b.haribunga,a.bungatahun,b.bungabulan,b.pph20,b.netbulan,a.asal,a.kdbank,a.keterangan,b.accharibunga,b.accbungabulan,b.accpph20,b.accnetbulan,b.bulan,b.tahun,c.descacct as namabank from mtrdeposito a join account c on a.kdbank=c.kodeacct,dtldepositotest b where a.proses = 'Y' and b.docno=a.docno and a.lineno=b.lineno and a.perpanjangan=b.perpanjangan and b.tahun='$tahun' order by a.tgltempo asc" );				    
            } else {
                $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
                if(!empty($data_tahunbulan)){
                    foreach($data_tahunbulan as $data_bul)
                    {
                        $bulan_buku = $data_bul->bulan_buku;
                    }
                } else {
                    $tgl = now();
                    $tanggal = date_format($tgl, 'Ym');
                    $bulan_buku = $tanggal;
                }
                $tahuns = substr($bulan_buku,0,-2);
                $bulans = ltrim(substr($bulan_buku,4), '0');

                $data = DB::select("SELECT a.kurs,a.docno,a.lineno,a.noseri,a.nominal,a.tgldep,a.tgltempo,a.perpanjangan,EXTRACT(day from tgltempo)-EXTRACT(day from date(now())) selhari,EXTRACT(month from tgltempo)-EXTRACT(month from date(now())) selbulan,EXTRACT(year from tgltempo)-EXTRACT(year from date(now())) seltahun,b.haribunga,a.bungatahun,b.bungabulan,b.pph20,b.netbulan,a.asal,a.kdbank,a.keterangan,b.accharibunga,b.accbungabulan,b.accpph20,b.accnetbulan,b.bulan,b.tahun,c.descacct as namabank from mtrdeposito a join account c on a.kdbank=c.kodeacct,dtldepositotest b where a.proses = 'Y' and b.docno=a.docno and a.lineno=b.lineno and a.perpanjangan=b.perpanjangan and b.bulan='$bulans' and b.tahun='$tahuns' order by a.tgltempo asc");
            }
                return datatables()->of($data)
                
                ->addColumn('warna', function ($data) {
                        $temp = date_create($data->tgltempo);
                        $tgltempo = date_format($temp, 'Y-m-d');
                    if(($data->selhari <= 2) and ($data->selhari > 0) and  ($data->selbulan == 0) and ($data->seltahun == 0)){
                        return 1;
                    }elseif($tgltempo <= date('Y-m-d')){
                        return 2;
                    } else {
                        return 3;
                    }
                })
                ->addColumn('noseri', function ($data) {
                    return $data->noseri;
                })
                ->addColumn('namabank', function ($data) {
                    return $data->namabank;
                })
                ->addColumn('rate', function ($data) {

                return number_format($data->kurs,0) == 0 ? number_format(1,2) : number_format($data->kurs,2);
                })
                ->addColumn('nominal', function ($data) {
                    return number_format($data->nominal,2,'.',',');
                })
                ->addColumn('tgldep', function ($data) {
                    $tgl = date_create($data->tgldep);
                    return date_format($tgl, 'd/m/Y');
                })
                ->addColumn('tgltempo', function ($data) {
                    $tgl = date_create($data->tgltempo);
                    return date_format($tgl, 'd/m/Y');
                })
                ->addColumn('haribunga', function ($data) {
                    return $data->haribunga;
                })
                ->addColumn('bungatahun', function ($data) {
                    return number_format($data->bungatahun,2,'.',',');
                })
                ->addColumn('bungabulan', function ($data) {
                    return number_format($data->bungabulan,2,'.',',');
                })
                ->addColumn('pph20', function ($data) {
                    return number_format($data->pph20,2,'.',',');
                })
                ->addColumn('netbulan', function ($data) {
                    return number_format($data->netbulan,2,'.',',');
                })
                ->addColumn('accharibunga', function ($data) {
                    return $data->accharibunga;
                })
                ->addColumn('accnetbulan', function ($data) {
                    return number_format($data->accnetbulan,2,'.',',');
                })
                ->addColumn('radio', function ($data) {
                    $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" name="btn-radio" nodok="'.$data->docno.'" lineno="'.$data->lineno.'" pjg="'.$data->perpanjangan.'"><span></span></label>'; 
                    return $radio;
                })
                ->rawColumns(['action','radio'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data_dok = DB::select("SELECT a.docno,a.lineno,a.asal,a.nominal,a.kdbank,a.keterangan,b.descacct from mtrdeposito  a join account b on a.kdbank=b.kodeacct where proses='N' order by docno");
        return view('modul-treasury.penempatan-deposito.create', compact('data_dok'));
    }

    public function linenoJson(Request $request)
    {
        $datas = DB::select("SELECT a.docno,a.lineno,a.asal,round(a.nominal,0) as nominal,a.kdbank,a.keterangan,b.descacct from mtrdeposito  a join account b on a.kdbank=b.kodeacct  where a.docno='$request->nodok' and a.lineno='$request->lineno' and proses='N' order by docno");
        return response()->json($datas[0]);
    }

    public function kursJson(Request $request)
    {
        $datas = DB::select("SELECT rate from kasdoc where docno='$request->nodok'");
        return response()->json($datas[0]);
    }

    public function kdbankJson(Request $request)
    {
        $datas = DB::select("SELECT * from mtrdeposito where docno='$request->nodok' and lineno='$request->lineno' and perpanjangan='$request->pjg'");
        return response()->json($datas[0]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docno = $request->nodok;
        $lineno = $request->lineno;
        $asal = $request->asal;
        $kdbank = $request->kdbank;
        $tgldep = $request->tanggal;
        $tgltempo = $request->tanggal2;
        $tahunbunga = str_replace(',', '.', $request->tahunbunga);
        $noseri = $request->noseri;
        $nominal = str_replace(',', '.', $request->nominal);
        $namabank = $request->namabank;
        $perpanjangan = $request->perpanjangan;
        $keterangan = $request->keterangan;
        $kurs = $request->kurs;
        Penempatandepo::insert([
            'docno' => $docno,
            'lineno' => $lineno,
            'tgldepo' => $tgldep,
            'tgltempo' => $tgltempo,
            'bungatahun' => $tahunbunga,
            'asal' => $asal,
            'noseri' => $noseri,
            'nominal' => $nominal,
            'kdbank' => $kdbank,
            'keterangan' => $keterangan,
            'kurs' => $kurs,
            'statcair' =>'N'        
            ]);
            Kasline::where('docno', $docno)
            ->where('lineno', $lineno)
            ->update([
                'inputpwd' => 'Y'
                ]);
            Mtrdeposito::where('docno', $docno)
            ->where('lineno', $lineno)
            ->where('perpanjangan', '0')
            ->update([
                'noseri' => $noseri,
                'tgldep' => $tgldep,
                'tgltempo' => $tgltempo,
                'bungatahun' => $tahunbunga,
                'kurs' => $kurs,
                'proses' => 'Y'
                ]);

            $data_mtrdeposito = DB::select("SELECT * from mtrdeposito where docno='$docno' and lineno='$lineno' and perpanjangan='$perpanjangan'");
            foreach($data_mtrdeposito as $data_mtr)
            {
                $i_proses='T';
                $i_docno=$docno;
                $i_lineno=$lineno;
                $i_panjang=$perpanjangan;
                $kdbank = $data_mtr->kdbank;
            
                if($i_proses == 'T'){
                    $data_kdbank = DB::select("SELECT jenis as v_jenis from account where kodeacct='$kdbank'");
                    foreach($data_kdbank as $data_kdb)
                    {
                        if($data_kdb->v_jenis == 'T'){
                                $v_pembagi = '36000';
                        } else {
                                $v_pembagi = '36500';
                        }
                    }
            
                    $tgltempos = date_create($data_mtr->tgltempo);
                    $tgltempo= date_format($tgltempos, 'm');
            
                    $tgldeps = date_create($data_mtr->tgldep);
                    $tgldep= date_format($tgldeps, 'm');
                    $bulan = ltrim(date_format($tgldeps, 'm'),0);
                    $tahun = date_format($tgldeps, 'Y');
                    $lastday = date('t',strtotime($data_mtr->tgldep));
                    
                    $v_range = $tgltempo - $tgldep;
                    if($v_range < 0 ){
                        $v_rangeok = ($tgltempo+12) - $tgldep;
                    } else {
                        $v_rangeok = $v_range;
                    }
            
                    if($v_rangeok == 0 ){ //bulan sama
                        $v_jumhari = hitunghari($data_mtr->tgldep,$data_mtr->tgltempo);
                        $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20 = round($v_bungabulan * (20/100),2);
                        $v_bunganet = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                    
                        Dtldepositotest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $data_mtr->tgltempo,
                            'accharibunga' => $v_jumhari,
                            'accbungabulan' => $v_bungabulan,
                            'accpph20' => $v_pph20,
                            'accnetbulan' => $v_bunganet,
                            ]);
                    }elseif($v_rangeok == 1){   //bulan beda 1
                        $v_jumhari = hitunghari($data_mtr->tgldep, $data_mtr->tgltempo);
                        $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20  = round($v_bungabulan * (20/100),2);
                        $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                        $v_jumhari2 =hitunghari($data_mtr->tgldep,$lastday);
                        $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph202  = round($v_bungabulan2 * (20/100),2);
                        $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan2 * (20/100)),2);
                        Dtldepositotest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $data_mtr->tgltempo,
                            'accharibunga' => $v_jumhari2,
                            'accbungabulan' => $v_bungabulan2,
                            'accpph20' => $v_pph202,
                            'accnetbulan' => $v_bunganet2,
                            ]);
                    }elseif($v_rangeok > 1){ // jarak bulan > 1
                        $v_tgldepotemp = date_create($data_mtr->tgldep);
                        $bulan = date_format($v_tgldepotemp, 'm');
                        $tahun = date_format($v_tgldepotemp, 'Y');
                        $v_hariakhirtemp =date_format($v_tgldepotemp, 'd');
                        $v_bulanakhirtemp =date_format($v_tgldepotemp, 'm')+1;
                        $v_tahunakhirtemp =date_format($v_tgldepotemp, 'Y');
                        if($v_bulanakhirtemp > 12){
                            $v_bulanakhirtemp =1;
                            $v_tahunakhirtemp = $v_tahunakhirtemp+1;
                        }
                        $v_tglakhir =$v_tahunakhirtemp.'-'.$v_bulanakhirtemp.'-'.$v_hariakhirtemp;
                        $v_hasiltgl = date_create($v_tglakhir);
                        $v_hasiltglakhir =date_format($v_hasiltgl, 'Y-m-d');
                        $v_jumhari =hitunghari($data_mtr->tgldep,$v_hasiltglakhir);
                        $v_bungabulan  = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20  = round($v_bungabulan * (20/100),2);
                        $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                        $v_jumhari2 =hitunghari($v_tgldepotemp,$lastday);
                        $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph202  = round($v_bungabulan2 * (20/100),2);
                        $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan2 * (20/100)),2);
                        Dtldepositotest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $v_hasiltglakhir,
                            'accharibunga' => $v_jumhari2,
                            'accbungabulan' => $v_bungabulan2,
                            'accpph20' => $v_pph202,
                            'accnetbulan' => $v_bunganet2,
                            ]);
                    }
                }
                return response()->json();
            }

    }

    public function edit($id, $lineno, $pjg)
    {
        $nodok = str_replace('-', '/', $id);
        
        $data = DB::table(DB::raw('mtrdeposito as a'))
            ->join(DB::raw('account as b'), DB::raw('a.kdbank'), '=', DB::raw('b.kodeacct'))
            ->where(DB::raw('a.docno'), '=', $nodok)
            ->where('lineno', '=', $lineno)
            ->where('perpanjangan', '=', $pjg)
            ->select(DB::raw('a.*, b.descacct as namabank'))
            ->first();

        return view('modul-treasury.penempatan-deposito.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $docno = $request->nodok;
        $lineno = $request->lineno;
        $asal = $request->asal;
        $kdbank = $request->kdbank;
        $tgldep = $request->tanggal;
        $tgltempo = $request->tanggal2;
        $tahunbunga = str_replace(',', '.', $request->tahunbunga);
        $noseri = $request->noseri;
        $nominal = str_replace(',', '.', $request->nominal);
        $namabank = $request->namabank;
        $perpanjangan = $request->perpanjangan;
        $keterangan = $request->keterangan;
        $kurs = $request->kurs;

        Dtldepositotest::where('docno', $request->nodok)->where('lineno', $request->lineno)->where('perpanjangan', $request->perpanjangan)->delete();

        Penempatandepo::where('docno', $request->nodok)->where('lineno', $request->lineno)
        ->update([
            'tgldepo' =>  $tgldep,
            'tgltempo' =>  $tgltempo,
            'bungatahun' =>  $tahunbunga,
            'asal' =>  $asal,
            'noseri' =>  $noseri,
            'nominal' =>  $nominal,
            'kdbank' =>  $kdbank,
            'keterangan' =>  $keterangan,
            'kurs' =>  $kurs,
            'statcair' =>  'N',
        ]);

        Mtrdeposito::where('docno', $request->nodok)->where('lineno', $request->lineno)->where('perpanjangan', $request->perpanjangan)
        ->update([
            'noseri' =>  $noseri,
            'tgldep' =>  $tgldep,
            'tgltempo' =>  $tgltempo,
            'bungatahun' =>  $tahunbunga,
            'proses' =>  'Y',
        ]);

        $data_mtrdeposito = DB::select("SELECT * from mtrdeposito where docno='$docno' and lineno='$lineno' and perpanjangan='$perpanjangan'");
        foreach ($data_mtrdeposito as $data_mtr) {
            $i_proses = 'T';
            $i_docno = $docno;
            $i_lineno = $lineno;
            $i_panjang = $perpanjangan;
            $kdbank = $data_mtr->kdbank;

            if ($i_proses == 'T') {
                $data_kdbank = DB::select("SELECT jenis as v_jenis from account where kodeacct='$kdbank'");
                foreach ($data_kdbank as $data_kdb) {
                    if ($data_kdb->v_jenis == 'T') {
                        $v_pembagi = '36000';
                    } else {
                        $v_pembagi = '36500';
                    }
                }

                $tgltempos = date_create($data_mtr->tgltempo);
                $tgltempo = date_format($tgltempos, 'm');

                $tgldeps = date_create($data_mtr->tgldep);
                $tgldep = date_format($tgldeps, 'm');
                $bulan = ltrim(date_format($tgldeps, 'm'), 0);
                $tahun = date_format($tgldeps, 'Y');
                $lastday = date('t', strtotime($data_mtr->tgldep));

                $v_range = $tgltempo - $tgldep;
                if ($v_range < 0) {
                    $v_rangeok = ($tgltempo + 12) - $tgldep;
                } else {
                    $v_rangeok = $v_range;
                }

                if ($v_rangeok == 0) { //bulan sama
                    $v_jumhari = hitunghari($data_mtr->tgldep, $data_mtr->tgltempo);
                    $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi, 2);
                    $v_pph20 = round($v_bungabulan * (20 / 100), 2);
                    $v_bunganet = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi) - ($v_bungabulan * (20 / 100)), 2);

                    Dtldepositotest::insert([
                        'docno' => $i_docno,
                        'lineno' => $i_lineno,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'haribunga' => $v_jumhari,
                        'bungabulan' => $v_bungabulan,
                        'pph20' => $v_pph20,
                        'netbulan' => $v_bunganet,
                        'perpanjangan' => $i_panjang,
                        'tglawal' => $data_mtr->tgldep,
                        'tglakhir' => $data_mtr->tgltempo,
                        'accharibunga' => $v_jumhari,
                        'accbungabulan' => $v_bungabulan,
                        'accpph20' => $v_pph20,
                        'accnetbulan' => $v_bunganet,
                    ]);
                } elseif ($v_rangeok == 1) {   //bulan beda 1
                    $v_jumhari = hitunghari($data_mtr->tgldep, $data_mtr->tgltempo);
                    $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi, 2);
                    $v_pph20  = round($v_bungabulan * (20 / 100), 2);
                    $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi) - ($v_bungabulan * (20 / 100)), 2);
                    $v_jumhari2 = hitunghari($data_mtr->tgldep, $lastday);
                    $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun) / $v_pembagi, 2);
                    $v_pph202  = round($v_bungabulan2 * (20 / 100), 2);
                    $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun) / $v_pembagi) - ($v_bungabulan2 * (20 / 100)), 2);
                    Dtldepositotest::insert([
                        'docno' => $i_docno,
                        'lineno' => $i_lineno,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'haribunga' => $v_jumhari,
                        'bungabulan' => $v_bungabulan,
                        'pph20' => $v_pph20,
                        'netbulan' => $v_bunganet,
                        'perpanjangan' => $i_panjang,
                        'tglawal' => $data_mtr->tgldep,
                        'tglakhir' => $data_mtr->tgltempo,
                        'accharibunga' => $v_jumhari2,
                        'accbungabulan' => $v_bungabulan2,
                        'accpph20' => $v_pph202,
                        'accnetbulan' => $v_bunganet2,
                    ]);
                } elseif ($v_rangeok > 1) { // jarak bulan > 1
                    $v_tgldepotemp = date_create($data_mtr->tgldep);
                    $bulan = date_format($v_tgldepotemp, 'm');
                    $tahun = date_format($v_tgldepotemp, 'Y');
                    $v_hariakhirtemp = date_format($v_tgldepotemp, 'd');
                    $v_bulanakhirtemp = date_format($v_tgldepotemp, 'm') + 1;
                    $v_tahunakhirtemp = date_format($v_tgldepotemp, 'Y');
                    if ($v_bulanakhirtemp > 12) {
                        $v_bulanakhirtemp = 1;
                        $v_tahunakhirtemp = $v_tahunakhirtemp + 1;
                    }
                    $v_tglakhir = $v_tahunakhirtemp . '-' . $v_bulanakhirtemp . '-' . $v_hariakhirtemp;
                    $v_hasiltgl = date_create($v_tglakhir);
                    $v_hasiltglakhir = date_format($v_hasiltgl, 'Y-m-d');
                    $v_jumhari = hitunghari($data_mtr->tgldep, $v_hasiltglakhir);
                    $v_bungabulan  = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi, 2);
                    $v_pph20  = round($v_bungabulan * (20 / 100), 2);
                    $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun) / $v_pembagi) - ($v_bungabulan * (20 / 100)), 2);
                    $v_jumhari2 = hitunghari($data_mtr->tgldep, $lastday);
                    $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun) / $v_pembagi, 2);
                    $v_pph202  = round($v_bungabulan2 * (20 / 100), 2);
                    $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun) / $v_pembagi) - ($v_bungabulan2 * (20 / 100)), 2);
                    Dtldepositotest::insert([
                        'docno' => $i_docno,
                        'lineno' => $i_lineno,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'haribunga' => $v_jumhari,
                        'bungabulan' => $v_bungabulan,
                        'pph20' => $v_pph20,
                        'netbulan' => $v_bunganet,
                        'perpanjangan' => $i_panjang,
                        'tglawal' => $data_mtr->tgldep,
                        'tglakhir' => $v_hasiltglakhir,
                        'accharibunga' => $v_jumhari2,
                        'accbungabulan' => $v_bungabulan2,
                        'accpph20' => $v_pph202,
                        'accnetbulan' => $v_bunganet2,
                    ]);
                }
            }
            return response()->json();
        }
    }

    public function delete(Request $request)
    {
        $nodok = str_replace('-', '/', $request->nodok);

        Dtldepositotest::where('docno', $nodok)->where('lineno', $request->lineno)->where('perpanjangan', $request->pjg)->delete();
        Mtrdeposito::where('docno', $nodok)->where('lineno', $request->lineno)->where('perpanjangan', $request->pjg)->delete();
        PenempatanDepo::where('docno', $nodok)->where('lineno', $request->lineno)->delete();
        Kasline::where('docno', $nodok)->where('lineno', $request->lineno)
        ->update([
            'inputpwd' =>  'N',
        ]);
        return response()->json();
    }

    //perpanjangan Deposito
    public function depopjg($id, $lineno, $pjg)
    {
        $nodok = str_replace('-', '/', $id);

        $data = DB::table(DB::raw('mtrdeposito as a'))
            ->join(DB::raw('account as b'), DB::raw('a.kdbank'), '=', DB::raw('b.kodeacct'))
            ->where(DB::raw('a.docno'), '=', $nodok)
            ->where('lineno', '=', $lineno)
            ->where('perpanjangan', '=', $pjg)
            ->select(DB::raw('a.*, b.descacct as namabank'))
            ->first();

        return view('modul-treasury.penempatan-deposito.perpanjangan', compact('data'));
    }

    public function updatedepopjg(Request $request)
    {
        $docno = $request->nodok;
        $lineno = $request->lineno;
        $asal = $request->asal;
        $kdbank = $request->kdbank;
        $tgldep = $request->tanggal;
        $tgltempo = $request->tanggal2;
        $tahunbunga = str_replace(',', '.', $request->tahunbunga);
        $noseri = $request->noseri;
        $nominal = str_replace(',', '.', $request->nominal);
        $namabank = $request->namabank;
        $perpanjangan = $request->perpanjangan+1;
        $keterangan = $request->keterangan;
        $kurs = $request->kurs;

       MtrDeposito::insert([
        'docno' => $docno,
        'lineno' => $lineno,
        'tgldep' => $tgldep,
        'tgltempo' => $tgltempo,
        'bungatahun' => $tahunbunga,
        'asal' => $asal,
        'noseri' => $noseri,
        'nominal' => $nominal,
        'kdbank' => $kdbank,
        'keterangan' => $keterangan,
        'proses' => 'Y',
        'perpanjangan' => $perpanjangan 
        ]);

        $data_mtrdeposito = DB::select("SELECT * from mtrdeposito where docno='$docno' and lineno='$lineno' and perpanjangan='$perpanjangan'");
            foreach($data_mtrdeposito as $data_mtr)
            {
                $i_proses='T';
                $i_docno=$docno;
                $i_lineno=$lineno;
                $i_panjang=$perpanjangan;
                $kdbank = $data_mtr->kdbank;
            
                if($i_proses == 'T'){
                    $data_kdbank = DB::select("SELECT jenis as v_jenis from account where kodeacct='$kdbank'");
                    foreach($data_kdbank as $data_kdb)
                    {
                        if($data_kdb->v_jenis == 'T'){
                                $v_pembagi = '36000';
                        } else {
                                $v_pembagi = '36500';
                        }
                    }
            
                    $tgltempos = date_create($data_mtr->tgltempo);
                    $tgltempo= date_format($tgltempos, 'm');
            
                    $tgldeps = date_create($data_mtr->tgldep);
                    $tgldep= date_format($tgldeps, 'm');
                    $bulan = ltrim(date_format($tgldeps, 'm'),0);
                    $tahun = date_format($tgldeps, 'Y');
                    $lastday = date('t',strtotime($data_mtr->tgldep));
                    
                    $v_range = $tgltempo - $tgldep;
                    if($v_range < 0 ){
                        $v_rangeok = ($tgltempo+12) - $tgldep;
                    } else {
                        $v_rangeok = $v_range;
                    }
            
                    if($v_rangeok == 0 ){ //bulan sama
                        $v_jumhari = hitunghari($data_mtr->tgldep,$data_mtr->tgltempo);
                        $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20 = round($v_bungabulan * (20/100),2);
                        $v_bunganet = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                    
                        Dtldepositotest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $data_mtr->tgltempo,
                            'accharibunga' => $v_jumhari,
                            'accbungabulan' => $v_bungabulan,
                            'accpph20' => $v_pph20,
                            'accnetbulan' => $v_bunganet,
                            ]);
                    }elseif($v_rangeok == 1){   //bulan beda 1
                        $v_jumhari = hitunghari($data_mtr->tgldep, $data_mtr->tgltempo);
                        $v_bungabulan = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20  = round($v_bungabulan * (20/100),2);
                        $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                        $v_jumhari2 =hitunghari($data_mtr->tgldep,$lastday);
                        $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph202  = round($v_bungabulan2 * (20/100),2);
                        $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan2 * (20/100)),2);
                        Dtldepositotest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $data_mtr->tgltempo,
                            'accharibunga' => $v_jumhari2,
                            'accbungabulan' => $v_bungabulan2,
                            'accpph20' => $v_pph202,
                            'accnetbulan' => $v_bunganet2,
                            ]);
                    }elseif($v_rangeok > 1){ // jarak bulan > 1
                        $v_tgldepotemp = date_create($data_mtr->tgldep);
                        $bulan = date_format($v_tgldepotemp, 'm');
                        $tahun = date_format($v_tgldepotemp, 'Y');
                        $v_hariakhirtemp =date_format($v_tgldepotemp, 'd');
                        $v_bulanakhirtemp =date_format($v_tgldepotemp, 'm')+1;
                        $v_tahunakhirtemp =date_format($v_tgldepotemp, 'Y');
                        if($v_bulanakhirtemp > 12){
                            $v_bulanakhirtemp =1;
                            $v_tahunakhirtemp = $v_tahunakhirtemp+1;
                        }
                        $v_tglakhir =$v_tahunakhirtemp.'-'.$v_bulanakhirtemp.'-'.$v_hariakhirtemp;
                        $v_hasiltgl = date_create($v_tglakhir);
                        $v_hasiltglakhir =date_format($v_hasiltgl, 'Y-m-d');
                        $v_jumhari =hitunghari($data_mtr->tgldep,$v_hasiltglakhir);
                        $v_bungabulan  = round(($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph20  = round($v_bungabulan * (20/100),2);
                        $v_bunganet  = round((($data_mtr->nominal * $v_jumhari * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan * (20/100)),2);
                        $v_jumhari2 =hitunghari($v_tgldepotemp,$lastday);
                        $v_bungabulan2  = round(($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi,2);
                        $v_pph202  = round($v_bungabulan2 * (20/100),2);
                        $v_bunganet2  = round((($data_mtr->nominal * $v_jumhari2 * $data_mtr->bungatahun)/$v_pembagi) - ($v_bungabulan2 * (20/100)),2);
                        DtlDepositoTest::insert([
                            'docno' => $i_docno,
                            'lineno' => $i_lineno,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'haribunga' => $v_jumhari,
                            'bungabulan' => $v_bungabulan,
                            'pph20' => $v_pph20,
                            'netbulan' => $v_bunganet,
                            'perpanjangan' => $i_panjang,
                            'tglawal' => $data_mtr->tgldep,
                            'tglakhir' => $v_hasiltglakhir,
                            'accharibunga' => $v_jumhari2,
                            'accbungabulan' => $v_bungabulan2,
                            'accpph20' => $v_pph202,
                            'accnetbulan' => $v_bunganet2,
                            ]);
                    }
                }
                return response()->json();
            }
    }

    public function rekap()
    {
        $data_bank = DB::select("SELECT distinct(a.kdbank),b.descacct from mtrdeposito a, account b where b.kodeacct=a.kdbank");
        $data_lapang = DB::select("SELECT kodelokasi,nama from lokasi");

        return view('modul-treasury.penempatan-deposito.rekap', compact('data_bank', 'data_lapang'));
    }

    public function rekaprc($no, $id)
    {
        $nodok = str_replace('-', '/', $no);
        $lineno = $id;
        $data_bank = DB::select("SELECT distinct(a.kdbank),b.descacct from mtrdeposito a, account b where b.kodeacct=a.kdbank");
        $data_lapang = DB::select("SELECT kodelokasi,nama from lokasi");
        return view('modul-treasury.penempatan-deposito.rekaprc', compact('data_bank', 'data_lapang', 'no', 'id'));
    }

    public function ctkdepo(Request $request)
    {
        // if($request->lapangan == ""){
        $lp = "a.asal in ('MD','MS')";
        $lapangan = "MD,MS";
        // } else {
        //     $lp = "a.asal='$request->lapangan'";
        //     $lapangan = "$request->lapangan";
        // }
        if ($request->sanper <> "") {
            $sanper = $request->sanper;
            $bulan = ltrim($request->bulan, 0);
            $tahun = $request->tahun;
            $data = "a.kdbank='$sanper' and d.bulan='$bulan' and d.tahun='$tahun'";
        } else {
            $sanper = "like '%' ";
            $bulan = ltrim($request->bulan, 0);
            $tahun = $request->tahun;
            $data = "a.kdbank $sanper and d.bulan='$bulan' and d.tahun='$tahun'";
        }
        $data_list = DB::select("SELECT a.*,b.ci,c.descacct,d.haribunga,d.bungabulan,d.pph20,d.netbulan,d.accharibunga,d.accnetbulan from mtrdeposito a join kasdoc b on a.docno=b.docno join account c on a.kdbank=c.kodeacct, dtldepositotest d where d.docno=a.docno and d.lineno=a.lineno and d.perpanjangan=a.perpanjangan and $data and $lp");
        if (!empty($data_list)) {
            // $pdf = PDF::loadview('penempatan_deposito.export_penemdep_pdf', compact(
            //     'data_list',
            //     'request',
            //     'lapangan'
            // ))
            // ->setPaper('a4', 'landscape')
            // ->setOption('footer-right', 'Halaman [page] dari [toPage]')
            // ->setOption('footer-font-size', 7)
            // ->setOption('header-html', view('penempatan_deposito.export_penemdep_pdf_header',compact('request')))
            // ->setOption('margin-top', 30)
            // ->setOption('margin-bottom', 10);

            // return $pdf->stream('rekap_d2_perperiode_'.date('Y-m-d H:i:s').'.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('penempatan_deposito.index');
        }
    }

    

    public function rekap_Rc($docs, $lineno)
    {
        $docno = str_replace('-', '/', $docs);   
        $lampiran = "-";
        $perihal = "Penempatan Deposito";
        $data_cari = DB::select("SELECT EXTRACT(day from a.tgltempo)-EXTRACT(day from date(now())) selhari,EXTRACT(month from a.tgltempo)-EXTRACT(month from date(now())) selbulan,a.*,b.nama as namabank, b.norek,b.cabang from penempatandepo a, rekening_bank b where a.kdbank=b.kdbank and a.asal=b.lokasi and a.docno = '$docno' and a.lineno='$lineno'");
        dd($data_cari);
        foreach ($data_cari as $carinominal) {
            $jumangka = $carinominal->nominal;
            $bank = $carinominal->nama;
            $cabang = $carinominal->cabang;
            $norek = $carinominal->rekening;
            $tmt = $carinominal->tgldep;
            $bunga = $carinominal->bungatahun;
            $ci = $carinominal->ci;
            $alamat = "-";
            $kota = "-";
            $up = "-";
            $jabkir = "Dir. Utama";
            $jabkan = "Man. Kontroler";
            $namkir = "Sjahril Samad";
            $namkan = "Wasono";
            $reg = "-";
            if ($carinominal->range <> 0) {
                $jangka = $carinominal->range . " bulan";
            } else {
                $jangka = $carinominal->jmlhari . " hari";
            }
        }
        return view('pembayaran_umk.rekap_rc', compact(
            'docs',
            'lampiran',
            'perihal',
            'bank',
            'cabang',
            'norek',
            'tmt',
            'bunga',
            'ci',
            'alamat',
            'kota',
            'up',
            'jabkir',
            'jabkan',
            'namkir',
            'namkan',
            'reg',
            'jumangka',
            'jangka'
        ));
    }

    public function exportRc(Request $request)
    {
        $docno = str_replace('-', '/', $request->docno);
        $data_list = DB::select("SELECT right(a.thnbln,2) bulan,  left(a.thnbln, 4) tahun,a.jk as jka,a.ci as cia,a.voucher as vouchera,a.keterangan, b.* from jurumdoc a join jurumline b on a.docno=b.docno where a.docno='$docno'");

        if (!empty($data_list)) {
            foreach ($data_list as $dataa) {
                $jk = $dataa->jka;
                $ci = $dataa->cia;
                $voucher = $dataa->vouchera;
                $docno = $dataa->docno;
                $bulan = $dataa->bulan;
                $tahun = $dataa->tahun;
            }
            $pdf = DomPDF::loadview('pembayaran_umk.expor_rct', compact('request', 'data_list', 'jk', 'ci', 'voucher', 'docno', 'bulan', 'tahun'))->setPaper('letter', 'landscape');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(105, 75, "{PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data", 'Failed')->persistent(true);
            return redirect()->route('pembayaran_umk.index_rc');
        }
    }
}
