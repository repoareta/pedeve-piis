<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTunjangan;
use DB;
use Alert;
use Illuminate\Http\Request;
use App\Http\Requests\TunjanganGolonganStore;

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
            return '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" class="btn-radio" value="'.$row->golongan.'" name="btn-radio">
                            <span></span>
                    </label>';
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

    public function store(TunjanganGolonganStore $request)
    {
        PayTunjangan::insert([
            'golongan' => $request->golongan,
            'nilai' => sanitize_nominal($request->nilai),
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.tunjangan_golongan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode)
    {
        $data = PayTunjangan::where('golongan', $kode)->first();
        return view('modul-sdm-payroll.tunjangan-golongan.edit',compact('data'));
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

        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.tunjangan_golongan.index');
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
