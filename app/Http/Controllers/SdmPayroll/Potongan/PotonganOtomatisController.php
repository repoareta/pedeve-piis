<?php

namespace App\Http\Controllers\SdmPayroll\Potongan;

use App\Http\Controllers\Controller;
use App\Models\PayAard;
use App\Models\PayPotongan;
use App\Models\MasterPegawai;
use DB;
use Illuminate\Http\Request;

class PotonganOtomatisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");	
        $data_potongan = DB::select("SELECT kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard where kode in('18','28','19','44') order by kode");

        return view('modul-sdm-payroll.potongan-otomatis.index',compact('data_pegawai','data_potongan'));
    }

    public function indexJson(Request $request)
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        foreach($data_tahunbulan as $data_bul)
        {
            $bulan_buku = $data_bul->bulan_buku;
        }
        $tahuns = substr($bulan_buku,0,-2);
    
        $bulan = ltrim($request->bulan, '0');
        $tahun = $request->tahun;
        $nopek = $request->nopek;
        $aardpot = $request->aard;

        if($nopek ==  null and $aardpot == null and $bulan == null and $tahun == null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo  a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.tahun='$tahuns' order by a.ccl"); 	
        }elseif($nopek == null and $aardpot == null and $bulan == null and $tahun <> null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.tahun='$tahun'  order by a.ccl");
        }elseif($nopek == null and $aardpot == null and $bulan <> null and $tahun <> null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.tahun='$tahun' and a.bulan='$bulan' order by a.ccl");
        }elseif($nopek <> null and $aardpot == null and $bulan == null and $tahun == null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.nopek='$nopek' order by a.ccl");
        }elseif($nopek <> null and $aardpot <> null and $bulan == null and $tahun == null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.nopek='$nopek' and a.aardpot='$aardpot' order by a.ccl");
        }elseif($nopek <> null and $aardpot <> null and $bulan <> null and $tahun == null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.nopek='$nopek' and a.aardpot='$aardpot' and a.bulan='$bulan' order by a.ccl");
        }elseif($nopek <> null and $aardpot <> null and $bulan <> null and $tahun <> null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.nopek='$nopek' and a.aardpot='$aardpot' and a.bulan='$bulan' and a.tahun='$tahun' order by a.ccl");
        }elseif($nopek <> null and $aardpot <> null and $bulan == null and $tahun <> null){
                $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.nopek='$nopek' and a.aardpot='$aardpot' and a.tahun='$tahun' order by a.ccl");
        } else {
            $data = DB::select("SELECT a.tahun, a.bulan,a.nopek,a.aardpot,a.jmlcc, a.ccl, a.nilai,a.aardhut,a.awal,a.akhir,a.totalhut,a.userid, b.nama as nama_nopek, c.nama as nama_aardpot  from pay_potongan_revo  a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aardpot=c.kode where a.tahun='$tahuns' order by a.ccl"); 	
        }
        return datatables()->of($data)
        ->addColumn('bulan', function ($data) {
            $array_bln	 = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
              );
            $bulan= strtoupper($array_bln[$data->bulan]);
            return $bulan;
       })
        ->addColumn('nopek', function ($data) {
            return $data->nopek.' -- '.$data->nama_nopek;
       })
        ->addColumn('aardpot', function ($data) {
            return $data->aardpot.' -- '.$data->nama_aardpot;
       })
        ->addColumn('nilai', function ($data) {
             return currency_idr($data->nilai);
       })
        ->addColumn('akhir', function ($data) {
             return currency_idr($data->akhir);
       })
        ->addColumn('totalhut', function ($data) {
             return currency_idr($data->totalhut);
       })
        ->addColumn('jmlcc', function ($data) {
             return abs($data->jmlcc);
       })
        ->addColumn('ccl', function ($data) {
             return abs($data->ccl);
       })

        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" tahun="'.$data->tahun.'" bulan="'.$data->bulan.'" nopek="'.$data->nopek.'" aard="'.$data->aardpot.'" nama="'.$data->nama_nopek.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    public function create()
    {
        $data_pegawai = MasterPegawai::whereNotIn('status',['P'])->get();
        $pay_aard = PayAard::whereIn('kode',['18','28','19','44'])->get();
        return view('modul-sdm-payroll.potongan-otomatis.create', compact('data_pegawai','pay_aard'));
    }

    public function store(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_potongan_revo   where nopek='$request->nopek' and aardpot='$request->aard' and bulan='$request->bulan' and tahun='$request->tahun'" ); 			
        if(!empty($data_cek)){
            $data=0;
            return response()->json($data);
        }else {
        $tahunnext = $request->tahun;
        $bulannext = $request->bulan;
        $nopek = $request->nopek;
        $aard = $request->aard;
        $ccl = $request->ccl;
        $jmlcc = $request->jmlcc;
        $akhir = $request->ccl + ($request->jmlcc-1);
        if($request->nilai == 0){
            DB::delete("delete from pay_potongan where (tahun||bulan >= '$tahunnext||$bulannext') and nopek='$nopek' and aard='$aard'");
        } else {
            DB::delete("delete from pay_potongan where (tahun||bulan >= '$tahunnext||$bulannext') and nopek='$nopek' and aard='$aard'");
            for($col=$ccl;$col<=$akhir;$col++){
          
                PayPotongan::insert([
                    'tahun' => $tahunnext,
                    'bulan' => $bulannext,
                    'nopek' => $nopek,
                    'aard' => $aard,
                    'jmlcc' => $jmlcc,
                    'ccl' => $col,
                    'nilai' => str_replace(',', '.', $request->nilai),
                    'userid' => $request->userid,            
                    ]);
                $bulannext = $bulannext + 1;
                if($bulannext == 13){
                    $tahunnext = $tahunnext + 1;
                    $bulannext = 1;
                }
            }
        }
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bulan,$tahun,$aard,$nopek)
    {
            $data_list =DB::table('pay_potongan_revo as a')
                        ->join('sdm_master_pegawai as b', 'a.nopek', '=', 'b.nopeg')
                        ->join('pay_tbl_aard as c', 'a.aardpot', '=', 'c.kode')
                        ->where('tahun', $tahun)
                        ->where('bulan',$bulan)
                        ->where('nopek',$nopek)
                        ->where('aardpot',$aard)
                        ->select('a.*', 'b.nama as nama_pegawai','b.status','c.nama as nama_aard')
                        ->get();
        foreach($data_list as $data)
        {
            $data_aardhut = $data->aardhut;
        }
        $pay_hutang = DB::select("SELECT kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard where jenis='09' order by kode");
        return view('modul-sdm-payroll.potongan-otomatis.edit',compact('data_list','pay_hutang'));
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
        PayPotongan::where('tahun', $request->tahun)
            ->where('bulan',$request->bulan)
            ->where('nopek',$request->nopek)
            ->where('aardpot',$request->aard)
            ->update([
                'jmlcc' => $request->jmlcc,
                'ccl' => $request->ccl,
                'nilai' => str_replace(',', '.', $request->nilai),
                'akhir' => $request->akhir,
                'aardhut' => $request->aardhut,
                'totalhut' => $request->totalhut,
                'userid'    => $request->userid,
            ]);
            return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayPotongan::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->where('aardpot',$request->aard)
        ->delete();
        return response()->json();
    }
}
