<?php

namespace App\Listeners;

use App\Events\ProsesInsentif;
use App\Models\MasterInsentif;
use App\Models\MasterPegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProsesInsentifKaryawanTetap implements ShouldQueue
{
    public $request;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  ProsesInsentif  $event
     * @return void
     */
    public function handle($event)
    {
        // 1.CARI PEGAWAI YANG STATUS PEKERJA TETAP
        // 2.Cari nilai Jamsostek
        // 3.Cari nilai kena pajak upah bulan sebelumnya
        // 4.HITUNG BIAYA JABATAN
        // inspotpajak // Insert Pit
        // instunjpajak //
        // inspotongan //
        // instunjangan //

        $tanggal = $this->request->tanggal;
        $data_tahun = substr($this->request->tanggal, -4);
        $data_bulan = ltrim(substr($this->request->tanggal, 0, -5), '0');
        $data_bulans = substr($this->request->tanggal, 0, -5);
        $upah = $this->request->upah;
        $tanggals = "1/$tanggal";
        $tahuns = $this->request->tahun;
        $keterangan = $this->request->keterangan;

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
                'userid' => $this->request->userid,
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
                'userid' => $this->request->userid,
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
                'userid' => $this->request->userid,
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
                'userid' => $this->request->userid,
            ]);
        }
    }
}
