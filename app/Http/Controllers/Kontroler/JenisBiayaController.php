<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\JenisBiaya;
use DB;
use Illuminate\Http\Request;

class JenisBiayaController extends Controller
{
    public function index()
    {
        return view('jenis_biaya.index');
    }

    public function searchIndex(Request $request)
    {
        $data = DB::select("select a.* from jenisbiaya a order by a.kode");
        return datatables()->of($data)
        ->addColumn('kode', function ($data) {
            return $data->kode;
       })
        ->addColumn('nama', function ($data) {
            return $data->keterangan;
       })
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" kode="'.$data->kode.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('jenis_biaya.create');
    }
    public function store(Request $request)
    {
        $data_objRs = DB::select("select kode from jenisbiaya where kode='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        }else{
            JenisBiaya::insert([
                'kode' => $request->kode,
                'keterangan' => $request->nama
            ]);
            $data = 1;
            return response()->json($data);
        }

    }

    public function edit($no)
    {
        $data_cash = DB::select("select * from jenisbiaya where kode='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kode;
            $nama = $data->keterangan;
        }
        return view('jenis_biaya.edit',compact('kode','nama'));
    }
    public function update(Request $request)
    {
        JenisBiaya::where('kode',$request->kode)
        ->update([
            'keterangan' => $request->nama
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        JenisBiaya::where('kode',$request->kode)->delete();
        return response()->json();
    }
}
