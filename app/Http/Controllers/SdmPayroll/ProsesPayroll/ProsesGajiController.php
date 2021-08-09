<?php

namespace App\Http\Controllers\SdmPayroll\ProsesPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\MasterBebanPerusahaan;
use App\Models\MasterHutang;
use App\Models\MasterUpah;
use App\Models\PayDanaPensiun;
use App\Models\PayGapokBulanan;
use App\Models\PayKoreksi;
use App\Models\PayTabungan;
use App\Models\PayTblJamsostek;
use App\Models\MasterPegawai;
use App\Models\StatusBayarGaji;
use App\Models\TblPajak;
use App\Models\UtBantu;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class ProsesGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.proses-gaji.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->radioupah == 'proses') {
            $data_tahun = substr($request->tanggalupah, -4);
            $data_bulan = ltrim(substr($request->tanggalupah, 0, -5), '0');
            $data_bulans = substr($request->tanggalupah, 0, -5);

            $data = MasterUpah::where('tahun', $data_tahun)
            ->where('bulan', $data_bulan)
            ->count();

            if ($data >= 1) {
                Alert::Info("Bulan $data_bulan dan tahun $data_tahun yang dimasukan sudah pernah di proses", 'Info')->persistent(true);
                
                return redirect()->route('modul_sdm_payroll.proses_gaji.index')->with(['proses' => 'proses']);
            } else {
                if ($request->prosesupah == 'A') {
                    // PekerjaTetap()
                    $data_pegawaic = MasterPegawai::where('status', 'C')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawaic as $datapt) {
                        TblPajak::insert([
                            'tahun' => $data_tahun,
                            'bulan' => $data_bulan,
                            'nopeg' => $datapt->nopeg,
                            'status' => $datapt->kodekeluarga,
                        ]);

                        // 1.CARI UPAH TETAP AARD 01
                        $data_sdmutpt = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapt->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapt->nopeg')");
                        if (!empty($data_sdmutpt)) {
                            foreach ($data_sdmutpt as $data_sdmpt) {
                                if ($data_sdmpt->ut <> "") {
                                    $upahtetappt = $data_sdmpt->ut;
                                } else {
                                    $upahtetappt = '0';
                                }
                            }
                        } else {
                            $upahtetappt = '0';
                        }

                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '01',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $upahtetappt,
                                'userid' => $request->userid,
                            ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datapt->nopeg)
                            ->update([
                                'upah' => $upahtetappt,
                            ]);

                        // 2.TUNJANGAN JABATAN AARD 03
                        $data_sdmjabatanpt = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datapt->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datapt->nopeg')");
                        if (!empty($data_sdmjabatanpt)) {
                            foreach ($data_sdmjabatanpt as $data_sdmjabpt) {
                                if ($data_sdmjabpt->tunjangan <> "") {
                                    $tunjabatanpt = $data_sdmjabpt->tunjangan;
                                } else {
                                    $tunjabatanpt = '0';
                                }
                            }
                        } else {
                            $tunjabatanpt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '03',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjabatanpt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'tunjjabat' => $tunjabatanpt,
                                ]);

                        // 3.TUNJANGAN BIAYA HIDUP AARD AARD = 04
                        $data_sdmtunjanganpt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$datapt->nopeg' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$datapt->nopeg')");
                        if (!empty($data_sdmtunjanganpt)) {
                            foreach ($data_sdmtunjanganpt as $data_sdmpt) {
                                if ($data_sdmpt->nilai <> "") {
                                    $tunjabatanhiduppt = $data_sdmpt->nilai;
                                } else {
                                    $tunjabatanhiduppt = '0';
                                }
                            }
                        } else {
                            $tunjabatanhiduppt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '04',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjabatanhiduppt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'tunjdaerah' => $tunjabatanhiduppt,
                                ]);

                        // 4.FASILITAS CUTI AARD 06
                        $data_sdmfcutipt = MasterPegawai::where('nopeg', $datapt->nopeg)->get();
                        foreach ($data_sdmfcutipt as $data_sdmpt) {
                            $tahunpt = date('Y', strtotime($data_sdmpt->fasilitas));
                            $bulanpt = ltrim(date('m', strtotime($data_sdmpt->fasilitas)), '0');
                            $sisatahunpt = $data_tahun - $tahunpt;
                            $sisabulanpt = $data_bulan - $bulanpt;
                        }
                        if ($sisabulanpt == '11' and $sisatahunpt == '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } elseif ($sisabulanpt == '11' and $sisatahunpt > '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } elseif ($sisabulanpt == '-1' and $sisatahunpt > '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } else {
                            $fasilitaspt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '06',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fasilitaspt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'gapok' => $fasilitaspt,
                                ]);

                        // 5.CARI NILAI LEMBUR AARD 05
                        $data_lemburpt = DB::select("SELECT Sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapt->nopeg' And bulan = '$data_bulan' AND tahun='$data_tahun'");
                        if (!empty($data_lemburpt)) {
                            foreach ($data_lemburpt as $data_sdmpt) {
                                if ($data_sdmpt->totlembur <> "") {
                                    $totallemburpt = $data_sdmpt->totlembur;
                                } else {
                                    $totallemburpt = '0';
                                }
                            }
                        } else {
                            $totallemburpt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '05',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $totallemburpt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'lembur' => $totallemburpt,
                                ]);

                        // 6.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaipt = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapt->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipt)) {
                            foreach ($data_sisanilaipt as $data_sdmpt) {
                                if ($data_sdmpt->nilai <> "") {
                                    $fassisapt = $data_sdmpt->nilai;
                                } else {
                                    $fassisapt = '0';
                                }
                            }
                        } else {
                            $fassisapt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '07',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fassisapt,
                                    'userid' => $request->userid,
                                    ]);
                                    
                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapt->nopeg' And bulan = '$data_bulan' AND tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                        'tahun' => $data_hitung_kor->tahun,
                                        'bulan' => $data_hitung_kor->bulan,
                                        'nopek' => $data_hitung_kor->nopek,
                                        'aard' => $data_hitung_kor->aard,
                                        'jmlcc' => $data_hitung_kor->jmlcc,
                                        'ccl' =>  $data_hitung_kor->ccl,
                                        'nilai' => $data_hitung_kor->nilai*-1,
                                        'userid' => $request->userid,
                                        ]);
                        }
                                    

                        //7.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'jumlah' => $upahtetappt,
                                        ]);
                        $data_jamsostekpt = PayTblJamsostek::all();
                        foreach ($data_jamsostekpt as $data_jampt) {
                            $niljspribadipt = ($data_jampt->pribadi/100) * $upahtetappt;
                            $niljstaccidentpt = ($data_jampt->accident/100) * $upahtetappt;
                            $niljspensiunpt = ($data_jampt->pensiun/100) * $upahtetappt;
                            $niljslifept = ($data_jampt->life/100) * $upahtetappt;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadipt * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentpt,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunpt,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifept,
                                'userid' => $request->userid,
                                ]);
                            
                        //9.HITUNG IURAN DANA PENSIUN BNI SIMPONI 46
                        $data_danapensiunpt = PayDanaPensiun::all();
                        foreach ($data_danapensiunpt as $data_danapt) {
                            $nildapenbnipt = ($data_danapt->perusahaan3/100) * $upahtetappt;
                        }
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '46',
                                'lastamount' => '0',
                                'curramount' => $nildapenbnipt,
                                'userid' => $request->userid,
                                ]);

                        // 10.HITUNG TABUNGAN AJTM AARD 16
                        $data_tabunganpt = PayTabungan::all();
                        foreach ($data_tabunganpt as $data_tabpt) {
                            $iuranwajibpt = ($data_tabpt->perusahaan/100) * $upahtetappt;
                        }
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '16',
                                'lastamount' => '0',
                                'curramount' => $iuranwajibpt,
                                'userid' => $request->userid,
                                ]);

                        // 11.CARI NILAI POTONGAN PINJAMAN AARD 19
                        $data_potonganpt = DB::select("SELECT * from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapt->nopeg' and aard='19'");
                        if (!empty($data_potonganpt)) {
                            foreach ($data_potonganpt as $data_potongpt) {
                                $jmlccpotongpinjampt = $data_potongpt->jmlcc;
                                $cclpotongpinjampt = $data_potongpt->ccl;
                                if ($data_potongpt->nilai < 0) {
                                    $nilaipotonganpinjampt = ($data_potongpt->nilai * -1);
                                } else {
                                    $nilaipotonganpinjampt = $data_potongpt->nilai;
                                }
                            }
                        } else {
                            $nilaipotonganpinjampt = '0';
                            $jmlccpotongpinjampt = '0';
                            $cclpotongpinjampt = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '19',
                                        'jmlcc' => $jmlccpotongpinjampt,
                                        'ccl' => $cclpotongpinjampt,
                                        'nilai' => $nilaipotonganpinjampt * -1,
                                        'userid' => $request->userid,
                                        ]);
                            
                        // 12.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajipt = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapt->nopeg'");
                        if (!empty($totalgajipt)) {
                            foreach ($totalgajipt as $totalpt) {
                                if ($totalpt->pembulatan1 < 0) {
                                    $sisagajipt = $totalpt->pembulatan2;
                                } else {
                                    $sisagajipt = $totalpt->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajipt = '0';
                        }

                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '23',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $sisagajipt * -1,
                                        'userid' => $request->userid,
                                        ]);

                        
                        $bulan2pt = $data_bulan + 1;
                        if ($bulan2pt > 12) {
                            $data_bulan2pt = 1;
                            $data_tahun2pt = $data_tahun + 1;
                        } else {
                            $data_bulan2pt =$bulan2pt;
                            $data_tahun2pt = $data_tahun;
                        }
                        // 15.SIMPAN NILAI PEMBULATAN KE TABEL KOREKSI AARD 17 SISA BULAN LALU
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2pt,
                                            'bulan' => $data_bulan2pt,
                                            'nopek' => $datapt->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajipt,
                                            'userid' => $request->userid,
                                            ]);

                        // 16.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakpt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapt->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakpt as $kenappt) {
                            $nilaikenapajakpt = $kenappt->nilai1;
                        }
                        $koreksigajipt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapt->nopeg'");
                        foreach ($koreksigajipt as $koreksigpt) {
                            $kortampt = $koreksigpt->kortam * -1;
                        }
                            
                        $totalkenapajakpt = ($nilaikenapajakpt + $niljstaccidentpt + $niljslifept + $fasilitaspt+ $kortampt)*12;

                        // 17.CARI NILAI PENGURANG
                        $biayajabatanspt = ((5/100)*$totalkenapajakpt);
                        if ($biayajabatanspt > 6000000) {
                            $biayajabatanpt = 6000000;
                        } else {
                            $biayajabatanpt = $biayajabatanspt;
                        }
                                
                                
                        $neto1tahunpt = $totalkenapajakpt - $biayajabatanpt;
                            
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datapt->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatanpt,
                                        ]);


                        // 18.CARI NILAI TIDAK KENA PAJAK
                        $data_ptkp = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapt->nopeg'");
                            
                        if (!empty($data_ptkp)) {
                            foreach ($data_ptkp as $data_ppt) {
                                $nilaiptkp1pt = $data_ppt->nilai;
                            }
                        } else {
                            $nilaiptkp1pt = '0';
                        }

                        //    19.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakapt = $neto1tahunpt - $nilaiptkp1pt;

                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapt->nopeg)
                                            ->update([
                                                'ptkp' => $nilaiptkp1pt,
                                                'pkp' => $nilaikenapajakapt,
                                            ]);

                        // 20.HITUNG PAJAK PENGHASILAN TERUTANG PAJAK SETAHUN
                        
                        $pajakbulanpt = pajak($nilaikenapajakapt);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpt * -1,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpt,
                                        'userid' => $request->userid,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapt->nopeg)
                                            ->update([
                                                'pajak_setor' => $pajakbulanpt,
                                            ]);
                    }

                    // PekerjaKontrak()
                    $data_pegawai_kontrakkt = MasterPegawai::where('status', 'K')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakkt as $datakt) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datakt->nopeg,
                                'status' => $datakt->kodekeluarga,
                                ]);
                        
                        // 1.CARI NILAI UPAH ALL IN AARD 02

                        $data_sdmallinkt = DB::select("SELECT nilai from sdm_allin where nopek='$datakt->nopeg'");
                        if (!empty($data_sdmallinkt)) {
                            foreach ($data_sdmallinkt as $data_sdmkt) {
                                if ($data_sdmkt->nilai <> "") {
                                    $upahallinkt = $data_sdmkt->nilai;
                                } else {
                                    $upahallinkt ='0';
                                }
                            }
                        } else {
                            $upahallinkt ='0';
                        }
                    
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinkt,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datakt->nopeg)
                                ->update([
                                    'upah' => $upahallinkt,
                                ]);

                        // 2.CARI TUNJANGAN JABATAN JIKA ADA
                        $data_sdmjabatankt =DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datakt->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datakt->nopeg')");
                        if (!empty($data_sdmjabatankt)) {
                            foreach ($data_sdmjabatankt as $data_sdmjabkt) {
                                if ($data_sdmjabkt->tunjangan <> "") {
                                    $tunjabatankt = $data_sdmjabkt->tunjangan;
                                } else {
                                    $tunjabatankt = '0';
                                }
                            }
                        } else {
                            $tunjabatankt = '0';
                        }
                        MasterUpah::insert([
                            'tahun' => $data_tahun,
                            'bulan' => $data_bulan,
                            'nopek' => $datakt->nopeg,
                            'aard' => '03',
                            'jmlcc' => '0',
                            'ccl' => '0',
                            'nilai' => $tunjabatankt,
                            'userid' => $request->userid,
                        ]);

                        TblPajak::where('tahun', $data_tahun)
                        ->where('bulan', $data_bulan)
                        ->where('nopeg', $datakt->nopeg)
                        ->update([
                            'tunjjabat' => $tunjabatankt,
                        ]);


                        // 3.TUNJANGAN DAERAH
                        $data_tunjangandaerahkt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$datakt->nopeg' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$datakt->nopeg')");
                        if (!empty($data_tunjangandaerahkt)) {
                            foreach ($data_tunjangandaerahkt as $data_sdmdaerahkt) {
                                if ($data_sdmdaerahkt->nilai <> "") {
                                    $tunjangandaerahkt = $data_sdmdaerahkt->nilai;
                                } else {
                                    $tunjangandaerahkt = '0';
                                }
                            }
                        } else {
                            $tunjangandaerahkt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '04',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $tunjangandaerahkt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datapt->nopeg)
                            ->update([
                                'tunjdaerah' => $tunjangandaerahkt,
                            ]);

                        // 4.Gapok Kontrak
                        $data_gapokkt = DB::select("SELECT gapok from sdm_gapok where nopeg = '$datakt->nopeg' and mulai=(select max(mulai) from sdm_gapok where nopeg='$datakt->nopeg')");
                        if (!empty($data_gapokkt)) {
                            foreach ($data_gapokkt as $data_gapkt) {
                                if ($datakt->nopeg == 'K00011') {
                                    $gapokkt = '0';
                                } else {
                                    $gapokkt = $data_gapkt->gapok;
                                }
                            }
                        } else {
                            $gapokkt = '0';
                        }

                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datakt->nopeg,
                                        'jumlah' => $upahallinkt,
                                        ]);

                        // 5.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        $data_jamsostekkt = PayTblJamsostek::all();
                        foreach ($data_jamsostekkt as $data_jamkt) {
                            $niljspribadikt = ($data_jamkt->pribadi/100) * $upahallinkt;
                            $niljstaccidentkt = ($data_jamkt->accident/100) * $upahallinkt;
                            $niljspensiunkt = ($data_jamkt->pensiun/100) * $upahallinkt;
                            $niljslifekt = ($data_jamkt->life/100) * $upahallinkt;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadikt * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentkt,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunkt,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifekt,
                                'userid' => $request->userid,
                                ]);

                        // 6.FASILITAS CUTI AARD 06
                        $data_cutikt = DB::select("SELECT a.fasilitas,a.fasilitas  from sdm_master_pegawai a where a.nopeg='$datakt->nopeg'");
                        if (!empty($data_cutikt)) {
                            foreach ($data_cutikt as $data_cutkt) {
                                $tahunkt = date('Y', strtotime($data_cutkt->fasilitas));
                                $bulankt = ltrim(date('m', strtotime($data_cutkt->fasilitas)), '0');
                                $sisatahunkt = $data_tahun - $tahunkt;
                                $sisabulankt = $data_bulan - $bulankt;
                                if ($sisabulankt == '11' and $sisatahunkt == '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } elseif ($sisabulankt == '11' and $sisatahunkt > '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } elseif ($sisabulankt == '-1' and $sisatahunkt > '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } else {
                                    $fasilitaskt = '0';
                                }
                            }
                        } else {
                            $fasilitaskt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '06',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fasilitaskt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datakt->nopeg)
                            ->update([
                                'gapok' => $fasilitaskt,
                            ]);

                        // 7.CARI NILAI LEMBUR AARD 05
                        $data_lemburkt = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datakt->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_lemburkt)) {
                            foreach ($data_lemburkt as $data_sdmkt) {
                                if ($data_sdmkt->totlembur <> "") {
                                    $totallemburkt = $data_sdmkt->totlembur;
                                } else {
                                    $totallemburkt = '0';
                                }
                            }
                        } else {
                            $totallemburkt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '05',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $totallemburkt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datakt->nopeg)
                            ->update([
                                'lembur' => $totallemburkt,
                            ]);

                        // 8.CARI SISA BULAN LALU AARD 07
                        $data_sisanilaikt = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datakt->nopeg' and aard='07'");
                        if (!empty($data_sisanilaikt)) {
                            foreach ($data_sisanilaikt as $data_sdmkt) {
                                if ($data_sdmkt->nilai <> "") {
                                    $fassisakt = $data_sdmkt->nilai;
                                } else {
                                    $fassisakt = '0';
                                }
                            }
                        } else {
                            $fassisakt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '07',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fassisakt,
                                'userid' => $request->userid,
                                ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datakt->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }
                        
                        // 9. POTONG KOPERASI
                        $data_potongankt = DB::select("SELECT * from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakt->nopeg' and aard='28'");
                        if (!empty($data_potongankt)) {
                            foreach ($data_potongankt as $data_potongkt) {
                                $jmlccpotongpinjamkt = $data_potongkt->jmlcc;
                                $cclpotongpinjamkt = $data_potongkt->ccl;
                                if ($data_potongkt->nilai < 0) {
                                    $nilaipotonganpinjamkt = $data_potongkt->nilai;
                                } else {
                                    $nilaipotonganpinjamkt = ($data_potongkt->nilai * -1);
                                }
                            }
                        } else {
                            $nilaipotonganpinjamkt = '0';
                            $jmlccpotongpinjamkt = '0';
                            $cclpotongpinjamkt = '0';
                        }

                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datakt->nopeg,
                                        'aard' => '28',
                                        'jmlcc' => $jmlccpotongpinjamkt,
                                        'ccl' => $cclpotongpinjamkt,
                                        'nilai' => $nilaipotonganpinjamkt,
                                        'userid' => $request->userid,
                                        ]);
                        // 10. HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajikt = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakt->nopeg'");
                        if (!empty($totalgajikt)) {
                            foreach ($totalgajikt as $totalkt) {
                                if ($totalkt->pembulatan1 < 0) {
                                    $sisagajikt = $totalkt->pembulatan2;
                                } else {
                                    $sisagajikt = $totalkt->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajikt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajikt * -1,
                                    'userid' => $request->userid,
                                    ]);

                    
                        $bulan2kt = $data_bulan + 1;
                        if ($bulan2kt >12) {
                            $data_bulan2kt = 1;
                            $data_tahun2kt = $data_tahun + 1;
                        } else {
                            $data_bulan2kt =$bulan2kt;
                            $data_tahun2kt = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2kt,
                                            'bulan' => $data_bulan2kt,
                                            'nopek' => $datakt->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajikt,
                                            'userid' => $request->userid,
                                            ]);

                        // 11.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakkt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakt->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakkt as $kenapkt) {
                            if ($kenapkt->nilai1 <> "") {
                                $nilaikenapajakkt = $kenapkt->nilai1;
                            } else {
                                $nilaikenapajakkt = '0';
                            }
                        }
                        $koreksigajikt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakt->nopeg'");
                        foreach ($koreksigajikt as $koreksigkt) {
                            $kortamkt = $koreksigkt->kortam * -1;
                        }
                        $totalkenapajakkt = (($nilaikenapajakkt + $kortamkt) * 12);
                        $biayajabatanskt = ((5/100)*$totalkenapajakkt);
                        if ($biayajabatanskt > 6000000) {
                            $biayajabatankt = 6000000;
                        } else {
                            $biayajabatankt = $biayajabatanskt;
                        }
                        $neto1tahunkt = $totalkenapajakkt - $biayajabatankt;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakt->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatankt,
                                        ]);
                        // 12.CARI NILAI TIDAK KENA PAJAK
                        $data_ptkpkt = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datakt->nopeg'");
                            
                        if (!empty($data_ptkpkt)) {
                            foreach ($data_ptkpkt as $data_pkt) {
                                if ($data_pkt->nilai <> "") {
                                    $nilaiptkp1kt = $data_pkt->nilai;
                                } else {
                                    $nilaiptkp1kt = '0';
                                }
                            }
                        } else {
                            $nilaiptkp1kt = '0';
                        }

                        // 13.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakakt = $neto1tahunkt - $nilaiptkp1kt;
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $datakt->nopeg)
                                    ->update([
                                        'ptkp' => $nilaiptkp1kt,
                                        'pkp' => $nilaikenapajakakt,
                                    ]);

                        // 14.HITUNG PAJAK PENGHASILAN TERUTANG PAJAK SETAHUN
                
                        $pajakbulankt = pajak($nilaikenapajakakt);
                    
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '26',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $pajakbulankt * -1,
                                'userid' => $request->userid,
                                ]);
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '27',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $pajakbulankt,
                                'userid' => $request->userid,
                                ]);
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $datakt->nopeg)
                                    ->update([
                                        'pajak_setor' => $pajakbulankt,
                                    ]);
                    }

                    // PekerjaBantu()
                    $data_pegawai_kontrakpb = MasterPegawai::where('status', 'B')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakpb as $datapb) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datapb->nopeg,
                                'status' => $datapb->kodekeluarga,
                                ]);
                        
                        // 1.CARI NILAI UPAH ALL IN AARD 02

                        $data_sdmallinpb = DB::select("SELECT nilai from sdm_allin where nopek='$datapb->nopeg'");
                        if (!empty($data_sdmallinpb)) {
                            foreach ($data_sdmallinpb as $data_sdmpb) {
                                if ($data_sdmpb->nilai <> "") {
                                    $upahallinpb = $data_sdmpb->nilai;
                                } else {
                                    $upahallinpb ='0';
                                }
                            }
                        } else {
                            $upahallinpb ='0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinpb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'upah' => $upahallinpb,
                                ]);

                        //2.CARI UPAH TETAP AARD 01
                        $data_sdmutpb = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapb->nopeg')");
                        if (!empty($data_sdmutpb)) {
                            foreach ($data_sdmutpb as $data_sdmpb) {
                                if ($data_sdmpb->ut <> "") {
                                    $upahtetappb = $data_sdmpb->ut;
                                } else {
                                    $upahtetappb = '0';
                                }
                            }
                        } else {
                            $upahtetappb = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '01',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahtetappb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'upah' => $upahtetappb,
                                ]);


                        $data_sdmutpb = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapb->nopeg')");
                        if (!empty($data_sdmutpb)) {
                            foreach ($data_sdmutpb as $data_sdmpb) {
                                if ($data_sdmpb->ut <> "") {
                                    $upahdaerahpb = $data_sdmpb->ut;
                                } else {
                                    $upahdaerahpb = '0';
                                }
                            }
                        } else {
                            $upahdaerahpb = '0';
                        }

                        UtBantu::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'nilai' => $upahdaerahpb,
                                    ]);

                        //4.UPAH TETAP PENSIUN
                        $data_pensiunpb = DB::select("SELECT a.ut from sdm_ut_pensiun a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut_pensiun where nopeg='$datapb->nopeg')");
                        if (!empty($data_pensiunpb)) {
                            foreach ($data_pensiunpb as $data_penpb) {
                                if ($data_penpb->ut <> "") {
                                    $upahtetappensiunpb = $data_penpb->ut;
                                } else {
                                    $upahtetappensiunpb = '0';
                                }
                            }
                        } else {
                            $upahtetappensiunpb = '0';
                        }

                        // 5.FASILITAS CUTI AARD 06
                        $data_cutipb = DB::select("SELECT a.fasilitas,a.fasilitas  from sdm_master_pegawai a where a.nopeg='$datapb->nopeg'");
                        if (!empty($data_cutipb)) {
                            foreach ($data_cutipb as $data_cutpb) {
                                $tahunpb = date('Y', strtotime($data_cutpb->fasilitas));
                                $bulanpb = ltrim(date('m', strtotime($data_cutpb->fasilitas)), '0');
                                $sisatahunpb = $data_tahun - $tahunpb;
                                $sisabulanpb = $data_bulan - $bulanpb;
                                if ($sisabulanpb == '11' and $sisatahunpb == '0') {
                                    $fasilitaspb = '0';
                                //   $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    //   $fasilitaspb = 1.5 * $uangcutipb;
                                } elseif ($sisabulanpb == '11' and $sisatahunpb > '0') {
                                    $fasilitaspb = '0';
                                // $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    // $fasilitaspb = 1.5 * $uangcutipb;
                                } elseif ($sisabulanpb == '-1' and $sisatahunpb > '0') {
                                    $fasilitaspb = '0';
                                // $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    // $fasilitaspb = 1.5 * $uangcutipb;
                                } else {
                                    $fasilitaspb = '0';
                                }
                            }
                        } else {
                            $fasilitaspb = '0';
                        }

                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '06',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fasilitaspb,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datapb->nopeg)
                            ->update([
                                'gapok' => $fasilitaspb,
                            ]);

                        // 6.CARI NILAI LEMBUR AARD 05
                        $data_lemburpb = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapb->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_lemburpb)) {
                            foreach ($data_lemburpb as $data_sdmpb) {
                                if ($data_sdmpb->totlembur <> "") {
                                    $totallemburpb = $data_sdmpb->totlembur;
                                } else {
                                    $totallemburpb = '0';
                                }
                            }
                        } else {
                            $totallemburpb = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '05',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $totallemburpb,
                                'userid' => $request->userid,
                                ]);

                        // 7.CARI SISA BULAN LALU AARD 07
                        $data_sisanilaipb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipb)) {
                            foreach ($data_sisanilaipb as $data_sdmpb) {
                                if ($data_sdmpb->nilai <> "") {
                                    $fassisapb = $data_sdmpb->nilai;
                                } else {
                                    $fassisapb = '0';
                                }
                            }
                        } else {
                            $fassisapb = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '07',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fassisapb,
                                'userid' => $request->userid,
                                ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapb->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 8.CARI NILAI KOREKSI JAMSOSTEK PEKERJA 29
                        $data_koreksijamsostekpb = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='29'");
                        if (!empty($data_koreksijamsostekpb)) {
                            foreach ($data_koreksijamsostekpb as $data_korekpb) {
                                if ($data_korekpb->nilai <> "") {
                                    $iujampekpb = $data_korekpb->nilai;
                                } else {
                                    $iujampekpb = '0';
                                }
                            }
                        } else {
                            $iujampekpb = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '29',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $iujampekpb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        // 9.HITUNG IURAN JAMSOSTEK PRIBADI DAN PERUSAHAAN
                        $data_iuranjamsostekpb = DB::select("SELECT gapok from sdm_gapok where nopeg = '$datapb->nopeg' and mulai=(select max(mulai) from sdm_gapok where nopeg='$datapb->nopeg')");
                        if (!empty($data_iuranjamsostekpb)) {
                            foreach ($data_iuranjamsostekpb as $data_iuranpb) {
                                if ($data_iuranpb->gapok <> "") {
                                    $gapokpb = $data_iuranpb->gapok;
                                } else {
                                    $gapokpb = '0';
                                }
                            }
                        } else {
                            $gapokpb = '0';
                        }
                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'jumlah' => $gapokpb,
                                        ]);

                        // 10.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        $data_persentasejmpb = DB::select("SELECT pribadi,accident,pensiun,life,manulife from pay_tbl_jamsostek");
                        if (!empty($data_persentasejmpb)) {
                            foreach ($data_persentasejmpb as $data_perpb) {
                                $jsmanualifepb = ($data_perpb->life/100);
                                if ($datapb->nopeg <> '709685') {
                                    $niljspribadipb = ($data_perpb->pribadi/100) * $gapokpb;
                                    $niljstaccidentpb = ($data_perpb->accident/100) * $gapokpb;
                                    $niljspensiunpb = ($data_perpb->pensiun/100) * $gapokpb;
                                    $niljslifepb = ($data_perpb->life/100) * $gapokpb;
                                } else {
                                    $niljspribadipb = '0';
                                    $niljstaccidentpb = '0';
                                    $niljspensiunpb = '0';
                                    $niljslifepb = '0';
                                }
                            }
                            $niljsmanualifepb = $jsmanualifepb * $upahtetappb;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadipb * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentpb,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunpb,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifepb,
                                'userid' => $request->userid,
                                ]);
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '13',
                                'lastamount' => '0',
                                'curramount' => $niljsmanualifepb,
                                'userid' => $request->userid,
                                ]);

                        // 11.HITUNG IURAN DANA PENSIUN BEBAN PEKERJA DAN PERUSAHAAN
                        $data_iurandanapensiunpb = DB::select("SELECT pribadi,perusahaan,perusahaan3 from pay_tbl_danapensiun");
                        foreach ($data_iurandanapensiunpb as $data_iuranpb) {
                            $dapenpribadipb = $data_iuranpb->pribadi;
                            $dapenperusahaanpb = $data_iuranpb->perusahaan;
                            $dapenperusahaan3pb = $data_iuranpb->perusahaan3;
                        }
                        if ($datapb->nopeg <> '709685') {
                            // HITUNG IURAN DANA PENSIUN PEKERJA/PRIBADI
                            $nildapenpribadipb = ($dapenpribadipb/100) * $upahtetappensiunpb;
                            // HITUNG IURAN DANA PENSIUN BEBAN PERUSAHAAN
                            $nildapenperusahaanpb = ($dapenperusahaanpb/100) * $upahtetappensiunpb;
                            if ($datapb->nopeg == '709669') {
                                $nildapenbnipb = ($dapenperusahaan3pb/100) * $upahtetappb;
                                MasterBebanPerusahaan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '46',
                                        'lastamount' => '0',
                                        'curramount' => $nildapenbnipb,
                                        'userid' => $request->userid,
                                        ]);
                            } elseif ($datapb->nopeg == '694287') {
                                $bazmapb = (2.5/100)*($upahallinpb - ($nildapenpribadipb+$niljspribadipb));
                                MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '36',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $bazmapb * -1,
                                            'userid' => $request->userid,
                                            ]);
                            } else {
                                MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '36',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => '0',
                                            'userid' => $request->userid,
                                            ]);
                            }
                        } else {
                            $nildapenpribadipb = '0';
                            $nildapenperusahaanpb = '0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '14',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $nildapenpribadipb * -1,
                                    'userid' => $request->userid,
                                    ]);
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '15',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $nildapenperusahaanpb,
                                    'userid' => $request->userid,
                                    ]);
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'dapen_pek' => $nildapenpribadipb,
                                ]);

                        // 11.HITUNG TABUNGAN AARD 16
                        $data_tabunganpb = DB::select("SELECT perusahaan from pay_tbl_tabungan");
                        if (!empty($data_tabunganpb)) {
                            foreach ($data_tabunganpb as $data_tabpb) {
                                if ($datapb->nopeg <> '709685') {
                                    $iuranwajibpb = ($data_tabpb->perusahaan/100) * $upahtetappb;
                                } else {
                                    $iuranwajibpb = '0';
                                }
                            }
                        } else {
                            $iuranwajibpb = '0';
                        }
                        MasterBebanPerusahaan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '16',
                                        'lastamount' => '0',
                                        'curramount' => $iuranwajibpb,
                                        'userid' => $request->userid,
                                        ]);

                        // 12.CARI NILAI POTONGAN PKPP AARD 17 DAN HUTANG PKPP AARD 20
                        $data_nilaipotonganpb = DB::select("SELECT id_pinjaman,jml_pinjaman as jumlah,tenor as lamanya,round(angsuran,0) as angsuran from pay_mtrpkpp where nopek='$datapb->nopeg' and cair ='Y' and lunas<>'Y'");
                        if (!empty($data_nilaipotonganpb)) {
                            foreach ($data_nilaipotonganpb as $data_nilaipb) {
                                $idpinjamanpb = $data_nilaipb->id_pinjaman;
                                $totalpinjamanpb = $data_nilaipb->jumlah;
                                $lamapinjamapb = $data_nilaipb->lamanya;
                                $jumlahangsuranpb = $data_nilaipb->angsuran * -1;
                            }
                            $data_potonganpkpp2pb = DB::select("SELECT round(sum(pokok)) as totalpokok,count(*) as cclke from pay_skdpkpp where nopek='$datapb->nopeg' and tahun <= '$data_tahun' and bulan <= '$data_bulans' and id_pinjaman='$idpinjamanpb'");
                            foreach ($data_potonganpkpp2pb as $data_potongpb) {
                                $totalpokokpb = $data_potongpb->totalpokok;
                                $cclkepb = $data_potongpb->cclke;
                                $sisacicilanpb = $totalpinjamanpb - $totalpokokpb;
                            }
                            if ($cclkepb == '0') {
                                $jumlahangsuranpb = '0';
                            }
                            MasterHutang::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '20',
                                        'lastamount' => '0',
                                        'curramount' => $sisacicilanpb,
                                        'userid' => $request->userid,
                                        ]);
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '17',
                                    'jmlcc' => $lamapinjamapb,
                                    'ccl' => $cclkepb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $lamapinjamapb = '0';
                            $cclkepb = '0';
                            $jumlahangsuranpb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '17',
                                    'jmlcc' => $lamapinjamapb,
                                    'ccl' => $cclkepb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 13.CARI NILAI POTONGAN PANJAR PESANGON AARD 18 DAN HUTANG PPRP AARD 21
                        $data_nilaipotonganpanjarpb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='18'");
                        if (!empty($data_nilaipotonganpanjarpb)) {
                            foreach ($data_nilaipotonganpanjarpb as $data_nilaipb) {
                                $jmlccpotongpprppb = $data_nilaipb->jmlcc;
                                $cclpotongpprppb = $data_nilaipb->ccl;
                                if ($data_nilaipb->bilai < 0) {
                                    $nilaipotongpprppb = $data_nilaipb->nilai * -1;
                                } else {
                                    $nilaipotongpprppb = $data_nilaipb->nilai;
                                }
                            }
                            $data_carihutangpprppb = DB::select("SELECT tahun,bulan,aard,lastamount,curramount from pay_master_hutang where (tahun||bulan)=(select max(tahun||bulan) from pay_master_hutang where nopek='$datapb->nopeg' and aard='21') and nopek='$datapb->nopeg' and aard='21'");
                            foreach ($data_carihutangpprppb as $data_caripb) {
                                $tahunhutangpprppb = $data_caripb->tahun;
                                $bulanhutangpprppb = $data_caripb->bulan;
                                $aardhutangpprppb = $data_caripb->aard;
                                $lasthutangpprppb = $data_caripb->lastamount;
                                $currhutangpprppb = $data_caripb->curramount;
                                $lasthutangpprp1pb = $currhutangpprppb;
                                $currhutangpprp1pb = ($currhutangpprppb - $nilaipotongpprppb);
                            }
                            MasterHutang::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '21',
                                        'lastamount' => $lasthutangpprp1pb,
                                        'curramount' => $currhutangpprp1pb,
                                        'userid' => $request->userid,
                                        ]);
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '18',
                                    'jmlcc' => $jmlccpotongpprppb,
                                    'ccl' => $cclpotongpprppb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $jmlccpotongpprppb = '0';
                            $cclpotongpprppb = '0';
                            $jumlahangsuranpb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '18',
                                    'jmlcc' => $jmlccpotongpprppb,
                                    'ccl' => $cclpotongpprppb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 14.POTONGAN KOPERASI AARD 28
                        $data_potongankoperasipb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='28'");
                        if (!empty($data_potongankoperasipb)) {
                            foreach ($data_potongankoperasipb as $data_potongankoppb) {
                                $jmlccpotongkoperasipb = $data_potongankoppb->jmlcc;
                                $cclpotongkoperasipb = $data_potongankoppb->ccl;
                                if ($data_potongankoppb->nilai < 0) {
                                    $nilaipotongkoperasipb = $data_potongankoppb->nilai;
                                } else {
                                    $nilaipotongkoperasipb = $data_potongankoppb->nilai * -1;
                                }
                            }
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '28',
                                    'jmlcc' => $jmlccpotongkoperasipb,
                                    'ccl' => $cclpotongkoperasipb,
                                    'nilai' => $nilaipotongkoperasipb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $jmlccpotongkoperasipb = '0';
                            $cclpotongkoperasipb = '0';
                            $nilaipotongkoperasipb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '28',
                                    'jmlcc' => $jmlccpotongkoperasipb,
                                    'ccl' => $cclpotongkoperasipb,
                                    'nilai' => $nilaipotongkoperasipb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 15.POTONGAN SUKA DUKA AARD 44
                        $data_potongansukadukapb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='44'");
                        if (!empty($data_potongansukadukapb)) {
                            foreach ($data_potongansukadukapb as $data_potongansukapb) {
                                $jmlccpotongsukadukapb = $data_potongansukapb->jmlcc;
                                $cclpotongsukadukapb = $data_potongansukapb->ccl;
                                if ($data_potongansukapb->nilai < 0) {
                                    $nilaipotongsukadukapb = $data_potongansukapb->nilai;
                                } else {
                                    $nilaipotongsukadukapb = $data_potongansukapb->nilai * -1;
                                }
                                MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '44',
                                    'jmlcc' => $jmlccpotongsukadukapb,
                                    'ccl' => $cclpotongsukadukapb,
                                    'nilai' => $nilaipotongsukadukapb,
                                    'userid' => $request->userid,
                                    ]);
                            }
                        } else {
                            $jmlccpotongsukadukapb = '0';
                            $cclpotongsukadukapb = '0';
                            $nilaipotongsukadukapb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '44',
                                    'jmlcc' => $jmlccpotongsukadukapb,
                                    'ccl' => $cclpotongsukadukapb,
                                    'nilai' => $nilaipotongsukadukapb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 16.HITUNG TOTAL GAJI YANG DI DAPAT
                        $data_hitungtotalgajipb = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg'");
                        if (!empty($data_hitungtotalgajipb)) {
                            foreach ($data_hitungtotalgajipb as $data_hitungtotalpb) {
                                if ($data_hitungtotalpb->pembulatan1 < 0) {
                                    $sisagajipb = $data_hitungtotalpb->pembulatan2;
                                } else {
                                    $sisagajipb = $data_hitungtotalpb->pembulatan1;
                                }
                            }
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajipb * -1,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        $bulan2pb = $data_bulan + 1;
                        if ($bulan2pb > 12) {
                            $data_bulan2pb = 1;
                            $data_tahun2pb = $data_tahun + 1;
                        } else {
                            $data_bulan2pb =$bulan2pb;
                            $data_tahun2pb = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2pb,
                                            'bulan' => $data_bulan2pb,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajipb,
                                            'userid' => $request->userid,
                                            ]);

                        // 17.CARI NILAI YANG KENA PAJAK (BRUTO)
                        $data_kenapajakpb = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapb->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        if (!empty($data_kenapajakpb)) {
                            foreach ($data_kenapajakpb as $data_kenapb) {
                                $nilaikenapajak1pb = $data_kenapb->nilai1;
                            }
                        } else {
                            $nilaikenapajak1pb = '0';
                        }
                        $totkenapajakpb = (($nilaikenapajak1pb + $fasilitaspb)*12);

                        // 18. CARI NILAI PENGURANG HITUNG BIAYA JABATAN
                        $biayajabatan2pb = ((5/100) * $totkenapajakpb);
                        if ($biayajabatan2pb > 6000000) {
                            $biayajabatanpb = 6000000;
                        } else {
                            $biayajabatanpb = $biayajabatan2pb;
                        }
                            
                        $neto1tahunpb =  $totkenapajakpb - $biayajabatanpb;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datapb->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatanpb,
                                        ]);

                        // 19.CARI NILAI TIDAK KENA PAJAK
                        $data_carinilairdkkenapajakpb = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapb->nopeg'");
                        if (!empty($data_carinilairdkkenapajakpb)) {
                            foreach ($data_carinilairdkkenapajakpb as $data_carinilaipb) {
                                $nilaiptkp1pb = $data_carinilaipb->nilai;
                            }
                        } else {
                            $nilaiptkp1pb = '0';
                        }

                        // 20.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakapb = $neto1tahunpb - $nilaiptkp1pb;
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapb->nopeg)
                                            ->update([
                                                'ptkp' => $nilaiptkp1pb,
                                                'pkp' => $nilaikenapajakapb,
                                            ]);

                        // 20.HITUNG PAJAK PENGHASILAN TERUTANG
                            
                        $pajakbulanpb = pajak($nilaikenapajakapb);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpb * -1,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpb,
                                        'userid' => $request->userid,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapb->nopeg)
                                            ->update([
                                                'pajak_setor' => $pajakbulanpb,
                                            ]);
                    }


                    // Pengurus()
                    $data_pegawai_kontraku = MasterPegawai::where('status', 'U')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontraku as $dataps) {
                        TblPajak::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopeg' => $dataps->nopeg,
                                    'status' => $dataps->kodekeluarga,
                                    ]);

                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinps = DB::select("SELECT nilai from sdm_allin where nopek='$dataps->nopeg'");
                        if (!empty($data_sdmallinps)) {
                            foreach ($data_sdmallinps as $data_sdmps) {
                                if ($data_sdmps->nilai <> "") {
                                    $upahallinps = $data_sdmps->nilai;
                                } else {
                                    $upahallinps ='0';
                                }
                            }
                        } else {
                            $upahallinps ='0';
                        }
                            
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $dataps->nopeg,
                                            'aard' => '02',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $upahallinps,
                                            'userid' => $request->userid,
                                            ]);
                                    
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $dataps->nopeg)
                                        ->update([
                                            'upah' => $upahallinps,
                                        ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                            'tahun' => $data_hitung_kor->tahun,
                                            'bulan' => $data_hitung_kor->bulan,
                                            'nopek' => $data_hitung_kor->nopek,
                                            'aard' => $data_hitung_kor->aard,
                                            'jmlcc' => $data_hitung_kor->jmlcc,
                                            'ccl' =>  $data_hitung_kor->ccl,
                                            'nilai' => $data_hitung_kor->nilai*-1,
                                            'userid' => $request->userid,
                                            ]);
                        }

                        // 2.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaips = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$dataps->nopeg' and aard='07'");
                        if (!empty($data_sisanilaips)) {
                            foreach ($data_sisanilaips as $data_sdps) {
                                if ($data_sdps->nilai <> "") {
                                    $fassisaps = $data_sdps->nilai;
                                } else {
                                    $fassisaps = '0';
                                }
                            }
                        } else {
                            $fassisaps = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '07',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $fassisaps,
                                        'userid' => $request->userid,
                                        ]);

                        // 3.CARI NILAI KOREKSI LAIN AARD 08
                        $data_carinilaikoreksips = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg' and aard='08'");
                        if (!empty($data_carinilaikoreksips)) {
                            foreach ($data_carinilaikoreksips as $data_carinilaips) {
                                if ($data_carinilaips->nilai <> "") {
                                    $faslainps = $data_carinilaips->nilai;
                                } else {
                                    $faslainps = '0';
                                }
                            }
                        } else {
                            $faslainps = '0';
                        }

                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '08',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $faslainps,
                                        'userid' => $request->userid,
                                        ]);

                        // 4.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajips = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg'");
                        if (!empty($totalgajips)) {
                            foreach ($totalgajips as $totalps) {
                                if ($totalps->pembulatan1 < 0) {
                                    $sisagajips = $totalps->pembulatan2;
                                } else {
                                    $sisagajips = $totalps->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajips = '0';
                        }
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $dataps->nopeg,
                                            'aard' => '23',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajips * -1,
                                            'userid' => $request->userid,
                                            ]);

                            
                        $bulan2ps = $data_bulan + 1;
                        if ($bulan2ps >12) {
                            $data_bulan2ps = 1;
                            $data_tahun2ps = $data_tahun + 1;
                        } else {
                            $data_bulan2ps =$bulan2ps;
                            $data_tahun2ps = $data_tahun;
                        }
                        PayKoreksi::insert([
                                                    'tahun' => $data_tahun2ps,
                                                    'bulan' => $data_bulan2ps,
                                                    'nopek' => $dataps->nopeg,
                                                    'aard' => '07',
                                                    'jmlcc' => '0',
                                                    'ccl' => '0',
                                                    'nilai' => $sisagajips,
                                                    'userid' => $request->userid,
                                                    ]);

                        // 5.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakps = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$dataps->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakps as $kenapps) {
                            if ($kenapps->nilai1 <> "") {
                                $nilaikenapajak1ps = $kenapps->nilai1;
                            } else {
                                $nilaikenapajak1ps = '0';
                            }
                        }
                        $nilaikenapajakaps = $nilaikenapajak1ps;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $dataps->nopeg)
                                        ->update([
                                            'pkp' => $nilaikenapajakaps,
                                        ]);

                        if ($dataps->nopeg == "kom9" or $dataps->nopeg == "kom4") {
                            $tunjpajakps = (15/100) * $nilaikenapajakaps;
                            $potpajakps = ((30/100)*($nilaikenapajakaps + $tunjpajakps));
                        } elseif ($dataps->nopeg == "komut1") {
                            $tunjpajakps = (15/100) * $nilaikenapajakaps;
                            $potpajakps = (30/100) * ($nilaikenapajakaps + $tunjpajakps);
                        } elseif ($dataps->nopeg == "kom5") {
                            $tunjpajakps = (5/100) * $nilaikenapajakaps;
                            $potpajakps = (15/100) * ($nilaikenapajakaps + $tunjpajakps);
                        } else {
                            $tunjpajakps = (5/100) * $nilaikenapajakaps;
                            $potpajakps = (30/100) * ($nilaikenapajakaps + $tunjpajakps);
                        }
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $dataps->nopeg,
                                            'aard' => '27',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $tunjpajakps,
                                            'userid' => $request->userid,
                                            ]);
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $dataps->nopeg,
                                            'aard' => '26',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $potpajakps,
                                            'userid' => $request->userid,
                                            ]);

                                
                            

                        $data_caripajak1ps = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$dataps->nopeg' and aard='27'");
                        foreach ($data_caripajak1ps as $data_pajak1ps) {
                            $tunjpaps = $data_pajak1ps->pajaknya;
                        }
                                
                        $data_caripajak2ps = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$dataps->nopeg' and aard='26'");
                        foreach ($data_caripajak2ps as $data_pajak2ps) {
                            $potpaps = $data_pajak2ps->pajaknya;
                        }

                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $dataps->nopeg)
                                        ->where('aard', '27')
                                        ->update([
                                            'nilai' => $tunjpaps,
                                        ]);
                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $dataps->nopeg)
                                        ->where('aard', '26')
                                        ->update([
                                            'nilai' => $potpaps * -1,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $dataps->nopeg)
                                        ->update([
                                            'pajak_setor' => $tunjpaps,
                                        ]);
                    }
                        

                    // Komite()
                    $data_pegawai_kontrako = MasterPegawai::where('status', 'O')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrako as $datakm) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datakm->nopeg,
                                'status' => $datakm->kodekeluarga,
                                ]);

                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinkm = DB::select("SELECT nilai from sdm_allin where nopek='$datakm->nopeg'");
                        if (!empty($data_sdmallinkm)) {
                            foreach ($data_sdmallinkm as $data_sdmkm) {
                                if ($data_sdmkm->nilai <> "") {
                                    $upahallinkm = $data_sdmkm->nilai;
                                } else {
                                    $upahallinkm ='0';
                                }
                            }
                        } else {
                            $upahallinkm ='0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinkm,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datakm->nopeg)
                                ->update([
                                    'upah' => $upahallinkm,
                                ]);

                        // 2.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajikm = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakm->nopeg'");
                        if (!empty($totalgajikm)) {
                            foreach ($totalgajikm as $totalkm) {
                                if ($totalkm->pembulatan1 < 0) {
                                    $sisagajikm = $totalkm->pembulatan2;
                                } else {
                                    $sisagajikm = $totalkm->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajikm = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajikm * -1,
                                    'userid' => $request->userid,
                                    ]);

                    

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakm->nopeg'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }
                        
                        $bulan2km = $data_bulan + 1;
                        if ($bulan2km >12) {
                            $data_bulan2km = 1;
                            $data_tahun2km = $data_tahun + 1;
                        } else {
                            $data_bulan2km =$bulan2km;
                            $data_tahun2km = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2km,
                                            'bulan' => $data_bulan2km,
                                            'nopek' => $datakm->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajikm,
                                            'userid' => $request->userid,
                                            ]);

                        // 3.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakkm = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakm->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakkm as $kenapkm) {
                            if ($kenapkm->nilai1 <> "") {
                                $nilaikenapajakkm = $kenapkm->nilai1;
                            } else {
                                $nilaikenapajakkm = '0';
                            }
                        }
                        $nilaikenapajakkma = $nilaikenapajakkm;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakm->nopeg)
                                        ->update([
                                            'pkp' => $nilaikenapajakkma,
                                        ]);

                        $tunjpajakkm = ((5/100) * $nilaikenapajakkma);
                        $potpajakkm = ((30/100) * ($nilaikenapajakkma + $tunjpajakkm));
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '27',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjpajakkm,
                                    'userid' => $request->userid,
                                    ]);
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '26',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $potpajakkm,
                                    'userid' => $request->userid,
                                    ]);
                        $data_caripajak1km = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$datakm->nopeg' and aard='27'");
                        foreach ($data_caripajak1km as $data_pajak1km) {
                            $tunjpakm = $data_pajak1km->pajaknya;
                        }
                                
                        $data_caripajak2km = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$datakm->nopeg' and aard='26'");
                        foreach ($data_caripajak2km as $data_pajak2km) {
                            $potpakm = $data_pajak2km->pajaknya;
                        }

                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $datakm->nopeg)
                                        ->where('aard', '27')
                                        ->update([
                                            'nilai' => $tunjpakm,
                                        ]);
                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $datakm->nopeg)
                                        ->where('aard', '26')
                                        ->update([
                                            'nilai' => $potpakm * -1,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakm->nopeg)
                                        ->update([
                                            'pajak_setor' => $tunjpakm,
                                        ]);
                    }

                    // PekerjaBaru()
                    $data_pegawai_kontrakn = MasterPegawai::where('status', 'N')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakn as $datapj) {
                        $status1pj = $datapj->status;
                        $kodekelpj = $datapj->kodekeluarga;
                        $tglaktifpj = date("j", strtotime($datapj->tglaktifdns));
                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinpj = DB::select("SELECT nilai from sdm_allin where nopek='$datapj->nopeg'");
                        if (!empty($data_sdmallinpj)) {
                            foreach ($data_sdmallinpj as $data_sdmpj) {
                                if ($data_sdmpj->nilai <> "") {
                                    $upahmentahpj = $data_sdmpj->nilai;
                                    $upahallinpj = ((30 - $tglaktifpj)/30) * $upahmentahpj;
                                } else {
                                    $upahallinpj ='0';
                                }
                            }
                        } else {
                            $upahallinpj ='0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapj->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinpj,
                                    'userid' => $request->userid,
                                    ]);

                        // 2.CARI TUNJANGAN JABATAN JIKA ADA
                        $data_tunjanganjabatanpj = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datapj->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datapj->nopeg')");
                        if (!empty($data_tunjanganjabatanpj)) {
                            foreach ($data_tunjanganjabatanpj as $data_tunjangpj) {
                                if ($data_tunjangpj->tunjangan <> "") {
                                    if ($data_tunjangpj->goljob <= '03') {
                                        $tunjangpj = $data_tunjangpj->tunjangan;
                                        $tunjjabatanpj = ((30 - $tglaktifpj)/30) * $tunjangpj;
                                    } else {
                                        $tunjjabatanpj = '0';
                                    }
                                } else {
                                    $tunjjabatanpj = '0';
                                }
                            }
                        } else {
                            $tunjjabatanpj = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapj->nopeg,
                                    'aard' => '03',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjjabatanpj,
                                    'userid' => $request->userid,
                                    ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapj->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                        'tahun' => $data_hitung_kor->tahun,
                                        'bulan' => $data_hitung_kor->bulan,
                                        'nopek' => $data_hitung_kor->nopek,
                                        'aard' => $data_hitung_kor->aard,
                                        'jmlcc' => $data_hitung_kor->jmlcc,
                                        'ccl' =>  $data_hitung_kor->ccl,
                                        'nilai' => $data_hitung_kor->nilai*-1,
                                        'userid' => $request->userid,
                                        ]);
                        }
                                    

                        // 3.CARI NILAI LEMBUR AARD 05
                        $data_carinilailemburpj = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapj->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_carinilailemburpj)) {
                            foreach ($data_carinilailemburpj as $data_carilemburpj) {
                                if ($data_carilemburpj->totlembur <> "") {
                                    $totallemburpj = $data_carilemburpj->totlembur;
                                } else {
                                    $totallemburpj = '0';
                                }
                            }
                        } else {
                            $totallemburpj = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapj->nopeg,
                                    'aard' => '05',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $totallemburpj,
                                    'userid' => $request->userid,
                                    ]);

                        // 4.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaipj = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipj)) {
                            foreach ($data_sisanilaipj as $data_sdmpj) {
                                if ($data_sdmpj->nilai <> "") {
                                    $fassisapj = $data_sdmpj->nilai;
                                } else {
                                    $fassisapj = '0';
                                }
                            }
                        } else {
                            $fassisapj = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapj->nopeg,
                                    'aard' => '07',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fassisapj,
                                    'userid' => $request->userid,
                                    ]);

                        // 5.CARI NILAI KOREKSI LAIN AARD 08
                        $data_carinilaikoreksipj = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='08'");
                        if (!empty($data_carinilaikoreksipj)) {
                            foreach ($data_carinilaikoreksipj as $data_carinilaipj) {
                                if ($data_carinilaipj->nilai <> "") {
                                    $faslainpj = $data_carinilaipj->nilai;
                                } else {
                                    $faslainpj = '0';
                                }
                            }
                        } else {
                            $faslainpj = '0';
                        }

                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapj->nopeg,
                                        'aard' => '08',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $faslainpj,
                                        'userid' => $request->userid,
                                        ]);

                        // 6.CARI NILAI POTONGAN LAIN AARD 19 DAN HUTANG LAIN AARD 22
                        $data_nilaipotonganaard19pj = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='19'");
                        if (!empty($data_nilaipotonganaard19pj)) {
                            foreach ($data_nilaipotonganaard19pj as $data_nilaiaardpj) {
                                $jmlccpotonglainpj = $data_nilaiaardpj->jmlcc;
                                $cclpotonglainpj = $data_nilaiaardpj->ccl;
                                if ($data_nilaiaardpj->nilai < 0) {
                                    $nilaipotonglainpj = $data_nilaiaardpj->nilai;
                                } else {
                                    $nilaipotonglainpj = $data_nilaiaardpj->nilai * -1;
                                }
                                $data_carihutanglainpj = DB::select("SELECT tahun,bulan,aard,lastamount,curramount from pay_master_hutang where (tahun||bulan)=(select max(tahun||bulan) from pay_master_hutang where nopek='$datapj->nopeg' and aard='22') and nopek='$datapj->nopeg' and aard='22'");
                                foreach ($data_carihutanglainpj as $data_carpj) {
                                    $tahunhutanglainpj = $data_carpj->tahun;
                                    $bulanhutanglainpj = $data_carpj->bulan;
                                    $aardhutanglainpj =   $data_carpj->aard;
                                    $lasthutanglainpj = $data_carpj->lastamount;
                                    $currhutanglainpj = $data_carpj->curramount;
                                        
                                    $lasthutanglain1pj = $currhutanglainpj;
                                    $currhutanglain1pj = ($currhutanglainpj + $nilaipotonglainpj);
                                    MasterHutang::insert([
                                                    'tahun' => $data_tahun,
                                                    'bulan' => $data_bulan,
                                                    'nopek' => $datapj->nopeg,
                                                    'aard' => '22',
                                                    'lastamount' => $lasthutanglain1pj,
                                                    'curramount' => $currhutanglain1pj,
                                                    'userid' => $request->userid,
                                                    ]);
                                    MasterUpah::insert([
                                                'tahun' => $data_tahun,
                                                'bulan' => $data_bulan,
                                                'nopek' => $datapj->nopeg,
                                                'aard' => '19',
                                                'jmlcc' => $jmlccpotonglainpj,
                                                'ccl' => $cclpotonglainpj,
                                                'nilai' => $nilaipotonglainpj,
                                                'userid' => $request->userid,
                                                ]);
                                }
                            }
                        } else {
                            $jmlccpotonglainpj = '0';
                            $cclpotonglainpj = '0';
                            $nilaipotonglainpj = '0';
                            MasterUpah::insert([
                                                'tahun' => $data_tahun,
                                                'bulan' => $data_bulan,
                                                'nopek' => $datapj->nopeg,
                                                'aard' => '19',
                                                'jmlcc' => $jmlccpotonglainpj,
                                                'ccl' => $cclpotonglainpj,
                                                'nilai' => $nilaipotonglainpj,
                                                'userid' => $request->userid,
                                                ]);
                        }

                        // 7.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajipj = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg'");
                        if (!empty($totalgajipj)) {
                            foreach ($totalgajipj as $totalpj) {
                                if ($totalpj->pembulatan1 < 0) {
                                    $sisagajipj = $totalpj->pembulatan2;
                                } else {
                                    $sisagajipj = $totalpj->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajipj = '0';
                        }
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapj->nopeg,
                                            'aard' => '23',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajipj * -1,
                                            'userid' => $request->userid,
                                            ]);

                            
                        $bulan2pj = $data_bulan + 1;
                        if ($bulan2pj >12) {
                            $data_bulan2pj = 1;
                            $data_tahun2pj = $data_tahun + 1;
                        } else {
                            $data_bulan2pj =$bulan2pj;
                            $data_tahun2pj = $data_tahun;
                        }
                        PayKoreksi::insert([
                                                    'tahun' => $data_tahun2pj,
                                                    'bulan' => $data_bulan2pj,
                                                    'nopek' => $datapj->nopeg,
                                                    'aard' => '07',
                                                    'jmlcc' => '0',
                                                    'ccl' => '0',
                                                    'nilai' => $sisagajipj,
                                                    'userid' => $request->userid,
                                                    ]);

                        // 8.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakpj = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapj->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakpj as $kenappj) {
                            if ($kenappj->nilai1 <> "") {
                                $nilaikenapajak1pj = $kenappj->nilai1;
                            } else {
                                $nilaikenapajak1pj = '0';
                            }
                        }
                        $totkenapajakpj = $nilaikenapajak1pj * 12;
                                
                        // 9.CARI NILAI TIDAK KENA PAJAK
                        $datatdkkenapajakpj = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapj->nopeg'");
                        foreach ($datatdkkenapajakpj as $tdkkenappj) {
                            if ($tdkkenappj->nilai1 <> "") {
                                $nilaiptkp1pj = $tdkkenappj->nilai1;
                            } else {
                                $nilaiptkp1pj = '0';
                            }
                        }
                        // 9.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakpj = $totkenapajakpj - $nilaiptkp1pj;
                                
                        $pajakbulanpj = pajak($nilaikenapajakpj);
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapj->nopeg,
                                            'aard' => '26',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $pajakbulanpj * -1,
                                            'userid' => $request->userid,
                                            ]);
                        MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapj->nopeg,
                                            'aard' => '27',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $pajakbulanpj,
                                            'userid' => $request->userid,
                                            ]);
                    }
                } elseif ($request->prosesupah == 'C') {

                        // PekerjaTetap()
                    // PekerjaTetap()
                    $data_pegawaic = MasterPegawai::where('status', 'C')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawaic as $datapt) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datapt->nopeg,
                                'status' => $datapt->kodekeluarga,
                                ]);

                        // 1.CARI UPAH TETAP AARD 01
                        $data_sdmutpt = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapt->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapt->nopeg')");
                        if (!empty($data_sdmutpt)) {
                            foreach ($data_sdmutpt as $data_sdmpt) {
                                if ($data_sdmpt->ut <> "") {
                                    $upahtetappt = $data_sdmpt->ut;
                                } else {
                                    $upahtetappt = '0';
                                }
                            }
                        } else {
                            $upahtetappt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '01',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahtetappt,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'upah' => $upahtetappt,
                                ]);

                        // 2.TUNJANGAN JABATAN AARD 03
                        $data_sdmjabatanpt = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datapt->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datapt->nopeg')");
                        if (!empty($data_sdmjabatanpt)) {
                            foreach ($data_sdmjabatanpt as $data_sdmjabpt) {
                                if ($data_sdmjabpt->tunjangan <> "") {
                                    $tunjabatanpt = $data_sdmjabpt->tunjangan;
                                } else {
                                    $tunjabatanpt = '0';
                                }
                            }
                        } else {
                            $tunjabatanpt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '03',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjabatanpt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'tunjjabat' => $tunjabatanpt,
                                ]);

                        // 3.TUNJANGAN BIAYA HIDUP AARD AARD = 04
                        $data_sdmtunjanganpt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$datapt->nopeg' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$datapt->nopeg')");
                        if (!empty($data_sdmtunjanganpt)) {
                            foreach ($data_sdmtunjanganpt as $data_sdmpt) {
                                if ($data_sdmpt->nilai <> "") {
                                    $tunjabatanhiduppt = $data_sdmpt->nilai;
                                } else {
                                    $tunjabatanhiduppt = '0';
                                }
                            }
                        } else {
                            $tunjabatanhiduppt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '04',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjabatanhiduppt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'tunjdaerah' => $tunjabatanhiduppt,
                                ]);

                        // 4.FASILITAS CUTI AARD 06
                        $data_sdmfcutipt = MasterPegawai::where('nopeg', $datapt->nopeg)->get();
                        foreach ($data_sdmfcutipt as $data_sdmpt) {
                            $tahunpt = date('Y', strtotime($data_sdmpt->fasilitas));
                            $bulanpt = ltrim(date('m', strtotime($data_sdmpt->fasilitas)), '0');
                            $sisatahunpt = $data_tahun - $tahunpt;
                            $sisabulanpt = $data_bulan - $bulanpt;
                        }
                        if ($sisabulanpt == '11' and $sisatahunpt == '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } elseif ($sisabulanpt == '11' and $sisatahunpt > '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } elseif ($sisabulanpt == '-1' and $sisatahunpt > '0') {
                            $uangcutipt = $upahtetappt + $tunjabatanpt + $tunjabatanhiduppt;
                            $fasilitaspt = 1.5 * $uangcutipt;
                        } else {
                            $fasilitaspt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '06',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fasilitaspt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'gapok' => $fasilitaspt,
                                ]);

                        // 5.CARI NILAI LEMBUR AARD 05
                        $data_lemburpt = DB::select("SELECT Sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapt->nopeg' And bulan = '$data_bulan' AND tahun='$data_tahun'");
                        if (!empty($data_lemburpt)) {
                            foreach ($data_lemburpt as $data_sdmpt) {
                                if ($data_sdmpt->totlembur <> "") {
                                    $totallemburpt = $data_sdmpt->totlembur;
                                } else {
                                    $totallemburpt = '0';
                                }
                            }
                        } else {
                            $totallemburpt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '05',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $totallemburpt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapt->nopeg)
                                ->update([
                                    'lembur' => $totallemburpt,
                                ]);

                        // 6.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaipt = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapt->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipt)) {
                            foreach ($data_sisanilaipt as $data_sdmpt) {
                                if ($data_sdmpt->nilai <> "") {
                                    $fassisapt = $data_sdmpt->nilai;
                                } else {
                                    $fassisapt = '0';
                                }
                            }
                        } else {
                            $fassisapt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '07',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fassisapt,
                                    'userid' => $request->userid,
                                    ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapt->nopeg' And bulan = '$data_bulan' AND tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                        'tahun' => $data_hitung_kor->tahun,
                                        'bulan' => $data_hitung_kor->bulan,
                                        'nopek' => $data_hitung_kor->nopek,
                                        'aard' => $data_hitung_kor->aard,
                                        'jmlcc' => $data_hitung_kor->jmlcc,
                                        'ccl' =>  $data_hitung_kor->ccl,
                                        'nilai' => $data_hitung_kor->nilai*-1,
                                        'userid' => $request->userid,
                                        ]);
                        }

                        //7.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'jumlah' => $upahtetappt,
                                        ]);
                        $data_jamsostekpt = PayTblJamsostek::all();
                        foreach ($data_jamsostekpt as $data_jampt) {
                            $niljspribadipt = ($data_jampt->pribadi/100) * $upahtetappt;
                            $niljstaccidentpt = ($data_jampt->accident/100) * $upahtetappt;
                            $niljspensiunpt = ($data_jampt->pensiun/100) * $upahtetappt;
                            $niljslifept = ($data_jampt->life/100) * $upahtetappt;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadipt * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentpt,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapt->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunpt,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifept,
                                'userid' => $request->userid,
                                ]);
                            
                        //9.HITUNG IURAN DANA PENSIUN BNI SIMPONI 46
                        $data_danapensiunpt = PayDanaPensiun::all();
                        foreach ($data_danapensiunpt as $data_danapt) {
                            $nildapenbnipt = ($data_danapt->perusahaan3/100) * $upahtetappt;
                        }
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '46',
                                'lastamount' => '0',
                                'curramount' => $nildapenbnipt,
                                'userid' => $request->userid,
                                ]);

                        // 10.HITUNG TABUNGAN AJTM AARD 16
                        $data_tabunganpt = PayTabungan::all();
                        foreach ($data_tabunganpt as $data_tabpt) {
                            $iuranwajibpt = ($data_tabpt->perusahaan/100) * $upahtetappt;
                        }
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapt->nopeg,
                                'aard' => '16',
                                'lastamount' => '0',
                                'curramount' => $iuranwajibpt,
                                'userid' => $request->userid,
                                ]);

                        // 11.CARI NILAI POTONGAN PINJAMAN AARD 19
                        $data_potonganpt = DB::select("SELECT * from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapt->nopeg' and aard='19'");
                        if (!empty($data_potonganpt)) {
                            foreach ($data_potonganpt as $data_potongpt) {
                                $jmlccpotongpinjampt = $data_potongpt->jmlcc;
                                $cclpotongpinjampt = $data_potongpt->ccl;
                                if ($data_potongpt->nilai < 0) {
                                    $nilaipotonganpinjampt = ($data_potongpt->nilai * -1);
                                } else {
                                    $nilaipotonganpinjampt = $data_potongpt->nilai;
                                }
                            }
                        } else {
                            $nilaipotonganpinjampt = '0';
                            $jmlccpotongpinjampt = '0';
                            $cclpotongpinjampt = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '19',
                                        'jmlcc' => $jmlccpotongpinjampt,
                                        'ccl' => $cclpotongpinjampt,
                                        'nilai' => $nilaipotonganpinjampt * -1,
                                        'userid' => $request->userid,
                                        ]);
                            
                        // 12.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajipt = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapt->nopeg'");
                        if (!empty($totalgajipt)) {
                            foreach ($totalgajipt as $totalpt) {
                                if ($totalpt->pembulatan1 < 0) {
                                    $sisagajipt = $totalpt->pembulatan2;
                                } else {
                                    $sisagajipt = $totalpt->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajipt = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '23',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $sisagajipt * -1,
                                        'userid' => $request->userid,
                                        ]);

                        
                        $bulan2pt = $data_bulan + 1;
                        if ($bulan2pt > 12) {
                            $data_bulan2pt = 1;
                            $data_tahun2pt = $data_tahun + 1;
                        } else {
                            $data_bulan2pt =$bulan2pt;
                            $data_tahun2pt = $data_tahun;
                        }
                        // 15.SIMPAN NILAI PEMBULATAN KE TABEL KOREKSI AARD 17 SISA BULAN LALU
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2pt,
                                            'bulan' => $data_bulan2pt,
                                            'nopek' => $datapt->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajipt,
                                            'userid' => $request->userid,
                                            ]);

                        // 16.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakpt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapt->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakpt as $kenappt) {
                            $nilaikenapajakpt = $kenappt->nilai1;
                        }
                        $koreksigajipt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapt->nopeg'");
                        foreach ($koreksigajipt as $koreksigpt) {
                            $kortampt = $koreksigpt->kortam * -1;
                        }

                        $totalkenapajakpt = ($nilaikenapajakpt + $niljstaccidentpt + $niljslifept + $fasilitaspt+ $kortampt)*12;

                        // 17.CARI NILAI PENGURANG
                        $biayajabatanspt = ((5/100)*$totalkenapajakpt);
                        if ($biayajabatanspt > 6000000) {
                            $biayajabatanpt = 6000000;
                        } else {
                            $biayajabatanpt = $biayajabatanspt;
                        }
                                
                        $neto1tahunpt = $totalkenapajakpt - $biayajabatanpt;
                            
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datapt->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatanpt,
                                        ]);

                        // 18.CARI NILAI TIDAK KENA PAJAK
                        $data_ptkp = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapt->nopeg'");
                            
                        if (!empty($data_ptkp)) {
                            foreach ($data_ptkp as $data_ppt) {
                                $nilaiptkp1pt = $data_ppt->nilai;
                            }
                        } else {
                            $nilaiptkp1pt = '0';
                        }

                        //    19.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakapt = $neto1tahunpt - $nilaiptkp1pt;
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapt->nopeg)
                                            ->update([
                                                'ptkp' => $nilaiptkp1pt,
                                                'pkp' => $nilaikenapajakapt,
                                            ]);

                        // 20.HITUNG PAJAK PENGHASILAN TERUTANG PAJAK SETAHUN
                        
                        $pajakbulanpt = pajak($nilaikenapajakapt);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpt * -1,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapt->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpt,
                                        'userid' => $request->userid,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapt->nopeg)
                                            ->update([
                                                'pajak_setor' => $pajakbulanpt,
                                            ]);
                    }
                } elseif ($request->prosesupah == 'K') {

                    // PekerjaKontrak()
                    $data_pegawai_kontrakkt = MasterPegawai::where('status', 'K')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakkt as $datakt) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datakt->nopeg,
                                'status' => $datakt->kodekeluarga,
                                ]);
                        
                        // 1.CARI NILAI UPAH ALL IN AARD 02

                        $data_sdmallinkt = DB::select("SELECT nilai from sdm_allin where nopek='$datakt->nopeg'");
                        if (!empty($data_sdmallinkt)) {
                            foreach ($data_sdmallinkt as $data_sdmkt) {
                                if ($data_sdmkt->nilai <> "") {
                                    $upahallinkt = $data_sdmkt->nilai;
                                } else {
                                    $upahallinkt ='0';
                                }
                            }
                        } else {
                            $upahallinkt ='0';
                        }
                    
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinkt,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datakt->nopeg)
                                ->update([
                                    'upah' => $upahallinkt,
                                ]);

                        // 2.CARI TUNJANGAN JABATAN JIKA ADA
                        $data_sdmjabatankt =DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datakt->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datakt->nopeg')");
                        if (!empty($data_sdmjabatankt)) {
                            foreach ($data_sdmjabatankt as $data_sdmjabkt) {
                                if ($data_sdmjabkt->tunjangan <> "") {
                                    $tunjabatankt = $data_sdmjabkt->tunjangan;
                                } else {
                                    $tunjabatankt = '0';
                                }
                            }
                        } else {
                            $tunjabatankt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '03',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjabatankt,
                                    'userid' => $request->userid,
                                    ]);

                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datakt->nopeg)
                                ->update([
                                    'tunjjabat' => $tunjabatankt,
                                ]);


                        // 3.TUNJANGAN DAERAH
                        $data_tunjangandaerahkt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$datakt->nopeg' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$datakt->nopeg')");
                        if (!empty($data_tunjangandaerahkt)) {
                            foreach ($data_tunjangandaerahkt as $data_sdmdaerahkt) {
                                if ($data_sdmdaerahkt->nilai <> "") {
                                    $tunjangandaerahkt = $data_sdmdaerahkt->nilai;
                                } else {
                                    $tunjangandaerahkt = '0';
                                }
                            }
                        } else {
                            $tunjangandaerahkt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '04',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $tunjangandaerahkt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datakt->nopeg)
                            ->update([
                                'tunjdaerah' => $tunjangandaerahkt,
                            ]);

                        // 4.Gapok Kontrak
                        $data_gapokkt = DB::select("SELECT gapok from sdm_gapok where nopeg = '$datakt->nopeg' and mulai=(select max(mulai) from sdm_gapok where nopeg='$datakt->nopeg')");
                        if (!empty($data_gapokkt)) {
                            foreach ($data_gapokkt as $data_gapkt) {
                                if ($datakt->nopeg == 'K00011') {
                                    $gapokkt = '0';
                                } else {
                                    $gapokkt = $data_gapkt->gapok;
                                }
                            }
                        } else {
                            $gapokkt = '0';
                        }

                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datakt->nopeg,
                                        'jumlah' => $upahallinkt,
                                        ]);

                        // 5.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        $data_jamsostekkt = PayTblJamsostek::all();
                        foreach ($data_jamsostekkt as $data_jamkt) {
                            $niljspribadikt = ($data_jamkt->pribadi/100) * $upahallinkt;
                            $niljstaccidentkt = ($data_jamkt->accident/100) * $upahallinkt;
                            $niljspensiunkt = ($data_jamkt->pensiun/100) * $upahallinkt;
                            $niljslifekt = ($data_jamkt->life/100) * $upahallinkt;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadikt * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentkt,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunkt,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifekt,
                                'userid' => $request->userid,
                                ]);

                        // 6.FASILITAS CUTI AARD 06
                        $data_cutikt = DB::select("SELECT a.fasilitas,a.fasilitas  from sdm_master_pegawai a where a.nopeg='$datakt->nopeg'");
                        if (!empty($data_cutikt)) {
                            foreach ($data_cutikt as $data_cutkt) {
                                $tahunkt = date('Y', strtotime($data_cutkt->fasilitas));
                                $bulankt = ltrim(date('m', strtotime($data_cutkt->fasilitas)), '0');
                                $sisatahunkt = $data_tahun - $tahunkt;
                                $sisabulankt = $data_bulan - $bulankt;
                                if ($sisabulankt == '11' and $sisatahunkt == '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } elseif ($sisabulankt == '11' and $sisatahunkt > '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } elseif ($sisabulankt == '-1' and $sisatahunkt > '0') {
                                    $uangcutikt = $upahallinkt + $tunjabatankt + $tunjangandaerahkt;
                                    $fasilitaskt = 1.5 * $uangcutikt;
                                } else {
                                    $fasilitaskt = '0';
                                }
                            }
                        } else {
                            $fasilitaskt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '06',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fasilitaskt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datakt->nopeg)
                            ->update([
                                'gapok' => $fasilitaskt,
                            ]);

                        // 7.CARI NILAI LEMBUR AARD 05
                        $data_lemburkt = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datakt->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_lemburkt)) {
                            foreach ($data_lemburkt as $data_sdmkt) {
                                if ($data_sdmkt->totlembur <> "") {
                                    $totallemburkt = $data_sdmkt->totlembur;
                                } else {
                                    $totallemburkt = '0';
                                }
                            }
                        } else {
                            $totallemburkt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '05',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $totallemburkt,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datakt->nopeg)
                            ->update([
                                'lembur' => $totallemburkt,
                            ]);

                        // 8.CARI SISA BULAN LALU AARD 07
                        $data_sisanilaikt = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datakt->nopeg' and aard='07'");
                        if (!empty($data_sisanilaikt)) {
                            foreach ($data_sisanilaikt as $data_sdmkt) {
                                if ($data_sdmkt->nilai <> "") {
                                    $fassisakt = $data_sdmkt->nilai;
                                } else {
                                    $fassisakt = '0';
                                }
                            }
                        } else {
                            $fassisakt = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '07',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fassisakt,
                                'userid' => $request->userid,
                                ]);
                                
                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datakt->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }


                        // 9. POTONG KOPERASI
                        $data_potongankt = DB::select("SELECT * from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakt->nopeg' and aard='28'");
                        if (!empty($data_potongankt)) {
                            foreach ($data_potongankt as $data_potongkt) {
                                $jmlccpotongpinjamkt = $data_potongkt->jmlcc;
                                $cclpotongpinjamkt = $data_potongkt->ccl;
                                if ($data_potongkt->nilai < 0) {
                                    $nilaipotonganpinjamkt = $data_potongkt->nilai;
                                } else {
                                    $nilaipotonganpinjamkt = ($data_potongkt->nilai * -1);
                                }
                            }
                        } else {
                            $nilaipotonganpinjamkt = '0';
                            $jmlccpotongpinjamkt = '0';
                            $cclpotongpinjamkt = '0';
                        }

                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datakt->nopeg,
                                        'aard' => '28',
                                        'jmlcc' => $jmlccpotongpinjamkt,
                                        'ccl' => $cclpotongpinjamkt,
                                        'nilai' => $nilaipotonganpinjamkt,
                                        'userid' => $request->userid,
                                        ]);
                        // 10. HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajikt = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakt->nopeg'");
                        if (!empty($totalgajikt)) {
                            foreach ($totalgajikt as $totalkt) {
                                if ($totalkt->pembulatan1 < 0) {
                                    $sisagajikt = $totalkt->pembulatan2;
                                } else {
                                    $sisagajikt = $totalkt->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajikt = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakt->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajikt * -1,
                                    'userid' => $request->userid,
                                    ]);

                    
                        $bulan2kt = $data_bulan + 1;
                        if ($bulan2kt >12) {
                            $data_bulan2kt = 1;
                            $data_tahun2kt = $data_tahun + 1;
                        } else {
                            $data_bulan2kt =$bulan2kt;
                            $data_tahun2kt = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2kt,
                                            'bulan' => $data_bulan2kt,
                                            'nopek' => $datakt->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajikt,
                                            'userid' => $request->userid,
                                            ]);

                        // 11.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakkt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakt->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakkt as $kenapkt) {
                            if ($kenapkt->nilai1 <> "") {
                                $nilaikenapajakkt = $kenapkt->nilai1;
                            } else {
                                $nilaikenapajakkt = '0';
                            }
                        }
                        $koreksigajikt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakt->nopeg'");
                        foreach ($koreksigajikt as $koreksigkt) {
                            $kortamkt = $koreksigkt->kortam * -1;
                        }
                        $totalkenapajakkt = (($nilaikenapajakkt + $kortamkt) * 12);
                        $biayajabatanskt = ((5/100)*$totalkenapajakkt);
                        if ($biayajabatanskt > 6000000) {
                            $biayajabatankt = 6000000;
                        } else {
                            $biayajabatankt = $biayajabatanskt;
                        }
                        $neto1tahunkt = $totalkenapajakkt - $biayajabatankt;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakt->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatankt,
                                        ]);
                        // 12.CARI NILAI TIDAK KENA PAJAK
                        $data_ptkpkt = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datakt->nopeg'");
                            
                        if (!empty($data_ptkpkt)) {
                            foreach ($data_ptkpkt as $data_pkt) {
                                if ($data_pkt->nilai <> "") {
                                    $nilaiptkp1kt = $data_pkt->nilai;
                                } else {
                                    $nilaiptkp1kt = '0';
                                }
                            }
                        } else {
                            $nilaiptkp1kt = '0';
                        }

                        // 13.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakakt = $neto1tahunkt - $nilaiptkp1kt;
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $datakt->nopeg)
                                    ->update([
                                        'ptkp' => $nilaiptkp1kt,
                                        'pkp' => $nilaikenapajakakt,
                                    ]);

                        // 14.HITUNG PAJAK PENGHASILAN TERUTANG PAJAK SETAHUN
                
                        $pajakbulankt = pajak($nilaikenapajakakt);
                    
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '26',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $pajakbulankt * -1,
                                'userid' => $request->userid,
                                ]);
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datakt->nopeg,
                                'aard' => '27',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $pajakbulankt,
                                'userid' => $request->userid,
                                ]);
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $datakt->nopeg)
                                    ->update([
                                        'pajak_setor' => $pajakbulankt,
                                    ]);
                    }
                } elseif ($request->prosesupah == 'B') {
                    
                    // PekerjaBantu()
                    $data_pegawai_kontrakpb = MasterPegawai::where('status', 'B')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakpb as $datapb) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datapb->nopeg,
                                'status' => $datapb->kodekeluarga,
                                ]);
                        
                        // 1.CARI NILAI UPAH ALL IN AARD 02

                        $data_sdmallinpb = DB::select("SELECT nilai from sdm_allin where nopek='$datapb->nopeg'");
                        if (!empty($data_sdmallinpb)) {
                            foreach ($data_sdmallinpb as $data_sdmpb) {
                                if ($data_sdmpb->nilai <> "") {
                                    $upahallinpb = $data_sdmpb->nilai;
                                } else {
                                    $upahallinpb ='0';
                                }
                            }
                        } else {
                            $upahallinpb ='0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinpb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'upah' => $upahallinpb,
                                ]);

                        //2.CARI UPAH TETAP AARD 01
                        $data_sdmutpb = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapb->nopeg')");
                        if (!empty($data_sdmutpb)) {
                            foreach ($data_sdmutpb as $data_sdmpb) {
                                if ($data_sdmpb->ut <> "") {
                                    $upahtetappb = $data_sdmpb->ut;
                                } else {
                                    $upahtetappb = '0';
                                }
                            }
                        } else {
                            $upahtetappb = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '01',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahtetappb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'upah' => $upahtetappb,
                                ]);


                        $data_sdmutpb = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$datapb->nopeg')");
                        if (!empty($data_sdmutpb)) {
                            foreach ($data_sdmutpb as $data_sdmpb) {
                                if ($data_sdmpb->ut <> "") {
                                    $upahdaerahpb = $data_sdmpb->ut;
                                } else {
                                    $upahdaerahpb = '0';
                                }
                            }
                        } else {
                            $upahdaerahpb = '0';
                        }

                        UtBantu::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'nilai' => $upahdaerahpb,
                                    ]);

                        //4.UPAH TETAP PENSIUN
                        $data_pensiunpb = DB::select("SELECT a.ut from sdm_ut_pensiun a where a.nopeg='$datapb->nopeg' and a.mulai=(select max(mulai) from sdm_ut_pensiun where nopeg='$datapb->nopeg')");
                        if (!empty($data_pensiunpb)) {
                            foreach ($data_pensiunpb as $data_penpb) {
                                if ($data_penpb->ut <> "") {
                                    $upahtetappensiunpb = $data_penpb->ut;
                                } else {
                                    $upahtetappensiunpb = '0';
                                }
                            }
                        } else {
                            $upahtetappensiunpb = '0';
                        }

                        // 5.FASILITAS CUTI AARD 06
                        $data_cutipb = DB::select("SELECT a.fasilitas,a.fasilitas  from sdm_master_pegawai a where a.nopeg='$datapb->nopeg'");
                        if (!empty($data_cutipb)) {
                            foreach ($data_cutipb as $data_cutpb) {
                                $tahunpb = date('Y', strtotime($data_cutpb->fasilitas));
                                $bulanpb = ltrim(date('m', strtotime($data_cutpb->fasilitas)), '0');
                                $sisatahunpb = $data_tahun - $tahunpb;
                                $sisabulanpb = $data_bulan - $bulanpb;
                                if ($sisabulanpb == '11' and $sisatahunpb == '0') {
                                    $fasilitaspb = '0';
                                //   $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    //   $fasilitaspb = 1.5 * $uangcutipb;
                                } elseif ($sisabulanpb == '11' and $sisatahunpb > '0') {
                                    $fasilitaspb = '0';
                                // $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    // $fasilitaspb = 1.5 * $uangcutipb;
                                } elseif ($sisabulanpb == '-1' and $sisatahunpb > '0') {
                                    $fasilitaspb = '0';
                                // $uangcutipb = $upahallin + $tunjabatan + $tunjangandaerah;
                                    // $fasilitaspb = 1.5 * $uangcutipb;
                                } else {
                                    $fasilitaspb = '0';
                                }
                            }
                        } else {
                            $fasilitaspb = '0';
                        }

                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '06',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fasilitaspb,
                                'userid' => $request->userid,
                                ]);

                        TblPajak::where('tahun', $data_tahun)
                            ->where('bulan', $data_bulan)
                            ->where('nopeg', $datapb->nopeg)
                            ->update([
                                'gapok' => $fasilitaspb,
                            ]);

                        // 6.CARI NILAI LEMBUR AARD 05
                        $data_lemburpb = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapb->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_lemburpb)) {
                            foreach ($data_lemburpb as $data_sdmpb) {
                                if ($data_sdmpb->totlembur <> "") {
                                    $totallemburpb = $data_sdmpb->totlembur;
                                } else {
                                    $totallemburpb = '0';
                                }
                            }
                        } else {
                            $totallemburpb = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '05',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $totallemburpb,
                                'userid' => $request->userid,
                                ]);

                        // 7.CARI SISA BULAN LALU AARD 07
                        $data_sisanilaipb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipb)) {
                            foreach ($data_sisanilaipb as $data_sdmpb) {
                                if ($data_sdmpb->nilai <> "") {
                                    $fassisapb = $data_sdmpb->nilai;
                                } else {
                                    $fassisapb = '0';
                                }
                            }
                        } else {
                            $fassisapb = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '07',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fassisapb,
                                'userid' => $request->userid,
                                ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapb->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 8.CARI NILAI KOREKSI JAMSOSTEK PEKERJA 29
                        $data_koreksijamsostekpb = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='29'");
                        if (!empty($data_koreksijamsostekpb)) {
                            foreach ($data_koreksijamsostekpb as $data_korekpb) {
                                if ($data_korekpb->nilai <> "") {
                                    $iujampekpb = $data_korekpb->nilai;
                                } else {
                                    $iujampekpb = '0';
                                }
                            }
                        } else {
                            $iujampekpb = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '29',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $iujampekpb,
                                    'userid' => $request->userid,
                                    ]);
                            
                        // 9.HITUNG IURAN JAMSOSTEK PRIBADI DAN PERUSAHAAN
                        $data_iuranjamsostekpb = DB::select("SELECT gapok from sdm_gapok where nopeg = '$datapb->nopeg' and mulai=(select max(mulai) from sdm_gapok where nopeg='$datapb->nopeg')");
                        if (!empty($data_iuranjamsostekpb)) {
                            foreach ($data_iuranjamsostekpb as $data_iuranpb) {
                                if ($data_iuranpb->gapok <> "") {
                                    $gapokpb = $data_iuranpb->gapok;
                                } else {
                                    $gapokpb = '0';
                                }
                            }
                        } else {
                            $gapokpb = '0';
                        }
                        PayGapokBulanan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'jumlah' => $gapokpb,
                                        ]);

                        // 10.CARI NILAI PERSENTASE DARI TABEL PAY_TABLE_JAMSOSTEK
                        $data_persentasejmpb = DB::select("SELECT pribadi,accident,pensiun,life,manulife from pay_tbl_jamsostek");
                        if (!empty($data_persentasejmpb)) {
                            foreach ($data_persentasejmpb as $data_perpb) {
                                $jsmanualifepb = ($data_perpb->life/100);
                                if ($datapb->nopeg <> '709685') {
                                    $niljspribadipb = ($data_perpb->pribadi/100) * $gapokpb;
                                    $niljstaccidentpb = ($data_perpb->accident/100) * $gapokpb;
                                    $niljspensiunpb = ($data_perpb->pensiun/100) * $gapokpb;
                                    $niljslifepb = ($data_perpb->life/100) * $gapokpb;
                                } else {
                                    $niljspribadipb = '0';
                                    $niljstaccidentpb = '0';
                                    $niljspensiunpb = '0';
                                    $niljslifepb = '0';
                                }
                            }
                            $niljsmanualifepb = $jsmanualifepb * $upahtetappb;
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '09',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $niljspribadipb * -1,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '10',
                                    'lastamount' => '0',
                                    'curramount' => $niljstaccidentpb,
                                    'userid' => $request->userid,
                                    ]);
                        MasterBebanPerusahaan::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '11',
                                    'lastamount' => '0',
                                    'curramount' => $niljspensiunpb,
                                    'userid' => $request->userid,
                                    ]);

                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '12',
                                'lastamount' => '0',
                                'curramount' => $niljslifepb,
                                'userid' => $request->userid,
                                ]);
                        MasterBebanPerusahaan::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapb->nopeg,
                                'aard' => '13',
                                'lastamount' => '0',
                                'curramount' => $niljsmanualifepb,
                                'userid' => $request->userid,
                                ]);

                        // 11.HITUNG IURAN DANA PENSIUN BEBAN PEKERJA DAN PERUSAHAAN
                        $data_iurandanapensiunpb = DB::select("SELECT pribadi,perusahaan,perusahaan3 from pay_tbl_danapensiun");
                        foreach ($data_iurandanapensiunpb as $data_iuranpb) {
                            $dapenpribadipb = $data_iuranpb->pribadi;
                            $dapenperusahaanpb = $data_iuranpb->perusahaan;
                            $dapenperusahaan3pb = $data_iuranpb->perusahaan3;
                        }
                        if ($datapb->nopeg <> '709685') {
                            // HITUNG IURAN DANA PENSIUN PEKERJA/PRIBADI
                            $nildapenpribadipb = ($dapenpribadipb/100) * $upahtetappensiunpb;
                            // HITUNG IURAN DANA PENSIUN BEBAN PERUSAHAAN
                            $nildapenperusahaanpb = ($dapenperusahaanpb/100) * $upahtetappensiunpb;
                            if ($datapb->nopeg == '709669') {
                                $nildapenbnipb = ($dapenperusahaan3pb/100) * $upahtetappb;
                                MasterBebanPerusahaan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '46',
                                        'lastamount' => '0',
                                        'curramount' => $nildapenbnipb,
                                        'userid' => $request->userid,
                                        ]);
                            } elseif ($datapb->nopeg == '694287') {
                                $bazmapb = (2.5/100)*($upahallinpb - ($nildapenpribadipb+$niljspribadipb));
                                MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '36',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $bazmapb * -1,
                                            'userid' => $request->userid,
                                            ]);
                            } else {
                                MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '36',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => '0',
                                            'userid' => $request->userid,
                                            ]);
                            }
                        } else {
                            $nildapenpribadipb = '0';
                            $nildapenperusahaanpb = '0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '14',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $nildapenpribadipb * -1,
                                    'userid' => $request->userid,
                                    ]);
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '15',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $nildapenperusahaanpb,
                                    'userid' => $request->userid,
                                    ]);
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datapb->nopeg)
                                ->update([
                                    'dapen_pek' => $nildapenpribadipb,
                                ]);

                        // 11.HITUNG TABUNGAN AARD 16
                        $data_tabunganpb = DB::select("SELECT perusahaan from pay_tbl_tabungan");
                        if (!empty($data_tabunganpb)) {
                            foreach ($data_tabunganpb as $data_tabpb) {
                                if ($datapb->nopeg <> '709685') {
                                    $iuranwajibpb = ($data_tabpb->perusahaan/100) * $upahtetappb;
                                } else {
                                    $iuranwajibpb = '0';
                                }
                            }
                        } else {
                            $iuranwajibpb = '0';
                        }
                        MasterBebanPerusahaan::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '16',
                                        'lastamount' => '0',
                                        'curramount' => $iuranwajibpb,
                                        'userid' => $request->userid,
                                        ]);

                        // 12.CARI NILAI POTONGAN PKPP AARD 17 DAN HUTANG PKPP AARD 20
                        $data_nilaipotonganpb = DB::select("SELECT id_pinjaman,jml_pinjaman as jumlah,tenor as lamanya,round(angsuran,0) as angsuran from pay_mtrpkpp where nopek='$datapb->nopeg' and cair ='Y' and lunas<>'Y'");
                        if (!empty($data_nilaipotonganpb)) {
                            foreach ($data_nilaipotonganpb as $data_nilaipb) {
                                $idpinjamanpb = $data_nilaipb->id_pinjaman;
                                $totalpinjamanpb = $data_nilaipb->jumlah;
                                $lamapinjamapb = $data_nilaipb->lamanya;
                                $jumlahangsuranpb = $data_nilaipb->angsuran * -1;
                            }
                            $data_potonganpkpp2pb = DB::select("SELECT round(sum(pokok)) as totalpokok,count(*) as cclke from pay_skdpkpp where nopek='$datapb->nopeg' and tahun <= '$data_tahun' and bulan <= '$data_bulans' and id_pinjaman='$idpinjamanpb'");
                            foreach ($data_potonganpkpp2pb as $data_potongpb) {
                                $totalpokokpb = $data_potongpb->totalpokok;
                                $cclkepb = $data_potongpb->cclke;
                                $sisacicilanpb = $totalpinjamanpb - $totalpokokpb;
                            }
                            if ($cclkepb == '0') {
                                $jumlahangsuranpb = '0';
                            }
                            MasterHutang::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '20',
                                        'lastamount' => '0',
                                        'curramount' => $sisacicilanpb,
                                        'userid' => $request->userid,
                                        ]);
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '17',
                                    'jmlcc' => $lamapinjamapb,
                                    'ccl' => $cclkepb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $lamapinjamapb = '0';
                            $cclkepb = '0';
                            $jumlahangsuranpb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '17',
                                    'jmlcc' => $lamapinjamapb,
                                    'ccl' => $cclkepb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 13.CARI NILAI POTONGAN PANJAR PESANGON AARD 18 DAN HUTANG PPRP AARD 21
                        $data_nilaipotonganpanjarpb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='18'");
                        if (!empty($data_nilaipotonganpanjarpb)) {
                            foreach ($data_nilaipotonganpanjarpb as $data_nilaipb) {
                                $jmlccpotongpprppb = $data_nilaipb->jmlcc;
                                $cclpotongpprppb = $data_nilaipb->ccl;
                                if ($data_nilaipb->bilai < 0) {
                                    $nilaipotongpprppb = $data_nilaipb->nilai * -1;
                                } else {
                                    $nilaipotongpprppb = $data_nilaipb->nilai;
                                }
                            }
                            $data_carihutangpprppb = DB::select("SELECT tahun,bulan,aard,lastamount,curramount from pay_master_hutang where (tahun||bulan)=(select max(tahun||bulan) from pay_master_hutang where nopek='$datapb->nopeg' and aard='21') and nopek='$datapb->nopeg' and aard='21'");
                            foreach ($data_carihutangpprppb as $data_caripb) {
                                $tahunhutangpprppb = $data_caripb->tahun;
                                $bulanhutangpprppb = $data_caripb->bulan;
                                $aardhutangpprppb = $data_caripb->aard;
                                $lasthutangpprppb = $data_caripb->lastamount;
                                $currhutangpprppb = $data_caripb->curramount;
                                $lasthutangpprp1pb = $currhutangpprppb;
                                $currhutangpprp1pb = ($currhutangpprppb - $nilaipotongpprppb);
                            }
                            MasterHutang::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '21',
                                        'lastamount' => $lasthutangpprp1pb,
                                        'curramount' => $currhutangpprp1pb,
                                        'userid' => $request->userid,
                                        ]);
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '18',
                                    'jmlcc' => $jmlccpotongpprppb,
                                    'ccl' => $cclpotongpprppb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $jmlccpotongpprppb = '0';
                            $cclpotongpprppb = '0';
                            $jumlahangsuranpb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '18',
                                    'jmlcc' => $jmlccpotongpprppb,
                                    'ccl' => $cclpotongpprppb,
                                    'nilai' => $jumlahangsuranpb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 14.POTONGAN KOPERASI AARD 28
                        $data_potongankoperasipb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='28'");
                        if (!empty($data_potongankoperasipb)) {
                            foreach ($data_potongankoperasipb as $data_potongankoppb) {
                                $jmlccpotongkoperasipb = $data_potongankoppb->jmlcc;
                                $cclpotongkoperasipb = $data_potongankoppb->ccl;
                                if ($data_potongankoppb->nilai < 0) {
                                    $nilaipotongkoperasipb = $data_potongankoppb->nilai;
                                } else {
                                    $nilaipotongkoperasipb = $data_potongankoppb->nilai * -1;
                                }
                            }
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '28',
                                    'jmlcc' => $jmlccpotongkoperasipb,
                                    'ccl' => $cclpotongkoperasipb,
                                    'nilai' => $nilaipotongkoperasipb,
                                    'userid' => $request->userid,
                                    ]);
                        } else {
                            $jmlccpotongkoperasipb = '0';
                            $cclpotongkoperasipb = '0';
                            $nilaipotongkoperasipb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '28',
                                    'jmlcc' => $jmlccpotongkoperasipb,
                                    'ccl' => $cclpotongkoperasipb,
                                    'nilai' => $nilaipotongkoperasipb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 15.POTONGAN SUKA DUKA AARD 44
                        $data_potongansukadukapb = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg' and aard='44'");
                        if (!empty($data_potongansukadukapb)) {
                            foreach ($data_potongansukadukapb as $data_potongansukapb) {
                                $jmlccpotongsukadukapb = $data_potongansukapb->jmlcc;
                                $cclpotongsukadukapb = $data_potongansukapb->ccl;
                                if ($data_potongansukapb->nilai < 0) {
                                    $nilaipotongsukadukapb = $data_potongansukapb->nilai;
                                } else {
                                    $nilaipotongsukadukapb = $data_potongansukapb->nilai * -1;
                                }
                                MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '44',
                                    'jmlcc' => $jmlccpotongsukadukapb,
                                    'ccl' => $cclpotongsukadukapb,
                                    'nilai' => $nilaipotongsukadukapb,
                                    'userid' => $request->userid,
                                    ]);
                            }
                        } else {
                            $jmlccpotongsukadukapb = '0';
                            $cclpotongsukadukapb = '0';
                            $nilaipotongsukadukapb = '0';
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '44',
                                    'jmlcc' => $jmlccpotongsukadukapb,
                                    'ccl' => $cclpotongsukadukapb,
                                    'nilai' => $nilaipotongsukadukapb,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 16.HITUNG TOTAL GAJI YANG DI DAPAT
                        $data_hitungtotalgajipb = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapb->nopeg'");
                        if (!empty($data_hitungtotalgajipb)) {
                            foreach ($data_hitungtotalgajipb as $data_hitungtotalpb) {
                                if ($data_hitungtotalpb->pembulatan1 < 0) {
                                    $sisagajipb = $data_hitungtotalpb->pembulatan2;
                                } else {
                                    $sisagajipb = $data_hitungtotalpb->pembulatan1;
                                }
                            }
                            MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapb->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajipb * -1,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        $bulan2pb = $data_bulan + 1;
                        if ($bulan2pb > 12) {
                            $data_bulan2pb = 1;
                            $data_tahun2pb = $data_tahun + 1;
                        } else {
                            $data_bulan2pb =$bulan2pb;
                            $data_tahun2pb = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2pb,
                                            'bulan' => $data_bulan2pb,
                                            'nopek' => $datapb->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajipb,
                                            'userid' => $request->userid,
                                            ]);

                        // 17.CARI NILAI YANG KENA PAJAK (BRUTO)
                        $data_kenapajakpb = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapb->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        if (!empty($data_kenapajakpb)) {
                            foreach ($data_kenapajakpb as $data_kenapb) {
                                $nilaikenapajak1pb = $data_kenapb->nilai1;
                            }
                        } else {
                            $nilaikenapajak1pb = '0';
                        }
                        $totkenapajakpb = (($nilaikenapajak1pb + $fasilitaspb)*12);

                        // 18. CARI NILAI PENGURANG HITUNG BIAYA JABATAN
                        $biayajabatan2pb = ((5/100) * $totkenapajakpb);
                        if ($biayajabatan2pb > 6000000) {
                            $biayajabatanpb = 6000000;
                        } else {
                            $biayajabatanpb = $biayajabatan2pb;
                        }
                            
                        $neto1tahunpb =  $totkenapajakpb - $biayajabatanpb;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datapb->nopeg)
                                        ->update([
                                            'bjabatan' => $biayajabatanpb,
                                        ]);

                        // 19.CARI NILAI TIDAK KENA PAJAK
                        $data_carinilairdkkenapajakpb = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapb->nopeg'");
                        if (!empty($data_carinilairdkkenapajakpb)) {
                            foreach ($data_carinilairdkkenapajakpb as $data_carinilaipb) {
                                $nilaiptkp1pb = $data_carinilaipb->nilai;
                            }
                        } else {
                            $nilaiptkp1pb = '0';
                        }

                        // 20.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakapb = $neto1tahunpb - $nilaiptkp1pb;
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapb->nopeg)
                                            ->update([
                                                'ptkp' => $nilaiptkp1pb,
                                                'pkp' => $nilaikenapajakapb,
                                            ]);

                        // 20.HITUNG PAJAK PENGHASILAN TERUTANG
                            
                        $pajakbulanpb = pajak($nilaikenapajakapb);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpb * -1,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapb->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpb,
                                        'userid' => $request->userid,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                            ->where('bulan', $data_bulan)
                                            ->where('nopeg', $datapb->nopeg)
                                            ->update([
                                                'pajak_setor' => $pajakbulanpb,
                                            ]);
                    }
                } elseif ($request->prosesupah == 'N') {
                    
                    // PekerjaBaru()
                    $data_pegawai_kontrakn = MasterPegawai::where('status', 'N')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrakn as $datapj) {
                        $status1pj = $datapj->status;
                        $kodekelpj = $datapj->kodekeluarga;
                        $tglaktifpj = date("j", strtotime($datapj->tglaktifdns));
                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinpj = DB::select("SELECT nilai from sdm_allin where nopek='$datapj->nopeg'");
                        if (!empty($data_sdmallinpj)) {
                            foreach ($data_sdmallinpj as $data_sdmpj) {
                                if ($data_sdmpj->nilai <> "") {
                                    $upahmentahpj = $data_sdmpj->nilai;
                                    $upahallinpj = ((30 - $tglaktifpj)/30) * $upahmentahpj;
                                } else {
                                    $upahallinpj ='0';
                                }
                            }
                        } else {
                            $upahallinpj ='0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapj->nopeg,
                                'aard' => '02',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $upahallinpj,
                                'userid' => $request->userid,
                                ]);

                        // 2.CARI TUNJANGAN JABATAN JIKA ADA
                        $data_tunjanganjabatanpj = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$datapj->nopeg' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$datapj->nopeg')");
                        if (!empty($data_tunjanganjabatanpj)) {
                            foreach ($data_tunjanganjabatanpj as $data_tunjangpj) {
                                if ($data_tunjangpj->tunjangan <> "") {
                                    if ($data_tunjangpj->goljob <= '03') {
                                        $tunjangpj = $data_tunjangpj->tunjangan;
                                        $tunjjabatanpj = ((30 - $tglaktifpj)/30) * $tunjangpj;
                                    } else {
                                        $tunjjabatanpj = '0';
                                    }
                                } else {
                                    $tunjjabatanpj = '0';
                                }
                            }
                        } else {
                            $tunjjabatanpj = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapj->nopeg,
                                'aard' => '03',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $tunjjabatanpj,
                                'userid' => $request->userid,
                                ]);

                        // 3.CARI NILAI LEMBUR AARD 05
                        $data_carinilailemburpj = DB::select("SELECT sum(makanpg+makansg+makanml+transport+lembur) as totlembur from pay_lembur where nopek='$datapj->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        if (!empty($data_carinilailemburpj)) {
                            foreach ($data_carinilailemburpj as $data_carilemburpj) {
                                if ($data_carilemburpj->totlembur <> "") {
                                    $totallemburpj = $data_carilemburpj->totlembur;
                                } else {
                                    $totallemburpj = '0';
                                }
                            }
                        } else {
                            $totallemburpj = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapj->nopeg,
                                'aard' => '05',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $totallemburpj,
                                'userid' => $request->userid,
                                ]);

                        // 4.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaipj = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='07'");
                        if (!empty($data_sisanilaipj)) {
                            foreach ($data_sisanilaipj as $data_sdmpj) {
                                if ($data_sdmpj->nilai <> "") {
                                    $fassisapj = $data_sdmpj->nilai;
                                } else {
                                    $fassisapj = '0';
                                }
                            }
                        } else {
                            $fassisapj = '0';
                        }
                        MasterUpah::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopek' => $datapj->nopeg,
                                'aard' => '07',
                                'jmlcc' => '0',
                                'ccl' => '0',
                                'nilai' => $fassisapj,
                                'userid' => $request->userid,
                                ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where nopek='$datapj->nopeg' and bulan='$data_bulan' and tahun='$data_tahun'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }

                        // 5.CARI NILAI KOREKSI LAIN AARD 08
                        $data_carinilaikoreksipj = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='08'");
                        if (!empty($data_carinilaikoreksipj)) {
                            foreach ($data_carinilaikoreksipj as $data_carinilaipj) {
                                if ($data_carinilaipj->nilai <> "") {
                                    $faslainpj = $data_carinilaipj->nilai;
                                } else {
                                    $faslainpj = '0';
                                }
                            }
                        } else {
                            $faslainpj = '0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datapj->nopeg,
                                    'aard' => '08',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $faslainpj,
                                    'userid' => $request->userid,
                                    ]);

                        // 6.CARI NILAI POTONGAN LAIN AARD 19 DAN HUTANG LAIN AARD 22
                        $data_nilaipotonganaard19pj = DB::select("SELECT nopek,aard,jmlcc,ccl,nilai from pay_potongan where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg' and aard='19'");
                        if (!empty($data_nilaipotonganaard19pj)) {
                            foreach ($data_nilaipotonganaard19pj as $data_nilaiaardpj) {
                                $jmlccpotonglainpj = $data_nilaiaardpj->jmlcc;
                                $cclpotonglainpj = $data_nilaiaardpj->ccl;
                                if ($data_nilaiaardpj->nilai < 0) {
                                    $nilaipotonglainpj = $data_nilaiaardpj->nilai;
                                } else {
                                    $nilaipotonglainpj = $data_nilaiaardpj->nilai * -1;
                                }
                                $data_carihutanglainpj = DB::select("SELECT tahun,bulan,aard,lastamount,curramount from pay_master_hutang where (tahun||bulan)=(select max(tahun||bulan) from pay_master_hutang where nopek='$datapj->nopeg' and aard='22') and nopek='$datapj->nopeg' and aard='22'");
                                foreach ($data_carihutanglainpj as $data_carpj) {
                                    $tahunhutanglainpj = $data_carpj->tahun;
                                    $bulanhutanglainpj = $data_carpj->bulan;
                                    $aardhutanglainpj =   $data_carpj->aard;
                                    $lasthutanglainpj = $data_carpj->lastamount;
                                    $currhutanglainpj = $data_carpj->curramount;
                                    
                                    $lasthutanglain1pj = $currhutanglainpj;
                                    $currhutanglain1pj = ($currhutanglainpj + $nilaipotonglainpj);
                                    MasterHutang::insert([
                                                'tahun' => $data_tahun,
                                                'bulan' => $data_bulan,
                                                'nopek' => $datapj->nopeg,
                                                'aard' => '22',
                                                'lastamount' => $lasthutanglain1pj,
                                                'curramount' => $currhutanglain1pj,
                                                'userid' => $request->userid,
                                                ]);
                                    MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapj->nopeg,
                                            'aard' => '19',
                                            'jmlcc' => $jmlccpotonglainpj,
                                            'ccl' => $cclpotonglainpj,
                                            'nilai' => $nilaipotonglainpj,
                                            'userid' => $request->userid,
                                            ]);
                                }
                            }
                        } else {
                            $jmlccpotonglainpj = '0';
                            $cclpotonglainpj = '0';
                            $nilaipotonglainpj = '0';
                            MasterUpah::insert([
                                            'tahun' => $data_tahun,
                                            'bulan' => $data_bulan,
                                            'nopek' => $datapj->nopeg,
                                            'aard' => '19',
                                            'jmlcc' => $jmlccpotonglainpj,
                                            'ccl' => $cclpotonglainpj,
                                            'nilai' => $nilaipotonglainpj,
                                            'userid' => $request->userid,
                                            ]);
                        }

                        // 7.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajipj = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datapj->nopeg'");
                        if (!empty($totalgajipj)) {
                            foreach ($totalgajipj as $totalpj) {
                                if ($totalpj->pembulatan1 < 0) {
                                    $sisagajipj = $totalpj->pembulatan2;
                                } else {
                                    $sisagajipj = $totalpj->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajipj = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapj->nopeg,
                                        'aard' => '23',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $sisagajipj * -1,
                                        'userid' => $request->userid,
                                        ]);

                        
                        $bulan2pj = $data_bulan + 1;
                        if ($bulan2pj >12) {
                            $data_bulan2pj = 1;
                            $data_tahun2pj = $data_tahun + 1;
                        } else {
                            $data_bulan2pj =$bulan2pj;
                            $data_tahun2pj = $data_tahun;
                        }
                        PayKoreksi::insert([
                                                'tahun' => $data_tahun2pj,
                                                'bulan' => $data_bulan2pj,
                                                'nopek' => $datapj->nopeg,
                                                'aard' => '07',
                                                'jmlcc' => '0',
                                                'ccl' => '0',
                                                'nilai' => $sisagajipj,
                                                'userid' => $request->userid,
                                                ]);

                        // 8.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakpj = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datapj->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakpj as $kenappj) {
                            if ($kenappj->nilai1 <> "") {
                                $nilaikenapajak1pj = $kenappj->nilai1;
                            } else {
                                $nilaikenapajak1pj = '0';
                            }
                        }
                        $totkenapajakpj = $nilaikenapajak1pj * 12;
                            
                        // 9.CARI NILAI TIDAK KENA PAJAK
                        $datatdkkenapajakpj = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$datapj->nopeg'");
                        foreach ($datatdkkenapajakpj as $tdkkenappj) {
                            if ($tdkkenappj->nilai1 <> "") {
                                $nilaiptkp1pj = $tdkkenappj->nilai1;
                            } else {
                                $nilaiptkp1pj = '0';
                            }
                        }
                        // 9.PENGHASILAN KENA PAJAK SETAHUN
                        $nilaikenapajakpj = $totkenapajakpj - $nilaiptkp1pj;
                            
                        $pajakbulanpj = pajak($nilaikenapajakpj);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapj->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpj * -1,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $datapj->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $pajakbulanpj,
                                        'userid' => $request->userid,
                                        ]);
                    }
                } elseif ($request->prosesupah == 'U') {
                    
                    
                    // Pengurus()
                    $data_pegawai_kontraku = MasterPegawai::where('status', 'U')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontraku as $dataps) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $dataps->nopeg,
                                'status' => $dataps->kodekeluarga,
                                ]);

                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinps = DB::select("SELECT nilai from sdm_allin where nopek='$dataps->nopeg'");
                        if (!empty($data_sdmallinps)) {
                            foreach ($data_sdmallinps as $data_sdmps) {
                                if ($data_sdmps->nilai <> "") {
                                    $upahallinps = $data_sdmps->nilai;
                                } else {
                                    $upahallinps ='0';
                                }
                            }
                        } else {
                            $upahallinps ='0';
                        }
                        
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '02',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $upahallinps,
                                        'userid' => $request->userid,
                                        ]);
                                
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $dataps->nopeg)
                                    ->update([
                                        'upah' => $upahallinps,
                                    ]);

                        // 2.CARI NILAI SISA BULAN LALU AARD 07
                        $data_sisanilaips = DB::select("SELECT nopek,aard,jmlcc,ccl,round(nilai) as nilai from pay_koreksi where bulan='$data_bulans' and tahun='$data_tahun' and nopek='$dataps->nopeg' and aard='07'");
                        if (!empty($data_sisanilaips)) {
                            foreach ($data_sisanilaips as $data_sdps) {
                                if ($data_sdps->nilai <> "") {
                                    $fassisaps = $data_sdps->nilai;
                                } else {
                                    $fassisaps = '0';
                                }
                            }
                        } else {
                            $fassisaps = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $dataps->nopeg,
                                    'aard' => '07',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $fassisaps,
                                    'userid' => $request->userid,
                                    ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                        'tahun' => $data_hitung_kor->tahun,
                                        'bulan' => $data_hitung_kor->bulan,
                                        'nopek' => $data_hitung_kor->nopek,
                                        'aard' => $data_hitung_kor->aard,
                                        'jmlcc' => $data_hitung_kor->jmlcc,
                                        'ccl' =>  $data_hitung_kor->ccl,
                                        'nilai' => $data_hitung_kor->nilai*-1,
                                        'userid' => $request->userid,
                                        ]);
                        }

                        // 3.CARI NILAI KOREKSI LAIN AARD 08
                        $data_carinilaikoreksips = DB::select("SELECT sum(nilai) as nilai from pay_koreksi where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg' and aard='08'");
                        if (!empty($data_carinilaikoreksips)) {
                            foreach ($data_carinilaikoreksips as $data_carinilaips) {
                                if ($data_carinilaips->nilai <> "") {
                                    $faslainps = $data_carinilaips->nilai;
                                } else {
                                    $faslainps = '0';
                                }
                            }
                        } else {
                            $faslainps = '0';
                        }

                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $dataps->nopeg,
                                    'aard' => '08',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $faslainps,
                                    'userid' => $request->userid,
                                    ]);

                        // 4.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajips = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$dataps->nopeg'");
                        if (!empty($totalgajips)) {
                            foreach ($totalgajips as $totalps) {
                                if ($totalps->pembulatan1 < 0) {
                                    $sisagajips = $totalps->pembulatan2;
                                } else {
                                    $sisagajips = $totalps->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajips = '0';
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '23',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $sisagajips * -1,
                                        'userid' => $request->userid,
                                        ]);

                        
                        $bulan2ps = $data_bulan + 1;
                        if ($bulan2ps >12) {
                            $data_bulan2ps = 1;
                            $data_tahun2ps = $data_tahun + 1;
                        } else {
                            $data_bulan2ps =$bulan2ps;
                            $data_tahun2ps = $data_tahun;
                        }
                        PayKoreksi::insert([
                                                'tahun' => $data_tahun2ps,
                                                'bulan' => $data_bulan2ps,
                                                'nopek' => $dataps->nopeg,
                                                'aard' => '07',
                                                'jmlcc' => '0',
                                                'ccl' => '0',
                                                'nilai' => $sisagajips,
                                                'userid' => $request->userid,
                                                ]);

                        // 5.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakps = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$dataps->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakps as $kenapps) {
                            if ($kenapps->nilai1 <> "") {
                                $nilaikenapajak1ps = $kenapps->nilai1;
                            } else {
                                $nilaikenapajak1ps = '0';
                            }
                        }
                        $nilaikenapajakaps = $nilaikenapajak1ps;
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $dataps->nopeg)
                                    ->update([
                                        'pkp' => $nilaikenapajakaps,
                                    ]);

                        if ($dataps->nopeg == "kom9" or $dataps->nopeg == "kom4") {
                            $tunjpajakps = (15/100) * $nilaikenapajakaps;
                            $potpajakps = ((30/100)*($nilaikenapajakaps + $tunjpajakps));
                        } elseif ($dataps->nopeg == "komut1") {
                            $tunjpajakps = (15/100) * $nilaikenapajakaps;
                            $potpajakps = (30/100) * ($nilaikenapajakaps + $tunjpajakps);
                        } elseif ($dataps->nopeg == "kom5") {
                            $tunjpajakps = (5/100) * $nilaikenapajakaps;
                            $potpajakps = (15/100) * ($nilaikenapajakaps + $tunjpajakps);
                        } else {
                            $tunjpajakps = (5/100) * $nilaikenapajakaps;
                            $potpajakps = (30/100) * ($nilaikenapajakaps + $tunjpajakps);
                        }
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '27',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $tunjpajakps,
                                        'userid' => $request->userid,
                                        ]);
                        MasterUpah::insert([
                                        'tahun' => $data_tahun,
                                        'bulan' => $data_bulan,
                                        'nopek' => $dataps->nopeg,
                                        'aard' => '26',
                                        'jmlcc' => '0',
                                        'ccl' => '0',
                                        'nilai' => $potpajakps,
                                        'userid' => $request->userid,
                                        ]);
                        

                        $data_caripajak1ps = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$dataps->nopeg' and aard='27'");
                        foreach ($data_caripajak1ps as $data_pajak1ps) {
                            $tunjpaps = $data_pajak1ps->pajaknya;
                        }
                            
                        $data_caripajak2ps = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$dataps->nopeg' and aard='26'");
                        foreach ($data_caripajak2ps as $data_pajak2ps) {
                            $potpaps = $data_pajak2ps->pajaknya;
                        }

                        MasterUpah::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopek', $dataps->nopeg)
                                    ->where('aard', '27')
                                    ->update([
                                        'nilai' => $tunjpaps,
                                    ]);
                        MasterUpah::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopek', $dataps->nopeg)
                                    ->where('aard', '26')
                                    ->update([
                                        'nilai' => $potpaps * -1,
                                    ]);
                        TblPajak::where('tahun', $data_tahun)
                                    ->where('bulan', $data_bulan)
                                    ->where('nopeg', $dataps->nopeg)
                                    ->update([
                                        'pajak_setor' => $tunjpaps,
                                    ]);
                    }
                } else {

                    
                    // Komite()
                    $data_pegawai_kontrako = MasterPegawai::where('status', 'O')->orderBy('nopeg', 'asc')->get();
                    foreach ($data_pegawai_kontrako as $datakm) {
                        TblPajak::insert([
                                'tahun' => $data_tahun,
                                'bulan' => $data_bulan,
                                'nopeg' => $datakm->nopeg,
                                'status' => $datakm->kodekeluarga,
                                ]);

                        // 1.CARI NILAI UPAH ALL IN AARD 02
                        $data_sdmallinkm = DB::select("SELECT nilai from sdm_allin where nopek='$datakm->nopeg'");
                        if (!empty($data_sdmallinkm)) {
                            foreach ($data_sdmallinkm as $data_sdmkm) {
                                if ($data_sdmkm->nilai <> "") {
                                    $upahallinkm = $data_sdmkm->nilai;
                                } else {
                                    $upahallinkm ='0';
                                }
                            }
                        } else {
                            $upahallinkm ='0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '02',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $upahallinkm,
                                    'userid' => $request->userid,
                                    ]);
                            
                        TblPajak::where('tahun', $data_tahun)
                                ->where('bulan', $data_bulan)
                                ->where('nopeg', $datakm->nopeg)
                                ->update([
                                    'upah' => $upahallinkm,
                                ]);

                        // 2.HITUNG TOTAL GAJI YANG DI DAPAT
                        $totalgajikm = DB::select("SELECT sum(nilai) as gajiasli,(sum(nilai)-round(sum(nilai),-3)) as pembulatan1,round(sum(nilai),-3) as hasil,(1000+(sum(nilai)-round(sum(nilai),-3))) as pembulatan2  from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakm->nopeg'");
                        if (!empty($totalgajikm)) {
                            foreach ($totalgajikm as $totalkm) {
                                if ($totalkm->pembulatan1 < 0) {
                                    $sisagajikm = $totalkm->pembulatan2;
                                } else {
                                    $sisagajikm = $totalkm->pembulatan1;
                                }
                            }
                        } else {
                            $sisagajikm = '0';
                        }
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '23',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $sisagajikm * -1,
                                    'userid' => $request->userid,
                                    ]);

                        $data_hitung_koreksi = DB::select("SELECT tahun,bulan,nopek,aard,jmlcc,ccl,nilai,userid from pay_koreksigaji where bulan='$data_bulan' and tahun='$data_tahun' and nopek='$datakm->nopeg'");
                        foreach ($data_hitung_koreksi as $data_hitung_kor) {
                            MasterUpah::insert([
                                    'tahun' => $data_hitung_kor->tahun,
                                    'bulan' => $data_hitung_kor->bulan,
                                    'nopek' => $data_hitung_kor->nopek,
                                    'aard' => $data_hitung_kor->aard,
                                    'jmlcc' => $data_hitung_kor->jmlcc,
                                    'ccl' =>  $data_hitung_kor->ccl,
                                    'nilai' => $data_hitung_kor->nilai*-1,
                                    'userid' => $request->userid,
                                    ]);
                        }
                    
                        $bulan2km = $data_bulan + 1;
                        if ($bulan2km >12) {
                            $data_bulan2km = 1;
                            $data_tahun2km = $data_tahun + 1;
                        } else {
                            $data_bulan2km =$bulan2km;
                            $data_tahun2km = $data_tahun;
                        }
                        PayKoreksi::insert([
                                            'tahun' => $data_tahun2km,
                                            'bulan' => $data_bulan2km,
                                            'nopek' => $datakm->nopeg,
                                            'aard' => '07',
                                            'jmlcc' => '0',
                                            'ccl' => '0',
                                            'nilai' => $sisagajikm,
                                            'userid' => $request->userid,
                                            ]);

                        // 3.HITUNG PAJAK PPH21 CARI NILAI YANG KENA PAJAK (BRUTO)
                        $kenapajakkm = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$data_tahun' and a.bulan='$data_bulan' and a.nopek='$datakm->nopeg' and a.aard=b.kode and b.kenapajak='Y'");
                        foreach ($kenapajakkm as $kenapkm) {
                            if ($kenapkm->nilai1 <> "") {
                                $nilaikenapajakkm = $kenapkm->nilai1;
                            } else {
                                $nilaikenapajakkm = '0';
                            }
                        }
                        $nilaikenapajakkma = $nilaikenapajakkm;
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakm->nopeg)
                                        ->update([
                                            'pkp' => $nilaikenapajakkma,
                                        ]);

                        $tunjpajakkm = ((5/100) * $nilaikenapajakkma);
                        $potpajakkm = ((30/100) * ($nilaikenapajakkma + $tunjpajakkm));
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '27',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $tunjpajakkm,
                                    'userid' => $request->userid,
                                    ]);
                        MasterUpah::insert([
                                    'tahun' => $data_tahun,
                                    'bulan' => $data_bulan,
                                    'nopek' => $datakm->nopeg,
                                    'aard' => '26',
                                    'jmlcc' => '0',
                                    'ccl' => '0',
                                    'nilai' => $potpajakkm,
                                    'userid' => $request->userid,
                                    ]);
                        $data_caripajak1km = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$datakm->nopeg' and aard='27'");
                        foreach ($data_caripajak1km as $data_pajak1km) {
                            $tunjpakm = $data_pajak1km->pajaknya;
                        }
                                
                        $data_caripajak2km = DB::select("SELECT round(nilai,-2) as pajaknya from pay_master_upah where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$datakm->nopeg' and aard='26'");
                        foreach ($data_caripajak2km as $data_pajak2km) {
                            $potpakm = $data_pajak2km->pajaknya;
                        }

                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $datakm->nopeg)
                                        ->where('aard', '27')
                                        ->update([
                                            'nilai' => $tunjpakm,
                                        ]);
                        MasterUpah::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopek', $datakm->nopeg)
                                        ->where('aard', '26')
                                        ->update([
                                            'nilai' => $potpakm * -1,
                                        ]);
                        TblPajak::where('tahun', $data_tahun)
                                        ->where('bulan', $data_bulan)
                                        ->where('nopeg', $datakm->nopeg)
                                        ->update([
                                            'pajak_setor' => $tunjpakm,
                                        ]);
                    }
                }//end proses
                StatusBayarGaji::insert([
                            'tahun' => $data_tahun,
                            'bulan' => $data_bulan,
                            'statpbd' => 'N',
                            ]);
                Alert::success('Data Upah Berhasil Diproses', 'Berhasil')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.index');
            }
        } else {
            $data_tahun = substr($request->tanggalupah, -4);
            $data_bulan = ltrim(substr($request->tanggalupah, 0, -5), '0');
            $data_bulans = substr($request->tanggalupah, 0, -5);
            $data_cekbatal = DB::select("SELECT * from pay_master_upah where bulan='$data_bulan' and tahun='$data_tahun'");
            if (!empty($data_cekbatal)) {
                $data_cektatus = DB::select("SELECT statpbd from statusbayargaji where tahun='$data_tahun' and bulan='$data_bulan'");
                foreach ($data_cektatus as $data_cek) {
                    if ($data_cek->statpbd == 'N') {
                        MasterUpah::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        PayKoreksi::where('tahun', $data_tahun)->where('bulan', $data_bulans)->delete();
                        MasterBebanPerusahaan::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        MasterHutang::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        UtBantu::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        TblPajak::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        StatusBayarGaji::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        PayGapokBulanan::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                        Alert::success('Proses pembatalan proses Upah selesai', 'Berhasil')->persistent(true);
                        return redirect()->route('modul_sdm_payroll.proses_gaji.index');
                    } else {
                        Alert::Info('Tidak bisa dibatalkan, Data Upah sudah di proses perbendaharaan', 'Info')->persistent(true);
                        return redirect()->route('modul_sdm_payroll.proses_gaji.index');
                    }
                }
            } else {
                Alert::Info("Tidak ditemukan data upah bulan $data_bulan dan tahun $data_tahun ", 'Info')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.index');
            }
        }
    }

    
    public function slipGaji()
    {
        $data_pegawai = DB::select("SELECT 
        nopeg,
        nama,
        status,
        nama 
        from sdm_master_pegawai 
        where status <> 'P' 
        order by nopeg");

        return view('modul-sdm-payroll.proses-gaji.slip-gaji', compact('data_pegawai'));
    }
    public function slipGajiExport(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_master_upah a  where a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan'");
        $data_cek1 = DB::select("SELECT * from pay_master_bebanprshn a where a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' order by a.aard asc");
        if (!empty($data_cek) and !empty($data_cek1)) {
            $data_list = DB::select("SELECT a.nopek,round(a.jmlcc,0) as jmlcc,round(a.ccl,0) as ccl,round(a.nilai,0) as nilai,a.aard,a.bulan,a.tahun,b.nama as nama_pegawai, c.nama as nama_aard,d.nama as nama_upah, d.cetak from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode join pay_tbl_jenisupah d on c.jenis=d.kode where a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' and a.aard in ('01','03','04','06','07','27')");
            $data_detail = DB::select("SELECT a.nopek,round(a.jmlcc,0) as jmlcc,round(a.ccl,0) as ccl,round(a.nilai,0)*-1 as nilai,a.aard,a.bulan,a.tahun,b.nama as nama_pegawai, c.nama as nama_aard,d.nama as nama_upah, d.cetak from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode join pay_tbl_jenisupah d on c.jenis=d.kode where a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' and a.aard in ('09','23','26')");
            $data_lain = DB::select("SELECT 
            a.nopek,a.aard,a.bulan,a.tahun,round(a.curramount,0) AS curramount,
                (SELECT sum(curramount) as total 
                    FROM pay_master_bebanprshn 
                    WHERE nopek=a.nopek 
                    AND aard=a.aard 
                    AND tahun=a.tahun 
                    AND bulan=a.bulan
                ) as total,
                b.nama AS nama_pegawai, 
                c.nama AS nama_aard,
                d.nama AS nama_upah, 
                d.cetak 
            FROM pay_master_bebanprshn a 
            JOIN sdm_master_pegawai b 
            on a.nopek=b.nopeg 
            JOIN pay_tbl_aard c 
            on a.aard=c.kode 
            JOIN pay_tbl_jenisupah d 
            on c.jenis = d.kode 
            WHERE a.nopek='217018' 
            AND a.tahun='2019'
            AND a.bulan='8' 
            order by a.aard asc");
            
            $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.slip-gaji-pdf', compact('request', 'data_list', 'data_detail', 'data_lain'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
        
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(910, 120, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_gaji.slip_gaji');
        }
    }

    /**
     *
     */
    public function rekapGaji()
    {
        return view('modul-sdm-payroll.proses-gaji.rekap-gaji');
    }
    
    /**
     *
     */
    public function rekapGajiExport(Request $request)
    {
        if ($request->prosesupah == 'C') {
            $data_list = db::select("SELECT a.nopek,b.nama, d.nama as nmbag, d.kode,
            sum(CASE WHEN a.aard ='01' THEN round(a.nilai,0) ELSE '0' END) as a_upah,
            sum(CASE WHEN a.aard ='04' THEN round(a.nilai,0) ELSE '0' END) as a_bh,
            sum(CASE WHEN a.aard ='03' THEN round(a.nilai,0) ELSE '0' END) as a_jb,
            sum(CASE WHEN a.aard ='06' THEN round(a.nilai,0) ELSE '0' END) as a_fc,
            sum(CASE WHEN a.aard ='05' THEN round(a.nilai,0) ELSE '0' END) as a_lem,
            sum(CASE WHEN a.aard ='07' THEN round(a.nilai,0) ELSE '0' END) as a_sbl,
            sum(CASE WHEN a.aard in ('32','34','35','37','38')  THEN round(a.nilai,0)*-1 ELSE '0' END) as a_koreksi,
            (case when b.KODEKELUARGA ='201' THEN 'K/1' when b.KODEKELUARGA ='202' THEN 'K/2' when b.KODEKELUARGA ='203' THEN 'K/3' when b.KODEKELUARGA ='200' THEN 'K/0' when b.KODEKELUARGA ='100' THEN '-/-' else '-/-' end) as a_kdkeluarga,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as a_tunpj,
            sum(CASE WHEN a.aard ='09' THEN round(a.nilai,0) ELSE '0' END) as iuranjm,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as pot_pajak,
            sum(CASE WHEN a.aard ='19' THEN round(a.nilai,0) ELSE '0' END) as pot_pinjaman,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as pembulatan,
            sum(CASE WHEN a.aard ='14' THEN round(a.nilai,0) ELSE '0' END) as a_005,
            sum(CASE WHEN a.aard ='17' THEN round(a.nilai,0) ELSE '0' END) as a_011,
            sum(CASE WHEN a.aard ='18' THEN round(a.nilai,0) ELSE '0' END) as a_012,
            sum(CASE WHEN a.aard in ('28','44')  THEN round(a.nilai,0) ELSE '0' END) as pot_koperasi
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag where b.status='C' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_rekapgajitetap', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(890, 125, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.ctkrekapgaji');
            }
        } elseif ($request->prosesupah == 'K') {
            $data_list = db::select("SELECT a.nopek,b.nama,d.nama as nmbag,d.kode ,
            sum(CASE WHEN a.aard ='02' THEN round(a.nilai,0) ELSE '0' END) as a_upah,
            sum(CASE WHEN a.aard ='03' THEN round(a.nilai,0) ELSE '0' END) as a_jb,
            sum(CASE WHEN a.aard ='04' THEN round(a.nilai,0) ELSE '0' END) as a_bh,
            sum(CASE WHEN a.aard ='06' THEN round(a.nilai,0) ELSE '0' END) as a_fc,
            sum(CASE WHEN a.aard ='05' THEN round(a.nilai,0) ELSE '0' END) as a_lem,
            sum(CASE WHEN a.aard ='07' THEN round(a.nilai,0) ELSE '0' END) as a_sbl,
            sum(CASE WHEN a.aard in ('32','34','35','38')  THEN round(a.nilai,0)*-1 ELSE '0' END) as a_koreksi,
            (case when b.KODEKELUARGA ='201' THEN 'K/1' when b.KODEKELUARGA ='202' THEN 'K/2' when b.KODEKELUARGA ='203' THEN 'K/3' when b.KODEKELUARGA ='200' THEN 'K/0' when b.KODEKELUARGA ='100' THEN '-/-' else '-/-' end) as a_kdkeluarga,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as tunpj,
            sum(CASE WHEN a.aard ='09' THEN round(a.nilai,0) ELSE '0' END) as iuranjm,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as pot_pajak,
            sum(CASE WHEN a.aard ='19' THEN round(a.nilai,0) ELSE '0' END) as pot_pinjaman,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as pembulatan,
            sum(CASE WHEN a.aard ='14' THEN round(a.nilai,0) ELSE '0' END) as a_005,
            sum(CASE WHEN a.aard ='17' THEN round(a.nilai,0) ELSE '0' END) as a_011,
            sum(CASE WHEN a.aard ='18' THEN round(a.nilai,0) ELSE '0' END) as a_012,
            sum(CASE WHEN a.aard in ('28','44')  THEN round(a.nilai,0) ELSE '0' END) as pot_koperasi
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag where b.status='K' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode;");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_rekapgajikontrak', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.ctkrekapgaji');
            }
        } elseif ($request->prosesupah == 'B') {
            $data_list = db::select("SELECT a.nopek,b.nama,d.nama as nmbag,d.kode ,
            sum(CASE WHEN a.aard ='02' THEN round(a.nilai,0) ELSE '0' END) as a_upah,
            sum(CASE WHEN a.aard ='03' THEN round(a.nilai,0) ELSE '0' END) as a_jb,
            sum(CASE WHEN a.aard ='04' THEN round(a.nilai,0) ELSE '0' END) as a_bh,
            sum(CASE WHEN a.aard ='06' THEN round(a.nilai,0) ELSE '0' END) as a_fc,
            sum(CASE WHEN a.aard ='05' THEN round(a.nilai,0) ELSE '0' END) as a_lem,
            sum(CASE WHEN a.aard ='07' THEN round(a.nilai,0) ELSE '0' END) as a_sbl,
            sum(CASE WHEN a.aard in ('32','34','35','45')  THEN round(a.nilai,0)*-1 ELSE '0' END) as a_koreksi,
            (case when b.KODEKELUARGA ='201' THEN 'K/1' when b.KODEKELUARGA ='202' THEN 'K/2' when b.KODEKELUARGA ='203' THEN 'K/3' when b.KODEKELUARGA ='200' THEN 'K/0' when b.KODEKELUARGA ='100' THEN '-/-' else '-/-' end) as a_kdkeluarga,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as tunpj,
            sum(CASE WHEN a.aard ='09' THEN round(a.nilai,0) ELSE '0' END) as iuranjm,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as pot_pajak,
            sum(CASE WHEN a.aard ='36' THEN round(a.nilai,0) ELSE '0' END) as pot_bazma,
            sum(CASE WHEN a.aard ='19' THEN round(a.nilai,0) ELSE '0' END) as pot_pinjaman,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as pembulatan,
            sum(CASE WHEN a.aard ='14' THEN round(a.nilai,0) ELSE '0' END) as iuranpensiun,
            sum(CASE WHEN a.aard ='17' THEN round(a.nilai,0) ELSE '0' END) as jumlah1,
            sum(CASE WHEN a.aard ='18' THEN round(a.nilai,0) ELSE '0' END) as jumlah2,
            sum(CASE WHEN a.aard = '17'   THEN round(a.ccl,0) ELSE '0' END) as ccl1,
            sum(CASE WHEN a.aard = '18'   THEN round(a.ccl,0) ELSE '0' END) as ccl2,
            sum(CASE WHEN a.aard in ('28','44')  THEN round(a.nilai,0) ELSE '0' END) as pot_koperasi
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag where b.status='B' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode;");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_rekapgajibantu', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.ctkrekapgaji');
            }
        } elseif ($request->prosesupah == 'U') {
            $data_list = db::select("SELECT a.nopek,b.nama,d.nama as nmbag,d.kode ,
            sum(CASE WHEN a.aard ='02' THEN round(a.nilai,0) ELSE '0' END) as a_upah,
            sum(CASE WHEN a.aard in ('32')  THEN round(a.nilai,0)*-1 ELSE '0' END) as a_koreksi,
            (case when b.KODEKELUARGA ='201' THEN 'K/1' when b.KODEKELUARGA ='202' THEN 'K/2' when b.KODEKELUARGA ='203' THEN 'K/3' when b.KODEKELUARGA ='200' THEN 'K/0' when b.KODEKELUARGA ='100' THEN '-/-' else '-/-' end) as a_kdkeluarga,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as tunpj,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as pot_pajak,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as pembulatan
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag where b.status='U' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode;");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_rekappengurus', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.ctkrekapgaji');
            }
        } else {
            $data_list = db::select("SELECT a.nopek,b.nama,d.nama as nmbag,d.kode ,
            sum(CASE WHEN a.aard ='02' THEN round(a.nilai,0) ELSE '0' END) as a_upah,
            sum(CASE WHEN a.aard in ('32')  THEN round(a.nilai,0)*-1 ELSE '0' END) as a_koreksi,
            (case when b.KODEKELUARGA ='201' THEN 'K/1' when b.KODEKELUARGA ='202' THEN 'K/2' when b.KODEKELUARGA ='203' THEN 'K/3' when b.KODEKELUARGA ='200' THEN 'K/0' when b.KODEKELUARGA ='100' THEN '-/-' else '-/-' end) as a_kdkeluarga,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as tunpj,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as pot_pajak,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as pembulatan
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag where b.status='O' and a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode;");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_rekapkomite', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.ctkrekapgaji');
            }
        }
    }
    
    /**
     *
     */
    public function daftarUpah()
    {
        return view('modul-sdm-payroll.proses-gaji.rekap-daftar-upah');
    }
    
    /**
     *
     */
    public function daftarUpahExport(Request $request)
    {
        if ($request->prosesupah == 'C') {
            $data_list = db::select("SELECT a.nopek,b.nama,d.nama as nmbag,e.rekening,e.atasnama,f.nama as namabank, f.alamat,
            sum(CASE WHEN a.aard ='01' THEN round(a.nilai,0) ELSE '0' END) as a_01,
            sum(CASE WHEN a.aard ='02' THEN round(a.nilai,0) ELSE '0' END) as a_02,
            sum(CASE WHEN a.aard ='03' THEN round(a.nilai,0) ELSE '0' END) as a_03,
            sum(CASE WHEN a.aard ='04' THEN round(a.nilai,0) ELSE '0' END) as a_04,
            sum(CASE WHEN a.aard ='05' THEN round(a.nilai,0) ELSE '0' END) as a_05,
            sum(CASE WHEN a.aard ='06' THEN round(a.nilai,0) ELSE '0' END) as a_06,
            sum(CASE WHEN a.aard ='07' THEN round(a.nilai,0) ELSE '0' END) as a_07,
            sum(CASE WHEN a.aard ='08' THEN round(a.nilai,0) ELSE '0' END) as a_08,
            sum(CASE WHEN a.aard ='09' THEN round(a.nilai,0) ELSE '0' END) as a_09,
            sum(CASE WHEN a.aard ='14' THEN round(a.nilai,0) ELSE '0' END) as a_14,
            sum(CASE WHEN a.aard ='16' THEN round(a.nilai,0) ELSE '0' END) as a_16,
            sum(CASE WHEN a.aard ='17' THEN round(a.nilai,0) ELSE '0' END) as a_17,
            sum(CASE WHEN a.aard ='18' THEN round(a.nilai,0) ELSE '0' END) as a_18,
            sum(CASE WHEN a.aard ='19' THEN round(a.nilai,0) ELSE '0' END) as a_19,
            sum(CASE WHEN a.aard ='23' THEN round(a.nilai,0) ELSE '0' END) as a_23,
            sum(CASE WHEN a.aard ='26' THEN round(a.nilai,0) ELSE '0' END) as a_26,
            sum(CASE WHEN a.aard ='27' THEN round(a.nilai,0) ELSE '0' END) as a_27,
            sum(CASE WHEN a.aard ='36' THEN round(a.nilai,0) ELSE '0' END) as a_28,
            sum(CASE WHEN a.aard ='29' THEN round(a.nilai,0) ELSE '0' END) as a_29,
            sum(CASE WHEN a.aard ='32' THEN round(a.nilai,0) ELSE '0' END) as a_32,
            sum(CASE WHEN a.aard ='34' THEN round(a.nilai,0) ELSE '0' END) as a_34,
            sum(CASE WHEN a.aard ='35' THEN round(a.nilai,0) ELSE '0' END) as a_35,
            sum(CASE WHEN a.aard ='37' THEN round(a.nilai,0) ELSE '0' END) as a_37,
            sum(CASE WHEN a.aard ='38' THEN round(a.nilai,0) ELSE '0' END) as a_38,
            sum(CASE WHEN a.aard ='45' THEN round(a.nilai,0) ELSE '0' END) as a_45,
            sum(CASE WHEN a.aard in ('28','44')  THEN round(a.nilai,0) ELSE '0' END) as koperasi
            from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag join pay_tbl_rekening e on a.nopek=e.nopek join pay_tbl_bank f on e.kdbank=f.kode where a.tahun='$request->tahun' and a.bulan='$request->bulan' and c.mulai=(select max(mulai) from sdm_jabatan where nopeg=a.nopek) group by a.nopek,b.nama,b.kodekeluarga,d.nama,d.kode,e.rekening,e.atasnama,f.nama,f.alamat");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_daftarupahtetap', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(890, 125, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.daftar_upah');
            }
        } elseif ($request->prosesupah == 'U') {
            $data_list = db::select("SELECT nopek, namapegawai,rekening,namabank,
            sum(CASE WHEN aard ='02' THEN round(nilai,0) ELSE '0' END) as allin,
            sum(CASE WHEN aard ='23' THEN round(nilai,0) ELSE '0' END) as jumkoreksi, 
            sum(CASE WHEN aard ='26' THEN round(nilai,0) ELSE '0' END) as potpajak,
            sum(CASE WHEN aard ='27' THEN round(nilai,0) ELSE '0' END) as tunpajak 
            from  (select a.nopek,b.nama as namapegawai, a.aard,a.nilai,e.rekening,f.nama as namabank from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag join pay_tbl_rekening e on a.nopek=e.nopek join pay_tbl_bank f on e.kdbank=f.kode where a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='U'  union all
            select a.nopek,b.nama as namapegawai, a.aard,a.nilai,e.rekening,f.nama as namabank from pay_koreksi a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag join pay_tbl_rekening e on a.nopek=e.nopek join pay_tbl_bank f on e.kdbank=f.kode where a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='U' ) a group by nopek, namapegawai,rekening,namabank");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_daftarupahkomisaris', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.daftar_upah');
            }
        } else {
            $data_list = db::select("SELECT nopek, namapegawai,rekening,namabank,
            sum(CASE WHEN aard ='02' THEN round(nilai,0) ELSE '0' END) as allin,
            sum(CASE WHEN aard ='23' THEN round(nilai,0) ELSE '0' END) as jumkoreksi, 
            sum(CASE WHEN aard ='26' THEN round(nilai,0) ELSE '0' END) as potpajak,
            sum(CASE WHEN aard ='27' THEN round(nilai,0) ELSE '0' END) as tunpajak 
            from  (select a.nopek,b.nama as namapegawai, a.aard,a.nilai,e.rekening,f.nama as namabank from pay_master_upah a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag join pay_tbl_rekening e on a.nopek=e.nopek join pay_tbl_bank f on e.kdbank=f.kode where a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='O'  union all
            select a.nopek,b.nama as namapegawai, a.aard,a.nilai,e.rekening,f.nama as namabank from pay_koreksi a join sdm_master_pegawai b on a.nopek=b.nopeg join sdm_jabatan c on c.nopeg=b.nopeg join sdm_tbl_kdbag d on d.kode=c.kdbag join pay_tbl_rekening e on a.nopek=e.nopek join pay_tbl_bank f on e.kdbank=f.kode where a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='O' ) a group by nopek, namapegawai,rekening,namabank");
            if (!empty($data_list)) {
                $pdf = DomPDF::loadview('modul-sdm-payroll.proses-gaji.export_daftarupahkomite', compact('request', 'data_list'))->setPaper('Legal', 'landscape');
                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
        
                $canvas = $dom_pdf->getCanvas();
                $canvas->page_text(880, 140, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //Rekap Gaji landscape
                // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
                return $pdf->stream();
            } else {
                Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_gaji.daftar_upah');
            }
        }
    }
}
