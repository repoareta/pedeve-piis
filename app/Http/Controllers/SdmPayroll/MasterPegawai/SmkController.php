<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMKStoreRequest;
use App\Http\Requests\SMKUpdateRequest;
use App\Models\MasterPegawai;
use App\Models\SMK;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SmkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $smk_list = SMK::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($smk_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_smk" data-tahun="'.$row->tahun.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._smk.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SMKStoreRequest $request, MasterPegawai $pegawai)
    {
        $smk           = new SMK;
        $smk->nopeg    = $pegawai->nopeg;
        $smk->tahun    = $request->tahun_smk;
        $smk->nilai    = $request->nilai_smk;
        $smk->userid   = Auth::user()->userid;
        $smk->tglentry = Carbon::now();

        $smk->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterPegawai $pegawai, $tahun)
    {
        $smk = SMK::where('nopeg', $pegawai->nopeg)
                    ->where('tahun', $tahun)
                    ->first();
        
        return view('modul-sdm-payroll.master-pegawai._smk.edit', compact('smk', 'pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SMKUpdateRequest $request, MasterPegawai $pegawai, $tahun)
    {
        DB::table('sdm_smk')
            ->where('nopeg', $pegawai->nopeg)
            ->where('tahun', $tahun)
            ->update([
                'nopeg' => $pegawai->nopeg,
                'tahun' => $request->tahun_smk,
                'nilai' => $request->nilai_smk,
                'userid' => Auth::user()->userid,
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
        SMK::where('nopeg', $request->pegawai)
            ->where('tahun', $request->tahun)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
