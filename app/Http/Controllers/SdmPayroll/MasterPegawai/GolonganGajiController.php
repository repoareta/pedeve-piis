<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Models\GolonganGaji;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GolonganGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $golongan_gaji_list = GolonganGaji::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($golongan_gaji_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_golongan_gaji" value="'.$row->nopeg.'_'.$row->golgaji.'_'.$row->tanggal.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('tanggal', function ($row) {
                return Carbon::parse($row->tanggal)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
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
        $golongan_gaji = new GolonganGaji;
        $golongan_gaji->nopeg = $pegawai->nopeg;
        $golongan_gaji->tanggal = $request->tanggal_golongan_gaji;
        $golongan_gaji->golgaji = $request->golongan_gaji;
        $golongan_gaji->userid = Auth::user()->userid;
        $golongan_gaji->tglentry = Carbon::now();

        $golongan_gaji->save();

        return response()->json($golongan_gaji, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $golongan_gaji = GolonganGaji::where('nopeg', $request->nopeg)
        ->where('golgaji', $request->golongan_gaji)
        ->where('tanggal', $request->tanggal)
        ->first();

        return response()->json($golongan_gaji, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $golongan_gaji, $tanggal)
    {
        $golongan_gaji = GolonganGaji::where('nopeg', $pegawai->nopeg)
        ->where('golgaji', $golongan_gaji)
        ->where('tanggal', $tanggal)
        ->first();
        
        $golongan_gaji->nopeg = $pegawai->nopeg;
        $golongan_gaji->tanggal = $request->tanggal_golongan_gaji;
        $golongan_gaji->golgaji = $request->golongan_gaji;
        $golongan_gaji->userid = Auth::user()->userid;

        $golongan_gaji->save();

        return response()->json($golongan_gaji, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $golongan_gaji = GolonganGaji::where('nopeg', $request->nopeg)
        ->where('golgaji', $request->golongan_gaji)
        ->where('tanggal', $request->tanggal)
        ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
