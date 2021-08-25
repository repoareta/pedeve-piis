<?php

namespace App\Http\Controllers\Umum\UangMukaKerja;

use App\Exports\RekapUMKExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UMKApprovalStoreRequest;
use App\Http\Requests\UMKDetailStoreRequest;
use Illuminate\Http\Request;

// load Model
use App\Models\Umk;
use App\Models\UmkHeader;
use App\Models\Vendor;
use App\Models\DetailUmk;
use App\Models\Kasdoc;
use App\Models\Kasline;

// load plugin
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use DB;
use DomPDF;
use App\Http\Requests\UMKStoreRequest;
use RealRashid\SweetAlert\Facades\Alert;

class UangMukaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                $bulan = substr($data_bul->bulan_buku, 4, 2);
                $tahun = substr($data_bul->bulan_buku, 0, 4);
            }
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }
        return view('modul-umum.umk.index', compact('bulan', 'tahun'));
    }

    public function indexJson(Request $request)
    {
        if ($request->permintaan <>  null and $request->tahun == null and $request->bulan == null) {
            $data = DB::select("SELECT a.no_umk,a.jenis_um,a.app_pbd,a.app_sdm,a.tgl_panjar,a.no_kas,a.keterangan,a.jumlah from kerja_header a where a.no_umk like '$request->permintaan%' order by a.bulan_buku desc,a.no_umk desc");
        } elseif ($request->permintaan <>  null and $request->tahun <>  null and $request->bulan ==  null) {
            $data = DB::select("SELECT  a.no_umk,a.jenis_um,a.app_pbd,a.app_sdm,a.tgl_panjar,a.no_kas,a.keterangan,a.jumlah from kerja_header a where a.no_umk like '$request->permintaan%' and left(a.bulan_buku,4)='$request->tahun' order by a.bulan_buku desc,a.no_umk desc");
        } elseif ($request->permintaan ==  null and $request->tahun <>  null and $request->bulan <>  null) {
            $data = DB::select("SELECT a.no_umk,a.jenis_um,a.app_pbd,a.app_sdm,a.tgl_panjar,a.no_kas,a.keterangan,a.jumlah from kerja_header a where right(a.no_umk,4)='$request->tahun' and (SUBSTRING(a.no_umk,11,2) ='$request->bulan' or SUBSTRING(a.no_umk,10,2) ='$request->bulan') order by a.bulan_buku desc,a.no_umk desc");
        } elseif ($request->permintaan <>  null and $request->tahun <>  null and $request->bulan <>  null) {
            $data = DB::select("SELECT a.no_umk,a.jenis_um,a.app_pbd,a.app_sdm,a.tgl_panjar,a.no_kas,a.keterangan,a.jumlah from kerja_header a where a.no_umk like '$request->permintaan%' and right(a.no_umk,4)='$request->tahun' and (SUBSTRING(a.no_umk,11,2) ='$request->bulan' or SUBSTRING(a.no_umk,10,2) ='$request->bulan') order by a.bulan_buku desc,a.no_umk desc");
        } else {
            $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            if (!empty($data_tahunbulan)) {
                foreach ($data_tahunbulan as $data_bul) {
                    $bulan_buku = $data_bul->bulan_buku;
                }
            } else {
                $bulan_buku = '000000';
            }
            $data = DB::select("SELECT  a.no_umk,a.jenis_um,a.app_pbd,a.app_sdm,a.tgl_panjar,a.no_kas,a.keterangan,a.jumlah from kerja_header a where a.bulan_buku ='$bulan_buku' order by a.bulan_buku desc,a.no_umk desc");
        }
        return datatables()->of($data)
            ->addColumn('jenis_um', function ($data) {
                if ($data->jenis_um == 'K') {
                    $UM = 'UM Kerja</p>';
                } else {
                    $UM = 'UM Dinas</p>';
                }
                return $UM;
            })
            ->addColumn('tgl_panjar', function ($data) {
                $tgl = date_create($data->tgl_panjar);
                return date_format($tgl, 'd F Y');
            })
            ->addColumn('jumlah', function ($data) {
                return number_format($data->jumlah, 2, '.', ',');
            })

            ->addColumn('radio', function ($data) {
                if ($data->app_pbd == 'Y') {
                    $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-s="Y" dataumk="' . $data->no_umk . '" data-id="' . str_replace('/', '-', $data->no_umk) . '" class="btn-radio" name="btn-radio"><span></span></label>';
                } else {
                    if ($data->app_sdm == 'Y') {
                        $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-s="N" dataumk="' . $data->no_umk . '" data-id="' . str_replace('/', '-', $data->no_umk) . '" name="btn-radio" class="btn-radio"><span></span></label>';
                    } else {
                        $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-s="N" class="btn-radio" dataumk="' . $data->no_umk . '" data-id="' . str_replace('/', '-', $data->no_umk) . '" name="btn-radio"><span></span></label>';
                    }
                }
                return $radio;
            })
            ->addColumn('approval', function ($data) {
                if ($data->app_pbd == 'Y') {
                    $action = '<span class="pointer-link" title="Data Sudah di proses perbendaharaan"><i class="fas fa-check-circle fa-2x text-success"></i></span>';
                } else {
                    if ($data->app_sdm == 'Y') {
                        $action = '<a href="' . route('modul_umum.uang_muka_kerja.approve', ['id' => str_replace('/', '-', $data->no_umk)]) . '"><span class="pointer-link" title="Batalkan Approval"><i class="fas fa-check-circle fa-2x text-success"></i></span></a>';
                    } else {
                        $action = '<a href="' . route('modul_umum.uang_muka_kerja.approve', ['id' => str_replace('/', '-', $data->no_umk)]) . '"><span class="pointer-link" title="Klik untuk Approval"><i class="fas fa-ban fa-2x text-danger"></i></span></a>';
                    }
                }
                return $action;
            })
            ->rawColumns(['radio', 'approval', 'jenis_um'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bulan_buku = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'")[0]->bulan_buku;
        $awal = "CS";
        $data = DB::select("SELECT left(max(no_umk),-14) as no_umk from kerja_header where  date_part('year', tgl_panjar)  = date_part('year', CURRENT_DATE)");
        foreach ($data as $data_no_umk) {
            $data_no_umk->no_umk;
        }
        $no_umk_max = $data_no_umk->no_umk;
        if (!empty($no_umk_max)) {
            $no_umk = sprintf("%03s", abs($no_umk_max + 1)) . '/' . $awal . '/' . date('d/m/Y');
        } else {
            $no_umk = sprintf("%03s", 1) . '/' . $awal . '/' . date('d/m/Y');
        }
        $vendor = Vendor::all();
        return view('modul-umum.umk.create', compact('no_umk', 'vendor', 'bulan_buku'));
    }

    /**
     * melakukan insert ke umk
     */
    public function store(UMKStoreRequest $request)
    {
        $validated = collect($request->validated())
            ->forget('jumlah')
            ->put('jumlah', str_replace([',', '.'], '', $request->jumlah));

        $check_data = DB::select("SELECT * FROM kerja_header WHERE no_umk = '$request->no_umk'");

        if (!empty($check_data)) {
            DB::table('kerja_header')
                ->where('no_umk', $request->no_umk)
                ->update($validated->forget('no_umk')->toArray());

            Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
            return redirect()->route('modul_umum.uang_muka_kerja.index');
        }

        DB::table('kerja_header')->insert($validated->toArray());

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_umum.uang_muka_kerja.edit', [str_replace('/', '-', $request->no_umk)]);
    }

    public function storeDetail(UMKDetailStoreRequest $request)
    {
        $check_data =  DB::select("SELECT * from kerja_detail where no = '$request->no' and  no_umk = '$request->no_umk'");
        if (!empty($check_data)) {
            DetailUmk::where('no_umk', $request->no_umk)
                ->where('no', $request->no)
                ->update([
                    'no' => $request->no,
                    'keterangan' => $request->keterangan,
                    'account' => $request->acc,
                    'nilai' =>   sanitize_nominal($request->nilai),
                    'cj' => $request->cj,
                    'jb' => $request->jb,
                    'bagian' => $request->bagian,
                    'pk' => $request->pk,
                    'no_umk' => $request->no_umk
                ]);
            $count = DetailUmk::where('no_umk', $request->no_umk)->select('no_umk')->sum('nilai');
            $jumlah = number_format($count, 0, '', '');
            Umk::where('no_umk', $request->no_umk)
                ->update([
                    'jumlah' => $jumlah
                ]);
            return response()->json();
        } else {
            DetailUmk::insert([
                'no' => $request->no,
                'keterangan' => $request->keterangan,
                'account' => $request->acc,
                'nilai' =>    sanitize_nominal($request->nilai),
                'cj' => $request->cj,
                'jb' => $request->jb,
                'bagian' => $request->bagian,
                'pk' => $request->pk,
                'no_umk' => $request->no_umk
            ]);
            $count = DetailUmk::where('no_umk', $request->no_umk)->select('no_umk')->sum('nilai');
            $jumlah = number_format($count, 0, '', '');
            Umk::where('no_umk', $request->no_umk)
                ->update([
                    'jumlah' => $jumlah
                ]);
            return response()->json();
        }
    }

    public function storeApp(UMKApprovalStoreRequest $request)
    {
        $noumk = str_replace('-', '/', $request->noumk);
        $data_app = Umk::where('no_umk', $noumk)->select('*')->get();
        foreach ($data_app as $data) {
            $check_data = $data->app_sdm;
        }
        if ($check_data == 'Y') {
            $data_delkerja = DB::select("SELECT no_kas from kerja_header where upper(no_umk)=upper('$noumk')");
            foreach ($data_delkerja as $data_del) {
                Kasdoc::where('docno', $data_del->no_kas)->delete();
                Kasline::where('docno', $data_del->no_kas)->delete();
            }
            Umk::where('no_umk', $noumk)
                ->update([
                    'app_sdm' => 'N',
                    'app_sdm_oleh' => $request->userid,
                    'app_sdm_tgl' => $request->tgl_app,
                    'no_kas' => ''
                ]);
            Alert::success('No. UMK : ' . $noumk . ' Berhasil Dibatalkan Approval', 'Berhasil')->persistent(true)->autoClose(2000);
            return redirect()->route('uang_muka_kerja.index');
        } else {
            $timestamp = date("Y-m-d H:i:s");
            $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            if (!empty($data_tahunbulan)) {
                foreach ($data_tahunbulan as $data_bul) {
                    $bulan_buku = $data_bul->bulan_buku;
                }
            } else {
                $bulan_buku = '000000';
            }
            $bulan = substr($bulan_buku, 4);
            $tahun = substr($bulan_buku, 0, -2);
            $data_crh = DB::select("SELECT * from kerja_header where upper(no_umk)=upper('$noumk')");
            $v_bagian = 'D0000';
            foreach ($data_crh as $t) {
                $data_vno = DB::select("SELECT max(substring(docno from 13)) as v_no from kasdoc where docno like 'P/'||'$v_bagian'||'/'||substring('$bulan_buku' from 3 for 2) || substring('$bulan_buku' from 5 for 2) || '%'");
                if (!empty($data_vno)) {
                    foreach ($data_vno as $data_vn) {
                        $v_no = sprintf("%03s", abs($data_vn->v_no + 1));
                    }
                } else {
                    $v_no = '001';
                }
                $v_docno = 'P/' . $v_bagian . '/' . substr($bulan_buku, 2, 2) . '' . substr($bulan_buku, 4, 2) . '' . $v_no;

                $data_nobukti = DB::select("SELECT max(voucher) as vnomorbukti  from kasdoc where thnbln= '$bulan_buku' and store='10' and substring(docno,1,1)='P'");
                if (!empty($data_nobukti)) {
                    foreach ($data_nobukti as $data_nobuk) {
                        $vnomorbukti = sprintf("%03s", abs($data_nobuk->vnomorbukti + 1));
                    }
                } else {
                    $vnomorbukti = '001';
                }
                $data_nover = DB::select("SELECT max(left(mrs_no,4)) as v_nover  from kasdoc where thnbln='$bulan_buku' and substring(docno,1,1)='P'");
                if (!empty($data_nover)) {
                    foreach ($data_nover as $data_nov) {
                        $v_nover  = sprintf("%03s", abs($data_nov->v_nover + 1));
                    }
                } else {
                    $v_nover = '001';
                }
                Kasdoc::insert([
                    'docno' => $v_docno,
                    'thnbln' => $bulan_buku,
                    'jk' => '10',
                    'store' => '10',
                    'ci' => '1',
                    'voucher' => $vnomorbukti,
                    'kepada' => 'SDR.ANGGRAINI GITTA LESTARI',
                    'debet' => '0',
                    'kredit' => '0',
                    'original' => 'Y',
                    'originaldate' => $timestamp,
                    'verified' => 'N',
                    'paid' => 'N',
                    'posted' => 'N',
                    'inputdate' => $timestamp,
                    'inputpwd' => $request->userid,
                    'rate' => $t->rate,
                    'nilai_dok' => $t->jumlah,
                    'kd_kepada' => 'PUMK',
                    'originalby' => $request->userid,
                    'ket1' => 'PUMK ' . $noumk,
                    'ket2' => '(Terlampir)',
                    'ref_no' => $noumk,
                    'mrs_no' => $v_nover
                ]);
                $data_crd = DB::select("SELECT * from kerja_detail where upper(no_umk)=upper('$noumk') order by no");
                foreach ($data_crd as $d) {
                    Kasline::insert([
                        'docno'  => $v_docno,
                        'lineno'  => $d->no,
                        'account'  => $d->account,
                        'bagian'  => $d->bagian,
                        'pk'  => $d->pk,
                        'jb'  => $d->jb,
                        'cj'  => $d->cj,
                        'keterangan'  => $d->keterangan,
                        'penutup'  => 'N',
                        'totprice'  => $d->nilai,
                        'lokasi' => 'MS'
                    ]);
                }
            }
            Umk::where('no_umk', $noumk)
                ->update([
                    'no_kas' => $v_docno,
                    'app_sdm' => 'Y',
                    'app_sdm_oleh' => $request->userid,
                    'app_sdm_tgl' => $timestamp,
                    'app_pbd' => 'N'
                ]);
            Alert::success('No. UMK : ' . $noumk . ' Berhasil Diapproval', 'Berhasil')->persistent(true)->autoClose(2000);
            return redirect()->route('modul_umum.uang_muka_kerja.index');
        }
    }

    public function edit($no)
    {
        $noumk = str_replace('-', '/', $no);
        $data_umk = DB::select("SELECT * from kerja_header where no_umk = '$noumk'")[0];

        // dd($data_umk);
        $no_uruts = DB::select("SELECT max(no) as no from kerja_detail where no_umk = '$noumk'");
        $data_umk_details = DetailUmk::where('no_umk', $noumk)->get();
        $data_account = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%' order by kodeacct desc");
        $data_bagian = DB::select("SELECT a.kode,a.nama from sdm_tbl_kdbag a order by a.kode");
        $data_jenisbiaya = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
        $data_cj = DB::select("SELECT kode,nama from cashjudex order by kode");
        $count = DetailUmk::where('no_umk', $noumk)->select('no_umk')->sum('nilai');
        $vendor = Vendor::all();
        if (!empty($no_urut) == null) {
            foreach ($no_uruts as $no_urut) {
                $no_umk_details = $no_urut->no + 1;
            }
        } else {
            $no_umk_details = 1;
        }

        return view('modul-umum.umk.edit', compact(
            'data_umk',
            'data_umk_details',
            'no_umk_details',
            'data_account',
            'data_bagian',
            'data_jenisbiaya',
            'data_cj',
            'count',
            'vendor',
            'noumk'
        ));
    }

    public function searchAccount(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_account = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%' and (kodeacct like '$cari%' or descacct like '$cari%') order by kodeacct desc");
            return response()->json($data_account);
        }
    }
    public function searchBagian(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_bagian = DB::select("SELECT kode,nama from sdm_tbl_kdbag where kode like '$cari%' or nama like '$cari%' order by kode");
            return response()->json($data_bagian);
        }
    }
    public function searchJb(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_jenisbiaya = DB::select("SELECT kode,keterangan from jenisbiaya where kode like '$cari%' or keterangan like '$cari%' order by kode");
            return response()->json($data_jenisbiaya);
        }
    }
    public function searchCj(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_cj = DB::select("SELECT kode,nama from cashjudex where kode like '$cari%' or nama like '$cari%' order by kode");
            return response()->json($data_cj);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($dataid, $datano)
    {
        $noumk = str_replace('-', '/', $dataid);

        $data = DetailUmk::where('no', $datano)->where('no_umk', $noumk)->distinct()->get();
        return response()->json($data[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete(Request $request)
    {
        Umk::where('no_umk', $request->id)->delete();
        DetailUmk::where('no_umk', $request->id)->delete();
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDetail(Request $request)
    {
        DetailUmk::where('no', $request->no)
            ->where('no_umk', $request->id)
            ->delete();
        $count = DetailUmk::where('no_umk', $request->id)->select('no_umk')->sum('nilai');
        $jumlah = number_format($count, 0, '', '');
        Umk::where('no_umk', $request->id)
            ->update([
                'jumlah' => $jumlah
            ]);
        return response()->json();
    }


    public function approve($id)
    {
        $noumk = str_replace('-', '/', $id);
        $data = Umk::where('no_umk', $noumk)->select('*')->first();
        return view('modul-umum.umk.approv', compact('data'));
    }

    public function rekap($id)
    {
        $noumk = str_replace('-', '/', $id);
        $data_cekjb = DB::select("SELECT a.no_umk,(select sum(nilai) from kerja_detail where upper(no_umk)=upper(a.no_umk)) as total from kerja_header a where upper(a.no_umk)='$noumk'");
        foreach ($data_cekjb as $data_cek) {
            $data_c = $data_cek->total;
        }
        if ($data_c < 10000000) {
            $setuju = "ALI SYAMSUL ROHMAN";
            $setujus = "CS & BS";
            $pemohon = "ANGGRAINI GITTA L";
            $pemohons = "IA & RM";
        } else {
            $setuju = "SJAHRIL SAMAD";
            $setujus = "DIREKTUR UTAMA";
            $pemohon = "ALI SYAMSUL ROHMAN";
            $pemohons = "CS & BS";
        }
        $data_report = Umk::where('no_umk', $noumk)->select('*')->get();
        return view('modul-umum.umk.rekap', compact(
            'data_report',
            'setuju',
            'setujus',
            'pemohon',
            'pemohons'
        ));
    }

    public function rekapRange()
    {
        return view('modul-umum.umk.rekap-range');
    }

    public function rekapExport(Request $request)
    {
        $noumk = $request->noumk;
        $header_list = Umk::where('no_umk', $noumk)->get();
        foreach ($header_list as $data_report) {
            $data_report;
        }
        $detail_list = DetailUmk::where('no_umk', $noumk)->get();
        $list_acount = DetailUmk::where('no_umk', $noumk)->select('nilai')->sum('nilai');
        $pdf = DomPDF::loadview('modul-umum.umk.export', compact(
            'list_acount',
            'data_report',
            'detail_list',
            'request'
        ))->setPaper('a4', 'Portrait');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->getCanvas();
        $canvas->page_text(690, 100, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function rekapExportRange(Request $request)
    {
        $data_cek = Umk::whereBetween('tgl_panjar', [$request->mulai, $request->sampai])->count();
        if ($data_cek == 0) {
            Alert::error('Tidak Ada Data Pada Tanggal Mulai: ' . $request->mulai . ' Sampai Tanggal: ' . $request->sampai . '', 'Failed')->persistent(true);
            return redirect()->route('modul_umum.uang_muka_kerja.rekap.range');
        } else {
            if ($request->submit == 'pdf') {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln     = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );

                $bulan = strtoupper($array_bln[(int)$pecahkan[1]]);
                $tahun = $pecahkan[0];
                $umk_header_list = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])
                    ->get();
                // dd($umk_header_list);
                $list_acount = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])
                    ->select('jumlah')->sum('jumlah');
                $pdf = DomPDF::loadview('modul-umum.umk.export-range', compact('umk_header_list', 'list_acount', 'bulan', 'tahun'))->setPaper('a4', 'landscape');
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(690, 100, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } elseif ($request->submit == 'xlsx') {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln     = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );

                $bulan = strtoupper($array_bln[(int)$pecahkan[1]]);
                $tahun = $pecahkan[0];
                $umk_header_list = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])->get();
                $list_acount = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])->select('jumlah')->sum('jumlah');

                $dataExcel = [
                    $umk_header_list,
                    $list_acount,
                    [$mulai, $sampai],
                    [$bulan, $tahun],
                ];

                return (new RekapUMKExport($dataExcel))->download('REKAP-' . date('Ymd') . '.xlsx');
            } else {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln     = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );

                $bulan = strtoupper($array_bln[(int)$pecahkan[1]]);
                $tahun = $pecahkan[0];
                $umk_header_list = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])
                    ->get();
                $list_acount = Umk::whereBetween('tgl_panjar', [$mulai, $sampai])
                    ->select('jumlah')->sum('jumlah');
                $excel = new Spreadsheet;
                return view('modul-umum.umk.export-csv', compact('umk_header_list', 'list_acount', 'excel', 'bulan', 'tahun'));
            }
        }
    }


    /**
     * show umk detail as JSON Type
     *
     * @param Request $request
     * @return void
     */
    public function showJson(Request $request)
    {
        $no_umk = str_replace('-', '/', $request->id);
        $data = UmkHeader::find($no_umk);

        return response()->json($data, 200);
    }
}
