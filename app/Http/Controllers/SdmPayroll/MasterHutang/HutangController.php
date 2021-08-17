<?php

namespace App\Http\Controllers\SdmPayroll\MasterHutang;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterHutangStore;
use App\Http\Requests\MasterHutangUpdate;
use App\Models\AardPayroll;
use App\Models\MasterHutang;
use App\Models\MasterPegawai;
use Auth;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = MasterHutang::distinct('tahun')
        ->orderBy('tahun', 'desc')
        ->get();

        $pegawai_list = MasterPegawai::all();

        return view('modul-sdm-payroll.master-hutang.index', compact('tahun', 'pegawai_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $hutang_master_list = MasterHutang::orderByRaw('tahun::int DESC')
        ->orderByRaw('bulan::int DESC')
        ->orderBy('nopek', 'desc');

        return datatables()->of($hutang_master_list)
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
            ->addColumn('bulan_tahun', function ($row) {
                return bulan($row->bulan).' '.$row->tahun;
            })
            ->addColumn('pekerja', function ($row) {
                return $row->nopek.' - '.optional($row->pekerja)->nama;
            })
            ->addColumn('aard', function ($row) {
                return $row->aard.' - '.optional($row->aard_payroll)->nama;
            })
            ->addColumn('lastamount', function ($row) {
                return currency_idr($row->lastamount);
            })
            ->addColumn('curramount', function ($row) {
                return currency_idr($row->curramount);
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

        return view('modul-sdm-payroll.master-hutang.create', compact('pegawai_list', 'aard_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterHutangStore $request, MasterHutang $hutang)
    {
        $hutang->tahun      = $request->tahun;
        $hutang->bulan      = $request->bulan;
        $hutang->nopek      = $request->pegawai;
        $hutang->aard       = $request->aard;
        $hutang->lastamount = str_replace(',', '', $request->last_amount);
        $hutang->curramount = str_replace(',', '', $request->current_amount);
        $hutang->userid     = Auth::user()->userid;

        $hutang->save();

        Alert::success('Tambah Master Hutang', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_hutang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tahun, $bulan, $nopek, $aard)
    {
        $hutang = MasterHutang::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orWhere('nopeg', $nopek)
        ->get();

        $aard_list = AardPayroll::all();

        return view('modul-sdm-payroll.master-hutang.edit', compact('pegawai_list', 'aard_list', 'hutang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterHutangUpdate $request, $tahun, $bulan, $nopek, $aard)
    {
        $hutang = MasterHutang::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $hutang->tahun      = $request->tahun;
        $hutang->bulan      = $request->bulan;
        $hutang->nopek      = $request->pegawai;
        $hutang->aard       = $request->aard;
        $hutang->lastamount = str_replace(',', '', $request->last_amount);
        $hutang->curramount = str_replace(',', '', $request->current_amount);
        $hutang->userid     = Auth::user()->userid;

        $hutang->save();

        Alert::success('Ubah Master Hutang', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_hutang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $hutang = MasterHutang::where('tahun', $request->tahun)
        ->where('bulan', $request->bulan)
        ->where('nopek', $request->nopek)
        ->where('aard', $request->aard)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
