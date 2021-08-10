<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;

// use Model
use App\Models\CashJudex;

// use request
use Illuminate\Http\Request;
use App\Http\Requests\CashJudexStore;
use App\Http\Requests\CashJudexUpdate;

// use Plugin
use RealRashid\SweetAlert\Facades\Alert;

class CashJudexController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.cash-judex.index');
    }

    public function indexJson()
    {
        $data = CashJudex::orderBy('kode');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '
                        <label class="radio radio-outline radio-outline-2x radio-primary">
                            <input type="radio" kode="'.$data->kode.'" class="btn-radio" name="btn-radio">
                            <span></span>
                        </label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.cash-judex.create');
    }

    public function store(CashJudexStore $request)
    {
        CashJudex::insert([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.cash_judex.index');
    }

    public function edit($kode)
    {
        $data = CashJudex::where('kode', $kode)->first();

        return view('modul-kontroler.tabel.cash-judex.edit',compact('data'));
    }
    
    public function update(CashJudexUpdate $request)
    {
        CashJudex::where('kode',$request->kode)
        ->update([
            'nama' => $request->nama
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.cash_judex.index');
    }

    public function delete(Request $request)
    {
        CashJudex::where('kode',$request->kode)->delete();
        return response()->json();
    }
}
