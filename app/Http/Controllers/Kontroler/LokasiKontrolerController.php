<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use DB;
use Alert;
use Illuminate\Http\Request;
use App\Http\Requests\LokasiKontrolerStore;
use App\Http\Requests\LokasiKontrolerUpdate;

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
                        <input type="radio" value="'.$data->kodelokasi.'" class="btn-radio" name="btn-radio">
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


    public function edit($kode)
    {
        $data_lokasi = Lokasi::where('kodelokasi', $kode)->first();
        return view('modul-kontroler.tabel.lokasi-kontroler.edit',compact('data_lokasi'));
    }

    public function update(LokasiKontrolerUpdate $request)
    {
        Lokasi::where('kodelokasi',$request->kodelokasi)
        ->update([
            'nama' => $request->nama
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.lokasi_kontroler.index');
    }

    public function delete(Request $request)
    {
        Lokasi::where('kodelokasi',$request->kode)->delete();
        return response()->json();
    }
}
