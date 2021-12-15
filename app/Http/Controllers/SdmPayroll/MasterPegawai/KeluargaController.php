<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\KeluargaStore;
use App\Http\Requests\KeluargaUpdate;
use App\Models\Agama;
use App\Models\Keluarga;
use App\Models\MasterPegawai;
use App\Models\Pendidikan;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class KeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(MasterPegawai $pegawai)
    {
        $keluarga_list = Keluarga::where('nopeg', $pegawai->nopeg);

        return datatables()->of($keluarga_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_keluarga" data-nama="'.$row->nama.'" data-nopeg="' . $row->nopeg . '" data-status="'.$row->status.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'S') {
                    return "Suami";
                } elseif ($row->status == 'I') {
                    return "Istri";
                }

                return "Anak";
            })
            ->addColumn('agama', function ($row) {
                return $row->kode_agama->nama;
            })
            ->addColumn('tgllahir', function ($row) {
                return Carbon::parse($row->tgllahir)->translatedFormat('d F Y');
            })
            ->addColumn('pendidikan', function ($row) {
                return "$row->kodependidikan ($row->tempatpendidikan)";
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, MasterPegawai $pegawai)
    {
        $agama_list = Agama::all();
        $pendidikan_list = Pendidikan::all();
        return view('modul-sdm-payroll.master-pegawai._keluarga.create', compact(
            'pegawai',
            'agama_list',
            'pendidikan_list'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeluargaStore $request, MasterPegawai $pegawai, Keluarga $keluarga)
    {
        $keluarga->nopeg            = $pegawai->nopeg;
        $keluarga->status           = $request->status;
        $keluarga->nama             = $request->nama;
        $keluarga->tempatlahir      = $request->tempat_lahir;
        $keluarga->tgllahir         = $request->tanggal_lahir;
        $keluarga->agama            = $request->agama;
        $keluarga->goldarah         = $request->golongan_darah;
        $keluarga->kodependidikan   = $request->pendidikan;
        $keluarga->tempatpendidikan = $request->tempat_pendidikan;
        $keluarga->kodept           = null;
        $keluarga->userid           = Auth::user()->userid;
        $keluarga->tglentry         = Carbon::now();

        $photo_keluarga = $request->file('photo_keluarga');
        $nama_keluarga = str_replace(' ', '_', $keluarga->nama);

        if ($photo_keluarga) {
            $photo = $photo_keluarga->getClientOriginalName();
            $extension = $photo_keluarga->getClientOriginalExtension();
            $keluarga->photo = str_replace(
                $photo,
                $pegawai->nopeg."_".$keluarga->status."_".$nama_keluarga.".".$extension,
                $photo
            );
            $photo_path = $photo_keluarga->storeAs('img_pegawai', $keluarga->photo, 'public');
        }

        $keluarga->save();

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MasterPegawai $pegawai, $status, $nama)
    {
        $agama_list = Agama::all();
        $pendidikan_list = Pendidikan::all();

        $keluarga = Keluarga::where('nopeg', $pegawai->nopeg)
            ->where('status', $status)
            ->where('nama', $nama)
            ->first();

        // dd($keluarga);

        return view('modul-sdm-payroll.master-pegawai._keluarga.edit', compact(
            'keluarga',
            'pegawai',
            'agama_list',
            'pendidikan_list',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KeluargaUpdate $request, MasterPegawai $pegawai, $status, $nama)
    {
        $keluarga = Keluarga::where('nopeg', $pegawai->nopeg)
        ->where('status', $status)
        ->where('nama', $nama)
        ->first();

        $keluarga->nopeg            = $pegawai->nopeg;
        $keluarga->status           = $request->status;
        $keluarga->nama             = $request->nama;
        $keluarga->tempatlahir      = $request->tempat_lahir;
        $keluarga->tgllahir         = $request->tanggal_lahir;
        $keluarga->agama            = $request->agama;
        $keluarga->goldarah         = $request->golongan_darah;
        $keluarga->kodependidikan   = $request->pendidikan;
        $keluarga->tempatpendidikan = $request->tempat_pendidikan;
        $keluarga->kodept           = null;
        $keluarga->userid           = Auth::user()->userid;
        $keluarga->tglentry         = Carbon::now();

        $photo_keluarga = $request->file('photo_keluarga');
        $nama_keluarga = str_replace(' ', '_', $keluarga->nama);

        if ($photo_keluarga) {
            $photo = $photo_keluarga->getClientOriginalName();
            $extension = $photo_keluarga->getClientOriginalExtension();
            $keluarga->photo = str_replace(
                $photo,
                $pegawai->nopeg."_".$keluarga->status."_".$nama_keluarga.".".$extension,
                $photo
            );
            $photo_path = $photo_keluarga->storeAs('img_pegawai', $keluarga->photo, 'public');
        }

        $keluarga->save();

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.master_pegawai.edit', [$pegawai->nopeg]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(MasterPegawai $pegawai, $status, $nama)
    {
        $keluarga = Keluarga::where('nopeg', $pegawai->nopeg)
                        ->where('status', $status)
                        ->where('nama', $nama)
                        ->first();

        $image_path = "public/img_pegawai/$keluarga->photo";  // Value is not URL but directory file path
        Storage::delete($image_path);

        $keluarga->delete();

        return response()->json(['delete' => true], 200);
    }
}
