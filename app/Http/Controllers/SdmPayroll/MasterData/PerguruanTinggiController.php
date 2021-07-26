<?php

namespace App\Http\Controllers\SdmPayroll\MasterData;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerguruanTinggiStore;
use App\Http\Requests\PerguruanTinggiUpdate;
use App\Models\PerguruanTinggi;
use Illuminate\Http\Request;

class PerguruanTinggiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('perguruan_tinggi.index');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson()
    {
        $perguruan_tinggi_list = PerguruanTinggi::orderBy('kode', 'desc')->get();

        return datatables()->of($perguruan_tinggi_list)
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
        return view('perguruan_tinggi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerguruanTinggiStore $request, PerguruanTinggi $perguruan_tinggi)
    {
        $perguruan_tinggi->kode = $request->kode;
        $perguruan_tinggi->nama = $request->nama;
        $perguruan_tinggi->save();

        Alert::success('Simpan Data Perguruan Tinggi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('perguruan_tinggi.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PerguruanTinggi $perguruan_tinggi)
    {
        return view('perguruan_tinggi.edit', compact('perguruan_tinggi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerguruanTinggiUpdate $request, PerguruanTinggi $perguruan_tinggi)
    {
        $perguruan_tinggi->kode = $request->kode;
        $perguruan_tinggi->nama = $request->nama;
        $perguruan_tinggi->save();

        Alert::success('Ubah Data Perguruan Tinggi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('perguruan_tinggi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PerguruanTinggi::find($request->id)
        ->delete();

        return response()->json();
    }
}
