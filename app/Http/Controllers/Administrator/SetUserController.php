<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// load model
use App\Models\UserPdv;
use App\Models\UserMenu;

// load model for GCG Implementation
use App\Models\GcgFungsi;
use App\Models\GcgJabatan;
use App\Models\Pekerja;

// load plugin
use Auth;
use DB;
use DomPDF;
use Alert;

class SetUserController extends Controller
{
    public function index()
    {
        $data = UserPdv::orderBy('userid', 'asc')->get();
        return view('set_user.index',compact('data'));
    }

    public function searchIndex(Request $request)
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
            $radio = '<center><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" kode="'.$data->userid.'" username="'.$data->usernm.'" class="btn-radio" name="btn-radio"><span></span></label></center>';
            return $radio;
        })
        ->addColumn('reset', function ($data) {
            $radio = '<center><a style="color:blue;" href="'. route('set_user.reset', ['no' => $data->userid]).'">RESET</a></center>';
            return $radio;
        })
        ->rawColumns(['radio','userap','reset'])
        ->make(true);
    }

    public function create()
    {
        $gcg_fungsi_list = GcgFungsi::all();
        $gcg_jabatan_list = GcgJabatan::all();
        $pekerja_list = Pekerja::all();

        return view('set_user.create', compact('gcg_fungsi_list', 'gcg_jabatan_list', 'pekerja_list'));
    }

    public function store(Request $request)
    {
        $userid = $request->userid;
        $usernm = $request->usernm;
        $userlv = $request->userlv;
        $userap = $request->akt.''.$request->cm.''.$request->pbd.''.$request->umu.''.$request->sdm;
        $userpw = "v3ntur4";
        $usrupd = Auth::user()->userid;
        $kode = $request->kode;
        $data_chkuser = DB::select("select userid from userpdv where userid='$userid'");
        if (!empty($data_chkuser)) {
            foreach ($data_chkuser as $data_ch) {
                $data = $data_ch->userid;
                return response()->json($data);
            }
        } else {
            $data_tglexp = DB::select("select (date(now()) + INTERVAL  '4' month) as tglexp");
            foreach ($data_tglexp as $data_tgl) {
                $tglexp = $data_tgl->tglexp;
            }
            $tglupd = date('Y-m-d');
            UserPdv::insert([
                'userid' => $userid,
                'userpw' => $userpw ,
                'usernm' => $usernm,
                'kode' => $kode,
                'userlv' => $userlv,
                'userap' => $userap,
                'tglupd' => $tglupd,
                'passexp' => $tglexp,
                'usrupd' => $usrupd,
                'nopeg' => $request->nopeg,
                'gcg_fungsi_id' => $request->gcg_fungsi,
                'gcg_jabatan_id' => $request->gcg_jabatan
            ]);
            if($request->akt == 'A'){
                $akt = 'AKT';
            }else{
                $akt = '';
            }
            if($request->cm == 'G'){
                $cm = 'CM';
            }else{
                $cm = '';
            }
            if($request->pbd == 'D'){
                $pbd = 'PBD';
            }else{
                $pbd = '';
            }
            if($request->umu == 'E'){
                $umu = 'UMU';
            }else{
                $umu = '';
            }
            if($request->sdm == 'F'){
                $sdm = 'SDM';
            }else{
                $sdm = '';
            }
            $data_menu = DB::select("select distinct(menuid) as menuid from dftmenu where userap in ('$akt','$cm','$pbd','$umu','$sdm')");
            foreach ($data_menu as $data_m) {
                UserMenu::insert([
                        'userid' => $userid,
                        'menuid' => $data_m->menuid,
                        'cetak' => '0',
                        'tambah' => '0',
                        'rubah' => '0',
                        'lihat' => '0',
                        'hapus' => '0'
                    ]);
            }
        }
        $data = 1;
        return response()->json($data);
    }

    public function edit($no)
    {
        $data_user = DB::select("select * from userpdv where userid='$no'");
        foreach ($data_user as $data) {
            $userid = $data->userid;
            $userpw  = $data->userpw;
            $usernm = $data->usernm;
            $kode = $data->kode;
            $userlv = $data->userlv;
            $userap = $data->userap;
            $usrupd = $data->usrupd;
            $nopeg = $data->nopeg;
            $gcg_fungsi_id = $data->gcg_fungsi_id;
            $gcg_jabatan_id = $data->gcg_jabatan_id;
        }

        $gcg_fungsi_list = GcgFungsi::all();
        $gcg_jabatan_list = GcgJabatan::all();
        $pekerja_list = Pekerja::all();

        return view('set_user.edit', compact(
            'userid',
            'userpw',
            'usernm',
            'kode',
            'userlv',
            'userap',
            'usrupd',
            'gcg_fungsi_list',
            'gcg_jabatan_list',
            'pekerja_list',
            'nopeg',
            'gcg_fungsi_id',
            'gcg_jabatan_id'
        ));
    }
    public function update(Request $request)
    {
        $userid = $request->userid;
        $usernm = $request->usernm;
        $userlv = $request->userlv;
        $kode = $request->kode;
        $tglupd = date('Y-m-d');
        $usrupd = Auth::user()->userid;
        $userap = $request->akt.''.$request->cm.''.$request->pbd.''.$request->umu.''.$request->sdm;
        UserPdv::where('userid', $userid)
        ->update([
            'usernm' => $usernm,
            'kode' => $kode,
            'userlv' => $userlv,
            'userap' => $userap,
            'tglupd' => $tglupd,
            'usrupd' => $usrupd,
            'nopeg' => $request->nopeg,
            'gcg_fungsi_id' => $request->gcg_fungsi,
            'gcg_jabatan_id' => $request->gcg_jabatan
        ]);

        if($request->akt == 'A'){
            $akt = 'AKT';
        }else{
            $akt = '';
        }
        if($request->cm == 'G'){
            $cm = 'CM';
        }else{
            $cm = '';
        }
        if($request->pbd == 'D'){
            $pbd = 'PBD';
        }else{
            $pbd = '';
        }
        if($request->umu == 'E'){
            $umu = 'UMU';
        }else{
            $umu = '';
        }
        if($request->sdm == 'F'){
            $sdm = 'SDM';
        }else{
            $sdm = '';
        }

        
        $data_menu = DB::select("select distinct(menuid) as menuid from dftmenu where userap in ('$akt','$cm','$pbd','$umu','$sdm')");
        foreach ($data_menu as $data_m) {
            $data_cek = DB::select("select * from usermenu where userid ='$userid' and menuid='$data_m->menuid'");
            if(!empty($data_cek)){
                UserMenu::where('userid',$userid)->where('menuid',$data_m->menuid)
                ->update([
                    'userid' => $userid,
                    'menuid' => $data_m->menuid
                ]);
            }else{
                UserMenu::insert([
                        'userid' => $userid,
                        'menuid' => $data_m->menuid,
                        'cetak' => '0',
                        'tambah' => '0',
                        'rubah' => '0',
                        'lihat' => '0',
                        'hapus' => '0'
                    ]);
            }
        }
        return response()->json();
    }

    public function delete(Request $request)
    {
        UserPdv::where('userid', $request->kode)->delete();
        UserMenu::where('userid', $request->kode)->delete();
        return response()->json();
    }

    public function export(Request $request)
    {
        if($request->cetak == 'A'){
            $data_user = UserPdv::all();
        }else{
            $data_user = UserPdv::where('userid', $request->userid)->get();
        }
        $pdf = DomPDF::loadview('set_user.export', compact('data_user'))->setPaper('a4', 'Portrait');
        // return $pdf->download('rekap_permint_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream();
    }

    public function Reset(Request $request)
    {
        $data_tglexp = DB::select("select (date(now()) + INTERVAL  '4' month) as tglexp");
        foreach ($data_tglexp as $data_tgl) {
            $tglexp = $data_tgl->tglexp;
        }
        $tglupd = date('Y-m-d');
        $userpw ="v3ntur4";
        UserPdv::where('userid', $request->no)
            ->update([
                'userpw' => $userpw,
                'tglupd' => $tglupd,
                'passexp' => $tglexp
            ]);
        Alert::success('Password telah di Reset.', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('set_user.index');
    }
}
