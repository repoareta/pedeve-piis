<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengalamanKerjaStoreRequest;
use App\Http\Requests\PengalamanKerjaUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\MasterPegawai;
use App\Models\PengalamanKerja;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengalamanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $pengalaman_kerja_list = PengalamanKerja::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($pengalaman_kerja_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_pengalaman_kerja" data-mulai="' .  Carbon::parse($row->mulai)->format('Y-m-d') . '" data-pangkat="' . $row->pangkat . '"><span></span></label>';
                return $radio;
            })
            ->addColumn('mulai', function ($row) {
                return $row->mulai->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return $row->mulai->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._pengalaman-kerja.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PengalamanKerjaStoreRequest $request, MasterPegawai $pegawai)
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

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterPegawai $pegawai, $mulai, $pangkat)
    {
        $pengalaman_kerja = PengalamanKerja::where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('pangkat', $pangkat)
            ->first();
        
        return view('modul-sdm-payroll.master-pegawai._pengalaman-kerja.edit', compact('pengalaman_kerja', 'pegawai'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PengalamanKerjaUpdateRequest $request, MasterPegawai $pegawai, $mulai, $pangkat)
    {
        DB::table('sdm_pengkerja')
            ->where('nopeg', $pegawai->nopeg)
            ->where('mulai', $mulai)
            ->where('pangkat', $pangkat)
            ->update([
                'nopeg' => $pegawai->nopeg,
                'mulai' => $request->mulai_pengalaman_kerja,
                'sampai' => $request->sampai_pengalaman_kerja,
                'status' => $request->status_pengalaman_kerja,
                'instansi' => $request->instansi_pengalaman_kerja,
                'pangkat' => $request->pangkat_pengalaman_kerja,
                'kota' => $request->kota_pengalaman_kerja,
                'negara' => $request->negara_pengalaman_kerja,
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
        PengalamanKerja::where('nopeg', $request->pegawai)
            ->where('mulai', $request->mulai)
            ->where('pangkat', $request->pangkat)
            ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
