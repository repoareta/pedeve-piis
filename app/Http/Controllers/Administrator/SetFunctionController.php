<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

// load Request
use Illuminate\Http\Request;
use App\Http\Requests\SetFunctionUpdate;

// load model
use App\Models\UserPdv;
use App\Models\UserMenu;

// load plugin
use DB;
use Alert;


class SetFunctionController extends Controller
{
    public function index()
    {
        return view('modul-administrator.set-function.index');
    }

    public function indexJson()
    {
        $data = UserPdv::orderBy('userid','asc')->get();
        return datatables()->of($data)
        ->addColumn('userlv', function ($data) {
            if($data->userlv == 0){
                return "ADMINISTRATOR";
            } else {
                return "USER";
            }
        })
        ->addColumn('userap', function ($data) {
            
            if (substr_count($data->userap, "A") > 0) {
                $userp1 = "[ KONTROLER ]";
            } else {
                $userp1="";
            }
            if (substr_count($data->userap, "G") > 0) {
                $userp2 = "[ CUSTOMER MANAGEMENT ]";
            } else {
                $userp2="";
            }
            if (substr_count($data->userap, "D") > 0) {
                $userp4 = "[ PERBENDAHARAAN ]";
            } else {
                $userp4="";
            }
            if (substr_count($data->userap, "E") > 0) {
                $userp5 = "[ UMUM ]";
            } else {
                $userp5="";
            }
            if (substr_count($data->userap, "F") > 0) {
                $userp6 = "[ SDM ]";
            } else {
                $userp6="";
            }
            return $userp1.' '.$userp2.' '.$userp4.' '.$userp5.' '.$userp6;
        })
        ->addColumn('radio', function ($data) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->userid.'" class="btn-radio" name="btn-radio"><span></span></label>'; 
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true); 
    }

    public function store(Request $request)
    {
        // 
    }

    public function edit($id)
    {
        $user_pdv = UserPdv::where('userid', $id)->first();

        $user_menus = DB::table('usermenu')
                    ->select('usermenu.* as usermenu', 'dftmenu.* as dftmenu')
                    ->join('dftmenu', 'usermenu.menuid', 'dftmenu.menuid')
                    ->where('usermenu.userid', $id)
                    ->orderBy('usermenu.menuid' ,'asc')
                    ->get();        
        
        return view('modul-administrator.set-function.edit',compact('user_menus','user_pdv'));
    }

    public function update(SetFunctionUpdate $request, $id)
    {
        if($request->tambah == ""){
            $tambah = 0;
        } else {
            $tambah = 1;
        }
        if($request->ubah == ""){
            $rubah = 0;
        } else {
            $rubah = 1;
        }
        if($request->hapus == ""){
            $hapus = 0;
        } else {
            $hapus = 1;
        }
        if($request->cetak == ""){
            $cetak = 0;
        } else {
            $cetak = 1;
        }
        if($request->lihat == ""){
            $lihat = 0;
        } else {
            $lihat = 1;
        }

        $user_menu = Usermenu::where('userid',$id)
                    ->where('menuid',$request->menuid)
                    ->update([
                        'tambah' => $tambah,
                        'rubah' => $rubah,
                        'hapus' => $hapus,
                        'cetak' => $cetak,
                        'lihat' => $lihat,
                    ]);
        
        if($user_menu){
            Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(300000);
            return redirect()->route('modul_administrator.set_function.index');
        }
        Alert::error('Gagal', 'Data Gagal Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        //
    }

    public function menuIdJson(Request $request)
    {
        $data = UserMenu::where('userid', $request->userid)
                        ->where('menuid', $request->menuid)
                        ->first();

        return response()->json($data);
    }
}
