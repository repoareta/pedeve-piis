<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenghargaanStoreRequest;
use App\Models\MasterPegawai;
use App\Models\Penghargaan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_penghargaan" data-tanggal="'.$row->tanggal.'" data-nama="'.$row->nama.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('tanggal', function ($row) {
                return Carbon::parse($row->tanggal)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._penghargaan.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenghargaanStoreRequest $request, MasterPegawai $pegawai)
    {
        $penghargaan = new Penghargaan;
        $penghargaan->nopeg = $pegawai->nopeg;
        $penghargaan->tanggal = $request->tanggal_penghargaan;
        $penghargaan->nama = $request->nama_penghargaan;
        $penghargaan->pemberi = $request->pemberi_penghargaan;
        $penghargaan->userid = Auth::user()->userid;
        $penghargaan->tglentry = Carbon::now();

        $penghargaan->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
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
        Penghargaan::where('nopeg', $request->pegawai)
            ->where('tanggal', $request->tanggal)
            ->where('nama', $request->nama)
            ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
