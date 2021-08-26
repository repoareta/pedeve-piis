<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpahTetapPensiunStoreRequest;
use App\Models\MasterPegawai;
use App\Models\UpahTetapPensiun;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpahTetapPensiunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $upah_tetap_pensiun_list = UpahTetapPensiun::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($upah_tetap_pensiun_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_upah_tetap_pensiun" data-ut="' . $row->ut . '"><span></span></label>';
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
    public function store(UpahTetapPensiunStoreRequest $request, MasterPegawai $pegawai, UpahTetapPensiun $upah)
    {
        $upah->nopeg      = $pegawai->nopeg;
        $upah->ut         = sanitize_nominal($request->nilai_upah_tetap_pensiun);
        $upah->mulai      = $request->mulai_upah_tetap_pensiun;
        $upah->sampai     = $request->sampai_upah_tetap_pensiun;
        $upah->keterangan = $request->keterangan_upah_tetap_pensiun;
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
    public function edit(Request $request)
    {
        $upah = UpahTetapPensiun::where('nopeg', $request->nopeg)
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
        $upah = UpahTetapPensiun::where('nopeg', $pegawai->nopeg)
            ->where('ut', $nilai)
            ->first();

        $upah->nopeg      = $pegawai->nopeg;
        $upah->ut         = $request->nilai_upah_tetap_pensiun;
        $upah->mulai      = $request->mulai_upah_tetap_pensiun;
        $upah->sampai     = $request->sampai_upah_tetap_pensiun;
        $upah->keterangan = $request->keterangan_upah_tetap_pensiun;
        $upah->userid     = Auth::user()->userid;
        $upah->tglentry   = Carbon::now();

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
        $upah = UpahTetapPensiun::where('nopeg', $request->nopeg)
            ->where('ut', $request->ut)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
