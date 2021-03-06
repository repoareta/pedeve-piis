<?php

namespace App\Http\Controllers\SdmPayroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\HonorKomiteStoreRequest;
use App\Models\PayHonor;
use App\Models\MasterPegawai;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HonorKomiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunbulan = DB::select("SELECT 
        max(thnbln) AS bulan_buku 
        FROM timetrans 
        WHERE status = '1' 
        AND LENGTH(thnbln)='6'")[0];

        if(!empty($tahunbulan)) {
            $tahun = substr($tahunbulan->bulan_buku,0,-2); 
            $bulan = substr($tahunbulan->bulan_buku,4); 
        } else {
            $bulan ='00';
            $tahun ='0000';
        }

        $pegawai_list = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nopeg')
        ->get();
        
        return view('modul-sdm-payroll.honor-komite.index',compact(
            'pegawai_list',
            'tahun',
            'bulan'
        ));
    }

    public function indexJson(Request $request)
    {
        if ($request->nopek == "- Pilih -") {
            $request->nopek = null;
        }

        if ($request->bulan == "- Pilih -") {
            $request->bulan = null;
        }

        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
        foreach($data_tahunbulan as $data_bul)
        {
            $bulan_buku = $data_bul->bulan_buku;
        }

        $bulan = ltrim($request->bulan, '0');
        $tahun = $request->tahun;
        $nopek = $request->nopek;

        $data = DB::table(DB::raw('pay_honorarium as a'))
            ->select(DB::raw('a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid,a.pajak, b.nama as nama_nopek'))
            ->join(DB::raw('sdm_master_pegawai as b'), 'a.nopek', '=', 'b.nopeg');

        if ($tahun) {
            $data = $data->where('a.tahun', '=', $tahun);
        }

        if ($bulan) {
            $data = $data->where('a.bulan', '=', $bulan);
        }

        if ($nopek) {
            $data = $data->where('a.nopek', '=', $nopek);
        }

        return datatables()->of($data->get())
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
        ->addColumn('nilai', function ($data) {
             return currency_format($data->nilai,2,'.',',');
       })
        ->addColumn('pajak', function ($data) {
             return currency_format($data->pajak,2,'.',',');
       })

        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" tahun="'.$data->tahun.'" bulan="'.$data->bulan.'"  aard="'.$data->aard.'" nopek="'.$data->nopek.'" nama="'.$data->nama_nopek.'" data-nopek="" class="btn-radio" name="btn-radio-rekap"><span></span></label>';
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
        $data_pegawai = MasterPegawai::all();
        return view('modul-sdm-payroll.honor-komite.create', compact('data_pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HonorKomiteStoreRequest $request)
    {
        $nilai = (float) sanitize_nominal($request->nilai);
        $pajak = (35/65) * $nilai;
        $data_tahun = $request->tahun;
        $data_bulan = $request->bulan;
        $nopek = $request->nopek;

        PayHonor::insert([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'nopek' => $request->nopek,
            'aard' => 30,
            'jmlcc' => 0,
            'ccl' => 0,
            'nilai' => $nilai,
            'userid' => $request->userid,
            'pajak' => $pajak,
        ]);

        $data_pajak = DB::select("SELECT round(pajak,-2) as pajaknya from pay_honorarium where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$nopek'")[0];

        PayHonor::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->update([
            'pajak' => $data_pajak->pajaknya,
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.honor_komite.index');
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
    public function edit($bulan,$tahun,$nopek)
    {
        $data_list = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid,a.pajak, b.nama as nama_nopek from pay_honorarium a join sdm_master_pegawai b on a.nopek=b.nopeg where nopek='$nopek' and bulan='$bulan' and tahun='$tahun' order by a.tahun,a.bulan,a.nopek")[0];
        $data_pegawai = MasterPegawai::all();
        return view('modul-sdm-payroll.honor-komite.edit',compact('data_list','data_pegawai'));
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
        $data_tahun = $request->tahun;
        $data_bulan = $request->bulan;
        $nilai = (float) sanitize_nominal($request->nilai);
        $nopek = $request->nopek;
        $pajak = (35/65) * $nilai;

        PayHonor::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->update([
            'tahun' => $data_tahun,
            'bulan' => $data_bulan,
            'nopek' => $request->nopek,
            'jmlcc' => 0,
            'ccl' => 0,
            'nilai' => $nilai,
            'userid' => $request->userid,
            'pajak' => $pajak,
        ]);

        $data_pajak = DB::select("SELECT round(pajak,-2) as pajaknya from pay_honorarium where tahun='$data_tahun' and bulan='$data_bulan' and nopek='$nopek'");
        foreach($data_pajak as $data_p)
        {
            PayHonor::where('tahun', $request->tahun)
            ->where('bulan',$request->bulan)
            ->where('nopek',$request->nopek)
            ->update([
                'pajak' => $data_p->pajaknya,
            ]);
        }

        Alert::success('Berhasil', 'Data Berhasil Diubah')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.honor_komite.index');
    }
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayHonor::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->where('aard',$request->aard)
        ->delete();
        return response()->json();
    }
}
