<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\GolonganGajiStore;
use App\Http\Requests\GolonganGajiUdpate;
use App\Models\GolonganGaji;
use App\Models\MasterPegawai;
use App\Models\PayTunjangan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class GolonganGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $golongan_gaji_list = GolonganGaji::where('nopeg', $pegawai->nopeg)->get();

        return datatables()->of($golongan_gaji_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_golongan_gaji" data-golgaji="'.$row->golgaji.'" data-tanggal="'.$row->tanggal->format('Y-m-d').'"><span></span></label>';
                return $radio;
            })
            ->addColumn('tanggal', function ($row) {
                return Carbon::parse($row->tanggal)->translatedFormat('d F Y');
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(MasterPegawai $pegawai)
    {
        $golongan_gaji_list = PayTunjangan::all();

        return view('modul-sdm-payroll.master-pegawai._golongan-gaji.create', compact(
            'pegawai',
            'golongan_gaji_list',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GolonganGajiStore $request, MasterPegawai $pegawai)
    {
        $golongan_gaji = new GolonganGaji;
        $golongan_gaji->nopeg = $pegawai->nopeg;
        $golongan_gaji->tanggal = $request->tanggal_golongan_gaji;
        $golongan_gaji->golgaji = $request->golongan_gaji;
        $golongan_gaji->userid = Auth::user()->userid;
        $golongan_gaji->tglentry = Carbon::now();

        $golongan_gaji->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Request $request)
    {
        $golongan_gaji = GolonganGaji::where('nopeg', $request->nopeg)
        ->where('golgaji', $request->golongan_gaji)
        ->where('tanggal', $request->tanggal)
        ->first();

        return response()->json($golongan_gaji, 200);
    }

    public function edit(Request $request, MasterPegawai $pegawai, $golongan_gaji, $tanggal)
    {
        $golonganGaji = GolonganGaji::where('nopeg', $pegawai->nopeg)
            ->where('golgaji', $golongan_gaji)
            ->where('tanggal', $tanggal)
            ->first();

        $golongan_gaji_list = PayTunjangan::all();

        return view('modul-sdm-payroll.master-pegawai._golongan-gaji.edit', compact(
            'golongan_gaji_list',
            'golonganGaji',
            'pegawai',
            'golongan_gaji',
            'tanggal',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GolonganGajiUdpate $request, MasterPegawai $pegawai, $golongan_gaji, $tanggal)
    {
        DB::table('sdm_golgaji')
            ->where('golgaji', $golongan_gaji)
            ->where('tanggal', $tanggal)
            ->update([
                'tanggal' => $request->tanggal_golongan_gaji,
                'golgaji' => $request->golongan_gaji,
            ]);

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        GolonganGaji::where('nopeg', $request->pegawai)
                    ->where('golgaji', $request->golongan_gaji)
                    ->where('tanggal', $request->tanggal)
                    ->delete();

        return response()->json(['deleted' => true], 200);
    }
}
