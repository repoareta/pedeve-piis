<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
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
        return view('set_menu.index');
    }

    public function searchIndex(Request $request)
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
            $radio = '<center><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" kode="'.$data->userid.'" class="btn-radio" name="btn-radio"><span></span></label></center>'; 
            return $radio;
        })
        ->rawColumns(['radio','userap'])
        ->make(true); 
    }

    public function create($no)
    {
        $data_userid = DB::select("select usernm,userid from userpdv where userid='$no'");
        foreach($data_userid as $data)
        {
            $userid = $data->userid;
            $usernm = $data->usernm;
        }
        $data_menuid = DB::select("select a.*,b.menunm from usermenu a, dftmenu b where a.userid='$no' and a.ability='1' and a.menuid=b.menuid order by b.menuid asc");
        return view('set_menu.create',compact('data_menuid','userid','usernm'));
    }
    public function store(Request $request)
    {
        if($request->tambah == ""){
            $tambah = 0;
        }else{
            $tambah = 1;
        }
        if($request->ubah == ""){
            $rubah = 0;
        }else{
            $rubah = 1;
        }
        if($request->hapus == ""){
            $hapus = 0;
        }else{
            $hapus = 1;
        }
        if($request->cetak == ""){
            $cetak = 0;
        }else{
            $cetak = 1;
        }
        if($request->lihat == ""){
            $lihat = 0;
        }else{
            $lihat = 1;
        }
        $userid = $request->userid;
        $menuid = $request->menuid;
        UserMenu::where('userid',$userid)
        ->where('menuid',$menuid)
        ->update([
            'tambah' => $tambah,
            'rubah' => $rubah,
            'hapus' => $hapus,
            'cetak' => $cetak,
            'lihat' => $lihat,
        ]);
        return response()->json($request->menuid);
    }

    public function menuidJson(Request $request)
    {
        $datas = DB::select("select a.* from usermenu a where a.userid='$request->userid' and menuid='$request->menuid'");
        return response()->json($datas[0]);
    }

    public function edit($no)
    {
        $data_user = DB::table('usermenu')
        ->join('dftmenu', 'usermenu.menuid', '=', 'dftmenu.menuid')
        ->select('usermenu.ability','usermenu.userid','usermenu.menuid','dftmenu.userap', 'dftmenu.menunm')
        ->where('usermenu.userid', $no)
        ->where('usermenu.deleted_at', null)
        ->whereNotIn('dftmenu.userap', ['INV','TAB'])
        ->orderBy('dftmenu.userap' ,'asc')
        ->get();
        
        $userid  = $no; 
        $data_jum = DB::select("select  count(a.userid) as jumlah from usermenu a join dftmenu b on  b.menuid=a.menuid where a.userid='$no'");
        foreach($data_jum as $data_ju)
        {
            $jumlah  = $data_ju->jumlah; 
        }
        return view('set_menu.edit',compact('userid','data_user','jumlah'));
    }
    
    public function update(Request $request)
    {
        $a = $request->jumlah;
        for($count = 1; $count <= $a; $count++)
        {
            $ability = 0;
            $menu = "menuid$count";
            $user = "userid$count";
            $abili = "ability$count";
            $menuid = $request->$menu;
            $ability = $request->$abili;
            $userid = $request->$user;
                UserMenu::where('userid',$userid)
                ->where('menuid',$menuid)
                ->update([
                    'ability' => $ability
                ]);
            }      
            return response()->json();
    }

    public function delete(Request $request)
    {
        UserPdv::where('userid',$request->kode)->delete();
        UserMenu::where('userid',$request->kode)->delete();
        return response()->json();
    }
}
