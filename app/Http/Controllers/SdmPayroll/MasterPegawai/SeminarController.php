<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeminarStoreRequest;
use App\Models\MasterPegawai;
use App\Models\Seminar;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $seminar_list = Seminar::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($seminar_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_seminar" data-mulai="'.$row->mulai.'" data-nama="'.$row->nama.'"><span></span></label>';
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
        return view('modul-sdm-payroll.master-pegawai._seminar.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeminarStoreRequest $request, MasterPegawai $pegawai)
    {
        $seminar = new Seminar;
        $seminar->nopeg         = $pegawai->nopeg;
        $seminar->mulai         = $request->mulai_seminar;
        $seminar->sampai        = $request->sampai_seminar;
        $seminar->nama          = $request->nama_seminar;
        $seminar->penyelenggara = $request->penyelenggara_seminar;
        $seminar->kota          = $request->kota_seminar;
        $seminar->negara        = $request->negara_seminar;
        $seminar->keterangan    = $request->keterangan_seminar;
        $seminar->userid        = Auth::user()->userid;
        $seminar->tglentry      = Carbon::now();

        $seminar->save();

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
        $seminar = Seminar::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->first();

        return response()->json($seminar, 200);
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
        $seminar = Seminar::where('nopeg', $pegawai->nopeg)
        ->where('mulai', $request->mulai)
        ->first();

        $seminar->nopeg         = $pegawai->nopeg;
        $seminar->mulai         = $request->mulai_seminar;
        $seminar->sampai        = $request->sampai_seminar;
        $seminar->nama          = $request->nama_seminar;
        $seminar->penyelenggara = $request->penyelenggara_seminar;
        $seminar->kota          = $request->kota_seminar;
        $seminar->negara        = $request->negara_seminar;
        $seminar->keterangan    = $request->keterangan_seminar;
        $seminar->userid        = Auth::user()->userid;
        $seminar->tglentry      = Carbon::now();

        $seminar->save();

        return response()->json($seminar, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $seminar = Seminar::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
