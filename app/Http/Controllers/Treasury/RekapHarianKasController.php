<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\Kasdoc;
use App\Models\Kasline;
use App\Models\RekapKas;
use App\Models\Ttable;
use DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RekapHarianKasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-treasury.rekap-harian-kas.index');
    }

    public function indexJson(Request $request)
    {
        $data_tahunbulan = DB::select("select max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                $bulan_buku = $data_bul->bulan_buku;
            }
        } else {
            $bulan_buku = '000000';
        }

        if ($request->nama == "") {
            $data = DB::select("select a.jk, a.store, ltrim(to_char(a.rekap,'000')) as no, to_date(trim(to_char(a.tglrekap,'dd/mm/yyyy')),'dd/mm/yyyy') as stglrekap, a.saldoawal*-1 as saldoawal, a.debet*-1 as debet, kredit, a.saldoakhir*-1 as saldoakhir, b.namabank as nama_store   from rekapkas a join storejk b on a.store=b.kodestore where to_char(a.tglrekap,'yyyymm') = '$bulan_buku' order by a.tglrekap desc");
        } elseif ($request->nama <> "") {
            $data = DB::select("select a.jk, a.store, ltrim(to_char(a.rekap,'000')) as no, to_date(trim(to_char(a.tglrekap,'dd/mm/yyyy')),'dd/mm/yyyy') as stglrekap, a.saldoawal*-1 as saldoawal, a.debet*-1 as debet, kredit, a.saldoakhir*-1 as saldoakhir, b.namabank as nama_store   from rekapkas a join storejk b on a.store=b.kodestore where a.store='$request->nama' order by a.tglrekap desc");
        }
        return datatables()->of($data)
            ->addColumn('jk', function ($data) {
                return $data->jk;
            })
            ->addColumn('store', function ($data) {
                return $data->store . ' -- ' . $data->nama_store;
            })
            ->addColumn('no', function ($data) {
                return $data->no;
            })
            ->addColumn('tglrekap', function ($data) {
                $tgl = date_create($data->stglrekap);
                return date_format($tgl, 'd F Y');
            })
            ->addColumn('saldoawal', function ($data) {
                return 'Rp. ' . number_format($data->saldoawal, 2, '.', ',');
            })
            ->addColumn('debet', function ($data) {
                return 'Rp. ' . number_format($data->debet, 2, '.', ',');
            })
            ->addColumn('kredit', function ($data) {
                return 'Rp. ' . number_format($data->kredit, 2, '.', ',');
            })
            ->addColumn('saldoakhir', function ($data) {
                return 'Rp. ' . number_format($data->saldoakhir, 2, '.', ',');
            })

            ->addColumn('radio', function ($data) {
                $tglrek = date_create($data->stglrekap);
                $tglrekap = date_format($tglrek, 'Y-m-d');
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" jk="' . $data->jk . '" nokas="' . $data->store . '"  tanggal="' . $tglrekap . '" class="btn-radio" name="btn-radio-rekap"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create()
    {
        return view('modul-treasury.rekap-harian-kas.create');
    }

    public function JeniskaruJson(Request $request)
    {
        $datas = DB::select("select distinct jk from kasdoc where paid='Y' and to_char(paiddate,'yyyy-mm-dd') ='$request->tanggal' order by jk");
        if (!empty($datas)) {
            return response()->json($datas[0]);
        } else {
            $data = 1;
            return response()->json($data);
        }
    }
    public function NokasJson(Request $request)
    {
        $datas = DB::select("select distinct a.store,b.namabank,b.norekening from kasdoc a,storejk b where a.store=b.kodestore and b.jeniskartu='$request->jk' and a.PAID='Y' and to_char(a.paiddate,'yyyy-mm-dd') = '$request->tanggal' order by a.store");
        if (!empty($datas)) {
            $html = '';
            foreach ($datas as $data) {
                $html .= '<option value="' . $data->store . '">' . $data->store . ' -- ' . $data->namabank . '</option>';
            }
            return response()->json(['html' => $html]);
        } else {
            $data = 1;
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $jk = $request->jk;
        $nokas = $request->nokas;
        $tanggal = $request->tanggal;

        $data_tabl = DB::select("select * from t_table");
        foreach ($data_tabl as $data_tab) {
            Ttable::where("t_date", $data_tab->t_date)->update([
                't_date' => $tanggal
            ]);
        }
        $data_rsrekapkas = DB::select("select * from rekapkas where jk='$jk' and store='$nokas' and to_char(tglrekap,'yyyy-mm-dd')='$tanggal'");
        if (!empty($data_rsrekapkas)) {
            $data = 5;
            return response()->json($data);
            // response.write("<script>alert('rekap kas sudah dilakukan!')</script>")  
        } else {
            $data_cekbulbuk = DB::select("select h.docno,to_char(h.paiddate,'yyyy-mm-dd') as stglrekap,h.voucher,h.thnbln,h.paiddate, h.store, d.keterangan, d.cj , -d.totprice totprice,posted,rate, h.jk 
                                from kasdoc h, kasline d 
                                where h.docno=d.docno and 
                                        h.store='$nokas' and 
                                        h.jk='$jk' and 
                                        to_char(h.paiddate,'yyyy-mm-dd')='$tanggal' and d.penutup<>'Y' 
                                        and h.paid='Y' order by h.voucher");
            if (!empty($data_cekbulbuk)) {
                foreach ($data_cekbulbuk as $data_cekbul) {
                    if ($data_cekbul->thnbln <> "") {
                        if (stbbuku($data_cekbul->thnbln, "0") > 1) {
                            $data = 2;
                            return response()->json($data);
                            // response.write("<script>alert('rekap gagal !')</script>")
                        }
                    }
                }
            }

            $data_rsdatemin = DB::select("select min(paiddate) as datemin from kasdoc h where paiddate not in (select tglrekap from rekapkas where store='$nokas' and jk='$jk') and store='$nokas' and jk='$jk'");
            foreach ($data_rsdatemin as $data_rsadm) {
                if ($data_rsadm->datemin <> "") {
                } else {
                    $data = 3;
                    return response()->json($data);
                    // response.write("<script>alert('rekap harian sudah dilakukan sebelumnya, rekap gagal!')</script>")  
                }
            }
        }

        $data_rs = DB::select("select tglrekap as datemax, rekap as norekap from rekapkas where store='$nokas' and jk='$jk' order by tglrekap desc");
        if (!empty($data_rs)) {
            foreach ($data_rs as $data_r) {
                if ($data_r->norekap == "999") {
                    $norekap = 0;
                }
                if ($data_r->datemax == "") {
                    $selrekapdate = 1;
                } else {
                    $selrekapdate = 0;
                }
                $norekap = $data_r->norekap;
            }
        } else {
            $selrekapdate = 1;
            $norekap = 0;
        }

        foreach ($data_cekbulbuk as $data_cekbull) {
            $datars_rs = DB::select("select * from rekapkas where store='$data_cekbull->store' and jk='$data_cekbull->jk' and to_char(tglrekap,'yyyy-mm-dd')='$tanggal'");
        }
        if (!empty($datars_rs)) {
            $data = 4;
            return response()->json($data);
            // response.write("<script>alert('rekap harian ini sudah ada!')</script>") 
        } else {
            $datatrs_rs = DB::select("select saldoakhir from rekapkas where store='$nokas' and jk='$jk' and tglrekap= (select max(tglrekap) from rekapkas where store='$nokas' and jk='$jk')");
            if (!empty($datatrs_rs)) {
                foreach ($datatrs_rs as $datatrs_r) {
                    $saldoawal = round(vbildb($datatrs_r->saldoakhir));
                }
            } else {
                $datasaldo_rs = DB::select("select saldoakhir from saldostore where nokas='$nokas' and jk='$jk'");
                if (!empty($datasaldo_rs)) {
                    foreach ($datasaldo_rs as $datasaldo_r) {
                        $storeak = $datasaldo_r->saldoakhir;
                    }
                } else {
                    $storeak = 0;
                }
                $saldoawal = round(vbildb($storeak));
            }

            $datajuml_rs = DB::select("select sum(d.totprice) as jumlah from kasdoc h, kasline d where h.docno=d.docno and h.store='$nokas' and h.jk='$jk' and to_char(h.paiddate,'yyyy-mm-dd')='$tanggal' and d.penutup<>'Y' and h.paid='Y' group by d.docno,h.ci,sign(d.totprice)");
            if (!empty($datajuml_rs)) {
                foreach ($datajuml_rs as $datajuml_r) {
                    if ($datajuml_r->jumlah <= 0) {
                        $debet = $datajuml_r->jumlah;
                    } else {
                        $kredit = $datajuml_r->jumlah;
                    }
                }
            } else {
                $debet = 0;
                $kredit = 0;
            }

            $tglrekap = date_create($tanggal);
            $rekapyear = date_format($tglrekap, 'Y');
            RekapKas::insert([
                'jk' => $jk,
                'tglrekap' => $tanggal,
                'store' => $nokas,
                'saldoawal' => $saldoawal,
                'saldoakhir' => $saldoawal + $debet + $kredit,
                'debet' => $debet,
                'kredit' => $kredit,
                'userid' => $request->userid,
                'password' => $request->userid,
                'rekap' => $norekap + 1,
                'tahun_rekap' => $rekapyear
            ]);

            // $data_rsrekapkas = DB::select("select * from rekapkas where store='$nokas' and jk='$jk' and to_char(tglrekap,'yyyy-mm-dd')='$tanggal'");

            $data_rskasdoc = DB::select("select docno, rekap, rekapdate from kasdoc where to_char(paiddate,'yyyy-mm-dd')='$tanggal'");
            if (!empty($data_rskasdoc)) {
                foreach ($data_rskasdoc as $data_rsk) {
                    Kasdoc::where('docno', $data_rsk->docno)
                        ->update([
                            'rekap' => $norekap + 1,
                            'rekapdate' => $tanggal
                        ]);
                }
            }
            $data = 1;
            return response()->json($data);
            // response.write("<script>alert('rekap harian sukses!')</script>")  

        }
    }

    public function edit($id, $no, $tgl)
    {
        $data_list = DB::select("select * from rekapkas where jk='$id' and store='$no' and tglrekap='$tgl'");
        return view('modul-treasury.rekap-harian-kas.edit', compact('data_list'));
    }

    public function update(Request $request)
    {
        $jk = $request->jk;
        $nokas = $request->nokas;
        $tanggal = $request->tanggal;
        $data_tabl = DB::select("select * from t_table");
        foreach ($data_tabl as $data_tab) {
            Ttable::where('t_date', $data_tab->t_date)->update([
                't_date' => $tanggal
            ]);
        }

        $data_srekapkas = DB::select("select * from rekapkas where store='$nokas' and jk='$jk' and to_char(tglrekap,'yyyy-mm-dd')='$tanggal'");

        if (!empty($data_srekapkas)) {
            $data = 2;
            return response()->json();
            // response.write("<script>alert('belum dilakukan rekap')</script>")  
        }

        $data_cekbulbuk = DB::select("select h.docno,to_char(h.paiddate,'yyyy-mm-dd') as stglrekap,h.voucher,h.thnbln,h.paiddate, h.store, d.keterangan, d.cj , -d.totprice totprice,posted,rate, h.jk  from kasdoc h, kasline d where h.docno=d.docno and h.store='$nokas' and h.jk='$jk' and to_char(h.paiddate,'yyyy-mm-dd')='$tanggal' and d.penutup<>'Y' order by h.voucher");
        if (!empty($data_cekbulbuk)) {
            foreach ($data_cekbulbuk as $data_cekbul) {
                if ($data_cekbul->thnbln <> "") {
                    if (stbbuku($data_cekbul->thnbln, "0") > 1) {
                        $data = 3;
                        return response()->json($data);
                        // response.write("<script>alert('pembatalan rekap gagal')</script>")  
                    }
                }
            }
        }

        $data_rs = DB::select("select tglrekap from rekapkas where (tglrekap > (select t_date from t_table)) and store='$nokas' and jk='$jk'");
        if (!empty($data_rs)) {
            $data = 4;
            return response()->json($data);
            // response.write("<script>alert('sudah ada rekap harian pada tanggal $rs("tglrekap"), cancel rekap tanggal tersebut terlebih dahulu')</script>")  
        }

        $data_cr1 = DB::select("select left(docno,1) dok,docno from kasdoc where paiddate=(select t_date from t_table) and store='$nokas' and jk='$jk'");
        $data_tdate = DB::select("select t_date as vdate from t_table");
        foreach ($data_cr1 as $t) {
            if ($t->dok == 'P') {
                Kasdoc::where('docno', $t->docno)
                    ->update([
                        'rekap' => '',
                        'rekapdate' => null
                    ]);
                Kasline::where('docno', $t->docno)
                    ->update([
                        'rekap' => '',
                        'voucher' => ''
                    ]);
            } else {
                Kasdoc::where('docno', $t->docno)
                    ->update([
                        'rekap' => '',
                        'rekapdate' => null
                    ]);
                Kasline::where('docno', $t->docno)
                    ->update([
                        'rekap' => '',
                        'voucher' => ''
                    ]);
            }
        }
        foreach ($data_tdate as $data_tdat) {
            RekapKas::where('store', $nokas)->where('jk', $jk)->where('tglrekap', $data_tdat->vdate)->delete();
            Kasdoc::where('dok_penutup', 'Y')->where('store', $nokas)->where('jk', $jk)->where('paiddate', $data_tdat->vdate)->delete();
        }
        $data = 1;
        return response()->json($data);
        // response.write("<script>alert('pembatalan rekap selesai')</script>")  


    }


    public function delete(Request $request)
    {
        RekapKas::where('store', $request->nokas)->where('jk', $request->jk)->where('tglrekap', $request->tanggal)->delete();
        return response()->json();
    }

    public function RekapHarian($nokas, $jk, $tanggal)
    {
        return view('modul-treasury.rekap-harian-kas.rekaphari', compact('jk', 'nokas', 'tanggal'));
    }
    public function CtkHarian(Request $request)
    {
        $data_list = DB::select("
            select * from v_report_rekapkas_harian where left(lokasi_kas_bank,2)='$request->nokas' and tanggal_rekap ='$request->tanggal' 
            ");
        // dd($request->jk);
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-treasury.rekap-harian-kas.export_hariankas', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(390, 115, "({PAGE_NUM}) Dari {PAGE_COUNT}", null, 8, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Data Tidak Ditemukan", 'Failed')->persistent(true);
            return redirect()->route('rekap_harian_kas.RekapHarian');
        }
    }
}
