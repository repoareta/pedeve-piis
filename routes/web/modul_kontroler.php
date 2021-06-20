<?php

//Kontroler
Route::prefix('kontroler')->group(function () {

    //jurnam_umum
    // Route assigned name "jurnal_umum.index"...
    Route::name('jurnal_umum.')->group(function () {
        Route::get('jurnal-umum', 'JurnalUmumController@index')->name('index');
        Route::post('jurnal-umum/search', 'JurnalUmumController@searchIndex')->name('search.index');
        Route::get('jurnal-umum/create', 'JurnalUmumController@create')->name('create');
        Route::post('jurnal-umum/store', 'JurnalUmumController@store')->name('store');
        Route::get('jurnal-umum/edit/{no}', 'JurnalUmumController@edit')->name('edit');
        Route::post('jurnal-umum/update', 'JurnalUmumController@update')->name('update');
        Route::delete('jurnal-umum/delete', 'JurnalUmumController@delete')->name('delete');
        Route::get('jurnal-umum/editdetail/{no}/{id}', 'JurnalUmumController@editDetail')->name('editdetail');
        Route::post('jurnal-umum/update/detail', 'JurnalUmumController@updateDetail')->name('update.detail');
        Route::delete('jurnal-umum/delete/detail', 'JurnalUmumController@deleteDetail')->name('delete.detail');
        Route::get('jurnal-umum/copy', 'JurnalUmumController@cpyjurnalumum')->name('cpyjurnalumum');
        Route::post('jurnal-umum/store/detail', 'JurnalUmumController@storeDetail')->name('store.detail');
        Route::get('jurnal-umum/posting/{no}/{status}', 'JurnalUmumController@posting')->name('posting');
        Route::post('jurnal-umum/store/posting', 'JurnalUmumController@storePosting')->name('store.posting');
        Route::get('jurnal-umum/copy/{no}', 'JurnalUmumController@copy')->name('copy');
        Route::post('jurnal-umum/store/copy', 'JurnalUmumController@storeCopy')->name('store.copy');
        Route::get('jurnal-umum/rekap/{docno}', 'JurnalUmumController@rekap')->name('rekap');
        Route::post('jurnal-umum/export', 'JurnalUmumController@export')->name('export');
    });
    //end jurnam_umum


    //postingan Kas Bank
    // Route assigned name "postingan-kas-bank.index"...
    Route::name('postingan_kas_bank.')->group(function () {
        Route::get('postingan-kas-bank', 'PostingKasBankController@index')->name('index');
        Route::get('postingan-kas-bank/verkas/{no}/{id}', 'PostingKasBankController@verkas')->name('verkas');
        Route::get('postingan-kas-bank/verkass', 'PostingKasBankController@verkass')->name('verkass');
        Route::get('postingan-kas-bank/verkas/json', 'PostingKasBankController@verkasJson')->name('verkasjson');
        Route::get('postingan-kas-bank/editdetail/{no}/{id}', 'PostingKasBankController@editdetail')->name('editdetail');
        Route::get('postingan-kas-bank/prsposting', 'PostingKasBankController@prsposting')->name('prsposting');
        Route::get('postingan-kas-bank/btlposting', 'PostingKasBankController@btlposting')->name('btlposting');
        Route::post('postingan-kas-bank/search', 'PostingKasBankController@searchIndex')->name('search.index');
        Route::post('postingan-kas-bank/store/verkas', 'PostingKasBankController@store')->name('store.verkas');
        Route::post('postingan-kas-bank/verifikasi', 'PostingKasBankController@verifikasi')->name('verifikasi');
        Route::post('postingan-kas-bank/store/detail', 'PostingKasBankController@storeDetail')->name('store.detail');
        Route::post('postingan-kas-bank/update/detail', 'PostingKasBankController@updateDetail')->name('update.detail');
        Route::post('postingan-kas-bank/store/prsposting', 'PostingKasBankController@storePrsposting')->name('store.prsposting');
        Route::post('postingan-kas-bank/store/btlposting', 'PostingKasBankController@storeBtlposting')->name('store.btlposting');
        Route::delete('postingan-kas-bank/delete/detail', 'PostingKasBankController@deleteDetail')->name('delete.detail');
    });
    //end postingan Kas Bank


    //Master Perusahaan
    // Route assigned name "master_perusahaan.index"...
    Route::name('master_perusahaan.')->group(function () {
        Route::get('master-perusahaan', 'MasterPerusahaanController@index')->name('index');
        Route::get('master-perusahaan/index/json', 'MasterPerusahaanController@indexJson')->name('index.json');
        Route::get('master-perusahaan/create', 'MasterPerusahaanController@create')->name('create');
        Route::post('master-perusahaan/store', 'MasterPerusahaanController@store')->name('store');
        Route::get('master-perusahaan/edit/{kode}', 'MasterPerusahaanController@edit')->name('edit');
        Route::post('master-perusahaan/update', 'MasterPerusahaanController@update')->name('update');
        Route::delete('master-perusahaan/delete', 'MasterPerusahaanController@delete')->name('delete');
    });
    //end Master Perusahaan


    //Master unit
    // Route assigned name "master_unit.index"...
    Route::name('master_unit.')->group(function () {
        Route::get('master-unit', 'MasterUnitController@index')->name('index');
        Route::get('master-unit/index/json', 'MasterUnitController@indexJson')->name('index.json');
        Route::get('master-unit/create', 'MasterUnitController@create')->name('create');
        Route::post('master-unit/store', 'MasterUnitController@store')->name('store');
        Route::get('master-unit/edit/{kode}', 'MasterUnitController@edit')->name('edit');
        Route::post('master-unit/update', 'MasterUnitController@update')->name('update');
        Route::delete('master-unit/delete', 'MasterUnitController@delete')->name('delete');
    });
    //end Master unit


    //Master Pekerja
    // Route assigned name "master_pekerja.index"...
    Route::name('master_pekerja.')->group(function () {
        Route::get('master-pekerja', 'MasterPekerjaController@index')->name('index');
        Route::get('master-pekerja/index/json', 'MasterPekerjaController@indexJson')->name('index.json');
        Route::get('master-pekerja/create', 'MasterPekerjaController@create')->name('create');
        Route::post('master-pekerja/store', 'MasterPekerjaController@store')->name('store');
        Route::get('master-pekerja/edit/{kode}', 'MasterPekerjaController@edit')->name('edit');
        Route::post('master-pekerja/update', 'MasterPekerjaController@update')->name('update');
        Route::delete('master-pekerja/delete', 'MasterPekerjaController@delete')->name('delete');
    });
    //end Master Pekerja



    //cetak-kas-bank
    // Route assigned name "cetak_kas_bank.index"...
    Route::name('cetak_kas_bank.')->group(function () {
        Route::get('cetak-kas-bank', 'KasBankKontrolerController@indexCetak')->name('index');
        Route::post('cetak-kas-bank/index/search', 'KasBankKontrolerController@searchIndexCetak')->name('search.cetak.index');
        Route::get('cetak-kas-bank/rekap/{id}', 'KasBankKontrolerController@rekap')->name('rekap');
        Route::post('cetak-kas-bank/export', 'KasBankKontrolerController@export')->name('export');
    });
    //end cetak-kas-bank

    //tabel_deposito
    // Route assigned name "tabel_deposito.index"...
    Route::name('tabel_deposito.')->group(function () {
        Route::get('tabel_deposito', 'TabelDepositoController@index')->name('index');
        Route::post('tabel_deposito/index/search', 'TabelDepositoController@searchIndex')->name('search.index');
        Route::get('tabel_deposito/rekap/{no}/{id}', 'TabelDepositoController@rekap')->name('rekap');
        Route::post('tabel_deposito/export', 'TabelDepositoController@export')->name('export');
    });
    //end tabel_deposito


    //cash_judex
    // Route assigned name "cash_judex.index"...
    Route::name('cash_judex.')->group(function () {
        Route::get('cash_judex', 'CashJudexController@index')->name('index');
        Route::post('cash_judex/index/search', 'CashJudexController@searchIndex')->name('search.index');
        Route::get('cash_judex/create', 'CashJudexController@create')->name('create');
        Route::post('cash_judex/store', 'CashJudexController@store')->name('store');
        Route::get('cash_judex/edit/{no}', 'CashJudexController@edit')->name('edit');
        Route::post('cash_judex/update', 'CashJudexController@update')->name('update');
        Route::delete('cash_judex/delete', 'CashJudexController@delete')->name('delete');
    });
    //end cash_judex


    //jenis_biaya
    // Route assigned name "jenis_biaya.index"...
    Route::name('jenis_biaya.')->group(function () {
        Route::get('jenis_biaya', 'JenisBiayaController@index')->name('index');
        Route::post('jenis_biaya/index/search', 'JenisBiayaController@searchIndex')->name('search.index');
        Route::get('jenis_biaya/create', 'JenisBiayaController@create')->name('create');
        Route::post('jenis_biaya/store', 'JenisBiayaController@store')->name('store');
        Route::get('jenis_biaya/edit/{no}', 'JenisBiayaController@edit')->name('edit');
        Route::post('jenis_biaya/update', 'JenisBiayaController@update')->name('update');
        Route::delete('jenis_biaya/delete', 'JenisBiayaController@delete')->name('delete');
    });
    //end jenis_biaya
    
    //kas_bank_kontroler
    // Route assigned name "kas_bank_kontroler.index"...
    Route::name('kas_bank_kontroler.')->group(function () {
        Route::get('kas_bank_kontroler', 'KasBankKontrolerController@index')->name('index');
        Route::post('kas_bank_kontroler/index/search', 'KasBankKontrolerController@searchIndex')->name('search.index');
        Route::get('kas_bank_kontroler/create', 'KasBankKontrolerController@create')->name('create');
        Route::post('kas_bank_kontroler/store', 'KasBankKontrolerController@store')->name('store');
        Route::get('kas_bank_kontroler/edit/{no}', 'KasBankKontrolerController@edit')->name('edit');
        Route::post('kas_bank_kontroler/update', 'KasBankKontrolerController@update')->name('update');
        Route::delete('kas_bank_kontroler/delete', 'KasBankKontrolerController@delete')->name('delete');
    });
    //end kas_bank_kontroler
    
    //lokasi_kontroler
    // Route assigned name "lokasi_kontroler.index"...
    Route::name('lokasi_kontroler.')->group(function () {
        Route::get('lokasi_kontroler', 'LokasiKontrolerController@index')->name('index');
        Route::post('lokasi_kontroler/index/search', 'LokasiKontrolerController@searchIndex')->name('search.index');
        Route::get('lokasi_kontroler/create', 'LokasiKontrolerController@create')->name('create');
        Route::post('lokasi_kontroler/store', 'LokasiKontrolerController@store')->name('store');
        Route::get('lokasi_kontroler/edit/{no}', 'LokasiKontrolerController@edit')->name('edit');
        Route::post('lokasi_kontroler/update', 'LokasiKontrolerController@update')->name('update');
        Route::delete('lokasi_kontroler/delete', 'LokasiKontrolerController@delete')->name('delete');
    });
    //end lokasi_kontroler


    //sandi_perkiraan
    // Route assigned name "sandi_perkiraan.index"...
    Route::name('sandi_perkiraan.')->group(function () {
        Route::get('sandi_perkiraan', 'SandiPerkiraanController@index')->name('index');
        Route::post('sandi_perkiraan/index/search', 'SandiPerkiraanController@searchIndex')->name('search.index');
        Route::get('sandi_perkiraan/create', 'SandiPerkiraanController@create')->name('create');
        Route::post('sandi_perkiraan/store', 'SandiPerkiraanController@store')->name('store');
        Route::get('sandi_perkiraan/edit/{no}', 'SandiPerkiraanController@edit')->name('edit');
        Route::post('sandi_perkiraan/update', 'SandiPerkiraanController@update')->name('update');
        Route::delete('sandi_perkiraan/delete', 'SandiPerkiraanController@delete')->name('delete');
    });
    //end sandi_perkiraan

    //bulan_kontroler
    // Route assigned name "bulan_kontroler.index"...
    Route::name('bulan_kontroler.')->group(function () {
        Route::get('bulan_kontroler', 'BulanKontrolerController@index')->name('index');
        Route::post('bulan_kontroler/index/search', 'BulanKontrolerController@searchIndex')->name('search.index');
        Route::get('bulan_kontroler/create', 'BulanKontrolerController@create')->name('create');
        Route::post('bulan_kontroler/store', 'BulanKontrolerController@store')->name('store');
        Route::get('bulan_kontroler/edit/{no}', 'BulanKontrolerController@edit')->name('edit');
        Route::post('bulan_kontroler/update', 'BulanKontrolerController@update')->name('update');
        Route::delete('bulan_kontroler/delete', 'BulanKontrolerController@delete')->name('delete');
    });
    //end bulan_kontroler


    //main_account
    // Route assigned name "main_account.index"...
    Route::name('main_account.')->group(function () {
        Route::get('main_account', 'MainAccountController@index')->name('index');
        Route::post('main_account/index/search', 'MainAccountController@searchIndex')->name('search.index');
        Route::get('main_account/create', 'MainAccountController@create')->name('create');
        Route::post('main_account/store', 'MainAccountController@store')->name('store');
        Route::get('main_account/edit/{no}', 'MainAccountController@edit')->name('edit');
        Route::post('main_account/update', 'MainAccountController@update')->name('update');
        Route::delete('main_account/delete', 'MainAccountController@delete')->name('delete');
    });
    //end main_account

    
    //d2_perbulan
    // Route assigned name "d2_perbulan.index"...
    Route::name('d2_perbulan.')->group(function () {
        Route::get('d2_perbulan', 'ReportKontrolerController@create_d2_perbulan')->name('create_d2_perbulan');
        Route::get('d2_perbulan/search/account', 'ReportKontrolerController@searchAccount')->name('search.account');
        Route::get('d2_perbulan/export', 'ReportKontrolerController@d2PerBulanExport')->name('export');
    });
    //end d2_perbulan
    
    //d2_periode
    // Route assigned name "d2_periode.index"...
    Route::name('d2_periode.')->group(function () {
        Route::get('d2_periode', 'ReportKontrolerController@create_d2_periode')->name('create_d2_periode');
        Route::get('d2_periode/search/account', 'ReportKontrolerController@searchAccount')->name('search.account');
        Route::get('d2_periode/export', 'ReportKontrolerController@d2PerPeriodeExport')->name('export');
    });
    //end d2_periode
    
    //d5_report
    // Route assigned name "d5_report.index"...
    Route::name('d5_report.')->group(function () {
        Route::get('d5_report', 'ReportKontrolerController@create_d5_report')->name('create_d5_report');
        Route::get('d5_report/search/account', 'ReportKontrolerController@searchAccount')->name('search.account');
        Route::post('d5_report/export', 'ReportKontrolerController@exportD5')->name('export');
    });
    //end d5_report

    //neraca_konsolidasi
    // Route assigned name "neraca_konsolidasi.index"...
    Route::name('neraca_konsolidasi.')->group(function () {
        Route::get('neraca_konsolidasi', 'ReportKontrolerController@create_neraca_konsolidasi')->name('create_neraca_konsolidasi');
        Route::post('neraca_konsolidasi/export', 'ReportKontrolerController@exportNeracaKonsolidasi')->name('export');
    });
    //end neraca_konsolidasi
    
    //neraca_detail
    // Route assigned name "neraca_detail.index"...
    Route::name('neraca_detail.')->group(function () {
        Route::get('neraca_detail', 'ReportKontrolerController@create_neraca_detail')->name('create_neraca_detail');
        Route::post('neraca_detail/export', 'ReportKontrolerController@exportNeracaDetail')->name('export');
    });
    //end neraca_detail

    //laba_rugi_konsolidasi
    // Route assigned name "laba_rugi_konsolidasi.index"...
    Route::name('laba_rugi_konsolidasi.')->group(function () {
        Route::get('laba_rugi_konsolidasi', 'ReportKontrolerController@create_laba_rugi_konsolidasi')->name('create_laba_rugi_konsolidasi');
        Route::post('laba_rugi_konsolidasi/export', 'ReportKontrolerController@exportLabaRugiKonsolidasi')->name('export.laba.rugi.konsolidasi');
    });
    //end laba_rugi_konsolidasi
    
    //laba_rugi_detail
    // Route assigned name "laba_rugi_detail.index"...
    Route::name('laba_rugi_detail.')->group(function () {
        Route::get('laba_rugi_detail', 'ReportKontrolerController@create_laba_rugi_detail')->name('create_laba_rugi_detail');
        Route::post('laba_rugi_detail/export', 'ReportKontrolerController@exportLabaRugiDetail')->name('export.laba.rugi.detail');
    });

    //end laporan_keuangan
    //laporan_keuangan
    // Route assigned name "laporan_keuangan.index"...
    Route::name('laporan_keuangan.')->group(function () {
        Route::get('laporan_keuangan', 'ReportKontrolerController@create_laporan_keuangan')->name('create_laporan_keuangan');
        Route::get('laporan_keuangan/export', 'ReportKontrolerController@laporanKeuanganExport')->name('export');
    });
    //end laporan_keuangan

    //end biaya_pegawai
    //biaya_pegawai
    // Route assigned name "biaya_pegawai.index"...
    Route::name('biaya_pegawai.')->group(function () {
        Route::get('biaya_pegawai', 'ReportKontrolerController@create_biaya_pegawai')->name('create_biaya_pegawai');
        Route::post('biaya_pegawai/export', 'ReportKontrolerController@exportBiayaPegawai')->name('export_biaya_pegawai');
    });
    //end biaya_pegawai
});
