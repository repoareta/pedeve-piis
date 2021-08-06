<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Auth;
use DB;
use Illuminate\Http\Request;

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
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->kodeacct.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.sandi-perkiraan.create');
    }
    public function store(Request $request)
    {
        $data_objRs = DB::select("SELECT kodeacct from account where kodeacct='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        } else {
            $userid = Auth::user()->userid;
            Account::insert([
                'kodeacct' => $request->kode,
                'descacct' => $request->nama,
                'userid' => $userid
            ]);
            $data = 1;
            return response()->json($data);
        }

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
        $userid = Auth::user()->userid;
        Account::where('kodeacct',$request->kode)
        ->update([
            'descacct' => $request->nama,
            'userid' => $userid
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        Account::where('kodeacct',$request->kode)->delete();
        return response()->json();
    }
}
