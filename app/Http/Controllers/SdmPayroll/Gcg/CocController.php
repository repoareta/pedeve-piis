<?php

namespace App\Http\Controllers\SdmPayroll\Gcg;

use App\Http\Controllers\Controller;
use App\Models\GcgCoc;
use Auth;
use DomPDF;
use Illuminate\Http\Request;

class CocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.gcg.coc.lampiran-satu');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lampiranDua()
    {
        return view('modul-sdm-payroll.gcg.coc.lampiran-dua');
    }

    public function lampiranSatuPrint(Request $request, GcgCoc $gcgCoc)
    {
        $tempat = $request->tempat;
        $tanggal_efektif = $request->tanggal_efektif;

        // insert
        $gcgCoc->lampiran = 1;
        $gcgCoc->nopeg = Auth::user()->nopeg;
        $gcgCoc->save();

        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.coc.lampiran-satu-print', compact('tempat', 'tanggal_efektif'));

        return $pdf->stream('coc_lampiran_satu_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function lampiranDuaPrint(Request $request, GcgCoc $gcgCoc)
    {
        $orang = $request->orang;
        $tanggal_efektif = $request->tanggal_efektif;

        // insert
        $gcgCoc->lampiran = 2;
        $gcgCoc->nopeg = Auth::user()->nopeg;
        $gcgCoc->save();


        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.coc.lampiran-dua-print', compact('orang', 'tanggal_efektif'));

        return $pdf->stream('coc_lampiran_dua_'.date('Y-m-d H:i:s').'.pdf');
    }
}
