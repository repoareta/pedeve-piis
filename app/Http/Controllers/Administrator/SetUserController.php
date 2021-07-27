<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//load form request
use App\Http\Requests\SetUserStore;
use App\Http\Requests\SetUserUpdate;

// load model
use App\Models\UserPdv;
use App\Models\UserMenu;

// load model for GCG Implementation
use App\Models\GcgFungsi;
use App\Models\GcgJabatan;
use App\Models\Pekerja;

// load plugin
use Auth;
use Carbon\Carbon;
use DB;
use DomPDF;
use Alert;
use App\Models\DftMenu;

class SetUserController extends Controller
{
    public function index()
    {
        $data = UserPdv::orderBy('userid', 'asc')->get();
        return view('modul-administrator.set-user.index', compact('data'));
    }

    public function searchIndex()
    {
        $data = UserPdv::orderBy('userid', 'asc')->get();
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
            if ($data->userlv == 0) {
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
            $radio = '<center><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" kode="'.$data->userid.'" username="'.$data->usernm.'" class="btn-radio" name="btn-radio"><span></span></label></center>';
            return $radio;
        })
        ->addColumn('reset', function ($data) {
            // Ini route mas bukan folder / file
            $radio = '<center><a style="color:blue;" href="'. route('modul_administrator.set_user.reset', ['no' => $data->userid]).'">RESET</a></center>';
            return $radio;
        })
        ->rawColumns(['radio','userap','reset'])
        ->make(true);
    }

    public function create()
    {
        $gcg_fungsi_list = GcgFungsi::all();
        $gcg_jabatan_list = GcgJabatan::all();
        $pegawai_list = Pekerja::all();
        return view('modul-administrator.set-user.create', compact(
                        'gcg_fungsi_list',
                        'gcg_jabatan_list',
                        'pegawai_list'
                    ));
    }

    public function store(SetUserStore $request)
    {
        $data_chkuser = UserPdv::find($request->userid);
        if ($data_chkuser) {            
            Alert::error('User ID sudah ada')->persistent(true)->autoClose(2000);
            return redirect()->back();
        }
        $user_pdv = New UserPdv();
        $user_pdv->userid = $request->userid;
        $user_pdv->usernm = $request->usernm;
        $user_pdv->userlv = $request->userlv;
        $user_pdv->userap = $request->akt.''.$request->cm.''.$request->pbd.''.$request->umu.''.$request->sdm;
        $user_pdv->userpw = "v3ntur4";
        $user_pdv->usrupd = Auth::user()->userid;
        $user_pdv->kode = $request->kode;
        $user_pdv->tglupd = Carbon::now();
        $user_pdv->passexp = Carbon::now()->addMonths(4);
        $user_pdv->nopeg = $request->nopeg;
        $user_pdv->gcg_fungsi_id = $request->gcg_fungsi_id;
        $user_pdv->gcg_jabatan_id = $request->gcg_jabatan_id;
        $user_pdv->save();

        if ($request->akt == 'A') {
            $akt = 'AKT';
        }else{
            $akt = '';
        }
        if ($request->cm == 'G') {
            $cm = 'CM';
        }else{
            $cm = '';
        }
        if ($request->pbd == 'D') {
            $pbd = 'PBD';
        }else{
            $pbd = '';
        }
        if ($request->umu == 'E') {
            $umu = 'UMU';
        }else{
            $umu = '';
        }
        if ($request->sdm == 'F') {
            $sdm = 'SDM';
        }else{
            $sdm = '';
        }
        
        $data_menu = DftMenu::whereIn('userap', [$akt, $cm, $pbd, $umu, $sdm])->get();
        
        foreach ($data_menu as $data_m) {
            UserMenu::insert([
                    'userid' => $user_pdv->userid,
                    'menuid' => $data_m->menuid,
                    'cetak' => '0',
                    'tambah' => '0',
                    'rubah' => '0',
                    'lihat' => '0',
                    'hapus' => '0'
                ]);
        }

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_administrator.set_user.index');
    }

    public function edit($id)
    {
        $data = UserPdv::where('userid', $id)->first();

        $gcg_fungsi_list = GcgFungsi::all();
        $gcg_jabatan_list = GcgJabatan::all();
        $pegawai_list = Pekerja::all();

        return view('modul-administrator.set-user.edit', compact(
            'data',
            'gcg_fungsi_list',
            'gcg_jabatan_list',
            'pegawai_list'
        ));
    }
    public function update(SetUserUpdate $request, $id)
    {
        $user_pdv = UserPdv::where('userid', $id)->first();        
        $user_pdv->usernm = $request->usernm;
        $user_pdv->userlv = $request->userlv;
        $user_pdv->kode = $request->kode;
        $user_pdv->tglupd = Carbon::now();
        $user_pdv->usrupd = Auth::user()->userid;
        $user_pdv->userap = $request->akt.''.$request->cm.''.$request->pbd.''.$request->umu.''.$request->sdm;
        $user_pdv->nopeg = $request->nopeg;
        $user_pdv->gcg_fungsi_id = $request->gcg_fungsi_id;
        $user_pdv->gcg_jabatan_id = $request->gcg_jabatan_id;        
        $user_pdv->update();

        if ($request->akt == 'A') {
            $akt = 'AKT';
        } else {
            $akt = '';
        }
        if ($request->cm == 'G') {
            $cm = 'CM';
        } else {
            $cm = '';
        }
        if ($request->pbd == 'D') {
            $pbd = 'PBD';
        } else {
            $pbd = '';
        }
        if ($request->umu == 'E') {
            $umu = 'UMU';
        } else {
            $umu = '';
        }
        if ($request->sdm == 'F') {
            $sdm = 'SDM';
        } else {
            $sdm = '';
        }

        DB::table('usermenu')->where('userid', $user_pdv->userid)->delete();

        $data_menus = DftMenu::whereIn('userap', [$akt, $cm, $pbd, $umu, $sdm])->get();
        foreach ($data_menus as $data_menu) {
            UserMenu::insert([
                    'userid' => $user_pdv->userid,
                    'menuid' => $data_menu->menuid,
                    'cetak' => '0',
                    'tambah' => '0',
                    'rubah' => '0',
                    'lihat' => '0',
                    'hapus' => '0'
                ]);
        }

        Alert::success('Berhasil', 'Data Berhasil Diperbarui')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_administrator.set_user.index');
    }

    public function delete(Request $request)
    {
        UserPdv::where('userid', $request->kode)->delete();
        DB::table('usermenu')->where('userid', $request->kode)->delete();
        return response()->json();
    }

    public function export(Request $request)
    {
        if ($request->cetak == 'A') {
            $data_user = UserPdv::all();
        } else {
            $data_user = UserPdv::where('userid', $request->userid)->get();
        }
        $pdf = DomPDF::loadview('modul-administrator.set-user.export', compact('data_user'))->setPaper('a4', 'Portrait');
        // return $pdf->download('rekap_permint_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function Reset(Request $request)
    {
        $userpw ="v3ntur4";
        UserPdv::where('userid', $request->no)
            ->update([
                'userpw' => $userpw,
                'tglupd' => Carbon::now(),
                'passexp' => Carbon::now()->addMonths(4)
            ]);
        Alert::success('Password telah di Reset.', 'Berhasil')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_administrator.set_user.index');
    }
}
