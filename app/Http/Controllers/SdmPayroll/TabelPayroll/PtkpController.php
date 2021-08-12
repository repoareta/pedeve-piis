<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterPTKPStoreRequest;
use App\Models\PayTblPtkp;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PtkpController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.master-ptkp.index');
    }

    public function indexJson()
    {
        $data = PayTblPtkp::all();
        
        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.$row->kdkel.'" name="btn-radio"><span></span><label>';
        })
        ->addColumn('nilai', function ($row) {
             return currency_format($row->nilai);
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    public function create()
    {
        return view('modul-sdm-payroll.master-ptkp.create');
    }

    public function store(MasterPTKPStoreRequest $request)
    {
        PayTblPtkp::insert($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_ptkp.index');
    }


    public function edit($id)
    {
        $ptkp = PayTblPtkp::where('kdkel', $id)->first();

        return view('modul-sdm-payroll.master-ptkp.edit',compact('ptkp'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $request->nilai = str_replace(',', '.', $request->nilai);

        PayTblPtkp::where('kdkel', $request->kdkel)
                ->update(
                    $request->only('nilai')
                );

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_ptkp.index');
    }


    public function delete(Request $request)
    {
        PayTblPtkp::where('kdkel', $request->kode)
        ->delete();

        return response()->json();
    }
}
