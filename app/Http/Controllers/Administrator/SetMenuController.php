<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

//load form request
use Illuminate\Http\Request;

// load model
use App\Models\UserPdv;
use App\Models\UserMenu;

// load plugin
use DB;
class SetMenuController extends Controller
{
    public function index()
    {
        return view('modul-administrator.set-menu.index');
    }

    public function indexJson()
    {
        $data = UserPdv::orderBy('userid','asc')->get();
        return datatables()->of($data)
        ->addColumn('userid', function ($data) {
            return $data->userid;
        })
        ->addColumn('usernm', function ($data) {
            return $data->usernm;
        })
        ->addColumn('kode', function ($data) {
            return $data->kode;
        })
        ->addColumn('userlv', function ($data) {
            if($data->userlv == 0){
                return "ADMINISTRATOR";
            }else{
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
            $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->userid.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio','userap'])
        ->make(true); 
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }


    public function edit($id)
    {
        $data = DB::table('usermenu')
                    ->select('usermenu.* as usermenu', 'dftmenu.* as dftmenu')
                    ->join('dftmenu', 'usermenu.menuid', 'dftmenu.menuid')
                    ->where('usermenu.userid', $id)
                    ->where('usermenu.deleted_at', null)
                    ->whereNotIn('dftmenu.userap', ['INV','TAB'])
                    ->orderBy('dftmenu.userap' ,'asc')
                    ->get();

        if(request()->ajax()){
            return datatables()->of($data)
            ->addColumn('checkbox', function($data){
                $ability = $data->ability == 1 ? 'checked' : '';
                $checkbox = '<label class="checkbox checkbox-primary">
                                <input type="checkbox" name="menuid" class="checkbox-menuid" value="'. $data->menuid .'" '. $ability .'>
                                <span></span>
                            </label>';
                
                return $checkbox;
            })
            ->addColumn('menuid', function($data){
                return $data->menuid;
            })
            ->addColumn('menunm', function($data){
                return $data->menunm;
            })
            ->addColumn('userap', function($data){
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
            ->rawColumns(['checkbox'])
            ->make(true);
        }

        return view('modul-administrator.set-menu.edit', compact('id'));
    }
    
    public function update(Request $request, $id)
    {
        // return response()->json($request->menus);die;
        $data = DB::table('usermenu')
                    ->select('usermenu.* as usermenu', 'dftmenu.* as dftmenu')
                    ->join('dftmenu', 'usermenu.menuid', 'dftmenu.menuid')
                    ->where('usermenu.userid', $id)
                    ->where('usermenu.deleted_at', null)
                    ->whereNotIn('dftmenu.userap', ['INV','TAB'])
                    ->orderBy('dftmenu.userap' ,'asc');

        if($request->has('menus') && $request->menus != 'null'){
            $data->whereNotIn('usermenu.menuid', $request->menus);
        }

        $usermenus = $data->get();
        // Menu ability 0        
        foreach($usermenus as $menu)
        {            
            UserMenu::where('userid', $id)
                    ->where('menuid', $menu->menuid)
                    ->update([
                        'ability' => 0
                    ]);
        }

        // Menu ability 1
        if($request->has('menus') && $request->menus != 'null'){
            foreach($request->menus as $menu)
            {            
                UserMenu::where('userid', $id)
                        ->where('menuid', $menu)
                        ->update([
                            'ability' => 1
                        ]);
            }
        }
        
        return route('modul_administrator.set_menu.index');
    }

    public function delete(Request $request)
    {
        UserPdv::where('userid',$request->kode)->delete();
        UserMenu::where('userid',$request->kode)->delete();
        return response()->json();
    }
}
