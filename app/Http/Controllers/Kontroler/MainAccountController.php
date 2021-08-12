<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\MainAccount;
use DB;
use Illuminate\Http\Request;
use Alert;
use App\Http\Requests\MainAccountStore;
use App\Http\Requests\MainAccountUpdate;

class MainAccountController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.main-account.index');
    }

    public function indexJson()
    {
        $data = MainAccount::orderByDesc('jenis');
        return datatables()->of($data)
        ->addColumn('pengali', function ($data) {
            return number_format($data->pengali,0,'.',',');
        })
        ->addColumn('pengali_tampil', function ($data) {
            return number_format($data->pengali_tampil,0,'.',',');
        })
        ->addColumn('radio', function ($data) {
            $radio = '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" value="'.$data->jenis.'" class="btn-radio" name="btn-radio">
                            <span></span>
                    </label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.main-account.create');
    }

    public function store(MainAccountStore $request)
    {
        MainAccount::insert([
            'jenis' => $request->jenis,
            'batas_awal' => $request->batas_awal,
            'batas_akhir' => $request->batas_akhir,
            'urutan' => $request->urutan,
            'pengali' => $request->pengali,
            'pengali_tampil' => $request->pengali_tampil,
            'sub_akun' => $request->sub_akun,
            'lokasi' => $request->lokasi 
        ]);        
    
        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.main_account.index');
    }

    public function edit($kode)
    {
        $data = MainAccount::where('jenis', $kode)->first();

        return view('modul-kontroler.tabel.main-account.edit',compact('data'));
    }

    public function update(MainAccountUpdate $request)
    {
        MainAccount::where('jenis', $request->jenis)
        ->update([
            'batas_awal' => $request->batas_awal,
            'batas_akhir' => $request->batas_akhir,
            'urutan' => $request->urutan,
            'pengali' => $request->pengali,
            'pengali_tampil' => $request->pengali_tampil,
            'sub_akun' => $request->sub_akun,
            'lokasi' => $request->lokasi 
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.main_account.index');
    }

    public function delete(Request $request)
    {
        MainAccount::where('jenis',$request->kode)->delete();
        return response()->json();
    }
}
