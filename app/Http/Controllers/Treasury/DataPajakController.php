<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\PajakInput;
use DB;
use Illuminate\Http\Request;

class DataPajakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_akses = DB::table('usermenu')->where('userid', auth()->user()->userid)->where('menuid', 509)->first();

        return view('modul-treasury.data-pajak.index', compact('data_akses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        if ($request->pencarian <> "") {
            $pencarian = $request->pencarian;
        } else {
            $pencarian = date('Y');
        }
        $data = DB::select("SELECT tahun,bulan,nopek,jenis,nilai,pajak,(select nama from sdm_master_pegawai where nopeg=nopek) as nm_pegawai,(select nama from pay_tbl_aard where kode=jenis) as nm_jenis from pajak_input where tahun like '%$pencarian%' or nopek like '%$pencarian%' order by nopek");
        return datatables()->of($data)
            ->addColumn('tahun', function ($data) {
                return $data->tahun;
            })
            ->addColumn('bulan', function ($data) {
                return $data->bulan;
            })
            ->addColumn('pekerja', function ($data) {
                return $data->nopek . '  -  ' . $data->nm_pegawai;
            })
            ->addColumn('jenis', function ($data) {
                return $data->jenis . '  -  ' . $data->nm_jenis;
            })
            ->addColumn('nilai', function ($data) {
                return currency_format($data->nilai);
            })
            ->addColumn('pajak', function ($data) {
                return currency_format($data->pajak);
            })
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" tahun="' . $data->tahun . '"  bulan="' . $data->bulan . '" jenis="' . $data->jenis . '" nopek="' . $data->nopek . '" class="btn-radio"><span></span></label>';
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
        $data_pegawai = DB::select("SELECT nopeg, nama, status, nama from sdm_master_pegawai order by nopeg");

        return view('modul-treasury.data-pajak.create', compact('data_pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_cek = DB::select("SELECT * from pajak_input where tahun='$request->tahun' and bulan='$request->bulan' and nopek='$request->nopek' and jenis='$request->jenis'");

        if (!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        }

        PajakInput::insert([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'nopek' => $request->nopek,
            'jenis' => $request->jenis,
            'nilai' => str_replace(',', '.', $request->nilai),
            'pajak' => str_replace(',', '.', $request->pajak),
        ]);

        $data = 1;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tahun, $bulan, $nopek, $jenis)
    {
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai order by nopeg");

        $data = DB::table('pajak_input')->where('tahun', '=', $tahun)
            ->where('bulan', '=', $bulan)
            ->where('nopek', '=', $nopek)
            ->where('jenis', '=', $jenis)
            ->first();

        $tahun = $data->tahun;
        $bulan = $data->bulan;
        $jenis = $data->jenis;
        $nopek = $data->nopek;
        $nilai = $data->nilai;
        $pajak = $data->pajak;
        
        return view('modul-treasury.data-pajak.edit', compact('tahun', 'bulan', 'jenis', 'nopek', 'nilai', 'pajak', 'data_pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = DB::table('pajak_input')
            ->where('tahun', $request->tahun)
            ->where('bulan', '=', $request->bulan)
            ->where('nopek', '=', $request->nopek)
            ->where('jenis', '=', $request->jenis)
            ->update([
                'nilai' => str_replace(',', '.', $request->nilai),
                'pajak' => str_replace(',', '.', $request->pajak),
            ]);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = DB::table('pajak_input')
            ->where('tahun', $request->tahun)
            ->where('bulan', '=', $request->bulan)
            ->where('nopek', '=', $request->nopek)
            ->where('jenis', '=', $request->jenis)
            ->delete();

        return response()->json($data);
    }
}
