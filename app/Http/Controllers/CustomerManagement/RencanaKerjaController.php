<?php

namespace App\Http\Controllers\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanAfiliasi;
use DB;
use Illuminate\Http\Request;

class RencanaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rencana_kerja.index');
    }

    public function indexJson(Request $request)
    {
          
        $data =DB::select("SELECT a.*, b.nama from tbl_rencana_kerja a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id where a.tahun='$request->tahun'");
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$data->kd_rencana_kerja.'" value="'.$data->kd_rencana_kerja.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->addColumn('nama', function ($data) {
                return $data->nama;
        })
        ->addColumn('thnbln', function ($data) {
                return "<p align='center'>$data->tahun</p>";
        })
        ->addColumn('ci', function ($data) {
                if($data->ci_r == 1){
                    return "IDR";
                } else {
                    return "USD";
                }
        })
        ->addColumn('aset', function ($data) {
                return "<p align='right'>".number_format($data->aset_r,2)."</p>";
        })
        ->addColumn('revenue', function ($data) {
                return "<p align='right'>".number_format($data->revenue_r,2)."</p>";
        })
        ->addColumn('beban_pokok', function ($data) {
            return "<p align='right'>".number_format($data->beban_pokok_r,2)."</p>";
        })
        ->addColumn('laba_kotor', function ($data) {
            return "<p align='right'>".number_format($data->beban_pokok_r+$data->revenue_r,2)."</p>";
        })
        ->addColumn('biaya_operasi', function ($data) {
            return "<p align='right'>".number_format($data->biaya_operasi_r,2)."</p>";
        })
        ->addColumn('laba_operasi', function ($data) {
            return "<p align='right'>".number_format($data->biaya_operasi_r+($data->beban_pokok_r+$data->revenue_r),2)."</p>";
        })
        ->addColumn('laba_bersih', function ($data) {
            return "<p align='right'>".number_format($data->laba_bersih_r,2)."</p>";
        })
        ->addColumn('tkp', function ($data) {
            return "<p align='right'>".round($data->tkp_r)."</p>";
        })
        ->addColumn('kpi', function ($data) {
            return "<p align='right'>".round($data->kpi_r)."</p>";
        })
        ->rawColumns(['action','thnbln','aset','revenue','beban_pokok','biaya_operasi','laba_bersih','laba_kotor','laba_operasi','sales','tkp','kpi'])
        ->make(true);
            
    }

    public function create()
    {
        $data_perusahaan = PerusahaanAfiliasi::all();
        return view('rencana_kerja.create',compact('data_perusahaan'));
    }
    public function store(Request $request)
    {
        DB::table('tbl_rencana_kerja')->insert([
            'kd_perusahaan' => $request->nama,
            'ci_r'            => $request->ci,
            'tahun'         => $request->tahun,
            'bulan'         => date('m'),
            'rate_r'          => $request->kurs,
            'aset_r'          => str_replace(',', '.', $request->aset),
            'revenue_r'       => str_replace(',', '.', $request->revenue),
            'beban_pokok_r'   => str_replace(',', '.', $request->beban_pokok),
            'biaya_operasi_r' => str_replace(',', '.', $request->biaya_operasi),
            'laba_bersih_r'   => str_replace(',', '.', $request->laba_bersih),
            'tkp_r'           => str_replace(',', '.', $request->tkp),
            'kpi_r'           => str_replace(',', '.', $request->kpi),
        ]);
        return response()->json(1);
    }

   
    public function edit($id)
    {
        $data_list =  DB::select("SELECT a.*, b.nama from tbl_rencana_kerja a join cm_perusahaan_afiliasi b on a.kd_perusahaan=b.id where kd_rencana_kerja='$id'");
        return view('rencana_kerja.edit', compact('data_list'));
    }

    
    public function update(Request $request)
    {
            DB::table('tbl_rencana_kerja')->where('kd_rencana_kerja',$request->kd_rencana_kerja)
            ->update([
                'kd_perusahaan' => $request->nama,
                'ci_r'            => $request->ci,
                'tahun'         => $request->tahun,
                'bulan'         => date('m'),
                'rate_r'          => $request->kurs,
                'aset_r'          => str_replace(',', '.', $request->aset),
                'revenue_r'       => str_replace(',', '.', $request->revenue),
                'beban_pokok_r'   => str_replace(',', '.', $request->beban_pokok),
                'biaya_operasi_r' => str_replace(',', '.', $request->biaya_operasi),
                'laba_bersih_r'   => str_replace(',', '.', $request->laba_bersih),
                'tkp_r'           => str_replace(',', '.', $request->tkp),
                'kpi_r'           => str_replace(',', '.', $request->kpi),
            ]);
            return response()->json();
    }

    public function delete(Request $request)
    {
        DB::table('tbl_rencana_kerja')->where('kd_rencana_kerja', $request->id)->delete();
        return response()->json();
    }
}
