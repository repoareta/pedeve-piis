<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\HistoryOb;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OpeningBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_akses = DB::table('usermenu')->where('userid', auth()->user()->userid)->where('menuid', 507)->first();

        return view('modul-treasury.opening-balance.index', compact(
            'data_akses',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $data = DB::select("SELECT thnblnsup,substr(thnblnsup,1,4) tahun,substr(thnblnsup,5,2) bulan, substr(thnblnsup,7,1) suplesi, no_jurnal_rp, no_jurnal_dl,user_id,tgl_buat from history_ob order by thnblnsup desc");

        return datatables()->of($data)
        ->addColumn('bulan', function ($data) {
            return $data->bulan;
        })
        ->addColumn('tahun', function ($data) {
            return $data->tahun;
        })
        ->addColumn('suplesi', function ($data) {
            return $data->suplesi;
        })
        ->addColumn('tanggal', function ($data) {
            $tgl = date_create($data->tgl_buat);
            $tgl_buat = date_format($tgl, 'd/m/Y');
            return $tgl_buat;
        })
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="' . $data->thnblnsup . '" class="btn-radio" name="btn-radio"><span></span></label></center>';
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-treasury.opening-balance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $thn = $request->tahun;
        $tabel_opsi = "obpsi_$thn";
        $cek = DB::select("SELECT * from history_ob where substr(thnblnsup,1,4)='$thn'");
        if (!empty($cek)) {
            $dataa = 2;
            return response()->json($dataa);
        } else {
            $data_vthn = DB::select("SELECT substr(max(o.thnblnsup),1,4) as vthn from history_ob o");
            if (!empty($data_vthn)) {
                foreach ($data_vthn as $data_v) {
                    $vthn = $data_v->vthn;
                }
            } else {
                $vthn = "0";
            }
            $thnterakhir = $vthn + 1;
            if ($thn <> $thnterakhir) {
                $data = $vthn;
                return response()->json($data);
            }
            $data_vada = DB::select("SELECT count(a.tablename) as vada from pg_tables a where a.tablename like 'obpsi_'||'$thn' ");
            if (!empty($data_vada)) {
                foreach ($data_vada as $data_van) {
                    $vada = $data_van->vada;
                }
            } else {
                $vada = "0";
            }
            if ($vada > 0) {
                Schema::dropIfExists("$tabel_opsi");
            }
            $create_tabel = 'obpsi_' . $thn;
            Schema::create("$create_tabel", function (Blueprint $table) {
                $table->string('tahun', 4)->nullable();
                $table->string('bulan', 2)->nullable();
                $table->string('ci', 1);
                $table->string('account', 6);
                $table->string('jb', 6);
                $table->float('pricerp', 20, 2)->nullable();
                $table->float('pricedl', 20, 2)->nullable();
                $table->float('totpricerp', 20, 2)->nullable();
                $table->float('totpricedl', 20, 2)->nullable();
                $table->string('bagian', 5)->nullable();
                $table->string('lokasi', 2);
                $table->string('area', 1)->nullable();
                $table->string('suplesi', 2)->nullable();
                $table->float('pricerp_real', 38, 10)->nullable();
                $table->float('totpricerp_real', 38, 10)->nullable();
                $table->string('asal', 50)->nullable();
                $table->float('awalrp', 38, 10)->nullable();
                $table->float('awaldl', 38, 10)->nullable();
            });

            $vthn_o = $thn - 1;
            $data_opsi = DB::select("SELECT * from obpsi_$vthn_o");
            foreach ($data_opsi as $data_op) {
                DB::table("$tabel_opsi")->insert([
                    'tahun' => $data_op->tahun,
                    'bulan' => $data_op->bulan,
                    'ci' => $data_op->ci,
                    'account' => $data_op->account,
                    'jb' => $data_op->jb,
                    'pricerp' => $data_op->pricerp,
                    'pricedl' => $data_op->pricedl,
                    'totpricerp' => $data_op->totpricerp,
                    'totpricedl' => $data_op->totpricedl,
                    'bagian' => $data_op->bagian,
                    'lokasi' => $data_op->lokasi,
                    'area' => $data_op->area,
                    'suplesi' => $data_op->suplesi,
                    'pricerp_real' => $data_op->pricerp_real,
                    'totpricerp_real' => $data_op->totpricerp_real,
                    'asal' => $data_op->asal,
                    'awalrp' => $data_op->awalrp,
                    'awaldl' => $data_op->awaldl,
                ]);
            }

            DB::table("$tabel_opsi")
            ->update([
                'tahun' => $thn,
                'bulan' => '00',
                'suplesi' => '0'
            ]);
            $crd2_neraca = DB::select("SELECT d.lokasi,d.account,d.jb,d.ci,
                        sum(coalesce(d.totpricerp,0)) jmlrp,
                        sum(coalesce(d.totpricedl,0)) jmldl
                from fiosd201 d
                where substring(d.account from 1 for 1) in ('0','1','2','3') and d.tahun='$vthn'
                group by d.lokasi,d.account,d.jb,d.ci");
            foreach ($crd2_neraca as $t1) {
                $vrp        = $t1->jmlrp;
                $vdl        = $t1->jmldl;
                $data_vsql = DB::select("SELECT * from $tabel_opsi where account='$t1->account' and jb='$t1->jb' and ci='$t1->ci' and lokasi='$t1->lokasi'");

                if (!empty($data_vsql)) {
                    foreach ($data_vsql as $b) {
                        DB::table("$tabel_opsi")
                        ->where('account', $t1->account)
                            ->where('jb', $t1->jb)
                            ->where('ci', $t1->ci)
                            ->where('lokasi', $t1->lokasi)
                            ->update([
                                'awalrp' => $b->awalrp + $vrp,
                                'awaldl' => $b->awaldl + $vdl,
                                'totpricerp' => $b->totpricerp + $vrp,
                                'totpricedl' => $b->totpricedl + $vdl
                            ]);
                    }
                } else {
                    DB::table("$tabel_opsi")->insert([
                        'tahun' => $thn,
                        'bulan' => '00',
                        'suplesi' => '0',
                        'ci' => $t1->ci,
                        'account' => $t1->account,
                        'jb' => $t1->jb,
                        'lokasi' => $t1->lokasi,
                        'pricerp' => '0',
                        'pricedl' => '0',
                        'totpricerp' => $vrp,
                        'totpricedl' => $vdl,
                        'awalrp' => $vrp,
                        'awaldl' => $vdl
                    ]);
                }
            }
            $crd2 = DB::select("SELECT d.lokasi,d.ci,
                    sum(coalesce(d.totpricerp,0)) jmlrp,
                    sum(coalesce(d.totpricedl,0)) jmldl
                    from fiosd201 d, account_ob o
                    where d.account like o.account and d.ci in ('1','2') and d.tahun='$vthn'
                    group by d.lokasi,d.ci");
            foreach ($crd2 as $t1) {
                $vrp        = $t1->jmlrp;
                $vdl        = $t1->jmldl;
                if ($t1->lokasi == 'MD') {
                    $vaccount   = '222999';
                    DB::table("$tabel_opsi")
                    ->where('account', $vaccount)
                        ->where('jb', '900')
                        ->where('lokasi', 'MD')
                        ->update([
                            'awalrp' => $b->awalrp + $vrp,
                            'awaldl' => $b->awaldl + $vdl,
                            'totpricerp' => $b->totpricerp + $vrp,
                            'totpricedl' => $b->totpricedl + $vdl,
                            'suplesi' => '0'
                        ]);
                } else {
                    $vaccount   = '303' . substr($thn, 1, 3);
                    DB::table("$tabel_opsi")->insert([
                        'tahun' => $thn,
                        'bulan' => '00',
                        'suplesi' => '0',
                        'ci' => $t1->ci,
                        'account' => $vaccount,
                        'jb' => '900',
                        'lokasi' => $t1->lokasi,
                        'pricerp' => '0',
                        'pricedl' => '0',
                        'totpricerp' => $vrp,
                        'totpricedl' => $vdl,
                        'awalrp' => $vrp,
                        'awaldl' => $vdl
                    ]);
                };
            }
            $tgl_buat = date('Y-m-d H:i:s');
            $userid = auth()->user()->userid;
            DB::table("history_ob")->insert([
                'thnblnsup' => $thn . '00' . '0',
                'user_id' => $userid,
                'tgl_buat' => $tgl_buat,
                'thnblnsup_lalu' => $vthn . '00' . '0'
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('history_ob')
            ->where('thnblnsup', '=', $id)
            ->select(DB::raw('substr(thnblnsup, 1, 4) as tahun'))
            ->first();

        $tahun = $data->tahun;

        return view('modul-treasury.opening-balance.edit', compact('tahun'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $thn = $request->tahun;
        $tabel_opsi = "obpsi_$thn";

        $data_vtnbln = DB::select("SELECT max(thnblnsup) as vthnbln from history_ob");
        
        foreach ($data_vtnbln as $data_vth) {
            if (substr($data_vth->vthnbln, 0, 4) <> $thn) {
                $data = 1;
                return response()->json($data);
            }
        }

        Schema::dropIfExists("$tabel_opsi");
        HistoryOb::where('thnblnsup', 'like', "$thn%")->delete();

        $data_vthn = DB::select("SELECT substr(max(a.tablename),7,4) as vthn from pg_tables a where a.tablename like 'obpsi_%'");

        foreach ($data_vthn as $data_vt) {
            if ($thn <> $data_vt->vthn) {
                $data = $data_vt->vthn;
                return response()->json($data);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
