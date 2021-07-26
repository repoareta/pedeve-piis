<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblTabungan;
use DB;
use Illuminate\Http\Request;

class MasterTabunganController extends Controller
{
    public function index()
    {
        return view('master_tabungan.index');
    }

    public function indexJson()
    {
        $data = PayTblTabungan::all();
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
                return '<p align="center"><label  class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.number_format($row->perusahaan,0).'" name="btn-radio"><span></span></label></p>';
        })
        ->addColumn('perusahaan', function ($row) {
             return number_format($row->perusahaan,0);
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    public function create()
    {
        return view('master_tabungan.create');
    }


    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_tabungan"); 			
        if(!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
        PayTblTabungan::insert([
            'perusahaan' => $request->perusahaan,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $data_list = PayTblTabungan::where('perusahaan', $id)->first();
        
        return view('master_tabungan.edit',compact('perusahaan'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        PayTblTabungan::where('perusahaan', $request->kode)
        ->update([
            'perusahaan' => $request->perusahaan,
        ]);

        return response()->json();
    }

    public function delete(Request $request)
    {
        PayTblTabungan::where('perusahaan', $request->kode)
        ->delete();

        return response()->json();
    }
}
