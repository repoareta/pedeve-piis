<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Http\Requests\PembayaranGajiStoreRequest;
use App\Models\CashJudex;
use App\Models\JenisBiaya;
use App\Models\Kasdoc;
use App\Models\Kasline;
use App\Models\Lokasi;
use App\Models\SaldoStore;
use App\Models\SdmKDBag;
use App\Models\SimpanRcGaji;
use App\Models\StatusBayarGaji;
use DB;
use DomPDF;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");

        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                $tahun = substr($data_bul->bulan_buku, 0, -2);
                $bulan = substr($data_bul->bulan_buku, 4);
            }
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }

        return view('modul-treasury.pembayaran-gaji.index', compact('tahun', 'bulan'));
    }

    public function indexJson(Request $request)
    {
        $data_rsbulan = DB::select("SELECT max(thnbln) as thnbln from timetrans where status='1' and length(thnbln)=6");
        if (!empty($data_rsbulan)) {
            foreach ($data_rsbulan as $rsbulan) {
                if (is_null($rsbulan->thnbln)) {
                    $thnblopen = "";
                } else {
                    $thnblopen = $rsbulan->thnbln;
                }
            }
        } else {
            $thnblopen = "";
        }
        $s = $thnblopen;
        $nodok = $request->bukti;
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        if ($nodok == "" and $tahun == "" and $bulan == "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.verified,a.nilai_dok,a.paid from kasdoc a where thnbln='$s' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where thnbln='$s' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } elseif ($nodok <> "" and $tahun == "" and $bulan == "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.verified,a.nilai_dok,a.paid from kasdoc a where a.voucher='$nodok' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where voucher='$nodok' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } elseif ($nodok <> "" and $tahun <> "" and $bulan == "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.verified,a.nilai_dok,a.paid from kasdoc a where a.voucher='$nodok' and left(a.thnbln, 4)='$tahun' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where voucher='$nodok' and left(thnbln, 4)='$tahun' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } elseif ($nodok == "" and $tahun <> "" and $bulan == "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.verified,a.paid from kasdoc a where left(thnbln, 4)='$tahun'  and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc ");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where left(thnbln, 4)='$tahun' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } elseif ($nodok == "" and $tahun <> "" and $bulan <> "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.verified,a.paid from kasdoc a where left(thnbln, 4)='$tahun' and SUBSTRING(thnbln, 5, 2)='$bulan' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc ");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where left(thnbln, 4)='$tahun' and SUBSTRING(thnbln, 5, 2)='$bulan' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } elseif ($nodok == "" and $tahun == "" and $bulan <> "") {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.nilai_dok as nilai_dok,a.verified,a.paid from kasdoc a where SUBSTRING(thnbln, 5, 2)='$bulan' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc ");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where  SUBSTRING(thnbln, 5, 2)='$bulan' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        } else {
            $data = DB::select("SELECT (select namabank from storejk where kodestore=a.store and ci=a.ci) as namastore, a.docno,a.originaldate,a.thnbln,a.jk,a.store,a.ci,a.voucher,a.kepada,a.rate,a.verified,a.nilai_dok,a.paid from kasdoc a where a.voucher='$nodok' and left(a.thnbln, 4)='$tahun' and SUBSTRING(thnbln, 5, 2)='$bulan' and a.kd_kepada LIKE 'PG%' order by a.store,a.voucher asc");
            $data_objrs2 = DB::select("SELECT sum(nilai_dok) as jml from kasdoc where voucher='$nodok' and left(thnbln, 4)='$tahun' and SUBSTRING(thnbln, 5, 2)='$bulan' and kd_kepada='PG'");
            if (!empty($data_objrs2)) {
                foreach ($data_objrs2 as $objrs2) {
                    $jumlahnya = $objrs2->jml;
                }
            } else {
                $jumlahnya = 0;
            }
        }
        return datatables()->of($data)
            ->addColumn('docno', function ($data) {
                return $data->docno;
            })
            ->addColumn('tanggalinput', function ($data) {
                $tgl = date_create($data->originaldate);
                return date_format($tgl, 'd/m/Y');
            })
            ->addColumn('nobukti', function ($data) {
                return $data->voucher;
            })
            ->addColumn('kepada', function ($data) {
                return $data->kepada;
            })
            ->addColumn('jk', function ($data) {
                return $data->jk;
            })
            ->addColumn('nokas', function ($data) {
                return $data->store . ' -- ' . $data->namastore;
            })
            ->addColumn('ci', function ($data) {
                return $data->ci;
            })
            ->addColumn('kurs', function ($data) {
                return $data->rate;
            })
            ->addColumn('nilai', function ($data) {
                if ($data->nilai_dok  == "") {
                    $nilai = 0;
                } else {
                    $nilai = number_format($data->nilai_dok, 2, '.', ',');
                }
                return $nilai;
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" value="' . $data->docno . '" docno="' . str_replace('/', '-', $data->docno) . '" class="btn-radio" name="btn-radio"><span></span></label>';
                return $radio;
            })
            ->addColumn('action', function ($data) {
                if ($data->verified == 'Y') {
                    $action = '<span class="pointer-link" title="Data Sudah DiVerifikasi"><i class="fas fa-check-circle fa-2x text-success"></i></span>';
                } else {
                    if ($data->paid == 'Y') {
                        $action = '<a href="' . route('pembayaran_gaji.approv', ['id' => str_replace('/', '-', $data->docno), 'status' => $data->paid]) . '"><span class="pointer-link" title="Batalkan Pembayaran"><i class="fas fa-check-circle fa-2x text-success"></i></span></a>';
                    } else {
                        $action = '<a href="' . route('pembayaran_gaji.approv', ['id' => str_replace('/', '-', $data->docno), 'status' => $data->paid]) . '"><span class="pointer-link" title="Klik untuk Pembayaran"><i class="fas fa-ban fa-2x text-danger"></i></span></a>';
                    }
                }
                return $action;
            })
            ->rawColumns(['radio', 'action'])
            ->make(true);
    }

    public function create()
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                if ($data_bul->bulan_buku <> null) {
                    $bulan_buku = $data_bul->bulan_buku;
                } else {
                    $bulan_buku = date_format(date_create(now()), 'Ym');
                }
            }
        } else {
            $bulan_buku = date_format(date_create(now()), 'Ym');
        }
        $mp = 'P';
        if ($mp == "P") {
            $darkep = "Kepada";
            $datas = DB::select("SELECT Max(left(mrs_no,4)) as nover from Kasdoc Where substr(DocNo,1,1)='P' and left(THNBLN,4)='$bulan_buku'");
            foreach ($datas as $data) {
                if ($data->nover <> null) {
                    $da = '2' . ($data->nover + 1);
                    $nover = substr($da, 1, 4);
                } else {
                    $nover = '0001';
                }
            }
        } else {
            $darkep = "Dari";
            $nover = '0';
        }
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                if ($data_bul->bulan_buku <> null) {
                    $bulan_buku = $data_bul->bulan_buku;
                } else {
                    $bulan_buku = date_format(date_create(now()), 'Ym');
                }
            }
        } else {
            $bulan_buku = date_format(date_create(now()), 'Ym');
        }
        $bulan = substr($bulan_buku, 4);
        $tahun = substr($bulan_buku, 0, -2);
        $data_bagian = SdmKdbag::all();
        return view('modul-treasury.pembayaran-gaji.create', compact('mp', 'data_bagian', 'tahun', 'bulan', 'bulan_buku', 'darkep', 'nover'));
    }

    public function createJson(Request $request)
    {
        $datas = DB::select("SELECT MAX(SUBSTR(docno,13,3)) as id from Kasdoc where SUBSTR(docno,3,5)='$request->bagian' and thnbln='$request->bulanbuku' and SUBSTR(docno,1,1)='$request->mp'");
        if (!empty($datas)) {
            foreach ($datas as $dataa) {
                if ($dataa->id <> null) {
                    $data = $dataa->id;
                } else {
                    $data = '000';
                }
            }
        } else {
            $data = '000';
        }
        return response()->json($data);
    }
    public function lokasiJson(Request $request)
    {
        $data = DB::select("SELECT a.kodestore,a.namabank,a.norekening from storejk a where a.jeniskartu ='$request->jk' and a.ci='$request->ci' order by a.kodestore");
        return response()->json($data);
    }

    public function nobuktiJson(Request $request)
    {
        $datas = DB::select("SELECT max(voucher) as nb from kasdoc where SUBSTR(thnbln,1,4)='$request->tahun' and store='$request->lokasi' and SUBSTR(docno,1,1)='$request->mp'");
        if (!empty($datas)) {
            foreach ($datas as $dataa) {
                if ($dataa->nb <> null) {
                    $da = '2' . ($dataa->nb + 1);
                    $data = substr($da, 1, 4);
                } else {
                    $data = '0001';
                }
            }
        } else {
            $data = '0001';
        }
        return response()->json($data);
    }

    public function store(PembayaranGajiStoreRequest $request)
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        if (!empty($data_tahunbulan)) {
            foreach ($data_tahunbulan as $data_bul) {
                if ($data_bul->bulan_buku <> null) {
                    $bulan_buku = $data_bul->bulan_buku;
                } else {
                    $bulan_buku = '0';
                }
            }
        } else {
            $bulan_buku = '0';
        }
        $data_status = DB::select("SELECT * from timetrans where thnbln='$bulan_buku' and suplesi='0'");
        if (!empty($data_status)) {
            foreach ($data_status as $data_st) {
                if ($data_st->status == '1') {
                    $stbbuku = 'gtopening';
                } elseif ($data_st->status == '2') {
                    $stbbuku = 'gtstopping';
                } elseif ($data_st->status == '3') {
                    $stbbuku = 'gtclosing';
                } else {
                    $stbbuku = 'gtnone';
                }
            }
        } else {
            $stbbuku = 'gtnone';
        }

        $mp = $request->mp;
        $bagian = $request->bagian;
        $nomor = $request->nomor;
        $scurrdoc = $mp . '/' . $bagian . '/' . $nomor;
        $docno = $scurrdoc;
        $thnbln = $request->bulanbuku;
        $jk = $request->jk;
        $store = $request->lokasi;
        $ci = $request->ci;
        $voucher = $request->nobukti;
        $kepada = $request->kepada;
        $debet = "0";
        $kredit = "0";
        $original = "Y";
        $originaldate = $request->tanggal;
        $verified = "N";
        $paid = "N";
        $posted = "N";
        $inputdate = $request->tanggal;
        $inputpwd = $request->userid;
        $updatedate = $request->tanggal;
        $updatepwd = $request->userid;
        $rate = $request->kurs;
        $nilai_dok = sanitize_nominal($request->nilai);
        $originalby = $request->userid;
        $ket1 = $request->ket1;
        $ket2 = $request->ket2;
        $ket3 = $request->ket3;
        $kodekepada = 'PG';
        $nover = $request->nover;
        if ($stbbuku == 'gtopening') {

            $data_cek = DB::select("SELECT * from kasdoc where docno='$docno'");
            if (!empty($data_cek)) {
                $data = 0;
                return response()->json($data);
            } else {
                Kasdoc::insert([
                    'docno' =>  $docno,
                    'thnbln' =>  $thnbln,
                    'jk' =>  $jk,
                    'store' =>  $store,
                    'ci' =>  $ci,
                    'voucher' =>  $voucher,
                    'kepada' =>  $kepada,
                    'debet'  => '0',
                    'kredit'  => '0',
                    'original' =>  $original,
                    'originaldate' =>  $originaldate,
                    'verified' =>  $verified,
                    'paid' =>  $paid,
                    'posted' =>  $posted,
                    'inputdate' =>  $inputdate,
                    'inputpwd' =>  $inputpwd,
                    'updatedate' =>  $updatedate,
                    'updatepwd' =>  $updatepwd,
                    'rate' =>  $rate,
                    'nilai_dok' =>  $nilai_dok,
                    'originalby' =>  $originalby,
                    'ket1' =>  $ket1,
                    'ket2' =>  $ket2,
                    'ket3' =>  $ket3,
                    'kd_kepada' =>  $kodekepada,
                    'mrs_no' =>  $nover,
                ]);
                $data = 1;
                return response()->json($data);
            }
        } else {
            $data = 2;
            return response()->json($data);
        }
    }

    public function edit($id)
    {
        $nodoc = str_replace('-', '/', $id);
        $data = DB::table('kasdoc')
            ->join('storejk', 'kasdoc.store', '=', 'storejk.kodestore')
            ->select('kasdoc.*', 'storejk.*')
            ->where('docno', $nodoc)
            ->first();
        $datenew = date('Y-m-d');
        $tgl = date_create($datenew);
        $tahuns = date_format($tgl, 'Y');
        $bulans = date_format($tgl, 'n');
        $lokasi = Lokasi::all();
        $data_jenis = JenisBiaya::all();
        $data_casj = CashJudex::all();
        $data_bagian = SdmKDBag::all();
        $data_rincian = DB::select("SELECT p.tahun, p.bulan,sum(p.nilai) as nilai,'TETAP' as status from pay_master_upah p where tahun='$tahuns' and bulan='$bulans' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='C') group by tahun,bulan union all
                                    select p.tahun, p.bulan,sum(p.nilai) as nilai,'KONTRAK' as status from pay_master_upah p where tahun='$tahuns' and bulan='$bulans' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='K') group by tahun,bulan union all
                                    select p.tahun, p.bulan,sum(p.nilai) as nilai,'PERBANTUAN' as status from pay_master_upah p where tahun='$tahuns' and bulan='$bulans' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='B') group by tahun,bulan union all
                                    select p.tahun, p.bulan,sum(p.nilai) as nilai,'KOMISARIS' as status from pay_master_upah p where tahun='$tahuns' and bulan='$bulans' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='U') group by tahun,bulan union all
                                    select p.tahun, p.bulan, sum(p.nilai) as nilai,'KOMITE' as status from pay_master_upah p where tahun='$tahuns' and bulan='$bulans' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='O') group by tahun,bulan;
                                    ");
        $data_account = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%'");
        $count = Kasline::where('docno', $nodoc)->sum('totprice');
        $data_detail = Kasline::where('docno', $nodoc)->get();
        $no_detail = Kasline::where('docno', $nodoc)->max('lineno');
        if ($no_detail <> null) {
            $no_urut = $no_detail + 1;
        } else {
            $no_urut = 1;
        }

        return view('modul-treasury.pembayaran-gaji.edit', compact(
            'data_rincian',
            'data',
            'data_bagian',
            'data_detail',
            'count',
            'no_urut',
            'lokasi',
            'data_account',
            'data_jenis',
            'data_casj',
            'tahuns',
            'bulans'
        ));
    }
    public function update(PembayaranGajiStoreRequest $request)
    {
        Kasdoc::where('docno', $request->nodok)
            ->update([
                'thnbln' =>  $request->bulanbuku,
                'jk' =>  $request->jk,
                'store' =>  $request->lokasi,
                'ci' =>  $request->ci,
                'voucher' =>  $request->nobukti,
                'kepada' =>  $request->kepada,
                'rate' =>  $request->kurs,
                'nilai_dok' =>  sanitize_nominal($request->nilai),
                'ket1' =>  $request->ket1,
                'ket2' =>  $request->ket2,
                'ket3' =>  $request->ket3,
                'mrs_no' =>  $request->nover,
            ]);
        return response()->json();
    }

    public function storeDetail(Request $request)
    {
        $tahun = $request->tahun;
        $bulans = $request->bulan;
        $bulan = ltrim($request->bulan, 0);
        $thnbln = $tahun . '' . $bulans;
        $docno = $request->nodok;
        $data_cek = DB::select("SELECT * from kasline where docno='$request->nodok' and lineno='$request->nourut'");
        if (!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
            $data_crtetap = DB::select("SELECT p.tahun, p.bulan,p.aard,sum(p.nilai) as nilai,'TETAP' as status from pay_master_upah p where tahun='$tahun' and bulan='$bulan' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='C') group by tahun,bulan,aard");
            $data_crkontrak = DB::select("SELECT p.tahun, p.bulan,p.aard,sum(p.nilai) as nilai,'KONTRAK' as status from pay_master_upah p where tahun='$tahun' and bulan='$bulan' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='K') group by tahun,bulan,aard");
            $data_crbantu = DB::select("SELECT p.tahun, p.bulan,p.aard,sum(p.nilai) as nilai,'PERBANTUAN' as status from pay_master_upah p where tahun='$tahun' and bulan='$bulan' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='B') group by tahun,bulan,aard");
            $data_crkom = DB::select("SELECT p.tahun, p.bulan,p.aard,sum(p.nilai) as nilai,'KOMISARIS' as status from pay_master_upah p where tahun='$tahun' and bulan='$bulan' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='U') group by tahun,bulan,aard");
            $data_crkomite = DB::select("SELECT p.tahun, p.bulan,p.aard, sum(p.nilai) as nilai,'KOMITE' as status from pay_master_upah p where tahun='$tahun' and bulan='$bulan' and nilai<>0 and nopek in (select nopeg from sdm_master_pegawai where status='O') group by tahun,bulan,aard");

            if ($request->status == 'TETAP') {
                foreach ($data_crtetap as $t) {
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }
                    $data_aard = DB::select("SELECT * from pay_tbl_aard where kode='$t->aard'");
                    if (!empty($data_aard)) {
                        foreach ($data_aard as $data_a) {
                            $v_nama = $data_a->nama;
                            $v_sandi = $data_a->sanper;
                            $v_cj = $data_a->cj;
                            $v_jb = $data_a->jb;
                        }
                    } else {
                        $v_nama = "";
                        $v_sandi = "";
                        $v_cj = "";
                        $v_jb = "";
                    }
                    Kasline::insert([
                        'docno' =>  $docno,
                        'lineno' =>  $v_nomor,
                        'account' =>  $v_sandi,
                        'area' =>  '0',
                        'lokasi'  => 'MS',
                        'bagian' =>  'B2000',
                        'pk' =>  '000000',
                        'jb' =>  $v_jb,
                        'cj' =>  $v_cj,
                        'totprice'  =>  str_replace('.', '', $t->nilai),
                        'keterangan'  =>  $v_nama,
                        'penutup' => 'N',
                        'ref_no' => $thnbln
                    ]);
                }
                $v_jenis = 'PGT';
            } elseif ($request->status == 'KONTRAK') {
                foreach ($data_crkontrak as $t) {
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }

                    $data_aard = DB::select("SELECT * from pay_tbl_aard where kode='$t->aard'");
                    if (!empty($data_aard)) {
                        foreach ($data_aard as $data_a) {
                            $v_nama = $data_a->nama;
                            $v_sandi = $data_a->sanperpwt;
                            $v_cj = $data_a->cj;
                            $v_jb = $data_a->jb;
                        }
                    } else {
                        $v_nama = "";
                        $v_sandi = "";
                        $v_cj = "";
                        $v_jb = "";
                    }
                    Kasline::insert([
                        'docno' =>  $docno,
                        'lineno' =>  $v_nomor,
                        'account' =>  $v_sandi,
                        'area' =>  '0',
                        'lokasi'  => 'MS',
                        'bagian' =>  'B2000',
                        'pk' =>  '000000',
                        'jb' =>  $v_jb,
                        'cj' =>  $v_cj,
                        'totprice'  =>  $t->nilai,
                        'keterangan'  =>  $v_nama,
                        'penutup' => 'N',
                        'ref_no' => $thnbln
                    ]);
                }
                $v_jenis = 'PGK';
            } elseif ($request->status == 'PERBANTUAN') {
                foreach ($data_crbantu as $t) {
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }

                    $data_aard = DB::select("SELECT * from pay_tbl_aard where kode='$t->aard'");
                    if (!empty($data_aard)) {
                        foreach ($data_aard as $data_a) {
                            $v_nama = $data_a->nama;
                            $v_sandi = $data_a->sanperdir;
                            $v_cj = $data_a->cj;
                            $v_jb = $data_a->jb;
                        }
                    } else {
                        $v_nama = "";
                        $v_sandi = "";
                        $v_cj = "";
                        $v_jb = "";
                    }
                    Kasline::insert([
                        'docno' =>  $docno,
                        'lineno' =>  $v_nomor,
                        'account' =>  $v_sandi,
                        'area' =>  '0',
                        'lokasi'  => 'MS',
                        'bagian' =>  'B2000',
                        'pk' =>  '000000',
                        'jb' =>  $v_jb,
                        'cj' =>  $v_cj,
                        'totprice'  =>  $t->nilai,
                        'keterangan'  =>  $v_nama,
                        'penutup' => 'N',
                        'ref_no' => $thnbln
                    ]);
                }
                $v_jenis = 'PGB';
            } elseif ($request->status == 'KOMISARIS') {
                foreach ($data_crkom as $t) {
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }

                    $data_aard = DB::select("SELECT * from pay_tbl_aard where kode='$t->aard'");
                    if (!empty($data_aard)) {
                        foreach ($data_aard as $data_a) {
                            $v_nama = $data_a->nama;
                            $v_sandi = $data_a->sanper;
                            $v_cj = $data_a->cj;
                            $v_jb = $data_a->jb;
                        }
                    } else {
                        $v_nama = "";
                        $v_sandi = "";
                        $v_cj = "";
                        $v_jb = "";
                    }
                    Kasline::insert([
                        'docno' =>  $docno,
                        'lineno' =>  $v_nomor,
                        'account' =>  $v_sandi,
                        'area' =>  '0',
                        'lokasi'  => 'MS',
                        'bagian' =>  'B2000',
                        'pk' =>  '000000',
                        'jb' =>  $v_jb,
                        'cj' =>  $v_cj,
                        'totprice'  =>  $t->nilai,
                        'keterangan'  =>  $v_nama,
                        'penutup' => 'N',
                        'ref_no' => $thnbln
                    ]);
                }
                $v_jenis = 'PGM';
            } else {
                foreach ($data_crkomite as $t) {
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }
                    $data_no = DB::select("SELECT max(lineno) as v_no from kasline where docno='$docno'");
                    if (!empty($data_no)) {
                        foreach ($data_no as $no) {
                            $v_nomor = $no->v_no + 1;
                        }
                    } else {
                        $v_nomor = 1;
                    }
                    $data_aard = DB::select("SELECT * from pay_tbl_aard where kode='$t->aard'");
                    if (!empty($data_aard)) {
                        foreach ($data_aard as $data_a) {
                            $v_nama = $data_a->nama;
                            $v_sandi = $data_a->sanper;
                            $v_cj = $data_a->cj;
                            $v_jb = $data_a->jb;
                        }
                    } else {
                        $v_nama = "";
                        $v_sandi = "";
                        $v_cj = "";
                        $v_jb = "";
                    }
                    Kasline::insert([
                        'docno' =>  $docno,
                        'lineno' =>  $v_nomor,
                        'account' =>  $v_sandi,
                        'area' =>  '0',
                        'lokasi'  => 'MS',
                        'bagian' =>  'B2000',
                        'pk' =>  '000000',
                        'jb' =>  $v_jb,
                        'cj' =>  $v_cj,
                        'totprice'  =>  $t->nilai,
                        'keterangan'  =>  $v_nama,
                        'penutup' => 'N',
                        'ref_no' => $thnbln
                    ]);
                }
                $v_jenis = 'PGO';
            }
            $data_sum = DB::select("SELECT sum(totprice) as v_total from kasline where docno='$docno'");
            foreach ($data_sum as $data_s) {
                Kasdoc::where('docno', $docno)
                    ->update([
                        'nilai_dok' =>  $data_s->v_total,
                        'kd_kepada' =>  $v_jenis
                    ]);
            }
            StatusBayarGaji::where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->update([
                    'statpbd' =>  'Y'
                ]);
            $data = 1;
            return response()->json($data);
        }
    }
    public function editDetail($nodok, $nourut)
    {
        $no = str_replace('-', '/', $nodok);
        $data = Kasline::where('docno', $no)->where('lineno', $nourut)->distinct()->get();
        return response()->json($data[0]);
    }
    public function updateDetail(Request $request)
    {
        Kasline::where('docno', $request->nodok)
            ->where('lineno', $request->nourut)
            ->update([
                'account' =>  $request->sanper,
                'area' =>  '0',
                'lokasi' =>  $request->lapangan,
                'bagian' =>  $request->bagian,
                'pk' =>  $request->pk,
                'jb' =>  $request->jb,
                'totprice' =>  str_replace(',', '.', $request->nilai),
                'cj' =>  $request->cj,
                'keterangan' =>  $request->rincian,
            ]);

        $data_sum = DB::select("SELECT sum(totprice) as total from kasline where docno='$request->nodok'");
        foreach ($data_sum as $data_s) {
            Kasdoc::where('docno', $request->nodok)
                ->update([
                    'nilai_dok' =>  $data_s->total
                ]);
        }
        return response()->json();
    }

    public function delete(Request $request)
    {
        $data_rskas = DB::select("SELECT thnbln from kasdoc a where a.docno='$request->nodok'");
        foreach ($data_rskas as $data_kas) {
            $data_rsbulan = DB::select("SELECT * from timetrans where thnbln='$data_kas->thnbln' and suplesi='0'");
            if (!empty($data_rsbulan)) {
                foreach ($data_rsbulan as $data_bulan) {
                    if ($data_bulan->status == '1') {
                        $stbbuku = '1'; //gtopening
                    } elseif ($data_bulan->status == '2') {
                        $stbbuku = '2'; //gtstopping
                    } elseif ($data_bulan->status == '3') {
                        $stbbuku = '3'; //gtclosing
                    } else {
                        $stbbuku = '4'; //gtnone
                    }
                }
            } else {
                $stbbuku = 'gtnone';
            }
            if ($stbbuku > 1) {
                $data = 2;
                return response()->json($data);
            } else {
                $data_rscekbayar = DB::select("SELECT paid from kasdoc where docno='$request->nodok'");
                foreach ($data_rscekbayar as $data_cekbayar) {
                    if ($data_cekbayar->paid == 'Y') {
                        $data = 3;
                        return response()->json($data);
                    } else {
                        Kasdoc::where('docno', $request->nodok)->delete();
                        Kasline::where('docno', $request->nodok)->delete();
                        $data = 1;
                        return response()->json($data);
                    }
                }
            }
        }
    }

    public function deleteDetail(Request $request)
    {
        Kasline::where('docno', $request->nodok)->where('lineno', $request->nourut)->delete();
        return response()->json();
    }
    public function deleteDetailall(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = ltrim($request->bulan, 0);
        Kasline::where('docno', $request->nodok)->delete();
        Kasdoc::where('docno', $request->nodok)
            ->update([
                'nilai_dok' => '0'
            ]);
        StatusBayarGaji::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->update([
                'statpbd' =>  'N'
            ]);
        return response()->json();
    }

    public function approv(Request $request, $id, $status)
    {
        $nodok = str_replace('-', '/', $id);
        $data = Kasdoc::where('docno', $nodok)->select('*')->first();

        $status = $request->status;

        return view('modul-treasury.pembayaran-gaji.approv', compact('data', 'status'));
    }

    public function storeApp(Request $request)
    {
        $nodok = str_replace('-', '/', $request->nodok);
        $data_app = Kasdoc::where('docno', $nodok)->select('*')->get();
        foreach ($data_app as $data) {
            $check_data = $data->paid;
        }
        if ($check_data == 'Y') {
            $bi_bayar = -1;  //Mengembalikan pembayaran
            $data_cr = DB::select("SELECT * from kasdoc h where h.docno='$nodok'");
            foreach ($data_cr as $t) {
                $v_akhir = -9999999999999999;
                $data_tglrekap = DB::select("SELECT max(tglrekap) as stglrekap from rekapkas where store = '$t->store' and jk =  '$t->jk'");
                if (!empty($data_tglrekap)) {
                    foreach ($data_tglrekap as $data_tgl) {
                        $stglrekap  = $data_tgl->stglrekap;
                    }
                } else {
                    $stglrekap = date(now());
                }

                $data_juml = DB::select("SELECT count(*),sum(totprice) as jumlah from kasline where penutup='N' and docno = '$nodok'");
                foreach ($data_juml as $data_jum) {
                    $selisih = round($data_jum->jumlah, 0) * $bi_bayar;
                    if ($selisih + $v_akhir > 0) {
                        Alert::info('Kas Tidak Mencukupi! Saldo yang tersedia = 9,999,999,999,990.00')->persistent(true);
                        return redirect()->route('pembayaran_gaji.index');
                    } else {
                        if ($selisih >= 0) {
                            if ($bi_bayar == 1) {
                                $v_debet  =  $selisih;
                                $v_kredit =  0;
                            } else {
                                $v_debet  =  0;
                                $v_kredit =  $selisih;
                            }
                        } else {
                            if ($bi_bayar == 1) {
                                $v_debet =  0;
                                $v_kredit = $selisih;
                            } else {
                                $v_debet =  $selisih;
                                $v_kredit = 0;
                            }
                        }
                        $data_saldo = DB::select("SELECT *  from saldostore where jk ='$t->jk' and nokas = '$t->store'");
                        foreach ($data_saldo as $data_sald) {
                            Saldostore::where('jk', $t->jk)->where('nokas', $t->store)
                                ->update([
                                    'saldoakhir' => round($data_sald->saldoakhir, 0) + round($selisih, 0),
                                    'debet' => round($data_sald->debet, 0) + $v_debet,
                                    'kredit' => round($data_sald->kredit, 0) + $v_kredit
                                ]);
                        }
                        Kasdoc::where('docno', $nodok)
                            ->update([
                                'paid' => 'N',
                                'paidby' => $request->userid,
                                'paiddate' => $request->tgl_app,
                            ]);
                        Alert::success('No.Dokumen : ' . $nodok . ' Approval Berhasil Dibatalkan', 'Berhasil')->persistent(true);
                        return redirect()->route('pembayaran_gaji.index');
                    }
                }
            }
        } else {
            $i_bayar = 1; //i_Bayar = 1  : Membayar Kas/Bank
            $data_cr = DB::select("SELECT * from kasdoc h where h.docno='$nodok'");
            foreach ($data_cr as $t) {
                $v_akhir = -9999999999999999;
                $data_tglrekap = DB::select("SELECT max(tglrekap) as stglrekap from rekapkas where store = '$t->store' and jk =  '$t->jk'");
                if (!empty($data_tglrekap)) {
                    foreach ($data_tglrekap as $data_tgl) {
                        $stglrekap  = $data_tgl->stglrekap;
                    }
                } else {
                    $stglrekap = date(now());
                }

                $data_juml = DB::select("SELECT count(*),sum(totprice) as jumlah from kasline where penutup='N' and docno = '$nodok'");
                foreach ($data_juml as $data_jum) {
                    $selisih = round($data_jum->jumlah, 0) * $i_bayar;
                    if ($selisih + $v_akhir > 0) {
                        Alert::info('Kas Tidak Mencukupi! Saldo yang tersedia = 9,999,999,999,990.00')->persistent(true);
                        return redirect()->route('pembayaran_gaji.index');
                    } else {
                        if ($selisih >= 0) {
                            if ($i_bayar == 1) {
                                $v_debet  =  $selisih;
                                $v_kredit =  0;
                            } else {
                                $v_debet  =  0;
                                $v_kredit =  $selisih;
                            }
                        } else {
                            if ($i_bayar == 1) {
                                $v_debet =  0;
                                $v_kredit = $selisih;
                            } else {
                                $v_debet =  $selisih;
                                $v_kredit = 0;
                            }
                        }
                        $data_saldo = DB::select("SELECT *  from saldostore where jk ='$t->jk' and nokas = '$t->store'");
                        foreach ($data_saldo as $data_sald) {
                            SaldoStore::where('jk', $t->jk)->where('nokas', $t->store)
                                ->update([
                                    'saldoakhir' => round($data_sald->saldoakhir, 0) + round($selisih, 0),
                                    'debet' => round($data_sald->debet, 0) + $v_debet,
                                    'kredit' => round($data_sald->kredit, 0) + $v_kredit
                                ]);
                        }
                        Kasdoc::where('docno', $nodok)
                            ->update([
                                'paid' => 'Y',
                                'paidby' => $request->userid,
                                'paiddate' => $request->tgl_app,
                            ]);
                        Alert::success('No.Dokumen : ' . $nodok . ' Berhasil Diapproval', 'Berhasil')->persistent(true);
                        return redirect()->route('pembayaran_gaji.index');
                    }
                }
            }
        }
    }

    public function rekap($docs)
    {
        $doc = str_replace('-', '/', $docs);
        $data_list = DB::select("SELECT * from kasdoc where docno='$doc'");
        foreach ($data_list as $data_kasd) {
            $docno = $data_kasd->docno;
            $thnbln = $data_kasd->thnbln;
            $jk = $data_kasd->jk;
            $store = $data_kasd->store;
            $ci = $data_kasd->ci;
            $voucher = $data_kasd->voucher;
            $kepada = $data_kasd->kepada;
            $rate = $data_kasd->rate;
            $nilai_dok = $data_kasd->nilai_dok;
            $ket1 = $data_kasd->ket1;
            $ket2 = $data_kasd->ket2;
            $ket3 = $data_kasd->ket3;
            $mp =  substr($data_kasd->docno, 0, 1);
            $kd_kepada = $data_kasd->kd_kepada;


            if (auth()->user()->userid == "ITA") {
                $id = "I";
            } elseif (auth()->user()->userid == "BAMBANG") {
                $id = "F";
            } elseif (auth()->user()->userid == "AA") {
                $id = "A";
            } else {
                $id = "K";
            }

            $data_pbd = DB::select("SELECT a.* from pbd_tbl_param a where id='$id'");
            foreach ($data_pbd as $rsparam) {
                if ($mp == "P" or $mp == "p") {
                    $minta1 = $rsparam->minta1;
                    $nminta1 = $rsparam->nminta1;
                    $verifikasi1 = $rsparam->verifikasi1;
                    $nverifikasi1 = $rsparam->nverifikasi1;
                    $setuju1 = $rsparam->setuju1;
                    $nsetuju1 = $rsparam->nsetuju1;
                    $buku1 = $rsparam->buku1;
                    $nbuku1 = $rsparam->nbuku1;
                    $setuju2 = "";
                    $nsetuju2 = "";
                    $buku2 = "";
                    $nbuku2 = "";
                    $kas2 = "";
                    $nkas2 = "";
                } else {
                    $minta1 = "";
                    $nminta1 = "";
                    $verifikasi1 = "";
                    $nverifikasi1 = "";
                    $setuju1 = "";
                    $nsetuju1 = "";
                    $buku1 = "";
                    $nbuku1 = "";
                    $setuju2 = $rsparam->setuju2;
                    $nsetuju2 = $rsparam->nsetuju2;
                    $buku2 = $rsparam->buku2;
                    $nbuku2 = $rsparam->nbuku2;
                    $kas2 = $rsparam->kas2;
                    $nkas2 = $rsparam->nkas2;
                }
            }
        }
        return view('modul-treasury.pembayaran-gaji.rekap', compact(
            'docs',
            'minta1',
            'nminta1',
            'verifikasi1',
            'nverifikasi1',
            'setuju1',
            'nsetuju1',
            'buku1',
            'nbuku1',
            'setuju2',
            'nsetuju2',
            'buku2',
            'nbuku2',
            'kas2',
            'nkas2',
            'docno',
            'nilai_dok',
            'ci',
            'kd_kepada',
            'mp'
        ));
    }

    public function export(Request $request)
    {
        $docno = str_replace('-', '/', $request->docno);
        Kasdoc::where('docno', $docno)
            ->update([
                'tgl_kurs' =>  $request->tanggal,
            ]);
        $data_list = DB::select("SELECT a.nilai_dok,a.mrs_no,a.kepada,a.tgl_kurs,a.jk,right(a.thnbln,2) bulan, left(a.thnbln, 4) tahun,a.store,a.ci,a.rate,a.ket1,a.ket2,a.ket3, b.*,a.voucher from kasdoc a join kasline b on a.docno=b.docno where a.docno='$docno'");

        if (!empty($data_list)) {
            foreach ($data_list as $data) {
                $jk = $data->jk;
                $tahun = $data->tahun;
                $bulan = $data->bulan;
                $store = $data->store;
                $voucher = $data->voucher;
                $ci = $data->ci;
                $rate = $data->rate;
                $ket1 = $data->ket1;
                $ket2 = $data->ket2;
                $ket3 = $data->ket3;
                $mrs_no = $data->mrs_no;
                $tgl_kurs = $data->tgl_kurs;
                $kepada = $data->kepada;
                $nilai_dok = $data->nilai_dok;
            }
            $mp = substr($docno, 0, 1);

            if ($mp == "M") {
                $reportname = "merah-pdf";
            } else {
                $reportname = "putih-pdf";
            }

            $pdf = DomPDF::loadview("modul-treasury.pembayaran-gaji.$reportname", compact(
                'request',
                'data_list',
                'jk',
                'bulan',
                'tahun',
                'store',
                'voucher',
                'ci',
                'rate',
                'ket1',
                'ket2',
                'ket3',
                'mrs_no',
                'tgl_kurs',
                'kepada',
                'nilai_dok'
            ))->setPaper('A4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(105, 75, "", null, 10, array(0, 0, 0)); //slip Gaji landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data", 'Failed')->persistent(true);
            return redirect()->route('pembayaran_gaji.index');
        }
    }

    public function rekapRc($docno)
    {
        $doc = str_replace('-', '/', $docno);
        $data_list = DB::select("SELECT * from kasdoc where docno='$doc'");
        foreach ($data_list as $data_kasd) {
            $docno = $data_kasd->docno;
            $kdkepada = $data_kasd->kd_kepada;
            $ci = $data_kasd->ci;
        }
        $lampiran = "-";
        $perihal = "Transfer/ Pemindahbukuan";
        $v_Total = 0;
        if ($kdkepada == "PGO" or $kdkepada == "PGM") {
            DB::table('simpan_rcgaji')->delete();
            $data_thnbln = DB::select("SELECT thnbln as i_thnbln, right(thnbln,2) bulan,  left(thnbln, 4) tahun from kasdoc where docno='$docno'");
            foreach ($data_thnbln as $data_thn) {
                $i_thnbln = $data_thn->i_thnbln;
                $tahun = $data_thn->tahun;
                $bulan = $data_thn->bulan;
            }
            $data_total = DB::select("SELECT coalesce(sum(nilai),0) as v_total from pay_master_upah where tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status in ('U','O'))");
            if (!empty($data_total)) {
                foreach ($data_total as $data_tot) {
                    $v_total = $data_tot->v_total;
                }
            } else {
                $v_total = 0;
            }

            $data_komisaris = DB::select("SELECT coalesce(sum(nilai),0) as v_komisaris from pay_master_upah where tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status='U')");
            if (!empty($data_komisaris)) {
                foreach ($data_komisaris as $data_komis) {
                    $v_komisaris = $data_komis->v_komisaris;
                }
            } else {
                $v_komisaris = 0;
            }

            $data_komite = DB::select("SELECT coalesce(sum(nilai),0) as v_komite from pay_master_upah where tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status='O')");
            if (!empty($data_komite)) {
                foreach ($data_komite as $data_komit) {
                    $v_komite = $data_komit->v_komite;
                }
            } else {
                $v_komite = 0;
            }

            $v_Transfer = $v_Total;
            SimpanRcGaji::insert([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'total' => $v_Transfer,
                'pkpp' => $v_komisaris,
                'koperasi' => $v_komite
            ]);

            $data_simpan = DB::select("SELECT * from simpan_rcgaji");
            foreach ($data_simpan as $objRs) {
                $transfer = $objRs->total;
                $pkpp = $objRs->pkpp;
                $bazma = 0;
                $koperasi = $objRs->koperasi;
                $sukaduka = 0;
                $total = $objRs->total;
            }
        } else {

            DB::table('simpan_rcgaji')->delete();
            $data_thnbln = DB::select("SELECT thnbln as i_thnbln, right(thnbln,2) bulan,  left(thnbln, 4) tahun from kasdoc where docno='$docno'");
            foreach ($data_thnbln as $data_thn) {
                $i_thnbln = $data_thn->i_thnbln;
                $tahun = $data_thn->tahun;
                $bulan = $data_thn->bulan;
            }
            $data_total = DB::select("SELECT coalesce(sum(nilai),0) as v_total from pay_master_upah where tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status in ('C','B','K'))");
            if (!empty($data_total)) {
                foreach ($data_total as $data_tot) {
                    $v_total = $data_tot->v_total;
                }
            } else {
                $v_total = 0;
            }


            $data_bazma = DB::select("SELECT coalesce(sum(nilai)*-1,0) as v_bazma from pay_master_upah where aard='36' and tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status in ('C','B','K'))");
            if (!empty($data_bazma)) {
                foreach ($data_bazma as $data_baz) {
                    $v_bazma = $data_baz->v_bazma;
                }
            } else {
                $v_bazma = 0;
            }


            $data_koperasi = DB::select("SELECT coalesce(sum(nilai)*-1,0) as v_koperasi from pay_master_upah where aard='28' and tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status in ('C','B','K'))");
            if (!empty($data_koperasi)) {
                foreach ($data_koperasi as $data_koper) {
                    $v_koperasi = $data_koper->v_koperasi;
                }
            } else {
                $v_koperasi = 0;
            }

            $data_sukaduka = DB::select("SELECT coalesce(sum(nilai)*-1,0) as v_sukaduka from pay_master_upah where aard='44' and tahun=left('$i_thnbln',4) and bulan=substring('$i_thnbln',5,2) and nopek in (select nopeg from sdm_master_pegawai where status in ('C','B','K'))");
            if (!empty($data_sukaduka)) {
                foreach ($data_sukaduka as $data_suka) {
                    $v_sukaduka = $data_suka->v_sukaduka;
                }
            } else {
                $v_sukaduka = 0;
            }

            $v_pkpp = 0;
            $v_transfer = $v_total + ($v_pkpp + $v_bazma + $v_koperasi + $v_sukaduka);
            SimpanRcGaji::insert([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'total' => $v_transfer,
                'pkpp' => $v_pkpp,
                'bazma' => $v_bazma,
                'transfer' => $v_total,
                'koperasi' => $v_koperasi,
                'sukduk' => $v_sukaduka
            ]);

            $data_simpan = DB::select("SELECT * from simpan_rcgaji");
            foreach ($data_simpan as $objRs) {
                $transfer = $objRs->transfer;
                $pkpp = $objRs->pkpp;
                $bazma = $objRs->bazma;
                $koperasi = $objRs->koperasi;
                $sukaduka = $objRs->sukduk;
                $total = $objRs->total;
                $bulan = $objRs->bulan;
                $tahun = $objRs->tahun;
            }
        }

        $bank = "Bank Mandiri (Persero)";
        $cabang = "Cabang Juanda";
        $norek = "119-00-0212252-9";
        $alamat = "Jl.Ir.H.Juanda";
        $kota = "Jakarta";
        $up = "Bp. Dody";
        $jabkir = "Dir. Utama";
        $jabkan = "Dir. Keu & Inv";
        $namkir = "Sjahril Samad";
        $namkan = "Muhammad Suryohadi";
        $reg = "-";
        return view('modul-treasury.pembayaran-gaji.rekap-rc', compact(
            'docno',
            'lampiran',
            'perihal',
            'transfer',
            'pkpp',
            'bazma',
            'koperasi',
            'sukaduka',
            'total',
            'bank',
            'cabang',
            'norek',
            'alamat',
            'kota',
            'up',
            'jabkir',
            'jabkan',
            'namkir',
            'namkan',
            'reg',
            'kdkepada',
            'bulan',
            'tahun',
            'ci'
        ));
    }

    public function exportRc(Request $request)
    {
        $docno = str_replace('-', '/', $request->docno);
        if ($request->kdkepada == "PGO" or $request->kdkepada == "PGM") {
            $reportname = "rcgajikomisaris-pdf";
        } else {
            $reportname = "rcgaji-pdf";
        }

        $pdf = DomPDF::loadview("modul-treasury.pembayaran-gaji.$reportname", compact('request'))->setPaper('A4', 'Portrait');
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->getCanvas();
        $canvas->page_text(105, 75, "", null, 10, array(0, 0, 0)); //slip Gaji landscape
        // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }
}
