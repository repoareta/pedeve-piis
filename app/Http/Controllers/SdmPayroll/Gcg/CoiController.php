<?php

namespace App\Http\Controllers\SdmPayroll\Gcg;

use App\Http\Controllers\Controller;
use App\Models\GcgCoi;
use App\Models\Jabatan;
use App\Models\KodeJabatan;
use Auth;
use DomPDF;
use Illuminate\Http\Request;

class CoiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan_latest = Jabatan::where('nopeg', Auth::user()->nopeg)->latest()->first();
        $jabatan = KodeJabatan::where('kdbag', $jabatan_latest->kdbag)
        ->where('kdjab', $jabatan_latest->kdjab)
        ->first();

        return view('modul-sdm-payroll.gcg.coi.lampiran-satu', compact('jabatan'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lampiranDua()
    {
        $jabatan_latest = Jabatan::where('nopeg', Auth::user()->nopeg)->latest()->first();
        $jabatan = KodeJabatan::where('kdbag', $jabatan_latest->kdbag)
        ->where('kdjab', $jabatan_latest->kdjab)
        ->first();

        return view('modul-sdm-payroll.gcg.coi.lampiran-dua', compact('jabatan'));
    }

    public function lampiranSatuPrint(Request $request, GcgCoi $gcgCoi)
    {
        $konflik = $request->konflik;
        $tempat = $request->tempat;
        $tanggal_efektif = $request->tanggal_efektif;
        $jabatan_latest = Jabatan::where('nopeg', Auth::user()->nopeg)->latest()->first();
        $jabatan = KodeJabatan::where('kdbag', $jabatan_latest->kdbag)
        ->where('kdjab', $jabatan_latest->kdjab)
        ->first();

        // insert to COI
        $gcgCoi->lampiran = 1;
        $gcgCoi->catatan = $konflik;
        $gcgCoi->nopeg = Auth::user()->nopeg;
        $gcgCoi->save();

        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.coi.lampiran-satu-print', compact(
            'konflik',
            'tempat',
            'tanggal_efektif',
            'jabatan'
        ));

        return $pdf->stream('coi_lampiran_satu'.date('Y-m-d H:i:s').'.pdf');
    }

    public function lampiranDuaPrint(Request $request, GcgCoi $gcgCoi)
    {
        $tempat = $request->tempat;
        $tanggal_efektif = $request->tanggal_efektif;
        $jabatan_latest = Jabatan::where('nopeg', Auth::user()->nopeg)->latest()->first();
        $jabatan = KodeJabatan::where('kdbag', $jabatan_latest->kdbag)
        ->where('kdjab', $jabatan_latest->kdjab)
        ->first();

        // insert to COI
        $gcgCoi->lampiran = 2;
        $gcgCoi->nopeg = Auth::user()->nopeg;
        $gcgCoi->save();

        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.coi.lampiran-dua-print', compact(
            'tempat',
            'tanggal_efektif',
            'jabatan'
        ));

        return $pdf->stream('coi_lampiran_dua'.date('Y-m-d H:i:s').'.pdf');
    }
}
