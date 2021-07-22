<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use DB;
use Illuminate\Http\Request;

class LokasiKontrolerController extends Controller
{
    public function index()
    {
        return view('lokasi_kontroler.index');
    }

    public function searchIndex(Request $request)
    {
        $data = DB::select("select a.* from lokasi a ORDER BY a.kodelokasi");
        return datatables()->of($data)
        ->addColumn('kode', function ($data) {
            return $data->kodelokasi;
       })
        ->addColumn('nama', function ($data) {
            return $data->nama;
       })
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" kode="'.$data->kodelokasi.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('lokasi_kontroler.create');
    }
    public function store(Request $request)
    {
        $data_objRs = DB::select("select kodelokasi from lokasi where kodelokasi='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        }else{
            Lokasi::insert([
                'kodelokasi' => $request->kode,
                'nama' => $request->nama
            ]);
            $data = 1;
            return response()->json($data);
        }

    }

    public function edit($no)
    {
        $data_cash = DB::select("select * from lokasi where kodelokasi='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kodelokasi;
            $nama = $data->nama;
        }
        return view('lokasi_kontroler.edit',compact('kode','nama'));
    }
    public function update(Request $request)
    {
        Lokasi::where('kodelokasi',$request->kode)
        ->update([
            'nama' => $request->nama
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        Lokasi::where('kodelokasi',$request->kode)->delete();
        return response()->json();
    }
}
