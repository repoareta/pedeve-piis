<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\KodeJabatan;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $jabatan_list = Jabatan::where('nopeg', $pegawai->nopeg);

        return datatables()->of($jabatan_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_jabatan" data-mulai="'.$row->mulai.'" data-kdbagian="'.$row->kdbag.'" data-kdjabatan="'.$row->kdjab.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('bagian', function ($row) {
                return $row->kdbag.' - '.$row->kode_bagian->nama;
            })
            ->addColumn('jabatan', function ($row) {
                $kode_bagian = $row->kdbag;
                $kode_jabatan = $row->kdjab;
                $jabatan = KodeJabatan::where('kdbag', $kode_bagian)
                    ->where('kdjab', $kode_jabatan)
                    ->first();
                $nama_jabatan = optional($jabatan)->keterangan ? ' - '.optional($jabatan)->keterangan : null;
                
                return $kode_jabatan.$nama_jabatan;
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
        return view('modul-sdm-payroll.master-pegawai._jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MasterPegawai $pegawai, Jabatan $jabatan)
    {
        $jabatan->nopeg    = $pegawai->nopeg;
        $jabatan->kdbag    = $request->bagian_pekerja;
        $jabatan->kdjab    = $request->jabatan_pekerja;
        $jabatan->mulai    = $request->mulai;
        $jabatan->sampai   = $request->sampai;
        $jabatan->noskep   = $request->no_skep;
        $jabatan->tglskep  = $request->tanggal_skep;
        $jabatan->userid   = Auth::user()->userid;
        $jabatan->tglentry = Carbon::now();
        // $jabatan->id       = null;

        $jabatan->save();

        return response()->json($jabatan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $jabatan = Jabatan::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('kdbag', $request->kdbag)
        ->where('kdjab', $request->kdjab)
        ->first();

        return response()->json($jabatan, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $mulai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $jabatan = Jabatan::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('kdbag', $request->kdbag)
        ->where('kdjab', $request->kdjab)
        ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
