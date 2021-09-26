<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterTabunganStoreRequest;
use App\Models\PayTblTabungan;
use DB;
use Illuminate\Http\Request;

class MasterTabunganController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.master-tabungan.index');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson()
    {
        $data = PayTblTabungan::all();

        return datatables()->of($data)
        ->addColumn('radio', function ($row) {
            return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.number_format($row->perusahaan, 0).'" name="btn-radio"><span></span><label>';
        })
        ->addColumn('perusahaan', function ($row) {
            return number_format($row->perusahaan, 0);
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        return view('modul-sdm-payroll.master-tabungan.create');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param PayTblTabungan $masterTabungan
     * @return void
     */
    public function store(MasterTabunganStoreRequest $request, PayTblTabungan $masterTabungan)
    {
        $masterTabungan->perusahaan = sanitize_nominal($request->perusahaan);

        $masterTabungan->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_tabungan.index');
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function edit(PayTblTabungan $masterTabungan)
    {
        return view('modul-sdm-payroll.master-tabungan.edit', compact('masterTabungan'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request, PayTblTabungan $masterTabungan)
    {
        $masterTabungan->perusahaan = $request->perusahaan;

        $masterTabungan->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_tabungan.index');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        PayTblTabungan::where('perusahaan', $request->kode)
        ->delete();

        return response()->json();
    }
}
