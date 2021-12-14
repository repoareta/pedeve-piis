<?php

namespace App\Http\Controllers\Gcg;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\GcgSosialisasiStore;
use App\Models\GcgSosialisasi;
use App\Models\GcgSosialisasiDokumen;
use App\Models\GcgSosialisasiReader;
use Illuminate\Http\Request;

class SosialisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sosialisasi_list = GcgSosialisasi::with('pekerja')
        ->with('dokumen')
        ->with('reader')
        ->with('reader.pekerja')
        ->get();

        return view('modul-gcg.sosialisasi.index', compact('sosialisasi_list'));
    }

    public function create()
    {
        return view('modul-gcg.sosialisasi.create');
    }

    public function store(GcgSosialisasiStore $request, GcgSosialisasi $sosialisasi)
    {
        $sosialisasi->keterangan = $request->keterangan;
        $sosialisasi->nopeg = auth()->user()->nopeg;

        $sosialisasi->save();

        $sosialisasi_id = $sosialisasi->id;

        if ($request->file('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $sosialisasi_dokumen = new GcgSosialisasiDokumen;
                $sosialisasi_dokumen->sosialisasi_id = $sosialisasi_id;
                
                $file_name = $file->getClientOriginalName();
                $file->move('sosialisasi', $file_name);
                
                $sosialisasi_dokumen->dokumen = $file_name;

                $sosialisasi_dokumen->save();
            }   
        }

        Alert::success('Tambah Sosialisasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_gcg.sosialisasi.index');
    }

    public function storeReader(Request $request, GcgSosialisasiReader $reader)
    {   
        $reader_exist = GcgSosialisasiReader::where('nopeg', $request->nopeg)
        ->where('sosialisasi_id', $request->sosialisasi_id)
        ->first();

        if ($reader_exist){
            return response()->json([
                'success' => true,
                'reader' => $reader_exist
            ], 200);
        }

        $reader->nopeg = $request->nopeg;
        $reader->sosialisasi_id = $request->sosialisasi_id;

        $reader->save();
        
        return response()->json([
            'success' => true,
            'reader' => $reader
        ], 200);
    }
}
