<?php

namespace App\Http\Controllers\Gcg;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\GcgLHKPNStore;
use App\Http\Requests\GCGLHKPNUpdate;
use App\Models\GcgLhkpn;
use App\Models\GcgLhkpnDokumen;
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
        return view('modul-gcg.lhkpn.index', compact('lhkpn_list'));
    }

    public function create()
    {
        return view('modul-gcg.lhkpn.create');
    }

    public function store(GcgLHKPNStore $request, GcgLhkpn $lhkpn)
    {
        $lhkpn->status = $request->status;
        $lhkpn->tanggal = $request->tanggal;
        $lhkpn->nopeg = auth()->user()->nopeg;

        $lhkpn->save();

        $lhkpn_id = $lhkpn->id;

        if ($request->file('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $lhkpn_dokumen = new GcgLhkpnDokumen();
                $lhkpn_dokumen->lhkpn_id = $lhkpn_id;

                $file_name = $file->getClientOriginalName();
                $file->move('lhkpn', $file_name);

                $lhkpn_dokumen->dokumen = $file_name;

                $lhkpn_dokumen->save();
            }
        }

        Alert::success('Tambah Laporan LHKPN', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_gcg.lhkpn.index');
    }

    public function edit(GcgLhkpn $lhkpn)
    {
        return view('modul-gcg.lhkpn.edit', compact(
            'lhkpn',
        ));
    }

    public function update(GCGLHKPNUpdate $request, GcgLhkpn $lhkpn)
    {
        $lhkpn->status = $request->status;
        $lhkpn->tanggal = $request->tanggal;
        $lhkpn->nopeg = auth()->user()->nopeg;

        $lhkpn->save();

        if ($request->file('dokumen')) {
            $lhkpn->dokumen()->delete();

            foreach ($request->file('dokumen') as $file) {
                $lhkpn_dokumen = new GcgLhkpnDokumen();
                $lhkpn_dokumen->lhkpn_id = $lhkpn->id;

                $file_name = $file->getClientOriginalName();
                $file->move('lhkpn', $file_name);

                $lhkpn_dokumen->dokumen = $file_name;

                $lhkpn_dokumen->save();
            }
        }

        Alert::success('Update Laporan LHKPN', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_gcg.lhkpn.index');
    }

    public function destroy(GcgLhkpn $lhkpn)
    {
        $lhkpn->dokumen()->delete();

        return (bool) $lhkpn->delete();
    }
}
