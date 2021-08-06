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
        return view('modul-kontroler.tabel.lokasi-kontroler.index');
    }

    public function indexJson()
    {
        $data = Lokasi::orderByDesc('kodelokasi');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->kodelokasi.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.lokasi-kontroler.create');
    }
    public function store(Request $request)
    {
        $data_objRs = DB::select("SELECT kodelokasi from lokasi where kodelokasi='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        } else {
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
        $data_cash = DB::select("SELECT * from lokasi where kodelokasi='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kodelokasi;
            $nama = $data->nama;
        }
        return view('modul-kontroler.tabel.lokasi-kontroler.edit',compact('kode','nama'));
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
