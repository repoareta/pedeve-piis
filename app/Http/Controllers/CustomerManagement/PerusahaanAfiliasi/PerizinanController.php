<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerizinanStore;
use App\Http\Requests\PerizinanUpdate;
use App\Models\Perizinan;
use App\Models\PerusahaanAfiliasi;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class PerizinanController extends Controller
{
    /**
     * Menampilkan daftar perizinan perusahaan tersebut
     *
     * @return void
     */
    public function indexJson($perusahaan_afiliasi)
    {
        $perizinan_list = Perizinan::where('perusahaan_afiliasi_id', $perusahaan_afiliasi);

        return datatables()->of($perizinan_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_perizinan" nama="'.$row->keterangan.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('dokumen', function ($row) {
                $files = collect($row->files);

                $dokumen = null;

                foreach ($files as $file) {
                    $file_path = asset("storage/$row->perusahaan_afiliasi_id/perizinan/$file->dokumen");
                    $dokumen .= '<a href="' . $file_path . '" target=_blank>' . $file->dokumen . '</a>';
                    
                    if ($files->last()->id !== $file->id) {
                        $dokumen .= ', <br>';
                    }
                }

                return $dokumen;
            })
            ->rawColumns(['radio', 'dokumen'])
            ->make(true);
    }

    public function create(PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        return view('modul-customer-management.perusahaan-afiliasi.perizinan.create', compact(
            'perusahaan_afiliasi'
        ));
    }

    public function edit(PerusahaanAfiliasi $perusahaan_afiliasi, Perizinan $perizinan)
    {
        return view('modul-customer-management.perusahaan-afiliasi.perizinan.edit', compact(
            'perusahaan_afiliasi',
            'perizinan',
        ));
    }

    /**
     * Insert Pemegang Saham Ke Database
     *
     * @param PerizinanStore $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Perizinan $perizinan
     * @return void
     */
    public function store(
        PerizinanStore $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Perizinan $perizinan
    ) {
        $perizinan->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->nomor = $request->nomor;
        $perizinan->masa_berlaku_akhir = $request->masa_berlaku_akhir;
        $perizinan->created_by = auth()->user()->nopeg;
        $perizinan->dokumen = '0';

        $perizinan->save();

        $files = $request->file('filedok');

        if ($files) {
            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                
                $findOldFile = public_path('storage/' . $perusahaan_afiliasi->id . '/perizinan/' . $file_name);
                $pathToSave = $perusahaan_afiliasi->id . '/perizinan';

                $fileName = (new FileUploadService($file, $pathToSave, $findOldFile))->upload();

                $perizinan->files()->insert([
                    'perizinan_id' => $perizinan->id,
                    'dokumen' => $fileName,
                ]);
            }
        }

        Alert::success('Berhasil', 'Data berhasil di simpan')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.edit', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]);
    }

    /**
     * menampilkan detail satu data pemegang saham
     *
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Perizinan $perizinan
     * @return void
     */
    public function show(PerusahaanAfiliasi $perusahaan_afiliasi, Perizinan $perizinan)
    {
        return response()->json($perizinan, 200);
    }

    /**
     * Undocumented function
     *
     * @param PerizinanUpdate $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Perizinan $perizinan
     * @return void
     */
    public function update(
        PerizinanUpdate $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Perizinan $perizinan
    ) {
        $perizinan->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $perizinan->keterangan = $request->keterangan;
        $perizinan->nomor = $request->nomor;
        $perizinan->masa_berlaku_akhir = $request->masa_berlaku_akhir;
        $perizinan->created_by = auth()->user()->nopeg;
        $perizinan->dokumen = '0';
        
        $perizinan->save();

        $files = $request->file('filedok');

        if ($files) {
            Storage::delete(Storage::allFiles("public/$perusahaan_afiliasi->id/perizinan/"));
            $perizinan->files()->delete();

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();

                $findOldFile = public_path('storage/' . $perusahaan_afiliasi->id . '/perizinan/' . $file_name);
                $pathToSave = $perusahaan_afiliasi->id . '/perizinan';

                $fileName = (new FileUploadService($file, $pathToSave, $findOldFile))->upload();

                $perizinan->files()->insert([
                    'perizinan_id' => $perizinan->id,
                    'dokumen' => $fileName,
                ]);
            }
        }

        Alert::success('Berhasil', 'Data berhasil di simpan')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.edit', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]);
    }

    /**
     * Delete Pemegang Saham
     *
     * @param Perizinan $perizinan
     * @return void
     */
    public function delete(PerusahaanAfiliasi $perusahaan_afiliasi, Perizinan $perizinan)
    {
        // Value is not URL but directory file path
        Storage::delete(Storage::allFiles("public/$perusahaan_afiliasi->id/perizinan/"));
        $perizinan->files()->delete();
        $perizinan->delete();

        return response()->json(['delete' => true], 200);
    }
}
