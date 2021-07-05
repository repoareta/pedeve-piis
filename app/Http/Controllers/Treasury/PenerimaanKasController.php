<?php

namespace App\Http\Controllers\Treasury;

use App\Http\Controllers\Controller;
use App\Models\SaldoStore;
use App\Services\PenerimaanKasService;
use App\Services\TimeTransactionService;
use DB;
use Illuminate\Http\Request;

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
        $tahun = $this->timeTrans->getCurrentYear();
        $bulan = $this->timeTrans->getCurrentMonth();
        $daftarBulan = $this->timeTrans->getAllMonths();

        return view('modul-treasury.bukti-kas.index', compact('tahun', 'bulan', 'daftarBulan'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request)
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
