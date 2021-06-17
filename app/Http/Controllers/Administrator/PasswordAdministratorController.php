<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\Userpdv;

// load plugin
use Auth;
use DB;

class PasswordAdministratorController extends Controller
{
    public function index()
    {
        return view('password_administrator.index');
    }

    public function passJson(Request $request)
    {
        $pass=$request->pass;
        $uppercase = preg_match('@[A-Z]@', $pass);
        $lowercase = preg_match('@[a-z]@', $pass);
        $number    = preg_match('@[0-9]@', $pass);

        if(!$lowercase || !$number || strlen($pass)<=8){
            return response()->json(1);
        }else{
            return response()->json(2);
        } 
    }

    public function store(Request $request)
    {
        $data_cek = DB::select("select * from userpdv where userpw='$request->userpw'");
        if (!empty($data_cek)) {
            $userid = Auth::user()->userid;
            $data_tglexp = DB::select("select (date(now()) + INTERVAL  '4' month) as tglexp");
            foreach ($data_tglexp as $data_tgl) {
                $tglexp = $data_tgl->tglexp;
            }
            $tglupd = date('Y-m-d');
            Userpdv::where('userid', $userid)
            ->update([
                'userpw' => $request->newpw,
                'tglupd' => $tglupd,
                'passexp' => $tglexp
            ]);
            return response()->json(1);
        }else{
            return response()->json(2);
        }
    }
}
