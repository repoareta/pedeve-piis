<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpahAllInStoreRequest;
use App\Models\MasterPegawai;
use App\Models\UpahAllIn;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpahAllInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $upah_all_in_list = UpahAllIn::where('nopek', $pegawai->nopeg);

        return datatables()->of($upah_all_in_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_upah_all_in" data-nilai="' . $row->nilai . '"><span></span></label>';
                return $radio;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('mulai', function ($row) {
                if ($row->mulai) {
                    return Carbon::parse($row->mulai)->translatedFormat('d F Y');
                }
                return null;
            })
            ->addColumn('sampai', function ($row) {
                if ($row->sampai) {
                    return Carbon::parse($row->sampai)->translatedFormat('d F Y');
                }
                return null;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        return view('modul-sdm-payroll.master-pegawai._upah-all-in.create', compact(
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpahAllInStoreRequest $request, MasterPegawai $pegawai)
    {
        $upah           = new UpahAllIn;
        $upah->nopek    = $pegawai->nopeg;
        $upah->nilai    = sanitize_nominal($request->nilai_upah_all_in);
        $upah->mulai    = $request->mulai_upah_all_in;
        $upah->sampai   = $request->sampai_upah_all_in;
        $upah->userid   = Auth::user()->userid;
        $upah->tglentry = Carbon::now();

        $upah->save();

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
        $upah = UpahAllIn::where('nopek', $request->nopeg)
            ->where('nilai', $request->nilai)
            ->first();

        $upah['mulai_date'] = $upah->formated_mulai;
        $upah['sampai_date'] = $upah->formated_sampai;

        return response()->json($upah, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $nilai)
    {
        $upah = UpahAllIn::where('nopek', $pegawai->nopeg)
            ->where('nilai', $request->nilai)
            ->first();

        $upah->nopek    = $pegawai->nopeg;
        $upah->nilai    = $request->nilai_upah_all_in;
        $upah->mulai    = $request->mulai_upah_all_in;
        $upah->sampai   = $request->sampai_upah_all_in;
        $upah->userid   = Auth::user()->userid;

        $upah->save();

        return response()->json($upah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $upah = UpahAllIn::where('nopek', $request->nopeg)
            ->where('nilai', $request->nilai)
            ->delete();

        return response()->json(['delete' => true], 200);
    }
}
