<?php

namespace App\Http\Controllers\SdmPayroll;

use App\Http\Controllers\Controller;
use App\Models\PayMtrPkpp;
use DB;
use Illuminate\Http\Request;

class PinjamanPekerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pinjaman_pekerja.index');
    }

    public function searchIndex(Request $request)
    {
        $data = DB::select("select a.id_pinjaman,a.nopek,a.jml_pinjaman,a.tenor,a.mulai,a.sampai,a.angsuran,a.cair,a.lunas,a.no_kontrak,b.nama as namapegawai,(select c.curramount from pay_master_hutang c where c.nopek=a.nopek and c.aard='20' and c.tahun||c.bulan = (select trim(max(tahun||bulan)) as bultah from pay_master_hutang where aard='20' and nopek=a.nopek)) as curramount from pay_mtrpkpp a join sdm_master_pegawai b on a.nopek=b.nopeg  where  a.lunas='N' order by a.id_pinjaman asc");
    
        return datatables()->of($data)
        ->addColumn('id_pinjaman', function ($data) {
            return $data->id_pinjaman;
        })
        ->addColumn('mulai', function ($data) {
            $tgl = date_create($data->mulai);
            return date_format($tgl, 'd F Y');
        })
        ->addColumn('sampai', function ($data) {
            $tgl = date_create($data->sampai);
            return date_format($tgl, 'd F Y');
        })
        ->addColumn('angsuran', function ($data) {
            return number_format($data->angsuran,2,'.',',');
        })
        ->addColumn('jml_pinjaman', function ($data) {
            return number_format($data->jml_pinjaman,2,'.',',');
        })
        ->addColumn('curramount', function ($data) {
            return number_format($data->curramount,2,'.',',');
        })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" id_pinjaman="'.$data->id_pinjaman.'" cair="'.$data->cair.'" class="btn-radio" name="id_pinjaman"><span></span></label>'; 
            return $radio;
        })
        ->addColumn('cair', function ($data) {
            if($data->cair == 'Y'){
                $cair = '<p align="center"><span style="font-size: 2em;" class="kt-font-success pointer-link" data-toggle="kt-tooltip" data-placement="top" title="Sudah Cair"><i class="fas fa-check-circle" ></i></span></p>'; 
            }else{
                $cair = '<p align="center"><span style="font-size: 2em;" class="kt-font-danger pointer-link" data-toggle="kt-tooltip" data-placement="top" title="Belum Cair"><i class="fas fa-ban" ></i></span></p>';
            }
            return $cair;
        })
        ->addColumn('lunas', function ($data) {
            if($data->lunas == 'Y'){
                $lunas = '<p align="center"><span style="font-size: 2em;" class="kt-font-success pointer-link" data-toggle="kt-tooltip" data-placement="top" title="Sudah Lunas"><i class="fas fa-check-circle" ></i></span></p>'; 
            }else{
                $lunas = '<p align="center"><span style="font-size: 2em;" class="kt-font-danger pointer-link" data-toggle="kt-tooltip" data-placement="top" title="Belum Lunas"><i class="fas fa-ban" ></i></span></p>';
            }
            return $lunas;
        })
        ->rawColumns(['radio','cair','lunas'])
        ->make(true);
    }

    public function create()
    {
        $data_pegawai = DB::select("select nopeg,nama,status,nama from sdm_master_pegawai where status<>'P' order by nopeg");
        return view('pinjaman_pekerja.create',compact('data_pegawai'));
    }

    public function IdpinjamanJson(Request $request)
    {
        $data = DB::select("select right(max(id_pinjaman),2) as idpinjaman from pay_mtrpkpp where nopek='$request->nopek'");
        if(!empty($data)){
            foreach($data as $data_p)
            {
                if($data_p->idpinjaman <> null){
                    $idpinjaman = sprintf("%02s", abs($data_p->idpinjaman + 1));
                    return response()->json($request->nopek.$idpinjaman);
                }else{
                    $idpinjaman = sprintf("%02s", 1);
                    return response()->json($request->nopek.$idpinjaman);
                }
            }
        }else{
            $idpinjaman = sprintf("%02s", 1);
            return response()->json($request->nopek.$idpinjaman);
        }
    }

    public function store(Request $request)
    {
            PayMtrPkpp::insert([
            'id_pinjaman' => $request->id_pinjaman,
            'nopek' => $request->nopek,
            'jml_pinjaman' => str_replace(',', '.', $request->pinjaman),
            'tenor' => $request->tenor,
            'mulai' => $request->mulai,
            'sampai' => $request->sampai,
            'angsuran' => str_replace(',', '.', $request->angsuran),
            'cair' => 'N',
            'lunas' => 'N',
            'no_kontrak' => $request->no_kontrak
            ]);
            return response()->json();
    }
    
    public function edit($no)
    {
        $data_list = DB::select("select a.*,b.nama as namapegawai from pay_mtrpkpp a join sdm_master_pegawai b on a.nopek=b.nopeg where a.id_pinjaman='$no'");
        $data_detail = DB::select("select id_pinjaman,nopek,tahun,bulan,pokok,bunga,realpokok,realbunga,(realpokok+realbunga) as jumlah2,(pokok+bunga) as jumlah,tahun||bulan as thnbln,nodoc from pay_skdpkpp where id_pinjaman='$no' order by tahun||bulan");
        $count = DB::select("select sum(pokok) jml,sum(bunga) bunga,sum(realpokok) realpokok,sum(realbunga) realbunga  from pay_skdpkpp where id_pinjaman='$no'");
        return view('pinjaman_pekerja.edit',compact('data_list','data_detail','count'));
    }

    public function update(Request $request)
    {
        PayMtrPkpp::where('id_pinjaman', $request->id_pinjaman)
        ->update([
            'jml_pinjaman' => str_replace(',', '.', $request->pinjaman),
            'tenor' => $request->tenor,
            'mulai' => $request->mulai,
            'sampai' => $request->sampai,
            'angsuran' => str_replace(',', '.', $request->angsuran),
            'no_kontrak' => $request->no_kontrak
        ]);
            return response()->json();
    }
    public function delete(Request $request)
    {
        PayMtrPkpp::where('id_pinjaman', $request->id_pinjaman)->delete();
        return response()->json();
    }
}
