<?php

namespace App\Http\Controllers\Kontroler;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\ViewClassAccount;
use App\Models\ViewReportD5;
use DB;
use DomPDF;
use Illuminate\Http\Request;
use PDF;

class ReportKontrolerController extends Controller
{
    // select tahun, bulan, supbln suplesi, jk, store lokasi, vc voucher, ci mu, lokasi lapangan, account sandi, bagian, wono pk, jb, cj kk, (case when -sign(totpricerp)='1' then '0' else totpricerp end) debet_rp, (case when sign(totpricerp)='-1' then totpricerp else '0' end) kredit_rp, (case when -sign(totpricedl)='1' then '0' else totpricedl end) debet_dl, (case when sign(totpricedl)='-1' then totpricedl else '0' end) kredit_dl, rate kurs, rate_trans kurs_trans, rate_pajak kurs_pajak, totprice, totpricerp, totpricedl, keterangan from fiosd201 order by tahun||bulan||supbln, account, jk||store, vc, ci, sign(totprice);

    public function create_d2_perbulan()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from 
                                    account where length(kodeacct)=6 
                                    and kodeacct not like '%X%' 
                                    order by kodeacct desc");
        return view('modul-kontroler.report-kontroler.d2-perbulan', compact('data_tahun', 'data_kodelok', 'data_sanper'));
    }

    public function searchAccount(Request $request)
    {
        if ($request->has('q')) {
            $cari = strtoupper($request->q);
            $data_account = DB::select("SELECT kodeacct,descacct from 
                                        account where length(kodeacct)=6 
                                        and kodeacct not like '%x%' and 
                                        (kodeacct like '$cari%' or descacct 
                                        like '$cari%') order by kodeacct desc");
            return response()->json($data_account);
        }
    }

    public function Cetak1(Request $request)
    {
        $thnbln = $request->tahun.''.$request->bulan;
        if ($request->jk == "1") {
            $jk = "in ('10','11','13')";
        } elseif ($request->jk == "2") {
            $jk = "in ('15','18')";
        } else {
            $jk = "in ('10','11','13','15','18')";
        }

        $tahun = $request->tahun;
        if ($request->bulan <> "") {
            $bulan ="in ('$request->bulan')";
        } else {
            $bulan ="in ('01','02','03','04','05','06','07','08','09','10','11','12')";
        }

        if ($request->sanper == "") {
            $data_list = DB::select("SELECT b.docno,substring(b.thnbln from 1 for 4) as tahun,substring(b.thnbln from 5 for 2) as bulan,b.jk,b.store,b.voucher,b.ci,b.paiddate as tglbayar,b.rate,a.lineno,a.account,a.lokasi,a.bagian,a.cj,round(a.totprice,2) as totprice,a.keterangan 
                                        from kasline a join kasdoc b on b.docno=a.docno 
                                        where b.jk $jk and substring(b.thnbln from 1 for 4)='$tahun' and substring(b.thnbln from 5 for 2) $bulan and a.keterangan <> 'penutup'");
        } else {
            $sanper = "like '$request->sanper'";
            $data_list = DB::select("SELECT b.docno,substring(b.thnbln from 1 for 4) as tahun,substring(b.thnbln from 5 for 2) as bulan,b.jk,b.store,b.voucher,b.ci,b.paiddate as tglbayar,b.rate,a.lineno,a.account,a.lokasi,a.bagian,a.cj,round(a.totprice,2) as totprice,a.keterangan 
                                        from kasline a join kasdoc b on b.docno=a.docno 
                                        where b.jk $jk and substring(b.thnbln from 1 for 4)='$tahun' and substring(b.thnbln from 5 for 2) $bulan and a.account $sanper and a.keterangan <> 'penutup'");
        }

        // dd($data_list);
        if (!empty($data_list)) {
            // return view('modul-kontroler.report-kontroler.export_report1',compact('request','data_list'));
            $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.export_report1', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.report_kontroler.create1');
        }
    }

    public function create_d2_periode()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        return view('modul-kontroler.report-kontroler.d2-periode', compact('data_tahun', 'data_kodelok', 'data_sanper'));
    }

    public function create_d5_report()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        return view('modul-kontroler.report-kontroler.d5-report', compact('data_tahun', 'data_kodelok', 'data_sanper'));
    }

    public function exportD5(Request $request)
    {
        $tahun = "$request->tahun";
        $bulan = "$request->bulan";
        $suplesi = "$request->suplesi";
        $thnbln = "2019$request->bulan$request->suplesi";
        $obpsi  = "obpsi_$request->tahun";
        
        $data_cek = DB::select("SELECT a.tablename as vada from pg_tables a where a.tablename = '$obpsi' ");
        if (!empty($data_cek)) {
            DB::statement("DROP VIEW IF EXISTS v_report_d5 CASCADE");
            DB::statement("CREATE OR REPLACE VIEW v_report_d5 AS
                                select tahun, bulan, suplesi, ci mu, jb, account sandi, lokasi lapangan, coalesce(awalrp,0) last_rp, coalesce(awaldl,0) last_dl, pricerp cur_rp, pricedl cur_dl, totpricerp cum_rp, totpricedl cum_dl from $obpsi union all 
                                select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, sum(coalesce(totprice,0)) cur_dl, sum(coalesce(totpricerp,0)) cum_rp, sum(coalesce(totpricedl,0)) cum_dl from fiosd201 where ci='2' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi union all 
                                select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, 0 cur_dl, sum(coalesce(totpricerp,0)) cum_rp, 0 cum_dl from fiosd201 where ci='1' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi
                        ");
            DB::statement("CREATE VIEW v_neraca AS
                        select tahun,bulan,suplesi,mu,jb,sandi,lapangan,last_rp,last_dl,cur_rp,cur_dl,cum_rp,cum_dl, m.* from v_report_d5 d, v_main_account m where substr(d.sandi,1,length(m.batas_awal)) between m.batas_awal and m.batas_akhir and strpos(m.lokasi,d.lapangan)>0
                        ");
            if ($request->sandi <> "") {
                $yyy = "$request->sandi";
                $data_list = ViewReportD5::where('sandi', $yyy)->orderBy('sandi', 'asc')->get();
            } else {
                $data_list = ViewReportD5::orderBy('sandi', 'asc')->get();
            }
            if ($data_list->count() > 0) {
                foreach ($data_list as $data_bln) {
                    $bulan = $data_bln->bulan;
                    $tahun = $data_bln->tahun;
                    $suplesi = $data_bln->suplesi;
                }
                $pdf = PDF::loadview('modul-kontroler.report-kontroler.export-d5-pdf', compact('data_list'))
                ->setPaper('a4', 'landscape')
                ->setOption('footer-right', 'Halaman [page] dari [toPage]')
                ->setOption('footer-font-size', 8)
                ->setOption('header-html', view('modul-kontroler.report-kontroler.export-d5-pdf-header', compact('bulan', 'tahun', 'suplesi')))
                ->setOption('margin-top', 30)
                ->setOption('margin-bottom', 10);

                return $pdf->stream('rekap-d5-'.date('Y-m-d H:i:s').'.pdf');
            } else {
                Alert::info("Tidak ditemukan data yang di cari", 'Failed')->persistent(true);
                return redirect()->route('modul_kontroler.d5_report.create_d5_report');
            }
        } else {
            Alert::info("Tidak ditemukan data yang di cari", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.d5_report.create_d5_report');
        }
    }

    public function create_neraca_konsolidasi()
    {
        $data_tahun = DB::table('fiosd201')
                        ->select(DB::raw('max(tahun||bulan||supbln) AS sbulan'))
                        ->first();
                        
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");

        $tahun = substr($data_tahun->sbulan, 0, 4);
        $bulan = substr($data_tahun->sbulan, 4, 2);
        $suplesi = substr($data_tahun->sbulan, 6);

        return view('modul-kontroler.report-kontroler.neraca-konsolidasi', compact(
            'tahun',
            'bulan',
            'suplesi',
            'data_kodelok',
        ));
    }
    public function exportNeracaKonsolidasi(Request $request)
    {
        $tahun = "$request->tahun";
        $bulan = "$request->bulan";
        $suplesi = "$request->suplesi";
        $thnbln = "2019$request->bulan$request->suplesi";
        $obpsi  = "obpsi_$request->tahun";
        
        $data_cek = DB::select("SELECT a.tablename as vada from pg_tables a where a.tablename = '$obpsi' ");
        if (!empty($data_cek)) {
            DB::statement("DROP VIEW IF EXISTS v_report_d5 CASCADE");
            DB::statement("CREATE OR REPLACE VIEW v_report_d5 AS
                            select tahun, bulan, suplesi, ci mu, jb, account sandi, lokasi lapangan, coalesce(awalrp,0) last_rp, coalesce(awaldl,0) last_dl, pricerp cur_rp, pricedl cur_dl, totpricerp cum_rp, totpricedl cum_dl from $obpsi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, sum(coalesce(totprice,0)) cur_dl, sum(coalesce(totpricerp,0)) cum_rp, sum(coalesce(totpricedl,0)) cum_dl from fiosd201 where ci='2' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, 0 cur_dl, sum(coalesce(totpricerp,0)) cum_rp, 0 cum_dl from fiosd201 where ci='1' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi
                            ");
            DB::statement("CREATE VIEW v_neraca AS
                            select tahun,bulan,suplesi,mu,jb,sandi,lapangan,last_rp,last_dl,cur_rp,cur_dl,cum_rp,cum_dl, m.* from v_report_d5 d, v_main_account m where substr(d.sandi,1,length(m.batas_awal)) between m.batas_awal and m.batas_akhir and strpos(m.lokasi,d.lapangan)>0
                            ");
            $data_list = DB::select("
                    select a.jenis,a.sub_akun,
                    sum(CASE WHEN a.lapangan ='MD' THEN c.pengali_tampil*a.cum_rp ELSE '0' END) as mmd,
                    sum(CASE WHEN a.lapangan ='MS' THEN c.pengali_tampil*a.cum_rp ELSE '0' END) as mms,
                    sum(c.pengali_tampil*a.cum_rp) as kons
                    from v_neraca a join v_sub_class_account b on a.urutan_sc=b.urutan join v_class_account c on b.urutan_cs=c.urutan_sc  group by a.jenis, a.sub_akun order by a.sub_akun asc
                    ");
            // dd($data_list);
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.neraca-konsolidasi', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(485, 120, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_kontroler.neraca_konsolidasi.create_neraca_konsolidasi');
            }
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.neraca_konsolidasi.create_neraca_konsolidasi');
        }
    }
    
    
    public function create_neraca_detail()
    {
        $data_tahun = DB::table('bulansuplesi')
                        ->where('kodereport', '=', 'D5')
                        ->select(['tahun', 'bulan', 'suplesi'])
                        ->first();

        $tahun = $data_tahun->tahun;
        $bulan = $data_tahun->bulan;
        $suplesi = $data_tahun->suplesi;

        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        return view('modul-kontroler.report-kontroler.neraca-detail', compact(
            'tahun',
            'bulan',
            'suplesi',
            'data_kodelok',
        ));
    }
    public function exportNeracaDetail(Request $request)
    {
        $tahun = "$request->tahun";
        $bulan = "$request->bulan";
        $suplesi = "$request->suplesi";
        $thnbln = "2019$request->bulan$request->suplesi";
        $obpsi  = "obpsi_$request->tahun";
    
        $data_cek = DB::select("SELECT a.tablename as vada from pg_tables a where a.tablename = '$obpsi' ");
        if (!empty($data_cek)) {
            DB::statement("DROP VIEW IF EXISTS v_report_d5 CASCADE");
            DB::statement("CREATE OR REPLACE VIEW v_report_d5 AS
                            select tahun, bulan, suplesi, ci mu, jb, account sandi, lokasi lapangan, coalesce(awalrp,0) last_rp, coalesce(awaldl,0) last_dl, pricerp cur_rp, pricedl cur_dl, totpricerp cum_rp, totpricedl cum_dl from $obpsi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, sum(coalesce(totprice,0)) cur_dl, sum(coalesce(totpricerp,0)) cum_rp, sum(coalesce(totpricedl,0)) cum_dl from fiosd201 where ci='2' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, 0 cur_dl, sum(coalesce(totpricerp,0)) cum_rp, 0 cum_dl from fiosd201 where ci='1' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi
                            ");
            DB::statement("CREATE VIEW v_neraca AS
                            select tahun,bulan,suplesi,mu,jb,sandi,lapangan,last_rp,last_dl,cur_rp,cur_dl,cum_rp,cum_dl, m.* from v_report_d5 d, v_main_account m where substr(d.sandi,1,length(m.batas_awal)) between m.batas_awal and m.batas_akhir and strpos(m.lokasi,d.lapangan)>0
                            ");
            $data_list = DB::select("
                select a.jenis,a.sub_akun,
                sum(c.pengali_tampil*a.last_rp) as mmd,
                sum(c.pengali_tampil*a.cur_rp) as mms,
                sum(c.pengali_tampil*a.cum_rp) as kons
                from v_neraca a join v_sub_class_account b on a.urutan_sc=b.urutan join v_class_account c on b.urutan_cs=c.urutan_sc group by a.jenis, a.sub_akun order by a.sub_akun asc
                ");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.neraca-detail-pdf', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(485, 120, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_kontroler.neraca_detail.create_neraca_detail');
            }
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.neraca_detail.create_neraca_detail');
        }
    }


    public function create_laba_rugi_konsolidasi()
    {
        $data_tahun = DB::table('fiosd201')
                        ->select(DB::raw('max(tahun||bulan||supbln) AS sbulan'))
                        ->first();
                        
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");

        $tahun = substr($data_tahun->sbulan, 0, 4);
        $bulan = substr($data_tahun->sbulan, 4, 2);
        $suplesi = substr($data_tahun->sbulan, 6);

        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        return view('modul-kontroler.report-kontroler.laba-rugi-konsolidasi', compact(
            'tahun',
            'bulan',
            'suplesi',
            'data_kodelok',
            'data_sanper'
        ));
    }
    public function exportLabaRugiKonsolidasi(Request $request)
    {
        $tahun = "$request->tahun";
        $bulan = "$request->bulan";
        $suplesi = "$request->suplesi";
        $thnbln = "2019$request->bulan$request->suplesi";
        $obpsi  = "obpsi_$request->tahun";
        
        $data_cek = DB::select("SELECT a.tablename as vada from pg_tables a where a.tablename = '$obpsi' ");
        if (!empty($data_cek)) {
            DB::statement("DROP VIEW IF EXISTS v_report_d5 CASCADE");
            DB::statement("CREATE OR REPLACE VIEW v_report_d5 AS
                            select tahun, bulan, suplesi, ci mu, jb, account sandi, lokasi lapangan, coalesce(awalrp,0) last_rp, coalesce(awaldl,0) last_dl, pricerp cur_rp, pricedl cur_dl, totpricerp cum_rp, totpricedl cum_dl from $obpsi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, sum(coalesce(totprice,0)) cur_dl, sum(coalesce(totpricerp,0)) cum_rp, sum(coalesce(totpricedl,0)) cum_dl from fiosd201 where ci='2' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, 0 cur_dl, sum(coalesce(totpricerp,0)) cum_rp, 0 cum_dl from fiosd201 where ci='1' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi
                            ");
            DB::statement("CREATE VIEW v_neraca AS
                            select tahun,bulan,suplesi,mu,jb,sandi,lapangan,last_rp,last_dl,cur_rp,cur_dl,cum_rp,cum_dl, m.* from v_report_d5 d, v_main_account m where substr(d.sandi,1,length(m.batas_awal)) between m.batas_awal and m.batas_akhir and strpos(m.lokasi,d.lapangan)>0
                            ");
            $data_list = DB::select("
                    select 
                    a.*, c.pengali_tampil as pengali_tmpl
                    from v_neraca a join v_sub_class_account b on a.urutan_sc=b.urutan join v_class_account c on b.urutan_cs=c.urutan_sc order by a.sub_akun asc
                    ");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.laba-rugi-konsolidasi-pdf', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
            
                $canvas = $dom_pdf->getCanvas();
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Bulan $request->bulan Tahun: $request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_kontroler.laba_rugi_konsolidasi.create_laba_rugi_konsolidasi');
            }
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan $request->bulan Tahun: $request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.laba_rugi_konsolidasi.create_laba_rugi_konsolidasi');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create_laba_rugi_detail()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        
        return view('modul-kontroler.report-kontroler.laba-rugi-detail', compact(
            'data_tahun',
            'data_kodelok',
            'data_sanper'
        ));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function labaRugiDetailExport(Request $request)
    {
        $tahun = "$request->tahun";
        $bulan = "$request->bulan";
        $suplesi = "$request->suplesi";
        $thnbln = "2019$request->bulan$request->suplesi";
        $obpsi  = "obpsi_$request->tahun";
        
        $data_cek = DB::select("SELECT a.tablename as vada from pg_tables a where a.tablename = '$obpsi' ");
        if (!empty($data_cek)) {
            DB::statement("DROP VIEW IF EXISTS v_report_d5 CASCADE");
            DB::statement("CREATE OR REPLACE VIEW v_report_d5 AS
                            select tahun, bulan, suplesi, ci mu, jb, account sandi, lokasi lapangan, coalesce(awalrp,0) last_rp, coalesce(awaldl,0) last_dl, pricerp cur_rp, pricedl cur_dl, totpricerp cum_rp, totpricedl cum_dl from $obpsi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, sum(coalesce(totprice,0)) cur_dl, sum(coalesce(totpricerp,0)) cum_rp, sum(coalesce(totpricedl,0)) cum_dl from fiosd201 where ci='2' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi union all 
                            select tahun, bulan, supbln suplesi, ci mu, jb, account sandi, lokasi lapangan, 0 last_rp, 0 last_dl, sum(coalesce(totpricerp,0)) cur_rp, 0 cur_dl, sum(coalesce(totpricerp,0)) cum_rp, 0 cum_dl from fiosd201 where ci='1' and tahun = '$tahun' and tahun||bulan||supbln <= '$thnbln' group by tahun, bulan, supbln, account, jb, ci,lokasi
                            ");
            DB::statement("CREATE VIEW v_neraca AS
                            select tahun,bulan,suplesi,mu,jb,sandi,lapangan,last_rp,last_dl,cur_rp,cur_dl,cum_rp,cum_dl, m.* from v_report_d5 d, v_main_account m where substr(d.sandi,1,length(m.batas_awal)) between m.batas_awal and m.batas_akhir and strpos(m.lokasi,d.lapangan)>0
                            ");
            $data_list = DB::select("
                    select 
                    a.*, c.pengali_tampil as pengali_tmpl
                    from v_neraca a join v_sub_class_account b on a.urutan_sc=b.urutan join v_class_account c on b.urutan_cs=c.urutan_sc order by a.sub_akun asc
                    ");
        
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.export_laba_rugi_detail', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
            
                $canvas = $dom_pdf->getCanvas();
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Bulan $request->bulan Tahun: $request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_kontroler.laba_rugi_detail.create_laba_rugi_detail');
            }
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan $request->bulan Tahun: $request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.laba_rugi_detail.create_laba_rugi_detail');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create_biaya_pegawai()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        
        return view('modul-kontroler.report-kontroler.biaya-pegawai-kantor', compact(
            'data_tahun',
            'data_kodelok',
            'data_sanper'
        ));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function exportBiayaPegawai(Request $request)
    {
        if ($request->lapangan == "KL") {
            $yyy = "tahun = '$request->tahun'";
            $sss = "bulan <= '$request->bulan2' and bulan >= '$request->bulan1'";
            $zzz = ("$yyy and $sss");
        } else {
            $bbb = "lapangan = '$request->lapangan'";
            $yyy = "tahun = '$request->tahun'";
            $sss = "bulan <= '$request->bulan2' and bulan >= '$request->bulan1'";
            $zzz = ("$bbb and $yyy and $sss");
        }

        $data_list = DB::select("SELECT *, substr(sandi,1,2) as duadigit,substr(sandi,1,3) as tigadigit from v_rincibiayakontroler where substr(sandi,1,3) between '500' and '519' and $zzz");
        
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.biaya-pegawai-kantor-pdf', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
        
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(485, 100, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan $request->bulan1 S/D $request->bulan2 Tahun: $request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_kontroler.biaya_pegawai.create_biaya_pegawai');
        }
    }


    public function d2PerBulanExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $d2_list =  DB::table('fiosd201')
        ->select(
            'tahun',
            'bulan',
            'supbln AS suplesi',
            'jk',
            'store AS lokasi',
            'vc AS voucher',
            'ci AS mu',
            'lokasi AS lapangan',
            'account AS sandi',
            'bagian',
            'wono AS pk',
            'jb',
            'cj AS kk',
            'rate AS kurs',
            'rate_trans AS kurs_trans',
            'rate_pajak AS kurs_pajak',
            'totprice',
            'totpricerp',
            'totpricedl',
            'keterangan'
        )
        ->when(request('bulan'), function ($query) {
            return $query->where('bulan', request('bulan'));
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->when(request('suplesi'), function ($query) {
            return $query->where('supbln', request('suplesi'));
        })
        
        ->when(request('jk') == 1, function ($query) {
            return $query->whereIn('jk', [10, 11, 13]);
        })
        ->when(request('jk') == 2, function ($query) {
            return $query->whereIn('jk', [15, 18]);
        })
        ->when(request('jk') == 3, function ($query) {
            return $query->whereIn('jk', [10, 11, 13, 15, 18]);
        })
        ->when(request('sanper'), function ($query) {
            return $query->where('account', request('sanper'));
        })
        ->orderBy('tahun', 'DESC')
        ->orderBy('bulan', 'DESC')
        ->orderBy('supbln', 'DESC')
        ->orderBy('account', 'DESC')
        ->orderBy('jk', 'DESC')
        ->orderBy('store', 'DESC')
        ->orderBy('vc', 'DESC')
        ->orderBy('ci', 'DESC')
        ->get();

        $d2_total = DB::table('fiosd201')
        ->select(
            DB::raw('SUM(round(totpricerp, 2)) AS saldo_rp'),
            DB::raw('SUM(round(totpricedl, 2)) AS saldo_dl'),
            DB::raw('SUM((case when totpricerp > 0 then round(totpricerp, 2) end)) AS total_debet_rp'),
            DB::raw('SUM((case when totpricerp < 0 then round(totpricerp, 2) end)) AS total_kredit_rp'),
            DB::raw('SUM((case when totpricedl > 0 then round(totpricedl, 2) end)) AS total_debet_dl'),
            DB::raw('SUM((case when totpricedl < 0 then round(totpricedl, 2) end)) AS total_kredit_dl')
        )
        ->when(request('bulan'), function ($query) {
            return $query->where('bulan', request('bulan'));
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->when(request('suplesi'), function ($query) {
            return $query->where('supbln', request('suplesi'));
        })
        ->when(request('jk') == 1, function ($query) {
            return $query->whereIn('jk', [10, 11, 13]);
        })
        ->when(request('jk') == 2, function ($query) {
            return $query->whereIn('jk', [15, 18]);
        })
        ->when(request('jk') == 3, function ($query) {
            return $query->whereIn('jk', [10, 11, 13, 15, 18]);
        })
        ->when(request('sanper'), function ($query) {
            return $query->where('account', request('sanper'));
        })
        ->first();

        $pdf = PDF::loadview('modul-kontroler.report-kontroler.export-d2-perbulan-pdf', compact(
            'd2_list',
            'd2_total',
            'tahun',
            'bulan'
        ))
        ->setPaper('a4', 'landscape')
        ->setOption('footer-right', 'Halaman [page] dari [toPage]')
        ->setOption('footer-font-size', 7)
        ->setOption('header-html', view('modul-kontroler.report-kontroler.export-d2-perbulan-pdf-header', compact('bulan', 'tahun')))
        ->setOption('margin-top', 30)
        ->setOption('margin-bottom', 10);

        return $pdf->stream('rekap-d2-perbulan-'.date('Y-m-d H:i:s').'.pdf');
    }

    public function d2PerPeriodeExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan_mulai = $request->bulan_mulai;
        $bulan_sampai = $request->bulan_sampai;

        $d2_list =  DB::table('fiosd201')
        ->select(
            'tahun',
            'bulan',
            'supbln AS suplesi',
            'jk',
            'store AS lokasi',
            'vc AS voucher',
            'ci AS mu',
            'lokasi AS lapangan',
            'account AS sandi',
            'bagian',
            'wono AS pk',
            'jb',
            'cj AS kk',
            'rate AS kurs',
            'rate_trans AS kurs_trans',
            'rate_pajak AS kurs_pajak',
            'totprice',
            'totpricerp',
            'totpricedl',
            'keterangan'
        )
        ->when(request('bulan_mulai'), function ($query) {
            return $query->whereBetween('bulan', [request('bulan_mulai'), request('bulan_sampai')]);
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->when(request('jk') == 1, function ($query) {
            return $query->whereIn('jk', [10, 11, 13]);
        })
        ->when(request('jk') == 2, function ($query) {
            return $query->whereIn('jk', [15, 18]);
        })
        ->when(request('jk') == 3, function ($query) {
            return $query->whereIn('jk', [10, 11, 13, 15, 18]);
        })
        ->when(request('sanper'), function ($query) {
            return $query->where('account', request('sanper'));
        })
        ->orderBy('tahun', 'DESC')
        ->orderBy('bulan', 'DESC')
        ->orderBy('supbln', 'DESC')
        ->orderBy('account', 'DESC')
        ->orderBy('jk', 'DESC')
        ->orderBy('store', 'DESC')
        ->orderBy('vc', 'DESC')
        ->orderBy('ci', 'DESC')
        ->get();

        $d2_total = DB::table('fiosd201')
        ->select(
            DB::raw('SUM(round(totpricerp, 2)) AS saldo_rp'),
            DB::raw('SUM(round(totpricedl, 2)) AS saldo_dl'),
            DB::raw('SUM((case when totpricerp > 0 then round(totpricerp, 2) end)) AS total_debet_rp'),
            DB::raw('SUM((case when totpricerp < 0 then round(totpricerp, 2) end)) AS total_kredit_rp'),
            DB::raw('SUM((case when totpricedl > 0 then round(totpricedl, 2) end)) AS total_debet_dl'),
            DB::raw('SUM((case when totpricedl < 0 then round(totpricedl, 2) end)) AS total_kredit_dl')
        )
        ->when(request('bulan_mulai'), function ($query) {
            return $query->whereBetween('bulan', [request('bulan_mulai'), request('bulan_sampai')]);
        })
        ->when(request('tahun'), function ($query) {
            return $query->where('tahun', request('tahun'));
        })
        ->when(request('jk') == 1, function ($query) {
            return $query->whereIn('jk', [10, 11, 13]);
        })
        ->when(request('jk') == 2, function ($query) {
            return $query->whereIn('jk', [15, 18]);
        })
        ->when(request('jk') == 3, function ($query) {
            return $query->whereIn('jk', [10, 11, 13, 15, 18]);
        })
        ->when(request('sanper'), function ($query) {
            return $query->where('account', request('sanper'));
        })
        ->first();

        $pdf = PDF::loadview('modul-kontroler.report-kontroler.export-d2-perperiode-pdf', compact(
            'd2_list',
            'd2_total',
            'tahun',
            'bulan_mulai',
            'bulan_sampai'
        ))
        ->setPaper('a4', 'landscape')
        ->setOption('footer-right', 'Halaman [page] dari [toPage]')
        ->setOption('footer-font-size', 7)
        ->setOption('header-html', view('modul-kontroler.report-kontroler.export-d2-perperiode-pdf-header', compact('tahun', 'bulan_mulai', 'bulan_sampai')))
        ->setOption('margin-top', 30)
        ->setOption('margin-bottom', 10);

        return $pdf->stream('rekap-d2-perperiode-'.date('Y-m-d H:i:s').'.pdf');
    }

    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function create_laporan_keuangan()
    {
        $data_tahun = DB::select("SELECT max(tahun||bulan||supbln) as sbulan from fiosd201");
        $data_kodelok = DB::select("SELECT kodelokasi,nama from mdms");
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct desc");
        
        return view('modul-kontroler.report-kontroler.catatan-laporan-keuangan', compact(
            'data_tahun',
            'data_kodelok',
            'data_sanper'
        ));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function laporanKeuanganExport(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $suplesi = $request->suplesi;

        $account_sc = ViewClassAccount::select('urutan_sc')
        ->with(['class_account' => function ($q) {
            $q->where(DB::raw('LENGTH(urutan)'), '=', 3);
            $q->orderBy('urutan_sc');
            $q->orderBy('urutan');
            $q->with(['class_account_by_sc' => function ($q_two) {
                $q_two->where(DB::raw('LENGTH(urutan)'), '>', 3);
                $q_two->orderBy('urutan_sc');
                $q_two->orderBy('urutan');
                $q_two->with(['neraca' => function ($q_three) {
                    $q_three->where('bulan', request('bulan'));
                    $q_three->where('tahun', request('tahun'));
                    $q_three->where('suplesi', request('suplesi'));
                    $q_three->orderBy('sandi');
                }]);
            }]);
        }])
        ->groupBy('urutan_sc')
        ->orderBy('urutan_sc') // default ASC
        ->get();

        // dd($account_sc);

        $pdf = DomPDF::loadview('modul-kontroler.report-kontroler.catatan-laporan-keuangan-pdf', compact(
            'account_sc',
            'tahun',
            'bulan'
        ))
        ->setPaper('a4', 'potrait')
        ->setOptions(['isPhpEnabled' => true]);

        return $pdf->stream('catatan_atas_laporan_keuangan_'.date('Y-m-d H:i:s').'.pdf');
    }
}
