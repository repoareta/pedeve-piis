<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerjalananDinasDetailStore;
use App\Http\Requests\PerjalananDinasDetailUpdate;
use App\Models\KodeJabatan;
use App\Models\MasterPegawai;
use App\Models\PanjarDetail;
use App\Models\PanjarHeader;
use Illuminate\Http\Request;

class PerjalananDinasDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request, $no_panjar = null)
    {
        $no_panjar = str_replace('-', '/', $no_panjar);
        $panjar_list_detail = PanjarDetail::where('no_panjar', $no_panjar)
        ->orderBy('no', 'ASC');

        return datatables()->of($panjar_list_detail)
            ->addColumn('golongan', function ($row) {
                return $row->status;
            })
            ->addColumn('radio', function ($row) {
                $radio = '
                <label class="radio radio-outline radio-outline-2x radio-primary">
                    <input
                        type="radio"
                        name="radio1"
                        data-no_panjar="'.str_replace('/', '-', $row->no_panjar).'"
                        data-no_urut="'.$row->no.'"
                        data-nopeg="'.$row->nopek.'"
                        data-nama="'.$row->nama.'">
                    <span></span>
                </label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create($no_panjar)
    {
        $panjar_detail_pegawai = PanjarDetail::where('no_panjar', str_replace('-', '/', $no_panjar))
        ->pluck('nopek')
        ->toArray();

        $panjar_header_pegawai = PanjarHeader::where('no_panjar', str_replace('-', '/', $no_panjar))
        ->pluck('nopek')
        ->toArray();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->whereNotIn('nopeg', $panjar_detail_pegawai)
        ->whereNotIn('nopeg', $panjar_header_pegawai)
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        return view('modul-umum.perjalanan-dinas._detail.create', compact(
            'pegawai_list',
            'jabatan_list',
            'no_panjar'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        PerjalananDinasDetailStore $request,
        $no_panjar,
        PanjarDetail $panjar_detail
    ) {
        $pegawai = MasterPegawai::where('nopeg', $request->nopek)->first();

        $panjar_detail->no = $request->no_urut;
        $panjar_detail->no_panjar = str_replace('-', '/', $no_panjar); // for add update only
        $panjar_detail->nopek = $request->nopek;
        $panjar_detail->nama = $pegawai->nama;
        $panjar_detail->jabatan = $request->jabatan;
        $panjar_detail->status = $request->golongan;
        $panjar_detail->keterangan = $request->keterangan;

        $panjar_detail->save();

        Alert::success(
            'Simpan Detail Panjar Dinas',
            'Berhasil'
        )
        ->persistent(true)
        ->autoClose(2000);

        return redirect()->route('modul_umum.perjalanan_dinas.edit', [
            'no_panjar' => $no_panjar
        ]);
    }

    public function edit($no_panjar, $no_urut, $nopek)
    {
        $panjar_detail = PanjarDetail::where('nopek', $nopek)
        ->where('no', $no_urut)
        ->where('no_panjar', str_replace('-', '/', $no_panjar))
        ->firstOrFail();

        $panjar_detail_pegawai = PanjarDetail::where('nopek' , '<>', $nopek)
        ->where('no_panjar', str_replace('-', '/', $no_panjar))
        ->pluck('nopek')
        ->toArray();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->whereNotIn('nopeg', $panjar_detail_pegawai)
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        return view('modul-umum.perjalanan-dinas._detail.edit', compact(
            'pegawai_list',
            'jabatan_list',
            'no_panjar',
            'no_urut',
            'nopek',
            'panjar_detail'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        PerjalananDinasDetailUpdate $request,
        $no_panjar,
        $no_urut,
        $nopek
    ) {
        $no_panjar_detail = str_replace('-', '/', $no_panjar);

        $pegawai = MasterPegawai::where('nopeg', $request->nopek)
        ->firstOrFail();

        $panjar_detail = PanjarDetail::where('no_panjar', $no_panjar_detail)
        ->where('no', $no_urut)
        ->where('nopek', $nopek)
        ->update([
            'no' => $request->no_urut,
            'no_panjar' => $no_panjar_detail,
            'nopek' => $request->nopek,
            'nama' => $pegawai->nama,
            'jabatan' => $request->jabatan,
            'status' => $request->golongan,
            'keterangan' => $request->keterangan,
        ]);

        Alert::success(
            'Ubah Detail Panjar Dinas',
            'Berhasil'
        )
        ->persistent(true)
        ->autoClose(2000);

        return redirect()->route('modul_umum.perjalanan_dinas.edit', [
            'no_panjar' => $no_panjar
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $no_panjar)
    {
        $no_panjar = str_replace('-', '/', $no_panjar);
        // delete Database
        PanjarDetail::where('nopek', $request->nopeg)
        ->where('no', $request->no_urut)
        ->where('no_panjar', $no_panjar)
        ->delete();

        return response()->json();
    }
}
