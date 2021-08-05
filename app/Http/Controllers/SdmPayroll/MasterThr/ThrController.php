<?php

namespace App\Http\Controllers\SdmPayroll\MasterThr;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterThrStore;
use App\Http\Requests\MasterThrUpdate;
use App\Models\AardPayroll;
use App\Models\MasterThr;
use App\Models\MasterPegawai;
use Auth;
use Illuminate\Http\Request;

class ThrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = MasterThr::distinct('tahun')
        ->orderBy('tahun', 'desc')
        ->get();

        $pegawai_list = MasterPegawai::all();

        return view('modul-sdm-payroll.master-thr.index', compact('tahun', 'pegawai_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $thr_master_list = MasterThr::orderByRaw('tahun::int DESC')
        ->orderByRaw('bulan::int DESC')
        ->orderBy('nopek', 'DESC');

        return datatables()->of($thr_master_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('no_pekerja')) {
                    $query->where('nopek', 'like', "%{$request->get('no_pekerja')}%");
                }

                if ($request->get('bulan')) {
                    $query->where('bulan', '=', $request->get('bulan'));
                }

                if ($request->get('tahun')) {
                    $query->where('tahun', '=', $request->get('tahun'));
                }
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_upah_all_in" value="'.$row->tahun.'-'.$row->bulan.'-'.$row->nopek.'-'.$row->aard.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('bulan', function ($row) {
                return bulan($row->bulan);
            })
            ->addColumn('pekerja', function ($row) {
                return $row->nopek.' - '.$row->pekerja->nama;
            })
            ->addColumn('aard', function ($row) {
                return $row->aard.' - '.$row->aard_payroll->nama;
            })
            ->addColumn('jmlcc', function ($row) {
                return currency_idr($row->jmlcc);
            })
            ->addColumn('ccl', function ($row) {
                return currency_idr($row->ccl);
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
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
        $pegawai_list = MasterPegawai::where('status', '<>', 'P')->get();
        $aard_list = AardPayroll::all();

        return view('modul-sdm-payroll.master-thr.create', compact('pegawai_list', 'aard_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterThrStore $request, MasterThr $thr)
    {
        $thr->tahun  = $request->tahun;
        $thr->bulan  = $request->bulan;
        $thr->nopek  = $request->pegawai;
        $thr->aard   = $request->aard;
        $thr->jmlcc  = $request->jumlah_cicilan;
        $thr->ccl    = $request->cicilan;
        $thr->nilai  = $request->nilai;
        $thr->userid = Auth::user()->userid;

        $thr->save();

        Alert::success('Tambah Master THR', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_thr.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tahun, $bulan, $nopek, $aard)
    {
        $thr = MasterThr::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orWhere('nopeg', $nopek)
        ->get();

        $aard_list = AardPayroll::all();

        return view('modul-sdm-payroll.master-thr.edit', compact('pegawai_list', 'aard_list', 'thr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterThrUpdate $request, $tahun, $bulan, $nopek, $aard)
    {
        $thr = MasterThr::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $thr->tahun  = $request->tahun;
        $thr->bulan  = $request->bulan;
        $thr->nopek  = $request->pegawai;
        $thr->aard   = $request->aard;
        $thr->jmlcc  = $request->jumlah_cicilan;
        $thr->ccl    = $request->cicilan;
        $thr->nilai  = $request->nilai;
        $thr->userid = Auth::user()->userid;

        $thr->save();

        Alert::success('Ubah Master THR', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_thr.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $thr = MasterThr::where('tahun', $request->tahun)
        ->where('bulan', $request->bulan)
        ->where('nopek', $request->nopek)
        ->where('aard', $request->aard)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
