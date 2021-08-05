<?php

//Kontroler

use App\Http\Controllers\Kontroler\BulanKontrolerController;
use App\Http\Controllers\Kontroler\CashJudexController;
use App\Http\Controllers\Kontroler\JenisBiayaController;
use App\Http\Controllers\Kontroler\JurnalUmumController;
use App\Http\Controllers\Kontroler\KasBankKontrolerController;
use App\Http\Controllers\Kontroler\LokasiKontrolerController;
use App\Http\Controllers\Kontroler\MainAccountController;
use App\Http\Controllers\Kontroler\MasterPegawaiController;
use App\Http\Controllers\Kontroler\MasterPerusahaanController;
use App\Http\Controllers\Kontroler\MasterUnitController;
use App\Http\Controllers\Kontroler\PostingKasBankController;
use App\Http\Controllers\Kontroler\ReportKontrolerController;
use App\Http\Controllers\Kontroler\SandiPerkiraanController;
use App\Http\Controllers\Kontroler\TabelDepositoController;
use Illuminate\Routing\RouteGroup;

Route::prefix('kontroler')->name('modul_kontroler.')->group(function () {

    //jurnam_umum
    // Route assigned name "jurnal_umum.index"...
    Route::name('jurnal_umum.')->group(function () {
        Route::get('jurnal-umum', [JurnalUmumController::class, 'index'])->name('index');
        Route::post('jurnal-umum/index-json', [JurnalUmumController::class, 'indexJson'])->name('index.json');
        Route::get('jurnal-umum/create', [JurnalUmumController::class, 'create'])->name('create');
        Route::post('jurnal-umum/store', [JurnalUmumController::class, 'store'])->name('store');
        Route::get('jurnal-umum/edit/{no}', [JurnalUmumController::class, 'edit'])->name('edit');
        Route::post('jurnal-umum/update', [JurnalUmumController::class, 'update'])->name('update');
        Route::delete('jurnal-umum/delete', [JurnalUmumController::class, 'delete'])->name('delete');
        Route::get('jurnal-umum/editdetail/{no}/{id}', [JurnalUmumController::class, 'editDetail'])->name('edit.detail');
        Route::post('jurnal-umum/update/detail', [JurnalUmumController::class, 'updateDetail'])->name('update.detail');
        Route::delete('jurnal-umum/delete/detail', [JurnalUmumController::class, 'deleteDetail'])->name('delete.detail');
        Route::get('jurnal-umum/copy', [JurnalUmumController::class, 'cpyjurnalumum'])->name('cpyjurnalumum');
        Route::post('jurnal-umum/store/detail', [JurnalUmumController::class, 'storeDetail'])->name('store.detail');
        Route::get('jurnal-umum/posting/{no}/{status}', [JurnalUmumController::class, 'posting'])->name('posting');
        Route::post('jurnal-umum/store/posting', [JurnalUmumController::class, 'storePosting'])->name('store.posting');
        Route::get('jurnal-umum/copy/{no}', [JurnalUmumController::class, 'copy'])->name('copy');
        Route::post('jurnal-umum/store/copy', [JurnalUmumController::class, 'storeCopy'])->name('store.copy');
        Route::get('jurnal-umum/rekap/{docno}', [JurnalUmumController::class, 'rekap'])->name('rekap');
        Route::post('jurnal-umum/export', [JurnalUmumController::class, 'export'])->name('export');
    });
    //end jurnam_umum


    //postingan Kas Bank
    // Route assigned name "postingan-kas-bank.index"...
    Route::name('postingan_kas_bank.')->group(function () {
        Route::get('postingan-kas-bank', [PostingKasBankController::class, 'index'])->name('index');
        Route::get('postingan-kas-bank/verkas/{no}/{id}', [PostingKasBankController::class, 'verkas'])->name('verkas');
        Route::get('postingan-kas-bank/verkass', [PostingKasBankController::class, 'verkass'])->name('verkass');
        Route::get('postingan-kas-bank/verkas/json', [PostingKasBankController::class, 'verkasJson'])->name('verkasjson');
        Route::get('postingan-kas-bank/editdetail/{no}/{id}', [PostingKasBankController::class, 'editdetail'])->name('editdetail');
        Route::get('postingan-kas-bank/prsposting', [PostingKasBankController::class, 'prsposting'])->name('prsposting');
        Route::get('postingan-kas-bank/btlposting', [PostingKasBankController::class, 'btlposting'])->name('btlposting');
        Route::post('postingan-kas-bank/index-json', [PostingKasBankController::class, 'indexJson'])->name('index.json');
        Route::post('postingan-kas-bank/store/verkas', [PostingKasBankController::class, 'store'])->name('store.verkas');
        Route::post('postingan-kas-bank/verifikasi', [PostingKasBankController::class, 'verifikasi'])->name('verifikasi');
        Route::post('postingan-kas-bank/store/detail', [PostingKasBankController::class, 'storeDetail'])->name('store.detail');
        Route::post('postingan-kas-bank/update/detail', [PostingKasBankController::class, 'updateDetail'])->name('update.detail');
        Route::post('postingan-kas-bank/store/prsposting', [PostingKasBankController::class, 'storePrsposting'])->name('store.prsposting');
        Route::post('postingan-kas-bank/store/btlposting', [PostingKasBankController::class, 'storeBtlposting'])->name('store.btlposting');
        Route::delete('postingan-kas-bank/delete/detail', [PostingKasBankController::class, 'deleteDetail'])->name('delete.detail');
    });
    //end postingan Kas Bank


    //Master Perusahaan
    // Route assigned name "master_perusahaan.index"...
    Route::name('master_perusahaan.')->group(function () {
        Route::get('master-perusahaan', [MasterPerusahaanController::class, 'index'])->name('index');
        Route::get('master-perusahaan/index/json', [MasterPerusahaanController::class, 'indexJson'])->name('index.json');
        Route::get('master-perusahaan/create', [MasterPerusahaanController::class, 'create'])->name('create');
        Route::post('master-perusahaan/store', [MasterPerusahaanController::class, 'store'])->name('store');
        Route::get('master-perusahaan/edit/{kode}', [MasterPerusahaanController::class, 'edit'])->name('edit');
        Route::post('master-perusahaan/update', [MasterPerusahaanController::class, 'update'])->name('update');
        Route::delete('master-perusahaan/delete', [MasterPerusahaanController::class, 'delete'])->name('delete');
    });
    //end Master Perusahaan


    //Master unit
    // Route assigned name "master_unit.index"...
    Route::name('master_unit.')->group(function () {
        Route::get('master-unit', [MasterUnitController::class, 'index'])->name('index');
        Route::get('master-unit/index/json', [MasterUnitController::class, 'indexJson'])->name('index.json');
        Route::get('master-unit/create', [MasterUnitController::class, 'create'])->name('create');
        Route::post('master-unit/store', [MasterUnitController::class, 'store'])->name('store');
        Route::get('master-unit/edit/{kode}', [MasterUnitController::class, 'edit'])->name('edit');
        Route::post('master-unit/update', [MasterUnitController::class, 'update'])->name('update');
        Route::delete('master-unit/delete', [MasterUnitController::class, 'delete'])->name('delete');
    });
    //end Master unit


    //Master Pekerja
    // Route assigned name "master_pekerja.index"...
    Route::name('master_pekerja.')->group(function () {
        Route::get('master-pekerja', [MasterPegawaiController::class, 'index'])->name('index');
        Route::get('master-pekerja/index/json', [MasterPegawaiController::class, 'indexJson'])->name('index.json');
        Route::get('master-pekerja/create', [MasterPegawaiController::class, 'create'])->name('create');
        Route::post('master-pekerja/store', [MasterPegawaiController::class, 'store'])->name('store');
        Route::get('master-pekerja/edit/{kode}', [MasterPegawaiController::class, 'edit'])->name('edit');
        Route::post('master-pekerja/update', [MasterPegawaiController::class, 'update'])->name('update');
        Route::delete('master-pekerja/delete', [MasterPegawaiController::class, 'delete'])->name('delete');
    });
    //end Master Pekerja



    //cetak-kas-bank
    // Route assigned name "cetak_kas_bank.index"...
    Route::name('cetak_kas_bank.')->group(function () {
        Route::get('cetak-kas-bank', [KasBankKontrolerController::class, 'indexCetak'])->name('index');
        Route::post('cetak-kas-bank/index/index-json', [KasBankKontrolerController::class, 'searchIndexCetak'])->name('search.cetak.index');
        Route::get('cetak-kas-bank/rekap/{id}', [KasBankKontrolerController::class, 'rekap'])->name('rekap');
        Route::post('cetak-kas-bank/export', [KasBankKontrolerController::class, 'export'])->name('export');
    });
    //end cetak-kas-bank

    //tabel_deposito
    // Route assigned name "tabel_deposito.index"...
    Route::name('tabel_deposito.')->group(function () {
        Route::get('tabel-deposito', [TabelDepositoController::class, 'index'])->name('index');
        Route::post('tabel-deposito/index/index-json', [TabelDepositoController::class, 'indexJson'])->name('index.json');
        Route::get('tabel-deposito/rekap/{no}/{id}', [TabelDepositoController::class, 'rekap'])->name('rekap');
        Route::post('tabel-deposito/export', [TabelDepositoController::class, 'export'])->name('export');
    });
    //end tabel_deposito

    // Tabel 
    Route::prefix('tabel.')->group(function () {

        //cash_judex
        // Route assigned name "cash_judex.index"...
        Route::name('cash_judex.')->group(function () {
            Route::get('cash-judex', [CashJudexController::class, 'index'])->name('index');
            Route::post('cash-judex/index/index-json', [CashJudexController::class, 'indexJson'])->name('index.json');
            Route::get('cash-judex/create', [CashJudexController::class, 'create'])->name('create');
            Route::post('cash-judex/store', [CashJudexController::class, 'store'])->name('store');
            Route::get('cash-judex/edit/{no}', [CashJudexController::class, 'edit'])->name('edit');
            Route::post('cash-judex/update', [CashJudexController::class, 'update'])->name('update');
            Route::delete('cash-judex/delete', [CashJudexController::class, 'delete'])->name('delete');
        });
        //end cash_judex
    
    
        //jenis_biaya
        // Route assigned name "jenis_biaya.index"...
        Route::name('jenis_biaya.')->group(function () {
            Route::get('jenis-biaya', [JenisBiayaController::class, 'index'])->name('index');
            Route::post('jenis-biaya/index/index-json', [JenisBiayaController::class, 'indexJson'])->name('index.json');
            Route::get('jenis-biaya/create', [JenisBiayaController::class, 'create'])->name('create');
            Route::post('jenis-biaya/store', [JenisBiayaController::class, 'store'])->name('store');
            Route::get('jenis-biaya/edit/{no}', [JenisBiayaController::class, 'edit'])->name('edit');
            Route::post('jenis-biaya/update', [JenisBiayaController::class, 'update'])->name('update');
            Route::delete('jenis-biaya/delete', [JenisBiayaController::class, 'delete'])->name('delete');
        });
        //end jenis_biaya
        
        //kas_bank_kontroler
        // Route assigned name "kas_bank_kontroler.index"...
        Route::name('kas_bank_kontroler.')->group(function () {
            Route::get('kas-bank-kontroler', [KasBankKontrolerController::class, 'index'])->name('index');
            Route::post('kas-bank-kontroler/index/index-json', [KasBankKontrolerController::class, 'indexJson'])->name('index.json');
            Route::get('kas-bank-kontroler/create', [KasBankKontrolerController::class, 'create'])->name('create');
            Route::post('kas-bank-kontroler/store', [KasBankKontrolerController::class, 'store'])->name('store');
            Route::get('kas-bank-kontroler/edit/{no}', [KasBankKontrolerController::class, 'edit'])->name('edit');
            Route::post('kas-bank-kontroler/update', [KasBankKontrolerController::class, 'update'])->name('update');
            Route::delete('kas-bank-kontroler/delete', [KasBankKontrolerController::class, 'delete'])->name('delete');
        });
        //end kas_bank_kontroler
        
        //lokasi_kontroler
        // Route assigned name "lokasi_kontroler.index"...
        Route::name('lokasi_kontroler.')->group(function () {
            Route::get('lokasi-kontroler', [LokasiKontrolerController::class, 'index'])->name('index');
            Route::post('lokasi-kontroler/index/index-json', [LokasiKontrolerController::class, 'indexJson'])->name('index.json');
            Route::get('lokasi-kontroler/create', [LokasiKontrolerController::class, 'create'])->name('create');
            Route::post('lokasi-kontroler/store', [LokasiKontrolerController::class, 'store'])->name('store');
            Route::get('lokasi-kontroler/edit/{no}', [LokasiKontrolerController::class, 'edit'])->name('edit');
            Route::post('lokasi-kontroler/update', [LokasiKontrolerController::class, 'update'])->name('update');
            Route::delete('lokasi-kontroler/delete', [LokasiKontrolerController::class, 'delete'])->name('delete');
        });
        //end lokasi_kontroler
    
        //sandi_perkiraan
        // Route assigned name "sandi_perkiraan.index"...
        Route::name('sandi_perkiraan.')->group(function () {
            Route::get('sandi-perkiraan', [SandiPerkiraanController::class, 'index'])->name('index');
            Route::post('sandi-perkiraan/index/index-json', [SandiPerkiraanController::class, 'indexJson'])->name('index.json');
            Route::get('sandi-perkiraan/create', [SandiPerkiraanController::class, 'create'])->name('create');
            Route::post('sandi-perkiraan/store', [SandiPerkiraanController::class, 'store'])->name('store');
            Route::get('sandi-perkiraan/edit/{no}', [SandiPerkiraanController::class, 'edit'])->name('edit');
            Route::post('sandi-perkiraan/update', [SandiPerkiraanController::class, 'update'])->name('update');
            Route::delete('sandi-perkiraan/delete', [SandiPerkiraanController::class, 'delete'])->name('delete');
        });
        //end sandi_perkiraan
    
        //bulan_kontroler
        // Route assigned name "bulan_kontroler.index"...
        Route::name('bulan_kontroler.')->group(function () {
            Route::get('bulan-kontroler', [BulanKontrolerController::class, 'index'])->name('index');
            Route::post('bulan-kontroler/index/index-json', [BulanKontrolerController::class, 'indexJson'])->name('index.json');
            Route::get('bulan-kontroler/create', [BulanKontrolerController::class, 'create'])->name('create');
            Route::post('bulan-kontroler/store', [BulanKontrolerController::class, 'store'])->name('store');
            Route::get('bulan-kontroler/edit/{no}', [BulanKontrolerController::class, 'edit'])->name('edit');
            Route::post('bulan-kontroler/update', [BulanKontrolerController::class, 'update'])->name('update');
            Route::delete('bulan-kontroler/delete', [BulanKontrolerController::class, 'delete'])->name('delete');
        });
        //end bulan_kontroler
    
        //main_account
        // Route assigned name "main_account.index"...
        Route::name('main_account.')->group(function () {
            Route::get('main-account', [MainAccountController::class, 'index'])->name('index');
            Route::post('main-account/index/index-json', [MainAccountController::class, 'indexJson'])->name('index.json');
            Route::get('main-account/create', [MainAccountController::class, 'create'])->name('create');
            Route::post('main-account/store', [MainAccountController::class, 'store'])->name('store');
            Route::get('main-account/edit/{no}', [MainAccountController::class, 'edit'])->name('edit');
            Route::post('main-account/update', [MainAccountController::class, 'update'])->name('update');
            Route::delete('main-account/delete', [MainAccountController::class, 'delete'])->name('delete');
        });
        
    });
    //end main_account

    
    //d2_perbulan
    // Route assigned name "d2_perbulan.index"...
    Route::name('d2_perbulan.')->group(function () {
        Route::get('d2-perbulan', [ReportKontrolerController::class, 'create_d2_perbulan'])->name('create_d2_perbulan');
        Route::get('d2-perbulan/search/account', [ReportKontrolerController::class, 'searchAccount'])->name('search.account');
        Route::get('d2-perbulan/export', [ReportKontrolerController::class, 'd2PerBulanExport'])->name('export');
    });
    //end d2_perbulan
    
    //d2_periode
    // Route assigned name "d2_periode.index"...
    Route::name('d2_periode.')->group(function () {
        Route::get('d2-periode', [ReportKontrolerController::class, 'create_d2_periode'])->name('create_d2_periode');
        Route::get('d2-periode/search/account', [ReportKontrolerController::class, 'searchAccount'])->name('search.account');
        Route::get('d2-periode/export', [ReportKontrolerController::class, 'd2PerPeriodeExport'])->name('export');
    });
    //end d2_periode
    
    //d5_report
    // Route assigned name "d5_report.index"...
    Route::name('d5_report.')->group(function () {
        Route::get('d5-report', [ReportKontrolerController::class, 'create_d5_report'])->name('create_d5_report');
        Route::get('d5-report/search/account', [ReportKontrolerController::class, 'searchAccount'])->name('search.account');
        Route::post('d5-report/export', [ReportKontrolerController::class, 'exportD5'])->name('export');
    });
    //end d5_report

    //neraca_konsolidasi
    // Route assigned name "neraca_konsolidasi.index"...
    Route::name('neraca_konsolidasi.')->group(function () {
        Route::get('neraca-konsolidasi', [ReportKontrolerController::class, 'create_neraca_konsolidasi'])->name('create_neraca_konsolidasi');
        Route::post('neraca-konsolidasi/export', [ReportKontrolerController::class, 'exportNeracaKonsolidasi'])->name('export');
    });
    //end neraca_konsolidasi
    
    //neraca_detail
    // Route assigned name "neraca_detail.index"...
    Route::name('neraca_detail.')->group(function () {
        Route::get('neraca-detail', [ReportKontrolerController::class, 'create_neraca_detail'])->name('create_neraca_detail');
        Route::post('neraca-detail/export', [ReportKontrolerController::class, 'exportNeracaDetail'])->name('export');
    });
    //end neraca_detail

    //laba_rugi_konsolidasi
    // Route assigned name "laba_rugi_konsolidasi.index"...
    Route::name('laba_rugi_konsolidasi.')->group(function () {
        Route::get('laba-rugi-konsolidasi', [ReportKontrolerController::class, 'create_laba_rugi_konsolidasi'])->name('create_laba_rugi_konsolidasi');
        Route::post('laba-rugi-konsolidasi/export', [ReportKontrolerController::class, 'exportLabaRugiKonsolidasi'])->name('export.laba.rugi.konsolidasi');
    });
    //end laba_rugi_konsolidasi
    
    //laba_rugi_detail
    // Route assigned name "laba_rugi_detail.index"...
    Route::name('laba_rugi_detail.')->group(function () {
        Route::get('laba-rugi-detail', [ReportKontrolerController::class, 'create_laba_rugi_detail'])->name('create_laba_rugi_detail');
        Route::post('laba-rugi-detail/export', [ReportKontrolerController::class, 'exportLabaRugiDetail'])->name('export.laba.rugi.detail');
    });

    //end laporan_keuangan
    //laporan_keuangan
    // Route assigned name "laporan_keuangan.index"...
    Route::name('laporan_keuangan.')->group(function () {
        Route::get('laporan-keuangan', [ReportKontrolerController::class, 'create_laporan_keuangan'])->name('create_laporan_keuangan');
        Route::get('laporan-keuangan/export', [ReportKontrolerController::class, 'laporanKeuanganExport'])->name('export');
    });
    //end laporan_keuangan

    //end biaya_pegawai
    //biaya_pegawai
    // Route assigned name "biaya_pegawai.index"...
    Route::name('biaya_pegawai.')->group(function () {
        Route::get('biaya-pegawai', [ReportKontrolerController::class, 'create_biaya_pegawai'])->name('create_biaya_pegawai');
        Route::post('biaya-pegawai/export', [ReportKontrolerController::class, 'exportBiayaPegawai'])->name('export_biaya_pegawai');
    });
    //end biaya_pegawai
});
