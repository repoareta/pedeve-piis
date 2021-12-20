<?php

namespace App\Http\Controllers\Gcg;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\GcgSosialisasiStore;
use App\Http\Requests\GcgSosialisasiUpdate;
use App\Models\GcgSosialisasi;
use App\Models\GcgSosialisasiReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        $files = $request->file('dokumen');

        if ($files) {
            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                
                $file->move('sosialisasi'.'/'.$sosialisasi->id, $file_name);

                $sosialisasi->dokumen()->insert([
                    'sosialisasi_id' => $sosialisasi->id,
                    'dokumen' => $file_name,
                ]);
            }
        }

        Alert::success('Tambah Sosialisasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_gcg.sosialisasi.index');
    }

    public function edit(GcgSosialisasi $sosialisasi)
    {
        return view('modul-gcg.sosialisasi.edit', compact('sosialisasi'));
    }

    public function update(GcgSosialisasiUpdate $request, GcgSosialisasi $sosialisasi)
    {        
        $sosialisasi->keterangan = $request->keterangan;

        $sosialisasi->save();

        $files = $request->file('dokumen');

        if ($files) {
            // delete file in directory sosialisasi_id
            $directory = 'sosialisasi/'.$sosialisasi->id;
            File::deleteDirectory(public_path($directory));

            $sosialisasi->dokumen()->delete();
            foreach ($files as $file) {
                $file_name = $file->getClientOriginalName();
                $file->move('sosialisasi'.'/'.$sosialisasi->id, $file_name);

                $sosialisasi->dokumen()->insert([
                    'sosialisasi_id' => $sosialisasi->id,
                    'dokumen' => $file_name,
                ]);
            }
        }

        Alert::success('Ubah Sosialisasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_gcg.sosialisasi.index');
    }

    /**
     * Delete Sosialisasi
     *
     * @param GcgSosialisasi $sosialisasi
     * @return void
     */
    public function delete(Request $request, GcgSosialisasi $sosialisasi)
    {
        // delete file in directory sosialisasi_id
        $directory = 'sosialisasi/'.$sosialisasi->id;
        File::deleteDirectory(public_path($directory));
        $sosialisasi->dokumen()->delete();
        $sosialisasi->delete();

        return response()->json(['delete' => true], 200);
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

    public function checkReader(Request $request)
    {   
        $reader_exist = GcgSosialisasiReader::where('nopeg', $request->nopeg)
        ->where('sosialisasi_id', $request->sosialisasi_id)
        ->first();

        if ($reader_exist){
            return response()->json([
                'success' => true,
                'reader' => $reader_exist
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'reader' => 'reader not found'
            ], 200);
        }
    }
}
