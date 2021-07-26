<?php

namespace App\Http\Controllers\SdmPayroll\MasterPekerja;

use App\Http\Controllers\Controller;
use App\Models\Pekerja;
use App\Models\SMK;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Pekerja $pekerja)
    {
        $smk_list = SMK::where('nopeg', $pekerja->nopeg)->get();

        return datatables()->of($smk_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio_smk" value="'.$row->nopeg.'-'.$row->tahun.'"><span></span></label>';
                return $radio;
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
        $smk           = new SMK;
        $smk->nopeg    = $pekerja->nopeg;
        $smk->tahun    = $request->tahun_smk;
        $smk->nilai    = $request->nilai_smk;
        $smk->userid   = Auth::user()->userid;
        $smk->tglentry = Carbon::now();

        $smk->save();

        return response()->json($smk, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $smk = SMK::where('nopeg', $request->nopeg)
        ->where('tahun', $request->tahun)
        ->first();

        return response()->json($smk, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pekerja $pekerja, $tahun)
    {
        $smk = SMK::where('nopeg', $pekerja->nopeg)
        ->where('tahun', $request->tahun)
        ->first();

        $smk->nopeg    = $pekerja->nopeg;
        $smk->tahun    = $request->tahun_smk;
        $smk->nilai    = $request->nilai_smk;
        $smk->userid   = Auth::user()->userid;

        $smk->save();

        return response()->json($smk, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $smk = SMK::where('nopeg', $request->nopeg)
        ->where('tahun', $request->tahun)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
