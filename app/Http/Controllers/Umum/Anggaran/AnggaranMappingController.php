<?php

namespace App\Http\Controllers\Umum\Anggaran;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AnggaranDetail;
use App\Models\AnggaranMapping;
use DataTables;
use DB;
use Illuminate\Http\Request;

class AnggaranMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = AnggaranDetail::select('tahun')
        ->whereNotNull('tahun')
        ->distinct()
        ->orderBy('tahun', 'DESC')
        ->get();

        return view('modul-umum.anggaran-mapping.index', compact('tahun'));
    }

    public function indexJson(Request $request)
    {
        $detail_anggaran_list = AnggaranDetail::orderBy('tahun', 'desc')
        ->orderBy('kode', 'asc');

        return DataTables::of($detail_anggaran_list)
            ->filter(function ($query) use ($request) {
                if ($request->has('kode_detail_anggaran')) {
                    $query->where('kode', 'like', "{$request->get('kode_detail_anggaran')}%");
                }

                if ($request->has('tahun')) {
                    $query->where('tahun', 'like', "%{$request->get('tahun')}%");
                }
            })
            ->addColumn('nama_sanper', function ($row) {
                $anggaranMappingList = AnggaranMapping::select('kodeacct')
                ->where('kode', $row->kode)
                ->get()
                ->toArray();
                
                $sanperList = Account::select('kodeacct', 'descacct')
                ->whereIn('kodeacct', $anggaranMappingList)
                ->orderBy('kodeacct', 'asc')
                ->get();
                
                $html = '';
                foreach ($sanperList as $key => $sanper) {
                    $html .= '<span class="badge badge-primary m-1"> '.$sanper->kodeacct.' - '.$sanper->descacct.' </span>';
                }

                return $html;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr(0);
            })
            ->addColumn('realisasi', function ($row) {
                return currency_idr(0);
            })
            ->addColumn('sisa', function ($row) {
                return currency_idr(0);
            })
            ->addColumn('radio', function ($row) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="radio1" value="'.$row->kode_main.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['radio', 'nama_sanper'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahunList = AnggaranDetail::select('tahun')
        ->whereNotNull('tahun')
        ->distinct()
        ->orderBy('tahun', 'DESC')
        ->get();

        $detailAnggaranList = AnggaranDetail::where('tahun', date('Y'))->get();

        return view('modul-umum.anggaran-mapping.create', compact(
            'tahunList',
            'detailAnggaranList'
        ));
    }

    public function ajaxDetailAnggaranList($tahun)
    {
        $detailAnggaranList = AnggaranDetail::where('tahun', $tahun)
        ->orderBy('tahun', 'desc')
        ->orderBy('kode', 'asc')
        ->get();

        return response()->json($detailAnggaranList);
    }

    public function ajaxSanper(Request $request)
    {
        $sanperAnggaranMappingList = AnggaranMapping::select('kodeacct')
        ->get()
        ->toArray();

        $sanperList = Account::select('kodeacct', 'descacct')
        ->whereNotIn('kodeacct', $sanperAnggaranMappingList)
        ->where('kodeacct', 'like', "$request->q%")
        ->orWhere('descacct', 'like', "$request->q%")
        ->orderByDesc('kodeacct')
        ->get();

        return response()->json($sanperList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
           // INSERT TO DATABASE
            foreach ($request->sandi_perkiraan as $key => $sandi_perkiraan) {
                $anggaranMapping = new AnggaranMapping;
                $anggaranMapping->kodeacct = $sandi_perkiraan;
                $anggaranMapping->kode = $request->detail_anggaran;
                $anggaranMapping->tahun = $request->tahun;

                $anggaranMapping->save();
            } 
        });

        return redirect()->route('modul_umum.anggaran.mapping.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('modul-umum.anggaran-mapping.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
