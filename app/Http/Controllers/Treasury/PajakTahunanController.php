<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\VParamPajak;
use DB;
use Illuminate\Http\Request;

class PajakTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-treasury.pajak-tahunan.index');
    }

    /**
     * Export the form for a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        DB::statement("DROP VIEW IF EXISTS v_reportpajak CASCADE");
        DB::statement("CREATE OR REPLACE VIEW v_reportpajak AS
                            select CAST(bulan as integer),tahun,nopek,
                            sum(CASE WHEN aard = '01' or aard = '02'  THEN nilai ELSE '0' END) as data_1,
                            sum(CASE WHEN aard = '27'  THEN nilai ELSE '0' END) as data_2,
                            sum(CASE WHEN aard = '04' or aard = '03' or aard = '06' or aard = '05' or aard = '32' THEN nilai ELSE '0' END) as data_3,
                            sum(CASE WHEN aard = '42' or aard = '43' or aard = '41' or aard = '45'  THEN nilai ELSE '0' END) as data_4,
                            sum(CASE WHEN aard = '10' or aard = '12'  THEN nilai ELSE '0' END) as data_5,
                            sum(CASE WHEN aard = '24' or aard = '25' or aard = '39' or aard = '40'  THEN nilai ELSE '0' END) as data_6,
                            sum(CASE WHEN aard = '24P' or aard = '40P' or aard = '25P' or aard = '39P' or aard = '43P' or aard = '41P' or aard = '42P' THEN nilai ELSE '0' END) as data_7,
                            sum(CASE WHEN aard = '09' or aard = '14'  THEN nilai ELSE '0' END) as data_8
                            from v_parampajakreport where tahun='$request->tahun' group by bulan,tahun,nopek ORDER BY nopek,bulan asc
                            ");
        DB::statement("DROP VIEW IF EXISTS v_reportpajak_total CASCADE");
        DB::statement("CREATE OR REPLACE VIEW v_reportpajak_total AS
                            select tahun,nopek,
                            sum(CASE WHEN aard = '01' or aard = '02'  THEN nilai ELSE '0' END) as data_1,
                            sum(CASE WHEN aard = '27'  THEN nilai ELSE '0' END) as data_2,
                            sum(CASE WHEN aard = '04' or aard = '03' or aard = '06' or aard = '05' or aard = '32' THEN nilai ELSE '0' END) as data_3,
                            sum(CASE WHEN aard = '42' or aard = '43' or aard = '41' or aard = '45'  THEN nilai ELSE '0' END) as data_4,
                            sum(CASE WHEN aard = '10' or aard = '12'  THEN nilai ELSE '0' END) as data_5,
                            sum(CASE WHEN aard = '24' or aard = '25' or aard = '39' or aard = '40'  THEN nilai ELSE '0' END) as data_6,
                            sum(CASE WHEN aard = '24P' or aard = '40P' or aard = '25P' or aard = '39P' or aard = '43P' or aard = '41P' or aard = '42P' THEN nilai ELSE '0' END) as data_7,
                            sum(CASE WHEN aard = '09' or aard = '14'  THEN nilai ELSE '0' END) as data_8
                            from v_parampajakreport where tahun='$request->tahun' group by tahun,nopek ORDER BY nopek asc
                            ");
        $data_list = VParamPajak::all();

        return $data_list;
        // $pdf = PDF::loadview('pajak_tahunan.export_proses_pajak_pdf', compact('data_list'))
        // ->setPaper('A4', 'landscape')
        // ->setOption('footer-right', 'Halaman [page] dari [toPage]')
        // ->setOption('footer-font-size', 7)
        // ->setOption('margin-top', 10)
        // ->setOption('margin-bottom', 10);

        // return $pdf->stream('Form Cetak 1721-A1_' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function rekapLaporan()
    {
        return view('modul-treasury.pajak-tahunan.rekap-laporan');
    }

    public function exportLaporan(Request $request)
    {
        DB::table('report_pajak')->delete();
        $tanggal = $request->tanggal;
        // 'CARI PEGAWAI YANG STATUS PEKERJA TETAP
        $rsproses = DB::select("select nopeg,status,kodekeluarga,trim(to_char(tglaktifdns,'YYYY')) as tahun,trim(to_char(tglaktifdns,'MM')) as bulan from sdm_master_pegawai where status in ('C','B','K') order by nopeg asc");
        foreach ($rsproses as $data_rsproses) {
            $nopeg = $data_rsproses->nopeg;
            $status1 = $data_rsproses->status;
            $kodekel = $data_rsproses->kodekeluarga;
            $tahundns = $data_rsproses->tahun;
            $bulandns = $data_rsproses->bulan;

            // 'CARI NILAI YANG KENA PAJAK (BRUTO 1-6)
            $rskenapajak = DB::select("select coalesce(sum(nilai),0) as nilaipajak from v_parampajakreport where tahun='$tanggal' and nopek='$nopeg' and length(aard)='2' and aard in ('01','02','04','03','06','05','32','42','43','41','10','12','45')");
            if (!empty($rskenapajak)) {
                foreach ($rskenapajak as $data_rskenapajak) {
                    $totkenapajak = $data_rskenapajak->nilaipajak;
                }
            } else {
                $totkenapajak = 0;
            }

            $rskenapajak2 = DB::select("select coalesce(sum(nilai),0) as nilaipajak from v_parampajakreport where tahun='$tanggal' and nopek='$nopeg' and length(aard)='2' and aard in ('24','25','39','40')");
            if (!empty($rskenapajak2)) {
                foreach ($rskenapajak2 as $data_rskenapajak2) {
                    $totkenapajak2 = $data_rskenapajak2->nilaipajak;
                }
            } else {
                $totkenapajak2 = 0;
            }
            if ($tahundns == $tanggal) {
                $bulanaktif = $bulandns;
                $nilaimaks = 500000 * ((12 - $bulanaktif) + 1);
            } else {
                $bulanaktif = 1;
                $nilaimaks = 6000000;
            }

            // 'CARI NILAI PENGURANG 
            // 'HITUNG BIAYA JABATAN 1
            $biayajabatan2 = ((5 / 100) * $totkenapajak);
            if ($biayajabatan2 > $nilaimaks) {
                $biayajabatan = $nilaimaks;
            } else {
                $biayajabatan = $biayajabatan2;
            }

            // 'HITUNG BIAYA JABATAN 2
            $biayajabatan3 = ((5 / 100) * $totkenapajak2);
            if ($biayajabatan3 > $nilaimaks) {
                $biayajabatan4 = $nilaimaks;
            } else {
                $biayajabatan4 = $biayajabatan3;
            }

            $jumbiayajabatan = $biayajabatan + $biayajabatan4;
            if ($jumbiayajabatan > $nilaimaks) {
                if ($biayajabatan >= $nilaimaks) {
                    $biayajabatan = $nilaimaks;
                    $biayajabatan4 = 0;
                } else {
                    $biayajabatan = $biayajabatan;
                    $biayajabatan4 = $nilaimaks - $biayajabatan;
                }
            } else {
                $biayajabatan = $biayajabatan;
                $biayajabatan4 = $biayajabatan4;
            }

            $rspensiun = DB::select("select coalesce(sum(nilai),0) as nilaipensiun from v_parampajakreport where tahun='$tanggal' and nopek='$nopeg' and length(aard)='2' and aard in ('09','14')");
            if (!empty($rspensiun)) {
                foreach ($rspensiun as $data_rspensiun) {
                    $totpensiun = $data_rspensiun->nilaipensiun;
                }
            } else {
                $totpensiun = 0;
            }
            $neto1tahun =  $totkenapajak + $totkenapajak2 + $totpensiun - ($biayajabatan + $biayajabatan4);

            // 'CARI NILAI TIDAK KENA PAJAK
            $nilaiptkp1 = DB::select("select a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$nopeg'");
            if (!empty($nilaiptkp1)) {
                foreach ($nilaiptkp1 as $data_nilaiptkp1) {
                    $nilaiptkp1 = $data_nilaiptkp1->nilai;
                }
            } else {
                $nilaiptkp1 = 0;
            }

            // 'PENGHASILAN KENA PAJAK SETAHUN
            $nilaikenapajaka = $neto1tahun - $nilaiptkp1;
            // 'HITUNG PAJAK PENGHASILAN TERUTANG
            // 'PAJAK SETAHUN
            $nilai2 = 0;
            $nilai1 = 0;
            $tunjangan = 0;
            $pajakbulan = 1;
            $nilaikenapajak = $nilaikenapajaka;
            if ($tunjangan <> $pajakbulan) {
                $tunjangan = $pajakbulan;
                $pajak1 = pph21ok($nilaikenapajak);
                $pajakbulan = ($pajak1);
                $nilaikenapajak = ($nilaikenapajak / 1000) * 1000;
                $selisih = $nilai2 - $nilai1;
                $nilai1 = $nilaikenapajak;
                $nilaikenapajak = (($nilaikenapajak + $pajak1) / 1000) * 1000;
                $nilai2 = ($nilaikenapajak / 1000) * 1000;
                $nilaikenapajak = (($nilaikenapajak - $selisih) / 1000) * 1000;
            }
            $tunjangan = $pajakbulan;


            // 'HITUNG ULANG PAJAK GROSS UP
            $totkenapajakfinal = $totkenapajak + $tunjangan;
            //     'HITUNG BIAYA JABATAN 1

            if ($tahundns == $tanggal) {
                $bulanaktif = $bulandns;
                $nilaimaks = 500000 * ((12 - $bulanaktif) + 1);
            } else {
                $bulanaktif = 1;
                $nilaimaks = 6000000;
            }

            $biayajabatan2 = ((5 / 100) * $totkenapajakfinal);
            if ($biayajabatan2 > $nilaimaks) {
                $biayajabatan = $nilaimaks;
            } else {
                $biayajabatan = $biayajabatan2;
            }

            // 'HITUNG BIAYA JABATAN 2
            $biayajabatan3 = ((5 / 100) * $totkenapajak2);
            if ($biayajabatan3 > $nilaimaks) {
                $biayajabatan4 = $nilaimaks;
            } else {
                $biayajabatan4 = $biayajabatan3;
            }

            $jumbiayajabatan = $biayajabatan + $biayajabatan4;
            if ($jumbiayajabatan > $nilaimaks) {
                if ($biayajabatan >= $nilaimaks) {
                    $biayajabatan = $nilaimaks;
                    $biayajabatan4 = 0;
                } else {
                    $biayajabatan = $biayajabatan;
                    $biayajabatan4 = $nilaimaks - $biayajabatan;
                }
            } else {
                $biayajabatan = $biayajabatan;
                $biayajabatan4 = $biayajabatan4;
            }

            $neto1tahun =  ($totkenapajakfinal) + ($totkenapajak2) + ($totpensiun) - (($biayajabatan) + ($biayajabatan4));

            $nilaikenapajaka = ($neto1tahun) - ($nilaiptkp1);
            // 'HITUNG PAJAK PENGHASILAN TERUTANG
            // 'PAJAK SETAHUN
            $nilai2 = 0;
            $nilai1 = 0;
            $tunjangan2 = 0;
            $pajakbulan = 1;
            $nilaikenapajak = $nilaikenapajaka;
            if ($tunjangan2 <> $pajakbulan) {
                $tunjangan2 = $pajakbulan;
                $pajak1 = pph21ok($nilaikenapajak);
                $pajakbulan = ($pajak1);
                $nilaikenapajak = ($nilaikenapajak / 1000) * 1000;
                $selisih = $nilai2 - $nilai1;
                $nilai1 = $nilaikenapajak;
                $nilaikenapajak = (($nilaikenapajak + $pajak1) / 1000) * 1000;
                $nilai2 = ($nilaikenapajak / 1000) * 1000;
                $nilaikenapajak = (($nilaikenapajak - $selisih) / 1000) * 1000;
            }
            $tunjangan2 = $pajakbulan;

            // 'TAMBAHKAN NILAI POTONGAN PAJAK KE MASTER_UPAH
            DB::table('report_pajak')->insert([
                'nopek' => $nopeg,
                'tahun' => $tanggal,
                'kodekel' => $kodekel,
                'kenapajak' => $nilaikenapajaka,
                'bjabatan' => $biayajabatan,
                'tunjpajak' => $tunjangan,
                'potpajak' => $tunjangan * -1,
                'nilptkp' => $nilaiptkp1,
                'bjabatan2' => $biayajabatan4,
                'mulai' => $bulanaktif,
                'sampai' => '12'
            ]);
        }

        // 'CARI PEGAWAI YANG STATUS PEKERJA TETAP
        $rsproses = DB::select("select nopeg,status,kodekeluarga from sdm_master_pegawai where status='U' order by nopeg asc");
        foreach ($rsproses as $data_rsproses) {
            $nopeg = $data_rsproses->nopeg;
            $status1 = $data_rsproses->status;
            $kodekel = $data_rsproses->kodekeluarga;

            // 'HITUNG PAJAK PPH21
            // 'CARI NILAI YANG KENA PAJAK (BRUTO)
            $rskenapajak = DB::select("select coalesce(sum(nilai),0) as nilaipajak from v_parampajakreport where tahun='$tanggal' and nopek='$nopeg' and length(aard)='2' and aard not in ('26','27')");
            if (!empty($rskenapajak)) {
                foreach ($rskenapajak as $data_rskenapajak) {
                    $totkenapajak = $data_rskenapajak->nilaipajak;
                }
            } else {
                $totkenapajak = 0;
            }
            $nilaikenapajaka = ($totkenapajak);

            if ($nopeg == "KOM3" or $nopeg == "KOMUT") {
                $tunjpajak = (15 / 100) * ($nilaikenapajaka);
                $potpajak = (30 / 100) * (($nilaikenapajaka) + $tunjpajak);
            } else {
                $tunjpajak = (5 / 100) * ($nilaikenapajaka);
                $potpajak = (30 / 100) * (($nilaikenapajaka) + $tunjpajak);
            }

            // 'TAMBAHKAN NILAI POTONGAN PAJAK KE MASTER_UPAH
            DB::table('report_pajak')->insert([
                'nopek' => $nopeg,
                'tahun' => $tanggal,
                'kodekel' => $kodekel,
                'kenapajak' => $nilaikenapajaka,
                'bjabatan' => 0,
                'tunjpajak' => $tunjpajak,
                'potpajak' => $potpajak * -1,
                'nilptkp' => 0
            ]);
        }





        DB::statement("DROP VIEW IF EXISTS v_reportpajak CASCADE");
        DB::statement("CREATE OR REPLACE VIEW v_reportpajak AS
                             select nopek,tahun,
                             sum(CASE WHEN aard = '01' or aard = '02'  THEN nilai ELSE '0' END) as data_1,
                             sum(CASE WHEN aard = '24' or aard = '25' or aard = '39' or aard = '40'  THEN nilai ELSE '0' END) as data_2,
                             sum(CASE WHEN aard = '27'  THEN nilai ELSE '0' END) as data_3,
                             sum(CASE WHEN aard = '42' or aard = '43' or aard = '41' or aard = '45'  THEN nilai ELSE '0' END) as data_4,
                             sum(CASE WHEN aard = '09' or aard = '14'  THEN nilai ELSE '0' END) as data_5,
                             sum(CASE WHEN aard = '04' or aard = '03' or aard = '06' or aard = '05' or aard = '32' THEN nilai ELSE '0' END) as data_6,
                             sum(CASE WHEN aard = '24P' or aard = '40P' or aard = '25P' or aard = '39P' or aard = '43P' or aard = '41P' or aard = '42P' THEN nilai ELSE '0' END) as data_7,
                             sum(CASE WHEN aard = '10' or aard = '12'  THEN nilai ELSE '0' END) as data_8,
                             sum(CASE WHEN aard = '01' or aard = '02' or aard = '04' or aard = '03' or aard = '06' or aard = '05' or aard = '32' or aard = '42' or aard = '43' or aard = '41' or aard = '45' or aard = '10' or aard = '12' THEN nilai ELSE '0' END) as data_9
                             from v_parampajakreport where tahun='$request->tahun' group by nopek,tahun ORDER BY nopek asc
                             ");
        $data_list = VParampajak::all();

        return $data_list;
        // $pdf = PDF::loadview('pajak_tahunan.export_laporan_pajak_pdf', compact('data_list'))
        // ->setPaper('legal', 'portrait')
        // ->setOption('footer-font-size', 7)
        // ->setOption('margin-left', 1)
        // ->setOption('margin-right', 1)
        // ->setOption('margin-top', 1)
        // ->setOption('margin-bottom', 1);

        // return $pdf->stream('Form Cetak 1721-A1 Tahunan_' . date('Y-m-d H:i:s') . '.pdf');
    }
}
