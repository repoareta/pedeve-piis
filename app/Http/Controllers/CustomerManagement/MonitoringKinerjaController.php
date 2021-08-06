<?php

namespace App\Http\Controllers\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanAfiliasi;
use DB;
use Illuminate\Http\Request;

class MonitoringKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-customer-management.monitoring-kinerja.index');
    }

    public function indexJson(Request $request)
    {
        $data =DB::select("
        select a.*, b.nama 
        from tbl_monitoring a 
        join cm_perusahaan_afiliasi b 
        on a.kd_perusahaan=b.id
        where a.bulan='$request->bulan' 
        and a.tahun='$request->tahun'");
        
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$data->kd_monitoring.'" value="'.$data->kd_monitoring.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->addColumn('thnbln', function ($data) {
            return "$data->bulan/$data->tahun";
        })
        ->addColumn('ci', function ($data) {
            if($data->ci == 1){
                return "IDR";
            } else {
                return "USD";
            }
        })
        ->addColumn('aset', function ($data) {
            return currency_format($data->aset);
        })
        ->addColumn('revenue', function ($data) {
            return currency_format($data->revenue);
        })
        ->addColumn('beban_pokok', function ($data) {
            return currency_format($data->beban_pokok);
        })
        ->addColumn('laba_kotor', function ($data) {
            return currency_format($data->beban_pokok+$data->revenue);
        })
        ->addColumn('biaya_operasi', function ($data) {
            return currency_format($data->biaya_operasi);
        })
        ->addColumn('laba_operasi', function ($data) {
            return currency_format($data->biaya_operasi+($data->beban_pokok+$data->revenue));
        })
        ->addColumn('laba_bersih', function ($data) {
            return currency_format($data->laba_bersih);
        })
        ->addColumn('tkp', function ($data) {
            return currency_format($data->tkp);
        })
        ->addColumn('kpi', function ($data) {
            return currency_format($data->kpi);
        })
        ->rawColumns(['radio','thnbln'])
        ->make(true);
            
    }

    public function create()
    {
        $data_perusahaan = PerusahaanAfiliasi::all();
        return view('monitoring_kinerja.create',compact('data_perusahaan'));
    }
    public function store(Request $request)
    {
        DB::table('tbl_monitoring')->insert([
            'kd_perusahaan' => $request->nama,
            'ci'            => $request->ci,
            'tahun'         => $request->tahun,
            'bulan'         => $request->bulan,
            'rate'          => $request->kurs,
            'aset'          => str_replace(',', '.', $request->aset),
            'revenue'       => str_replace(',', '.', $request->revenue),
            'beban_pokok'   => str_replace(',', '.', $request->beban_pokok),
            'biaya_operasi' => str_replace(',', '.', $request->biaya_operasi),
            'laba_bersih'   => str_replace(',', '.', $request->laba_bersih),
            'tkp'           => str_replace(',', '.', $request->tkp),
            'kpi'           => str_replace(',', '.', $request->kpi),
        ]);
        return response()->json(1);
    }

   
    public function edit($id)
    {
        $data_list =  DB::select("SELECT a.*, b.nama from tbl_monitoring a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id where kd_monitoring='$id'");
        return view('monitoring_kinerja.edit', compact('data_list'));
    }

    
    public function update(Request $request)
    {
            DB::table('tbl_monitoring')->where('kd_monitoring',$request->kd_monitoring)
            ->update([
                'kd_perusahaan' => $request->nama,
                'ci'            => $request->ci,
                'tahun'         => $request->tahun,
                'bulan'         => $request->bulan,
                'rate'          => $request->kurs,
                'aset'          => str_replace(',', '.', $request->aset),
                'revenue'       => str_replace(',', '.', $request->revenue),
                'beban_pokok'   => str_replace(',', '.', $request->beban_pokok),
                'biaya_operasi' => str_replace(',', '.', $request->biaya_operasi),
                'laba_bersih'   => str_replace(',', '.', $request->laba_bersih),
                'tkp'           => str_replace(',', '.', $request->tkp),
                'kpi'           => str_replace(',', '.', $request->kpi),
            ]);
            return response()->json();
    }

    public function delete(Request $request)
    {
        DB::table('tbl_monitoring')->where('kd_monitoring', $request->id)->delete();
        return response()->json();
    }
}
