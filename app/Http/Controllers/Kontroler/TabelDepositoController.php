<?php

namespace App\Http\Controllers\Kontroler;

use Alert;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use PDF;

class TabelDepositoController extends Controller
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
        return view('tabel_deposito.index',compact('tahun','bulan'));
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
                $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from bulankontroller where status='1' and length(thnbln)=6");
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

    public function rekap()
    {
        $data_bank = DB::select("SELECT distinct(a.kdbank),b.descacct from mtrdeposito a, account b where b.kodeacct=a.kdbank");
        $data_lapang = DB::select("SELECT kodelokasi,nama from lokasi");
        return view('tabel_deposito.rekap',compact('data_bank','data_lapang'));
    }

    public function export(Request $request)
    {
            // if($request->lapangan == ""){
                $lp = "a.asal in ('MD','MS')";
                $lapangan = "MD,MS";
            // } else {
            //     $lp = "a.asal='$request->lapangan'";
            //     $lapangan = "$request->lapangan";
            // }
            if($request->sanper <> ""){
                $sanper = $request->sanper;
                $bulan = ltrim($request->bulan,0);
                $tahun = $request->tahun;
                $data = "a.kdbank='$sanper' and d.bulan='$bulan' and d.tahun='$tahun'";
            } else {
                $sanper ="like '%' ";
                $bulan = ltrim($request->bulan,0);
                $tahun = $request->tahun;
                $data = "a.kdbank $sanper and d.bulan='$bulan' and d.tahun='$tahun'";
            }
            $data_list = DB::select("SELECT a.*,b.ci,c.descacct,d.haribunga,d.bungabulan,d.pph20,d.netbulan,d.accharibunga,d.accnetbulan from mtrdeposito a join kasdoc b on a.docno=b.docno join account c on a.kdbank=c.kodeacct, dtldepositotest d where d.docno=a.docno and d.lineno=a.lineno and d.perpanjangan=a.perpanjangan and $data and $lp");
        if(!empty($data_list)){
            $pdf = PDF::loadview('tabel_deposito.export_penemdep_pdf', compact(
                'data_list',
                'request',
                'lapangan'
            ))
            ->setPaper('a4', 'landscape')
            ->setOption('footer-right', 'Halaman [page] dari [toPage]')
            ->setOption('footer-font-size', 7)
            ->setOption('header-html', view('tabel_deposito.export_penemdep_pdf_header',compact('request')))
            ->setOption('margin-top', 30)
            ->setOption('margin-bottom', 10);
    
            return $pdf->stream('rekap_d2_perperiode_'.date('Y-m-d H:i:s').'.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('tabel_deposito.index');
        }
    }
}
