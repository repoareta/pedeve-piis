<?php

namespace App\Http\Controllers\Umum\PerjalananDinas;

use App\Http\Controllers\Controller;
use App\Models\PanjarHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PerjalananDinasController extends Controller
{
    public function index()
    {
        return view('modul-umum.perjalanan-dinas.index');
    }

    public function indexJson(Request $request)
    {
        $panjar_list = PanjarHeader::orderBy('tgl_panjar', 'desc');

        return datatables()->of($panjar_list)
            ->filter(function ($query) use ($request) {
                if (request('nopanjar')) {
                    $query->where('no_panjar', request('nopanjar'));
                }
            })
            ->addColumn('mulai', function ($row) {
                return Carbon::parse($row->mulai)->translatedFormat('d F Y');
            })
            ->addColumn('sampai', function ($row) {
                return Carbon::parse($row->sampai)->translatedFormat('d F Y');
            })
            ->addColumn('nopek', function ($row) {
                return $row->nopek." - ".$row->nama;
            })
            ->addColumn('nilai', function ($row) {
                return currency_idr($row->jum_panjar);
            })
            ->addColumn('action', function ($row) {
                if (optional($row->ppanjar_header)->no_panjar) {
                    $ppanjar_header = "true";
                } else {
                    $ppanjar_header = "false";
                }

                $radio = '<label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="radio1" data-ppanjar="'.$ppanjar_header.'" value="'.$row->no_panjar.'"><span></span></label>';
                return $radio;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
