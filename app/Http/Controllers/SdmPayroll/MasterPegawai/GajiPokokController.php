<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\GajiPokokStoreRequest;
use App\Http\Requests\GajiPokokUpdate;
use App\Models\GajiPokok;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GajiPokokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $gaji_pokok_list = GajiPokok::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($gaji_pokok_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_gaji_pokok" data-gapok="'.$row->gapok.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('gapok', function ($row) {
                return currency_idr($row->gapok);
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._gaji-pokok.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GajiPokokStoreRequest $request, MasterPegawai $pegawai)
    {
        $gaji_pokok = new GajiPokok;
        $gaji_pokok->nopeg = $pegawai->nopeg;
        $gaji_pokok->mulai = $request->mulai_gaji_pokok;
        $gaji_pokok->sampai = $request->sampai_gaji_pokok;
        $gaji_pokok->gapok = sanitize_nominal($request->nilai_gaji_pokok);
        $gaji_pokok->keterangan = $request->keterangan_gaji_pokok;
        $gaji_pokok->userid = Auth::user()->userid;
        $gaji_pokok->tglentry = Carbon::now();

        $gaji_pokok->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    public function edit(MasterPegawai $pegawai, $nilai)
    {
        $gajiPokok = GajiPokok::where('nopeg', $pegawai->nopeg)
            ->where('gapok', $nilai)
            ->first();

        return view('modul-sdm-payroll.master-pegawai._gaji-pokok.edit', compact(
            'gajiPokok',
            'nilai',
            'pegawai',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $gaji_pokok = GajiPokok::where('nopeg', $request->nopeg)
            ->where('gapok', $request->gapok)
            ->first();

        return response()->json($gaji_pokok, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GajiPokokUpdate $request, MasterPegawai $pegawai, $nilai)
    {
        $gaji_pokok = GajiPokok::where('nopeg', $pegawai->nopeg)
            ->where('gapok', $nilai)
            ->first();

        $gaji_pokok->nopeg = $pegawai->nopeg;
        $gaji_pokok->mulai = $request->mulai_gaji_pokok;
        $gaji_pokok->sampai = $request->sampai_gaji_pokok;
        $gaji_pokok->gapok = sanitize_nominal($request->nilai_gaji_pokok);
        $gaji_pokok->keterangan = $request->keterangan_gaji_pokok;
        $gaji_pokok->userid = Auth::user()->userid;
        $gaji_pokok->tglentry = Carbon::now();

        $gaji_pokok->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        GajiPokok::where('nopeg', $request->pegawai)
                ->where('gapok', $request->gapok)
                ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
