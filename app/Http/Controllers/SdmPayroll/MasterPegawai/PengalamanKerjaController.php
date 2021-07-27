<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
use App\Models\PengalamanKerja;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengalamanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Pekerja $pegawai)
    {
        $pengalaman_kerja_list = PengalamanKerja::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($pengalaman_kerja_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_pengalaman_kerja" value="'.$row->nopeg.'_'.$row->mulai.'_'.$row->pangkat.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->sampai)->translatedFormat('d F Y');
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
    public function store(Request $request, Pekerja $pegawai)
    {
        $pengalaman_kerja = new PengalamanKerja;
        $pengalaman_kerja->nopeg    = $pegawai->nopeg;
        $pengalaman_kerja->mulai    = $request->mulai_pengalaman_kerja;
        $pengalaman_kerja->sampai   = $request->sampai_pengalaman_kerja;
        $pengalaman_kerja->status   = $request->status_pengalaman_kerja;
        $pengalaman_kerja->instansi = $request->instansi_pengalaman_kerja;
        $pengalaman_kerja->pangkat  = $request->pangkat_pengalaman_kerja;
        $pengalaman_kerja->kota     = $request->kota_pengalaman_kerja;
        $pengalaman_kerja->negara   = $request->negara_pengalaman_kerja;
        $pengalaman_kerja->userid   = Auth::user()->userid;
        $pengalaman_kerja->tglentry = Carbon::now();

        $pengalaman_kerja->save();

        return response()->json($pengalaman_kerja, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $pengalaman_kerja = PengalamanKerja::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('pangkat', $request->pangkat)
        ->first();

        return response()->json($pengalaman_kerja, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pekerja $pegawai, $mulai)
    {
        $pengalaman_kerja = PengalamanKerja::where('nopeg', $pegawai->nopeg)
        ->where('mulai', $request->mulai)
        ->where('pangkat', $request->pangkat)
        ->first();

        $pengalaman_kerja->nopeg    = $pegawai->nopeg;
        $pengalaman_kerja->mulai    = $request->mulai_pengalaman_kerja;
        $pengalaman_kerja->sampai   = $request->sampai_pengalaman_kerja;
        $pengalaman_kerja->status   = $request->status_pengalaman_kerja;
        $pengalaman_kerja->instansi = $request->instansi_pengalaman_kerja;
        $pengalaman_kerja->pangkat  = $request->pangkat_pengalaman_kerja;
        $pengalaman_kerja->kota     = $request->kota_pengalaman_kerja;
        $pengalaman_kerja->negara   = $request->negara_pengalaman_kerja;
        $pengalaman_kerja->userid   = Auth::user()->userid;

        $pengalaman_kerja->save();

        return response()->json($pengalaman_kerja, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $pengalaman_kerja = PengalamanKerja::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('pangkat', $request->pangkat)
        ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
