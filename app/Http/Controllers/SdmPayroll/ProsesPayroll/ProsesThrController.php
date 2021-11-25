<?php

namespace App\Http\Controllers\SdmPayroll\ProsesPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\MasterThr;
use App\Models\StatBayarThr;
use DB;
use DomPDF;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

class ProsesThrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.proses-thr.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-sdm-payroll.proses-thr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prosesupah = $request->prosesthr;
        $tanggal = $request->tanggal;
        $tahun = substr($request->tanggal, -4);
        $bulan = ltrim(substr($request->tanggal, 0, -5), '0');
        $bulans = substr($request->tanggal, 0, -5);
        $tanggals = "1/$tanggal";
        $tahuns = $request->tahun;
        $keterangan = $request->keterangan;

        if ($bulan - 1 == 0) {
            $bulangaji="12";
            $tahungaji=$tahun - 1;
        } else {
            $bulangaji=$bulan - 1;
            $tahungaji= $tahun;
        }

        if ($request->radioupah == 'proses') {
            if ($prosesupah == 'A') {
                $data_Cekthr = DB::select("SELECT * from pay_master_thr where tahun='$tahun' and bulan='$bulan'");
            } else {
                $data_Cekthr = DB::select("SELECT * from pay_master_thr where tahun='$tahun' and bulan='$bulan' and status='$prosesupah'");
            }

            // Cek THR
            if (!empty($data_Cekthr)) {
                Alert::Info("Data THR bulan $bulan dan tahun $tahun sudah pernah di proses", 'Info')->persistent(true);
                
                return redirect()->route('modul_sdm_payroll.proses_thr.index');
            } else {
                if ($prosesupah == 'A') {
                    // Pekerja REQUEST SEMUA
                    $this->startProsesThrPegawaiTetap($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                    $this->startProsesThrPegawaiKontrak($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                    $this->startProsesThrPegawaiPerbantuan($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                } elseif ($prosesupah == 'C') {
                    // Pekerja Tetap REQUEST C
                    $this->startProsesThrPegawaiTetap($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                } elseif ($prosesupah == 'K') {
                    // Pekerja Kontrak REQUEST K
                    $this->startProsesThrPegawaiKontrak($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                } elseif ($prosesupah == 'B') {
                    // Pekerja Kontrak REQUEST B
                    $this->startProsesThrPegawaiPerbantuan($request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan);
                }

                $cek_stat = DB::select("SELECT * from stat_bayar_thr where tahun='$tahun' and bulan='$bulan'");
                if (!empty($cek_stat)) {
                    StatBayarThr::where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->update([
                        'status' => 'N',
                    ]);
                } else {
                    StatBayarThr::insert([
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'status' => 'N',
                    ]);
                }

                Alert::success("Data THR bulan $bulan dan tahun $tahun berhasil di proses ", 'Berhasil')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_thr.index');
            }
        } else {
            $data_cekstatusbayar = DB::select("SELECT status from stat_bayar_thr where tahun='$tahun' and bulan='$bulan'");
            if (!empty($data_cekstatusbayar)) {
                foreach ($data_cekstatusbayar as $data_bayar) {
                    $data_cekbayar = $data_bayar->status;
                }
                if ($data_cekbayar == 'N') {
                    if ($prosesupah == 'A') {
                        $data_Cekbatal = DB::select("SELECT * from pay_master_thr where tahun='$tahun' and bulan='$bulan'");
                    } else {
                        $data_Cekbatal = DB::select("SELECT * from pay_master_thr where tahun='$tahun' and bulan='$bulan' and status='$prosesupah'");
                    }
                    if (!empty($data_Cekbatal)) {
                        if ($prosesupah == 'A') {
                            MasterThr::where('tahun', $tahun)->where('bulan', $bulan)->delete();
                            StatBayarThr::where('tahun', $tahun)->where('bulan', $bulan)->delete();
                        } elseif ($prosesupah == 'C') {
                            MasterThr::where('tahun', $tahun)->where('bulan', $bulan)->where('status', $prosesupah)->delete();
                        } elseif ($prosesupah == 'K') {
                            MasterThr::where('tahun', $tahun)->where('bulan', $bulan)->where('status', $prosesupah)->delete();
                        } else {
                            MasterThr::where('tahun', $tahun)->where('bulan', $bulan)->where('status', $prosesupah)->delete();
                        }
                        Alert::success("Proses pembatalan proses THR selesai", 'Berhasil')->persistent(true);
                        return redirect()->route('modul_sdm_payroll.proses_thr.index');
                    } else {
                        Alert::Info("Tidak ditemukan data THR bulan $bulan dan tahun $tahun", 'Info')->persistent(true);
                        return redirect()->route('modul_sdm_payroll.proses_thr.index');
                    }
                } else {
                    Alert::Info("Tidak bisa dibatalkan Data THR bulan $bulan tahun $tahun sudah di proses perbendaharaan", 'Info')->persistent(true);
                    return redirect()->route('modul_sdm_payroll.proses_thr.index');
                }
            } else {
                Alert::Info("Tidak ditemukan data THR bulan $bulan dan tahun $tahun", 'Info')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_thr.index');
            }
        }
    }

    public function startProsesThrPegawaiTetap(Request $request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan)
    {
        // pekerjatetapthr()
        // 1.cari pegawai yang status pekerja tetap
        $data_pegawaitetapC = DB::select("SELECT nopeg,kodekeluarga from sdm_master_pegawai where status='C' order by nopeg asc");

        foreach ($data_pegawaitetapC as $data_pegawaitept) {
            $nopegpt = $data_pegawaitept->nopeg;
            $kodekelpt = $data_pegawaitept->kodekeluarga;
            $data_upahpt = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$nopegpt' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$nopegpt')");
            if (!empty($data_upahpt)) {
                foreach ($data_upahpt as $data_uppt) {
                    if ($data_uppt->ut <> "") {
                        $upahtetappt = $data_uppt->ut;
                    } else {
                        $upahtetappt = '0';
                    }
                }
            } else {
                $upahtetappt= '0';
            }

            // '2.tunjangan jabatan aard = 03
            if ($nopegpt == "181326") {
                $tunjjabatanpt = '0';
            } else {
                $rstunjjabatanpt = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$nopegpt' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$nopegpt')");
                if (!empty($rstunjjabatanpt)) {
                    foreach ($rstunjjabatanpt as $data_tunpt) {
                        if ($data_tunpt->tunjangan <> "") {
                            $tunjjabatanpt = $data_tunpt->tunjangan;
                        } else {
                            $tunjjabatanpt = '0';
                        }
                    }
                } else {
                    $tunjjabatanpt = '0';
                }
            }
            
            // '3.tunjangan biaya hidup aard aard = 04
            $rstunjdaerahpt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$nopegpt' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$nopegpt')");
            if (!empty($rstunjdaerahpt)) {
                foreach ($rstunjdaerahpt as $data_daept) {
                    if ($data_daept->nilai <> "") {
                        $tunjdaerahpt = $data_daept->nilai;
                    } else {
                        $tunjdaerahpt = '0';
                    }
                }
            } else {
                $tunjdaerahpt = '0';
            }

            $thrgabpt = $upahtetappt + $tunjdaerahpt + $tunjjabatanpt;
            $pengalipt = "1";

            // 4.'cari nilai jamsostek
            $rsjstaccidentpt = DB::select("SELECT curramount from pay_master_bebanprshn where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='10'");
            if (!empty($rsjstaccidentpt)) {
                foreach ($rsjstaccidentpt as $data_jspt) {
                    if ($data_jspt->curramount <> "") {
                        $niljstaccidentpt = $data_jspt->curramount;
                    } else {
                        $niljstaccidentpt = '0';
                    }
                }
            } else {
                $niljstaccidentpt = '0';
            }
            
            $rsjstlifept = DB::select("SELECT curramount from pay_master_bebanprshn where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='12'");
            if (!empty($rsjstlifept)) {
                foreach ($rsjstlifept as $data_lifpt) {
                    if ($data_lifpt->curramount <> "") {
                        $niljstlifept = $data_lifpt->curramount;
                    } else {
                        $niljstlifept = '0';
                    }
                }
            } else {
                $niljstlifept = '0';
            }


            $rsfasilitaspt = DB::select("SELECT nilai from pay_master_upah where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='06'");
            if (!empty($rsfasilitaspt)) {
                foreach ($rsfasilitaspt as $data_faspt) {
                    if ($data_faspt->nilai <> "") {
                        $fasilitaspt = $data_faspt->nilai;
                    } else {
                        $fasilitaspt = '0';
                    }
                }
            } else {
                $fasilitaspt = '0';
            }

            // 4.'cari nilai kena pajak upah bulan sebelumnya
            $rskenapajak1pt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegpt' and a.aard=b.kode and b.kenapajak='Y'");
            if (!empty($rskenapajak1pt)) {
                foreach ($rskenapajak1pt as $data_kenapt) {
                    if ($data_kenapt->nilai1 <> "") {
                        $nilaikenapajak1pt = $data_kenapt->nilai1;
                    } else {
                        $nilaikenapajak1pt = '0';
                    }
                }
            } else {
                $nilaikenapajak1pt = '0';
            }


            $rskorgajipt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegpt'");
            if (!empty($rskorgajipt)) {
                foreach ($rskorgajipt as $data_koreksipt) {
                    if ($data_koreksipt->kortam <> "") {
                        $kortampt = $data_koreksipt->kortam;
                    } else {
                        $kortampt = '0';
                    }
                }
            } else {
                $kortampt = '0';
            }

            $totkenapajakpt = ((($nilaikenapajak1pt + $niljstaccidentpt + $niljstlifept)*12)+$thrgabpt+$kortampt+$fasilitaspt);

            // 5.'hitung biaya jabatan
            $biayajabatan2pt = ((5/100) * $totkenapajakpt);
            if ($biayajabatan2pt > 6000000) {
                $biayajabatanpt = 6000000;
            } else {
                $biayajabatanpt = $biayajabatan2pt;
            }

            $neto1tahunpt =  $totkenapajakpt - $biayajabatanpt;

            $rsptkppt = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$nopegpt'");
            if (!empty($rsptkppt)) {
                foreach ($rsptkppt as $data_ptkppt) {
                    if ($data_ptkppt->nilai <> "") {
                        $nilaiptkp1pt = $data_ptkppt->nilai;
                    } else {
                        $nilaiptkp1pt = '0';
                    }
                }
            } else {
                $nilaiptkp1pt = '0';
            }

            $nilaikenapajakapt = $neto1tahunpt - $nilaiptkp1pt;
            
            $nilai2pt = 0;
            $nilai1pt = 0;
            $tunjanganpt = 0;
            $pajakbulanpt=1;
            $nilkenapajakpt = $nilaikenapajakapt;
            $sisapokokpt = $nilkenapajakpt;
            $data_sdmprogresifpt = DB::select("SELECT * from sdm_tbl_progressif order by awal asc");
            foreach ($data_sdmprogresifpt as $data_progpt) {
                $awalpt = $data_progpt->awal;
                $akhirpt = $data_progpt->akhir;
                $persenpt = $data_progpt->prosen;
                $prosenpt = $persenpt/100;
                $rangept = $akhirpt - $awalpt;
                if ($sisapokokpt > 0) {
                    $sisapokok1pt = $sisapokokpt;
                    if ($sisapokok1pt > 0 and $sisapokok1pt < $rangept) {
                        $pph21rpt = $sisapokok1pt * $prosenpt;
                    } elseif ($sisapokok1pt > 0 and $sisapokok1pt >= $rangept) {
                        $pph21rpt = $rangept * $prosenpt;
                    } else {
                        $pph21rpt = 0;
                    }
                } else {
                    $pph21rpt = 0;
                }
                $sisapokokpt = $sisapokok1pt - $rangept;
                $pph21okpt =  $pph21rpt;
                $pajakbulanpt = pajak($nilaikenapajakapt);
                $nilaikenapajakpt=($nilkenapajakpt/1000)*1000;

                $selisihpt=$nilai2pt-$nilai1pt;
                $nilai1pt=$nilaikenapajakpt;
                $nilaikenapajakpt=(($nilaikenapajakpt+$pph21okpt)/1000)*1000;
                $nilai2pt=($nilaikenapajakpt/1000)*1000;
                $nilaikenapajakpt=(($nilaikenapajakpt-$selisihpt)/1000)*1000;
            }
            $tunjanganpt=$pajakbulanpt;
            $rstunjgajipt = DB::select("SELECT nilai from pay_master_upah where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='27'");
            if (!empty($rstunjgajipt)) {
                foreach ($rstunjgajipt as $data_tungapt) {
                    if ($data_tungapt->nilai <> "") {
                        $pajakgajipt = $data_tungapt->nilai;
                    } else {
                        $pajakgajipt = '0';
                    }
                }
            } else {
                $pajakgajipt = '0';
            }

            $pajakakhirpt = ($pajakbulanpt * 12)-($pajakgajipt*12);
            $rskoreksipt = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegpt' and aard='32'");
            if (!empty($rskoreksipt)) {
                foreach ($rskoreksipt as $data_koreksipt) {
                    if ($data_koreksipt->nilai <> "") {
                        $koreksipt = $data_koreksipt->nilai;
                    } else {
                        $koreksipt = '0';
                    }
                }
            } else {
                $koreksipt = '0';
            }

            $rsbazmapt = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegpt' and aard='36'");
            if (!empty($rsbazmapt)) {
                foreach ($rsbazmapt as $data_bazmapt) {
                    if ($data_bazmapt->nilai <> "") {
                        $bazmapt = $data_bazmapt->nilai;
                    } else {
                        $bazmapt = '0';
                    }
                }
            } else {
                $bazmapt = '0';
            }
            // inspotpajak
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpt,
                    'aard' => 26,
                    'nilai' => $pajakakhirpt * -1,
                    'tahunthr' => $tahun,
                    'status' => 'C',
                    'userid' => $request->userid,
                    ]);
            // instunjpajak
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpt,
                    'aard' => 27,
                    'nilai' => $pajakakhirpt,
                    'tahunthr' => $tahun,
                    'status' => 'C',
                    'userid' => $request->userid,
                    ]);
            // instunjangan
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpt,
                    'aard' => 25,
                    'nilai' =>$thrgabpt,
                    'tahunthr' => $tahun,
                    'status' => 'C',
                    'pajakgaji' => $pajakgajipt*12,
                    'pajakthr' => $pajakakhirpt,
                    'ut' => $upahtetappt,
                    'pengali' => $pengalipt,
                    'keterangan' => $keterangan,
                    'userid' => $request->userid,
                    'tbiayahidup' => $tunjdaerahpt,
                    'tjabatan' => $tunjjabatanpt,
                    'koreksi' => $koreksipt,
                    'potongan' => $bazmapt,
                    ]);

            // inskoreksi
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpt,
                    'aard' => 32,
                    'nilai' => $koreksipt,
                    'tahunthr' => $tahun,
                    'status' => 'C',
                    'userid' => $request->userid,
                    ]);
            // insbazma
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpt,
                    'aard' => 36,
                    'nilai' => $bazmapt,
                    'tahunthr' => $tahun,
                    'status' => 'C',
                    'userid' => $request->userid,
                    ]);
        }

        return true;
    }

    public function startProsesThrPegawaiKontrak(Request $request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan)
    {
        // pekerjakontrakthr()
        // cari pegawai yang status pekerja kontrak
        $data_pegawaikontrakk = DB::select("SELECT nopeg,kodekeluarga from sdm_master_pegawai where status='K' order by nopeg asc");
        
        foreach ($data_pegawaikontrakk as $data_pegawaikonkt) {
            $nopegkt = $data_pegawaikonkt->nopeg;
            $kodekelkt = $data_pegawaikonkt->kodekeluarga;
            if ($nopegkt == "070953") {
                $bulangaji=3;
            }
            $rsupahallinkt = DB::select("SELECT nilai from sdm_allin where nopek='$nopegkt'");
            if (!empty($rsupahallinkt)) {
                foreach ($rsupahallinkt as $data_upkt) {
                    if ($data_upkt->nilai <> "") {
                        $upahallinkt = $data_upkt->nilai;
                    } else {
                        $upahallinkt = '0';
                    }
                }
            } else {
                $upahallinkt= '0';
            }
 
            $rstunjjabatankt = DB::select("SELECT a.nopeg,a.kdbag,a.kdjab,b.goljob,b.tunjangan from sdm_jabatan a,sdm_tbl_kdjab b where a.nopeg='$nopegkt' and a.kdbag=b.kdbag and a.kdjab=b.kdjab and a.mulai=(select max(mulai) from sdm_jabatan where nopeg='$nopegkt')");
            if (!empty($rstunjjabatankt)) {
                foreach ($rstunjjabatankt as $data_tunkt) {
                    if ($data_tunkt->tunjangan <> "") {
                        $tunjjabatankt = $data_tunkt->tunjangan;
                    } else {
                        $tunjjabatankt = '0';
                    }
                }
            } else {
                $tunjjabatankt= '0';
            }
 
            $rstunjdaerahkt = DB::select("SELECT a.golgaji, b.nilai from sdm_golgaji a,pay_tbl_tunjangan b where a.nopeg='$nopegkt' and a.golgaji=b.golongan and a.tanggal=(select max(tanggal) from sdm_golgaji where nopeg ='$nopegkt')");
            if (!empty($rstunjdaerahkt)) {
                foreach ($rstunjdaerahkt as $data_tundaekt) {
                    if ($data_tundaekt->nilai <> "") {
                        $tunjdaerahkt = $data_tundaekt->nilai;
                    } else {
                        $tunjdaerahkt = '0';
                    }
                }
            } else {
                $tunjdaerahkt= '0';
            }
 
            $thrgabkt =$upahallinkt + $tunjjabatankt + $tunjdaerahkt;
            if ($nopegkt == "070953") {
                $pengalikt = 235/365;
                $thrgabkt = ($thrgabkt * (235/365));
            } elseif ($nopegkt == "120926") {
                $pengalikt = 340/365;
                $thrgabkt = (($thrgabkt) * (340/365));
            } else {
                $pengalikt = "1";
                $thrgabkt=$thrgabkt;
            }
 
            $rskenapajak1kt = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegkt' and a.aard=b.kode and b.kenapajak='Y'");
            if (!empty($rskenapajak1kt)) {
                foreach ($rskenapajak1kt as $data_kenapajakkt) {
                    if ($data_kenapajakkt->nilai1 <> "") {
                        $nilaikenapajak1kt = $data_kenapajakkt->nilai1;
                    } else {
                        $nilaikenapajak1kt = '0';
                    }
                }
            } else {
                $nilaikenapajak1kt= '0';
            }
 
            $rskorgaji2kt = DB::select("SELECT sum(a.nilai) as kortam from pay_koreksigaji a where a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegkt'");
            foreach ($rskorgaji2kt as $data_korkt) {
                $kortam2kt = $data_korkt->kortam;
            }
 
            $totkenapajakkt = (($nilaikenapajak1kt * 12)+$kortam2kt+$thrgabkt);
            $biayajabatan2kt = ((5/100) * $totkenapajakkt);
            if ($biayajabatan2kt > 6000000) {
                $biayajabatankt = 6000000;
            } else {
                $biayajabatankt = $biayajabatan2kt;
            }
 
            $neto1tahunkt =  $totkenapajakkt - $biayajabatankt;
            $rsptkpkt = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$nopegkt'");
            if (!empty($rsptkpkt)) {
                foreach ($rsptkpkt as $data_ptkpkt) {
                    if ($data_ptkpkt->nilai <> "") {
                        $nilaiptkp1kt = $data_ptkpkt->nilai;
                    } else {
                        $nilaiptkp1kt = '0';
                    }
                }
            } else {
                $nilaiptkp1kt= '0';
            }
 
            $nilaikenapajakakt = $neto1tahunkt - $nilaiptkp1kt;
            $nilai2kt = 0;
            $nilai1kt = 0;
            $tunjangankt = 0;
            $pajakbulankt=1;
            $nilkenapajakkt = $nilaikenapajakakt;
            $sisapokokkt = $nilkenapajakkt;
            $sisapokok1kt = $sisapokokkt;
            $data_sdmprogresifkt = DB::select("SELECT * from sdm_tbl_progressif order by awal asc");
            foreach ($data_sdmprogresifkt as $data_progkt) {
                $awalkt = $data_progkt->awal;
                $akhirkt = $data_progkt->akhir;
                $persenkt = $data_progkt->prosen;
                $prosenkt = $persenkt/100;
                $rangekt = $akhirkt - $awalkt;
                if ($sisapokokkt > 0) {
                    if ($sisapokok1kt > 0 and $sisapokok1kt < $rangekt) {
                        $pph21rkt = $sisapokok1kt * $prosenkt;
                    } elseif ($sisapokok1kt > 0 and $sisapokok1kt >= $rangekt) {
                        $pph21rkt = $rangekt * $prosenkt;
                    } else {
                        $pph21rkt = 0;
                    }
                } else {
                    $pph21rkt = 0;
                }
                $sisapokokkt = $sisapokok1kt - $rangekt;
                $pph21okkt =  $pph21rkt;
                $pajakbulankt = pajak($nilaikenapajakakt);
                $nilaikenapajakkt=($nilkenapajakkt/1000)*1000;
 
                $selisihkt=$nilai2kt-$nilai1kt;
                $nilai1kt=$nilaikenapajakkt;
                $nilaikenapajakkt=(($nilaikenapajakkt+$pph21okkt)/1000)*1000;
                $nilai2kt=($nilaikenapajakkt/1000)*1000;
                $nilaikenapajakkt=(($nilaikenapajakkt-$selisihkt)/1000)*1000;
            }
            $tunjangankt=$pajakbulankt;
 
            $rstunjgajikt = DB::select("SELECT nilai from pay_master_upah where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegkt' and aard='27'");
            if (!empty($rstunjgajikt)) {
                foreach ($rstunjgajikt as $datakt) {
                    if ($datakt->nilai <> "") {
                        $pajakgajikt = $datakt->nilai;
                    } else {
                        $pajakgajikt = '0';
                    }
                }
            } else {
                $pajakgajikt='0';
            }
 
            $pajakakhirkt = ($pajakbulankt * 12)-($pajakgajikt*12);
            $rskoreksikt = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegkt' and aard='32'");
            if (!empty($rskoreksikt)) {
                foreach ($rskoreksikt as $data_korekkt) {
                    if ($data_korekkt->nilai <> "") {
                        $koreksikt = $data_korekkt->nilai;
                    } else {
                        $koreksikt = '0';
                    }
                }
            } else {
                $koreksikt= '0';
            }
            $rsbazmakt = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegkt' and aard='36'");
            if (!empty($rsbazmakt)) {
                foreach ($rsbazmakt as $data_bazkt) {
                    if ($data_bazkt->nilai <> "") {
                        $bazmakt = $data_bazkt->nilai;
                    } else {
                        $bazmakt = '0';
                    }
                }
            } else {
                $bazmakt= '0';
            }
 
            // inspotpajak
            MasterThr::insert([
                                 'tahun' => $tahun,
                                 'bulan' => $bulan,
                                 'nopek' => $nopegkt,
                                 'aard' => 26,
                                 'nilai' => $pajakakhirkt * -1,
                                 'tahunthr' => $tahun,
                                 'status' => 'K',
                                 'userid' => $request->userid,
                                 ]);
            // instunjpajak
            MasterThr::insert([
                                 'tahun' => $tahun,
                                 'bulan' => $bulan,
                                 'nopek' => $nopegkt,
                                 'aard' => 27,
                                 'nilai' => $pajakakhirkt,
                                 'tahunthr' => $tahun,
                                 'status' => 'K',
                                 'userid' => $request->userid,
                                 ]);
            // instunjangan
            MasterThr::insert([
                                 'tahun' => $tahun,
                                 'bulan' => $bulan,
                                 'nopek' => $nopegkt,
                                 'aard' => 25,
                                 'nilai' =>$thrgabkt,
                                 'tahunthr' => $tahun,
                                 'status' => 'K',
                                 'pajakgaji' => $pajakgajikt*12,
                                 'pajakthr' => $pajakakhirkt,
                                 'ut' => $upahallinkt,
                                 'pengali' => $pengalikt,
                                 'keterangan' => $keterangan,
                                 'userid' => $request->userid,
                                 'tbiayahidup' => $tunjdaerahkt,
                                 'tjabatan' => $tunjjabatankt,
                                 'koreksi' => $koreksikt,
                                 'potongan' => $bazmakt,
                                 ]);
 
            // inskoreksi
            MasterThr::insert([
                                 'tahun' => $tahun,
                                 'bulan' => $bulan,
                                 'nopek' => $nopegkt,
                                 'aard' => 32,
                                 'nilai' => $koreksikt,
                                 'tahunthr' => $tahun,
                                 'status' => 'K',
                                 'userid' => $request->userid,
                                 ]);
            // insbazma
            MasterThr::insert([
                                 'tahun' => $tahun,
                                 'bulan' => $bulan,
                                 'nopek' => $nopegkt,
                                 'aard' => 36,
                                 'nilai' => $bazmakt,
                                 'tahunthr' => $tahun,
                                 'status' => 'K',
                                 'userid' => $request->userid,
                                 ]);
        }

        return true;
    }

    public function startProsesThrPegawaiPerbantuan(Request $request, $tahun, $bulan, $tahungaji, $bulangaji, $keterangan)
    {
        // pekerjabantuthr()
        $data_pegawaibantub = DB::select("SELECT nopeg,status,kodekeluarga from sdm_master_pegawai where status='B' order by nopeg asc");
        
        foreach ($data_pegawaibantub as $data_pegawaikonpb) {
            $nopegpb = $data_pegawaikonpb->nopeg;
            $status1pb = $data_pegawaikonpb->status;
            $kodekelpb = $data_pegawaikonpb->kodekeluarga;
            if ($nopegpb == "070953") {
                $bulangaji=3;
            }

            // 1.cari upah all in 01
            $rsupahallinpb = DB::select("SELECT nilai from sdm_allin where nopek='$nopegpb'");
            if (!empty($rsupahallinpb)) {
                foreach ($rsupahallinpb as $data_uppb) {
                    if ($data_uppb->nilai <> "") {
                        $upahallinpb = $data_uppb->nilai;
                    } else {
                        $upahallinpb = '0';
                    }
                }
            } else {
                $upahallinpb= '0';
            }
            $pengalipb = 1;
            $thrgabpb =$upahallinpb;

            $rsupahtetappb = DB::select("SELECT a.ut from sdm_ut a where a.nopeg='$nopegpb' and a.mulai=(select max(mulai) from sdm_ut where nopeg='$nopegpb')");
            if (!empty($rsupahtetappb)) {
                foreach ($rsupahtetappb as $data_uptetappb) {
                    if ($data_uptetappb->ut <> "") {
                        $upahtetappb = $data_uptetappb->ut;
                    } else {
                        $upahtetappb = '0';
                    }
                }
            } else {
                $upahtetappb= '0';
            }

            $rsfasilitaspb = DB::select("SELECT nilai from pay_master_upah where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpb' and aard='06'");
            if (!empty($rsfasilitaspb)) {
                foreach ($rsfasilitaspb as $data_faspb) {
                    if ($data_faspb->nilai <> "") {
                        $fasilitaspb = $data_faspb->nilai;
                    } else {
                        $fasilitaspb = '0';
                    }
                }
            } else {
                $fasilitaspb= '0';
            }
           

            //    hitung pajak pph21
            $rskenapajak1pb = DB::select("SELECT sum(a.nilai) as nilai1 from pay_master_upah a,pay_tbl_aard b where a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegpb' and a.aard=b.kode and b.kenapajak='Y'");
            if (!empty($rskenapajak1pb)) {
                foreach ($rskenapajak1pb as $data_kenapapb) {
                    if ($data_kenapapb->nilai1 <> "") {
                        $nilaikenapajak1pb = $data_kenapapb->nilai1;
                    } else {
                        $nilaikenapajak1pb = '0';
                    }
                }
            } else {
                $nilaikenapajak1pb= '0';
            }

            $totkenapajakpb = (($nilaikenapajak1pb*12)+$fasilitaspb + $upahallinpb);
            //    cari nilai pengurang
            $biayajabatan2pb = ((5/100) * $totkenapajakpb);
            if ($biayajabatan2pb > 6000000) {
                $biayajabatanpb = 6000000;
            } else {
                $biayajabatanpb = $biayajabatan2pb;
            }

            $neto1tahunpb =  $totkenapajakpb - $biayajabatanpb;

            // cari nilai tidak kena pajak
            $rsptkppb = DB::select("SELECT a.kodekeluarga,b.nilai from sdm_master_pegawai a,pay_tbl_ptkp b where a.kodekeluarga=b.kdkel and a.nopeg='$nopegpb'");
            if (!empty($rsptkppb)) {
                foreach ($rsptkppb as $data_ptkppb) {
                    if ($data_ptkppb->nilai <> "") {
                        $nilaiptkp1pb = $data_ptkppb->nilai;
                    } else {
                        $nilaiptkp1pb = '0';
                    }
                }
            } else {
                $nilaiptkp1pb= '0';
            }
            
            $nilaikenapajakapb = $neto1tahunpb - $nilaiptkp1pb;
            $nilai2pb = 0;
            $nilai1pb = 0;
            $tunjanganpb = 0;
            $pajakbulanpb=1;
            $nilkenapajakpb = $nilaikenapajakapb;
            $sisapokokpb = $nilkenapajakpb;
            $data_sdmprogresifpb = DB::select("SELECT * from sdm_tbl_progressif order by awal asc");
            foreach ($data_sdmprogresifpb as $data_progpb) {
                $awalpb = $data_progpb->awal;
                $akhirpb = $data_progpb->akhir;
                $persenpb = $data_progpb->prosen;
                $prosenpb = $persenpb/100;
                $rangepb = $akhirpb - $awalpb;
                if ($sisapokokpb > 0) {
                    $sisapokok1pb = $sisapokokpb;
                    if ($sisapokok1pb > 0 and $sisapokok1pb < $rangepb) {
                        $pph21rpb = $sisapokok1pb * $prosenpb;
                    } elseif ($sisapokok1pb > 0 and $sisapokok1pb >= $rangepb) {
                        $pph21rpb = $rangepb * $prosenpb;
                    } else {
                        $pph21rpb = 0;
                    }
                } else {
                    $pph21rpb = 0;
                }
                $sisapokokpb = $sisapokok1pb - $rangepb;
                $pph21okpb =  $pph21rpb;
                $pajakbulanpb = pajak($nilaikenapajakapb);
                $nilaikenapajakpb=($nilkenapajakpb/1000)*1000;

                $selisihpb=$nilai2pb-$nilai1pb;
                $nilai1pb=$nilaikenapajakpb;
                $nilaikenapajakpb=(($nilaikenapajakpb+$pph21okpb)/1000)*1000;
                $nilai2pb=($nilaikenapajakpb/1000)*1000;
                $nilaikenapajakpb=(($nilaikenapajakpb-$selisihpb)/1000)*1000;
            }
            $tunjanganpb=$pajakbulanpb;
            $rstunjgajipb = DB::select("SELECT nilai from pay_master_upah where tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpb' and aard='27'");
            if (!empty($rstunjgajipb)) {
                foreach ($rstunjgajipb as $data_tunjpb) {
                    if ($data_tunjpb->nilai <> "") {
                        $pajakgajipb = $data_tunjpb->nilai;
                    } else {
                        $pajakgajipb = '0';
                    }
                }
            } else {
                $pajakgajipb= '0';
            }
                
              
            $pajakakhirpb = ($pajakbulanpb * 12)-($pajakgajipb*12);

            $rskoreksipb = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegpb' and aard='32'");
            if (!empty($rskoreksipb)) {
                foreach ($rskoreksipb as $data_korekspb) {
                    if ($data_korekspb->nilai <> "") {
                        $koreksipb = $data_korekspb->nilai;
                    } else {
                        $koreksipb = '0';
                    }
                }
            } else {
                $koreksipb= '0';
            }
            $rsbazmapb = DB::select("SELECT sum(nilai) as nilai from pay_potongan_thr where tahun='$tahun' and bulan='$bulan' and nopek='$nopegpb' and aard='36'");
            if (!empty($rsbazmapb)) {
                foreach ($rsbazmapb as $data_bazpb) {
                    if ($data_bazpb->nilai <> "") {
                        $bazmapb = $data_bazpb->nilai;
                    } else {
                        $bazmapb = '0';
                    }
                }
            } else {
                $bazmapb= '0';
            }
                
            // inspotpajak
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpb,
                    'aard' => 26,
                    'nilai' => $pajakakhirpb * -1,
                    'tahunthr' => $tahun,
                    'status' => 'B',
                    'userid' => $request->userid,
                    ]);
            // instunjpajak
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpb,
                    'aard' => 27,
                    'nilai' => $pajakakhirpb,
                    'tahunthr' => $tahun,
                    'status' => 'B',
                    'userid' => $request->userid,
                    ]);
            // instunjangan
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpb,
                    'aard' => 25,
                    'nilai' =>$thrgabpb,
                    'tahunthr' => $tahun,
                    'status' => 'B',
                    'pajakgaji' => $pajakgajipb*12,
                    'pajakthr' => $pajakakhirpb,
                    'ut' => $upahallinpb,
                    'pengali' => $pengalipb,
                    'keterangan' => $keterangan,
                    'userid' => $request->userid,
                    'tbiayahidup' => '0',
                    'tjabatan' => '0',
                    'koreksi' => $koreksipb,
                    'potongan' => $bazmapb,
                    ]);

            // inskoreksi
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpb,
                    'aard' => 32,
                    'nilai' => $koreksipb,
                    'tahunthr' => $tahun,
                    'status' => 'B',
                    'userid' => $request->userid,
                    ]);
            // insbazma
            MasterThr::insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nopek' => $nopegpb,
                    'aard' => 36,
                    'nilai' => $bazmapb,
                    'tahunthr' => $tahun,
                    'status' => 'B',
                    'userid' => $request->userid,
                    ]);
        }

        return true;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function slipThr()
    {
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");
        return view('modul-sdm-payroll.proses-thr.slip-thr', compact('data_pegawai'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function slipThrExport(Request $request)
    {
        $data_list = DB::select("SELECT a.nopek,round(a.jmlcc,0) as jmlcc,round(a.ccl,0) as ccl,round(a.nilai,0) as nilai,a.aard,a.bulan,a.tahun,b.nama as nama_pegawai, c.nama as nama_aard,d.nama as nama_upah, d.cetak from pay_master_thr a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode join pay_tbl_jenisupah d on c.jenis=d.kode where a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' and d.kode in ('02','10')");
        $data_detail = DB::select("SELECT 
        a.nopek,
        round(a.jmlcc,0) as jmlcc,
        round(a.ccl,0) as ccl,
        round(a.nilai,0) as nilai,
        a.aard,a.bulan,a.tahun,
        b.nama as nama_pegawai, 
        c.nama as nama_aard,
        d.nama as nama_upah, 
        d.cetak 
        from pay_master_thr a 
        join sdm_master_pegawai b 
        on a.nopek=b.nopeg 
        join pay_tbl_aard c 
        on a.aard=c.kode 
        join pay_tbl_jenisupah d 
        on c.jenis=d.kode 
        where a.nopek='$request->nopek' 
        and a.tahun='$request->tahun' 
        and bulan='$request->bulan' 
        and d.kode in ('07','03')");
        if (!empty($data_list) and !empty($data_detail)) {
            $pdf = DomPDF::loadview('modul-sdm-payroll.proses-thr.slip-thr-pdf', compact('request', 'data_list', 'data_detail'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            
            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(910, 120, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //slip thr landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_thr.slip_thr');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function rekapThr()
    {
        return view('modul-sdm-payroll.proses-thr.rekap-thr');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapThrExport(Request $request)
    {
        $data_list = DB::select("SELECT a.aard,a.bulan,a.tahun,a.nopek,a.koreksi,a.nilai,a.pengali,a.pajakthr,a.tbiayahidup,a.ut,a.tjabatan,a.status,a.potongan,b.nama as namapegawai from pay_master_thr a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard='25' and a.tahun='$request->tahun' and a.bulan='$request->bulan'");
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-sdm-payroll.proses-thr.rekap-thr-pdf', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_thr.rekap_thr');
        }
    }
}
