<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Account;
use DB;
use Alert;
use Illuminate\Http\Request;
use App\Http\Requests\SandiPerkiraanStore;

class SandiPerkiraanController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.sandi-perkiraan.index');
    }

    public function indexJson()
    {
        $data = Account::where('kodeacct', '01')->orderByDesc('kodeacct');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" kode="'.$data->kodeacct.'" class="btn-radio" name="btn-radio">
                        <span></span>
                    </label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.sandi-perkiraan.create');
    }
    public function store(SandiPerkiraanStore $request)
    {
        Account::insert([
            'kodeacct' => $request->kodeacct,
            'descacct' => $request->descacct,
            'userid' => auth()->user()->userid
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.sandi_perkiraan.index');
    }

    public function edit($no)
    {
        $data_cash = DB::select("SELECT * from account where kodeacct='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kodeacct;
            $nama = $data->descacct;
        }
        return view('modul-kontroler.tabel.sandi-perkiraan.edit',compact('kode','nama'));
    }
    public function update(Request $request)
    {
        Account::where('kodeacct',$request->kode)
        ->update([
            'descacct' => $request->nama,
            'userid' => auth()->user()->userid
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        Account::where('kodeacct',$request->kode)->delete();
        return response()->json();
    }
}
