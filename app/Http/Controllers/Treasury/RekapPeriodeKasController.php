<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use DomPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RekapPeriodeKasController extends Controller
{
    public function create()
    {
        return view('modul-treasury.rekap-periode-kas.rekap');
    }

    public function nokasJson(Request $request)
    {
        $data = DB::select("SELECT distinct a.store,b.namabank,b.norekening from kasdoc a,storejk b where a.store=b.kodestore and a.PAID='Y' and b.jeniskartu='$request->jk' and paiddate between '$request->tanggal' and '$request->tanggal2' order by a.store");
        return response()->json($data);
    }
    public function jkJson(Request $request)
    {
        $data = DB::select("SELECT distinct jk from kasdoc where paid='Y' and paiddate between '$request->tanggal' and '$request->tanggal2'  order by jk");
        return response()->json($data);
    }

    public function RekapPeriode()
    {
        return view('modul-treasury.rekap-periode-kas.rekap');
    }
    public function exportPeriode(Request $request)
    {
        $data_vd = DB::select("SELECT min(tglrekap) v_d1, max(tglrekap)  v_d2 from rekapkas where (to_char( tglrekap,'dd-mm-yyyy') between '$request->tanggal' and '$request->tanggal2') and  jk='$request->jk' and store='$request->nokas'");
        if (!empty($data_vd)) {
            foreach ($data_vd as $data_vdd) {
                $a = date_create($data_vdd->v_d1);
                $v_d1 = date_format($a, 'd-m-Y');
                $b = date_create($data_vdd->v_d2);
                $v_d2 = date_format($b, 'd-m-Y');
                if (is_null($data_vdd->v_d1)) {
                    $v_saw = 0;
                } else {
                    $data_a = DB::select("SELECT -round(s.saldoawal,2)  v_saw  from rekapkas s where to_char( s.tglrekap,'dd-mm-yyyy') = '$v_d1' and jk='$request->jk' and store='$request->nokas'");
                    if (!empty($data_a)) {
                        foreach ($data_a as $data) {
                            $v_saw = $data->v_saw;
                        }
                    } else {
                        $v_saw = 0;
                    }
                }

                if (is_null($data_vdd->v_d1)) {
                    $v_sak = 0;
                } else {
                    $data_a = DB::select("SELECT -round(s.saldoakhir,2) v_sak  from rekapkas s where to_char( tglrekap,'dd-mm-yyyy') = '$v_d2' and jk='$request->jk' and store='$request->nokas'");
                    if (!empty($data_a)) {
                        foreach ($data_a as $data) {
                            $v_sak = $data->v_sak;
                        }
                    } else {
                        $v_sak = 0;
                    }
                }
            }
        } else {
            $v_saw = 0;
            $v_sak = 0;
        }


        DB::statement("DROP VIEW IF EXISTS v_report_rekapkas_bebas CASCADE");
        DB::statement("CREATE OR REPLACE VIEW v_report_rekapkas_bebas AS
                        select ltrim(to_char(rk.rekap,'000')) No_Rekap, to_char(rk.tglrekap,'dd/mm/yyyy') Tanggal_Rekap, rk.jk Jenis_Kartu, (rk.store||' ('||s.namabank||')') Lokasi_Kas_Bank, s.norekening No_Rekening, (d.ci||' ('||mu.namamu||')') Mata_Uang, l.docno as No_Dokumen, d.voucher as No_Bukti, l.keterangan as uraian_penjelasan, l.LOKASI, L.cj, CASE WHEN sign(l.totprice) = '-1' then abs(l.totprice) else '0' end Debet, CASE WHEN -sign(l.totprice) = 1 then 0 else l.totprice end Kredit, $v_saw Saldo_Awal, $v_sak Saldo_Akir from rekapkas rk, kasdoc d, kasline l, storejk s, matauang mu where to_char( rk.tglrekap,'dd-mm-yyyy')=to_char( d.PAIDdate,'dd-mm-yyyy') and rk.store=s.kodestore and rk.store=d.store and rk.jk=d.jk and d.docno=l.docno and coalesce(l.penutup,'N')='N' and d.ci=mu.kodemu and coalesce(d.paid,'N')='Y' And to_char( rk.tglrekap,'dd-mm-yyyy') Between '$request->tanggal' AND '$request->tanggal2' and rk.jk='$request->jk' and rk.store='$request->nokas' order by d.voucher, l.lineno;
                        ");
        $data_list = DB::select("SELECT * from v_report_rekapkas_bebas");
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-treasury.rekap-periode-kas.export', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(420, 115, "({PAGE_NUM}) Dari {PAGE_COUNT}", null, 8, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('d-m-Y H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Data Tidak Ditemukan", 'Failed')->persistent(true);
            return redirect()->route('rekap_periode_kas.create');
        }
    }
}
