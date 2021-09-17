<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPerjalananDinasDetailStore;
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
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" data-no="'.$row->no.'" data-nopek="'.$row->nopek.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('nilai', function ($row) {
                return currency_format($row->nilai);
            })
            ->addColumn('qty', function ($row) {
                return float_two($row->qty);
            })
            ->addColumn('total', function ($row) {
                return currency_format($row->total);
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create($no_ppanjar)
    {
        $no_ppanjar_header = str_replace('-', '/', $no_ppanjar);

        $pegawai_list_on_ppanjar_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)
        ->pluck('nopek')
        ->toArray();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->whereNotIn('nopeg', $pegawai_list_on_ppanjar_detail)
        ->orderBy('nama', 'ASC')
        ->get();

        $no_urut = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)->count();
        $no_urut += 1;

        return view('modul-umum.perjalanan-dinas-pertanggungjawaban._detail.create', compact(
            'pegawai_list',
            'no_ppanjar',
            'no_urut'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PPerjalananDinasDetailStore $request, PPanjarDetail $ppanjar_detail, $no_ppanjar)
    {
        $no_ppanjar_header = str_replace('-', '/', $no_ppanjar);
        $nilai = (float) sanitize_nominal($request->nilai);
        $qty = (float) sanitize_nominal($request->qty);

        $ppanjar_detail->no         = $request->no_urut;
        $ppanjar_detail->no_ppanjar = $no_ppanjar_header;
        $ppanjar_detail->nopek      = $request->nopek;
        $ppanjar_detail->keterangan = $request->keterangan;
        $ppanjar_detail->nilai      = $nilai;
        $ppanjar_detail->qty        = $qty;
        $ppanjar_detail->total      = $nilai * $qty;

        $ppanjar_detail->save();

        Alert::success(
            'Simpan Detail PPanjar Dinas',
            'Berhasil'
        )
        ->persistent(true)
        ->autoClose(2000);
        
        return redirect()->route('modul_umum.perjalanan_dinas.pertanggungjawaban.edit', [
            'no_ppanjar' => $no_ppanjar
        ]);
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
    public function delete(Request $request, $no_ppanjar)
    {
        PPanjarDetail::where('nopek', $request->nopek)
        ->where('no', $request->no)
        ->where('no_ppanjar', str_replace('-', '/', $no_ppanjar))
        ->delete();

        return response()->json();
    }
}
