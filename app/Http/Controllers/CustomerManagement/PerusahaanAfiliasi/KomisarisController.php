<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\KomisarisStore;
use App\Http\Requests\KomisarisUpdate;
use App\Models\Komisaris;
use App\Models\PerusahaanAfiliasi;
use Illuminate\Http\Request;

class KomisarisController extends Controller
{
    /**
     * Menampilkan daftar komisaris perusahaan tersebut
     *
     * @return void
     */
    public function indexJson($perusahaan_afiliasi)
    {
        $komisaris_list = Komisaris::where('perusahaan_afiliasi_id', $perusahaan_afiliasi);

        return datatables()->of($komisaris_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio_komisaris" nama="'.$row->nama.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Insert Pemegang Saham Ke Database
     *
     * @param KomisarisStore $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Komisaris $komisaris
     * @return void
     */
    public function store(
        KomisarisStore $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Komisaris $komisaris
    ) {
        $komisaris->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $komisaris->nama = $request->nama_komisaris;
        $komisaris->tmt_dinas = $request->tmt_dinas_komisaris;
        $komisaris->akhir_masa_dinas = $request->akhir_masa_dinas_komisaris;
        $komisaris->created_by = auth()->user()->nopeg;

        $komisaris->save();

        return response()->json($komisaris, 200);
    }

    /**
     * menampilkan detail satu data pemegang saham
     *
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Komisaris $komisaris
     * @return void
     */
    public function show(PerusahaanAfiliasi $perusahaan_afiliasi, Komisaris $komisaris)
    {
        return response()->json($komisaris, 200);
    }

    /**
     * Undocumented function
     *
     * @param KomisarisUpdate $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param Komisaris $komisaris
     * @return void
     */
    public function update(
        KomisarisUpdate $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        Komisaris $komisaris
    ) {
        $komisaris->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $komisaris->nama = $request->nama_komisaris;
        $komisaris->tmt_dinas = $request->tmt_dinas_komisaris;
        $komisaris->akhir_masa_dinas = $request->akhir_masa_dinas_komisaris;
        $komisaris->created_by = auth()->user()->nopeg;

        $komisaris->save();

        return response()->json($komisaris, 200);
    }

    /**
     * Delete Pemegang Saham
     *
     * @param Komisaris $komisaris
     * @return void
     */
    public function delete(PerusahaanAfiliasi $perusahaan_afiliasi, Komisaris $komisaris)
    {
        $komisaris->delete();

        return response()->json(['delete' => true], 200);
    }
}
