<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use App\Http\Controllers\Controller;
use App\Http\Requests\PPerjalananDinasStore;
use App\Models\KodeJabatan;
use App\Models\PanjarHeader;
use App\Models\Pekerja;
use App\Models\PPanjarDetail;
use App\Models\PPanjarHeader;
use Carbon\Carbon;
use DomPDF;
use Illuminate\Http\Request;

class PerjalananDinasPertanggungjawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-umum.perjalanan-dinas-pertanggungjawaban.index');
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson(Request $request)
    {
        $panjar_list = PPanjarHeader::orderBy('tgl_ppanjar', 'desc');

        return datatables()->of($panjar_list)
            ->filter(function ($query) use ($request) {
                if (request('noppanjar')) {
                    $query->where('no_ppanjar', request('noppanjar'));
                }
            })
            ->addColumn('tgl_ppanjar', function ($row) {
                return Carbon::parse($row->tgl_ppanjar)->translatedFormat('d F Y');
            })
            ->addColumn('nopek', function ($row) {
                return $row->nopek.".".$row->nama;
            })
            ->addColumn('jmlpanjar', function ($row) {
                return currency_idr($row->jmlpanjar);
            })
            ->addColumn('action', function ($row) {
                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio1" value="'.$row->no_ppanjar.'"><span></span></label>';
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

        $ppanjar_header_list = PPanjarHeader::select('no_panjar')->whereNotNull('no_panjar')->get()->toArray();
        $panjar_header_list = PanjarHeader::whereNotIn('no_panjar', $ppanjar_header_list)->get();

        $ppanjar_header_count = PPanjarHeader::all()->count();

        $last_ppanjar = PPanjarHeader::withTrashed()->latest()->first();
        
        $date_now = date('d');
        $month_now = date('m');
        $year_now = date('Y');

        $year_last_ppanjar = date('Y', strtotime($last_ppanjar->tgl_ppanjar));
        $last_ppanjar_no = implode('/', array_slice(explode('/', $last_ppanjar->no_ppanjar), 0, 1)) + 1;
        if ($year_now > $year_last_ppanjar) {
            // reset no_pspd ke 001
            $no_pspd = sprintf("%03d", 1)."/CS/$date_now/$month_now/$year_now";
        } else {
            $no_pspd = sprintf("%03d", $last_ppanjar_no)."/CS/$date_now/$month_now/$year_now";
        }

        return view('perjalanan-dinas-pertanggungjawaban.create', compact(
            'pegawai_list',
            'panjar_header_list',
            'no_pspd',
            'jabatan_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PPerjalananDinasStore $request)
    {
        $pegawai = Pekerja::find($request->nopek);
        
        $ppanjar_header = new PPanjarHeader;
        $ppanjar_header->no_ppanjar = $request->no_pj_panjar;
        $ppanjar_header->no_panjar = $request->no_panjar;
        $ppanjar_header->keterangan = $request->keterangan;
        $ppanjar_header->tgl_ppanjar = date('Y-m-d H:i:s', strtotime(date('H:i:s'), strtotime($request->tanggal)));
        $ppanjar_header->nopek = $request->nopek;
        $ppanjar_header->nama = $pegawai->nama;
        $ppanjar_header->pangkat = $request->jabatan;
        $ppanjar_header->gol = $request->golongan;
        $ppanjar_header->jmlpanjar = $request->jumlah;
        // Save Panjar Header
        $ppanjar_header->save();

        // Save Panjar Detail;
        if (session('ppanjar_detail')) {
            foreach (session('ppanjar_detail') as $ppanjar) {
                $ppanjar_detail = new PPanjarDetail();
                $ppanjar_detail->no = $ppanjar['no'];
                $ppanjar_detail->no_ppanjar = $request->no_pj_panjar;
                $ppanjar_detail->keterangan = $ppanjar['keterangan'];
                $ppanjar_detail->nilai = $ppanjar['nilai'];
                $ppanjar_detail->qty = $ppanjar['qty'];
                $ppanjar_detail->nopek = $ppanjar['nopek'];
                $ppanjar_detail->total = $ppanjar['total'];

                $ppanjar_detail->save();
            }

            session()->forget('ppanjar_detail');
        }

        return redirect()->route('perjalanan_dinas.pertanggungjawaban.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($no_ppanjar)
    {
        $no_ppanjar = str_replace('-', '/', $no_ppanjar);
        $ppanjar_header = PPanjarHeader::find($no_ppanjar);

        $pegawai_list = Pekerja::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        // $panjar_header_list = PanjarHeader::all();

        $no_panjar = $ppanjar_header->panjar_header->no_panjar;

        $ppanjar_header_list = PPanjarHeader::select('no_panjar')
        ->whereNotNull('no_panjar')
        ->whereNotIn('no_panjar', ["$no_panjar"])
        ->get()
        ->toArray();

        $panjar_header_list = PanjarHeader::whereNotIn('no_panjar', $ppanjar_header_list)->get();

        return view('perjalanan-dinas-pertanggungjawaban.edit', compact(
            'pegawai_list',
            'panjar_header_list',
            'jabatan_list',
            'ppanjar_header'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_ppanjar)
    {
        $pegawai = Pekerja::find($request->nopek);

        $no_ppanjar = str_replace('-', '/', $no_ppanjar);
        $ppanjar_header = PPanjarHeader::find($no_ppanjar);

        $ppanjar_header->no_ppanjar = $request->no_pj_panjar;
        $ppanjar_header->no_panjar = $request->no_panjar;
        $ppanjar_header->keterangan = $request->keterangan;
        $ppanjar_header->tgl_ppanjar = date('Y-m-d H:i:s', strtotime(date('H:i:s'), strtotime($request->tanggal)));
        $ppanjar_header->nopek = $request->nopek;
        $ppanjar_header->nama = $pegawai->nama;
        $ppanjar_header->pangkat = $request->jabatan;
        $ppanjar_header->gol = $request->golongan;
        $ppanjar_header->jmlpanjar = $request->jumlah;
        // Save Panjar Header
        $ppanjar_header->save();

        return redirect()->route('perjalanan_dinas.pertanggungjawaban.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PPanjarHeader::where('no_ppanjar', $request->id)->delete();

        return response()->json();
    }

    public function exportRow($no_ppanjar)
    {
        $no_ppanjar = str_replace('-', '/', $no_ppanjar);
        
        $ppanjar_header = PPanjarHeader::find($no_ppanjar);

        $pekerja_jabatan = $ppanjar_header->pangkat;

        $pdf = DomPDF::loadview('modul-umum.perjalanan-dinas-pertanggungjawaban.export-row', [
            'ppanjar_header' => $ppanjar_header,
            'pekerja_jabatan' => $pekerja_jabatan
        ]);
        return $pdf->stream('rekap_panjar_dinas_pertanggungjawaban_'.date('Y-m-d H:i:s').'.pdf');
    }
}
