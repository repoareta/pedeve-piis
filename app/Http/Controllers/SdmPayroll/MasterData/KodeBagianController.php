<?php

namespace App\Http\Controllers\SdmPayroll\MasterData;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\KodeBagianStore;
use App\Http\Requests\KodeBagianUpdate;
use App\Models\KodeBagian;
use Illuminate\Http\Request;

class KodeBagianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kode_bagian.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $kode_bagian_list = KodeBagian::orderBy('kode', 'desc')->get();

        return datatables()->of($kode_bagian_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kode_bagian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KodeBagianStore $request, KodeBagian $kode_bagian)
    {
        $kode_bagian->kode = $request->kode;
        $kode_bagian->nama = $request->nama;
        $kode_bagian->save();

        Alert::success('Simpan Data Kode Bagian', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('kode_bagian.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeBagian $kode_bagian)
    {
        return view('kode_bagian.edit', compact('kode_bagian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KodeBagianUpdate $request, KodeBagian $kode_bagian)
    {
        $kode_bagian->kode = $request->kode;
        $kode_bagian->nama = $request->nama;
        $kode_bagian->save();

        Alert::success('Ubah Data Kode Bagian', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('kode_bagian.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        KodeBagian::find($request->id)->delete();

        return response()->json();
    }
}
