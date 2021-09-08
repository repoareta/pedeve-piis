<?php

namespace App\Http\Controllers\SdmPayroll\MasterBebanPerusahaan;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterBebanPerusahaanStore;
use App\Http\Requests\MasterBebanPerusahaanUpdate;
use App\Models\AardPayroll;
use App\Models\MasterBebanPerusahaan;
use App\Models\MasterPegawai;
use Auth;
use Illuminate\Http\Request;

class BebanPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = MasterBebanPerusahaan::distinct('tahun')
        ->orderBy('tahun', 'desc')
        ->get();

        $pegawai_list = MasterPegawai::all();

        return view('modul-sdm-payroll.master-beban-perusahaan.index', compact('tahun', 'pegawai_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $beban_perusahaan_master_list = MasterBebanPerusahaan::orderByRaw('tahun::int DESC')
        ->orderByRaw('bulan::int DESC')
        ->orderBy('nopek', 'DESC');

        return datatables()->of($beban_perusahaan_master_list)
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
                return $row->nopek.' - '.$row->pekerja->nama;
            })
            ->addColumn('aard', function ($row) {
                return $row->aard.' - '.$row->aard_payroll->nama;
            })
            ->addColumn('nilai', function ($row) {
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

        return view('modul-sdm-payroll.master-beban-perusahaan.create', compact('pegawai_list', 'aard_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterBebanPerusahaanStore $request, MasterBebanPerusahaan $beban_perusahaan)
    {
        $beban_perusahaan->tahun      = $request->tahun;
        $beban_perusahaan->bulan      = $request->bulan;
        $beban_perusahaan->nopek      = $request->pegawai;
        $beban_perusahaan->aard       = $request->aard;
        $beban_perusahaan->lastamount = sanitize_nominal($request->last_amount);
        $beban_perusahaan->curramount = sanitize_nominal($request->current_amount);
        $beban_perusahaan->userid     = Auth::user()->userid;

        $beban_perusahaan->save();

        Alert::success('Tambah Master Beban Perusahaan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_beban_perusahaan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tahun, $bulan, $nopek, $aard)
    {
        $beban_perusahaan = MasterBebanPerusahaan::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orWhere('nopeg', $nopek)
        ->get();

        $aard_list = AardPayroll::all();

        return view('modul-sdm-payroll.master-beban-perusahaan.edit', compact('pegawai_list', 'aard_list', 'beban_perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterBebanPerusahaanUpdate $request, $tahun, $bulan, $nopek, $aard)
    {
        $beban_perusahaan = MasterBebanPerusahaan::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $beban_perusahaan->tahun      = $request->tahun;
        $beban_perusahaan->bulan      = $request->bulan;
        $beban_perusahaan->nopek      = $request->pegawai;
        $beban_perusahaan->aard       = $request->aard;
        $beban_perusahaan->lastamount = sanitize_nominal($request->last_amount);
        $beban_perusahaan->curramount = sanitize_nominal($request->current_amount);
        $beban_perusahaan->userid     = Auth::user()->userid;

        $beban_perusahaan->save();

        Alert::success('Ubah Master Beban Perusahaan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_beban_perusahaan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $beban_perusahaan = MasterBebanPerusahaan::where('tahun', $request->tahun)
        ->where('bulan', $request->bulan)
        ->where('nopek', $request->nopek)
        ->where('aard', $request->aard)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
