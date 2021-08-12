<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterBankStoreRequest;
use App\Models\PayTblBank;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasterBankController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.master-bank.index');
    }

    public function indexJson()
    {
        $data = DB::select("SELECT kode, nama, alamat, kota from pay_tbl_bank order by kode asc");

        return datatables()->of($data)
            ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="' . $row->kode . '" name="btn-radio"><span></span><label>';
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create()
    {
        return view('modul-sdm-payroll.master-bank.create');
    }

    public function store(MasterBankStoreRequest $request)
    {
        PayTblBank::insert($request->validated());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_bank.index');
    }

    public function edit($id)
    {
        $bank = PayTblBank::where('kode', $id)->first();
        
        return view('modul-sdm-payroll.master-bank.edit', compact('bank'));
    }

    public function update(Request $request)
    {
        PayTblBank::where('kode', $request->kode)
            ->update(
                $request->only(['nama', 'alamat', 'kota'])
            );

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_bank.index');
    }

    public function delete(Request $request)
    {
        PayTblBank::where('kode', $request->kode)
            ->delete();
        return response()->json();
    }
}
