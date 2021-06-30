<?php

namespace App\Http\Controllers\Umum;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorStore;
use App\Http\Requests\VendorUpdate;
use Illuminate\Http\Request;

use App\Models\Vendor;

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
            ->addColumn('action', function ($vendor) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" data-id="'.$vendor->id.'" data-nama="'.$vendor->nama.'" value="'.$vendor->id.'" name="btn-radio"><span></span></label>';

                return $radio;
            })
            ->rawColumns(['action'])
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
        $vendor->no_rekening = $request->no_rekening;
        $vendor->nama_bank = $request->nama_bank;
        $vendor->cabang_bank = $request->cabang_bank;

        $vendor->save();

        return redirect()->route('vendor.index');
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
        $vendor->nama_bank = $request->nama_bank;
        $vendor->cabang_bank = $request->cabang_bank;

        $vendor->save();

        return redirect()->route('vendor.index');
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
