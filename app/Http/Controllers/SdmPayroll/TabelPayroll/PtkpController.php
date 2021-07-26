<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblPtkp;
use DB;
use Illuminate\Http\Request;

class PtkpController extends Controller
{
    public function index()
    {
        return view('master_ptkp.index');
    }

    public function indexJson()
    {
        $data = PayTblPtkp::all();
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
                return '<p align="center"><label  class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" class="btn-radio" kode="'.$row->kdkel.'" name="btn-radio"><span></span></label></p>';
        })
        ->addColumn('nilai', function ($row) {
             return number_format($row->nilai,2,'.',',');
        })
        ->rawColumns(['radio'])
            ->make(true);
    }

    public function create()
    {
        return view('master_ptkp.create');
    }

    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_ptkp where kdkel = '$request->kdkel'" ); 			
        if(!empty($data_cek)) {
            $data = 2;
            
            return response()->json($data);
        } else {
            PayTblPtkp::insert([
                'kdkel' => $request->kdkel,
                'nilai' => str_replace(',', '.', $request->nilai),
            ]);
            $data = 1;

            return response()->json($data);
        }
    }


    public function edit($id)
    {
        $data_list = PayTblPtkp::where('kdkel', $id)->get();
        foreach($data_list as $data)
        {
            $kdkel = $data->kdkel;
            $nilai = $data->nilai;
        }
        return view('master_ptkp.edit',compact('kdkel','nilai'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        PayTblPtkp::where('kdkel', $request->kdkel)
        ->update([
            'nilai' => str_replace(',', '.', $request->nilai),
        ]);

        return response()->json();
    }


    public function delete(Request $request)
    {
        PayTblPtkp::where('kdkel', $request->kode)
        ->delete();

        return response()->json();
    }
}
