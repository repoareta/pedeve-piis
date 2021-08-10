<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use DB;
use Alert;
use Illuminate\Http\Request;
use App\Http\Requests\LokasiKontrolerStore;

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
            $radio = '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" kode="'.$data->kodelokasi.'" class="btn-radio" name="btn-radio">
                        <span></span>
                    </label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.lokasi-kontroler.create');
    }

    public function store(LokasiKontrolerStore $request)
    {
        Lokasi::insert([
            'kodelokasi' => $request->kodelokasi,
            'nama' => $request->nama
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.lokasi_kontroler.index');
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
