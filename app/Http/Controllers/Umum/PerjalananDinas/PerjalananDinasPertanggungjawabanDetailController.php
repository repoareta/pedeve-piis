<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use App\Http\Controllers\Controller;
use App\Models\MasterPegawai;
use App\Models\PPanjarDetail;
use Illuminate\Http\Request;

class PerjalananDinasPertanggungjawabanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request, $no_ppanjar)
    {
        $no_ppanjar = str_replace('-', '/', $request->no_ppanjar);
        $ppanjar_list_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar);

        return datatables()->of($ppanjar_list_detail)
            ->addColumn('action', function ($row) {
                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio1" value="'.$row->no.'-'.$row->nopek.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('nilai', function ($row) {
                return float_two($row->nilai);
            })
            ->addColumn('qty', function ($row) {
                return float_two($row->qty);
            })
            ->addColumn('total', function ($row) {
                return float_two($row->total);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        return view('modul-umum.perjalanan-dinas-pertanggungjawaban._detail.create', compact(
            'pegawai_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PPanjarDetail $ppanjar_detail)
    {
        $ppanjar_detail->no         = $request->no;
        $ppanjar_detail->no_ppanjar = $request->no_ppanjar;        // for add update only
        $ppanjar_detail->nopek      = $request->nopek;
        $ppanjar_detail->nama       = $request->nama;
        $ppanjar_detail->keterangan = $request->keterangan;
        $ppanjar_detail->nilai      = float_two($request->nilai);
        $ppanjar_detail->qty        = $request->qty;
        $ppanjar_detail->total      = float_two($request->nilai * $ppanjar_detail->qty);

        return response()->json($ppanjar_detail, 200);
    }

    /**
     * Undocumented function
     *
     * @param [type] $no_ppanjar
     * @param [type] $no_urut
     * @param [type] $nopek
     * @return void
     */
    public function edit($no_ppanjar, $no_urut, $nopek)
    {
        return view('modul-umum.perjalanan-dinas-pertanggungjawaban._detail.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_ppanjar, $no_urut, $nopek)
    {
        // Dari Database
        $panjar_detail = PPanjarDetail::where('no_ppanjar', $request->no_ppanjar)
        ->where('no', $request->no)
        ->delete();

        $ppanjar_detail = new PPanjarDetail;
        $ppanjar_detail->no = $request->no;
        $ppanjar_detail->no_ppanjar = $request->no_ppanjar ? $request->no_ppanjar : null; // for add update only
        $ppanjar_detail->nopek = $request->nopek;
        $ppanjar_detail->keterangan = $request->keterangan;
        $ppanjar_detail->nilai = $request->nilai;
        $ppanjar_detail->qty = $request->qty;
        $ppanjar_detail->total = $ppanjar_detail->nilai * $ppanjar_detail->qty;

        $ppanjar_detail->save();
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $nopek = substr($request->no_nopek, strpos($request->no_nopek, "-") + 1);
        // dd($nopek);
        if ($request->session == 'true') {
            // delete session
            foreach (session('ppanjar_detail') as $key => $value) {
                if ($value['nopek'] == $nopek) {
                    session()->forget("ppanjar_detail.$key");
                }
            }
        } else {
            // delete Database
            PPanjarDetail::where('nopek', $nopek)
            ->where('no_ppanjar', $request->no_ppanjar)
            ->delete();
        }

        return response()->json();
    }
}
