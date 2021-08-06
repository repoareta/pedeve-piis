<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\AktaStore;
use App\Http\Requests\AktaUpdate;
use App\Models\Akta;
use App\Models\PerusahaanAfiliasi;
use Illuminate\Http\Request;
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
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_akta" nama="'.$row->jenis.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('dokumen', function ($row) {
                $file_path = asset("storage/$row->perusahaan_afiliasi_id/akta/$row->dokumen");
                $dokumen = '<a href="'.$file_path.'" target=_blank>'.$row->dokumen.'</a>';
                return $dokumen;
            })
            ->rawColumns(['radio', 'dokumen'])
            ->make(true);
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

        $file = $request->file('dokumen_akta');

        if ($file) {
            $file_name = $file->getClientOriginalName();
            $akta->dokumen = $file_name;
            $file_path = $file->storeAs(
                $perusahaan_afiliasi->id.'/akta',
                $akta->dokumen,
                'public'
            );
        }

        $akta->save();

        return response()->json($akta, 200);
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

        $file = $request->file('dokumen_akta');

        if ($file) {
            // Value is not URL but directory file path
            $file_path = "public/$perusahaan_afiliasi->id/akta/$akta->dokumen";
            Storage::delete($file_path);
        
            $file_name = $file->getClientOriginalName();
            $akta->dokumen = $file_name;
            $file_path = $file->storeAs(
                $perusahaan_afiliasi->id.'/akta',
                $akta->dokumen,
                'public'
            );
        }

        $akta->save();

        return response()->json($akta, 200);
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
        $file_path = "public/$perusahaan_afiliasi->id/akta/$akta->dokumen";
        Storage::delete($file_path);

        $akta->delete();

        return response()->json(['delete' => true], 200);
    }
}
