<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorStore;
use App\Http\Requests\VendorUpdate;
use Illuminate\Http\Request;

use App\Models\Vendor;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modul-umum.vendor.index');
    }

    public function indexJson(Request $request)
    {
        $vendor = Vendor::orderBy('id', 'DESC');
        return datatables()->of($vendor)
        ->addColumn('radio', function ($vendor) {
            $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$vendor->id.'" data-nama="'.$vendor->nama.'" value="'.$vendor->id.'" name="btn-radio"><span></span></label>';
            return $radio;
        })
        ->rawColumns(['radio'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modul-umum.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorStore $request, Vendor $vendor)
    {
        $vendor->nama = $request->nama;
        $vendor->alamat = $request->alamat;
        $vendor->telepon = $request->telepon;
        $vendor->atas_nama = $request->atas_nama;
        $vendor->no_rekening = $request->no_rekening;
        $vendor->nama_bank = $request->nama_bank;
        $vendor->cabang_bank = $request->cabang_bank;

        $vendor->save();

        Alert::success('Data berhasil di simpan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_umum.vendor.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        return view('modul-umum.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorUpdate $request, Vendor $vendor)
    {
        $vendor->nama = $request->nama;
        $vendor->alamat = $request->alamat;
        $vendor->telepon = $request->telepon;
        $vendor->no_rekening = $request->no_rekening;
        $vendor->atas_nama = $request->atas_nama;
        $vendor->nama_bank = $request->nama_bank;
        $vendor->cabang_bank = $request->cabang_bank;

        $vendor->save();

        Alert::success('Data berhasil di ubah', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_umum.vendor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Vendor::where('id', $request->id)->delete();
        return response()->json();
    }
}
