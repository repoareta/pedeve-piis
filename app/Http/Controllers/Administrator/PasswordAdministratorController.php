<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// load model
use App\Models\UserPdv;

// load plugin
use Auth;
use Alert;

class PasswordAdministratorController extends Controller
{
    public function index()
    {
        return view('modul-administrator.password-administrator.index');
    }

    public function store(Request $request)
    {
        $cek_user = UserPdv::where('userid', Auth::user()->userid)
                            ->where('userpw', $request->password_lama)
                            ->first();
        
        if(!$cek_user){
            Alert::error('Gagal', 'Password lama tidak sama dengan user ini')->persistent(true)->autoClose(3000);
            return redirect()->back();
        }

        $cek_user->userpw = $request->password_baru;
        $cek_user->save();

        Alert::success('Sukses', 'Password sudah diupdate')->persistent(true)->autoClose(3000);
        return redirect()->back();
    }
}
