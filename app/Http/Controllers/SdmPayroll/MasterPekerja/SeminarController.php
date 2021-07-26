<?php

namespace App\Http\Controllers\SdmPayroll\MasterPekerja;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
use App\Models\Seminar;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Pekerja $pekerja)
    {
        $seminar_list = Seminar::where('nopeg', $pekerja->nopeg)->get();

        return datatables()->of($seminar_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_seminar" value="'.$row->nopeg.'_'.$row->mulai.'_'.$row->nama.'"><span></span></label>';
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
    public function store(Request $request, Pekerja $pekerja)
    {
        $seminar = new Seminar;
        $seminar->nopeg         = $pekerja->nopeg;
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
    public function update(Request $request, Pekerja $pekerja, $mulai)
    {
        $seminar = Seminar::where('nopeg', $pekerja->nopeg)
        ->where('mulai', $request->mulai)
        ->first();

        $seminar->nopeg         = $pekerja->nopeg;
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
