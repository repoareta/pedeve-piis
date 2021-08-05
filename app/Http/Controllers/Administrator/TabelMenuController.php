<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

// load model
use App\Models\DftMenu;

// load plugin
use DB;
use Alert;

// load request
use Illuminate\Http\Request;
use App\Http\Requests\TabelMenuStore;
use App\Http\Requests\TabelMenuUpdate;

class TabelMenuController extends Controller
{
    public function index()
    {
        return view('modul-administrator.tabel-menu.index');
    }

    public function searchIndex()
    {
        $data = DftMenu::orderBy('userap', 'asc')->get();
        return datatables()->of($data)
        ->addColumn('menuid', function ($data) {
            return $data->menuid;
        })
        ->addColumn('menunm', function ($data) {
            return $data->menunm;
        })
        ->addColumn('userap', function ($data) {
            if($data->userap == 'UMU'){
                $userap = 'UMUM';
            }elseif($data->userap == 'SDM'){
                $userap = 'SDM & Payroll';
            }elseif($data->userap == 'PBD'){
                $userap = 'PERBENDAHARAAN';
            }elseif($data->userap == 'AKT'){
                $userap = 'KONTROLER';
            } else {
                $userap = 'CUSTOMER MANAGEMENT';
            }
            return $userap;
        })
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->menuid.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('modul-administrator.tabel-menu.create');
    }
    
    public function store(TabelMenuStore $request)
    {
        $dft_menu1 = DftMenu::where('menuid', $request->menuid)->first();
        if($dft_menu1){
            Alert::error('Gagal', 'Data Gagal Disimpan')->persistent(true)->autoClose(3000);
            return redirect()->back();
        } else {
            $dft_menu2 = new DftMenu();
            $dft_menu2->menuid = $request->menuid;
            $dft_menu2->menunm = $request->userap .' - '. $request->menunm;
            $dft_menu2->userap = $request->userap;
            $dft_menu2->save();
            
            Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
            return redirect()->route('modul_administrator.tabel_menu.index');
        }
    }

    public function edit($id)
    {
        $dft_menu = DftMenu::where('menuid', $id)->first();
        // dd($dft_menu);
        if(strlen($dft_menu->menuid) == 1)
        {
            $dft_menu->menunm = substr($dft_menu->menunm, 4);
        }
        if(strlen($dft_menu->menuid) == 2)
        {
            $dft_menu->menunm = substr($dft_menu->menunm, 5);
        }
        if(strlen($dft_menu->menuid) == 3)
        {
            $dft_menu->menunm = substr($dft_menu->menunm, 6);
        }
        if(strlen($dft_menu->menuid) == 4)
        {
            $dft_menu->menunm = substr($dft_menu->menunm, 7);
        }
        return view('modul-administrator.tabel-menu.edit',compact('dft_menu'));
    }

    public function update(TabelMenuUpdate $request, $id)
    {
        $dft_menu = DftMenu::where('menuid', $id)->first();

        $dft_menu->userap = $request->userap;
        $dft_menu->menunm = $dft_menu->userap .' - '. $request->menunm;
        DB::table('dftmenu')
            ->where('menuid', $id)
            ->limit(1)
            ->update([
                'menunm' => $dft_menu->menunm,
                'userap' => $dft_menu->userap
            ]);
        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_administrator.tabel_menu.index');
    }

    public function delete(Request $request)
    {
        DftMenu::where('menuid',$request->kode)->delete();
        return response()->json();
    }
}
