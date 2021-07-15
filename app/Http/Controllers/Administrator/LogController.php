<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load plugin
use App\Models\UserLog;

class LogController extends Controller
{
    public function index()
    {
        return view('modul-administrator.log.index');
    }

    public function searchIndex(Request $request)
    {        
        $log = UserLog::orderBy('login', 'desc');

        if($request->has('login_month') && $request->login_month != '' && $request->has('login_year') && $request->login_year != ''){
            $log->whereMonth('login', $request->login_month);
            $log->whereYear('login', $request->login_year);
        }
        else{
            if($request->has('login_month') && $request->login_month != ''){
                $log->whereMonth('login', $request->login_month);
            }
    
            if($request->has('login_year') && $request->login_year != ''){
                $log->whereYear('login', $request->login_year);
            }
        }

        $data = $log->get();        
        
        return datatables()->of($data)
        ->addColumn('userid', function ($data) {
            return $data->userid;
        })
        ->addColumn('usernm', function ($data) {
            return $data->usernm;
        })
        ->addColumn('login', function ($data) {
            return $data->login;
        })
        ->addColumn('logout', function ($data) {
            return $data->logout;
        })
        ->addColumn('terminal', function ($data) {
            return $data->terminal;
        })
        ->make(true);
    }
}
