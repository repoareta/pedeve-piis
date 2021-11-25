<?php

namespace App\Http\Controllers\Umum\Anggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\AnggaranMain;
use App\Models\AnggaranSubMain;

//load form request (for validation)
use App\Http\Requests\AnggaranSubmainStore;
use App\Http\Requests\AnggaranSubmainUpdate;

// Load Plugin
use Alert;
use Auth;

class AnggaranSubmainController extends Controller
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

        return view('modul-umum.anggaran-submain.index', compact('tahun'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson(Request $request)
    {
        $anggaran_list = AnggaranSubMain::orderBy('tahun', 'desc')
        ->orderBy('kode_submain', 'asc');

        return datatables()->of($anggaran_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('kode')) {
                    $query->where('kode_submain', 'like', "%{$request->get('kode')}%");
                }

                if ($request->has('tahun')) {
                    $query->where('tahun', 'like', "%{$request->get('tahun')}%");
                }
            })
            ->addColumn('main', function ($row) {
                return $row->anggaran_main->kode_main." - ".$row->anggaran_main->nama_main;
            })
            ->addColumn('sub_anggaran', function ($row) {
                return $row->kode_submain.' - '.$row->nama_submain;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('nilai_real', function ($row) {
                return currency_idr($row->nilai_real);
            })
            ->addColumn('sisa', function ($row) {
                return currency_idr($row->nilai_real);
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode_main.'-'.$row->kode_submain.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio', 'sub_anggaran'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $anggaran_main_list = AnggaranMain::where('tahun', date('Y'))
        ->get();

        return view('modul-umum.anggaran-submain.create', compact('anggaran_main_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnggaranSubmainStore $request, AnggaranSubMain $anggaran)
    {
        $anggaran->kode_main = $request->kode_main;
        $anggaran->kode_submain = $request->kode;
        $anggaran->nama_submain = $request->nama;
        $anggaran->inputdate = date('Y-m-d H:i:s');
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Tambah Submain Anggaran', 'Berhasil')->persistent(true)->autoClose(2000);
        
        return redirect()->route('modul_umum.anggaran.submain.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_main, AnggaranSubMain $anggaranSubmain)
    {
        $anggaran_main_list = AnggaranMain::where('tahun', $anggaranSubmain->tahun)->get();
        return view('modul-umum.anggaran-submain.edit', compact('anggaranSubmain',  'anggaran_main_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnggaranSubmainUpdate $request, $kode_main, $kode_submain)
    {
        $anggaran = AnggaranSubMain::where('kode_main', $kode_main)
        ->where('kode_submain', $kode_submain)
        ->first();

        $anggaran->kode_main = $kode_main;
        $anggaran->kode_submain = $request->kode;
        $anggaran->nama_submain = $request->nama;
        $anggaran->inputuser = Auth::user()->userid;
        $anggaran->tahun = $request->tahun;

        $anggaran->save();

        Alert::success('Ubah Submain Anggaran', 'Berhasil')->persistent(true)->autoClose(2000);
        
        return redirect()->route('modul_umum.anggaran.submain.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $anggaranSubmain = AnggaranSubMain::where('kode_main', $request->kode_main)
        ->where('kode_submain', $request->kode_submain)
        ->first();

        $anggaranSubmain->anggaran_detail()->delete();

        $anggaranSubmain->delete();

        if ($anggaranSubmain) {
            return response()->json();
        }
    }
}
