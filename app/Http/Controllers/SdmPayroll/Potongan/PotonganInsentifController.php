<?php

namespace App\Http\Controllers\SdmPayroll\Potongan;

use App\Http\Controllers\Controller;
use App\Models\PayPotonganInsentif;
use App\Models\MasterPegawai;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PotonganInsentifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT max(thnbln) as bulan_buku from timetrans where status='1' and length(thnbln)='6'");
            if(!empty($data_tahunbulan)) {
                foreach ($data_tahunbulan as $data_bul) {
                    $tahun = substr($data_bul->bulan_buku,0,-2);
                    $bulan = substr($data_bul->bulan_buku,4);
                }
            } else {
                $bulan ='00';
                $tahun ='0000';
            }
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");
        return view('modul-sdm-payroll.potongan-insentif.index',compact('data_pegawai','tahun','bulan'));
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
            $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.tahun ='$tahuns'  order by a.tahun,a.bulan asc");
            }elseif($bulan == null and $tahun <> null){
            $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.tahun ='$tahun'  order by a.tahun,a.bulan asc");
            } else {
            $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.bulan='$bulan' and a.tahun='$tahun' order by a.nopek asc");
            }
        } else {
            if($bulan == null and $tahun == null){
            $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.nopek='$nopek' order by a.tahun,a.bulan desc");
            } else {
            $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.nopek='$nopek' and a.bulan='$bulan' and a.tahun='$tahun'" );
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
        ->addColumn('nopek', function ($data) {
            return $data->nopek.' -- '.$data->nama_nopek;
       })
        ->addColumn('nilai', function ($data) {
             return number_format($data->nilai,2,'.',',');
       })

        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" tahun="'.$data->tahun.'" bulan="'.$data->bulan.'"   nopek="'.$data->nopek.'" nama="'.$data->nama_nopek.'" data-nopek="" class="btn-radio" name="btn-radio-rekap"><span></span></label>';
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
        $data_pegawai = MasterPegawai::whereNotIn('status',['P'])->get();
        return view('modul-sdm-payroll.potongan-insentif.create',compact('data_pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prevData = DB::table('pay_potongan_insentif')
            ->where('nopek', $request->nopek)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($prevData) {
            Alert::info('Failed', 'Data Potongan Insentif Yang Diinput Sudah Ada.')->persistent(true)->autoClose(3000);
            return redirect()->route('modul_sdm_payroll.potongan_insentif.create')->withInput();
        }

        PayPotonganInsentif::insert([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'nopek' => $request->nopek,
            'nilai' => sanitize_nominal($request->nilai),
            'userid' => $request->userid,
        ]);

        Alert::success('Success', 'Data berhasil ditambahkan.')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.potongan_insentif.index');
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
        $data = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.nilai, a.userid,b.nama as nama_nopek, b.nopeg from pay_potongan_insentif a join sdm_master_pegawai b on a.nopek=b.nopeg where a.nopek='$nopek' and a.bulan='$bulan' and a.tahun='$tahun'")[0];

        return view('modul-sdm-payroll.potongan-insentif.edit', compact(
            'data'
        ));
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
        PayPotonganInsentif::where('tahun', $request->tahun)
            ->where('bulan',$request->bulan)
            ->where('nopek',$request->nopek)
            ->update([
                'nilai' => sanitize_nominal($request->nilai),
                'userid' => $request->userid,
            ]);

        Alert::success('Success', 'Data berhasil diubah.')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.potongan_insentif.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        PayPotonganInsentif::where('tahun', $request->tahun)
        ->where('bulan',$request->bulan)
        ->where('nopek',$request->nopek)
        ->delete();
        return response()->json();
    }
}
