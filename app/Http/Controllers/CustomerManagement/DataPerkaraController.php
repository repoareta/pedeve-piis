<?php

namespace App\Http\Controllers\CustomerManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\Userpdv;

// load plugin
use DB;
use Alert;
use App\Http\Requests\DataPerkaraStoreRequest;
use App\Http\Requests\DetailDokumenStoreRequest;
use App\Http\Requests\DetailPihakStoreRequest;
use Illuminate\Support\Facades\File;

class DataPerkaraController extends Controller
{
    public function index()
    {
        return view('modul-customer-management.data-perkara.index');
    }

    public function indexJson(Request $request)
    {
        $data = DB::select("SELECT * from tbl_perkara");

        return datatables()->of($data)
            ->addColumn('no_perkara', function ($data) {
                return $data->no_perkara;
            })
            ->addColumn('tanggal', function ($data) {
                $tgl = date_create($data->tgl_perkara);
                $tanggal = date_format($tgl, 'd/m/Y');

                return $tanggal;
            })
            ->addColumn('jenis_perkara', function ($data) {
                return $data->jenis_perkara;
            })
            ->addColumn('klasifikasi_perkara', function ($data) {
                return $data->klasifikasi_perkara;
            })
            ->addColumn('status_perkara', function ($data) {
                return $data->status_perkara;
            })
            ->addColumn('detail', function ($data) {
                return  '<a href="' . route('modul_cm.data_perkara.detail', ['no' => str_replace('/', '--', $data->no_perkara)]) . '">Detail</a>';
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="' . str_replace('/', '--', $data->no_perkara) . '" value="' . str_replace('/', '--', $data->no_perkara) . '" name="btn-radio"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio', 'view', 'detail'])
            ->make(true);
    }


    public function detail($no)
    {
        $noperkara = str_replace('--', '/', $no);
        $data_list = DB::select("SELECT * from tbl_perkara where no_perkara='$noperkara'");
        $data_ = DB::select("SELECT a.*, b.nama nama_hakim from tbl_pihak a join tbl_hakim b on a.kd_pihak=b.kd_pihak  where a.no_perkara='$noperkara'");
        $data_p = DB::select("SELECT a.* from tbl_pihak a where a.no_perkara='$noperkara'");

        return view('modul-customer-management.data-perkara.detail-perkara', compact('data_list', 'data_', 'data_p'));
    }

    public function create()
    {
        return view('modul-customer-management.data-perkara.create');
    }

    public function store(DataPerkaraStoreRequest $request)
    {
        $validated = collect($request->validated())
            ->put('file', '0')
            ->put('rate', 1)
            ->forget('nilai_perkara')
            ->put('nilai_perkara', (string) str_replace([',', '.'], '', $request->nilai_perkara))
            ->toArray();

        DB::table('tbl_perkara')->insert($validated);

        Alert::success('Data berhasil di simpan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.data_perkara.index');
    }

    //pihak
    public function searchpihak(Request $request)
    {
        $data = DB::select("SELECT * from tbl_pihak where no_perkara='$request->no_perkara'");
        return datatables()->of($data)
            ->addColumn('nama', function ($data) {
                return $data->nama;
            })
            ->addColumn('alamat', function ($data) {
                return $data->alamat;
            })
            ->addColumn('telp', function ($data) {
                return $data->telp;
            })
            ->addColumn('keterangan', function ($data) {
                return $data->keterangan;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "Penggugat";
                } elseif ($data->status == 2) {
                    return "Tergugat";
                } elseif ($data->status == 3) {
                    return "Turut Tergugat";
                } else {
                    return "";
                }
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="' . $data->kd_pihak . '" value="' . $data->kd_pihak . '" name="btn-radio"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function pihak(DetailPihakStoreRequest $request)
    {
        $latestId = DB::table('tbl_pihak')->latest('kd_pihak')->first()->kd_pihak + 1;

        if ($request->cek == 'A') {
            DB::table('tbl_pihak')->where('kd_pihak', $request->kd_pihak)
                ->update([
                    'no_perkara' => $request->no_perkara,
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                    'keterangan' => $request->keterangan,
                    'status' => $request->status,
                ]);
            return response()->json();
        } else {
            DB::table('tbl_pihak')->insert([
                'kd_pihak' => $latestId,
                'no_perkara' => $request->no_perkara,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'keterangan' => $request->keterangan,
                'status' => $request->status,
            ]);
            return response()->json();
        }
    }

    public function showPihak(Request $request)
    {
        $data = DB::select("SELECT * from tbl_pihak where kd_pihak='$request->kd'");
        return response()->json($data[0]);
    }

    public function deletepihak(Request $request)
    {
        DB::table('tbl_pihak')->where('kd_pihak', $request->id)->delete();
        return response()->json();
    }

    //hakim
    public function searchhakim(Request $request)
    {
        $data = DB::select("SELECT a.*,b.nama nama_p from tbl_hakim a join tbl_pihak b on a.kd_pihak=b.kd_pihak where b.no_perkara='$request->no_perkara'");
        return datatables()->of($data)
            ->addColumn('nama_p', function ($data) {
                return $data->nama_p;
            })
            ->addColumn('nama', function ($data) {
                return $data->nama;
            })
            ->addColumn('alamat', function ($data) {
                return $data->alamat;
            })
            ->addColumn('telp', function ($data) {
                return $data->telp;
            })
            ->addColumn('keterangan', function ($data) {
                return $data->keterangan;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return "Penggugat";
                } elseif ($data->status == 2) {
                    return "Tergugat";
                } elseif ($data->status == 3) {
                    return "Turut Tergugat";
                } else {
                    return "";
                }
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="' . $data->kd_hakim . '" value="' . $data->kd_hakim . '" name="btn-radio"><span></span></label>';
                return $radio;
            })


            ->rawColumns(['radio'])
            ->make(true);
    }

    public function pihakJson(Request $request)
    {
        $data = DB::select("SELECT a.* from tbl_pihak a  where a.status='$request->status' and a.no_perkara='$request->no_perkara'");
        return response()->json($data);
    }

    public function hakim(Request $request)
    {
        $latestId = DB::table('tbl_hakim')->latest('kd_hakim')->first()->kd_hakim + 1;

        if ($request->cekhakim == 'A') {
            DB::table('tbl_hakim')->where('kd_hakim', $request->kd_hakim)
                ->update([
                    'kd_pihak' => $request->kd_pihak,
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                    'keterangan' => $request->keterangan,
                    'status' => $request->status,
                ]);
            return response()->json(1);
        } else {
            DB::table('tbl_hakim')->insert([
                'kd_hakim' => $latestId,
                'kd_pihak' => $request->kd_pihak,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'keterangan' => $request->keterangan,
                'status' => $request->status,
            ]);
            return response()->json(2);
        }
    }

    public function showhakim(Request $request)
    {
        $data = DB::select("SELECT * from tbl_hakim where kd_hakim='$request->kd'");
        return response()->json($data[0]);
    }

    public function deletehakim(Request $request)
    {
        DB::table('tbl_hakim')->where('kd_hakim', $request->id)->delete();
        return response()->json();
    }

    public function edit($no)
    {
        $noperkara = str_replace('--', '/', $no);
        $data = DB::select("SELECT * FROM tbl_perkara WHERE no_perkara = '$noperkara'")[0];

        return view('modul-customer-management.data-perkara.edit', compact('data'));
    }

    public function update(DataPerkaraStoreRequest $request)
    {
        $validated = collect($request->validated())
            ->put('file', '0')
            ->put('rate', 1)
            ->forget(['nilai_perkara', 'no_perkara'])
            ->put('nilai_perkara', (string) str_replace([',', '.'], '', $request->nilai_perkara))
            ->toArray();

        DB::table('tbl_perkara')
            ->where('no_perkara', $request->no_perkara)
            ->update($validated);

        Alert::success('Data berhasil di simpan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.data_perkara.index');
    }

    public function delete(Request $request)
    {
        $data_pihak = DB::select("SELECT * from tbl_pihak where no_perkara='$request->kode'");
        foreach ($data_pihak as $data) {
            $data_p = $data->kd_pihak;
            DB::table('tbl_hakim')->where('kd_pihak', $data_p)->delete();
        }
        DB::table('tbl_perkara')->where('no_perkara', $request->kode)->delete();
        DB::table('tbl_pihak')->where('no_perkara', $request->kode)->delete();
        DB::table('tbl_dokumen_perkara')->where('no_perkara', $request->kode)->delete();
        if (File::isDirectory(public_path('/data_perkara/' . $request->kode))) {
            File::deleteDirectory(public_path('/data_perkara/' . $request->kode));
        }
        return response()->json();
    }

    public function Reset(Request $request)
    {
        $data_tglexp = DB::select("SELECT (date(now()) + INTERVAL  '4' month) as tglexp");
        foreach ($data_tglexp as $data_tgl) {
            $tglexp = $data_tgl->tglexp;
        }
        $tglupd = date('Y-m-d');
        $userpw = "v3ntur4";
        Userpdv::where('userid', $request->no)
            ->update([
                'userpw' => $userpw,
                'tglupd' => $tglupd,
                'passexp' => $tglexp
            ]);
        Alert::success('Password telah di Reset.', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.data_perkara.index');
    }

    public function searchdokumen(Request $request)
    {
        $data = DB::select("SELECT *  from tbl_dokumen_perkara where no_perkara='$request->no_perkara'");
        return datatables()->of($data)
            ->addColumn('nama', function ($data) {
                $dat = '<embed align="center"  width="800" height="400" src="' . asset('/data_perkara/' . $data->no_perkara . '/' . $data->file) . '" type="application/pdf"></embed>';
                return $dat;
            })
            ->addColumn('file', function ($data) {
                return $data->file;
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" no-perkara="' . $data->no_perkara . '" data-id="' . $data->kd_dok . '" file-id="' . $data->file . '" name="btn-radio"><span></span></label>';
                return $radio;
            })


            ->rawColumns(['radio', 'nama'])
            ->make(true);
    }

    public function dokumen(DetailDokumenStoreRequest $request)
    {
        $folderPath = public_path('/data_perkara/' . $request->no_perkara);
        
        File::ensureDirectoryExists($folderPath);

        if ($request->hasfile('filedok')) {
            foreach ($request->file('filedok') as $key => $file) {
                $name = time() . $key . '_' . $file->getClientOriginalName();
                $tujuan_upload = $folderPath;
                $file->move($tujuan_upload, $name);
                $data = $name;
                DB::table('tbl_dokumen_perkara')->insert([
                    'no_perkara' => $request->no_perkara,
                    'file' => $data,
                ]);
            }
        }
        
        return response()->json();
    }

    public function deletedokumen(Request $request)
    {
        DB::table('tbl_dokumen_perkara')->where('kd_dok', $request->kd_dok)->delete();
        File::delete('data_perkara/' . $request->noperkara . '/' . $request->filed);
        return response()->json();
    }
}
