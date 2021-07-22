<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerizinanStore;
use App\Http\Requests\PerizinanUpdate;
use App\Models\Perizinan;
use App\Models\PerusahaanAfiliasi;
use Illuminate\Http\Request;
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
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_perizinan" nama="'.$row->keterangan.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('dokumen', function ($row) {
                $file_path = asset("storage/$row->perusahaan_afiliasi_id/perizinan/$row->dokumen");
                $dokumen = '<a href="'.$file_path.'" target=_blank>'.$row->dokumen.'</a>';
                return $dokumen;
            })
            ->rawColumns(['action', 'dokumen'])
            ->make(true);
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
        $perizinan->keterangan = $request->keterangan_perizinan;
        $perizinan->nomor = $request->nomor_perizinan;
        $perizinan->masa_berlaku_akhir = $request->masa_berlaku_akhir_perizinan;
        $perizinan->created_by = auth()->user()->nopeg;

        $file = $request->file('dokumen_perizinan');

        if ($file) {
            $file_name = $file->getClientOriginalName();
            $perizinan->dokumen = $file_name;
            $file_path = $file->storeAs(
                $perusahaan_afiliasi->id.'/perizinan',
                $perizinan->dokumen,
                'public'
            );
        }

        $perizinan->save();

        return response()->json($perizinan, 200);
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
        $perizinan->keterangan = $request->keterangan_perizinan;
        $perizinan->nomor = $request->nomor_perizinan;
        $perizinan->masa_berlaku_akhir = $request->masa_berlaku_akhir_perizinan;
        $perizinan->created_by = auth()->user()->nopeg;

        $file = $request->file('dokumen_perizinan');

        if ($file) {
            // Value is not URL but directory file path
            $file_path = "public/$perusahaan_afiliasi->id/perizinan/$perizinan->dokumen";
            Storage::delete($file_path);
        
            $file_name = $file->getClientOriginalName();
            $perizinan->dokumen = $file_name;
            $file_path = $file->storeAs(
                $perusahaan_afiliasi->id.'/perizinan',
                $perizinan->dokumen,
                'public'
            );
        }

        $perizinan->save();

        return response()->json($perizinan, 200);
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
        $file_path = "public/$perusahaan_afiliasi->id/perizinan/$perizinan->dokumen";
        Storage::delete($file_path);

        $perizinan->delete();

        return response()->json(['delete' => true], 200);
    }
}
