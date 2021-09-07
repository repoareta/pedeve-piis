<?php

namespace App\Http\Controllers\Umum\UangMukaKerja;

use App\Http\Controllers\Controller;
use App\Http\Requests\PUMKDetailStoreRequest;
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
        $no_pumk = str_replace('-', '/', $request->no_pumk);
        $pumk_list_detail = PUmkDetail::where('no_pumk', $no_pumk)
            ->get();

        return datatables()->of($pumk_list_detail)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="' . $row->no . '-' . $row->no_pumk . '"><span></span></label>';
                return $radio;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->addColumn('total', function ($row) {
                return float_two($row->nilai);
            })

            ->rawColumns(['radio'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PUMKDetailStoreRequest $request)
    {
        $pumk_detail = new PUmkDetail;
        $pumk_detail->no = $request->no_urut;
        $pumk_detail->keterangan = $request->keterangan;
        $pumk_detail->account = $request->account;
        $pumk_detail->nilai = sanitize_nominal($request->nilai);
        $pumk_detail->cj = $request->cj;
        $pumk_detail->jb = $request->jb;
        $pumk_detail->bagian = $request->bagian;
        $pumk_detail->pk = $request->pk;
        $pumk_detail->no_pumk = $request->no_pumk;

        $pumk_detail->save();

        return response()->json($pumk_detail, 200);
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
        $pumk_detail = PUmkDetail::where('no', $request->no_urut)
            ->where('no_pumk', $request->no_pumk)
            ->first();

        $pumk_detail->no = $request->no_urut;
        $pumk_detail->keterangan = $request->keterangan;
        $pumk_detail->account = $request->account;
        $pumk_detail->nilai = sanitize_nominal($request->nilai);
        $pumk_detail->cj = $request->cj;
        $pumk_detail->jb = $request->jb;
        $pumk_detail->bagian = $request->bagian;
        $pumk_detail->pk = $request->pk;
        $pumk_detail->no_pumk = $request->no_pumk;

        $pumk_detail->save();

        return response()->json($pumk_detail, 200);
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
            $update_pumk_detail['no'] = $key + 1;
            Session::put('pumk_detail.' . $key, $update_pumk_detail);
        }
    }
}
