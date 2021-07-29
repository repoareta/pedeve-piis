<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\MasterPegawai;
use App\Models\PayTblRekening;
use DB;
use Illuminate\Http\Request;

class RekeningPekerjaController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.rekening-pekerja.index');
    }

    public function indexJson()
    {
        $tunjangan_list = DB::select("select a.nopek,a.kdbank,a.rekening,a.atasnama,(select nama from pay_tbl_bank where kode=a.kdbank) as namabank, (select nama from sdm_master_pegawai where nopeg=a.nopek) as namapekerja from pay_tbl_rekening a order by nopek");
        
        return datatables()->of($tunjangan_list)
        ->addColumn('radio', function ($row) {
                return '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" kode="'.$row->nopek.'" name="btn-radio"><span></span><label>';
        })
        ->addColumn('namapekerja', function ($row) {
             return $row->nopek.' -- '.$row->namapekerja;
        })
        ->addColumn('namabank', function ($row) {
             return $row->kdbank.' -- '.$row->namabank;
        })
        ->rawColumns(['radio'])
        ->make(true);
    }


    public function create()
    {
        $data_pegawai = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nopeg')
        ->get();
        $data_bank = DB::select("select kode, nama, alamat, kota from pay_tbl_bank");
        return view('modul-sdm-payroll.rekening-pekerja.create',compact('data_pegawai','data_bank'));
    }


    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_tbl_rekening where nopek = '$request->nopek'" ); 			
        if(!empty($data_cek)) {
            $data = 2;
            return response()->json($data);
        } else {
            PayTblRekening::insert([
                'nopek' => $request->nopek,
                'kdbank' => $request->kdbank,
                'rekening' => $request->rekening,
                'atasnama' => $request->atasnama,
            ]);
            $data = 1;
            return response()->json($data);
        }
    }


    public function edit($id)
    {
        $data_pegawai = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nopeg')
        ->get();
        
        $data_bank = DB::select("select kode, nama, alamat, kota from pay_tbl_bank");
        
        $rekening = PayTblRekening::where('nopek', $id)->first();

        return view('modul-sdm-payroll.rekening-pekerja.edit',compact('data_pegawai','data_bank', 'rekening'));
    }


    public function update(Request $request)
    {
        PayTblRekening::where('nopek', $request->nopek)
        ->update([
            'kdbank' => $request->kdbank,
            'rekening' => $request->rekening,
            'atasnama' => $request->atasnama,
        ]);
        
        return response()->json();
    }


    public function delete(Request $request)
    {
        PayTblRekening::where('nopek', $request->kode)
        ->delete();

        return response()->json();
    }
}
