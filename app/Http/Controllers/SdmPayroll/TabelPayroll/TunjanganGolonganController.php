<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTunjangan;
use DB;
use Illuminate\Http\Request;

class TunjanganGolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.tunjangan-golongan.index');
    }

    public function indexJson()
    {
        $tunjangan_list = PayTunjangan::all();
        
        return datatables()->of($tunjangan_list)
        ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" golongan="'.$row->golongan.'" name="btn-radio"><span></span></label>';
        })
        ->addColumn('nilai', function ($row) {
            return currency_idr($row->nilai);
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(DB::select("SELECT golongan from pay_tbl_tunjangan where golongan = 'P2'"));
        return view('modul-sdm-payroll.tunjangan-golongan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cekGolonganJson(Request $request)
    {
        $data = PayTunjangan::where('golongan', $request->golongan)->count();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_tbl_tunjangan where golongan='$request->golongan'"); 			
        if(!empty($data_cek)) {
            $data=0;
            return response()->json($data);
        } else {
        PayTunjangan::insert([
            'golongan' => $request->golongan,
            'nilai' => str_replace(',', '.', $request->nilai),
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data_list = PayTunjangan::where('golongan', $id)->get();
        return view('modul-sdm-payroll.tunjangan-golongan.edit',compact('data_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        PayTunjangan::where('golongan', $request->golongan)
            ->update([
                'nilai' => str_replace(',', '.', $request->nilai),
            ]);
            return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayTunjangan::where('golongan', $request->golongan)
        ->delete();
        return response()->json();
    }
}
