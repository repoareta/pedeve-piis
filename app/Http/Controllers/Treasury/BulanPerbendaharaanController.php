<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\TimeTrans;
use DB;
use Illuminate\Http\Request;

class BulanPerbendaharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_akses = DB::table('usermenu')->where('userid', auth()->user()->userid)->where('menuid',507)->first();

        return view('modul-treasury.bulan-perbendaharaan.index', compact(
            'data_akses',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        $data = TimeTrans::orderBy('thnbln', 'desc')->get();
        return datatables()->of($data)
            ->addColumn('thnbln', function ($data) {
                return $data->thnbln;
            })
            ->addColumn('nama_status', function ($data) {
                if ($data->status == "1") {
                    $nama_status = "OPENING";
                } elseif ($data->status == "2") {
                    $nama_status = "STOPING";
                } else {
                    $nama_status = "CLOSING";
                }
                return $nama_status;
            })
            ->addColumn('data_buka', function ($data) {
                if ($data->opendate <> "") {
                    $tgl = date_create($data->opendate);
                    $data_buka = date_format($tgl, 'd/m/Y');
                } else {
                    $data_buka = "";
                }
                return $data_buka;
            })
            ->addColumn('data_stop', function ($data) {
                if ($data->stopdate <> "") {
                    $tgl = date_create($data->stopdate);
                    $data_stop = date_format($tgl, 'd/m/Y');
                } else {
                    $data_stop = "";
                }
                return $data_stop;
            })
            ->addColumn('data_tutup', function ($data) {
                if ($data->closedate <> "") {
                    $tgl = date_create($data->closedate);
                    $data_tutup = date_format($tgl, 'd/m/Y');
                } else {
                    $data_tutup = "";
                }
                return $data_tutup;
            })
            ->addColumn('description', function ($data) {
                return $data->description;
            })
            ->addColumn('suplesi', function ($data) {
                return $data->suplesi;
            })
            ->addColumn('radio', function ($data) {
                $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="' . $data->thnbln . '" class="btn-radio" name="btn-radio"><span></span></label></center>';
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
        return view('modul-treasury.bulan-perbendaharaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;
        $thnbln = $tahun . '' . $bulan;
        $suplesi = $request->suplesi;
        $keterangan = $request->keterangan;
        $status = $request->status;
        $opendate = $request->tanggal;
        $stopdate = $request->tanggal2;
        $closedate = $request->tanggal3;

        if ($opendate <> "") {
            $opendate1 = $request->tanggal;
        } else {
            $opendate1 = null;
        }
        if ($stopdate <> "") {
            $stopdate1 = $request->tanggal2;
        } else {
            $stopdate1 = null;
        }
        if ($closedate <> "") {
            $closedate1 = $request->tanggal3;
        } else {
            $closedate1 = null;
        }
        $data_objRs = DB::select("select * from timetrans where thnbln='$thnbln'");
        if (!empty($data_objRs)) {
            $data = 2;
            return response()->json($data);
        } else {
            $userid = auth()->user()->userid;
            Timetrans::insert([
                'thnbln' => $thnbln,
                'status' => $status,
                'opendate' => $opendate1,
                'stopdate' => $stopdate1,
                'closedate' => $closedate1,
                'description' => $keterangan,
                'userid' => $userid,
                'password' => $userid,
                'suplesi' => $suplesi
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TimeTrans::where('thnbln', '=', $id)->first();

        $thnbln = $data->thnbln;
        $status  = $data->status;

        if ($data->opendate <> "") {
            $tgl = date_create($data->opendate);
            $tanggal = date_format($tgl, 'd-m-Y');
        } else {
            $tanggal = "";
        }

        if ($data->stopdate <> "") {
            $tgl2 = date_create($data->stopdate);
            $tanggal2 = date_format($tgl2, 'd-m-Y');
        } else {
            $tanggal2 = "";
        }

        if ($data->closedate <> "") {
            $tgl3 = date_create($data->closedate);
            $tanggal3 = date_format($tgl3, 'd-m-Y');
        } else {
            $tanggal3 =  "";
        }

        $keterangan  = $data->description;
        $suplesi =  $data->suplesi;

        return view('modul-treasury.bulan-perbendaharaan.edit', compact(
            'thnbln',
            'status',
            'tanggal',
            'tanggal2',
            'tanggal3',
            'keterangan',
            'suplesi',
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
        $tahun = $request->tahun;
		$bulan = $request->bulan;
		$thnbln = $tahun.''.$bulan;
		$suplesi = $request->suplesi;
		$keterangan = $request->keterangan;
		$status = $request->status;
		$opendate = $request->tanggal;
		$stopdate = $request->tanggal2;
        $closedate = $request->tanggal3;
        $userid = auth()->user()->userid;

        if ($opendate <> "") {
            $opendate1 = $request->tanggal;
        } else {
            $opendate1 = null;
        }
        if ($stopdate <> "") {
            $stopdate1 = $request->tanggal2;
        } else {
            $stopdate1 = null;
        }
        if ($closedate <> "") {
            $closedate1 = $request->tanggal3;
        } else {
            $closedate1 = null;
        }

        Timetrans::where('thnbln',$thnbln)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Timetrans::where('thnbln', $request->kode)->delete();
        return response()->json();
    }
}
