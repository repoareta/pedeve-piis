<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblAard;
use DB;
use Illuminate\Http\Request;

class TabelAardController extends Controller
{
    public function index()
    {
        return view('tabel_aard.index');
    }

    public function indexJson()
    {
        $data = DB::select("select kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard order by kode");
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
                return '<p align="center"><label  class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" class="btn-radio" kode="'.$row->kode.'" name="btn-radio"><span></span></label></p>';
        })
        ->rawColumns(['radio'])
            ->make(true);
    }


    public function create()
    {
        $data_jenisupah = DB::select("select kode,nama,cetak from pay_tbl_jenisupah order by kode");
        return view('tabel_aard.create',compact('data_jenisupah'));
    }


    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_aard where kode = '$request->kode'" ); 			
        if(!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
            PayTblAard::insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'kenapajak' => $request->kenapajak,
                'lappajak' => $request->lappajak,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }


    public function edit($id)
    {
        $data_jenisupah = DB::select("select kode,nama,cetak from pay_tbl_jenisupah order by kode");
        $data_list = PayTblAard::where('kode', $id)->get();
        foreach($data_list as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
            $jenis = $data->jenis;
            $kenapajak = $data->kenapajak;
            $lappajak = $data->lappajak;
        }
        return view('tabel_aard.edit',compact('kode','nama','jenis','kenapajak','lappajak','data_jenisupah'));
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
