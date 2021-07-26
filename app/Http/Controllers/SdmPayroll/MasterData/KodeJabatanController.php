<?php

namespace App\Http\Controllers\SdmPayroll\MasterData;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\KodeJabatanStore;
use App\Http\Requests\KodeJabatanUpdate;
use App\Models\KodeBagian;
use App\Models\KodeJabatan;
use Illuminate\Http\Request;

class KodeJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kode_jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $kode_jabatan_list = KodeJabatan::with('kode_bagian')
        ->orderBy('kdbag', 'asc')
        ->orderBy('kdjab', 'asc')
        ->get();

        return datatables()->of($kode_jabatan_list)
            ->addColumn('action', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kdbag.'-'.$row->kdjab.'"><span></span></label>';
                return $radio;
            })
            ->addColumn('kdbag', function ($row) {
                $kode_bagian = optional($row->kode_bagian)->nama ? ' - '.$row->kode_bagian->nama : null;
                return $row->kdbag.$kode_bagian;
            })
            ->addColumn('tunjangan', function ($row) {
                return currency_idr($row->tunjangan);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode_bagian_list = KodeBagian::all();
        return view('kode_jabatan.create', compact('kode_bagian_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KodeJabatanStore $request, KodeJabatan $kode_jabatan)
    {
        $kode_jabatan->kdbag = $request->kode_bagian;
        $kode_jabatan->kdjab = $request->kode_jabatan;
        $kode_jabatan->keterangan = $request->nama;
        $kode_jabatan->goljob = $request->golongan;
        $kode_jabatan->tunjangan = $request->tunjangan;
        $kode_jabatan->save();

        Alert::success('Simpan Data Kode Jabatan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('kode_jabatan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(KodeBagian $kode_bagian, $kdjab)
    {
        $kode_bagian_list = KodeBagian::all();

        $kode_jabatan = KodeJabatan::where('kdbag', $kode_bagian->kode)
        ->where('kdjab', $kdjab)
        ->firstOrFail();

        return view('kode_jabatan.edit', compact('kode_bagian', 'kode_bagian_list', 'kode_jabatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KodeJabatanUpdate $request, KodeBagian $kode_bagian, $kdjab)
    {
        $kode_jabatan = KodeJabatan::where('kdbag', $kode_bagian->kode)
        ->where('kdjab', $kdjab)
        ->firstOrFail();

        $kode_jabatan->kdbag = $request->kode_bagian;
        $kode_jabatan->kdjab = $request->kode_jabatan;
        $kode_jabatan->keterangan = $request->nama;
        $kode_jabatan->goljob = $request->golongan;
        $kode_jabatan->tunjangan = $request->tunjangan;

        try {
            $kode_jabatan->save();
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error('Kode Bagian dan Kode Jabatan sudah ada', 'Gagal')->persistent(true)->autoClose(2000);

            return redirect()->route('kode_jabatan.edit', ['kode_bagian' => $kode_bagian->kode, 'kode_jabatan' => $kdjab]);
        }

        Alert::success('Ubah Data Kode Jabatan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('kode_jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        KodeJabatan::where('kdbag', $request->kode_bagian)
        ->where('kdjab', $request->kode_jabatan)
        ->delete();

        return response()->json();
    }

    public function indexJsonByBagian(Request $request)
    {
        if ($request->kodebagian == '') {
            $kode_jabatan_list = KodeJabatan::all();
        } else {
            $kode_jabatan_list = KodeJabatan::where('kdbag', $request->kodebagian)->get();
        }

        
        

        $kode_jabatan_list_new = [];
        foreach ($kode_jabatan_list as $kode_jabatan) {
            $kode_jabatan_list_new[] = [
                'id'       => $kode_jabatan->kdjab,
                'text'     => $kode_jabatan->kdjab.' - '.$kode_jabatan->keterangan,
                'golongan' => $kode_jabatan->goljob
            ];
        }

        $pilih_jabatan[] =  array(
            'id'       => '',
            'text'     => '- Pilih Jabatan -',
            'golongan' => null
        );

        $kode_jabatan_list_new = array_merge($pilih_jabatan, $kode_jabatan_list_new);

        return response()->json($kode_jabatan_list_new, 200);
    }
}
