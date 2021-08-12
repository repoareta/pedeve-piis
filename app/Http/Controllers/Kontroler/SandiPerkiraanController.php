<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Account;
use DB;
use Alert;
use Illuminate\Http\Request;
use App\Http\Requests\SandiPerkiraanStore;
use App\Http\Requests\SandiPerkiraanUpdate;

class SandiPerkiraanController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.sandi-perkiraan.index');
    }

    public function indexJson()
    {
        $data = Account::orderByDesc('kodeacct');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" value="'.$data->kodeacct.'" class="btn-radio" name="btn-radio">
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

    public function edit($kode)
    {
        $data_sanper = Account::where('kodeacct', $kode)->firstOrFail();
        return view('modul-kontroler.tabel.sandi-perkiraan.edit', compact('data_sanper'));
    }

    public function update(SandiPerkiraanUpdate $request)
    {
        Account::where('kodeacct',$request->kodeacct)
        ->update([
            'descacct' => $request->descacct,
            'userid' => auth()->user()->userid
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.sandi_perkiraan.index');
    }

    public function delete(Request $request)
    {
        Account::where('kodeacct',$request->kode)->delete();
        return response()->json();
    }
}
