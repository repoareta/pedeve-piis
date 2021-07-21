<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\Kasline;
use App\Models\PenempatanDepo;
use DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PerhitunganBagiHasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_akses = DB::table('usermenu')->where('userid', auth()->user()->userid)->where('menuid', 509)->first();

        $date = !$request->tanggal ? date('Y-m-d') : $request->tanggal;
        
        $data_list = DB::select("select docno,lineno,tgldepo,tgltempo,bungatahun,asal,noseri,nominal as asli,(select sum(case when kurs<>'1' then nominal else 0 end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date') as totaldollar,(select sum(case when kurs='1' then nominal else 0 end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date') as totalrupiah,(select sum(case when kurs<>'1' then nominal*kurs else 0 end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date') as ekivalen,(select sum(case when kurs='1' then nominal else nominal*kurs end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date') as total,((case when kurs='1' then nominal else nominal*kurs end)/(select sum(case when kurs='1' then nominal else nominal*kurs end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date'))*bungatahun as rtimbang,(select sum(((case when kurs='1' then nominal else nominal*kurs end)/(select sum(case when kurs='1' then nominal else nominal*kurs end) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date'))*bungatahun) from penempatandepo where tgltempo > '$date' and tgldepo <= '$date') as totalrata,(select descacct from account where kodeacct=kdbank) as nmbank,keterangan,kurs,statcair,doccair,linecair from penempatandepo where tgltempo > '$date' and tgldepo <= '$date' order by tgltempo asc;");

        return view('modul-treasury.perhitungan-bagi-hasil.index', compact(
            'data_akses',
            'data_list',
            'date',
        ));
    }

    public function delete(Request $request)
    {
        $nodok=str_replace('-', '/', $request->nodok);
        PenempatanDepo::where('docno', $nodok)->where('lineno', $request->lineno)->delete();
        Kasline::where('docno', $nodok)->where('lineno', $request->lineno)
        ->update([
            'inputpwd' => 'N',
        ]);
        return response()->json();
    }

    public function RekapPerhitungan()
    {
        return view('modul-treasury.perhitungan-bagi-hasil.rekap');
    }
    public function exportPerhitungan(Request $request)
    {
        $data_list = DB::select("
        select * from v_reportdeposito where to_char(tglcair,'yyyy/mm/dd') > '$request->tanggal' and to_char(tgldepo,'yyyy/mm/dd') <= '$request->tanggal'");
        $data_bankrp = DB::select("
                select 
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110123' or kdbank='110201' or kdbank='110107' or kdbank='110101'  THEN nominal ELSE '0' END) as brimd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110201' or kdbank='110107' or kdbank='110101'  THEN nominal ELSE '0' END) as bnimd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110100' or kdbank='110200' THEN nominal ELSE '0' END) as mandirimd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal ELSE '0' END) as btnmd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110153' THEN nominal ELSE '0' END) as agromd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110121' THEN nominal ELSE '0' END) as mantapmd,
                sum(CASE WHEN kurs=1 and lokasi='MD' and kdbank='110154' THEN nominal ELSE '0' END) as bnisyamd,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110123' or kdbank='110201' or kdbank='110107' or kdbank='110101'  THEN nominal ELSE '0' END) as brims,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110201' or kdbank='110107' or kdbank='110101'  THEN nominal ELSE '0' END) as bnims,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110100' or kdbank='110200' THEN nominal ELSE '0' END) as mandirims,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal ELSE '0' END) as btnms,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110153' THEN nominal ELSE '0' END) as agroms,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110121' THEN nominal ELSE '0' END) as mantapms,
                sum(CASE WHEN kurs=1 and lokasi='MS' and kdbank='110154' THEN nominal ELSE '0' END) as bnisyams,
                
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110123' or kdbank='110122' or kdbank='110125' or kdbank='110130'  THEN nominal ELSE '0' END) as brimd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110201' or kdbank='110107' or kdbank='110208'  THEN nominal ELSE '0' END) as bnimd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110100' or kdbank='110200' THEN nominal ELSE '0' END) as mandirimd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal ELSE '0' END) as btnmd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110153' THEN nominal ELSE '0' END) as agromd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110121' THEN nominal ELSE '0' END) as mantapmd1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110154' THEN nominal ELSE '0' END) as bnisyamd1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110123' or kdbank='110122' or kdbank='110125' or kdbank='110130'  THEN nominal ELSE '0' END) as brims1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110201' or kdbank='110107' or kdbank='110208'  THEN nominal ELSE '0' END) as bnims1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110100' or kdbank='110200' THEN nominal ELSE '0' END) as mandirims1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal ELSE '0' END) as btnms1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110153' THEN nominal ELSE '0' END) as agroms1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110121' THEN nominal ELSE '0' END) as mantapms1,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110154' THEN nominal ELSE '0' END) as bnisyams1,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110123' or kdbank='110122' or kdbank='110125' or kdbank='110130'  THEN nominal*kurs ELSE '0' END) as brimd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110201' or kdbank='110107' or kdbank='110208'  THEN nominal*kurs ELSE '0' END) as bnimd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110100' or kdbank='110200' THEN nominal*kurs ELSE '0' END) as mandirimd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal*kurs ELSE '0' END) as btnmd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110153' THEN nominal*kurs ELSE '0' END) as agromd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110121' THEN nominal*kurs ELSE '0' END) as mantapmd2,
                sum(CASE WHEN kurs<>1 and lokasi='MD' and kdbank='110154' THEN nominal*kurs ELSE '0' END) as bnisyamd2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110123' or kdbank='110122' or kdbank='110125' or kdbank='110130'  THEN nominal*kurs ELSE '0' END) as brims2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110201' or kdbank='110107' or kdbank='110208'  THEN nominal*kurs ELSE '0' END) as bnims2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110100' or kdbank='110200' THEN nominal*kurs ELSE '0' END) as mandirims2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110218' or kdbank='110118' or kdbank='110700' or kdbank='110120' or kdbank='110126' THEN nominal*kurs ELSE '0' END) as btnms2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110153' THEN nominal*kurs ELSE '0' END) as agroms2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110121' THEN nominal*kurs ELSE '0' END) as mantapms2,
                sum(CASE WHEN kurs<>1 and lokasi='MS' and kdbank='110154' THEN nominal*kurs ELSE '0' END) as bnisyams2
                from v_reportdeposito where to_char(tglcair,'yyyy/mm/dd') > '$request->tanggal' and to_char(tgldepo,'yyyy/mm/dd') <= '$request->tanggal'
            ");
        // dd($data_bankrp);
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-treasury.perhitungan-bagi-hasil.export', compact('request', 'data_list', 'data_bankrp'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(520, 110, "{PAGE_NUM} Dari {PAGE_COUNT}", null, 8, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Data Tidak Ditemukan", 'Failed')->persistent(true);
            return redirect()->route('perhitungan_bagihasil.rekap');
        }
    }
}
