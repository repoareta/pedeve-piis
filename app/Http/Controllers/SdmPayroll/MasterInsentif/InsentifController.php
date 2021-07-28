<?php

namespace App\Http\Controllers\SdmPayroll\MasterInsentif;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterInsentifStore;
use App\Http\Requests\MasterInsentifUpdate;
use App\Models\AardPayroll;
use App\Models\MasterInsentif;
use App\Models\MasterPegawai;
use Auth;
use Illuminate\Http\Request;

class InsentifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = MasterInsentif::distinct('tahun')
        ->orderBy('tahun', 'desc')
        ->get();

        $pegawai_list = MasterPegawai::all();

        return view('modul-sdm-payroll.master-insentif.index', compact('tahun', 'pegawai_list'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $insentif_master_list = MasterInsentif::orderByRaw('tahun::int DESC')
        ->orderByRaw('bulan::int DESC')
        ->orderBy('nopek', 'desc');

        return datatables()->of($insentif_master_list)
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
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_upah_all_in" value="'.$row->tahun.'-'.$row->bulan.'-'.$row->nopek.'-'.$row->aard.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('bulan', function ($row) {
                return bulan($row->bulan);
            })
            ->addColumn('pekerja', function ($row) {
                return $row->nopek.' - '.optional($row->pekerja)->nama;
            })
            ->addColumn('aard', function ($row) {
                return $row->aard.' - '.optional($row->aard_payroll)->nama;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->nilai);
            })
            ->rawColumns(['action'])
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

        return view('modul-sdm-payroll.master-insentif.create', compact('pegawai_list', 'aard_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MasterInsentifStore $request, MasterInsentif $insentif)
    {
        $insentif->tahun      = $request->tahun;
        $insentif->bulan      = $request->bulan;
        $insentif->nopek      = $request->pegawai;
        $insentif->aard       = $request->aard;
        $insentif->jmlcc      = 0;
        $insentif->ccl        = 0;
        $insentif->nilai      = $request->nilai;
        $insentif->userid     = Auth::user()->userid;
        $insentif->status     = MasterPegawai::find($request->pegawai)->status;
        $insentif->tahunins   = $request->tahun_insentif;
        $insentif->pajakins   = null;
        $insentif->pajakgaji  = null;
        $insentif->pengali    = null;
        $insentif->ut         = null;
        $insentif->keterangan = null;
        $insentif->potongan   = null;

        $insentif->save();

        Alert::success('Tambah Master Insentif', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_insentif.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tahun, $bulan, $nopek, $aard)
    {
        $insentif = MasterInsentif::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orWhere('nopeg', $nopek)
        ->get();

        $aard_list = AardPayroll::all();

        return view('modul-sdm-payroll.master-insentif.edit', compact('pegawai_list', 'aard_list', 'insentif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MasterInsentifUpdate $request, $tahun, $bulan, $nopek, $aard)
    {
        $insentif = MasterInsentif::where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('nopek', $nopek)
        ->where('aard', $aard)
        ->first();

        $insentif->tahun      = $request->tahun;
        $insentif->bulan      = $request->bulan;
        $insentif->nopek      = $request->pegawai;
        $insentif->aard       = $request->aard;
        $insentif->jmlcc      = 0;
        $insentif->ccl        = 0;
        $insentif->nilai      = $request->nilai;
        $insentif->userid     = Auth::user()->userid;
        $insentif->status     = MasterPegawai::find($request->pegawai)->status;
        $insentif->tahunins   = $request->tahun_insentif;
        $insentif->pajakins   = null;
        $insentif->pajakgaji  = null;
        $insentif->pengali    = null;
        $insentif->ut         = null;
        $insentif->keterangan = null;
        $insentif->potongan   = null;

        $insentif->save();

        Alert::success('Ubah Master Insentif', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.master_insentif.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $insentif = MasterInsentif::where('tahun', $request->tahun)
        ->where('bulan', $request->bulan)
        ->where('nopek', $request->nopek)
        ->where('aard', $request->aard)
        ->delete();

        return response()->json(['delete' => true], 200);
    }
}
