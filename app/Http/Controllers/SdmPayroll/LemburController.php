<?php

namespace App\Http\Controllers\SdmPayroll;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\MasterPegawai;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class LemburController extends Controller
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
        WHERE status ='1' 
        AND length(thnbln)='6'")[0];
        
        if(!empty($tahunbulan)) {
            $tahun = substr($tahunbulan->bulan_buku,0,-2); 
            $bulan = substr($tahunbulan->bulan_buku,4);
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
        
        return view('modul-sdm-payroll.lembur.index',compact(
        'pegawai_list',
        'tahun',
        'bulan'
        ));
    }


    public function indexJson(Request $request)
    {
        $data = DB::select("SELECT 
            a.bulan,
            a.tahun,
            a.tanggal,
            a.nopek,
            a.libur,
            a.mulai,
            a.sampai,
            a.makanpg,
            a.makansg,
            a.makanml,
            a.transport,
            a.lembur,
            (a.makanpg + a.makansg + a.makanml + a.transport + a.lembur) AS total, 
            b.nama AS nama_nopek 
            FROM pay_lembur a 
            JOIN sdm_master_pegawai b 
            ON a.nopek = b.nopeg
            ORDER BY a.tanggal ASC");

        return datatables()->of($data)
        ->filter(function ($query) use ($request) {
            // if (request('nopek')) {
            //     $query->where('a.nopek', '=', request('nopek'));
            // }
            // if (request('bulan')) {
            //     $query->where('bulan', ltrim(request('bulan'), '0'));
            // }
            // if (request('tahun')) {
            //     $query->where('a.tahun', request('tahun'));
            // }
        })
        ->addColumn('nopek', function ($data) {
            return $data->nopek.' -- '.$data->nama_nopek;
        })
        ->addColumn('tanggal', function ($data) {
            $tanggal = date_format(date_create($data->tanggal), 'd F Y');
            
            return $tanggal;
        })
        ->addColumn('makanpg', function ($data) {
            return currency_format($data->makanpg);
        })
        ->addColumn('makansg', function ($data) {
            return currency_format($data->makansg);
        })
        ->addColumn('makanml', function ($data) {
            return currency_format($data->makanml);
        })
        ->addColumn('transport', function ($data) {
            return currency_format($data->transport);
        })
        ->addColumn('lembur', function ($data) {
            return currency_format($data->lembur);
        })
        ->addColumn('total', function ($data) {
            return currency_format($data->total);
        })

        ->addColumn('radio', function ($data) {
            $tanggal = date_format(date_create($data->tanggal), 'd-m-Y');
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" data-tanggal="'.$tanggal.'"  data-nopek="'.$data->nopek.'" class="btn-radio" name="btn-radio-rekap"><span></span></label>';
            
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
        $data_pegawai = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nopeg')
        ->get();	
        $data_potongan = DB::select("SELECT kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard where kode in ('18','28','19','44') order by kode");	
        return view('lembur.create',compact('data_pegawai','data_potongan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_cek = DB::select("SELECT * from pay_lembur where to_char(tanggal, 'dd/mm/YYYY') = '$request->tanggal' and nopek='$request->nopek'");
        if(!empty($data_cek)){
            $data=0;
            return response()->json($data);

        }else {
                DB::table('pay_lembur')->insert([
                    'tanggal' => $request->tanggal,
                    'nopek' => $request->nopek, 
                    'makanpg' => str_replace(',', '.', $request->makanpg), 
                    'makansg' => str_replace(',', '.', $request->makansg), 
                    'makanml' => str_replace(',', '.', $request->makanml), 
                    'transport' => str_replace(',', '.', $request->transport),
                    'lembur' => str_replace(',', '.', $request->lembur), 
                    'userid' => $request->userid,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    ]);
                    $data = 1;
                    return response()->json($data);
            # code...
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tanggal, $nopek)
    {
        $data_list = DB::select("SELECT bulan,tahun,tanggal,nopek,makanpg, makansg, makanml, transport,lembur, userid from pay_lembur where  to_char(tanggal, 'dd-mm-YYYY')= '$tanggal' and nopek = '$nopek'");
        $data_pegawai = MasterPegawai::where('status', '<>', 'P')
        ->orderBy('nopeg')
        ->get();	
        $data_potongan = DB::select("SELECT kode, nama, jenis, kenapajak, lappajak from pay_tbl_aard where kode in ('18','28','19','44') order by kode");	
        return view('lembur.edit',compact('data_list','data_pegawai','data_potongan'));
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
        $mapg = str_replace(',', '.', $request->makanpg);
        $masi = str_replace(',', '.', $request->makansg);
        $maml = str_replace(',', '.', $request->makanml);
        $trans = str_replace(',', '.', $request->transport);
        $lem = str_replace(',', '.', $request->lembur);
        DB::update("update pay_lembur set makanpg='$mapg', makansg='$masi', makanml='$maml', transport='$trans',lembur='$lem', userid='$request->userid',bulan='$request->bulan',tahun='$request->tahun' where to_char(tanggal, 'dd/mm/YYYY') = '$request->tanggal' and nopek='$request->nopek'");
       
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
        DB::delete("delete from pay_lembur where to_char(tanggal, 'dd-mm-YYYY') = '$request->tanggal' and nopek='$request->nopek'");
        return response()->json();

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function rekapLembur()
    {
        return view('modul-sdm-payroll.lembur.rekap-lembur');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function rekapLemburExport(Request $request)
    {
        $data_list = DB::select("SELECT a.*, b.* from pay_lembur a join sdm_master_pegawai b on a.nopek=b.nopeg where a.tahun='$request->tahun' and a.bulan='$request->bulan'");
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('lembur.rekap-lembur-pdf', compact('request', 'data_list'))->setPaper('a4', 'landscape');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::error('Tidak Ada Data Yang Dicari', 'Failed')->persistent(true);
            return redirect()->route('lembur.rekap_lembur');
        }
    }
}
