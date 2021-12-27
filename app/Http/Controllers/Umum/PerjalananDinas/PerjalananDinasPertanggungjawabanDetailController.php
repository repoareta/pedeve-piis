<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPerjalananDinasDetailStore;
use App\Http\Requests\PPerjalananDinasDetailUpdate;
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
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" data-no="'.$row->no.'" data-nopek="'.$row->nopek.'" data-ppanjar="'.str_replace('/', '-', $row->no_ppanjar).'"><span></span></label>';
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

        // $pegawai_list_on_ppanjar_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)
        // ->pluck('nopek')
        // ->toArray();

        // $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        // ->whereNotIn('nopeg', $pegawai_list_on_ppanjar_detail)
        // ->orderBy('nama', 'ASC')
        // ->get();

        // Perubahan saat meeting  27 Desember 2021
        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
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
        $no_ppanjar_header = str_replace('-', '/', (string) $no_ppanjar);

        // $pegawai_list_on_ppanjar_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)
        // ->where('nopek' , '<>', $nopek)
        // ->pluck('nopek')
        // ->toArray();

        // $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        // ->whereNotIn('nopeg', $pegawai_list_on_ppanjar_detail)
        // ->orderBy('nama', 'ASC')
        // ->get();

        // Perubahan saat meeting  27 Desember 2021
        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();
        
        $ppanjar_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)
        ->where('no', $no_urut)
        ->where('nopek', $nopek)
        ->first();

        return view('modul-umum.perjalanan-dinas-pertanggungjawaban._detail.edit', compact(
            'no_ppanjar',
            'ppanjar_detail',
            'pegawai_list'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PPerjalananDinasDetailUpdate $request, $no_ppanjar, $no_urut, $nopek)
    {
        $no_ppanjar_header = str_replace('-', '/', $no_ppanjar);

        $nilai = (float) sanitize_nominal($request->nilai);
        $qty = (float) sanitize_nominal($request->qty);

        $ppanjar_detail = PPanjarDetail::where('no_ppanjar', $no_ppanjar_header)
        ->where('no', $no_urut)
        ->where('nopek', $nopek)
        ->update([
            'no' => $request->no_urut,
            'no_ppanjar' => $no_ppanjar_header,
            'nopek' => $request->nopek,
            'keterangan' => $request->keterangan,
            'nilai' => $nilai,
            'qty' => $qty,
            'total' => $nilai * $qty,
        ]);

        Alert::success(
            'Ubah Detail PPanjar Dinas',
            'Berhasil'
        )
        ->persistent(true)
        ->autoClose(2000);
        
        return redirect()->route('modul_umum.perjalanan_dinas.pertanggungjawaban.edit', [
            'no_ppanjar' => $no_ppanjar
        ]);
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
