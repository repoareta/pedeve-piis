<?php

namespace App\Http\Controllers\SdmPayroll\MasterData;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinsiStore;
use App\Http\Requests\ProvinsiUpdate;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.master-data.provinsi.index');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson()
    {
        $provinsi_list = Provinsi::orderBy('kode', 'desc')->get();

        return datatables()->of($provinsi_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode.'"><span></span></label>';
                return $radio;
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
        return view('modul-sdm-payroll.master-data.provinsi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinsiStore $request, Provinsi $provinsi)
    {
        $provinsi->kode = $request->kode;
        $provinsi->nama = $request->nama;
        $provinsi->save();

        Alert::success('Simpan Data Provinsi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.provinsi.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Provinsi $provinsi)
    {
        return view('modul-sdm-payroll.master-data.provinsi.edit', compact('provinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinsiUpdate $request, Provinsi $provinsi)
    {
        $provinsi->kode = $request->kode;
        $provinsi->nama = $request->nama;
        $provinsi->save();

        Alert::success('Ubah Data Provinsi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.provinsi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Provinsi::find($request->id)
        ->delete();

        return response()->json();
    }
}
