<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MasterPerusahaanController extends Controller
{
    public function index()
    {
        return view('master_perusahaan.index');
    }

   public function indexJson(Request $request)
    {
        $data = DB::select("select * from tab_tbl_prshn");
        return datatables()->of($data)
        ->addColumn('kode', function ($data) {
            return $data->kode;
       })
        ->addColumn('nama', function ($data) {
            return $data->nama;
       })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->kode.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('master_perusahaan.create');
    }

    public function store(Request $request)
    {
        $data = DB::select("select * from tab_tbl_prshn where kode='$request->kode'");
        if(!empty($data)){
            $data = 2;
            return response()->json($data);
        }else{
        DB::table('tab_tbl_prshn')->insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($kode)
    {
        $data = DB::select("select * from tab_tbl_prshn where kode='$kode'");
        foreach($data as $dat)
        {
            $kode = $dat->kode;
            $nama = $dat->nama;
        }
        return view('master_perusahaan.edit',compact('kode','nama'));
    }

    public function update(Request $request)
    {
        DB::table('tab_tbl_prshn')->where('kode', $request->kode)
        ->update([
            'nama' => $request->nama,
            ]);
            return response()->json();
    }

    public function delete(Request $request)
    {
        DB::table('tab_tbl_prshn')->where('kode', $request->kode)->delete();
            return response()->json();
    }
}
