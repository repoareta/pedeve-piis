<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PendidikanStore;
use App\Http\Requests\PendidikanUpdate;
use App\Models\MasterPegawai;
use App\Models\PekerjaPendidikan;
use App\Models\Pendidikan;
use App\Models\PerguruanTinggi;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_pekerja_pendidikan" data-mulai="'.$row->mulai->format('Y-m-d').'" data-tempatdidik="'.$row->tempatdidik.'" data-kodedidik="'.$row->kodedidik.'"><span></span></label>';

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
    public function edit(MasterPegawai $pegawai, $mulai, $tempatdidik, $kodedidik)
    {
        $pendidikan_list = Pendidikan::all();
        $perguruan_tinggi_list = PerguruanTinggi::all();
        $pendidikanPekerja = PekerjaPendidikan::where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('tempatdidik', $tempatdidik)
            ->where('kodedidik', $kodedidik)
            ->first();

        // return $pendidikanPekerja;

        return view('modul-sdm-payroll.master-pegawai._pendidikan.edit', compact(
            'pegawai',
            'pendidikanPekerja',
            'mulai',
            'tempatdidik',
            'kodedidik',
            'pendidikan_list',
            'perguruan_tinggi_list',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PendidikanUpdate $request, MasterPegawai $pegawai, $mulai, $tempatdidik, $kodedidik)
    {
        DB::table('sdm_pendidikan')
            ->where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('tempatdidik', $tempatdidik)
            ->where('kodedidik', $kodedidik)
            ->update([
                'mulai' => $request->mulai_pendidikan_pegawai,
                'tgllulus' => $request->sampai_pendidikan_pegawai,
                'kodedidik' => $request->kode_pendidikan_pegawai,
                'tempatdidik' => $request->tempat_didik_pegawai,
                'kodept' => $request->kode_pt_pendidikan_pegawai,
                'catatan' => $request->catatan_pendidikan_pegawai,
            ]);

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
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
        PekerjaPendidikan::where('nopeg', $request->pegawai)
            ->where('mulai', $request->mulai)
            ->where('tempatdidik', $request->tempatdidik)
            ->where('kodedidik', $request->kodedidik)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
