<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\BulanKontroller;
use Alert;
use DB;
use Carbon\Carbon;
use App\Http\Requests\BulanKontrolerStore;
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
        ->addColumn('radio', function ($data) {
            $radio = '
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" value="'.$data->thnbln.'" class="btn-radio" name="btn-radio">
                            <span></span>
                    </label>';
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    public function create()
    {
        return view('modul-kontroler.tabel.bulan-kontroler.create');
    }

    public function store(BulanKontrolerStore $request)
    {
        $thnbln = $request->tahun.''.$request->bulan;
        
        if(BulanKontroller::where('thnbln', $thnbln)->first()){
            Alert::error('Error', 'Tahun bulan sudah ada')->persistent(true)->autoClose(3000);
            return redirect()->back();
        }

        BulanKontroller::insert([
            'thnbln' => $thnbln,
            'status' => $request->status ,
            'opendate' => $request->opendate,
            'stopdate' => $request->stopdate,
            'closedate' => $request->closedate,
            'description' => $request->keterangan,
            'userid' => auth()->user()->userid,
            'password' => auth()->user()->userpw,
            'suplesi' => $request->suplesi
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.bulan_kontroler.index');
    }

    public function edit($kode)
    {
        $data = BulanKontroller::where('thnbln', $kode)->first();
        $data->opendate = $data->opendate ? Carbon::parse($data->opendate)->format('d-m-Y') : '';
        $data->stopdate = $data->stopdate ? Carbon::parse($data->stopdate)->format('d-m-Y') : '';
        $data->closedate = $data->closedate ? Carbon::parse($data->closingdate)->format('d-m-Y') : '';
        
        return view('modul-kontroler.tabel.bulan-kontroler.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $thnbln = $request->tahun.''.$request->bulan;

        BulanKontroller::where('thnbln', $thnbln)
        ->update([
            'thnbln' => $thnbln,
            'status' => $request->status ,
            'opendate' => $request->opendate,
            'stopdate' => $request->stopdate,
            'closedate' => $request->closedate,
            'description' => $request->keterangan,
            'userid' => auth()->user()->userid,
            'password' => auth()->user()->userpw,
            'suplesi' => $request->suplesi
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.bulan_kontroler.index');
    }

    public function delete(Request $request)
    {
        Bulankontroller::where('thnbln', $request->kode)->delete();
        return response()->json();
    }
}
