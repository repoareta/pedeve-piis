<?php

namespace App\Http\Controllers\Umum\Anggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\AnggaranMain;
use App\Models\AnggaranSubMain;
use App\Models\AnggaranDetail;

//load form request (for validation)
use App\Http\Requests\AnggaranStore;

// Load Plugin
use Carbon\Carbon;
use Session;
use DomPDF;
use PDF;
use Excel;
use Alert;
use Auth;
use DataTables;
use DB;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = AnggaranMain::select('tahun')
        ->whereNotNull('tahun')
        ->distinct()
        ->orderBy('tahun', 'DESC')
        ->get();

        return view('modul-umum.anggaran.index', compact('tahun'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson(Request $request)
    {
        $anggaran_list = AnggaranMain::orderBy('tahun', 'desc');

        return DataTables::of($anggaran_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('kode_anggaran')) {
                    $query->where('kode_main', 'like', "%{$request->get('kode_anggaran')}%");
                }

                if ($request->has('tahun')) {
                    $query->where('tahun', 'like', "%{$request->get('tahun')}%");
                }
            })
            ->addColumn('nilai_real', function ($row) use ($request) {
                $tahun = $request->tahun ? $request->tahun : date('Y');
                $nilai = $this->getNilai($row, $tahun);

                return currency_idr($nilai);
            })
            ->addColumn('realisasi', function ($row) use ($request) {
                $tahun = $request->tahun ? $request->tahun : date('Y');
                $realisasi = $this->getRealisasi($row, $tahun);

                return currency_idr($realisasi);
            })
            ->addColumn('sisa', function ($row) use ($request){
                $tahun = $request->tahun ? $request->tahun : date('Y');
                $nilai = $this->getNilai($row, $tahun);
                $realisasi = $this->getRealisasi($row, $tahun);

                return currency_idr($nilai - $realisasi);
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode_main.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio', 'nama_main'])
            ->make(true);
    }

    public function getNilai($anggaranMain, $tahun)
    {
        $nilai = DB::select(
            "SELECT 
                        SUM(ad.nilai) AS nilai
                    FROM 
                        anggaran_detail ad
                    WHERE
                        ad.tahun = '$tahun'
                    AND
                        ad.kode_submain IN (
                            SELECT
                                kode_submain
                            FROM
                                anggaran_submain
                            WHERE
                                kode_main = '$anggaranMain->kode_main'
                        )
                "); 
        
                return $nilai[0]->nilai;
    }

    public function getRealisasi($anggaranMain, $tahun)
    {
        $realisasi = DB::select(
            "SELECT 
                SUM(round(a.totprice,2)) AS realisasi
            FROM 
                kasline a 
            JOIN 
                kasdoc b on b.docno = a.docno
            WHERE
                substring(b.thnbln from 1 for 4)= '$tahun'
            AND 
                a.account IN (
                    SELECT 
                        kodeacct
                    FROM
                        anggaran_mapping
                    WHERE
                        kode IN (
                            SELECT
                                kode
                            FROM
                                anggaran_detail
                            WHERE
                                kode_submain IN (
                                    SELECT
                                        kode_submain
                                    FROM
                                        anggaran_submain
                                    WHERE
                                        kode_main = '$anggaranMain->kode_main'
                                )
                        )
                )
            AND 
                a.keterangan <> 'penutup'"); 

        return $realisasi[0]->realisasi;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-umum.anggaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggaranStore $request, AnggaranMain $anggaran)
    {
        $anggaran->kode_main = $request->kode;
        $anggaran->nama_main = $request->nama;
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Tambah Master Anggaran', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_umum.anggaran.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AnggaranMain $anggaran)
    {
        return view('modul-umum.anggaran.edit', compact('anggaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnggaranMain $anggaran)
    {
        $anggaran->kode_main = $request->kode;
        $anggaran->nama_main = $request->nama;
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Ubah Master Anggaran', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_umum.anggaran.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        AnggaranMain::find($request->id)
        ->anggaran_detail()
        ->delete();

        AnggaranMain::find($request->id)
        ->anggaran_submain()
        ->delete();

        AnggaranMain::find($request->id)->delete();

        return response()->json();
    }

    public function rekapExport(Request $request)
    {
        $tahun = $request->tahun_cetak;
        $anggaran_list = AnggaranMain::where('tahun', $tahun)
        ->with(['anggaran_submain.anggaran_detail' => function ($query) {
            $query->orderBy('kode', 'ASC');
        }])
        ->orderBy('kode_main', 'ASC')
        ->get();

        // $v_anggaran = AnggaranMain::where('tahun', $tahun)
        // ->join(
        //     DB::raw("
        //     (SELECT
        //         (SELECT substr(thnbln,1,4) FROM kasdoc kas WHERE kas.docno = K.docno) AS tahun_anggaran,
        //         (SELECT rate FROM kasdoc kas WHERE kas.docno = K.docno) AS kurs,
        //         K.docno,
        //         K.lineno,
        //         K.account,
        //         K.area,
        //         K.lokasi,
        //         K.bagian,
        //         K.pk,
        //         K.jb,
        //         K.cj,
        //         K.totprice,
        //         K.keterangan
        //     FROM kasline K
        //     WHERE K.account like '5%') AS v_anggaran
        // "),
        //     'v_anggaran.tahun_anggaran',
        //     'anggaran_main.tahun'
        // )
        // ->get()
        // ->toArray();
    
        // dd($v_anggaran);

        // return default PDF
        $pdf = DomPDF::loadview('modul-umum.anggaran.anggaran-pdf', compact('anggaran_list', 'tahun'))
        ->setPaper('a4', 'potrait');

        return $pdf->stream('rekap_anggaran_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function report()
    {
        return view('modul-umum.anggaran.report');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function reportExport(Request $request)
    {
        $tahun = $request->tahun;
        $anggaran_list = AnggaranMain::where('tahun', $tahun)
        ->with(['anggaran_submain.anggaran_detail' => function ($query) {
            $query->orderBy('kode', 'ASC');
        }])
        ->orderBy('kode_main', 'ASC')
        ->get();

        // return default PDF
        $pdf = PDF::loadView('modul-umum.anggaran.anggaran-pdf', compact(
            'anggaran_list', 
            'tahun')
        )
        ->setOption('page-size', 'A4')
        ->setOption('orientation', 'Portrait')
        ->setOption('footer-right', 'Halaman [page] dari [toPage]');

        return $pdf->stream('rekap_anggaran_'.date('Y-m-d H:i:s').'.pdf');
    }

    /**
     * Undocumented function
     *
     * @param Type $var
     * @return void
     */
    public function getByTahun(Request $request)
    {
        $anggaran_list = AnggaranMain::where('tahun', $request->tahun)->get();
        
        return response()->json($anggaran_list);
    }
}
