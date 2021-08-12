<?php

namespace App\Http\Controllers\Kontroler;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\StoreJK;
use Illuminate\Http\Request;
use App\Http\Requests\KasBankKontrolerStore;
use App\Http\Requests\KasBankKontrolerUpdate;
use Alert;
use App\Models\Kasdoc;
use DB;

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
                    <label class="radio radio-outline radio-outline-2x radio-primary">
                        <input type="radio" value="'.$data->kodestore.'" class="btn-radio" name="btn-radio">
                            <span></span>
                    </label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        $data_sanper = Account::select('kodeacct', 'descacct')
                                ->where('kodeacct', 'not like', '%X%')
                                ->orderBy('kodeacct')
                                ->get();

        return view('modul-kontroler.tabel.kas-bank-kontroler.create',compact('data_sanper'));
    }
    public function store(KasBankKontrolerStore $request)
    {
        StoreJK::insert([
            'jeniskartu' => $request->jeniskartu,
            'kodestore' => $request->kodestore,
            'account' => $request->kodeacct,
            'ci' => $request->ci,
            'namabank' => $request->namabank,
            'norekening' => $request->norekening,
            'lokasi' => $request->lokasi,
            'jenisbiaya' => '000',
            'bagian' => 'C3010' 
        ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.kas_bank_kontroler.index');
    }

    public function edit($kode)
    {
        $data_store = StoreJK::where('kodestore', $kode)->first();
        $data_sanper = Account::select('kodeacct', 'descacct')
                                ->where('kodeacct', 'not like', '%X%')
                                ->orderBy('kodeacct')
                                ->get();
                                
        return view('modul-kontroler.tabel.kas-bank-kontroler.edit',compact(
                                                        'data_sanper',
                                                        'data_store'
                                                        ));
    }

    public function update(KasBankKontrolerUpdate $request)
    {
        Storejk::where('kodestore',$request->kodestore)
        ->update([
            'jeniskartu' => $request->jeniskartu,
            'account' => $request->kodeacct,
            'ci' => $request->ci,
            'namabank' => $request->namabank,
            'norekening' => $request->norekening,
            'lokasi' => $request->lokasi
        ]);
        
        Alert::success('Berhasil', 'Data Berhasil Diupdate')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_kontroler.tabel.kas_bank_kontroler.index');
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
