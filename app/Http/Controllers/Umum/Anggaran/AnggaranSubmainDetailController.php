<?php

namespace App\Http\Controllers\Umum\Anggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\AnggaranDetail;
use App\Models\AnggaranMain;
use App\Models\AnggaranSubMain;

//load form request (for validation)
use App\Http\Requests\AnggaranSubmainDetailStore;
use App\Http\Requests\AnggaranSubmainDetailUpdate;

// Load Plugin
use Alert;
use App\Models\AnggaranMapping;
use Auth;
use DB;

class AnggaranSubmainDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = AnggaranDetail::select('tahun')
        ->whereNotNull('tahun')
        ->distinct()
        ->orderBy('tahun', 'DESC')
        ->get();

        return view('modul-umum.anggaran-submain-detail.index', compact('tahun'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson(Request $request)
    {
        $anggaran_list = AnggaranDetail::when(request('tahun'), function($q) use ($request) {
            $q->where('tahun', $request->tahun);
        })
        ->orderBy('tahun', 'desc');

        return datatables()->of($anggaran_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('kode')) {
                    $query->where('kode_submain', 'like', "%{$request->get('kode')}%");
                }

                if ($request->has('tahun')) {
                    $query->where('tahun', 'like', "%{$request->get('tahun')}%");
                }
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('realisasi', function ($row) use ($request) {
                $tahun = $request->tahun ? $request->tahun : date('Y');

                $dataRealisasi = $this->getRealisasi($row, $tahun);

                return currency_idr($dataRealisasi);
            })
            ->addColumn('sisa', function ($row) use ($request) {
                $tahun = $request->tahun ? $request->tahun : date('Y');
                
                $dataRealisasi = $this->getRealisasi($row, $tahun);

                return currency_idr($row->nilai - $dataRealisasi);
            })
            ->addColumn('anggaran_submain', function ($row) {
                return $row->anggaran_submain->kode_submain.' - '.$row->anggaran_submain->nama_submain;
            })
            ->addColumn('detail_anggaran', function ($row) {
                return $row->kode.' - '.$row->nama;
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode.'" data-kode_submain="'.$row->kode_submain.'" data-tahun="'.$row->tahun.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function getRealisasi($anggaranDetail, $tahun)
    {
        $realisasi = DB::select("
            SELECT 
                SUM(round(a.totprice,2)) AS realisasi
            FROM 
                kasline a 
            JOIN 
                kasdoc b on b.docno = a.docno
            WHERE
                substring(b.thnbln from 1 for 4)= '$tahun'
            AND 
                a.account IN (
                    SELECT kodeacct
                    FROM
                        anggaran_mapping
                    WHERE
                        kode = '$anggaranDetail->kode'
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
        $anggaran_submain_list = AnggaranSubMain::where('tahun', date('Y'))
        ->get();
        
        return view('modul-umum.anggaran-submain-detail.create', compact(
            'anggaran_submain_list',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggaranSubmainDetailStore $request, AnggaranDetail $anggaran)
    {
        $anggaran->kode_submain = $request->kode_submain;
        $anggaran->kode = $request->kode;
        $anggaran->nama = $request->nama;
        $anggaran->nilai = sanitize_nominal($request->nilai);
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Simpan Detail Anggaran', 'Berhasil')->persistent(true)->autoClose(2000);
        
        return redirect()->route('modul_umum.anggaran.submain.detail.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_submain, $kode)
    {
        $anggaran = AnggaranDetail::where('kode_submain', $kode_submain)
        ->where('kode', $kode)
        ->firstOrFail();

        $anggaran_submain_list = AnggaranSubMain::where('tahun', $anggaran->tahun)
        ->get();

        return view('modul-umum.anggaran-submain-detail.edit', compact(
            'kode_submain',
            'kode',
            'anggaran',
            'anggaran_submain_list'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnggaranSubmainDetailUpdate $request, $kode_submain, $kode)
    {
        $anggaran = AnggaranDetail::where('kode', $kode)
        ->where('kode_submain', $kode_submain)
        ->first();

        $anggaran->kode_submain = $kode_submain;
        $anggaran->kode = $request->kode;
        $anggaran->nama = $request->nama;
        $anggaran->nilai = sanitize_nominal($request->nilai);
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Ubah Anggaran Submain Detail', 'Berhasil')->persistent(true)->autoClose(2000);
        
        return redirect()->route('modul_umum.anggaran.submain.detail.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        AnggaranDetail::where('kode', $request->kode)
        ->where('kode_submain', $request->kode_submain)
        ->where('tahun', $request->tahun)
        ->delete();

        return response()->json();
    }
}
