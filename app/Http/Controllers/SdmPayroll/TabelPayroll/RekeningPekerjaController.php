<?php

namespace App\Http\Controllers\SdmPayroll\TabelPayroll;

use App\Http\Controllers\Controller;
use App\Models\MasterPegawai;
use App\Models\PayTblRekening;
use DB;
use Alert;
use App\Http\Requests\RekeningPekerjaStore;
use App\Http\Requests\RekeningPekerjaUpdate;
use Illuminate\Http\Request;

class RekeningPekerjaController extends Controller
{
    public function index()
    {
        return view('modul-sdm-payroll.rekening-pekerja.index');
    }

    public function indexJson()
    {
        $tunjangan_list = DB::select("SELECT a.nopek,a.kdbank,a.rekening,a.atasnama,(select nama from pay_tbl_bank where kode=a.kdbank) as namabank, (select nama from sdm_master_pegawai where nopeg=a.nopek) as namapekerja from pay_tbl_rekening a order by nopek");
        
        return datatables()->of($tunjangan_list)
        ->addColumn('radio', function ($row) {
            return '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" class="btn-radio" value="'.$row->nopek.'" name="btn-radio">
                            <span></span>
                    <label>';
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
        $data_bank = DB::select("SELECT kode, nama, alamat, kota from pay_tbl_bank");

        return view('modul-sdm-payroll.rekening-pekerja.create',compact('data_pegawai','data_bank'));
    }


    public function store(RekeningPekerjaStore $request)
    {
        PayTblRekening::insert([
            'nopek' => $request->nopek,
            'kdbank' => $request->kdbank,
            'rekening' => $request->rekening,
            'atasnama' => $request->atasnama,
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.rekening_pekerja.index');
    }


    public function edit($id)
    {
        $data_pegawai = MasterPegawai::where('status', '<>', 'P')
                                        ->orderBy('nopeg')
                                        ->get();
        
        $data_bank = DB::select("SELECT kode, nama, alamat, kota from pay_tbl_bank");
        
        $rekening = PayTblRekening::where('nopek', $id)->first();

        return view('modul-sdm-payroll.rekening-pekerja.edit',compact('data_pegawai','data_bank', 'rekening'));
    }


    public function update(RekeningPekerjaUpdate $request)
    {
        PayTblRekening::where('nopek', $request->nopek)
        ->update([
            'kdbank' => $request->kdbank,
            'rekening' => $request->rekening,
            'atasnama' => $request->atasnama,
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.rekening_pekerja.index');
    }


    public function delete(Request $request)
    {
        PayTblRekening::where('nopek', $request->kode)
        ->delete();

        return response()->json();
    }
}
