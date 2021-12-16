<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpahTetapPensiunStoreRequest;
use App\Http\Requests\UpahTetapPensiunUpdateRequest;
use App\Models\MasterPegawai;
use App\Models\UpahTetapPensiun;
use Auth;
use Illuminate\Support\Facades\DB;
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
                return $row->mulai->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return $row->sampai->translatedFormat('d F Y');
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
    public function store(UpahTetapPensiunStoreRequest $request, MasterPegawai $pegawai)
    {
        $upah             = new UpahTetapPensiun();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterPegawai $pegawai, $nilai)
    {
        $upah = UpahTetapPensiun::where('nopeg', $pegawai->nopeg)
                                ->where('ut', $nilai)
                                ->first();        
        
        return view('modul-sdm-payroll.master-pegawai._upah-tetap-pensiun.edit', compact('upah', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpahTetapPensiunUpdateRequest $request, MasterPegawai $pegawai, $nilai)
    {
        DB::table('sdm_ut_pensiun')
            ->where('nopeg', $pegawai->nopeg)
            ->where('ut', $nilai)
            ->update([
                'nopeg' => $pegawai->nopeg,
                'ut' => $request->nilai_upah_tetap_pensiun,
                'mulai' => $request->mulai_upah_tetap_pensiun,
                'sampai' => $request->sampai_upah_tetap_pensiun,
                'keterangan' => $request->keterangan_upah_tetap_pensiun,
                'userid' => Auth::user()->userid
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
        UpahTetapPensiun::where('nopeg', $request->pegawai)
            ->where('ut', $request->ut)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
