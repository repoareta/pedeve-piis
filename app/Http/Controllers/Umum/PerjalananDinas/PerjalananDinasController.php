<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//load form request
use App\Http\Requests\PerjalananDinasStore;
use App\Http\Requests\PerjalananDinasUpdate;
// load models
use App\Models\KodeJabatan;
use App\Models\PanjarDetail;
use App\Models\PanjarHeader;
use App\Models\Pekerja;
// load pluggin
use Carbon\Carbon;
use Dompdf\Dompdf;
use Alert;
use Excel;

use App\Exports\RekapSPD;

class PerjalananDinasController extends Controller
{
    public function index()
    {
        return view('modul-umum.perjalanan-dinas.index');
    }

    public function indexJson(Request $request)
    {
        $panjar_list = PanjarHeader::orderBy('tgl_panjar', 'desc');

        return datatables()->of($panjar_list)
            ->filter(function ($query) use ($request) {
                if (request('nopanjar')) {
                    $query->where('no_panjar', request('nopanjar'));
                }
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->sampai)->translatedFormat('d F Y');
            })
            ->addColumn('nopek', function ($row) {
                return $row->nopek." - ".$row->nama;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->jum_panjar);
            })
            ->addColumn('action', function ($row) {
                if (optional($row->ppanjar_header)->no_panjar) {
                    $ppanjar_header = "true";
                } else {
                    $ppanjar_header = "false";
                }

                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" data-ppanjar="'.$ppanjar_header.'" value="'.$row->no_panjar.'"><span></span></label>';
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
        $pegawai_list = Pekerja::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        // get tanggal panjar
        $last_panjar = PanjarHeader::withTrashed()->latest()->first();

        $year_now = date('Y');
        $year_last_panjar = date('Y', strtotime($last_panjar->tgl_panjar));
        $last_panjar_no = implode('/', array_slice(explode('/', $last_panjar->no_panjar), 0, 1)) + 1;
        if ($year_now > $year_last_panjar) {
            // reset no_spd ke 001
            $no_spd = sprintf("%03d", 1)."/PDV/CS/$year_now";
        } else {
            $no_spd = sprintf("%03d", $last_panjar_no)."/PDV/CS/$year_now";
        }

        return view('perjalanan_dinas.create', compact(
            'pegawai_list',
            'no_spd',
            'jabatan_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerjalananDinasStore $request)
    {
        $pegawai = Pekerja::find($request->nopek);
        
        $panjar_header = new PanjarHeader;
        $panjar_header->no_panjar = $request->no_spd;
        $panjar_header->tgl_panjar = date('Y-m-d H:i:s', strtotime(date('H:i:s'), strtotime($request->tanggal)));
        $panjar_header->nopek = $request->nopek;
        $panjar_header->nama = $pegawai->nama;
        $panjar_header->jabatan = $request->jabatan;
        $panjar_header->gol = $request->golongan;
        $panjar_header->ktp = $request->ktp;
        $panjar_header->jenis_dinas = $request->jenis_dinas;
        $panjar_header->dari = $request->dari;
        $panjar_header->tujuan = $request->tujuan;
        $panjar_header->mulai = $request->mulai;
        $panjar_header->sampai = $request->sampai;
        $panjar_header->kendaraan = $request->kendaraan;
        $panjar_header->ditanggung_oleh = $request->biaya;
        $panjar_header->keterangan = $request->keterangan;
        $panjar_header->jum_panjar = $request->jumlah;
        // Save Panjar Header
        $panjar_header->save();

        if ($request->url == 'edit') {
            return redirect()->route('modul-umum.perjalanan-dinas.edit', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]);
        }

        Alert::success('Simpan Panjar Dinas', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul-umum.perjalanan-dinas.index');
    }

    public function showJson(Request $request)
    {
        $no_panjar = str_replace('-', '/', $request->id);
        $data = PanjarHeader::find($no_panjar);

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($no_panjar)
    {
        $no_panjar = str_replace('-', '/', $no_panjar);
        $panjar_header = PanjarHeader::where('no_panjar', $no_panjar)->first();

        if (optional($panjar_header->ppanjar_header)->no_panjar) {
            Alert::warning('Data Panjar Dinas Tidak Bisa Diubah', 'Gagal')->persistent(true)->autoClose(2000);
            return redirect()->route('modul-umum.perjalanan-dinas.index');
        }

        $pegawai_list = Pekerja::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        $panjar_detail_count = PanjarDetail::where('no_panjar', $no_panjar)->count();

        return view('modul-umum.perjalanan-dinas.edit', compact(
            'panjar_header',
            'pegawai_list',
            'jabatan_list',
            'panjar_detail_count'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerjalananDinasUpdate $request, $no_panjar)
    {
        $no_panjar = str_replace('-', '/', $no_panjar);
        $panjar_header = PanjarHeader::find($no_panjar);

        $pegawai = Pekerja::find($request->nopek);

        $panjar_header->no_panjar = $request->no_spd;
        $panjar_header->tgl_panjar = $request->tanggal;
        $panjar_header->nopek = $request->nopek;
        $panjar_header->nama = $pegawai->nama;
        $panjar_header->jabatan = $request->jabatan;
        $panjar_header->gol = $request->golongan;
        $panjar_header->ktp = $request->ktp;
        $panjar_header->jenis_dinas = $request->jenis_dinas;
        $panjar_header->dari = $request->dari;
        $panjar_header->tujuan = $request->tujuan;
        $panjar_header->mulai = $request->mulai;
        $panjar_header->sampai = $request->sampai;
        $panjar_header->kendaraan = $request->kendaraan;
        $panjar_header->ditanggung_oleh = $request->biaya;
        $panjar_header->keterangan = $request->keterangan;
        $panjar_header->jum_panjar = $request->jumlah;

        $panjar_header->save();

        return redirect()->route('modul-umum.perjalanan-dinas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $panjar_header = PanjarHeader::where('no_panjar', $request->id)->first();
        if (is_null(optional($panjar_header->ppanjar_header)->no_panjar)) {
            $panjar_header->delete();
        }

        return response()->json();
    }

    public function rekap()
    {
        return view('modul-umum.perjalanan-dinas.rekap');
    }

    public function rekapExport(Request $request)
    {
        $mulai = date($request->mulai);
        $sampai = date($request->sampai);
        $panjar_header_list = PanjarHeader::whereBetween('tgl_panjar', [$mulai, $sampai])
        ->get();
        // dd($panjar_header_list);


        if ($request->submit != 'pdf') {
            return Excel::download(new RekapSPD($panjar_header_list, $request->submit, $mulai, $sampai), 'rekap_spd_'.date('Y-m-d H:i:s').'.'.$request->submit);
        }

        // return default PDF
        $pdf = DomPDF::loadview('modul-umum.perjalanan-dinas.export-pdf', compact('panjar_header_list', 'mulai', 'sampai'))
        ->setPaper('a4', 'landscape')
        ->setOptions(['isPhpEnabled' => true]);

        return $pdf->stream('rekap_spd_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function rowExport(Request $request)
    {
        // dd($request->atasan_ybs);
        // $no_panjar = str_replace('-', '/', $no_panjar);
        $panjar_header = PanjarHeader::find($request->no_panjar_dinas);

        // update panjar header
        $panjar_header->atasan = $request->atasan_ybs;
        $panjar_header->menyetujui = $request->menyetujui;
        $panjar_header->personalia = $request->sekr_perseroan;
        $panjar_header->menyetujui_keu = $request->keuangan;

        $panjar_header->save();

        $pdf = Dompdf::loadview('modul-umum.perjalanan-dinas.export-row', compact('panjar_header'));

        return $pdf->stream('rekap_spd_'.date('Y-m-d H:i:s').'.pdf');
    }
}
