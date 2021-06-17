<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load modedl
use App\Models\DftMenu;

// load plugin
use DB;

class TabelMenuController extends Controller
{
    public function index()
    {
        return view('tabel_menu.index');
    }

    public function searchIndex(Request $request)
    {
        $data = DftMenu::orderBy('userap', 'asc')->whereNotIn('userap', ['INV','TAB'])->get();
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
            }else{
                $userap = 'CUSTOMER MANAGEMENT';
            }
            return $userap;
       })
        ->addColumn('radio', function ($data) {
            $radio = '<center><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" kode="'.$data->menuid.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function create()
    {
        return view('tabel_menu.create');
    }
    
    public function store(Request $request)
    {
        $data_cek = DB::select("select * from dftmenu where menuid='$request->menuid'");
        if(!empty($data_cek)){
            $data = $request->menuid;
            return response()->json($data);
        }else{
            $menuid = $request->menuid;
            $menunm = $request->menunm;
            $userap = $request->userap;
            DftMenu::insert([
                'menuid' => $menuid,
                'menunm' => $userap.' - '.$menunm,
                'userap' => $userap
            ]);
            $data = 1;
            return response()->json($data);
        }
    }

    public function edit($no)
    {
        $data_user = DB::select("select * from DftMenu where menuid='$no'");
        foreach($data_user as $data)
        {
            $menuid = $data->menuid;
            $menunm  = $data->menunm; 
            $userap = $data->userap;
        }
        return view('tabel_menu.edit',compact('menuid','menunm','userap'));
    }

    public function update(Request $request)
    {
        $menuid = $request->menuid;
        $menunm = $request->menunm;
        $userap = $request->userap;
        DftMenu::where('menuid',$menuid)
        ->update([
            'menunm' => $menunm,
            'userap' => $userap 
        ]);
        return response()->json();
    }

    public function delete(Request $request)
    {
        DftMenu::where('menuid',$request->kode)->delete();
        return response()->json();
    }
}
