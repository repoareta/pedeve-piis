<?php

namespace App\Http\Controllers\SdmPayroll\Gcg;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\GcgLHKPNStore;
use App\Models\GcgLhkpn;
use Illuminate\Http\Request;

class LhkpnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lhkpn_list = GcgLhkpn::all();
        return view('gcg.lhkpn.index', compact('lhkpn_list'));
    }

    public function create()
    {
        return view('gcg.lhkpn.create');
    }

    public function store(GcgLHKPNStore $request, GcgLhkpn $lhkpn)
    {
        $file = $request->file('dokumen');

        $lhkpn->status  = $request->status_lhkpn;
        $lhkpn->tanggal = $request->tanggal;
        $lhkpn->nopeg   = auth()->user()->nopeg;

        if ($file) {
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $lhkpn->dokumen = $file_name;
            $file_path = $file->storeAs('lhkpn', $lhkpn->dokumen, 'public');
        }

        $lhkpn->save();

        Alert::success('Tambah Laporan LHKPN', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('gcg.lhkpn.index');
    }
}
