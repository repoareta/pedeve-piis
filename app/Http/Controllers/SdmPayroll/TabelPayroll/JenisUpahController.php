<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayTblJenisUpah;
use DB;
use Illuminate\Http\Request;

class JenisUpahController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.jenis-upah.index');
    }

    public function indexJson()
    {
        $jenisUpah = PayTblJenisUpah::all();
        
        return datatables()->of($jenisUpah)
        ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.$row->kode.'" name="btn-radio"><span></span><label>';
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        return view('modul-sdm-payroll.jenis-upah.create');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_jenisupah where kode = '$request->kode'" ); 			
        if(!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
        PayTblJenisUpah::insert([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'cetak' => $request->cetak,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        $data_list = PayTblJenisUpah::where('kode', $id)->get();
        foreach($data_list as $data)
        {
            $kode = $data->kode;
            $nama = $data->nama;
            $cetak = $data->cetak;
        }
        return view('modul-sdm-payroll.jenis-upah.edit',compact('kode','nama','cetak'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->update([
            'nama' => $request->nama,
            'cetak' => $request->cetak,
        ]);

        return response()->json();
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request)
    {
        PayTblJenisUpah::where('kode', $request->kode)
        ->delete();

        return response()->json();
    }
}
