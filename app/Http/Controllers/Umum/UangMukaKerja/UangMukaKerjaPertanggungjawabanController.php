<?php

namespace App\Http\Controllers\Umum\UangMukaKerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Load Model
use App\Models\PUmkHeader;
use App\Models\PUmkDetail;
use App\Models\UmkHeader;
use App\Models\MasterPegawai;
use App\Models\KodeBagian;
use App\Models\KodeJabatan;

// Load Plugin
use DomPDF;
use DB;
use Alert;
use DataTables;

class UangMukaKerjaPertanggungjawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = PUmkHeader::whereNotNull('tgl_pumk')
        ->distinct()
        ->orderBy('year', 'DESC')
        ->get([DB::raw('extract(year from tgl_pumk) as year')]);

        return view('modul-umum.umk_pertanggungjawaban.index', compact('tahun'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function indexJson(Request $request)
    {
        // dd($request->get('no_pumk'));

        $pumk_list = PUmkHeader::orderBy('tgl_pumk', 'desc')
        ->orderBy('no_pumk', 'desc');

        return DataTables::of($pumk_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('no_pumk')) {
                    $query->where('no_pumk', 'like', "%{$request->get('no_pumk')}%");
                }

                if ($request->has('bulan')) {
                    $query->where('tgl_pumk', 'like', "%{$request->get('bulan')}%");
                }

                if ($request->has('tahun')) {
                    $query->where('tgl_pumk', 'like', "%{$request->get('tahun')}%");
                }
            })

            ->addColumn('nama', function ($row) {
                return $row->nopek." - ".$row->pekerja->nama;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr(optional($row->umk_header)->jumlah - $row->pumk_detail->sum('nilai'));
            })
            ->addColumn('approval', function ($row) {
                if ($row->app_pbd == 'Y') {
                    $button = '<span class="text-success"><i class="fas fa-check-circle"title="Data Sudah di proses perbendaharaan"></i></span>';
                } else {
                    if ($row->app_sdm == 'Y') {
                        $button = '<a href="'. route('uang_muka_kerja.pertanggungjawaban.approval', ['no_pumk' => str_replace('/', '-', $row->no_pumk)]).'"><span class="text-success"><i class="fas fa-check-circle"title="Batalkan Approval"></i></span></a>';
                    } else {
                        $button = '<a href="'. route('uang_muka_kerja.pertanggungjawaban.approval', ['no_pumk' => str_replace('/', '-', $row->no_pumk)]).'"><span class="text-danger"><i class="fas fa-ban" title="Klik untuk Approval"></i></span></a>';
                    }
                }

                return $button;
            })
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->no_pumk.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action', 'approval'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        $pumk_header_list = PUmkHeader::select('no_umk')->whereNotNull('no_umk')->get()->toArray();
        $umk_header_list = UmkHeader::whereNotIn('no_umk', $pumk_header_list)->get();

        $pumk_header_count = PUmkHeader::all()->count();

        $account_list = DB::select("SELECT kodeacct, descacct FROM account where LENGTH(kodeacct)=6 AND kodeacct NOT LIKE '%X%' ORDER BY kodeacct DESC");

        $bagian_list = DB::select("SELECT A.kode,A.nama FROM sdm_tbl_kdbag A ORDER BY A.kode");

        $jenis_biaya_list = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
        
        $c_judex_list = DB::select("SELECT kode,nama from cashjudex order by kode");

        return view('modul-umum.umk_pertanggungjawaban.create', compact(
            'pegawai_list',
            'umk_header_list',
            'pumk_header_count',
            'jabatan_list',
            'account_list',
            'bagian_list',
            'jenis_biaya_list',
            'c_judex_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pegawai = MasterPegawai::find($request->nopek);
        
        $pumk_header = new PUmkHeader;
        $pumk_header->no_pumk = $request->no_pumk;
        $pumk_header->no_umk = $request->no_umk;
        $pumk_header->keterangan = $request->keterangan;
        $pumk_header->tgl_pumk = date('Y-m-d H:i:s', strtotime(date('H:i:s'), strtotime($request->tanggal)));
        $pumk_header->nopek = $request->nopek;
        $pumk_header->nama = $pegawai->nama;
        $pumk_header->app_sdm = 'N';
        $pumk_header->app_pbd = 'N';
        // Save Panjar Header
        $pumk_header->save();

        // Save Panjar Detail;
        if (session('pumk_detail')) {
            foreach (session('pumk_detail') as $key => $value) {
                $pumk_detail = new PUmkDetail;
                $pumk_detail->no = $value['no'];
                $pumk_detail->keterangan = $value['keterangan'];
                $pumk_detail->account = $value['account'];
                $pumk_detail->nilai = $value['nilai'];
                $pumk_detail->cj = $value['cj'];
                $pumk_detail->jb = $value['jb'];
                $pumk_detail->bagian = $value['bagian'];
                $pumk_detail->pk = $value['pk'];
                $pumk_detail->no_pumk = $request->no_pumk; // for add edit only
    
                $pumk_detail->save();
            }
    
            session()->forget('pumk_detail');
        }

        Alert::success('Simpan Pertanggungjawaban UMK', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('uang_muka_kerja.pertanggungjawaban.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($no_pumk)
    {
        $no_pumk = str_replace('-', '/', $no_pumk);
        $pumk_header = PUmkHeader::find($no_pumk);

        $no_umk = $pumk_header->umk_header->no_umk;

        $pegawai_jabatan = KodeJabatan::where('kdbag', $pumk_header->pekerja->jabatan_latest()->kdbag)
        ->where('kdjab', $pumk_header->pekerja->jabatan_latest()->kdjab)
        ->first();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nama', 'ASC')
        ->get();

        $jabatan_list = KodeJabatan::distinct('keterangan')
        ->orderBy('keterangan', 'ASC')
        ->get();

        $pumk_header_list = PUmkHeader::select('no_umk')
        ->whereNotNull('no_umk')
        ->whereNotIn('no_umk', ["$no_umk"])
        ->get()
        ->toArray();

        $umk_header_list = UmkHeader::whereNotIn('no_umk', $pumk_header_list)->get();

        $account_list = DB::select("SELECT kodeacct, descacct FROM account where LENGTH(kodeacct)=6 AND kodeacct NOT LIKE '%X%' ORDER BY kodeacct DESC");

        $bagian_list = DB::select("SELECT A.kode,A.nama FROM sdm_tbl_kdbag A ORDER BY A.kode");

        $jenis_biaya_list = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
        
        $c_judex_list = DB::select("SELECT kode,nama from cashjudex order by kode");

        return view('modul-umum.umk_pertanggungjawaban.edit', compact(
            'pegawai_list',
            'umk_header_list',
            'jabatan_list',
            'account_list',
            'bagian_list',
            'jenis_biaya_list',
            'c_judex_list',
            'pumk_header',
            'pekerja_jabatan'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_pumk)
    {
        $pegawai = MasterPegawai::find($request->nopek);

        $no_pumk = str_replace('-', '/', $no_pumk);
        
        $pumk_header = PUmkHeader::where('no_pumk', $no_pumk)->first();
        $pumk_header->no_pumk = $request->no_pumk;
        $pumk_header->no_umk = $request->no_umk;
        $pumk_header->keterangan = $request->keterangan;
        $pumk_header->tgl_pumk = date('Y-m-d H:i:s', strtotime(date('H:i:s'), strtotime($request->tanggal)));
        $pumk_header->nopek = $request->nopek;
        $pumk_header->nama = $pegawai->nama;
        // Save Panjar Header
        $pumk_header->save();

        Alert::success('Ubah Pertanggungjawaban UMK', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('uang_muka_kerja.pertanggungjawaban.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PUmkHeader::where('no_pumk', $request->id)->delete();

        return response()->json();
    }

    public function exportRow($no_pumk)
    {
        $no_pumk = str_replace('-', '/', $no_pumk);
        
        $pumk_header = PUmkHeader::where('no_pumk', $no_pumk)->first();

        $pegawai_jabatan = KodeJabatan::where('kdbag', $pumk_header->pekerja->jabatan_latest()->kdbag)
        ->where('kdjab', $pumk_header->pekerja->jabatan_latest()->kdjab)
        ->first();

        $pdf = DomPDF::loadview('modul-umum.umk_pertanggungjawaban.export_row', [
            'pumk_header' => $pumk_header,
            'pekerja_jabatan' => $pegawai_jabatan
        ]);
        return $pdf->stream('rekap_umk_pertanggungjawaban_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function approve($id)
    {
        $no_pumk = str_replace('-', '/', $id);
        $pumk_header = PUmkHeader::where('no_pumk', $no_pumk)->first();
        return view('modul-umum.umk_pertanggungjawaban.approv', compact('pumk_header'));
    }

    public function storeApp(Request $request)
    {
        $no_pumk = $request->no_pumk;
        $pumk = PUmkHeader::where('no_pumk', $no_pumk)->first();

        // dd($request->userid);

        if ($pumk->app_sdm == 'N') {
            // Begin APPR_UMUM_PUMK
            DB::statement("SELECT appr_umum_pumk('$no_pumk', '$request->userid')");

            Alert::success('No. PUMK : '.$no_pumk.' Berhasil Approval', 'Berhasil')->persistent(true)->autoClose(2000);
        } else {
            $cek_approval = $pumk->app_pbd;
            if ($cek_approval == 'Y') {
                Alert::success('Pembatalan approval gagal,Data sudah di Approv perbendaharaan', 'Gagal')->persistent(true)->autoClose(2000);
            } else {
                $rs_batal = $pumk->app_sdm_tgl;
                if ($rs_batal) {
                    $tgl_approval = $rs_batal;
                }

                // Begin APPR_UMUM_PUMK
                DB::statement("SELECT appr_batal_pumk('$no_pumk', '$request->userid')");

                Alert::success("Pembatalan approval No. PUMK : $no_pumk Tanggal Approval $tgl_approval", 'Berhasil')
                ->persistent(true)
                ->autoClose(2000);
            }
        }

        return redirect()->route('uang_muka_kerja.pertanggungjawaban.index');
    }
}
