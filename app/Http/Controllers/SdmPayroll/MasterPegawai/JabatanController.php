<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\JabatanStoreRequest;
use App\Models\Jabatan;
use App\Models\KodeBagian;
use App\Models\KodeJabatan;
use App\Models\MasterPegawai;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $jabatan_list = Jabatan::where('nopeg', $pegawai->nopeg);

        return datatables()->of($jabatan_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_jabatan" data-mulai="'.$row->mulai.'" data-kdbagian="'.$row->kdbag.'" data-kdjabatan="'.$row->kdjab.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('bagian', function ($row) {
                return $row->kdbag.' - '.$row->kode_bagian->nama;
            })
            ->addColumn('jabatan', function ($row) {
                $kode_bagian = $row->kdbag;
                $kode_jabatan = $row->kdjab;
                $jabatan = KodeJabatan::where('kdbag', $kode_bagian)
                    ->where('kdjab', $kode_jabatan)
                    ->first();
                $nama_jabatan = optional($jabatan)->keterangan ? ' - '.optional($jabatan)->keterangan : null;

                return $kode_jabatan.$nama_jabatan;
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        $kodeBagian = KodeBagian::all();

        return view('modul-sdm-payroll.master-pegawai._jabatan.create', compact(
            'kodeBagian',
            'pegawai',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JabatanStoreRequest $request, MasterPegawai $pegawai, Jabatan $jabatan)
    {
        $jabatan->nopeg    = $pegawai->nopeg;
        $jabatan->kdbag    = $request->bagian;
        $jabatan->kdjab    = $request->jabatan;
        $jabatan->mulai    = $request->mulai;
        $jabatan->sampai   = $request->sampai;
        $jabatan->noskep   = $request->no_skep;
        $jabatan->tglskep  = $request->tanggal_skep;
        $jabatan->userid   = Auth::user()->userid;
        $jabatan->tglentry = Carbon::now();
        // $jabatan->id       = null;

        $jabatan->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $jabatan = Jabatan::where('nopeg', $request->nopeg)
        ->where('mulai', $request->mulai)
        ->where('kdbag', $request->kdbag)
        ->where('kdjab', $request->kdjab)
        ->first();

        return response()->json($jabatan, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterPegawai $pegawai, $mulai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Jabatan::where('nopeg', $request->pegawai)
                ->where('mulai', $request->mulai)
                ->where('kdbag', $request->kdbagian)
                ->where('kdjab', $request->kdjabatan)
                ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
