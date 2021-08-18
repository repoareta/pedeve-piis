<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use Alert;
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
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_komisaris" nama="'.$row->nama.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    /**
     * Undocumented function
     *
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @return void
     */
    public function create(PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        return view(
            'modul-customer-management.perusahaan-afiliasi.komisaris.create',
            compact(
                'perusahaan_afiliasi'
            )
        );
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
        $komisaris->nama = $request->nama;
        $komisaris->tmt_dinas = $request->tmt_dinas;
        $komisaris->akhir_masa_dinas = $request->akhir_masa_dinas;
        $komisaris->created_by = auth()->user()->nopeg;

        $komisaris->save();

        Alert::success('Tambah Komisaris', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route(
            'modul_cm.perusahaan_afiliasi.edit',
            [
            'perusahaan_afiliasi' => $perusahaan_afiliasi->id
        ]
        );
    }

    /**
     * Undocumented function
     *
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @return void
     */
    public function edit(PerusahaanAfiliasi $perusahaan_afiliasi, Komisaris $komisaris)
    {
        return view(
            'modul-customer-management.perusahaan-afiliasi.komisaris.edit',
            compact(
                'perusahaan_afiliasi',
                'komisaris'
            )
        );
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
        $komisaris->nama = $request->nama;
        $komisaris->tmt_dinas = $request->tmt_dinas;
        $komisaris->akhir_masa_dinas = $request->akhir_masa_dinas;
        $komisaris->created_by = auth()->user()->nopeg;

        $komisaris->save();

        Alert::success('Ubah Komisaris', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route(
            'modul_cm.perusahaan_afiliasi.edit',
            [
                'perusahaan_afiliasi' => $perusahaan_afiliasi->id
            ]
        );
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
