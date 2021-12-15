<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\KursusStore;
use App\Http\Requests\KursusUpdate;
use App\Models\Kursus;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KursusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $kursus_list = Kursus::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($kursus_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_kursus" data-mulai="'.$row->mulai->format('Y-m-d').'" data-nama="'.$row->nama.'"><span></span></label>';
                return $radio;
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
        return view('modul-sdm-payroll.master-pegawai._kursus.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KursusStore $request, MasterPegawai $pegawai)
    {
        $kursus = new Kursus;
        $kursus->nopeg         = $pegawai->nopeg;
        $kursus->mulai         = $request->mulai_kursus;
        $kursus->sampai        = $request->sampai_kursus;
        $kursus->nama          = $request->nama_kursus;
        $kursus->penyelenggara = $request->penyelenggara_kursus;
        $kursus->kota          = $request->kota_kursus;
        $kursus->negara        = $request->negara_kursus;
        $kursus->keterangan    = $request->keterangan_kursus;
        $kursus->userid        = Auth::user()->userid;
        $kursus->tglentry      = Carbon::now();

        $kursus->save();

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
        $kursus = Kursus::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('nama', $request->nama)
        ->first();

        return response()->json($kursus, 200);
    }

    public function edit(Request $request, MasterPegawai $pegawai, $mulai, $nama)
    {
        $kursus = Kursus::where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('nama', $nama)
            ->first();

        return view('modul-sdm-payroll.master-pegawai._kursus.edit', compact(
            'kursus',
            'pegawai',
            'mulai',
            'nama',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KursusUpdate $request, MasterPegawai $pegawai, $mulai, $nama)
    {
        DB::table('sdm_kursus')
            ->where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('nama', $nama)
            ->update([
                'mulai' => $request->mulai_kursus,
                'sampai' => $request->sampai_kursus,
                'nama' => $request->nama_kursus,
                'penyelenggara' => $request->penyelenggara_kursus,
                'kota' => $request->kota_kursus,
                'negara' => $request->negara_kursus,
                'keterangan' => $request->keterangan_kursus,
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
        Kursus::where('nopeg', $request->pegawai)
                ->where('mulai', $request->mulai)
                ->where('nama', $request->nama)
                ->delete();

        return response()->json(['delete' => true], 200);
    }
}
