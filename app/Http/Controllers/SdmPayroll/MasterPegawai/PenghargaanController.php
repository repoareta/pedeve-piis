<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Models\MasterPegawai;
use App\Models\Penghargaan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $penghargaan_list = Penghargaan::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($penghargaan_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_penghargaan" value="'.$row->nopeg.'_'.$row->tanggal.'_'.$row->nama.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MasterPegawai $pegawai)
    {
        $penghargaan = new Penghargaan;
        $penghargaan->nopeg = $pegawai->nopeg;
        $penghargaan->tanggal = $request->tanggal_penghargaan;
        $penghargaan->nama = $request->nama_penghargaan;
        $penghargaan->pemberi = $request->pemberi_penghargaan;
        $penghargaan->userid = Auth::user()->userid;
        $penghargaan->tglentry = Carbon::now();

        $penghargaan->save();

        return response()->json($penghargaan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $penghargaan = Penghargaan::where('nopeg', $request->nopeg)
        ->where('tanggal', $request->tanggal)
        ->where('nama', $request->nama)
        ->first();

        return response()->json($penghargaan, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $tanggal, $nama)
    {
        $penghargaan = Penghargaan::where('nopeg', $pegawai->nopeg)
        ->where('tanggal', $request->tanggal)
        ->where('nama', $request->nama)
        ->first();

        $penghargaan->nopeg = $pegawai->nopeg;
        $penghargaan->tanggal = $request->tanggal_penghargaan;
        $penghargaan->nama = $request->nama_penghargaan;
        $penghargaan->pemberi = $request->pemberi_penghargaan;
        $penghargaan->userid = Auth::user()->userid;

        $penghargaan->save();

        return response()->json($penghargaan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $penghargaan = Penghargaan::where('nopeg', $request->nopeg)
        ->where('tanggal', $request->tanggal)
        ->where('nama', $request->nama)
        ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
