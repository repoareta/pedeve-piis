<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblBank;
use DB;
use Illuminate\Http\Request;

class MasterBankController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.master-bank.index');
    }

    public function indexJson()
    {
        $data = DB::select("select kode, nama, alamat, kota from pay_tbl_bank order by kode asc");
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.$row->kode.'" name="btn-radio"><span></span><label>';
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    public function create()
    {
        return view('modul-sdm-payroll.master-bank.create');
    }

    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_bank where kode = '$request->kode'" ); 			
        if(!empty($data_cek)){
            $data=2;
            return response()->json($data);
        }else {
        PayTblBank::insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($id)
    {
        $data_list = PayTblBank::where('kode', $id)->get();
        foreach($data_list as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
            $alamat = $data->alamat;
            $kota = $data->kota;
        }
        return view('modul-sdm-payroll.master-bank.edit',compact('kode','nama','alamat','kota'));
    }

    public function update(Request $request)
    {
        PayTblBank::where('kode', $request->kode)
            ->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
            ]);
            return response()->json();
    }

    public function delete(Request $request)
    {
        PayTblBank::where('kode', $request->kode)
        ->delete();
        return response()->json();
    }
}
