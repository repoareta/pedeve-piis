<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanKasStoreRequest;
use App\Models\CashJudex;
use App\Models\DtlDepositoTest;
use App\Models\JenisBiaya;
use App\Models\Kasdoc;
use App\Models\Kasline;
use App\Models\Lokasi;
use App\Models\MtrDeposito;
use App\Models\SdmKDBag;
use App\Models\UserMenu;
use App\Services\PenerimaanKasService;
use App\Services\TimeTransactionService;
use DB;
use Illuminate\Http\Request;
use PDF;

class PenerimaanKasController extends Controller
{
    protected $penerimaanKasService;
    protected $timeTrans;

    public function __construct(
        PenerimaanKasService $penerimaanKasService,
        TimeTransactionService $timeTrans,
    ) {
        $this->penerimaanKasService = $penerimaanKasService;
        $this->timeTrans = $timeTrans;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAbility = UserMenu::where('userid', auth()->user()->userid)
            ->where('menuid', 501)
            ->first();

        $tahun = $this->timeTrans->getCurrentYear();
        $bulan = $this->timeTrans->getCurrentMonth();
        $daftarBulan = $this->timeTrans->getAllMonths();
        
        return view('modul-treasury.bukti-kas.index', compact('tahun', 'bulan', 'daftarBulan', 'userAbility'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return $this->penerimaanKasService->getDatatables($this->timeTrans->getStringDate());
    }

    /**
     * Show the form for approval page.
     *
     * @return \Illuminate\Http\Response
     */
    public function approval($documentId)
    {
        $kasDocument = $this->penerimaanKasService->getKasDocument($documentId);
        
        if ($kasDocument->paid == 'Y') {
            return redirect()->back();
        }
        
        return view('modul-treasury.bukti-kas.approval', compact('kasDocument'));
    }

    /**
     * Show the form for approval page.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($documentId)
    {
        $kasDocument = $this->penerimaanKasService->getKasDocument($documentId);
        
        if ($kasDocument->paid == 'N') {
            return redirect()->back();
        }
        
        return view('modul-treasury.bukti-kas.approval', compact('kasDocument'));
    }
    
    public function approve($documentId, Request $request)
    {
        $approval = $this->penerimaanKasService->approval($documentId, $request);

        if (!$approval) {
            alert()->info('Info', 'Kas Tidak Mencukupi!');
            return redirect()->route('penerimaan_kas.index');
        }

        alert()->success('Approval', 'Doc. No ' . $request->no_dokumen . ' telah diapprove.');
        return redirect()->route('penerimaan_kas.index');
    }

    public function cancelApproval($documentId, Request $request)
    {
        $approval = $this->penerimaanKasService->approval($documentId, $request, true);

        if (!$approval) {
            alert()->info('Info', 'Kas Tidak Mencukupi!');
            return redirect()->route('penerimaan_kas.index');
        }

        alert()->success('Approval', 'Doc. No ' . $request->no_dokumen . ' telah dibatalkan.');
        return redirect()->route('penerimaan_kas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createKas()
    {
        return view('modul-treasury.bukti-kas.create-kas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stringDate = !$this->timeTrans->getStringDate() ? date('Ym', strtotime(now())) : $this->timeTrans->getStringDate();
        $bulan_buku = !$this->timeTrans->getCurrentMonth() ? date('m', strtotime(now())) : $this->timeTrans->getCurrentMonth();
        $tahun_buku = !$this->timeTrans->getCurrentYear() ? date('Y', strtotime(now())) : $this->timeTrans->getCurrentYear();
        $noVer = $this->penerimaanKasService->getVerNumber($stringDate);
        $semuaBagian = SdmKDBag::all();

        return view('modul-treasury.bukti-kas.create', compact('bulan_buku', 'tahun_buku', 'semuaBagian', 'noVer'));
    }

    public function ajaxCreate(Request $request)
    {
        $documentNumber = $this->penerimaanKasService->createDocumentNumber(
            $request->bagian,
            $request->bulanbuku,
            $request->mp
        );

        return response()->json($documentNumber);
    }

    public function ajaxBagian(Request $request)
    {
        $bagian = $this->penerimaanKasService->getBagian(
            $request->q
        );

        return response()->json($bagian);
    }

    public function ajaxLocation(Request $request)
    {
        $locations = $this->penerimaanKasService->getLocations(
            $request->jenis_kartu,
            $request->currency_index,
        );

        return response()->json($locations);
    }

    public function ajaxBukti(Request $request)
    {
        $bukti = $this->penerimaanKasService->getNomorBukti(
            $request->tahun,
            $request->lokasi,
            $request->mp,
        );

        return response()->json($bukti);
    }

    public function ajaxKepada(Request $request)
    {
        $kepada = $this->penerimaanKasService->getKepada(
            $request->q,
        );

        return response()->json($kepada);
    }

    public function ajaxAccount(Request $request)
    {
        $account = $this->penerimaanKasService->getAccounts(
            $request->q,
        );

        return response()->json($account);
    }

    public function ajaxJenisBiaya(Request $request)
    {
        $jenisBiaya = $this->penerimaanKasService->getJenisBiaya(
            $request->q,
        );

        return response()->json($jenisBiaya);
    }

    public function ajaxCashJudex(Request $request)
    {
        $cashJudex = $this->penerimaanKasService->getCashJudex(
            $request->q
        );

        return $cashJudex;
    }

    public function storeDetail(Request $request)
    {
        $detailToInsert = $this->penerimaanKasService->storeKasLine(
            $request->only([
                'nodok',
                'nourut',
                'rincian',
                'sanper',
                'bagian',
                'pk',
                'jb',
                'cj',
                'nilai',
            ]),
        );

        return response()->json($detailToInsert);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenerimaanKasStoreRequest $request)
    {
        $timeTrans = $this->timeTrans->getStringDate();

        $dataToInsert = $this->penerimaanKasService->storeKas(
            $request->validated(),
            $this->timeTrans->getTimeTransStatus($timeTrans),
        );
        
        return response()->json($dataToInsert);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($documentId)
    {
        $document = $this->penerimaanKasService->getKasDocument($documentId, ['storejk']);
        $rawNumber = explode('/', $document->docno);
        $codeMP = $rawNumber[0];
        $bagian = SdmKDBag::where('kode', $rawNumber[1])->first();
        $nomor = $rawNumber[2];
        $tahun = substr($document->thnbln, 0, 4);
        $bulan = substr($document->thnbln, 4, 2);
        $kasLine = $this->penerimaanKasService->getKasLine($documentId);
        $lineNumber = $this->penerimaanKasService->kasLineLastNumber($documentId);
        $count = $this->penerimaanKasService->getTotalPrice($documentId);
        $lokasi = Lokasi::all();
        $data_jenis = JenisBiaya::all();
        $data_casj = CashJudex::all();
        $data_bagian = SdmKdbag::all();
        $data_account = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%'");
        
        return view('modul-treasury.bukti-kas.show', compact(
            'document',
            'codeMP',
            'bagian',
            'nomor',
            'tahun',
            'bulan',
            'kasLine',
            'lineNumber',
            'count',
            'lokasi',
            'data_jenis',
            'data_bagian',
            'data_account',
            'data_casj',
        ));
    }

    public function getDetail($documentId, $lineNumber)
    {
        $kasLine = $this->penerimaanKasService->getKasLineByNumber($documentId, $lineNumber);

        return response()->json($kasLine);
    }

    public function deleteDetail(Request $request)
    {
        Kasline::where('docno', str_replace('-', '/',$request->nodok))->where('lineno', $request->nourut)->delete();
        MtrDeposito::where('docno', str_replace('-', '/',$request->nodok))->where('lineno', $request->nourut)->delete();

        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($documentId)
    {
        $nodoc=str_replace('-', '/', $documentId);
        $data_list =DB::table('kasdoc')
        ->join('storejk', 'kasdoc.store', '=', 'storejk.kodestore')
        ->select('kasdoc.*', 'storejk.*')
        ->where('kasdoc.docno', $nodoc)
        ->get();
        $lokasi = Lokasi::all();
        $data_jenis = JenisBiaya::all();
        $data_casj = Cashjudex::all();
        $data_bagian = SdmKdbag::all();
        $data_account = DB::select("SELECT kodeacct,descacct from account where length(kodeacct)=6 and kodeacct not like '%x%'");
        $count= Kasline::where('docno', $nodoc)->where('keterangan','<>','PENUTUP')->sum('totprice');
        $data_detail = DB::select("SELECT * from kasline where docno ='$nodoc' and keterangan <> 'PENUTUP' order by lineno");
        $no_detail = Kasline::where('docno', $nodoc)->max('lineno');

        if ($no_detail <> null) {
            $no_urut = $no_detail + 1;
        } else {
            $no_urut = 1;
        }

        return view('modul-treasury.bukti-kas.edit', compact(
            'data_list',
            'data_bagian',
            'data_detail',
            'count',
            'no_urut',
            'lokasi',
            'data_account',
            'data_jenis',
            'data_casj'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Kasdoc::where('docno', $request->nodok)
            ->update([
                'thnbln' =>  $request->bulanbuku,
                'jk' =>  $request->jk,
                'store' =>  $request->lokasi,
                'ci' =>  $request->ci,
                'voucher' =>  $request->nobukti,
                'kepada' =>  $request->kepada,
                'rate' =>  $request->kurs,
                'nilai_dok' =>  str_replace(',', '.', $request->nilai),
                'ket1' =>  $request->ket1,
                'ket2' =>  $request->ket2,
                'ket3' =>  $request->ket3,
                'mrs_no' =>  $request->nover ,
            ]);
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data_rskas = DB::select("SELECT thnbln from kasdoc a where a.docno='$request->nodok'");
        foreach ($data_rskas as $data_kas) {
            $data_rsbulan = DB::select("SELECT * from timetrans where thnbln='$data_kas->thnbln' and suplesi='0'");
            if (!empty($data_rsbulan)) {
                foreach ($data_rsbulan as $data_bulan) {
                    if ($data_bulan->status == '1') {
                        $stbbuku = '1';//gtopening
                    } elseif ($data_bulan->status == '2') {
                        $stbbuku = '2';//gtstopping
                    } elseif ($data_bulan->status == '3') {
                        $stbbuku = '3';//gtclosing
                    } else {
                        $stbbuku = '4';//gtnone
                    }
                }
            } else {
                $stbbuku = 'gtnone';
            }
            if ($stbbuku > 1) {
                $data = 2;
                return response()->json($data);
            } else {
                $data_rscekbayar = DB::select("SELECT paid from kasdoc where docno='$request->nodok'");
                foreach ($data_rscekbayar as $data_cekbayar) {
                    if ($data_cekbayar->paid == 'Y') {
                        $data = 3;
                        return response()->json($data);
                    } else {
                        Kasdoc::where('docno', $request->nodok)->delete();
                        Kasline::where('docno', $request->nodok)->delete();
                        Mtrdeposito::where('docno', $request->nodok)->delete();
                        DtlDepositoTest::where('docno', $request->nodok)->delete();
                        $data = 1;
                        return response()->json($data);
                    }
                }
            }
        }
    }

    public function export(Request $request)
    {
        $kasdoc = Kasdoc::where('docno', $request->no_dokumen)
            ->with(['kasline' => function ($query) {
                $query->orderBy('lineno', 'ASC');
            }])
            ->withSum('kasline', 'totprice')
            ->firstOrFail();

        // return $kasdoc;

        if (substr(strtoupper($request->no_dokumen), 0, 1) == 'P') {
            // return default PDF
            $pdf = PDF::loadview('modul-treasury.bukti-kas.kas-putih-pdf', compact(
                'kasdoc'
            ))->setOption("footer-right", "Page [page] from [topage]");

            return $pdf->stream('bkp_'.date('Y-m-d H:i:s').'.pdf');
        } else {
            // return default PDF
            $pdf = PDF::loadview('modul-treasury.bukti-kas.kas-merah-pdf', compact(
                'kasdoc'
            ))->setOption("footer-right", "Page [page] from [topage]");

            return $pdf->stream('bkm_'.date('Y-m-d H:i:s').'.pdf');
        }
    }
}
