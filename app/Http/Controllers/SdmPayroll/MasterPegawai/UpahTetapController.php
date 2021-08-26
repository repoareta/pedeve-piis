<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpahTetapStoreRequest;
use App\Models\MasterPegawai;
use App\Models\UpahTetap;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpahTetapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $upah_tetap_list = UpahTetap::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($upah_tetap_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_upah_tetap" data-ut="'.$row->ut.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('ut', function ($row) {
                return currency_idr($row->ut);
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->sampai)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._upah-tetap-pensiun.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpahTetapStoreRequest $request, MasterPegawai $pegawai)
    {
        $upah             = new UpahTetap;
        $upah->nopeg      = $pegawai->nopeg;
        $upah->ut         = sanitize_nominal($request->nilai_upah_tetap);
        $upah->mulai      = $request->mulai_upah_tetap;
        $upah->sampai     = $request->sampai_upah_tetap;
        $upah->keterangan = $request->keterangan_upah_tetap;
        $upah->userid     = Auth::user()->userid;
        $upah->tglentry   = Carbon::now();

        $upah->save();

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
        $upah = UpahTetap::where('nopeg', $request->nopeg)
        ->where('ut', $request->ut)
        ->first();

        return response()->json($upah, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $nilai)
    {
        $upah = UpahTetap::where('nopeg', $pegawai->nopeg)
        ->where('ut', $nilai)
        ->first();

        $upah->nopeg      = $pegawai->nopeg;
        $upah->ut         = $request->nilai_upah_tetap;
        $upah->mulai      = $request->mulai_upah_tetap;
        $upah->sampai     = $request->sampai_upah_tetap;
        $upah->keterangan = $request->keterangan_upah_tetap;
        $upah->userid     = Auth::user()->userid;

        $upah->save();

        return response()->json($upah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $upah = UpahTetap::where('nopeg', $request->nopeg)
        ->where('ut', $request->ut)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
