<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PendidikanStore;
use App\Models\MasterPegawai;
use App\Models\PekerjaPendidikan;
use App\Models\Pendidikan;
use App\Models\PerguruanTinggi;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $PekerjaPendidikan_list = PekerjaPendidikan::where('nopeg', $pegawai->nopeg);

        return datatables()->of($PekerjaPendidikan_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_pekerja_pendidikan" data-mulai="'.$row->mulai.'" data-tempatdidik="'.$row->tempatdidik.'" data-kodedidik="'.$row->kodedidik.'"><span></span></label>';

                return $radio;
            })
            ->addColumn('namapt', function ($row) {
                return optional($row->perguruan_tinggi)->nama;
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('tgllulus', function ($row) {
                return Carbon::parse($row->tgllulus)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        $pendidikan_list = Pendidikan::all();
        $perguruan_tinggi_list = PerguruanTinggi::all();

        return view('modul-sdm-payroll.master-pegawai._pendidikan.create', compact(
            'pegawai',
            'pendidikan_list',
            'perguruan_tinggi_list',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendidikanStore $request, MasterPegawai $pegawai, PekerjaPendidikan $PekerjaPendidikan)
    {
        $PekerjaPendidikan->nopeg       = $pegawai->nopeg;
        $PekerjaPendidikan->mulai       = $request->mulai_pendidikan_pegawai;
        $PekerjaPendidikan->tgllulus    = $request->sampai_pendidikan_pegawai;
        $PekerjaPendidikan->kodedidik   = $request->kode_pendidikan_pegawai;
        $PekerjaPendidikan->tempatdidik = $request->tempat_didik_pegawai;
        $PekerjaPendidikan->kodept      = $request->kode_pt_pendidikan_pegawai;
        $PekerjaPendidikan->catatan     = $request->catatan_pendidikan_pegawai;
        $PekerjaPendidikan->userid      = Auth::user()->userid;
        $PekerjaPendidikan->tglentry    = Carbon::now();

        $PekerjaPendidikan->save();

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
        $PekerjaPendidikan = PekerjaPendidikan::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('tempatdidik', $request->tempatdidik)
        ->where('kodedidik', $request->kodedidik)
        ->first();

        return response()->json($PekerjaPendidikan, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $mulai, $tempatdidik, $kodedidik)
    {
        $PekerjaPendidikan = PekerjaPendidikan::where('nopeg', $pegawai->nopeg)
        ->where('mulai', $request->mulai)
        ->where('tempatdidik', $request->tempatdidik)
        ->where('kodedidik', $request->kodedidik)
        ->first();

        $PekerjaPendidikan->nopeg       = $pegawai->nopeg;
        $PekerjaPendidikan->mulai       = $request->mulai_PekerjaPendidikan_pekerja;
        $PekerjaPendidikan->tgllulus    = $request->sampai_PekerjaPendidikan_pekerja;
        $PekerjaPendidikan->kodedidik   = $request->kode_PekerjaPendidikan_pekerja;
        $PekerjaPendidikan->tempatdidik = $request->tempat_didik_pekerja;
        $PekerjaPendidikan->kodept      = $request->kode_pt_PekerjaPendidikan_pekerja;
        $PekerjaPendidikan->catatan     = $request->catatan_PekerjaPendidikan_pekerja;
        $PekerjaPendidikan->userid      = Auth::user()->userid;

        $PekerjaPendidikan->save();

        return response()->json($PekerjaPendidikan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PekerjaPendidikan::where('nopeg', $request->pegawai)
            ->where('mulai', $request->mulai)
            ->where('tempatdidik', $request->tempatdidik)
            ->where('kodedidik', $request->kodedidik)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
