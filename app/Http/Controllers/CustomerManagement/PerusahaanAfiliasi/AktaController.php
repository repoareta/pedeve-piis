<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\AktaStore;
use App\Http\Requests\AktaUpdate;
use App\Models\Akta;
use App\Models\PerusahaanAfiliasi;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class AktaController extends Controller
{
    /**
     * Menampilkan daftar akta perusahaan tersebut
     *
     * @return void
     */
    public function indexJson($perusahaan_afiliasi)
    {
        $akta_list = Akta::where('perusahaan_afiliasi_id', $perusahaan_afiliasi);

        return datatables()->of($akta_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_akta" nama="' . $row->jenis . '" value="' . $row->id . '"><span></span></label>';
                return $radio;
            })
            ->addColumn('dokumen', function ($row) {
                $files = collect($row->files);

                $dokumen = null;

                foreach ($files as $file) {
                    $file_path = asset("storage/$row->perusahaan_afiliasi_id/akta/$file->dokumen");
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
        return view('modul-customer-management.perusahaan-afiliasi.akta.create', compact(
            'perusahaan_afiliasi'
        ));
    }

    public function edit(PerusahaanAfiliasi $perusahaan_afiliasi, Akta $akta)
    {
        // dd($akta);
        return view('modul-customer-management.perusahaan-afiliasi.akta.edit', compact(
            'perusahaan_afiliasi',
            'akta',
        ));
    }

    /**
     * Insert Pemegang Saham Ke Database
     *
     * @param AktaStore $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Akta $akta
     * @return void
     */
    public function store(
        AktaStore $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Akta $akta
    ) {
        $akta->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $akta->jenis = $request->jenis_akta;
        $akta->nomor_akta = $request->nomor_akta;
        $akta->tanggal = $request->tanggal_akta;
        $akta->notaris = $request->notaris;
        $akta->tmt_mulai = $request->tmt_berlaku;
        $akta->tmt_akhir = $request->tmt_berakhir;
        $akta->created_by = auth()->user()->nopeg;
        $akta->dokumen = '0';

        $akta->save();

        $files = $request->file('filedok');

        if ($files) {
            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                
                $findOldFile = public_path('storage/' . $perusahaan_afiliasi->id . '/akta/' . $file_name);
                $pathToSave = $perusahaan_afiliasi->id . '/akta';

                $fileName = (new FileUploadService($file, $pathToSave, $findOldFile))->upload();

                $akta->files()->insert([
                    'akta_id' => $akta->id,
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
     * @param Akta $akta
     * @return void
     */
    public function show(PerusahaanAfiliasi $perusahaan_afiliasi, Akta $akta)
    {
        return response()->json($akta, 200);
    }

    /**
     * Undocumented function
     *
     * @param AktaUpdate $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Akta $akta
     * @return void
     */
    public function update(
        AktaUpdate $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Akta $akta
    ) {
        $akta->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $akta->jenis = $request->jenis_akta;
        $akta->nomor_akta = $request->nomor_akta;
        $akta->tanggal = $request->tanggal_akta;
        $akta->notaris = $request->notaris;
        $akta->tmt_mulai = $request->tmt_berlaku;
        $akta->tmt_akhir = $request->tmt_berakhir;
        $akta->created_by = auth()->user()->nopeg;
        $akta->dokumen = '0';

        $akta->save();

        $files = $request->file('filedok');

        if ($files) {
            Storage::delete(Storage::allFiles("public/$perusahaan_afiliasi->id/akta/"));
            $akta->files()->delete();

            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();

                $findOldFile = public_path('storage/' . $perusahaan_afiliasi->id . '/akta/' . $file_name);
                $pathToSave = $perusahaan_afiliasi->id . '/akta';

                $fileName = (new FileUploadService($file, $pathToSave, $findOldFile))->upload();

                $akta->files()->insert([
                    'akta_id' => $akta->id,
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
     * @param Akta $akta
     * @return void
     */
    public function delete(PerusahaanAfiliasi $perusahaan_afiliasi, Akta $akta)
    {
        // Value is not URL but directory file path
        Storage::delete(Storage::allFiles("public/$perusahaan_afiliasi->id/akta/"));
        $akta->files()->delete();
        $akta->delete();

        return response()->json(['delete' => true], 200);
    }
}
