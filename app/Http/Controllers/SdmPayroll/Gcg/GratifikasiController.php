<?php

namespace App\Http\Controllers\SdmPayroll\Gcg;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\GcgPemberianStore;
use App\Http\Requests\GcgPenerimaanStore;
use App\Http\Requests\GcgPermintaanStore;
use App\Models\GcgFungsi;
use App\Models\GcgGratifikasi;
use Auth;
use Carbon\Carbon;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class GratifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gratifikasi_list = GcgGratifikasi::all();
        return view('modul-sdm-payroll.gcg.gratifikasi.index', compact('gratifikasi_list'));
    }

    public function penerimaan()
    {
        return view('modul-sdm-payroll.gcg.gratifikasi.penerimaan');
    }

    public function penerimaanStore(GcgPenerimaanStore $request, GcgGratifikasi $penerimaan)
    {
        $penerimaan->nopeg             = Auth::user()->nopeg;
        $penerimaan->gift_last_month   = $request->penerimaan_bulan_lalu;
        $penerimaan->tgl_gratifikasi   = $request->tanggal_penerimaan;
        $penerimaan->bentuk            = $request->bentuk_jenis_penerimaan;
        $penerimaan->nilai             = $request->nilai;
        $penerimaan->jumlah            = $request->jumlah;
        $penerimaan->pemberi          = $request->pemberi_hadiah;
        $penerimaan->keterangan        = $request->keterangan;
        $penerimaan->jenis_gratifikasi = 'penerimaan';

        $penerimaan->save();

        Alert::success('Simpan Data Penerimaan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.gcg.gratifikasi.index');
    }

    public function pemberian()
    {
        return view('modul-sdm-payroll.gcg.gratifikasi.pemberian');
    }

    public function pemberianStore(GcgPemberianStore $request, GcgGratifikasi $pemberian)
    {
        $pemberian->nopeg             = Auth::user()->nopeg;
        $pemberian->gift_last_month   = $request->pemberian_bulan_lalu;
        $pemberian->tgl_gratifikasi   = $request->tanggal_pemberian;
        $pemberian->bentuk            = $request->bentuk_jenis_pemberian;
        $pemberian->nilai             = $request->nilai;
        $pemberian->jumlah            = $request->jumlah;
        $pemberian->penerima          = $request->penerima_hadiah;
        $pemberian->keterangan        = $request->keterangan;
        $pemberian->jenis_gratifikasi = 'pemberian';

        $pemberian->save();

        Alert::success('Simpan Data Pemberian', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.gcg.gratifikasi.index');
    }

    public function permintaan()
    {
        return view('modul-sdm-payroll.gcg.gratifikasi.permintaan');
    }

    public function permintaanStore(GcgPermintaanStore $request, GcgGratifikasi $permintaan)
    {
        $permintaan->nopeg             = Auth::user()->nopeg;
        $permintaan->gift_last_month   = $request->permintaan_bulan_lalu;
        $permintaan->tgl_gratifikasi   = $request->tanggal_permintaan;
        $permintaan->bentuk            = $request->bentuk_jenis_permintaan;
        $permintaan->nilai             = $request->nilai;
        $permintaan->jumlah            = $request->jumlah;
        $permintaan->peminta          = $request->peminta;
        $permintaan->keterangan        = $request->keterangan;
        $permintaan->jenis_gratifikasi = 'permintaan';

        $permintaan->save();

        Alert::success('Simpan Data Permintaan', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.gcg.gratifikasi.index');
    }

    public function reportPersonal()
    {
        $gratifikasi_tahun = GcgGratifikasi::selectRaw("extract(year from created_at) AS year")
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

        return view('modul-sdm-payroll.gcg.gratifikasi.report-personal', compact('gratifikasi_tahun'));
    }

    public function reportPersonalExport(Request $request)
    {
        $gratifikasi_list = GcgGratifikasi::when(request('bentuk_gratifikasi'), function ($q) {
            return $q->where('jenis_gratifikasi', request('bentuk_gratifikasi'));
        })
        ->when(request('bulan'), function ($q) {
            return $q->where(DB::raw('extract(month from tgl_gratifikasi)'), request('bulan'));
        })
        ->when(request('tahun'), function ($q) {
            return $q->where(DB::raw('extract(year from tgl_gratifikasi)'), request('tahun'));
        })
        ->get();
        
        // return default PDF
        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.gratifikasi.report-personal-export-pdf', compact('gratifikasi_list'))->setOptions(['isPhpEnabled' => true]);

        return $pdf->stream('gcg_report_personal_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function reportPersonalIndexJson(Request $request)
    {
        $gratifikasi_list = GcgGratifikasi::where('nopeg', Auth::user()->nopeg)
        ->orderBy('created_at', 'desc');

        return datatables()->of($gratifikasi_list)
            ->filter(function ($query) use ($request) {
                if (request('bentuk_gratifikasi')) {
                    $query->where('jenis_gratifikasi', request('bentuk_gratifikasi'));
                }

                if (request('bulan')) {
                    $query->where(DB::raw('extract(month from tgl_gratifikasi)'), request('bulan'));
                }

                if (request('tahun')) {
                    $query->where(DB::raw('extract(year from tgl_gratifikasi)'), request('tahun'));
                }
            })
            ->addColumn('tanggal_gratifikasi', function ($row) {
                return Carbon::parse($row->tgl_gratifikasi)->translatedFormat('d F Y');
            })
            ->addColumn('tanggal_submit', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })
            ->make(true);
    }

    public function reportManagement(Request $request)
    {
        $gratifikasi_tahun = GcgGratifikasi::selectRaw("extract(year from created_at) AS year")
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

        $fungsi_list = GcgFungsi::all();

        return view('modul-sdm-payroll.gcg.gratifikasi.report-management', compact('gratifikasi_tahun', 'fungsi_list'));
    }

    public function reportManagementExport(Request $request)
    {
        $gratifikasi_list = GcgGratifikasi::with('userpdv')
        ->with('userpdv.fungsi')
        ->with('userpdv.fungsi_jabatan')
        ->when(request('bentuk_gratifikasi'), function ($q) {
            return $q->where('jenis_gratifikasi', request('bentuk_gratifikasi'));
        })
        ->when(request('fungsi'), function ($q) {
            return $q->whereHas('userpdv', function ($qry) {
                return $qry->where('gcg_fungsi_id', request('fungsi'));
            });
        })
        ->when(request('bulan'), function ($q) {
            return $q->where(DB::raw('extract(month from tgl_gratifikasi)'), request('bulan'));
        })
        ->when(request('tahun'), function ($q) {
            return $q->where(DB::raw('extract(year from tgl_gratifikasi)'), request('tahun'));
        })
        ->get();
        
        // return default PDF
        $pdf = DomPDF::loadview('modul-sdm-payroll.gcg.gratifikasi.report-management-export-pdf', compact('gratifikasi_list'));

        return $pdf->stream('gcg_report_management_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function reportManagementIndexJson(Request $request)
    {
        $gratifikasi_list = GcgGratifikasi::with('userpdv')
        ->with('userpdv.fungsi')
        ->with('userpdv.fungsi_jabatan')
        ->orderBy('created_at', 'desc');

        return datatables()->of($gratifikasi_list)
            ->filter(function ($query) use ($request) {
                if (request('bentuk_gratifikasi')) {
                    $query->where('jenis_gratifikasi', request('bentuk_gratifikasi'));
                }

                if (request('fungsi')) {
                    $query->whereHas('userpdv', function ($q) {
                        return $q->where('gcg_fungsi_id', request('fungsi'));
                    });
                }

                if (request('bulan')) {
                    $query->where(DB::raw('extract(month from tgl_gratifikasi)'), request('bulan'));
                }

                if (request('tahun')) {
                    $query->where(DB::raw('extract(year from tgl_gratifikasi)'), request('tahun'));
                }
            })
            ->addColumn('nama', function ($row) {
                return $row->pekerja->nama;
            })
            ->addColumn('fungsi_jabatan', function ($row) {
                return $row->userpdv->fungsi_jabatan->nama;
            })
            ->addColumn('tanggal_gratifikasi', function ($row) {
                return Carbon::parse($row->tgl_gratifikasi)->translatedFormat('d F Y');
            })
            ->addColumn('tanggal_submit', function ($row) {
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })
            ->make(true);
    }

    public function edit(GcgGratifikasi $gratifikasi)
    {
        return view('modul-sdm-payroll.gcg.gratifikasi.edit', compact('gratifikasi'));
    }

    public function update(GcgGratifikasi $gratifikasi, Request $request)
    {
        $gratifikasi->status  = $request->status;
        $gratifikasi->catatan = $request->catatan;

        $gratifikasi->save();

        Alert::success('Update Data Gratifikasi', 'Berhasil')->persistent(true)->autoClose(2000);
        return redirect()->route('modul_sdm_payroll.gcg.gratifikasi.index');
    }
}
