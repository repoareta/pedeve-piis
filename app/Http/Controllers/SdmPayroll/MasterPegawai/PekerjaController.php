<?php

namespace App\Http\Controllers\SdmPayroll\MasterPegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Load Model
use App\Models\Pekerja;
use App\Models\Jabatan;
use App\Models\KodeJabatan;
use App\Models\KodeBagian;
use App\Models\Provinsi;
use App\Models\Agama;
use App\Models\Pendidikan;
use App\Models\PerguruanTinggi;
use App\Models\PayTunjangan;

//load form request (for validation)
use App\Http\Requests\PekerjaStore;
use App\Http\Requests\PekerjaUpdate;

// Load Plugin
use Carbon\Carbon;
use Alert;
use Storage;

class PekerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-sdm-payroll.master-pekerja.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $pegawai_list = Pekerja::orderBy('tglentry', 'desc')
        ->with('jabatan');

        return datatables()->of($pegawai_list)
            ->filter(function ($query) use ($request) {
                if (request('nopeg')) {
                    $query->where('nopeg', request('nopeg'));
                }

                if (request('status')) {
                    $query->where('status', request('status'));
                }
            })
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->nopeg.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('bagian', function ($row) {
                $kode_bagian = optional($row->jabatan_latest())->kdbag;
                $bagian = KodeBagian::find($kode_bagian);
                $nama_bagian = optional($bagian)->nama ? ' - '.optional($bagian)->nama : null;
                
                return $kode_bagian.$nama_bagian;
            })
            ->addColumn('jabatan', function ($row) {
                $kode_bagian = optional($row->jabatan_latest())->kdbag;
                $kode_jabatan = optional($row->jabatan_latest())->kdjab;
                $jabatan = KodeJabatan::where('kdbag', $kode_bagian)
                    ->where('kdjab', $kode_jabatan)
                    ->first();
                $nama_jabatan = optional($jabatan)->keterangan ? ' - '.optional($jabatan)->keterangan : null;
                
                return $kode_jabatan.$nama_jabatan;
            })
            ->addColumn('status', function ($row) {
                $status = $row->status;
                switch ($status) {
                    case "B":
                        return "Perbantuan";
                        break;
                    case "K":
                        return "Kontrak";
                        break;
                    case "C":
                        return "Aktif";
                        break;
                    case "P":
                        return "Pensiun";
                        break;
                    case "U":
                        return "Komisaris";
                        break;
                    case "D":
                        return "Direksi";
                        break;
                    case "N":
                        return "Pekerja Baru";
                        break;
                    case "O":
                        return "Komite";
                        break;
                    default:
                        return "Status tidak di temukan";
                        break;
                }
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
        $kode_bagian_list = KodeBagian::all();
        $kode_jabatan_list = KodeJabatan::all();
        $provinsi_list = Provinsi::all();
        $agama_list = Agama::all();
        $pendidikan_list = Pendidikan::all();

        return view('pekerja.create', compact(
            'kode_bagian_list',
            'kode_jabatan_list',
            'provinsi_list',
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
    public function store(PekerjaStore $request, Pekerja $pegawai)
    {
        $pegawai->nopeg        = $request->nomor;
        $pegawai->nama         = $request->nama;
        $pegawai->status       = $request->status;
        $pegawai->tgllahir     = $request->tanggal_lahir;
        $pegawai->tempatlhr    = $request->tempat_lahir;
        $pegawai->proplhr      = $request->provinsi;
        $pegawai->agama        = $request->agama;
        $pegawai->goldarah     = $request->golongan_darah;
        $pegawai->notlp        = $request->no_telepon;
        $pegawai->kodekeluarga = $request->kode_keluarga;
        $pegawai->noydp        = $request->no_ydp;
        $pegawai->noastek      = $request->no_astek;
        $pegawai->tglaktifdns  = $request->tanggal_aktif_dinas;
        $pegawai->alamat1      = $request->alamat_1;
        $pegawai->alamat2      = $request->alamat_2;
        $pegawai->alamat3      = $request->alamat_3;
        $pegawai->gelar1       = $request->gelar_1;
        $pegawai->gelar2       = $request->gelar_2;
        $pegawai->gelar3       = $request->gelar_3;
        $pegawai->nohp         = $request->no_handphone;
        $pegawai->gender       = $request->jenis_kelamin;
        $pegawai->npwp         = $request->npwp;
        $pegawai->userid       = auth()->user()->userid;
        $pegawai->tglentry     = Carbon::now();
        $pegawai->fasilitas    = null;
        $pegawai->noktp        = $request->ktp;

        if ($request->file('photo')) {
            $photo = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $pegawai->photo = str_replace($photo, $pegawai->nopeg.".".$extension, $photo);
            $photo_path = $request->file('photo')->storeAs('pekerja_img', $pegawai->photo, 'public');
        }

        $pegawai->save();

        if ($request->url == 'edit') {
            return redirect()->route('pekerja.edit', ['pekerja' => $pegawai->nopeg]);
        }
        Alert::success('Simpan Pekerja', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('pekerja.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJson(Pekerja $pegawai)
    {
        // SHOW
        // Nopeg, Nama Jabatan dan Golongan
        $pegawai_jabatan = $pegawai->jabatan_latest()->first();
        $kode_jabatan = KodeJabatan::where('kdjab', $pegawai_jabatan->kdjab)
        ->where('kdbag', $pegawai_jabatan->kdbag)
        ->firstOrFail();

        $data = [
            'golongan' => $kode_jabatan->goljob,
            'jabatan' => $kode_jabatan->keterangan,
            'pekerja' => $pegawai
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pekerja $pegawai)
    {
        $kode_bagian_list = KodeBagian::all();
        $kode_jabatan_list = KodeJabatan::all();
        $provinsi_list = Provinsi::all();
        $agama_list = Agama::all();
        $pendidikan_list = Pendidikan::all();
        $perguruan_tinggi_list = PerguruanTinggi::all();
        $golongan_gaji_list = PayTunjangan::all();

        return view('pekerja.edit', compact(
            'kode_bagian_list',
            'kode_jabatan_list',
            'provinsi_list',
            'agama_list',
            'pendidikan_list',
            'perguruan_tinggi_list',
            'golongan_gaji_list',
            'pekerja'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PekerjaUpdate $request, Pekerja $pegawai)
    {
        $pegawai->nopeg        = $request->nomor;
        $pegawai->nama         = $request->nama;
        $pegawai->status       = $request->status;
        $pegawai->tgllahir     = $request->tanggal_lahir;
        $pegawai->tempatlhr    = $request->tempat_lahir;
        $pegawai->proplhr      = $request->provinsi;
        $pegawai->agama        = $request->agama;
        $pegawai->goldarah     = $request->golongan_darah;
        $pegawai->notlp        = $request->no_telepon;
        $pegawai->kodekeluarga = $request->kode_keluarga;
        $pegawai->noydp        = $request->no_ydp;
        $pegawai->noastek      = $request->no_astek;
        $pegawai->tglaktifdns  = $request->tanggal_aktif_dinas;
        $pegawai->alamat1      = $request->alamat_1;
        $pegawai->alamat2      = $request->alamat_2;
        $pegawai->alamat3      = $request->alamat_3;
        $pegawai->gelar1       = $request->gelar_1;
        $pegawai->gelar2       = $request->gelar_2;
        $pegawai->gelar3       = $request->gelar_3;
        $pegawai->nohp         = $request->no_handphone;
        $pegawai->gender       = $request->jenis_kelamin;
        $pegawai->npwp         = $request->npwp;
        $pegawai->userid       = auth()->user()->userid;
        $pegawai->tglentry     = Carbon::now();
        $pegawai->fasilitas    = null;
        $pegawai->noktp        = $request->ktp;

        if ($request->file('photo')) {
            // Value is not URL but directory file path
            $image_path = "public/pekerja_img/$pegawai->photo";
            Storage::delete($image_path);

            $photo = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $pegawai->photo = str_replace($photo, $pegawai->nopeg.".".$extension, $photo);
            $photo_path = $request->file('photo')->storeAs('pekerja_img', $pegawai->photo, 'public');
        }

        $pegawai->save();
        
        Alert::success('Ubah Pekerja', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('pekerja.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $pegawai = Pekerja::find($request->id);
        
        // $image_path = "public/pekerja_img/$pegawai->photo";  // Value is not URL but directory file path
        // Storage::delete($image_path);

        $pegawai->delete();

        return response()->json();
    }
}