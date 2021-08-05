<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\CashJudex;
use DB;
use Illuminate\Http\Request;

class CashJudexController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.cash-judex.index');
    }

    public function indexJson(Request $request)
    {
        $data = DB::select("SELECT a.* from cashjudex a order by a.kode");
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->kode.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.cash-judex.create');
    }

    public function store(Request $request)
    {
        $data_objRs = DB::select("SELECT kode from CashJudex where kode='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        } else {
            CashJudex::insert([
                'kode' => $request->kode,
                'nama' => $request->nama
            ]);
            $data = 1;
            return response()->json($data);
        }

    }

    public function edit($no)
    {
        $data_cash = DB::select("SELECT * from CashJudex where kode='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
        }
        return view('modul-kontroler.cash-judex.edit',compact('kode','nama'));
    }
    
    public function update(Request $request)
    {
        CashJudex::where('kode',$request->kode)
        ->update([
            'nama' => $request->nama
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        CashJudex::where('kode',$request->kode)->delete();
        return response()->json();
    }
}
