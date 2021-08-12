<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\JamsostekStoreRequest;
use App\Models\PayTblJamsostek;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class JamsostekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.jamsostek.index');
    }

    public function indexJson(Request $request)
    {
        $data = PayTblJamsostek::all();

        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$data->pribadi.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->addColumn('pribadi', function ($data) {
            return currency_format($data->pribadi, 2);
        })
        ->addColumn('accident', function ($data) {
            return currency_format($data->accident, 2);
        })
        ->addColumn('pensiun', function ($data) {
            return currency_format($data->pensiun, 2);
        })
        ->addColumn('life', function ($data) {
            return currency_format($data->life, 2);
        })
        ->addColumn('manulife', function ($data) {
            return currency_format($data->manulife, 2);
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-sdm-payroll.jamsostek.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JamsostekStoreRequest $request)
    {
        $data_cek = PayTblJamsostek::all()->count();

        if(!empty($data_cek)){
            Alert::info('Failed', 'Duplikasi data, entri dibatalkan.')->persistent(true)->autoClose(3000);
            return redirect()->route('modul_sdm_payroll.jamsostek.index');
        }
        
        PayTblJamsostek::insert($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.jamsostek.index');
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jamsostek = PayTblJamsostek::where('pribadi', $id)->first();

        $jamsostek->pribadi = number_format($jamsostek->pribadi, 2);
        $jamsostek->accident = number_format($jamsostek->accident, 2);
        $jamsostek->pensiun = number_format($jamsostek->pensiun, 2);
        $jamsostek->life = number_format($jamsostek->life, 2);
        $jamsostek->manulife = number_format($jamsostek->manulife, 2);

        return view('modul-sdm-payroll.jamsostek.edit', compact(
            'jamsostek'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JamsostekStoreRequest $request)
    {
        PayTblJamsostek::where('pribadi', $request->pribadi)
        ->update($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.jamsostek.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayTblJamsostek::where('pribadi', $request->dataid)->delete();
        return response()->json();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function daftarIuran()
    {
        return view('modul-sdm-payroll.jamsostek.daftar-iuran');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapExport(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_master_upah where tahun='$request->tahun' and bulan='$request->bulan'");
        if(!empty($data_cek) and $request->ijp == 'v1') {
            $data_list = DB::select("SELECT a.tahun,a.bulan,a.nopek,a.aard,a.nilai*-1 as pribadi,b.nama as namapegawai,b.status,b.noastek,(SELECT jumlah FROM pay_gapokbulanan WHERE tahun=a.tahun AND bulan=a.bulan AND nopek=a.nopek) gapok,(select curramount from pay_master_bebanprshn where aard='10' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek)  jkk, (select curramount from pay_master_bebanprshn where aard='11' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) pensiun,(select curramount from pay_master_bebanprshn where aard='12' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) life,(select curramount from pay_master_bebanprshn where aard='13' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) manulife from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg WHERE a.aard='09' and a.tahun='$request->tahun' and a.bulan='$request->bulan'");
            $pdf = DomPDF::loadview('modul-sdm-payroll.jamsostek.export_iuranjsv1',compact('request','data_list'))->setPaper('a4', 'landscape');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(730, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran jamsostek landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } elseif(!empty($data_cek) and $request->ijp == 'v2') {
            $data_list = DB::select("SELECT a.tahun, a.bulan, a.nopek,a.aard, a.nilai as gapok, b.noastek,b.nama as namapegawai, b.status from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard='09' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and a.nilai*-1>0");
            $pdf = DomPDF::loadview('modul-sdm-payroll.jamsostek.export_iuranjsv2',compact('request','data_list'))->setPaper('a4', 'landscape');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(730, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran jamsostek landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data Tahun: $request->tahun dan Bulan: $request->bulan", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.jamsostek.ctkiuranjs');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function rekapIuran()
    {
        return view('modul-sdm-payroll.jamsostek.rekap-iuran');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapIuranExport(Request $request)
    {
        $pdf = DomPDF::loadview('modul-sdm-payroll.jamsostek.rekap-iuran-pdf',compact('request'))
        ->setPaper('a4', 'landscape');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->getCanvas();
        $canvas->page_text(740, 110, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran pensiun landscape
        // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function daftarIuranExport(Request $request)
    {
        $data_cek = DB::select("select * from pay_master_upah where tahun='$request->tahun' and bulan='$request->bulan'");
        if(!empty($data_cek) and $request->ijp == 'v1') {
            $data_list = DB::select("select a.tahun,a.bulan,a.nopek,a.aard,a.nilai*-1 as pribadi,b.nama as namapegawai,b.status,b.noastek,(SELECT jumlah FROM pay_gapokbulanan WHERE tahun=a.tahun AND bulan=a.bulan AND nopek=a.nopek) gapok,(select curramount from pay_master_bebanprshn where aard='10' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek)  jkk, (select curramount from pay_master_bebanprshn where aard='11' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) pensiun,(select curramount from pay_master_bebanprshn where aard='12' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) life,(select curramount from pay_master_bebanprshn where aard='13' and tahun=a.tahun and bulan=a.bulan and nopek=a.nopek) manulife from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg WHERE a.aard='09' and a.tahun='$request->tahun' and a.bulan='$request->bulan'");
            $pdf = DomPDF::loadview('modul-sdm-payroll.jamsostek.daftar-iuran-pdf-pekerja-satu',compact('request','data_list'))->setPaper('a4', 'landscape');
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf ->getCanvas();
            $canvas->page_text(730, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran jamsostek landscape
            return $pdf->stream();
        }elseif(!empty($data_cek) and $request->ijp == 'v2'){
            $data_list = DB::select("select a.tahun, a.bulan, a.nopek,a.aard, a.nilai as gapok, b.noastek,b.nama as namapegawai, b.status from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard='09' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and a.nilai*-1>0");
            $pdf = DomPDF::loadview('modul-sdm-payroll.jamsostek.daftar-iuran-pdf-pekerja-dua',compact('request','data_list'))->setPaper('a4', 'landscape');
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf ->getCanvas();
            $canvas->page_text(730, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran jamsostek landscape
            return $pdf->stream();
        }else{
            Alert::info("Tidak ditemukan data Tahun: $request->tahun dan Bulan: $request->bulan", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.jamsostek.daftar_iuran');
        }
    }
}
