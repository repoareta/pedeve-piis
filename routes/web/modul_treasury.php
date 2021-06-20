<?php

//PERBENDAHARAAN
Route::prefix('perbendaharaan')->group(function () {

    //Penerimaan kas
    // Route assigned name "penerimaan_kas.index"...
    Route::name('penerimaan_kas.')->group(function () {
        Route::get('penerimaan_kas', 'PenerimaanKasController@index')->name('index');
        Route::post('penerimaan_kas/search', 'PenerimaanKasController@searchIndex')->name('search.index');
        Route::get('penerimaan_kas/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('penerimaan_kas/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('penerimaan_kas/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('penerimaan_kas/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('penerimaan_kas/createmp', 'PenerimaanKasController@createmp')->name('createmp');
        Route::post('penerimaan_kas/create', 'PenerimaanKasController@create')->name('create');
        Route::post('penerimaan_kas/create/json', 'PenerimaanKasController@createJson')->name('createJson');
        Route::post('penerimaan_kas/lokasi/json', 'PenerimaanKasController@lokasiJson')->name('lokasiJson');
        Route::post('penerimaan_kas/nobukti/json', 'PenerimaanKasController@nobuktiJson')->name('nobuktiJson');
        Route::post('penerimaan_kas/kepada/json', 'PenerimaanKasController@kepadaJson')->name('kepadaJson');
        Route::post('penerimaan_kas/store', 'PenerimaanKasController@store')->name('store');
        Route::post('penerimaan_kas/store_detail', 'PenerimaanKasController@storeDetail')->name('store.detail');
        Route::post('penerimaan_kas/store_app', 'PenerimaanKasController@storeApp')->name('store.app');
        Route::get('penerimaan_kas/edit/{no}', 'PenerimaanKasController@edit')->name('edit');
        Route::get('penerimaan_kas/editdetail/{id}/{no}', 'PenerimaanKasController@editDetail')->name('edit.detail');
        Route::post('penerimaan_kas/update', 'PenerimaanKasController@update')->name('update');
        Route::delete('penerimaan_kas/delete', 'PenerimaanKasController@delete')->name('delete');
        Route::delete('penerimaan_kas/deletedetail', 'PenerimaanKasController@deleteDetail')->name('delete.detail');
        Route::get('penerimaan_kas/approv/{id}/{status}', 'PenerimaanKasController@approv')->name('approv');
        Route::get('penerimaan_kas/export', 'PenerimaanKasController@export')->name('export');
    });
    //end penerimaan kas

    //informasi saldo
    // Route assigned name "informasi_saldo.index"...
    Route::name('informasi_saldo.')->group(function () {
        Route::get('informasi_saldo', 'InformasiSaldoController@index')->name('index');
        Route::post('informasi_saldo/index/json', 'InformasiSaldoController@indexJson')->name('index.json');
        Route::get('informasi_saldo/create', 'InformasiSaldoController@create')->name('create');
        Route::post('informasi_saldo/store', 'InformasiSaldoController@store')->name('store');
        Route::get('informasi_saldo/edit/{bulan}/{tahun}/{nopek}', 'InformasiSaldoController@edit')->name('edit');
        Route::post('informasi_saldo/update', 'InformasiSaldoController@update')->name('update');
        Route::delete('informasi_saldo/delete', 'InformasiSaldoController@delete')->name('delete');
    });
    //end informasi_saldo


    //data Pajak
    // Route assigned name "data_pajak.index"...
    Route::name('data_pajak.')->group(function () {
        Route::get('data_pajak', 'DataPajakController@index')->name('index');
        Route::post('data_pajak/index/json', 'DataPajakController@indexJson')->name('index.json');
        Route::get('data_pajak/create', 'DataPajakController@create')->name('create');
        Route::post('data_pajak/store', 'DataPajakController@store')->name('store');
        Route::get('data_pajak/edit/{tahun}/{bulan}/{nopek}/{jenis}', 'DataPajakController@edit')->name('edit');
        Route::post('data_pajak/update', 'DataPajakController@update')->name('update');
        Route::delete('data_pajak/delete', 'DataPajakController@delete')->name('delete');
    });
    //end data_pajak

    //proses pajak
    // Route assigned name "proses_pajak.rekap"...
    Route::name('proses_pajak.')->group(function () {
        Route::get('proses_pajak', 'PajakTahunanController@RekapPostPajak')->name('rekap');
        Route::post('proses_pajak/export', 'PajakTahunanController@ExportProses')->name('export.proses');
    });
    //end proses_pajak
 
    //laporan pajak
    // Route assigned name "laporan_pajak.rekap"...
    Route::name('laporan_pajak.')->group(function () {
        Route::get('laporan_pajak', 'PajakTahunanController@RekapLaporanPajak')->name('rekap');
        Route::post('laporan_pajak/export', 'PajakTahunanController@ExportLaporan')->name('export.laporan');
    });
    //end laporan_pajak

    //bulan_perbendaharaan
    // Route assigned name "bulan_perbendaharaan.index"...
    Route::name('bulan_perbendaharaan.')->group(function () {
        Route::get('bulan_perbendaharaan', 'BulanPerbendaharaanController@index')->name('index');
        Route::post('bulan_perbendaharaan/index/search', 'BulanPerbendaharaanController@searchIndex')->name('search.index');
        Route::get('bulan_perbendaharaan/create', 'BulanPerbendaharaanController@create')->name('create');
        Route::post('bulan_perbendaharaan/store', 'BulanPerbendaharaanController@store')->name('store');
        Route::get('bulan_perbendaharaan/edit/{no}', 'BulanPerbendaharaanController@edit')->name('edit');
        Route::post('bulan_perbendaharaan/update', 'BulanPerbendaharaanController@update')->name('update');
        Route::delete('bulan_perbendaharaan/delete', 'BulanPerbendaharaanController@delete')->name('delete');
    });
    //end bulan_perbendaharaan

    //opening_balance
    // Route assigned name "opening_balance.index"...
    Route::name('opening_balance.')->group(function () {
        Route::get('opening_balance', 'OpeningBalanceController@index')->name('index');
        Route::post('opening_balance/index/search', 'OpeningBalanceController@searchIndex')->name('search.index');
        Route::get('opening_balance/create', 'OpeningBalanceController@create')->name('create');
        Route::post('opening_balance/store', 'OpeningBalanceController@store')->name('store');
        Route::get('opening_balance/edit/{no}', 'OpeningBalanceController@edit')->name('edit');
        Route::post('opening_balance/update', 'OpeningBalanceController@update')->name('update');
    });
    //end opening_balance

    //Penempatan deposito
    // Route assigned name "penempatan_deposito.index"...
    Route::name('penempatan_deposito.')->group(function () {
        Route::get('penempatan_deposito', 'PenempatanDepositoController@index')->name('index');
        Route::post('penempatan_deposito/search', 'PenempatanDepositoController@searchIndex')->name('search.index');
        Route::post('penempatan_deposito/lineno/json', 'PenempatanDepositoController@linenoJson')->name('linenoJson');
        Route::post('penempatan_deposito/kurs/json', 'PenempatanDepositoController@kursJson')->name('kursJson');
        Route::post('penempatan_deposito/kdbank/json', 'PenempatanDepositoController@kdbankJson')->name('kdbankJson');
        Route::post('penempatan_deposito/nokas/json', 'PenempatanDepositoController@nokasJson')->name('nokas.json');
        Route::get('penempatan_deposito/create', 'PenempatanDepositoController@create')->name('create');
        Route::post('penempatan_deposito/store', 'PenempatanDepositoController@store')->name('store');
        Route::get('penempatan_deposito/edit/{nodok}/{lineno}/{pjg}', 'PenempatanDepositoController@edit')->name('edit');
        Route::post('penempatan_deposito/update', 'PenempatanDepositoController@update')->name('update');
        Route::delete('penempatan_deposito/delete', 'PenempatanDepositoController@delete')->name('delete');
        Route::get('penempatan_deposito/depopjg/{nodok}/{lineno}/{pjg}', 'PenempatanDepositoController@depopjg')->name('depopjg');
        Route::post('penempatan_deposito/updatedepopjg', 'PenempatanDepositoController@updatedepopjg')->name('updatedepopjg');
        Route::get('penempatan_deposito/rekap', 'PenempatanDepositoController@rekap')->name('rekap');
        Route::post('penempatan_deposito/ctkdepo', 'PenempatanDepositoController@ctkdepo')->name('ctkdepo');
        Route::get('penempatan_deposito/rekaprc/{no}/{id}', 'PenempatanDepositoController@rekaprc')->name('rekaprc');
        Route::get('penempatan_deposito/rekap_rc/{no}/{id}', 'PenempatanDepositoController@rekap_Rc')->name('rekap_rc');
        Route::post('penempatan_deposito/exportrc', 'PenempatanDepositoController@exportRc')->name('export_rc');
    });
    //end penempatan_deposito

    //Penempatan deposito
    // Route assigned name "penempatan_deposito.index"...
    Route::name('perhitungan_bagihasil.')->group(function () {
        Route::get('perhitungan_bagihasil', 'PerhitunganBagiHasilController@index')->name('index');
        Route::post('perhitungan_bagihasil/search', 'PerhitunganBagiHasilController@index')->name('index.search');
        Route::delete('perhitungan_bagihasil/delete', 'PerhitunganBagiHasilController@delete')->name('delete');
        Route::get('perhitungan_bagihasil/rekap', 'PerhitunganBagiHasilController@RekapPerhitungan')->name('rekap');
        Route::post('perhitungan_bagihasil/export', 'PerhitunganBagiHasilController@exportPerhitungan')->name('export');
    });
    //end perhitungan_bagihasil

    //pembayaran_gaji
    // Route assigned name "pembayaran_gaji.index"...
    Route::name('pembayaran_gaji.')->group(function () {
        Route::get('pembayaran_gaji', 'PembayaranGajiController@index')->name('index');
        Route::post('pembayaran_gaji/search', 'PembayaranGajiController@searchIndex')->name('search.index');
        Route::get('pembayaran_gaji/create', 'PembayaranGajiController@create')->name('create');
        Route::post('pembayaran_gaji/create/json', 'PembayaranGajiController@createJson')->name('createJson');
        Route::post('pembayaran_gaji/lokasi/json', 'PembayaranGajiController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran_gaji/nobukti/json', 'PembayaranGajiController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran_gaji/store', 'PembayaranGajiController@store')->name('store');
        Route::post('pembayaran_gaji/store_detail', 'PembayaranGajiController@storeDetail')->name('store.detail');
        Route::post('pembayaran_gaji/store_app', 'PembayaranGajiController@storeApp')->name('store.app');
        Route::get('pembayaran_gaji/edit/{no}', 'PembayaranGajiController@edit')->name('edit');
        Route::get('pembayaran_gaji/editdetail/{id}/{no}', 'PembayaranGajiController@editDetail')->name('edit.detail');
        Route::post('pembayaran_gaji/update', 'PembayaranGajiController@update')->name('update');
        Route::post('pembayaran_gaji/update/detail', 'PembayaranGajiController@updateDetail')->name('update.detail');
        Route::delete('pembayaran_gaji/delete', 'PembayaranGajiController@delete')->name('delete');
        Route::delete('pembayaran_gaji/deletedetail', 'PembayaranGajiController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran_gaji/deletedetail/all', 'PembayaranGajiController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran_gaji/approv/{id}/{status}', 'PembayaranGajiController@approv')->name('approv');
        Route::get('pembayaran_gaji/rekap/{docno}', 'PembayaranGajiController@rekap')->name('rekap');
        Route::post('pembayaran_gaji/export', 'PembayaranGajiController@export')->name('export');
        Route::get('pembayaran_gaji/rekaprc/{docno}', 'PembayaranGajiController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran_gaji/exportrc', 'PembayaranGajiController@exportRc')->name('export_rc');
    });
    //end pembayaran_gaji

    //pembayaran_umk
    // Route assigned name "pembayaran_umk.index"...
    Route::name('pembayaran_umk.')->group(function () {
        Route::get('pembayaran_umk', 'PembayaranUmkController@index')->name('index');
        Route::post('pembayaran_umk/search', 'PembayaranUmkController@searchIndex')->name('search.index');
        Route::get('pembayaran_umk/create', 'PembayaranUmkController@create')->name('create');
        Route::post('pembayaran_umk/create/json', 'PembayaranUmkController@createJson')->name('createJson');
        Route::post('pembayaran_umk/lokasi/json', 'PembayaranUmkController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran_umk/nobukti/json', 'PembayaranUmkController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran_umk/store', 'PembayaranUmkController@store')->name('store');
        Route::post('pembayaran_umk/store_detail', 'PembayaranUmkController@storeDetail')->name('store.detail');
        Route::post('pembayaran_umk/store_app', 'PembayaranUmkController@storeApp')->name('store.app');
        Route::get('pembayaran_umk/edit/{no}', 'PembayaranUmkController@edit')->name('edit');
        Route::get('pembayaran_umk/editdetail/{id}/{no}', 'PembayaranUmkController@editDetail')->name('edit.detail');
        Route::post('pembayaran_umk/update', 'PembayaranUmkController@update')->name('update');
        Route::post('pembayaran_umk/update/detail', 'PembayaranUmkController@updateDetail')->name('update.detail');
        Route::delete('pembayaran_umk/delete', 'PembayaranUmkController@delete')->name('delete');
        Route::delete('pembayaran_umk/deletedetail', 'PembayaranUmkController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran_umk/deletedetail/all', 'PembayaranUmkController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran_umk/approv/{id}/{status}', 'PembayaranUmkController@approv')->name('approv');
        Route::get('pembayaran_umk/rekap/{docno}', 'PembayaranUmkController@rekap')->name('rekap');
        Route::post('pembayaran_umk/export', 'PembayaranUmkController@export')->name('export');
        Route::get('pembayaran_umk/rekaprc/{docno}', 'PembayaranUmkController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran_umk/exportrc', 'PembayaranUmkController@exportRc')->name('export_rc');
    });
    //end pembayaran_umk


    //pembayaran_jumk
    // Route assigned name "pembayaran_jumk.index"...
    Route::name('pembayaran_jumk.')->group(function () {
        Route::get('pembayaran_jumk', 'PembayaranJumkController@index')->name('index');
        Route::post('pembayaran_jumk/search', 'PembayaranJumkController@searchIndex')->name('search.index');
        Route::get('pembayaran_jumk/create', 'PembayaranJumkController@create')->name('create');
        Route::post('pembayaran_jumk/create/json', 'PembayaranJumkController@createJson')->name('createJson');
        Route::post('pembayaran_jumk/lokasi/json', 'PembayaranJumkController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran_jumk/nobukti/json', 'PembayaranJumkController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran_jumk/store', 'PembayaranJumkController@store')->name('store');
        Route::post('pembayaran_jumk/store_detail', 'PembayaranJumkController@storeDetail')->name('store.detail');
        Route::post('pembayaran_jumk/store_app', 'PembayaranJumkController@storeApp')->name('store.app');
        Route::get('pembayaran_jumk/edit/{no}', 'PembayaranJumkController@edit')->name('edit');
        Route::get('pembayaran_jumk/editdetail/{id}/{no}', 'PembayaranJumkController@editDetail')->name('edit.detail');
        Route::post('pembayaran_jumk/update', 'PembayaranJumkController@update')->name('update');
        Route::post('pembayaran_jumk/update/detail', 'PembayaranJumkController@updateDetail')->name('update.detail');
        Route::delete('pembayaran_jumk/delete', 'PembayaranJumkController@delete')->name('delete');
        Route::delete('pembayaran_jumk/deletedetail', 'PembayaranJumkController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran_jumk/deletedetail/all', 'PembayaranJumkController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran_jumk/approv/{id}/{status}', 'PembayaranJumkController@approv')->name('approv');
        Route::get('pembayaran_jumk/rekap/{docno}', 'PembayaranJumkController@rekap')->name('rekap');
        Route::post('pembayaran_jumk/export', 'PembayaranJumkController@export')->name('export');
        Route::get('pembayaran_jumk/rekaprc/{docno}', 'PembayaranJumkController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran_jumk/exportrc', 'PembayaranJumkController@exportRc')->name('export_rc');
    });
    //end pembayaran_jumk

    //pembayaran_pbayar
    // Route assigned name "pembayaran_pbayar.index"...
    Route::name('pembayaran_pbayar.')->group(function () {
        Route::get('pembayaran_pbayar', 'PembayaranPbayarController@index')->name('index');
        Route::post('pembayaran_pbayar/search', 'PembayaranPbayarController@searchIndex')->name('search.index');
        Route::get('pembayaran_pbayar/create', 'PembayaranPbayarController@create')->name('create');
        Route::post('pembayaran_pbayar/create/json', 'PembayaranPbayarController@createJson')->name('createJson');
        Route::post('pembayaran_pbayar/lokasi/json', 'PembayaranPbayarController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran_pbayar/nobukti/json', 'PembayaranPbayarController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran_pbayar/store', 'PembayaranPbayarController@store')->name('store');
        Route::post('pembayaran_pbayar/store_detail', 'PembayaranPbayarController@storeDetail')->name('store.detail');
        Route::post('pembayaran_pbayar/store_app', 'PembayaranPbayarController@storeApp')->name('store.app');
        Route::get('pembayaran_pbayar/edit/{no}', 'PembayaranPbayarController@edit')->name('edit');
        Route::get('pembayaran_pbayar/editdetail/{id}/{no}', 'PembayaranPbayarController@editDetail')->name('edit.detail');
        Route::post('pembayaran_pbayar/update', 'PembayaranPbayarController@update')->name('update');
        Route::post('pembayaran_pbayar/update/detail', 'PembayaranPbayarController@updateDetail')->name('update.detail');
        Route::delete('pembayaran_pbayar/delete', 'PembayaranPbayarController@delete')->name('delete');
        Route::delete('pembayaran_pbayar/deletedetail', 'PembayaranPbayarController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran_pbayar/deletedetail/all', 'PembayaranPbayarController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran_pbayar/approv/{id}/{status}', 'PembayaranPbayarController@approv')->name('approv');
        Route::get('pembayaran_pbayar/rekap/{docno}', 'PembayaranPbayarController@rekap')->name('rekap');
        Route::post('pembayaran_pbayar/export', 'PembayaranPbayarController@export')->name('export');
        Route::get('pembayaran_pbayar/rekaprc/{docno}', 'PembayaranPbayarController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran_pbayar/exportrc', 'PembayaranPbayarController@exportRc')->name('export_rc');
        Route::get('pembayaran_pbayar/rekaprc/{docno}', 'PembayaranPbayarController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran_pbayar/exportrc', 'PembayaranPbayarController@exportRc')->name('export_rc');
    });
    //end pembayaran_pbayar

    //Rekap Harian Kas
    // Route assigned name "rekap_harian_kas.index"...
    Route::name('rekap_harian_kas.')->group(function () {
        Route::get('rekap_harian_kas', 'RekapHarianKasController@index')->name('index');
        Route::post('rekap_harian_kas/search', 'RekapHarianKasController@searchIndex')->name('search.index');
        Route::post('rekap_harian_kas/jeniskartu/json', 'RekapHarianKasController@JeniskaruJson')->name('jenis.kartu.json');
        Route::post('rekap_harian_kas/nokas/json', 'RekapHarianKasController@NokasJson')->name('nokas.json');
        Route::get('rekap_harian_kas/create', 'RekapHarianKasController@create')->name('create');
        Route::post('rekap_harian_kas/store', 'RekapHarianKasController@store')->name('store');
        Route::get('rekap_harian_kas/edit/{no}/{id}/{tgl}', 'RekapHarianKasController@edit')->name('edit');
        Route::post('rekap_harian_kas/update', 'RekapHarianKasController@update')->name('update');
        Route::delete('rekap_harian_kas/delete', 'RekapHarianKasController@delete')->name('delete');
        Route::get('rekap_harian_kas/rekap/{no}/{id}/{tanggal}', 'RekapHarianKasController@RekapHarian')->name('rekap');
        Route::post('rekap_harian_kas/ctkharian', 'RekapHarianKasController@CtkHarian')->name('ctkharian');
    });
    //end rekap_harian_kas

    //Rekap Harian Kas
    // Route assigned name "rekap_periode_kas.index"...
    Route::name('rekap_periode_kas.')->group(function () {
        Route::get('rekap_periode_kas/create', 'RekapPeriodeKasController@RekapPeriode')->name('create');
        Route::post('rekap_periode_kas/export', 'RekapPeriodeKasController@exportPeriode')->name('exportperiode');
        Route::post('rekap_periode_kas/json/nokas', 'RekapPeriodeKasController@nokasJson')->name('nokas.json');
        Route::post('rekap_periode_kas/json/jk', 'RekapPeriodeKasController@jkJson')->name('jk.json');
    });
    //end rekap_harian_kas


    //Report Kas Kas Bank
    // Route assigned name "report_kas_bank.index"...
    Route::name('kas_bank.')->group(function () {
        Route::get('kas_bank/report/create1', 'KasCashJudexController@Create1')->name('create1');
        Route::get('kas_bank/search/account', 'KasCashJudexController@searchAccount')->name('search.account');
        Route::post('kas_bank/report/cetak1', 'KasCashJudexController@cetak1')->name('cetak1');
        Route::get('kas_bank/report/create2', 'KasCashJudexController@Create2')->name('create2');
        Route::post('kas_bank/report/cetak2', 'KasCashJudexController@Cetak2')->name('cetak2');
        Route::get('kas_bank/report/create3', 'KasCashJudexController@Create3')->name('create3');
        Route::post('kas_bank/report/cetak3', 'KasCashJudexController@Cetak3')->name('cetak3');
        Route::get('kas_bank/report/create4', 'KasCashJudexController@Create4')->name('create4');
        Route::post('kas_bank/report/cetak4', 'KasCashJudexController@Cetak4')->name('cetak4');
        Route::get('kas_bank/report/create5', 'KasCashJudexController@Create5')->name('create5');
        Route::post('kas_bank/report/cetak5', 'KasCashJudexController@Cetak5')->name('cetak5');
        Route::get('kas_bank/report/create6', 'KasCashJudexController@Create6')->name('create6');
        Route::post('kas_bank/report/cetak6', 'KasCashJudexController@Cetak6')->name('cetak6');
        Route::get('kas_bank/report/create7', 'KasCashJudexController@Create7')->name('create7');
        Route::get('kas_bank/report/cetak7', 'KasCashJudexController@Cetak7')->name('cetak7');
        Route::get('kas_bank/report/create8', 'KasCashJudexController@Create8')->name('create8');
        Route::get('kas_bank/report/cetak8', 'KasCashJudexController@Cetak8')->name('cetak8');
        Route::get('kas_bank/report/create9', 'KasCashJudexController@Create9')->name('create9');
        Route::get('kas_bank/report/cetak9', 'KasCashJudexController@Cetak9')->name('cetak9');
        Route::get('kas_bank/report/create10', 'KasCashJudexController@Create10')->name('create10');
        Route::get('kas_bank/search/cj', 'KasCashJudexController@searchCj')->name('search.cj');
        Route::get('kas_bank/report/cetak10', 'KasCashJudexController@Cetak10')->name('cetak10');
    });
    //end report_kas_bank

    // Report CashFlow START
    // Route assigned name "cash_flow.index"...
    Route::name('cash_flow.')->group(function () {
        Route::get('cash_flow/report/internal', 'CashFlowController@internal')->name('internal');
        Route::get('cash_flow/report/internal/export', 'CashFlowController@internalExport')->name('internal.export');
        Route::get('cash_flow/report/perperiode', 'CashFlowController@perPeriode')->name('perperiode');
        Route::get('cash_flow/report/perperiode/export', 'CashFlowController@perPeriode')->name('perperiode.export');
        Route::get('cash_flow/report/mutasi', 'CashFlowController@mutasi')->name('mutasi');
        Route::get('cash_flow/report/mutasi/export', 'CashFlowController@mutasiExport')->name('mutasi.export');
        Route::get('cash_flow/report/permatauang', 'CashFlowController@perMataUang')->name('permatauang');
        Route::get('cash_flow/report/permatauang/export', 'CashFlowController@perMataUangExport')->name('permatauang.export');
        Route::get('cash_flow/report/lengkap', 'CashFlowController@lengkap')->name('lengkap');
        Route::get('cash_flow/report/lengkap/export', 'CashFlowController@lengkapExport')->name('lengkap.export');
    });
    // Report CashFlow END
});
