<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use Alert;
use App\Http\Controllers\Controller;
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
        ->addColumn('action', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$data->pribadi.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->addColumn('pribadi', function ($data) {
            return currency_format($data->pribadi); 
        })
        ->addColumn('accident', function ($data) {
            return currency_format($data->accident);
        })
        ->addColumn('pensiun', function ($data) {
            return currency_format($data->pensiun);
        })
        ->addColumn('life', function ($data) {
            return currency_format($data->life);
        })
        ->addColumn('manulife', function ($data) {
            return currency_format($data->manulife);
        })
        ->rawColumns(['action'])
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
    public function store(Request $request)
    {
        $data_cek = PayTblJamsostek::all()->count(); 			
        if(!empty($data_cek)){
            $data=0;
            return response()->json($data);
        }else {
        PayTblJamsostek::insert([
            'pribadi' => str_replace(',', '.', $request->pribadi),
            'accident' => str_replace(',', '.', $request->accident),
            'pensiun' => str_replace(',', '.', $request->pensiun),
            'life' => str_replace(',', '.', $request->life),
            'manulife' => str_replace(',', '.', $request->manulife)
            ]);
            $data = 1;
            return response()->json($data);
        }   
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_list =  PayTblJamsostek::where('pribadi', $id)->get();
        return view('modul-sdm-payroll.jamsostek.edit', compact('data_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        PayTblJamsostek::where('pribadi', $request->pribadi)
        ->update([
            'pribadi' => str_replace(',', '.', $request->pribadi),
            'accident' => str_replace(',', '.', $request->accident),
            'pensiun' => str_replace(',', '.', $request->pensiun),
            'life' => str_replace(',', '.', $request->life),
            'manulife' => str_replace(',', '.', $request->manulife)
        ]);
        return response()->json();
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
}
