<?php

namespace App\Http\Controllers\SdmPayroll\Potongan;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\KoreksiGaji;
use App\Models\PayAard;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class PotonganKoreksiGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT 
            max(thnbln) AS bulan_buku 
            FROM timetrans 
            WHERE status ='1' 
            AND length(thnbln)='6'")[0];

        if(!empty($data_tahunbulan)) {
            $tahun = substr($data_tahunbulan->bulan_buku,0,-2); 
            $bulan = substr($data_tahunbulan->bulan_buku,4); 
        } else {
            $bulan ='00';
            $tahun ='0000';
        }

        $pegawai_list = DB::select("SELECT 
            nopeg,
            nama, 
            status,
            nama 
            FROM sdm_master_pegawai 
            WHERE status <> 'P' 
            ORDER BY nopeg
        ");

        return view('modul-sdm-payroll.potongan-koreksi-gaji.index',compact(
            'pegawai_list',
            'tahun',
            'bulan'
        ));
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
        if($nopek == null){
            if($bulan == null and $tahun == null){    
                $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode where a.tahun ='$tahuns' order by a.tahun desc,a.bulan desc");
            }elseif($bulan == null and $tahun <> null){
                $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode where a.tahun ='$tahun' order by a.tahun desc,a.bulan desc");
            }else{
               $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode where a.bulan='$bulan' and a.tahun='$tahun' order by a.tahun desc,a.bulan desc");
            }
        }else{
            if($bulan == null and $tahun == null){
               $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode where a.nopek='$nopek' order by a.tahun desc,a.bulan desc");	
            }else{
               $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode where a.bulan='$bulan' and a.tahun='$tahun' and a.nopek='$nopek' order by a.tahun desc,a.bulan desc");
            }
        }

        return datatables()->of($data)
        ->addColumn('tahun', function ($data) {
            return $data->tahun;
        })
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
        ->addColumn('aard', function ($data) {
            return $data->aard.' -- '.$data->nama_aard;
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
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");
        $pay_aard = PayAard::where('jenis', 10)->get();
        return view('modul-sdm-payroll.potongan-koreksi-gaji.create', compact('pay_aard','data_pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_koreksigaji   where nopek='$request->nopek' and aard='$request->aard' and bulan='$request->bulan' and tahun='$request->tahun'" ); 			
        if(!empty($data_cek)){
            $data=0;
            return response()->json($data);
        }else {
        $data_tahun = $request->tahun;
        $data_bulan = $request->bulan;
            KoreksiGaji::insert([
            'tahun' => $data_tahun,
            'bulan' => $data_bulan,
            'nopek' => $request->nopek,
            'aard' => $request->aard,
            'jmlcc' => 0,
            'ccl' => 0,
            'nilai' => str_replace(',', '.', $request->nilai),
            'userid' => $request->userid,
            
            // Save Panjar Header
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($bulan,$tahun,$aard,$nopek)
    {
        $data_list = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode  where a.nopek='$nopek' and a.aard='$aard' and a.bulan='$bulan' and a.tahun='$tahun'");
        return view('modul-sdm-payroll.potongan-koreksi-gaji.edit',compact('data_list'));
    }

    public function update(Request $request)
    {
            KoreksiGaji::where('tahun', $request->tahun)
            ->where('bulan',$request->bulan)
            ->where('nopek',$request->nopek)
            ->where('aard',$request->aard)
            ->update([
                'jmlcc' => 0,
                'ccl' => 0,
                'nilai' => str_replace(',', '.', $request->nilai),
                'userid' => $request->userid,
            ]);
            return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        KoreksiGaji::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->where('aard',$request->aard)
        ->delete();
        return response()->json();
    }
    public function ctkkoreksi()
    {
        return view('modul-sdm-payroll.potongan-koreksi-gaji.rekapkoreksi');
    }
    public function koreksiExport(Request $request)
    {
        $data_list = DB::select("SELECT a.aard,a.nopek,a.nilai,b.nama from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard in ('32','34') and a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='$request->prosesupah' order by b.nama asc");
        if(!empty($data_list)){
            $pdf = DomPDF::loadview('modul-sdm-payroll.potongan-koreksi-gaji.export_koreksigaji',compact('request','data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        }else{
            Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('potongan_koreksi_gaji.ctkkoreksi');
        }
    }
}
