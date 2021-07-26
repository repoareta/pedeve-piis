<?php

namespace App\Http\Controllers\SdmPayroll\MasterPekerja;

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
        $pekerja_list = Pekerja::orderBy('tglentry', 'desc')
        ->with('jabatan');

        return datatables()->of($pekerja_list)
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
    public function store(PekerjaStore $request, Pekerja $pekerja)
    {
        $pekerja->nopeg        = $request->nomor;
        $pekerja->nama         = $request->nama;
        $pekerja->status       = $request->status;
        $pekerja->tgllahir     = $request->tanggal_lahir;
        $pekerja->tempatlhr    = $request->tempat_lahir;
        $pekerja->proplhr      = $request->provinsi;
        $pekerja->agama        = $request->agama;
        $pekerja->goldarah     = $request->golongan_darah;
        $pekerja->notlp        = $request->no_telepon;
        $pekerja->kodekeluarga = $request->kode_keluarga;
        $pekerja->noydp        = $request->no_ydp;
        $pekerja->noastek      = $request->no_astek;
        $pekerja->tglaktifdns  = $request->tanggal_aktif_dinas;
        $pekerja->alamat1      = $request->alamat_1;
        $pekerja->alamat2      = $request->alamat_2;
        $pekerja->alamat3      = $request->alamat_3;
        $pekerja->gelar1       = $request->gelar_1;
        $pekerja->gelar2       = $request->gelar_2;
        $pekerja->gelar3       = $request->gelar_3;
        $pekerja->nohp         = $request->no_handphone;
        $pekerja->gender       = $request->jenis_kelamin;
        $pekerja->npwp         = $request->npwp;
        $pekerja->userid       = auth()->user()->userid;
        $pekerja->tglentry     = Carbon::now();
        $pekerja->fasilitas    = null;
        $pekerja->noktp        = $request->ktp;

        if ($request->file('photo')) {
            $photo = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $pekerja->photo = str_replace($photo, $pekerja->nopeg.".".$extension, $photo);
            $photo_path = $request->file('photo')->storeAs('pekerja_img', $pekerja->photo, 'public');
        }

        $pekerja->save();

        if ($request->url == 'edit') {
            return redirect()->route('pekerja.edit', ['pekerja' => $pekerja->nopeg]);
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
    public function showJson(Pekerja $pekerja)
    {
        // SHOW
        // Nopeg, Nama Jabatan dan Golongan
        $pekerja_jabatan = $pekerja->jabatan_latest()->first();
        $kode_jabatan = KodeJabatan::where('kdjab', $pekerja_jabatan->kdjab)
        ->where('kdbag', $pekerja_jabatan->kdbag)
        ->firstOrFail();

        $data = [
            'golongan' => $kode_jabatan->goljob,
            'jabatan' => $kode_jabatan->keterangan,
            'pekerja' => $pekerja
        ];

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pekerja $pekerja)
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
    public function update(PekerjaUpdate $request, Pekerja $pekerja)
    {
        $pekerja->nopeg        = $request->nomor;
        $pekerja->nama         = $request->nama;
        $pekerja->status       = $request->status;
        $pekerja->tgllahir     = $request->tanggal_lahir;
        $pekerja->tempatlhr    = $request->tempat_lahir;
        $pekerja->proplhr      = $request->provinsi;
        $pekerja->agama        = $request->agama;
        $pekerja->goldarah     = $request->golongan_darah;
        $pekerja->notlp        = $request->no_telepon;
        $pekerja->kodekeluarga = $request->kode_keluarga;
        $pekerja->noydp        = $request->no_ydp;
        $pekerja->noastek      = $request->no_astek;
        $pekerja->tglaktifdns  = $request->tanggal_aktif_dinas;
        $pekerja->alamat1      = $request->alamat_1;
        $pekerja->alamat2      = $request->alamat_2;
        $pekerja->alamat3      = $request->alamat_3;
        $pekerja->gelar1       = $request->gelar_1;
        $pekerja->gelar2       = $request->gelar_2;
        $pekerja->gelar3       = $request->gelar_3;
        $pekerja->nohp         = $request->no_handphone;
        $pekerja->gender       = $request->jenis_kelamin;
        $pekerja->npwp         = $request->npwp;
        $pekerja->userid       = auth()->user()->userid;
        $pekerja->tglentry     = Carbon::now();
        $pekerja->fasilitas    = null;
        $pekerja->noktp        = $request->ktp;

        if ($request->file('photo')) {
            // Value is not URL but directory file path
            $image_path = "public/pekerja_img/$pekerja->photo";
            Storage::delete($image_path);

            $photo = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $pekerja->photo = str_replace($photo, $pekerja->nopeg.".".$extension, $photo);
            $photo_path = $request->file('photo')->storeAs('pekerja_img', $pekerja->photo, 'public');
        }

        $pekerja->save();
        
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
        $pekerja = Pekerja::find($request->id);
        
        // $image_path = "public/pekerja_img/$pekerja->photo";  // Value is not URL but directory file path
        // Storage::delete($image_path);

        $pekerja->delete();

        return response()->json();
    }
}
