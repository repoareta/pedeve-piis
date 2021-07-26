<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblJenisUpah;
use DB;
use Illuminate\Http\Request;

class JenisUpahController extends Controller
{
    public function index()
    {
        return view('jenis_upah.index');
    }

    public function indexJson()
    {
        $tunjangan_list = PayTblJenisUpah::all();
        
        return datatables()->of($tunjangan_list)
        ->addColumn('radio', function ($row) {
                return '<p align="center"><label  class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.$row->kode.'" name="btn-radio"><span></span></label></p>';
        })
        ->addColumn('kode', function ($row) {
             return '<p align="center">'.$row->kode.'</p>';
        })
        ->addColumn('nama', function ($row) {
             return '<p align="left">'.$row->nama.'</p>';
        })
        ->addColumn('cetak', function ($row) {
             return '<p align="center">'.$row->cetak.'</p>';
        })
        ->rawColumns(['radio','kode','nama','cetak'])
            ->make(true);
    }


    public function create()
    {
        return view('jenis_upah.create');
    }


    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_jenisupah where kode = '$request->kode'" ); 			
        if(!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
        PayTblJenisUpah::insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'cetak' => $request->cetak,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }


    public function edit($id)
    {
        $data_list = PayTblJenisUpah::where('kode', $id)->get();
        foreach($data_list as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
            $cetak = $data->cetak;
        }
        return view('jenis_upah.edit',compact('kode','nama','cetak'));
    }


    public function update(Request $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->update([
            'nama' => $request->nama,
            'cetak' => $request->cetak,
        ]);

        return response()->json();
    }


    public function delete(Request $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->delete();

        return response()->json();
    }
}
