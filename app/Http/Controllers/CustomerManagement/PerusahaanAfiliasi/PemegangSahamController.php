<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PemegangSahamStore;
use App\Http\Requests\PemegangSahamUpdate;
use App\Models\PemegangSaham;
use App\Models\PerusahaanAfiliasi;
use Illuminate\Http\Request;

class PemegangSahamController extends Controller
{
    /**
     * Menampilkan daftar pemegang saham perusahaan tersebut
     *
     * @return void
     */
    public function indexJson($perusahaan_afiliasi)
    {
        $pemegang_saham_list = PemegangSaham::where('perusahaan_afiliasi_id', $perusahaan_afiliasi);

        return datatables()->of($pemegang_saham_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio_pemegang_saham" nama="'.$row->nama.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create(PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        return view('modul-customer-management.perusahaan-afiliasi.pemegang-saham.create', compact(
            'perusahaan_afiliasi'
        ));
    }

    /**
     * Insert Pemegang Saham Ke Database
     *
     * @param PemegangSahamStore $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param PemegangSaham $pemegang_saham
     * @return void
     */
    public function store(
        PemegangSahamStore $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        PemegangSaham $pemegang_saham
    ) {
        $pemegang_saham->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $pemegang_saham->nama = $request->nama_pemegang_saham;
        $pemegang_saham->kepemilikan = $request->kepemilikan;
        $pemegang_saham->jumlah_lembar_saham = sanitize_nominal($request->jumlah_lembar_saham_pemegang_saham);
        $pemegang_saham->created_by = auth()->user()->nopeg;

        $pemegang_saham->save();

        Alert::success('Tambah Pemegang Saham', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.edit', 
        [
            'perusahaan_afiliasi' => $perusahaan_afiliasi->id
        ]);
    }

    /**
     * menampilkan detail satu data pemegang saham
     *
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param PemegangSaham $pemegang_saham
     * @return void
     */
    public function edit(PerusahaanAfiliasi $perusahaan_afiliasi, PemegangSaham $pemegang_saham)
    {
        return view('modul-customer-management.perusahaan-afiliasi.pemegang-saham.edit', compact(
            'perusahaan_afiliasi',
            'pemegang_saham'
        ));
    }

    /**
     * Undocumented function
     *
     * @param PemegangSahamUpdate $request
     * @param PerusahaanAfiliasi $perusahaan_afiliasi
     * @param PemegangSaham $pemegang_saham
     * @return void
     */
    public function update(
        PemegangSahamUpdate $request,
        PerusahaanAfiliasi $perusahaan_afiliasi,
        PemegangSaham $pemegang_saham
    ) {
        $pemegang_saham->perusahaan_afiliasi_id = $perusahaan_afiliasi->id;
        $pemegang_saham->nama = $request->nama_pemegang_saham;
        $pemegang_saham->kepemilikan = $request->kepemilikan;
        $pemegang_saham->jumlah_lembar_saham = sanitize_nominal($request->jumlah_lembar_saham_pemegang_saham);
        $pemegang_saham->created_by = auth()->user()->nopeg;

        $pemegang_saham->save();

        Alert::success('Ubah Pemegang Saham', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.edit', 
        [
            'perusahaan_afiliasi' => $perusahaan_afiliasi->id
        ]);
    }

    /**
     * Delete Pemegang Saham
     *
     * @param PemegangSaham $pemegang_saham
     * @return void
     */
    public function delete(PerusahaanAfiliasi $perusahaan_afiliasi, PemegangSaham $pemegang_saham)
    {
        $pemegang_saham->delete();

        return response()->json(['delete' => true], 200);
    }
}
