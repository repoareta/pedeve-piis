<?php

namespace App\Http\Controllers\SdmPayroll\MasterData;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgamaStore;
use App\Http\Requests\AgamaUpdate;
use App\Models\Agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.master-data.agama.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $agama_list = Agama::orderBy('kode', 'desc')->get();

        return datatables()->of($agama_list)
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
        return view('modul-sdm-payroll.master-data.agama.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgamaStore $request, Agama $agama)
    {
        $agama->kode = $request->kode;
        $agama->nama = $request->nama;
        $agama->save();

        Alert::success('Simpan Data Agama', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.agama.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Agama $agama)
    {
        return view('modul-sdm-payroll.master-data.agama.edit', compact('agama'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgamaUpdate $request, Agama $agama)
    {
        $agama->kode = $request->kode;
        $agama->nama = $request->nama;
        $agama->save();

        Alert::success('Ubah Data Agama', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.agama.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Agama::find($request->id)->delete();

        return response()->json();
    }
}
