<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Models\GajiPokok;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_gaji_pokok" value="'.$row->nopeg.'-'.$row->gapok.'"><span></span></label>';
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
        $gaji_pokok = new GajiPokok;
        $gaji_pokok->nopeg = $pegawai->nopeg;
        $gaji_pokok->mulai = $request->mulai_gaji_pokok;
        $gaji_pokok->sampai = $request->sampai_gaji_pokok;
        $gaji_pokok->gapok = $request->nilai_gaji_pokok;
        $gaji_pokok->keterangan = $request->keterangan_gaji_pokok;
        $gaji_pokok->userid = Auth::user()->userid;
        $gaji_pokok->tglentry = Carbon::now();

        $gaji_pokok->save();

        return response()->json($gaji_pokok, 200);
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
    public function update(Request $request, MasterPegawai $pegawai, $nilai)
    {
        $gaji_pokok = GajiPokok::where('nopeg', $pegawai->nopeg)
        ->where('gapok', $nilai)
        ->first();

        $gaji_pokok->nopeg = $pegawai->nopeg;
        $gaji_pokok->mulai = $request->mulai_gaji_pokok;
        $gaji_pokok->sampai = $request->sampai_gaji_pokok;
        $gaji_pokok->gapok = $request->nilai_gaji_pokok;
        $gaji_pokok->keterangan = $request->keterangan_gaji_pokok;
        $gaji_pokok->userid = Auth::user()->userid;
        $gaji_pokok->tglentry = Carbon::now();

        $gaji_pokok->save();

        return response()->json($gaji_pokok, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $gaji_pokok = GajiPokok::where('nopeg', $request->nopeg)
        ->where('gapok', $request->gapok)
        ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
