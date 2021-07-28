<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\ViewCashFlowPerCJReport;
use App\Models\ViewD2KasBank;
use App\Models\ViewReportCashFlow;
use App\Models\VKas;
use DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class KasCashJudexController extends Controller
{
    public function create1()
    {
        $data_tahun = DB::select("select max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("select kodelokasi,nama from mdms");
        $data_sanper = DB::select("select kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%' order by kodeacct desc");
        return view('modul-treasury.kas-bank.report1', compact('data_kodelok', 'data_sanper', 'data_tahun'));
    }

    public function searchAccount(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_account = DB::select("select kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%' and (kodeacct like '$cari%' or descacct like '$cari%') order by kodeacct desc");
            return response()->json($data_account);
        }
    }

    public function cetak1(Request $request)
    {
        if ($request->status == "1") {
            $xxx = ['10', '11', '13'];
        } elseif ($request->status == "2") {
            $xxx = ['15', '18'];
        } else {
            $xxx = ['10', '11', '13', '15', '18'];
        }

        $yyy = "$request->tahun";
        if ($request->bulan <> "") {
            $sss = [$request->bulan];
        } else {
            $sss = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        }

        if ($request->sanper == "") {
            $data_list = ViewD2KasBank::where('tahun', $yyy)->whereIn('bulan', $sss)->whereIn('jk', $xxx)->orderBy('account', 'asc')->get();
        } else {
            $ddd = "$request->sanper";
            $data_list = ViewD2KasBank::where('tahun', $yyy)->whereIn('bulan', $sss)->where('account', $ddd)->whereIn('jk', $xxx)->orderBy('account', 'asc')->get();
        }

        if ($request->bulan <> "") {
            $export_d2_kas_bank = 'export_d2_kas_bank_bulan_pdf';
            $export_d2_kas_bank_header = 'export_d2_kas_bank_bulan_pdf_header';
        } else {
            $export_d2_kas_bank = 'export_d2_kas_bank_tahun_pdf';
            $export_d2_kas_bank_header = 'export_d2_kas_bank_tahun_pdf_header';
        }

        if ($data_list->count() > 0) {
            foreach ($data_list as $data) {
                $bulan = $data->bulan;
                $tahun = $data->tahun;
            }
            
            $pdf = PDF::loadview("modul-treasury.kas-bank.$export_d2_kas_bank", compact(
                'data_list',
                'tahun'
            ))
                ->setPaper('a4', 'landscape')
                ->setOption('footer-right', 'Halaman [page] dari [toPage]')
                ->setOption('footer-font-size', 7)
                ->setOption('header-html', view("modul-treasury.kas-bank.$export_d2_kas_bank_header", compact('bulan', 'tahun')))
                ->setOption('margin-top', 30)
                ->setOption('margin-bottom', 10);

            return $pdf->stream('rekap_d2_kas_bank_' . date('Y-m-d H:i:s') . '.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari", 'Failed')->persistent(true);
            return redirect()->route('modul-treasury.kas-bank.create1');
        }
    }

    public function create2()
    {
        $data_tahun = DB::select("select max(tahun||bulan) as thnbln from fiosd201");
        return view('modul-treasury.kas-bank.report2', compact('data_tahun'));
    }

    public function cetak2(Request $request)
    {
        $data_list = DB::select("select a.docno ,a.voucher ,a.rekapdate ,substring(a.thnbln from 1  for 4 ) as tahun,substring(a.thnbln  from 5  for 2 ) as bulan,b.lineno ,b.keterangan ,a.jk ,a.store ,a.ci ,a.rate ,a.voucher ,b.account ,coalesce(b.totprice,1)*CASE WHEN a.rate=0 THEN 1 WHEN a.rate IS NULL THEN 1  ELSE a.rate END as totprice ,b.area,b.lokasi ,b.bagian ,b.jb ,b.pk ,b.cj,a.rekap from kasdoc a join kasline b on a.docno=b.docno where  a.thnbln='202001' AND (coalesce(a.paid,'N') = 'Y' ) and coalesce(b.penutup,'N')<>'Y'");
        if (!empty($data_list)) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_report2', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create2');
        }
    }

    public function create3()
    {
        $data_tahun = DB::select("Select max(tahun||bulan) as thnbln from fiosd201");
        return view('modul-treasury.kas-bank.report3', compact('data_tahun'));
    }

    public function cetak3(Request $request)
    {
        $data_list = DB::select("select a.* from vkas a join kasdoc b on a.docno=b.docno where a.tahun='$request->tahun' and bulan='$request->bulan'");
        if (!empty($data_list)) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_report3',compact('request', 'data_list'))
                ->setPaper('a4', 'portrait')
                ->setOption('footer-right', 'Halaman [page] dari [toPage]')
                ->setOption('footer-font-size', 10)
                ->setOption('header-html', view('modul-treasury.kas-bank.export_report3_pdf_header',compact('request')))
                ->setOption('margin-top', 30)
                ->setOption('margin-left', 5)
                ->setOption('margin-right', 5)
                ->setOption('margin-bottom', 10);

            return $pdf->stream('Rincian Kas Bank Per Cash Judex_'.date('Y-m-d H:i:s').'.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create3');
        }
    }


    public function create4()
    {
        $data_judex = DB::select("select kode,nama from cashjudex");
        return view('modul-treasury.kas-bank.report4', compact('data_judex'));
    }

    public function cetak4(Request $request)
    {
        $thnbln = $request->tahun . '' . $request->bulan;
        $data_list = DB::select("select a.docno ,a.voucher ,a.rekapdate ,substring(a.thnbln from 1  for 4 ) as tahun,substring(a.thnbln  from 5  for 2 ) as bulan,b.lineno ,b.keterangan ,a.jk ,a.store ,a.ci ,a.rate ,a.voucher ,b.account ,coalesce(b.totprice,1)*CASE WHEN a.rate=0 THEN 1 WHEN a.rate IS NULL THEN 1  ELSE a.rate END as totprice ,b.area,b.lokasi ,b.bagian ,b.jb ,b.pk ,b.cj,a.rekap from kasdoc a join kasline b on a.docno=b.docno where  a.thnbln='$thnbln' and b.cj='$request->cj' AND (coalesce(a.paid,'N') = 'Y' ) and coalesce(b.penutup,'N')<>'Y'");
        if (!empty($data_list)) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_report4', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data yang di cari", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create4');
        }
    }


    public function create5()
    {
        $data_judex = DB::select("select kode,nama from cashjudex");
        return view('modul-treasury.kas-bank.report5', compact('data_judex'));
    }

    public function cetak5(Request $request)
    {

        $data_list = VKas::where('cj', $request->cj)->where('tahun', $request->tahun)->where('bulan', $request->bulan)->get();
        if ($data_list->count() > 0) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_report5', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create5');
        }
    }

    public function create6()
    {
        $data_judex = DB::select("select kode,nama from cashjudex");
        return view('modul-treasury.kas-bank.report6', compact('data_judex'));
    }

    public function cetak6(Request $request)
    {
        $data_list = Vkas::where('cj', $request->cj)->where('tahun', $request->tahun)->where('bulan', $request->bulan)->get();
        if ($data_list->count() > 0) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_report6', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create6');
        }
    }

    // Report Cash Flow Internal
    public function create7()
    {
        return view('modul-treasury.kas-bank.report7');
    }

    public function cetak7(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $kurs = $request->kurs;

        $data_list = ViewReportCashFlow::select(
            DB::raw('
                SUBSTR(cj_code, 1, 1) AS cj_code_1,
                SUBSTR(cj_code, 1, 2) AS cj_code_2,
                tahun,
                class,
                ket_clas,
                cj_code,
                cj_level,
                bulan,
                nilai_lalu,
                nilai_lalu_dl,
                nilai_lalu_dl_rp,
                saldo_awal_lalu,
                saldo_awal_lalu_dl,
                saldo_awal_lalu_dl_rp,
                saldo_awal,
                saldo_awal_dl,
                saldo_awal_dl_rp,
                nilai,
                nilai_dl,
                nilai_dl_rp,
                saldo_akhir,
                saldo_akhir_dl,
                saldo_akhir_dl_rp,
                nilai_kurs,
                saldo_awal_kurs,
                saldo_akhir_kurs,
                keterangan
            ')
        )
            ->when(request('bulan'), function ($query) {
                return $query->where('bulan', request('bulan'));
            })
            ->when(request('tahun'), function ($query) {
                return $query->where('tahun', request('tahun'));
            })
            ->get();


        // dd($data_list);
        $arus_kas_aktivitas_koperasi = null;
        $arus_kas_aktivitas_koperasi_penerimaan = null;
        $arus_kas_aktivitas_koperasi_pengeluaran = null;

        $arus_kas_aktivitas_investasi = null;
        $arus_kas_aktivitas_investasi_penerimaan = null;
        $arus_kas_aktivitas_investasi_pengeluaran = null;

        $arus_kas_aktivitas_pendanaan = null;
        $arus_kas_aktivitas_pendanaan_penerimaan = null;
        $arus_kas_aktivitas_pendanaan_pengeluaran = null;

        // A. ARUS KAS DARI AKTIVITAS OPERASI START
        if (count(array_intersect(['1', '2', '3', '4', '5', '6'], array_column($data_list->toArray(), 'cj_code_1'))) > 0 || count(array_intersect(['74', '75', '93'], array_column($data_list->toArray(), 'cj_code_2'))) > 0) {
            $arus_kas_aktivitas_koperasi = $data_list->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_1, ['1', '2', '3', '4', '5', '6'])
                    ||
                    in_array($value->cj_code_2, ['74', '75', '93']);
            });
            // collect penerimaan
            $arus_kas_aktivitas_operasi_penerimaan = $arus_kas_aktivitas_koperasi->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_1, ['1', '3', '4']);
            });

            $arus_kas_aktivitas_koperasi_penerimaan = $arus_kas_aktivitas_operasi_penerimaan->all();

            // collect pengeluaran
            $arus_kas_aktivitas_koperasi_pengeluaran = $arus_kas_aktivitas_koperasi->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_1, ['2', '5', '6'])
                    ||
                    in_array($value->cj_code_2, ['74', '75', '93']);
            });

            $arus_kas_aktivitas_koperasi_pengeluaran = $arus_kas_aktivitas_koperasi_pengeluaran->all();
        }

        // B. ARUS KAS DARI AKTIVITAS INVESTASI START
        if (count(array_intersect(['9'], array_column($data_list->toArray(), 'cj_code_1'))) > 0) {
            $arus_kas_aktivitas_investasi = $data_list->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_1, ['9']);
            });

            // collect penerimaan
            $arus_kas_aktivitas_investasi_penerimaan = $arus_kas_aktivitas_investasi->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_2, ['90']);
            });

            $arus_kas_aktivitas_investasi_penerimaan = $arus_kas_aktivitas_investasi_penerimaan->all();

            // collect pengeluaran
            $arus_kas_aktivitas_investasi_pengeluaran = $arus_kas_aktivitas_investasi->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_2, ['91']);
            });

            $arus_kas_aktivitas_investasi_pengeluaran = $arus_kas_aktivitas_investasi_pengeluaran->all();
        }

        // C. ARUS KAS DARI AKTIVITAS PENDANAAN
        if (count(array_intersect(['7', '8'], array_column($data_list->toArray(), 'cj_code_1'))) > 0) {
            $arus_kas_aktivitas_pendanaan = $data_list->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_1, ['7', '8']);
            });

            // collect penerimaan
            $arus_kas_aktivitas_pendanaan_penerimaan = $arus_kas_aktivitas_pendanaan->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_2, ['70']);
            });

            $arus_kas_aktivitas_pendanaan_penerimaan = $arus_kas_aktivitas_pendanaan_penerimaan->all();

            // collect pengeluaran
            $arus_kas_aktivitas_pendanaan_pengeluaran = $arus_kas_aktivitas_pendanaan->filter(function ($value, $key) {
                return
                    in_array($value->cj_code_2, ['71', '72', '79']);
            });

            $arus_kas_aktivitas_pendanaan_pengeluaran = $arus_kas_aktivitas_pendanaan_pengeluaran->all();
        }

        // return default PDF
        $pdf = PDF::loadview('modul-treasury.kas-bank.export_report7', compact(
            'data_list',
            'tahun',
            'bulan',
            'arus_kas_aktivitas_koperasi',
            'arus_kas_aktivitas_koperasi_penerimaan',
            'arus_kas_aktivitas_koperasi_pengeluaran',
            'arus_kas_aktivitas_investasi',
            'arus_kas_aktivitas_investasi_penerimaan',
            'arus_kas_aktivitas_investasi_pengeluaran',
            'arus_kas_aktivitas_pendanaan',
            'arus_kas_aktivitas_pendanaan_penerimaan',
            'arus_kas_aktivitas_pendanaan_pengeluaran'
        ))
            ->setPaper('a4', 'Portrait')
            ->setOptions(['isPhpEnabled' => true]);

        return $pdf->stream('laporan_arus_kas_internal_' . date('Y-m-d H:i:s') . '.pdf');
    }

    // Report Cash Flow Per Periode
    public function create8()
    {
        return view('modul-treasury.kas-bank.report8');
    }


    public function cetak8(Request $request)
    {
        $tahun = $request->tahun;
        $kurs = $request->kurs;
        $mulai = $request->mulai;
        $sampai = $request->sampai;

        $data_list = null;

        $pdf = PDF::loadview('modul-treasury.kas-bank.export_report8', compact(
            'data_list',
            'tahun',
            'mulai',
            'sampai'
        ))
            ->setPaper('a4', 'Portrait');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->getCanvas();
        $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->stream();
    }

    public function create9()
    {
        return view('modul-treasury.kas-bank.report9');
    }


    public function cetak9(Request $request)
    {
        $data_list = ViewCashFlowPerCJReport::select('*')->where('tahun', $request->tahun)->where('bulan', $request->bulan)->orderBy('status', 'asc')->get();
        $data_total = DB::select("select
        SUM((case when status = 1 then nilai end)) - SUM((case when status = 2 then nilai end)) AS status_1,
        SUM((case when status = 1 then totreal end)) - SUM((case when status = 2 then totreal end)) AS totreal_1
        from v_cashflowpercjreport where tahun='$request->tahun' and bulan='$request->bulan'");
        if ($data_list->count() > 0) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_proyeksi_cashflow_pajak_pdf', compact('data_list', 'data_total', 'request'))
                ->setPaper('A4', 'portrait')
                ->setOption('footer-right', 'Halaman [page] dari [toPage]')
                ->setOption('footer-font-size', 7)
                ->setOption('margin-top', 10)
                ->setOption('margin-bottom', 10);

            return $pdf->stream('Cetak Proyeksi Cashflow_' . date('Y-m-d H:i:s') . '.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create9');
        }
    }

    public function create10()
    {
        $data_judex = DB::select("select kode,nama from cashjudex");
        return view('modul-treasury.kas-bank.report10', compact('data_judex'));
    }

    public function searchCj(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_cj = DB::select("select kode,nama from cashjudex where kode like '$cari%' or nama like '$cari%' order by kode");
            return response()->json($data_cj);
        }
    }

    public function cetak10(Request $request)
    {
        $cjudex = $request->cjudex;
        $tanggal = $request->tanggal;
        $tanggal2 = $request->tanggal2;
        $tgl_1 = date_create($tanggal);
        $thn1 = date_format($tgl_1, 'Y');
        $bln1 = date_format($tgl_1, 'm');
        $tgl_2 = date_create($tanggal2);
        $thn2 = date_format($tgl_2, 'Y');
        $bln2 = date_format($tgl_2, 'm');
        $thnbln1 = $thn1 . '' . $bln1;
        $thnbln2 = $thn2 . '' . $bln2;
        if ($request->cjudex <> "") {
            $yyy = "thnbln >= '$thnbln1' and thnbln <= '$thnbln2' and cj ='$cjudex'";
        } else {
            $yyy = "thnbln >= '$thnbln1' and thnbln <= '$thnbln2'";
        }
        $data_list = DB::select("select * from v_repcashjudex where $yyy order by docno asc");
        if (!empty($data_list)) {
            $pdf = PDF::loadview('modul-treasury.kas-bank.export_cash_judex_pdf', compact('data_list', 'request'))
                ->setPaper('a4', 'portrait')
                ->setOption('footer-right', 'Halaman [page] dari [toPage]')
                ->setOption('footer-font-size', 10)
                ->setOption('header-html', view('modul-treasury.kas-bank.export_cash_judex_pdf_header',compact('request')))
                ->setOption('margin-top', 30)
                ->setOption('margin-left', 5)
                ->setOption('margin-right', 5)
                ->setOption('margin-bottom', 10);

            return $pdf->stream('Report Cash Judex Periode_' . date('Y-m-d H:i:s') . '.pdf');
        } else {
            Alert::info("Tidak ditemukan data yang di cari ", 'Failed')->persistent(true);
            return redirect()->route('kas_bank.create9');
        }
    }
}
