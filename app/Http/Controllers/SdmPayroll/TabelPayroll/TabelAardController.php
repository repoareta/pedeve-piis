<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblAard;
use DB;
use Alert;
use App\Http\Requests\TabelAardStore;
use Illuminate\Http\Request;

class TabelAardController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.tabel-aard.index');
    }

    public function indexJson()
    {
        $data = DB::select("SELECT kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard order by kode");
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
            return '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" class="btn-radio" kode="'.$row->kode.'" name="btn-radio">
                        <span></span>
                    <label>';
        })
        ->rawColumns(['radio'])
        ->make(true);
    }


    public function create()
    {
        $data_jenisupah = DB::select("SELECT kode,nama,cetak from pay_tbl_jenisupah order by kode");
        
        return view('modul-sdm-payroll.tabel-aard.create',compact('data_jenisupah'));
    }


    public function store(TabelAardStore $request)
    {
        PayTblAard::insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'kenapajak' => $request->kenapajak,
            'lappajak' => $request->lappajak,
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.tabel_aard.index');
    }


    public function edit($id)
    {
        $data_jenisupah = DB::select("SELECT kode,nama,cetak from pay_tbl_jenisupah order by kode");
        $data_list = PayTblAard::where('kode', $id)->get();
        foreach($data_list as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
            $jenis = $data->jenis;
            $kenapajak = $data->kenapajak;
            $lappajak = $data->lappajak;
        }
        return view('modul-sdm-payroll.tabel-aard.edit',compact('kode','nama','jenis','kenapajak','lappajak','data_jenisupah'));
    }


    public function update(Request $request)
    {
        PayTblAard::where('kode', $request->kode)
        ->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'kenapajak' => $request->kenapajak,
            'lappajak' => $request->lappajak,
        ]);

        return response()->json();
    }


    public function delete(Request $request)
    {
        PayTblAard::where('kode', $request->kode)
        ->delete();

        return response()->json();
    }
}
