<?php

namespace App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerusahaanAfiliasiStore;
use App\Http\Requests\PerusahaanAfiliasiUpdate;
use App\Models\Akta;
use App\Models\Direksi;
use App\Models\Komisaris;
use App\Models\PemegangSaham;
use App\Models\Perizinan;
use App\Models\PerusahaanAfiliasi;
use DomPDF;
use Illuminate\Http\Request;

class PerusahaanAfiliasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-customer-management.perusahaan-afiliasi.index');
    }

    /**
     * Menampilkan daftar perusahaan afiliasi
     *
     * @return void
     */
    public function indexJson()
    {
        $perusahaan_afiliasi_list = PerusahaanAfiliasi::all();

        return datatables()->of($perusahaan_afiliasi_list)
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" data-nama="'.$row->nama.'" value="'.$row->id.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-customer-management.perusahaan-afiliasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerusahaanAfiliasiStore $request, PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        $perusahaan_afiliasi->nama = $request->nama_perusahaan;
        $perusahaan_afiliasi->telepon = $request->no_telepon;
        $perusahaan_afiliasi->npwp = $request->npwp;
        $perusahaan_afiliasi->alamat = $request->alamat;
        $perusahaan_afiliasi->bidang_usaha = $request->bidang_usaha;
        $perusahaan_afiliasi->modal_dasar = sanitize_nominal($request->modal_dasar);
        $perusahaan_afiliasi->modal_disetor = sanitize_nominal($request->modal_disetor);
        $perusahaan_afiliasi->jumlah_lembar_saham = sanitize_nominal($request->jumlah_lembar_saham);
        $perusahaan_afiliasi->nilai_nominal_per_saham = sanitize_nominal($request->nilai_nominal_per_saham);
        $perusahaan_afiliasi->created_by = auth()->user()->nopeg;

        $perusahaan_afiliasi->save();

        if ($request->url == 'edit') {
            return redirect()->route('modul_cm.perusahaan_afiliasi.edit', ['perusahaan_afiliasi' => $perusahaan_afiliasi]);
        }

        Alert::success('Simpan Perusahaan Afiliasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        return view('modul-customer-management.perusahaan-afiliasi.detail', compact('perusahaan_afiliasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        return view('modul-customer-management.perusahaan-afiliasi.edit', compact('perusahaan_afiliasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerusahaanAfiliasiUpdate $request, PerusahaanAfiliasi $perusahaan_afiliasi)
    {
        $perusahaan_afiliasi->nama = $request->nama_perusahaan;
        $perusahaan_afiliasi->telepon = $request->no_telepon;
        $perusahaan_afiliasi->npwp = $request->npwp;
        $perusahaan_afiliasi->alamat = $request->alamat;
        $perusahaan_afiliasi->bidang_usaha = $request->bidang_usaha;
        $perusahaan_afiliasi->modal_dasar = sanitize_nominal($request->modal_dasar);
        $perusahaan_afiliasi->modal_disetor = sanitize_nominal($request->modal_disetor);
        $perusahaan_afiliasi->jumlah_lembar_saham = sanitize_nominal($request->jumlah_lembar_saham);
        $perusahaan_afiliasi->nilai_nominal_per_saham = sanitize_nominal($request->nilai_nominal_per_saham);
        $perusahaan_afiliasi->created_by = auth()->user()->nopeg;

        $perusahaan_afiliasi->save();

        Alert::success('Update Perusahaan Afiliasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_cm.perusahaan_afiliasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $perusahaan = PerusahaanAfiliasi::find($request->id);
        $perusahaan->delete();

        return response()->json();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function export(PerusahaanAfiliasi $perusahaanAfiliasi)
    {
        $pemegangSahamList = PemegangSaham::where('perusahaan_afiliasi_id', $perusahaanAfiliasi->id)->get();
        $direksiList = Direksi::where('perusahaan_afiliasi_id', $perusahaanAfiliasi->id)->get();
        $komisarisList = Komisaris::where('perusahaan_afiliasi_id', $perusahaanAfiliasi->id)->get();
        $perizinanList = Perizinan::where('perusahaan_afiliasi_id', $perusahaanAfiliasi->id)->get();
        $aktaList = Akta::where('perusahaan_afiliasi_id', $perusahaanAfiliasi->id)->get();
        
        $pdf = DomPDF::loadView(
            'modul-customer-management.perusahaan-afiliasi.export-row-pdf',
            compact(
                'perusahaanAfiliasi',
                'pemegangSahamList',
                'direksiList',
                'komisarisList',
                'perizinanList',
                'aktaList'
            )
        );

        return $pdf->stream(
            'perusahaan_afiliasi'.date('Y-m-d H:i:s').'.pdf'
        );
    }
}
