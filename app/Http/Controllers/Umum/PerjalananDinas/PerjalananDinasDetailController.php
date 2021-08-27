<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use App\Http\Controllers\Controller;
use App\Models\PanjarDetail;
use Illuminate\Http\Request;

class PerjalananDinasDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request, $no_panjar = null)
    {
        if (session('panjar_detail') and $no_panjar == null) {
            $panjar_list_detail = session('panjar_detail');
        } else {
            $no_panjar = str_replace('-', '/', $no_panjar);
            $panjar_list_detail = PanjarDetail::where('no_panjar', $no_panjar)->get();
        }

        return datatables()->of($panjar_list_detail)
            ->addColumn('golongan', function ($row) {
                return $row->status;
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->no.'-'.$row->nopek.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio'])
            ->make(true);
    }

    public function create()
    {
        return view('modul-umum.perjalanan-dinas._detail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $panjar_detail = new PanjarDetail;
        $panjar_detail->no = $request->no;
        $panjar_detail->no_panjar = $request->no_panjar ? $request->no_panjar : null; // for add update only
        $panjar_detail->nopek = $request->nopek;
        $panjar_detail->nama = $request->nama;
        $panjar_detail->jabatan = $request->jabatan;
        $panjar_detail->status = $request->golongan;
        $panjar_detail->keterangan = $request->keterangan;

        if ($request->session == 'true') {
            if (session('panjar_detail')) {
                session()->push('panjar_detail', $panjar_detail);
            } else {
                session()->put('panjar_detail', []);
                session()->push('panjar_detail', $panjar_detail);
            }
        } else {
            // insert to database
            $panjar_detail->save();
        }

        return response()->json($panjar_detail, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $nopek = substr($request->no_nopek, strpos($request->no_nopek, "-") + 1);
        $nopek = $request->no_nopek;
        $no = $request->no_urut;

        if ($request->session == 'true') {
            foreach (session('panjar_detail') as $key => $value) {
                if ($value['nopek'] == $nopek and $value['no'] == $no) {
                    $data = session("panjar_detail.$key");
                }
            }
        } else {
            $data = PanjarDetail::where('no_panjar', $request->no_panjar)
            ->where('nopek', $nopek)->first();
        }

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_panjar, $no_urut, $nopek)
    {
        if ($request->session == 'true') {
            // delete session
            foreach (session('panjar_detail') as $key => $value) {
                if ($value['no'] == $no_urut and $value['nopek'] == $nopek) {
                    session()->forget("panjar_detail.$key");

                    $panjar_detail = new PanjarDetail;
                    $panjar_detail->no = $request->no;
                    $panjar_detail->nopek = $request->nopek;
                    $panjar_detail->nama = $request->nama;
                    $panjar_detail->jabatan = $request->jabatan;
                    $panjar_detail->golongan = $request->golongan;
                    $panjar_detail->status = $request->golongan;
                    $panjar_detail->keterangan = $request->keterangan;

                    // dd($panjar_detail);

                    if (session('panjar_detail')) {
                        session()->push('panjar_detail', $panjar_detail);
                    } else {
                        session()->put('panjar_detail', []);
                        session()->push('panjar_detail', $panjar_detail);
                    }
                }
            }
        } else {
            // Dari Database
            $panjar_detail = PanjarDetail::where('no_panjar', $request->no_panjar)
            ->where('no', $request->no)
            ->delete();

            $panjar_detail = new PanjarDetail;
            $panjar_detail->no = $request->no;
            $panjar_detail->no_panjar = $request->no_panjar;
            $panjar_detail->nopek = $request->nopek;
            $panjar_detail->nama = $request->nama;
            $panjar_detail->jabatan = $request->jabatan;
            $panjar_detail->status = $request->golongan;
            $panjar_detail->keterangan = $request->keterangan;

            $panjar_detail->save();
        }

        $data = $panjar_detail;
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $nopek = substr($request->no_nopek, strpos($request->no_nopek, "-") + 1);
        // dd($nopek);
        if ($request->session == 'true') {
            // delete session
            foreach (session('panjar_detail') as $key => $value) {
                if ($value['nopek'] == $nopek) {
                    session()->forget("panjar_detail.$key");
                }
            }
        } else {
            // delete Database
            PanjarDetail::where('nopek', $nopek)
            ->where('no_panjar', $request->no_panjar)
            ->delete();
        }

        return response()->json();
    }
}
