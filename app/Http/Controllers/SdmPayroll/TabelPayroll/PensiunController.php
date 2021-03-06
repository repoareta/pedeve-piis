<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PensiunStoreRequest;
use App\Models\PayTblPensiun;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class PensiunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.pensiun.index');
    }

    public function indexJson(Request $request)
    {
        if ($request->ajax()) {
            $data = PayTblPensiun::all();

            return datatables()->of($data)
                ->addColumn('radio', function ($data) {
                    $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="' . $data->pribadi . '" name="btn-radio"><span></span></label>';
                    return $radio;
                })
                ->addColumn('pribadi', function ($data) {
                    return currency_format($data->pribadi);
                })
                ->addColumn('perusahaan', function ($data) {
                    return currency_format($data->perusahaan);
                })
                ->addColumn('perusahaan2', function ($data) {
                    return currency_format($data->perusahaan2);
                })
                ->addColumn('perusahaan3', function ($data) {
                    return currency_format($data->perusahaan3);
                })
                ->rawColumns(['radio'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-sdm-payroll.pensiun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PensiunStoreRequest $request)
    {
        $data_cek = PayTblPensiun::all()->count();

        if (!empty($data_cek)) {
            Alert::info('Failed', 'Duplikasi data, entri dibatalkan.')->persistent(true)->autoClose(3000);
            return redirect()->route('modul_sdm_payroll.pensiun.index');
        }

        PayTblPensiun::insert($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.pensiun.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pensiun = PayTblPensiun::where('pribadi', $id)->first();

        $pensiun->pribadi = number_format($pensiun->pribadi, 2);
        $pensiun->perusahaan = number_format($pensiun->perusahaan, 2);
        $pensiun->perusahaan2 = number_format($pensiun->perusahaan2, 2);
        $pensiun->perusahaan3 = number_format($pensiun->perusahaan3, 2);

        return view('modul-sdm-payroll.pensiun.edit', compact(
            'pensiun'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PensiunStoreRequest $request)
    {
        PayTblPensiun::where('pribadi', $request->id)
            ->update($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.pensiun.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayTblPensiun::where('pribadi', $request->dataid)->delete();
        return response()->json();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function daftarIuran()
    {
        return view('modul-sdm-payroll.pensiun.daftar-iuran');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function daftarIuranExport(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_master_upah where tahun='$request->tahun' and bulan='$request->bulan'");
        $data_cek1 = DB::select("SELECT * from pay_master_bebanprshn where tahun='$request->tahun' and bulan='$request->bulan'");
        if (!empty($data_cek) and !empty($data_cek1)) {
            $data_list = DB::select("SELECT nopek, nama, 
                                    sum(CASE WHEN aard ='15'  THEN curramount ELSE '0' END) as aard15,
                                    sum(CASE WHEN aard ='46'  THEN curramount ELSE '0' END) as aard46,
                                    sum(CASE WHEN aard ='14'  THEN curramount*-1 ELSE '0' END) as aard14
                                    from (select a.nopek,b.nama,a.aard,a.curramount
                                    from pay_master_bebanprshn a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard in ('15','46') and a.tahun='$request->tahun' and a.bulan='$request->bulan' union all
                                    select c.nopek,d.nama, c.aard, c.nilai as curramount
                                    from pay_master_upah c join sdm_master_pegawai d on c.nopek=d.nopeg where c.aard='14' and c.tahun='$request->tahun' and c.bulan='$request->bulan') d group by nama, nopek order by nama asc");

            $pdf = DomPDF::loadview('modul-sdm-payroll.pensiun.export-iuran', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(730, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //iuran pensiun landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data Bulan: $request->bulan dan Tahun: $request->tahun", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.pensiun.daftar_iuran');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function rekapIuran()
    {
        return view('modul-sdm-payroll.pensiun.rekap-iuran');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapIuranExport(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_master_upah where tahun='$request->tahun'");
        $data_cek1 = DB::select("SELECT * from pay_master_bebanprshn where tahun='$request->tahun'");
        if (!empty($data_cek) and !empty($data_cek1)) {
            if ($request->dp == 'BK') {
                $data_list = DB::select("SELECT 
                count(a.bulan),a.nopek,b.nama as namapegawai, SUM(a.nilai),
                SUM(CASE WHEN a.bulan ='1' THEN round(a.nilai,0)* -1 ELSE '0' END) as jan, 
                SUM(CASE WHEN a.bulan ='2' THEN round(a.nilai,0)* -1 ELSE '0' END) as feb,
                SUM(CASE WHEN a.bulan ='3' THEN round(a.nilai,0)* -1 ELSE '0' END) as mar,
                SUM(CASE WHEN a.bulan ='4' THEN round(a.nilai,0)* -1 ELSE '0' END) as apr,
                SUM(CASE WHEN a.bulan ='5' THEN round(a.nilai,0)* -1 ELSE '0' END) as mei,
                SUM(CASE WHEN a.bulan ='6' THEN round(a.nilai,0)* -1 ELSE '0' END) as jun,
                SUM(CASE WHEN a.bulan ='7' THEN round(a.nilai,0)* -1 ELSE '0' END) as jul,
                SUM(CASE WHEN a.bulan ='8' THEN round(a.nilai,0)* -1 ELSE '0' END) as agu,
                SUM(CASE WHEN a.bulan ='9' THEN round(a.nilai,0)* -1 ELSE '0' END) as sep,
                SUM(CASE WHEN a.bulan ='10' THEN round(a.nilai,0)* -1 ELSE '0' END) as okt,
                SUM(CASE WHEN a.bulan ='11' THEN round(a.nilai,0)* -1 ELSE '0' END) as nov,
                SUM(CASE WHEN a.bulan ='12' THEN round(a.nilai,0)* -1 ELSE '0' END) as des    
                from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg where a.tahun='$request->tahun'  and a.aard='14' group by a.nopek, b.nama order by b.nama asc");
            } else {
                $data_list = DB::select("SELECT 
                    b.nopeg AS nopek,b.nama AS namapegawai, SUM(a.CURRAMOUNT),
                    SUM(CASE WHEN a.bulan ='1' and a.aard in('15','46')  THEN round(a.CURRAMOUNT,0) ELSE '0' END) as jan, 
                    SUM(CASE WHEN a.bulan ='2' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as feb,
                    SUM(CASE WHEN a.bulan ='3' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as mar,
                    SUM(CASE WHEN a.bulan ='4' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as apr,
                    SUM(CASE WHEN a.bulan ='5' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as mei,
                    SUM(CASE WHEN a.bulan ='6' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as jun,
                    SUM(CASE WHEN a.bulan ='7' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as jul,
                    SUM(CASE WHEN a.bulan ='8' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as agu,
                    SUM(CASE WHEN a.bulan ='9' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as sep,
                    SUM(CASE WHEN a.bulan ='10' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as okt,
                    SUM(CASE WHEN a.bulan ='11' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as nov,
                    SUM(CASE WHEN a.bulan ='12' THEN round(a.CURRAMOUNT,0) ELSE '0' END) as des    
                    from pay_master_bebanprshn a join sdm_master_pegawai b on a.nopek=b.nopeg where a.tahun='$request->tahun'  and a.aard in ('15','46') group by b.nama,b.nopeg order by b.nama asc");
            }
        } else {
            Alert::info("Tidak ditemukan data Tahun: $request->tahun", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.pensiun.rekap_iuran');
        }
        $pdf = DomPDF::loadview('modul-sdm-payroll.pensiun.rekap-iuran-pensiun-pdf', compact('request', 'data_list'))->setPaper('legal', 'landscape');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        return $pdf->stream();
    }
}
