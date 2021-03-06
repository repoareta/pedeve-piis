<?php

namespace App\Http\Controllers\SdmPayroll\ProsesPayroll;

use Alert;
use App\Http\Controllers\Controller;
use DB;
use DomPDF;
use Illuminate\Http\Request;
use App\Models\StatBayarInsentif;
use App\Models\MasterInsentif;

class ProsesInsentifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.proses-insentif.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-sdm-payroll.proses-insentif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_tahun = substr($request->tanggal, -4);
        $data_bulan = ltrim(substr($request->tanggal, 0, -5), '0');

        $data = MasterInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan);

        if ($request->prosesupah !== 'A') {
            $data = $data->where('status', $request->prosesupah);
        }

        if ($request->radioupah == 'proses') {

            if ($data->count() > 0) {
                Alert::Info("Data Insentif bulan $data_bulan dan tahun $data_tahun sudah pernah di proses", 'Info')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_insentif.index');
            }

            if ($request->prosesupah == 'A') {
                $this->prosesInsentifKaryawanTetap($request);
                $this->prosesInsentifKaryawanKontrak($request);
            } elseif ($request->prosesupah == 'C') {
                $this->prosesInsentifKaryawanTetap($request);
            } else {
                $this->prosesInsentifKaryawanKontrak($request);
            }

            $cekStatus = StatBayarInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan)->count();

            if ($cekStatus > 0) {
                StatBayarInsentif::where('tahun', $data_tahun)
                    ->where('bulan', $data_bulan)
                    ->update([
                        'status' => 'N',
                    ]);
            } else {
                StatBayarInsentif::insert([
                    'tahun' => $data_tahun,
                    'bulan' => $data_bulan,
                    'status' => 'N',
                ]);
            }

            Alert::success("Data Insentif bulan $data_bulan dan tahun $data_tahun berhasil di proses ", 'Berhasil')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_insentif.index');
        }

        $cekStatusBayar = StatBayarInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan)->first()->status;

        if ($cekStatusBayar == 'N') {
            if ($data->count() > 0) {
                if ($request->prosesupah == 'A') {
                    MasterInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                    StatBayarInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan)->delete();
                } else {
                    MasterInsentif::where('tahun', $data_tahun)->where('bulan', $data_bulan)->where('status', $request->prosesupah)->delete();
                }

                Alert::success("Proses pembatalan proses Insentif selesai", 'Berhasil')->persistent(true);
                return redirect()->route('modul_sdm_payroll.proses_insentif.index');
            }

            Alert::info("Tidak ditemukan data insentif bulan $data_bulan dan tahun $data_tahun", 'Info')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_insentif.index');
        }

        Alert::info("Tidak bisa dibatalkan Data Insentif bulan $data_bulan tahun $data_tahun sudah di proses perbendaharaan", 'Info')->persistent(true);
        return redirect()->route('modul_sdm_payroll.proses_insentif.index');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function slipInsentif()
    {
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama FROM sdm_master_pegawai WHERE status <>'P' order by nopeg");
        return view('modul-sdm-payroll.proses-insentif.slip-insentif', compact('data_pegawai'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function slipInsentifExport(Request $request)
    {
        $data_list = DB::select("SELECT a.nopek,round(a.jmlcc,0) as jmlcc,round(a.ccl,0) as ccl,round(a.nilai,0) as nilai,a.aard,a.bulan,a.tahun,b.nama as nama_pegawai, c.nama as nama_aard,d.nama as nama_upah, d.cetak FROM pay_master_insentif a JOIN sdm_master_pegawai b on a.nopek=b.nopeg JOIN pay_tbl_aard c on a.aard=c.kode JOIN pay_tbl_jenisupah d on c.jenis=d.kode WHERE a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' and d.kode in ('02','10')");
        $data_detail = DB::select("SELECT a.nopek,round(a.jmlcc,0) as jmlcc,round(a.ccl,0) as ccl,round(a.nilai,0) as nilai,a.aard,a.bulan,a.tahun,b.nama as nama_pegawai, c.nama as nama_aard,d.nama as nama_upah, d.cetak FROM pay_master_insentif a JOIN sdm_master_pegawai b on a.nopek=b.nopeg JOIN pay_tbl_aard c on a.aard=c.kode JOIN pay_tbl_jenisupah d on c.jenis=d.kode WHERE a.nopek='$request->nopek' and a.tahun='$request->tahun' and bulan='$request->bulan' and d.kode in ('03','07')");
        if (!empty($data_list) and !empty($data_detail)) {
            $pdf = DomPDF::loadview('modul-sdm-payroll.proses-insentif.slip-insentif-pdf', compact('request', 'data_list', 'data_detail'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(910, 120, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_insentif.slip_insentif');
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function rekapInsentif()
    {
        return view('modul-sdm-payroll.proses-insentif.rekap-insentif');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapInsentifExport(Request $request)
    {
        $data_list = DB::select("SELECT
            a.status,
            a.nopek,
            a.nilai,
            a.ut,
            a.pajakins,
            b.nama AS namapegawai
            FROM pay_master_insentif a
            JOIN sdm_master_pegawai b
            on a.nopek=b.nopeg
            WHERE a.aard='24'
            and a.tahun='$request->tahun'
            and a.bulan='$request->bulan'
        ");
        $subtotala = [];
        $subtotala1 = [];
        $subtotala2 = [];
        $subtotala3 = [];

        $subtotalb = [];
        $subtotalb1 = [];
        $subtotalb2 = [];
        $subtotalb3 = [];

        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-sdm-payroll.proses-insentif.rekap-insentif-pdf', compact(
                'request',
                'data_list',
                'subtotala',
                'subtotala1',
                'subtotala2',
                'subtotala3',
                'subtotalb',
                'subtotalb1',
                'subtotalb2',
                'subtotalb3',
            ))
                ->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('modul_sdm_payroll.proses_insentif.rekap_insentif');
        }
    }

    private function prosesInsentifKaryawanTetap(Request $request)
    {
        $tanggal = $request->tanggal;
        $data_tahun = substr($request->tanggal, -4);
        $data_bulan = ltrim(substr($request->tanggal, 0, -5), '0');
        $data_bulans = substr($request->tanggal, 0, -5);
        $upah = $request->upah;
        $tanggals = "1/$tanggal";
        $tahuns = $request->tahun;
        $keterangan = $request->keterangan;

        if ($data_bulan - 1 == 0) {
            $bulangaji = "12";
            $tahungaji = $data_tahun - 1;
        } else {
            $bulangaji = $data_bulan - 1;
            $tahungaji = $data_tahun;
        }

        // 1.CARI PEGAWAI YANG STATUS PEKERJA TETAP
        $data_caripegawaic = DB::select("SELECT nopeg,kodekeluarga FROM sdm_master_pegawai WHERE status='C' order by nopeg asc");
        foreach ($data_caripegawaic as $data_caript) {
            $nopegpt = $data_caript->nopeg;
            $kodekel = $data_caript->kodekeluarga;

            $data_upahtetappt = DB::select("SELECT a.ut FROM sdm_ut a WHERE a.nopeg='$nopegpt' and a.mulai=(select max(mulai) FROM sdm_ut WHERE nopeg='$nopegpt')");
            if (!empty($data_upahtetappt)) {
                foreach ($data_upahtetappt as $data_upahpt) {
                    if ($data_upahpt->ut <> "") {
                        $upahtetappt = $data_upahpt->ut;
                    } else {
                        $upahtetappt = '0';
                    }
                }
            } else {
                $upahtetappt = '0';
            }
            $pengalipt = $upah;
            $insentifpt = $upahtetappt * $upah;

            // 2.Cari nilai Jamsostek
            $data_carijamsostekpt = DB::select("SELECT curramount FROM pay_master_bebanprshn WHERE tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='10'");
            if (!empty($data_carijamsostekpt)) {
                foreach ($data_carijamsostekpt as $data_carijampt) {
                    if ($data_carijampt->curramount <> "") {
                        $niljstaccidentpt = $data_carijampt->curramount;
                    } else {
                        $niljstaccidentpt = '0';
                    }
                }
            } else {
                $niljstaccidentpt = '0';
            }

            $data_jslifept = DB::select("SELECT curramount FROM pay_master_bebanprshn WHERE tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='12'");
            if (!empty($data_jslifept)) {
                foreach ($data_jslifept as $data_carilifept) {
                    if ($data_carilifept->curramount <> "") {
                        $niljstlifept = $data_carilifept->curramount;
                    } else {
                        $niljstlifept = '0';
                    }
                }
            } else {
                $niljstlifept = '0';
            }

            $data_fasilitaspt = DB::select("SELECT nilai FROM pay_master_upah WHERE tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='06'");
            if (!empty($data_fasilitaspt)) {
                foreach ($data_fasilitaspt as $data_fasilpt) {
                    if ($data_fasilpt->nilai <> "") {
                        $fasilitaspt = $data_fasilpt->nilai;
                    } else {
                        $fasilitaspt = '0';
                    }
                }
            } else {
                $fasilitaspt = '0';
            }

            // 3.Cari nilai kena pajak upah bulan sebelumnya
            $data_kenapajakpt = DB::select("SELECT sum(a.nilai) as nilai1 FROM pay_master_upah a,pay_tbl_aard b WHERE a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegpt' and a.aard=b.kode and b.kenapajak='Y'");
            if (!empty($data_kenapajakpt)) {
                foreach ($data_kenapajakpt as $data_kenappt) {
                    if ($data_kenappt->nilai1 <> "") {
                        $nilaikenapajak1pt = $data_kenappt->nilai1;
                    } else {
                        $nilaikenapajak1pt = '0';
                    }
                }
            } else {
                $nilaikenapajak1pt = '0';
            }

            $data_koreksigajipt = DB::select("SELECT sum(a.nilai) as kortam FROM pay_koreksigaji a WHERE a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopegpt'");
            if (!empty($data_koreksigajipt)) {
                foreach ($data_koreksigajipt as $data_koreksigpt) {
                    if ($data_koreksigpt->kortam <> "") {
                        $kortampt = $data_koreksigpt->kortam;
                    } else {
                        $kortampt = '0';
                    }
                }
            } else {
                $kortampt = '0';
            }

            $totkenapajakpt = ((($nilaikenapajak1pt + $niljstaccidentpt + $niljstlifept) * 12) + $fasilitaspt + $kortampt + $insentifpt);

            // 4.HITUNG BIAYA JABATAN
            $biayajabatan2pt = ((5 / 100) * $totkenapajakpt);
            if ($biayajabatan2pt > 6000000) {
                $biayajabatanpt = 6000000;
            } else {
                $biayajabatanpt = $biayajabatan2pt;
            }

            $neto1tahunpt =  $totkenapajakpt - $biayajabatanpt;

            $data_ptkppt = DB::select("SELECT a.kodekeluarga,b.nilai FROM sdm_master_pegawai a,pay_tbl_ptkp b WHERE a.kodekeluarga=b.kdkel and a.nopeg='$nopegpt'");
            if (!empty($data_ptkppt)) {
                foreach ($data_ptkppt as $data_ppt) {
                    if ($data_ppt->nilai <> "") {
                        $nilaiptkp1pt = $data_ppt->nilai;
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
            $pajakbulanpt = 1;
            $nilkenapajakpt = $nilaikenapajakapt;
            $sisapokokpt = $nilkenapajakpt;
            $data_sdmprogresif = DB::select("SELECT * FROM sdm_tbl_progressif order by awal asc");
            foreach ($data_sdmprogresif as $data_progpt) {
                $awalpt = $data_progpt->awal;
                $akhirpt = $data_progpt->akhir;
                $persenpt = $data_progpt->prosen;
                $prosenpt = $persenpt / 100;
                $rangept = $akhirpt - $awalpt;
                if ($sisapokokpt > 0) {
                    $sisapokokpt = $sisapokokpt;
                    if ($sisapokokpt > 0 and $sisapokokpt < $rangept) {
                        $pph21rpt = $sisapokokpt * $prosenpt;
                    } elseif ($sisapokokpt > 0 and $sisapokokpt >= $rangept) {
                        $pph21rpt = $rangept * $prosenpt;
                    } else {
                        $pph21rpt = 0;
                    }
                } else {
                    $pph21rpt = 0;
                }
                $sisapokokpt = $sisapokokpt - $rangept;
                $pph21okpt =  $pph21rpt;
                $pajakbulanpt = pajak($nilaikenapajakapt);
                $nilaikenapajakpt = ($nilkenapajakpt / 1000) * 1000;

                $selisihpt = $nilai2pt - $nilai1pt;
                $nilai1pt = $nilaikenapajakpt;
                $nilaikenapajakpt = (($nilaikenapajakpt + $pph21okpt) / 1000) * 1000;
                $nilai2pt = ($nilaikenapajakpt / 1000) * 1000;
                $nilaikenapajakpt = (($nilaikenapajakpt - $selisihpt) / 1000) * 1000;
            }
            $tunjanganpt = $pajakbulanpt;


            $data_stungajipt = DB::select("SELECT nilai FROM pay_master_upah WHERE tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopegpt' and aard='27'");
            if (!empty($data_stungajipt)) {
                foreach ($data_stungajipt as $data_stpt) {
                    if ($data_stpt->nilai <> "") {
                        $pajakgajipt = $data_stpt->nilai;
                    } else {
                        $pajakgajipt = '0';
                    }
                }
            } else {
                $pajakgajipt = '0';
            }
            $pajakakhirpt = ($pajakbulanpt - $pajakgajipt) * 12;

            $data_potonganpt = DB::select("SELECT nilai as nilai FROM pay_potongan_insentif WHERE tahun='$data_tahun' and bulan='$$data_bulan' and nopek='$nopegpt'");
            if (!empty($data_potonganpt)) {
                foreach ($data_potonganpt as $data_potpt) {
                    if ($data_potpt->nilai <> "") {
                        $potonganinsentifpt = $data_potpt->nilai;
                    } else {
                        $potonganinsentifpt = '0';
                    }
                }
            } else {
                $potonganinsentifpt = '0';
            }
            // inspotpajak
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopegpt,
                'aard' => 26,
                'nilai' => $pajakakhirpt * -1,
                'tahunins' => $tahuns,
                'status' => 'C',
                'userid' => $request->userid,
            ]);
            // instunjpajak
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopegpt,
                'aard' => 27,
                'nilai' => $pajakakhirpt,
                'tahunins' => $tahuns,
                'status' => 'C',
                'userid' => $request->userid,
            ]);
            // inspotongan
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopegpt,
                'aard' => 19,
                'nilai' => $potonganinsentifpt,
                'tahunins' => $tahuns,
                'status' => 'C',
                'userid' => $request->userid,
            ]);
            // instunjangan
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopegpt,
                'aard' => 24,
                'nilai' => $insentifpt,
                'tahunins' => $tahuns,
                'status' => 'C',
                'pajakgaji' => $pajakgajipt * 12,
                'pajakins' => $pajakakhirpt,
                'ut' => $upahtetappt,
                'pengali' => $pengalipt,
                'keterangan' => $keterangan,
                'potongan' => $potonganinsentifpt,
                'userid' => $request->userid,
            ]);
        }
    }

    private function prosesInsentifKaryawanKontrak(Request $request)
    {
        $tanggal = $request->tanggal;
        $data_tahun = substr($request->tanggal, -4);
        $data_bulan = ltrim(substr($request->tanggal, 0, -5), '0');
        $data_bulans = substr($request->tanggal, 0, -5);
        $upah = $request->upah;
        $tanggals = "1/$tanggal";
        $tahuns = $request->tahun;
        $keterangan = $request->keterangan;

        if ($data_bulan - 1 == 0) {
            $bulangaji = "12";
            $tahungaji = $data_tahun - 1;
        } else {
            $bulangaji = $data_bulan - 1;
            $tahungaji = $data_tahun;
        }

        // pekerjakontrakins()
        // 1.CARI PEGAWAI YANG STATUS PEKERJA Kontrak
        $data_caripegawaipk = DB::select("SELECT nopeg,kodekeluarga FROM sdm_master_pegawai WHERE status='K' order by nopeg asc");
        foreach ($data_caripegawaipk as $data_carikt) {
            $nopeg = $data_carikt->nopeg;
            $kodekel = $data_carikt->kodekeluarga;

            // 1. UPAHALLIN
            $data_upahkt = DB::select("SELECT nilai FROM sdm_allin WHERE nopek='$nopeg'");
            if (!empty($data_upahkt)) {
                foreach ($data_upahkt as $data_upkt) {
                    if ($data_upkt->nilai <> "") {
                        $upahallinkt = $data_upkt->nilai;
                    } else {
                        $upahallinkt = '0';
                    }
                }
            } else {
                $upahallinkt = '0';
            }

            $insentifkt = $upahallinkt * $upah;

            $data_kenapajakkt = DB::select("SELECT sum(a.nilai) as nilai1 FROM pay_master_upah a,pay_tbl_aard b WHERE a.tahun='$tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopeg' and a.aard=b.kode and b.kenapajak='Y'");
            if (!empty($data_kenapajakkt)) {
                foreach ($data_kenapajakkt as $data_kenakt) {
                    if ($data_kenakt->nilai1 <> "") {
                        $nilaikenapajak1kt  = $data_kenakt->nilai1;
                    } else {
                        $nilaikenapajak1kt  = '0';
                    }
                }
            } else {
                $nilaikenapajak1kt = '0';
            }

            $data_korgajikt = DB::select("SELECT sum(a.nilai) as kortam FROM pay_koreksigaji a WHERE a.tahun='tahungaji' and a.bulan='$bulangaji' and a.nopek='$nopeg'");
            foreach ($data_korgajikt as $data_korkt) {
                $kortam2kt = $data_korkt->kortam;
            }

            $totkenapajakkt = (($nilaikenapajak1kt * 12) + $kortam2kt + $insentifkt);
            $biayajabatan2kt = ((5 / 100) * $totkenapajakkt);
            if ($biayajabatan2kt > 6000000) {
                $biayajabatankt = 6000000;
            } else {
                $biayajabatankt = $biayajabatan2kt;
            }

            $neto1tahunkt =  $totkenapajakkt - $biayajabatankt;

            $data_ptkpkt = DB::select("SELECT a.kodekeluarga,b.nilai FROM sdm_master_pegawai a,pay_tbl_ptkp b WHERE a.kodekeluarga=b.kdkel and a.nopeg='$nopeg'");
            if (!empty($data_ptkpkt)) {
                foreach ($data_ptkpkt as $data_ptkt) {
                    if ($data_ptkt->nilai <> "") {
                        $nilaiptkp1kt  = $data_ptkt->nilai;
                    } else {
                        $nilaiptkp1kt  = '0';
                    }
                }
            } else {
                $nilaiptkp1kt = '0';
            }

            $nilaikenapajakakt = $neto1tahunkt - $nilaiptkp1kt;


            $nilai2kt = 0;
            $nilai1kt = 0;
            $tunjangankt = 0;
            $pajakbulankt = 1;
            $nilkenapajakkt = $nilaikenapajakakt;
            $sisapokokkt = $nilkenapajakkt;
            $sisapokok1kt = $sisapokokkt;
            $data_sdmprogresif = DB::select("SELECT * FROM sdm_tbl_progressif order by awal asc");
            foreach ($data_sdmprogresif as $data_progkt) {
                $awalkt = $data_progkt->awal;
                $akhirkt = $data_progkt->akhir;
                $persenkt = $data_progkt->prosen;
                $prosenkt = $persenkt / 100;
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
                $nilaikenapajakkt = ($nilkenapajakkt / 1000) * 1000;

                $selisihkt = $nilai2kt - $nilai1kt;
                $nilai1kt = $nilaikenapajakkt;
                $nilaikenapajakkt = (($nilaikenapajakkt + $pph21okkt) / 1000) * 1000;
                $nilai2kt = ($nilaikenapajakkt / 1000) * 1000;
                $nilaikenapajakkt = (($nilaikenapajakkt - $selisihkt) / 1000) * 1000;
            }
            $tunjangankt = $pajakbulankt;

            $data_tunjgajikt = DB::select("SELECT nilai FROM pay_master_upah WHERE tahun='$tahungaji' and bulan='$bulangaji' and nopek='$nopeg' and aard='27'");
            if (!empty($data_tunjgajikt)) {
                foreach ($data_tunjgajikt as $data_tunjkt) {
                    if ($data_tunjkt->nilai <> "") {
                        $pajakgajikt  = $data_tunjkt->nilai;
                    } else {
                        $pajakgajikt  = '0';
                    }
                }
            } else {
                $pajakgajikt = '0';
            }

            $pajakakhirkt = ($pajakbulankt - $pajakgajikt) * 12;

            $data_potongankt = DB::select("SELECT nilai as nilai FROM pay_potongan_insentif WHERE tahun='$data_tahun' and bulan='$data_bulan' and nopek='$nopeg'");
            if (!empty($data_potongankt)) {
                foreach ($data_potongankt as $data_potkt) {
                    if ($data_potkt->nilai <> "") {
                        $potonganinsentifkt  = $data_potkt->nilai;
                    } else {
                        $potonganinsentifkt  = '0';
                    }
                }
            } else {
                $potonganinsentifkt = '0';
            }

            // inspotpajak
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopeg,
                'aard' => 26,
                'nilai' => $pajakakhirkt * -1,
                'tahunins' => $tahuns,
                'status' => 'K',
                'userid' => $request->userid,
            ]);
            // instunjpajak
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopeg,
                'aard' => 27,
                'nilai' => $pajakakhirkt,
                'tahunins' => $tahuns,
                'status' => 'K',
                'userid' => $request->userid,
            ]);
            // inspotongan
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopeg,
                'aard' => 19,
                'nilai' => $potonganinsentifkt,
                'tahunins' => $tahuns,
                'status' => 'K',
                'userid' => $request->userid,
            ]);
            // instunjangan
            MasterInsentif::insert([
                'tahun' => $data_tahun,
                'bulan' => $data_bulan,
                'nopek' => $nopeg,
                'aard' => 24,
                'nilai' => $insentifkt,
                'tahunins' => $tahuns,
                'status' => 'K',
                'pajakgaji' => $pajakgajikt * 12,
                'pajakins' => $pajakakhirkt,
                'ut' => $upahallinkt,
                'pengali' => $upah,
                'keterangan' => $keterangan,
                'potongan' => $potonganinsentifkt,
                'userid' => $request->userid,
            ]);
        }
    }
}
