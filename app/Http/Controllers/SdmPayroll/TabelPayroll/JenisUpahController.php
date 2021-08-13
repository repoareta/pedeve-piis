<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblJenisUpah;
use DB;
use Alert;
use App\Http\Requests\JenisUpahStore;
use App\Http\Requests\JenisUpahUpdate;
use Illuminate\Http\Request;

class JenisUpahController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.jenis-upah.index');
    }

    public function indexJson()
    {
        $jenisUpah = PayTblJenisUpah::all();
        
        return datatables()->of($jenisUpah)
        ->addColumn('radio', function ($row) {
                return '
                        <label class="radio radio-outline radio-outline-2x radio-primary">
                            <input type="radio" class="btn-radio" value="'.$row->kode.'" name="btn-radio">
                                <span></span>
                        <label>';
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
        return view('modul-sdm-payroll.jenis-upah.create');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(JenisUpahStore $request)
    {
        PayTblJenisUpah::insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'cetak' => $request->cetak,
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.jenis_upah.index');
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function edit($kode)
    {
        $data = PayTblJenisUpah::where('kode', $kode)->first();
        return view('modul-sdm-payroll.jenis-upah.edit',compact('data'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(JenisUpahUpdate $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->update([
            'nama' => $request->nama,
            'cetak' => $request->cetak,
        ]);

        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.jenis_upah.index');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->delete();

        return response()->json();
    }
}
