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
use Auth;

class AnggaranSubmainDetailController extends Controller
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

        return view('modul-umum.anggaran-submain-detail.index', compact('tahun'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson()
    {
        $anggaran_list = AnggaranDetail::orderBy('tahun', 'desc');

        return datatables()->of($anggaran_list)
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('detail_anggaran', function ($row) {
                return $row->kode.' - '.$row->nama;
            })
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $anggaran_main_list = AnggaranMain::all();
        $anggaran_submain_list = AnggaranSubMain::all();
        
        return view('modul-umum.anggaran-submain-detail.create', compact(
            'anggaran_main_list',
            'anggaran_submain_list',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggaranSubmainDetailStore $request, $kode_submain)
    {
        $anggaran = new AnggaranDetail;

        $anggaran->kode_submain = $kode_submain;
        $anggaran->kode = $request->kode;
        $anggaran->nama = $request->nama;
        $anggaran->nilai = $request->nilai;
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Simpan Anggaran Submain Detail', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('anggaran.submain.detail.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_main, $kode_submain, $kode)
    {
        $anggaran = AnggaranDetail::find($kode);
        return view('modul-umum.anggaran-submain-detail.edit', compact(
            'kode_main',
            'kode_submain',
            'kode',
            'anggaran'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnggaranSubmainDetailUpdate $request, $kode_main, $kode_submain, $kode)
    {
        $anggaran = AnggaranDetail::where('kode', $kode)
        ->where('kode_submain', $kode_submain)
        ->first();

        $anggaran->kode_submain = $kode_submain;
        $anggaran->kode = $request->kode;
        $anggaran->nama = $request->nama;
        $anggaran->nilai = $request->nilai;
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Ubah Anggaran Submain Detail', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('anggaran.submain.detail.index', ['kode_main' => $kode_main, 'kode_submain' => $kode_submain]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        AnggaranDetail::where('kode', $request->id)
        ->where('kode_submain', $request->kode_submain)
        ->delete();

        return response()->json();
    }
}
