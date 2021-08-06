<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;

// use model
use App\Models\JenisBiaya;

// use Request
use App\Http\Requests\JenisBiayaStore;
use App\Http\Requests\JenisBiayaUpdate;
use Illuminate\Http\Request;

// use Plugin
use RealRashid\SweetAlert\Facades\Alert;

class JenisBiayaController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.jenis-biaya.index');
    }

    public function indexJson()
    {
        $data = JenisBiaya::orderBy('kode');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->kode.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.jenis-biaya.create');
    }

    public function store(JenisBiayaStore $request)
    {
        JenisBiaya::insert([
            'kode' => $request->kode,
            'keterangan' => $request->nama
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.jenis_biaya.index');
    }


    public function edit($kode)
    {
        $data = JenisBiaya::where('kode', $kode)->first();
        return view('modul-kontroler.tabel.jenis-biaya.edit',compact('data'));
    }
    public function update(JenisBiayaUpdate $request)
    {
        JenisBiaya::where('kode',$request->kode)
        ->update([
            'keterangan' => $request->keterangan
        ]);

        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.cash_judex.index');
    }

    public function delete(Request $request)
    {
        JenisBiaya::where('kode',$request->kode)->delete();
        return response()->json();
    }
}
