<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MasterPekerjaController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.master-pekerja.index');
    }

    public function indexJson(Request $request)
    {
        $data = DB::select("
            SELECT 
                A.PERUSAHAAN, 
                C.NAMA AS NAMAPRSHN, 
                A.NOPEK, 
                A.NAMA, 
                A.UNIT, 
                A.UNITLALU, 
                B.NAMA AS NAMAUNIT, 
                A.STATUS, 
                A.TGLLAHIR, 
                A.TGLDINAS, 
                A.TGLPENSIUN, 
                A.nopek_lokasi,
                B.KODE
            FROM 
                TAB_TBL_PEKERJA A, 
                TAB_TBL_UNIT B, 
                TAB_TBL_PRSHN C 
            WHERE 
                A.PERUSAHAAN = C.KODE 
            AND A.UNIT = B.KODE 
        ");
        
        return datatables()->of($data)
        ->addColumn('tgllahir', function ($data) {
            return date('d M Y', strtotime($data->tgllahir));
        })
        ->addColumn('tglpensiun', function ($data) {
            return date('d M Y', strtotime($data->tglpensiun));
        })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->nopek.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }
 
    public function create()
    {
        $data_perusahaan = DB::select("select * from tab_tbl_prshn");
        return view('modul-kontroler.master-pekerja.create',compact('data_perusahaan'));
    }

    public function store(Request $request)
    {
        $data = DB::select("select * from tab_tbl_unit where kode='$request->kode'");
        if(!empty($data)){
            $data2 = 2;
            return response()->json($data2);
        }else{
        DB::table('tab_tbl_unit')->insert([
        'tembusan' => $request->tembusan ,
        'skdari' => $request->skdari ,
        'kode' => $request->kode ,
        'nama' => $request->nama ,
        'perusahaan' => $request->perusahaan ,
        'alamat' => $request->alamat ,
        'kota' => $request->kota ,
        'telp' => $request->telp ,
        'facs' => $request->facs ,
        'sanper' => $request->sanper ,
        'kepada' => $request->kepada ,
        'bantu' => $request->bantu 
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($kode)
    {
    $data_perusahaan = DB::select("select * from tab_tbl_prshn");
        $data = DB::select("select * from tab_tbl_unit where kode='$kode'");
        foreach($data as $dat)
        {
        $tembusan = $dat->tembusan;
        $skdari = $dat->skdari;
        $kode = $dat->kode;
        $nama = $dat->nama;
        $perusahaan = $dat->perusahaan;
        $alamat = $dat->alamat;
        $kota = $dat->kota;
        $telp = $dat->telp;
        $facs = $dat->facs;
        $sanper = $dat->sanper;
        $kepada = $dat->kepada;
        $bantu = $dat->bantu;
        }
        return view('modul-kontroler.master-pekerja.edit',compact(
            'data_perusahaan',
            'tembusan',
            'skdari',
            'kode',
            'kode',
            'nama',
            'perusahaan',
            'alamat',
            'kota',
            'telp',
            'facs',
            'sanper',
            'kepada',
            'bantu'
        ));
    }

    public function update(Request $request)
    {
        DB::table('tab_tbl_unit')->where('kode', $request->kode)
            ->update([
                'tembusan' => $request->tembusan ,
                'skdari' => $request->skdari ,
                'nama' => $request->nama ,
                'perusahaan' => $request->perusahaan ,
                'alamat' => $request->alamat ,
                'kota' => $request->kota ,
                'telp' => $request->telp ,
                'facs' => $request->facs ,
                'sanper' => $request->sanper ,
                'kepada' => $request->kepada ,
                'bantu' => $request->bantu 
            ]);

        return response()->json();
    }

    public function delete(Request $request)
    {
        DB::table('tab_tbl_unit')->where('kode', $request->kode)->delete();
        
        return response()->json();
    }
}
