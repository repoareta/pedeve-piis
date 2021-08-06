<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\BulanKontroller;
use Auth;
use DB;
use Illuminate\Http\Request;

class BulanKontrolerController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.bulan-kontroler.index');
    }

    public function indexJson()
    {
        $data = BulanKontroller::orderByDesc('thnbln');
        return datatables()->of($data)
        ->addColumn('nama_status', function ($data) {
            if($data->status == "1"){
                $nama_status = "OPENING";
            }elseif($data->status == "2"){
                $nama_status = "STOPING";
            } else {
                $nama_status = "CLOSING";
            }
            return $nama_status;
        })
        ->addColumn('data_buka', function ($data) {
            if($data->opendate <> ""){
                $tgl = date_create($data->opendate);
                $data_buka = date_format($tgl, 'd/m/Y');
            } else {
                $data_buka = "";
            }
            return $data_buka;
        })
        ->addColumn('data_stop', function ($data) {
            if($data->stopdate <> ""){
                $tgl = date_create($data->stopdate);
                $data_stop = date_format($tgl, 'd/m/Y');
            } else {
                $data_stop = "";
            }
            return $data_stop;
        })
        ->addColumn('data_tutup', function ($data) {
            if($data->closedate <> ""){
                $tgl = date_create($data->closedate);
                $data_tutup = date_format($tgl, 'd/m/Y');
            } else {
                $data_tutup = "";
            }
            return $data_tutup;
        })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->thnbln.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-kontroler.tabel.bulan-kontroler.create');
    }
    public function store(Request $request)
    {
        $tahun = $request->tahun;
		$bulan = $request->bulan;
		$thnbln = $tahun.''.$bulan;
		$suplesi = $request->suplesi;
		$keterangan = $request->keterangan;
		$status = $request->status;
		$opendate = $request->tanggal;
		$stopdate = $request->tanggal2;
		$closedate = $request->tanggal3;
		
		if($opendate <> ""){
		   $opendate1 = $request->tanggal;
        } else {
		   $opendate1 = null;
        }
		if($stopdate <> ""){
		   $stopdate1 = $request->tanggal2;
        } else {
		   $stopdate1 = null;
        }
		if($closedate <> ""){
		   $closedate1 = $request->tanggal3;
        } else {
		  $closedate1 = null;
        }
        $data_objRs = DB::select("SELECT * from bulankontroller where thnbln='$thnbln'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        } else {
            $userid = Auth::user()->userid;
            BulanKontroller::insert([
                'thnbln' => $thnbln,
                'status' => $status ,
                'opendate' => $opendate1 ,
                'stopdate' => $stopdate1 ,
                'closedate' => $closedate1 ,
                'description' => $keterangan ,
                'userid' => $userid,
                'password' => $userid,
                'suplesi' => $suplesi 
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($no)
    {
        $data_cash = DB::select("SELECT * from bulankontroller where thnbln='$no'");
        foreach($data_cash as $data)
        {
                    $thnbln =     $data->thnbln;
                    $status  =     $data->status;
                    if($data->opendate<>""){
                        $tgl = date_create($data->opendate);
                        $tanggal  =   date_format($tgl, 'Y-m-d');
                    } else {
                        $tanggal  =   "";
                    }
                    if($data->stopdate<>""){
                        $tgl2 = date_create($data->stopdate);
                        $tanggal2 =   date_format($tgl2, 'Y-m-d');
                    } else {
                        $tanggal2 =   "";
                    }
                    if($data->closedate<>""){
                        $tgl3 = date_create($data->closedate);
                        $tanggal3 =  date_format($tgl3, 'Y-m-d');
                    } else {
                        $tanggal3 =  "";
                    }
                    $keterangan  =$data->description;
                    $suplesi =    $data->suplesi; 
        }
        return view('modul-kontroler.tabel.bulan-kontroler.edit',compact('thnbln','status','tanggal','tanggal2','tanggal3','keterangan','suplesi'));
    }
    public function update(Request $request)
    {
        $tahun = $request->tahun;
		$bulan = $request->bulan;
		$thnbln = $tahun.''.$bulan;
		$suplesi = $request->suplesi;
		$keterangan = $request->keterangan;
		$status = $request->status;
		$opendate = $request->tanggal;
		$stopdate = $request->tanggal2;
        $closedate = $request->tanggal3;
        $userid = Auth::user()->userid;
		
		if($opendate <> ""){
		   $opendate1 = $request->tanggal;
        } else {
		   $opendate1 = null;
        }
		if($stopdate <> ""){
		   $stopdate1 = $request->tanggal2;
        } else {
		   $stopdate1 = null;
        }
		if($closedate <> ""){
		   $closedate1 = $request->tanggal3;
        } else {
		  $closedate1 = null;
        }
        Bulankontroller::where('thnbln',$thnbln)
        ->update([
            'status' => $status ,
            'opendate' => $opendate1 ,
            'stopdate' => $stopdate1 ,
            'closedate' => $closedate1 ,
            'description' => $keterangan ,
            'userid' => $userid,
            'password' => $userid,
            'suplesi' => $suplesi 
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        Bulankontroller::where('thnbln',$request->kode)->delete();
        return response()->json();
    } 
}
