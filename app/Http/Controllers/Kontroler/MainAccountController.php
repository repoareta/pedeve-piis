<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\MainAccount;
use DB;
use Illuminate\Http\Request;
use Alert;
use App\Http\Requests\MainAccountStore;

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
                        <input type="radio" kode="'.$data->jenis.'" class="btn-radio" name="btn-radio">
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

    public function edit($no)
    {
        $data_cash = DB::select("SELECT * from main_account where jenis='$no'");
        foreach($data_cash as $data)
        {
            $jenis = $data->jenis;
            $batasawal= $data->batas_awal;
            $batasakhir= $data->batas_akhir;
            $urutan = $data->urutan;
            $pengali = $data->pengali;
            $pengalitampil = $data->pengali_tampil;
            $subakun = $data->sub_akun;
            $lokasi = $data->lokasi;
        }
        return view('modul-kontroler.tabel.main-account.edit',compact('jenis','batasawal','batasakhir','urutan','pengali','pengalitampil','subakun','lokasi'));
    }
    public function update(Request $request)
    {
        $jenis = $request->jenis;
        $batasawal= $request->batasawal;
        $batasakhir= $request->batasakhir;
        $urutan = $request->urutan;
        $pengali = $request->pengali;
        $pengalitampil = $request->pengalitampil;
        $subakun = $request->subakun;
        $lokasi = $request->lokasi;
        MainAccount::where('jenis',$jenis)
        ->update([
            'batas_awal' => $batasawal,
            'batas_akhir' => $batasakhir,
            'urutan' => $urutan,
            'pengali' => $pengali,
            'pengali_tampil' => $pengalitampil,
            'sub_akun' => $subakun,
            'lokasi' => $lokasi 
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        MainAccount::where('jenis',$request->kode)->delete();
        return response()->json();
    }
}
