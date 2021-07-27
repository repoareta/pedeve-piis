<?php

namespace App\Http\Controllers\SdmPayroll\Potongan;

use App\Http\Controllers\Controller;
use App\Models\PayPotongan;
use App\Models\Pekerja;
use DB;
use Illuminate\Http\Request;

class PotonganManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("select max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            if(!empty($data_tahunbulan)) {
                foreach ($data_tahunbulan as $data_bul) {
                    $tahun = substr($data_bul->bulan_buku,0,-2); 
                    $bulan = substr($data_bul->bulan_buku,4); 
                }
            }else{
                $bulan ='00';
                $tahun ='0000';
            }
        $data_pegawai = DB::select("select nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");	
        return view('potongan_manual.index',compact('data_pegawai','tahun','bulan'));
    }

    public function indexJson(Request $request)
    {
            $data_tahunbulan = DB::select("select max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            foreach($data_tahunbulan as $data_bul)
            {
                $bulan_buku = $data_bul->bulan_buku;
            }
            $tahuns = substr($bulan_buku,0,-2);
        
            $bulan = ltrim($request->bulan, '0');
            $tahun = $request->tahun;
            $nopek = $request->nopek;
            if($nopek == null){
                if($bulan == null and $tahun == null){
                $data = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode  where a.tahun ='$tahuns' order by a.tahun, a.bulan asc");
                }elseif($bulan == null and $tahun <> null){
                $data = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode  where a.tahun ='$tahun' order by a.tahun, a.bulan asc");
                }else{
                $data = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode where a.bulan='$bulan' and a.tahun='$tahun' order by a.nopek asc");
                }
            }else{
                if($bulan == null and $tahun == null and $nopek <> ""){
                $data = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode where a.nopek='$nopek' order by a.tahun, a.bulan desc");
                }else{
                $data = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode  where a.nopek='$nopek' and a.bulan='$bulan' and a.tahun='$tahun'" ); 			
                }
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
            ->addColumn('tahun', function ($data) {
                return $data->tahun;
           })
            ->addColumn('nopek', function ($data) {
                return $data->nopek.' -- '.$data->nama_nopek;
           })
            ->addColumn('aard', function ($data) {
                return $data->aard.' -- '.$data->nama_aard;
           })
            ->addColumn('ccl', function ($data) {
                 return number_format($data->ccl,0,'.',',');
           })
            ->addColumn('jmlcc', function ($data) {
                 return number_format($data->jmlcc,0,'.',',');
           })
            ->addColumn('nilai', function ($data) {
                 return number_format($data->nilai,2,'.',',');
           })
    
            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" tahun="'.$data->tahun.'" bulan="'.$data->bulan.'"  aard="'.$data->aard.'" nopek="'.$data->nopek.'" nama="'.$data->nama_nopek.'" data-nopek="" class="btn-radio" name="btn-radio-rekap"><span></span></label>'; 
                return $radio;
            })
            ->rawColumns(['action','radio'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data_pegawai = Pekerja::whereNotIn('status',['P'])->get();
        $pay_aard = DB::select("select kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard where kode in ('18','28','19','44') order by kode");
        return view('potongan_manual.create', compact('data_pegawai','pay_aard'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_cek = DB::select("select * from pay_potongan   where nopek='$request->nopek' and aard='$request->aard' and bulan='$request->bulan' and tahun='$request->tahun'" ); 			
        if(!empty($data_cek)){
            $data=0;
            return response()->json($data);
        }else {
        $data_tahun = $request->tahun;
        $data_bulan = $request->bulan;
        PayPotongan::insert([
            'tahun' => $data_tahun,
            'bulan' => $data_bulan,
            'nopek' => $request->nopek,
            'aard' => $request->aard,
            'jmlcc' => $request->jmlcc,
            'ccl' => $request->ccl,
            'nilai' => str_replace(',', '.', $request->nilai),
            'userid' => $request->userid,            
            ]);
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
        $data_list = DB::select("select a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_potongan a join sdm_master_pegawai b on a.nopek=b.nopeg join pay_tbl_aard c on a.aard=c.kode  where a.nopek='$nopek' and a.aard='$aard' and a.bulan='$bulan' and a.tahun='$tahun'" ); 			
        return view('potongan_manual.edit',compact('data_list'));
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
            ->where('aard',$request->aard)
            ->update([
                'jmlcc' => $request->jmlcc,
                'ccl' => $request->ccl,
                'nilai' => str_replace(',', '.', $request->nilai),
                'userid' => $request->userid,
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
        ->where('aard',$request->aard)
        ->delete();
        return response()->json();
    }
}
