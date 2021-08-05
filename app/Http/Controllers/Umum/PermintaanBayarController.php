<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PermintaanBayarHeader;
use App\Models\Vendor;
use App\Models\PermintaanBayarDetail;
use App\Models\UmuDebetNota;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use DB;
use DomPDF;
use Alert;

class PermintaanBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        return view('modul-umum.permintaan-bayar.index', compact('bulan', 'tahun'));
    }

    public function indexJson(Request $request)
    {
        if ($request->permintaan <>  null and $request->tahun == null and $request->bulan == null) {
            $data = DB::select("SELECT a.no_bayar,a.kepada,a.bulan_buku,a.keterangan,a.lampiran,a.no_kas,a.app_pbd as app_pbd,a.app_sdm as app_sdm,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as nilai from umu_bayar_header a where a.no_bayar like '$request->permintaan%' order by a.no_bayar desc");
        } elseif ($request->permintaan <>  null and $request->tahun <>  null and $request->bulan ==  null) {
            $data = DB::select("SELECT  a.no_bayar,a.kepada,a.bulan_buku,a.keterangan,a.lampiran,a.no_kas,a.app_pbd as app_pbd,a.app_sdm as app_sdm,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as nilai from umu_bayar_header a where a.no_bayar like '$request->permintaan%' and left(a.bulan_buku,4)='$request->tahun' order by a.no_bayar desc");
        } elseif ($request->permintaan ==  null and $request->tahun <>  null and $request->bulan <>  null) {
            $data = DB::select("SELECT a.no_bayar,a.kepada,a.bulan_buku,a.keterangan,a.lampiran,a.no_kas,a.app_pbd as app_pbd,a.app_sdm as app_sdm,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as nilai from umu_bayar_header a where right(a.no_bayar,4)='$request->tahun' and SUBSTRING(a.no_bayar,11,2) ='$request->bulan' order by a.no_bayar desc");
        } elseif ($request->permintaan <>  null and $request->tahun <>  null and $request->bulan <>  null) {
            $data = DB::select("SELECT a.no_bayar,a.kepada,a.bulan_buku,a.keterangan,a.lampiran,a.no_kas,a.app_pbd as app_pbd,a.app_sdm as app_sdm,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as nilai from umu_bayar_header a where a.no_bayar like '$request->permintaan%' and right(a.no_bayar,4)='$request->tahun' and SUBSTRING(a.no_bayar,11,2) ='$request->bulan' order by a.no_bayar desc");
        } else {
            $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            foreach ($data_tahunbulan as $data_bul) {
                $bulan_buku = $data_bul->bulan_buku;
            }
             
            $data = DB::select("SELECT  a.no_bayar,a.kepada,a.bulan_buku,a.keterangan,a.lampiran,a.no_kas,a.app_pbd as app_pbd,a.app_sdm as app_sdm,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as nilai from umu_bayar_header a where a.bulan_buku ='$bulan_buku' order by a.no_bayar desc");
        }

        return datatables()->of($data)
        ->addColumn('nilai', function ($data) {
            return currency_format($data->nilai);
        })
        ->addColumn('radio', function ($data) {
            if ($data->app_pbd == 'Y') {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-s="Y" databayar="'.$data->no_bayar.'" data-id="'.str_replace('/', '-', $data->no_bayar).'" name="btn-radio" ><span></span></label>';
            } else {
                if ($data->app_sdm == 'Y') {
                    $radio =  '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-s="N" databayar="'.$data->no_bayar.'" data-id="'.str_replace('/', '-', $data->no_bayar).'" name="btn-radio"><span></span></label>';
                } else {
                    $radio =  '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-s="N" databayar="'.$data->no_bayar.'" data-id="'.str_replace('/', '-', $data->no_bayar).'" name="btn-radio"><span></span></label>';
                }
            }
            return $radio;
        })
        ->addColumn('action', function ($data) {
            if ($data->app_pbd == 'Y') {
                $action = '<span title="Data Sudah di proses perbendaharaan"><i class="fas fa-check-circle fa-2x fa-2x text-success"></i></span>';
            } else {
                if ($data->app_sdm == 'Y') {
                    $action = '<a href="'. route('modul_umum.permintaan_bayar.approv', ['id' => str_replace('/', '-', $data->no_bayar)]).'"><span title="Batalkan Approval"><i class="fas fa-check-circle fa-2x fa-2x text-success"></i></span></a>';
                } else {
                    $action = '<a href="'. route('modul_umum.permintaan_bayar.approv', ['id' => str_replace('/', '-', $data->no_bayar)]).'"><span title="Klik untuk Approval"><i class="fas fa-ban fa-2x text-danger"></i></span></a>';
                }
            }
            return $action;
        })
        ->rawColumns(['action','radio'])
        ->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $debit_nota = UmuDebetNota::all();
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        foreach ($data_tahunbulan as $data_bul) {
            $bulan_buku = $data_bul->bulan_buku;
        }
        $data = DB::select("SELECT left(max(no_bayar),-14) as no_bayar from umu_bayar_header where  date_part('year', tgl_bayar)  = date_part('year', CURRENT_DATE)");
        foreach ($data as $data_no_bayar) {
            $data_no_bayar->no_bayar;
        }
        $no_bayar_max = $data_no_bayar->no_bayar;
        if (!empty($no_bayar_max)) {
            $permintaan_header_count= sprintf("%03s", abs($no_bayar_max + 1)). '/CS/' . date('d/m/Y');
        } else {
            $permintaan_header_count= sprintf("%03s", 1). '/CS/' . date('d/m/Y');
        }
        $vendor = Vendor::all();
        return view('modul-umum.permintaan-bayar.create', compact('debit_nota', 'permintaan_header_count', 'vendor', 'bulan_buku'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check_data =  DB::select("SELECT * from umu_bayar_header where no_bayar = '$request->nobayar'");
        if (!empty($check_data)) {
            PermintaanBayarHeader::where('no_bayar', $request->nobayar)
            ->update([
            'no_bayar' => $request->nobayar,
            'tgl_bayar' => $request->tanggal,
            'lampiran' => $request->lampiran,
            'keterangan' => $request->keterangan,
            'kepada' => $request->dibayar,
            'debet_dari' => $request->debetdari,
            'debet_no' => $request->nodebet,
            'debet_tgl' => $request->tgldebet,
            'no_kas' => $request->nokas,
            'bulan_buku' => $request->bulanbuku,
            'ci' => $request->ci,
            'rate' => $request->kurs,
            'mulai' => $request->mulai,
            'sampai' => $request->sampai,
            ]);
            return response()->json();
        } else {
            DB::table('umu_bayar_header')->insert([
            'no_bayar' => $request->nobayar,
            'tgl_bayar' => $request->tanggal,
            'lampiran' => $request->lampiran,
            'keterangan' => $request->keterangan,
            'kepada' => $request->dibayar,
            'debet_dari' => $request->debetdari,
            'rekyes' => $request->rekyes,
            'debet_no' => $request->nodebet,
            'debet_tgl' => $request->tgldebet,
            'no_kas' => $request->nokas,
            'bulan_buku' => $request->bulanbuku,
            'ci' => $request->ci,
            'rate' => $request->kurs,
            'mulai' => $request->mulai,
            'sampai' => $request->sampai,
            'app_sdm' => 'N',
            'app_pbd' => 'N',
            // Save Panjar Header
            ]);
            return response()->json();
        }
    }

    public function storeDetail(request $request)
    {
        $check_data =  DB::select("SELECT * from umu_bayar_detail where no = '$request->no' and  no_bayar = '$request->nobayar'");
        if (!empty($check_data)) {
            PermintaanBayarDetail::where('no_bayar', $request->nobayar)
            ->where('no', $request->no)
            ->update([
            'no' => $request->no,
            'keterangan' => $request->keterangan,
            'account' => $request->acc,
            'nilai' => str_replace(',', '.', $request->nilai),
            'cj' => $request->cj,
            'jb' => $request->jb,
            'bagian' => $request->bagian,
            'pk' => $request->pk,
            'no_bayar' => $request->nobayar
            ]);
            return response()->json();
        } else {
            PermintaanBayarDetail::insert([
            'no' => $request->no,
            'keterangan' => $request->keterangan,
            'account' => $request->acc,
            'nilai' => str_replace(',', '.', $request->nilai),
            'cj' => $request->cj,
            'jb' => $request->jb,
            'bagian' => $request->bagian,
            'pk' => $request->pk,
            'no_bayar' => $request->nobayar
            ]);
            return response()->json();
        }
    }

    public function storeApp(Request $request)
    {
        $nobayar=str_replace('-', '/', $request->nobayar);
        $data_app = PermintaanBayarHeader::where('no_bayar', $nobayar)->select('*')->get();
        foreach ($data_app as $data) {
            $check_data = $data->app_sdm;
        }
        if ($check_data == 'Y') {
            PermintaanBayarHeader::where('no_bayar', $nobayar)
            ->update([
                'app_sdm' => 'N',
                'app_sdm_oleh' => $request->userid,
                'app_sdm_tgl' => $request->tgl_app,
            ]);
            Alert::success('No. Bayar : '.$nobayar.' Berhasil Dibatalkan Approval', 'Berhasil')->persistent(true)->autoClose(2000);
            return redirect()->route('permintaan_bayar.index');
        } else {
            PermintaanBayarHeader::where('no_bayar', $nobayar)
            ->update([
                'app_sdm' => 'Y',
                'app_sdm_oleh' => $request->userid,
                'app_sdm_tgl' => $request->tgl_app,
            ]);
            Alert::success('No. Bayar : '.$nobayar.' Berhasil Diapproval', 'Berhasil')->persistent(true)->autoClose(2000);
            return redirect()->route('permintaan_bayar.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nobayar)
    {
        $nobayars=str_replace('-', '/', $nobayar);
        $data_bayars =  PermintaanBayarHeader::where('no_bayar', $nobayars)->get();
        $debit_nota = UmuDebetNota::all();
        $no_uruts =  DB::select("SELECT max(no) as no from umu_bayar_detail where no_bayar = '$nobayars'");
        $data_bayar_details = PermintaanBayarDetail::where('no_bayar', $nobayars)->get();
        $data_account = DB::select("SELECT kodeacct, descacct FROM account where LENGTH(kodeacct)=6 AND kodeacct NOT LIKE '%X%' order by kodeacct desc");
        $data_bagian = DB::select("SELECT A.kode,A.nama FROM sdm_tbl_kdbag A ORDER BY A.kode");
        $data_jenisbiaya = DB::select("SELECT kode,keterangan from jenisbiaya order by kode");
        $data_cj = DB::select("SELECT kode,nama from cashjudex order by kode");
        $count= PermintaanBayarDetail::where('no_bayar', $nobayars)->select('no_bayar')->sum('nilai');
        $vendor=Vendor::all();
        if (!empty($no_urut) == null) {
            foreach ($no_uruts as $no_urut) {
                $no_bayar_details=$no_urut->no + 1;
            }
        } else {
            $no_bayar_details= 1;
        }
        return view('modul-umum.permintaan-bayar.edit', compact(
            'data_bayars',
            'debit_nota',
            'data_account',
            'data_bagian',
            'data_jenisbiaya',
            'data_cj',
            'no_bayar_details',
            'data_bayar_details',
            'count',
            'vendor'
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

    public function editDetail($dataid, $datano)
    {
        $nobayar=str_replace('-', '/', $dataid);
        $data = PermintaanBayarDetail::where('no', $datano)->where('no_bayar', $nobayar)->distinct()->get();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $nobayars=str_replace('-', '/', $request->id);
        PermintaanBayarHeader::where('no_bayar', $nobayars)->delete();
        PermintaanBayarDetail::where('no_bayar', $nobayars)->delete();
        return response()->json();
    }

    public function deleteDetail(Request $request)
    {
        PermintaanBayarDetail::where('no', $request->no)
        ->where('no_bayar', $request->id)
        ->delete();
        return response()->json();
    }


    public function approv($id)
    {
        $nobayar=str_replace('-', '/', $id);
        $data_app = PermintaanBayarHeader::where('no_bayar', $nobayar)->select('*')->get();
        return view('modul-umum.permintaan-bayar.approv', compact('data_app'));
    }

    //surat permintaan bayar
    public function rekap($id)
    {
        $nobayar=str_replace('-', '/', $id);
        $data_cekjb = DB::select("SELECT a.no_bayar,(select sum(nilai) from umu_bayar_detail where no_bayar=a.no_bayar) as total from umu_bayar_header a where a.no_bayar='$nobayar'");
        foreach ($data_cekjb as $data_cek) {
            $data_c = $data_cek->total;
        }
        if ($data_c > 10000000) {
            $setuju = "-";
            $setujus = "DIREKTUR KEU & INV";
            $pemohon = "ALI SYAMSUL ROHMAN";
            $pemohons = "CS & BS";
        } else {
            $setuju = "ALI SYAMSUL ROHMAN";
            $setujus = "CS & BS";
            $pemohon = "ANGGRAINI GITTA LESTARI";
            $pemohons = "IA & RM";
        }
        $data_report = PermintaanBayarHeader::where('no_bayar', $nobayar)->select('*')->get();
        return view('modul-umum.permintaan-bayar.rekap', compact(
            'data_report',
            'setuju',
            'setujus',
            'pemohon',
            'pemohons'
        ));
    }


    //rekap permintaan bayar
    public function rekapRange()
    {
        return view('modul-umum.permintaan-bayar.rekap-range');
    }

    public function rekapExport(Request $request)
    {
        $nobayar=$request->nobayar;
        PermintaanBayarHeader::where('no_bayar', $nobayar)
            ->update([
            'pemohon' => $request->pemohon,
            'menyetujui' => $request->menyetujui,
            ]);
        $bayar_header_list = PermintaanBayarHeader::where('no_bayar', $nobayar)->get();
        foreach ($bayar_header_list as $data_report) {
            $data_report;
            $data_rek = DB::select("SELECT * from tbl_vendor where nama ='$data_report->kepada'");
        }
        $bayar_detail_list = PermintaanBayarDetail::where('no_bayar', $nobayar)->get();
        $list_acount =PermintaanBayarDetail::where('no_bayar', $nobayar)->select('nilai')->sum('nilai');
        $pdf = DomPDF::loadview('modul-umum.permintaan-bayar.export', compact('list_acount', 'data_report', 'bayar_detail_list', 'request', 'data_rek'))->setPaper('a4', 'Portrait');
        // return $pdf->download('rekap_permint_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }
    public function rekapExportRange(Request $request)
    {
        $data_cek = PermintaanBayarHeader::whereBetween('tgl_bayar', [$request->mulai, $request->sampai]) ->count();
        if ($data_cek == 0) {
            Alert::error('Tidak Ada Data Pada Tanggal Mulai: '.$request->mulai.' Sampai Tanggal: '.$request->sampai.'', 'Failed')->persistent(true);
            return redirect()->route('permintaan_bayar.rekap.range');
        } else {
            if ($request->submit == 'pdf') {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln	 = array(
                    1 =>   'Januari',
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
                
                $bulan= strtoupper($array_bln[ (int)$pecahkan[1] ]);
                $tahun=$pecahkan[0];
                $bayar_header_list = \DB::table('umu_bayar_header AS a')
                ->select(\DB::raw('a.*, (SELECT sum(b.nilai)  FROM umu_bayar_detail as b WHERE b.no_bayar=a.no_bayar) AS nilai'))
                ->whereBetween('tgl_bayar', [$mulai, $sampai])
                ->get();
                $bayar_header_list_total =PermintaanBayarHeader::select(\DB::raw('SUM(umu_bayar_detail.nilai) as nilai'))
                ->Join('umu_bayar_detail', 'umu_bayar_detail.no_bayar', '=', 'umu_bayar_header.no_bayar')
                ->whereBetween('umu_bayar_header.tgl_bayar', [$mulai, $sampai])
                ->get();
                $pdf = DomPDF::loadview('modul-umum.permintaan-bayar.exportrange', compact('bayar_header_list_total', 'bayar_header_list', 'bulan', 'tahun'))->setPaper('a4', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(700, 120, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
                // return $pdf->download('rekap_permint_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream('my.pdf', array('Attachment'=>true));
            } elseif ($request->submit == 'xlsx') {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln	 = array(
                    1 =>   'Januari',
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
                
                $bulan= strtoupper($array_bln[ (int)$pecahkan[1] ]);
                $tahun=$pecahkan[0];
                $bayar_header_list = \DB::table('umu_bayar_header AS a')
                ->select(\DB::raw('a.*, (SELECT sum(b.nilai)  FROM umu_bayar_detail as b WHERE b.no_bayar=a.no_bayar) AS nilai'))
                ->whereBetween('tgl_bayar', [$mulai, $sampai])
                ->get();
                $bayar_header_list_total =PermintaanBayarHeader::select(\DB::raw('SUM(umu_bayar_detail.nilai) as nilai'))
                ->Join('umu_bayar_detail', 'umu_bayar_detail.no_bayar', '=', 'umu_bayar_header.no_bayar')
                ->whereBetween('umu_bayar_header.tgl_bayar', [$mulai, $sampai])
                ->get();
                $excel=new Spreadsheet;
                return view('modul-umum.permintaan-bayar.exportexcel', compact('bayar_header_list_total', 'bayar_header_list', 'bulan', 'tahun', 'excel'));
            } else {
                $mulai = date($request->mulai);
                $sampai = date($request->sampai);
                $pecahkan = explode('-', $request->mulai);
                $array_bln	 = array(
                    1 =>   'Januari',
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
                
                $bulan= strtoupper($array_bln[ (int)$pecahkan[1] ]);
                $tahun=$pecahkan[0];
                $bayar_header_list = \DB::table('umu_bayar_header AS a')
                ->select(\DB::raw('a.*, (SELECT sum(b.nilai)  FROM umu_bayar_detail as b WHERE b.no_bayar=a.no_bayar) AS nilai'))
                ->whereBetween('tgl_bayar', [$mulai, $sampai])
                ->get();
                $bayar_header_list_total =PermintaanBayarHeader::select(\DB::raw('SUM(umu_bayar_detail.nilai) as nilai'))
                ->Join('umu_bayar_detail', 'umu_bayar_detail.no_bayar', '=', 'umu_bayar_header.no_bayar')
                ->whereBetween('umu_bayar_header.tgl_bayar', [$mulai, $sampai])
                ->get();
                $excel=new Spreadsheet;
                return view('modul-umum.permintaan-bayar.exportcsv', compact('bayar_header_list_total', 'bayar_header_list', 'bulan', 'tahun', 'excel'));
            }
        }
    }
}
