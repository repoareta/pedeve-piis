<?php

namespace App\Http\Controllers\Umum\UangMukaKerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Load Model
use App\Models\UmkHeader;
use App\Models\PUmkHeader;
use App\Models\PUmkDetail;
// use App\Models\SdmMasterPegawai;
// use App\Models\SdmTblKdjab;

// Load Plugin
use Carbon\Carbon;
use Session;
use DB;

class UangMukaKerjaPertanggungjawabanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request, $no_pumk = 'null')
    {
        // $request->session()->flush();
        if (session('pumk_detail') and $request->no_pumk == 'null') {
            $pumk_list_detail = session('pumk_detail');
        } else {
            $no_pumk = str_replace('-', '/', $request->no_pumk);
            $pumk_list_detail = PUmkDetail::where('no_pumk', $no_pumk)
            ->get();
        }
        return datatables()->of($pumk_list_detail)
            ->addColumn('action', function ($row) {
                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio1" value="'.$row->no.'-'.$row->no_pumk.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('total', function ($row) {
                return float_two($row->nilai);
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pumk_detail = new PUmkDetail;
        $pumk_detail->no = $request->no;
        $pumk_detail->keterangan = $request->keterangan;
        $pumk_detail->account = $request->account;
        $pumk_detail->nilai = $request->nilai;
        $pumk_detail->cj = $request->cj;
        $pumk_detail->jb = $request->jb;
        $pumk_detail->bagian = $request->bagian;
        $pumk_detail->pk = $request->pk;
        $pumk_detail->no_pumk = $request->no_pumk ? $request->no_pumk : null; // for add edit only

        if ($request->session == 'true') {
            $pumk_detail->account_nama = $request->account_nama;
            $pumk_detail->cj_nama = $request->cj_nama;
            $pumk_detail->jb_nama = $request->jb_nama;
            $pumk_detail->bagian_nama = $request->bagian_nama;

            if (session('pumk_detail')) {
                session()->push('pumk_detail', $pumk_detail);
            } else {
                session()->put('pumk_detail', []);
                session()->push('pumk_detail', $pumk_detail);
            }
            $this->pumk_detail_reset();
        } else {
            // insert to database
            $pumk_detail->save();
        }

        return response()->json(session('pumk_detail'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->session == 'true') {
            foreach (session('pumk_detail') as $key => $value) {
                if ($value['no'] == $request->no_urut and $value['no_pumk'] == $request->no_pumk) {
                    $pumk_detail = session("pumk_detail.$key");
                }
            }
        } else {
            $pumk_detail = PUmkDetail::where('no', $request->no_urut)
            ->where('no_pumk', $request->no_pumk)
            ->first();

            $account = DB::select("SELECT kodeacct, descacct FROM account WHERE kodeacct = '$pumk_detail->account'")[0];
            $c_judex = DB::select("SELECT kode, nama FROM cashjudex WHERE kode = '$pumk_detail->cj'")[0];

            $bagian = DB::select("SELECT kode, nama FROM sdm_tbl_kdbag WHERE kode = '$pumk_detail->bagian'")[0];

            $jenis_biaya = DB::select("SELECT kode,keterangan FROM jenisbiaya WHERE kode = '$pumk_detail->jb'")[0];

            $pumk_detail->account_nama = $account->descacct;
            $pumk_detail->cj_nama      = $c_judex->nama;
            $pumk_detail->jb_nama      = $jenis_biaya->keterangan;
            $pumk_detail->bagian_nama  = $bagian->nama;
        }

        return response()->json($pumk_detail, 200);
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
        if ($request->session == 'true') {
            // search
            // delete session
            // insert a new one
            // dd($no_urut);
            foreach (session('pumk_detail') as $key => $value) {
                if ($value['no'] == $request->no_urut and $value['no_pumk'] == $request->no_pumk) {
                    // dd($value);
                    $update_pumk_detail = $value;
                    $update_pumk_detail['no'] = $request->no;
                    $update_pumk_detail['keterangan'] = $request->keterangan;
                    $update_pumk_detail['account'] = $request->account;
                    $update_pumk_detail['nilai'] = $request->nilai;
                    $update_pumk_detail['cj'] = $request->cj;
                    $update_pumk_detail['jb'] = $request->jb;
                    $update_pumk_detail['bagian'] = $request->bagian;
                    $update_pumk_detail['pk'] = $request->pk;
                    $update_pumk_detail['no_pumk'] = $request->no_pumk ? $request->no_pumk : null; // for add edit only
                    $update_pumk_detail['account_nama'] = $request->account_nama;
                    $update_pumk_detail['cj_nama'] = $request->cj_nama;
                    $update_pumk_detail['jb_nama'] = $request->jb_nama;
                    $update_pumk_detail['bagian_nama'] = $request->bagian_nama;
            
                    $request->session()->put('pumk_detail'.$key, $update_pumk_detail);
                    $pumk_detail = $update_pumk_detail;
                }
            }

            $this->pumk_detail_reset();
        } else {
            // for Database
            $pumk_detail = PUmkDetail::where('no', $request->no_urut)
            ->where('no_pumk', $request->no_pumk)
            ->first();

            $pumk_detail->no = $request->no;
            $pumk_detail->keterangan = $request->keterangan;
            $pumk_detail->account = $request->account;
            $pumk_detail->nilai = $request->nilai;
            $pumk_detail->cj = $request->cj;
            $pumk_detail->jb = $request->jb;
            $pumk_detail->bagian = $request->bagian;
            $pumk_detail->pk = $request->pk;
            $pumk_detail->no_pumk = $request->no_pumk;

            $pumk_detail->save();
        }

        $data = $pumk_detail;
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // $no_pumk = substr($request->no_pumk, strpos($request->no_pumk, "-") + 1);

        if ($request->session == 'true') {
            // delete session
            foreach (session('pumk_detail') as $key => $value) {
                if ($value['no'] == $request->no) {
                    Session::forget('pumk_detail.' . $key);
                }
            }

            $this->pumk_detail_reset();
        } else {
            // delete Database
            PUmkDetail::where('no_pumk', $request->no_pumk)
            ->where('no', $request->no)
            ->delete();
        }

        return response()->json(['result' => session('pumk_detail')], 200);
    }

    public function pumk_detail_reset()
    {
        Session::put('pumk_detail', array_values(session('pumk_detail')));

        foreach (session('pumk_detail') as $key => $value) {
            $update_pumk_detail = $value;
            $update_pumk_detail['no']= $key + 1;
            Session::put('pumk_detail.'.$key, $update_pumk_detail);
        }
    }
}
