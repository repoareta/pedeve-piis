<?php

namespace App\Http\Controllers\SdmPayroll\Potongan;

use Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\PotonganKoreksiGajiStoreRequest;
use App\Models\KoreksiGaji;
use App\Models\PayAard;
use DB;
use DomPDF;
use Illuminate\Http\Request;

class PotonganKoreksiGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_tahunbulan = DB::select("SELECT 
            max(thnbln) AS bulan_buku 
            FROM timetrans 
            WHERE status ='1' 
            AND length(thnbln)='6'")[0];

        if (!empty($data_tahunbulan)) {
            $tahun = substr($data_tahunbulan->bulan_buku, 0, -2);
            $bulan = substr($data_tahunbulan->bulan_buku, 4);
        } else {
            $bulan = '00';
            $tahun = '0000';
        }

        $pegawai_list = DB::select("SELECT 
            nopeg,
            nama, 
            status,
            nama 
            FROM sdm_master_pegawai 
            WHERE status <> 'P' 
            ORDER BY nopeg
        ");

        return view('modul-sdm-payroll.potongan-koreksi-gaji.index', compact(
            'pegawai_list',
            'tahun',
            'bulan'
        ));
    }

    public function indexJson(Request $request)
    {
        if ($request->nopek == "- Pilih -") {
            $request->nopek = null;
        }

        if ($request->bulan == "- Pilih -") {
            $request->bulan = null;
        }

        $bulan = $request->bulan ? ltrim($request->bulan, '0') : null;
        $tahun = $request->tahun;
        $nopek = $request->nopek;

        $data = DB::table(DB::raw('pay_koreksigaji as a'))
            ->select(DB::raw('a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard'))
            ->join(DB::raw('sdm_master_pegawai as b'), 'a.nopek', '=', 'b.nopeg')
            ->join(DB::raw('pay_tbl_aard as c'), 'a.aard', '=', 'c.kode');

        if ($tahun) {
            $data = $data->where('a.tahun', '=', $tahun);
        }

        if ($bulan) {
            $data = $data->where('a.bulan', '=', $bulan);
        }

        if ($nopek) {
            $data = $data->where('a.nopek', '=', $nopek);
        }

        return datatables()->of($data->get())
            ->addColumn('tahun', function ($data) {
                return $data->tahun;
            })
            ->addColumn('bulan', function ($data) {
                $array_bln     = array(
                    1 => 'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
                $bulan = strtoupper($array_bln[$data->bulan]);
                return $bulan;
            })
            ->addColumn('nopek', function ($data) {
                return $data->nopek . ' -- ' . $data->nama_nopek;
            })
            ->addColumn('aard', function ($data) {
                return $data->aard . ' -- ' . $data->nama_aard;
            })
            ->addColumn('nilai', function ($data) {
                return currency_format($data->nilai, 2, '.', ',');
            })

            ->addColumn('radio', function ($data) {
                $radio = '<label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" tahun="' . $data->tahun . '" bulan="' . $data->bulan . '"  aard="' . $data->aard . '" nopek="' . $data->nopek . '" nama="' . $data->nama_nopek . '" data-nopek="" class="btn-radio" name="btn-radio-rekap"><span></span></label>';
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
        $data_pegawai = DB::select("SELECT nopeg,nama,status,nama from sdm_master_pegawai where status <>'P' order by nopeg");
        $pay_aard = PayAard::where('jenis', 10)->get();
        $bulan = date_format(now(), 'n');
        $tahun = date_format(now(), 'Y');
        return view('modul-sdm-payroll.potongan-koreksi-gaji.create', compact('pay_aard', 'data_pegawai', 'bulan', 'tahun'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PotonganKoreksiGajiStoreRequest $request)
    {
        $validated = collect($request->validated())
            ->put('jmlcc', 0)
            ->put('ccl', 0)
            ->toArray();

        $validated['nilai'] = sanitize_nominal($validated['nilai']);

        KoreksiGaji::insert($validated);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.potongan_koreksi_gaji.index');
    }

    public function edit($bulan, $tahun, $aard, $nopek)
    {
        $data_list = DB::select("SELECT a.tahun, a.bulan, a.nopek, a.aard, a.jmlcc, a.ccl, a.nilai, a.userid, b.nama as nama_nopek,c.nama as nama_aard from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg  join pay_tbl_aard c on a.aard=c.kode  where a.nopek='$nopek' and a.aard='$aard' and a.bulan='$bulan' and a.tahun='$tahun'")[0];

        $bulan = date_format(now(), 'n');
        $tahun = date_format(now(), 'Y');
        $data = KoreksiGaji::where('nopek', $nopek)
            ->where('aard', $aard)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();


        return view('modul-sdm-payroll.potongan-koreksi-gaji.edit', compact('data_list', 'tahun', 'bulan'));
    }

    public function update(Request $request)
    {
        KoreksiGaji::where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->where('nopek', $request->nopek)
            ->where('aard', $request->aard)
            ->update([
                'nilai' => sanitize_nominal($request->nilai),
                'userid' => $request->userid,
            ]);

        Alert::success('Berhasil', 'Data Berhasil Disimpan')->persistent(true)->autoClose(3000);
        return redirect()->route('modul_sdm_payroll.potongan_koreksi_gaji.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        KoreksiGaji::where('tahun', $request->tahun)
            ->where('bulan', $request->bulan)
            ->where('nopek', $request->nopek)
            ->where('aard', $request->aard)
            ->delete();
        return response()->json();
    }
    public function ctkkoreksi()
    {
        return view('modul-sdm-payroll.potongan-koreksi-gaji.rekapkoreksi');
    }
    public function koreksiExport(Request $request)
    {
        $data_list = DB::select("SELECT a.aard,a.nopek,a.nilai,b.nama from pay_koreksigaji a join sdm_master_pegawai b on a.nopek=b.nopeg where a.aard in ('32','34') and a.tahun='$request->tahun' and a.bulan='$request->bulan' and b.status='$request->prosesupah' order by b.nama asc");
        if (!empty($data_list)) {
            $pdf = DomPDF::loadview('modul-sdm-payroll.potongan-koreksi-gaji.export_koreksigaji', compact('request', 'data_list'))->setPaper('a4', 'Portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->getCanvas();
            $canvas->page_text(740, 115, "Halaman {PAGE_NUM} Dari {PAGE_COUNT}", null, 10, array(0, 0, 0)); //lembur landscape
            // return $pdf->download('rekap_umk_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream();
        } else {
            Alert::info("Tidak ditemukan data dengan Nopeg: $request->nopek Bulan/Tahun: $request->bulan/$request->tahun ", 'Failed')->persistent(true);
            return redirect()->route('potongan_koreksi_gaji.ctkkoreksi');
        }
    }
}
