<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\StoreJK;
use Illuminate\Http\Request;
use Auth;
use Alert;
use App\Models\Kasdoc;
use DB;
use DomPDF;

class KasBankKontrolerController extends Controller
{
    public function index()
    {
        return view('modul-kontroler.tabel.kas-bank-kontroler.index');
    }

    public function indexJson()
    {
        $data = StoreJk::orderByDesc('jeniskartu')
                        ->orderByDesc('kodestore');
        return datatables()->of($data)
        ->addColumn('radio', function ($data) {
            $radio = '
                    <center>
                        <label class="radio radio-outline radio-outline-2x radio-primary">
                            <input type="radio" kode="'.$data->kodestore.'" class="btn-radio" name="btn-radio">
                                <span></span>
                        </label>
                    </center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct");
        return view('modul-kontroler.tabel.kas-bank-kontroler.create',compact('data_sanper'));
    }
    public function store(Request $request)
    {
        $data_objRs = DB::select("SELECT * from storejk where kodestore='$request->kode'");
        if(!empty($data_objRs)){
            $data = 2;
            return response()->json($data);
        } else {
            StoreJK::insert([
                'jeniskartu' => $request->jk,
                'kodestore' => $request->kode,
                'account' => $request->sanper,
                'ci' => $request->ci,
                'namabank' => $request->nama,
                'norekening' => $request->norek,
                'lokasi' => $request->lokasi,
                'jenisbiaya' => '000',
                'bagian' => 'C3010' 
            ]);
            $data = 1;
            return response()->json($data);
        }

    }

    public function edit($no)
    {
        $data_cash = DB::select("SELECT * from storejk where kodestore='$no'");
        foreach($data_cash as $data)
        {
            $kode = $data->kodestore;
            $nama = $data->namabank;
            $jk = $data->jeniskartu;
            $sanper = $data->account;
            $ci = $data->ci;
            $norek = $data->norekening;
            $lokasi = $data->lokasi;
        }
        $data_sanper = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%X%' order by kodeacct");
        return view('modul-kontroler.tabel.kas-bank-kontroler.edit',compact(
                                                        'data_sanper',
                                                        'kode',
                                                        'nama',
                                                        'jk',
                                                        'sanper',
                                                        'ci',
                                                        'norek',
                                                        'lokasi'
                                                                ));
    }
    public function update(Request $request)
    {
        Storejk::where('kodestore',$request->kode)
        ->update([
            'jeniskartu' => $request->jk,
            'account' => $request->sanper,
            'ci' => $request->ci,
            'namabank' => $request->nama,
            'norekening' => $request->norek,
            'lokasi' => $request->lokasi
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        $data_objrs1 = DB::select("SELECT account from storejk where kodestore='$request->kode'"); 
        foreach($data_objrs1 as $objrs1)
        {
            Account::where('kodeacct',$objrs1->account)->delete();
        }
        Storejk::where('kodestore',$request->kode)->delete();
        return response()->json();
    }
}
