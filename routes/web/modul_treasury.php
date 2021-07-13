<?php

//PERBENDAHARAAN

use App\Http\Controllers\Treasury\InformasiSaldoController;
use App\Http\Controllers\Treasury\PenerimaanKasController;

Route::prefix('perbendaharaan')->group(function () {

    // Penerimaan kas
    // Route assigned name "penerimaan_kas.index"...
    Route::name('penerimaan_kas.')->group(function () {
        Route::get('penerimaan-kas', [PenerimaanKasController::class, 'index'])->name('index');
        Route::post('penerimaan-kas/search', [PenerimaanKasController::class, 'search'])->name('search');
        Route::post('penerimaan-kas/create', [PenerimaanKasController::class, 'create'])->name('create');
        Route::get('penerimaan-kas/create/jenis-kas', [PenerimaanKasController::class, 'createKas'])->name('create.kas');
        Route::post('penerimaan-kas/store', [PenerimaanKasController::class, 'store'])->name('store');
        Route::post('penerimaan-kas/ajax-document-number', [PenerimaanKasController::class, 'ajaxCreate'])->name('ajax-create');
        Route::post('penerimaan-kas/ajax-bagian', [PenerimaanKasController::class, 'ajaxBagian'])->name('ajax-bagian');
        Route::post('penerimaan-kas/ajax-lokasi', [PenerimaanKasController::class, 'ajaxLocation'])->name('ajax-lokasi');
        Route::post('penerimaan-kas/ajax-bukti', [PenerimaanKasController::class, 'ajaxBukti'])->name('ajax-bukti');
        Route::post('penerimaan-kas/ajax-kepada', [PenerimaanKasController::class, 'ajaxKepada'])->name('ajax-kepada');
        Route::post('penerimaan-kas/ajax-account', [PenerimaanKasController::class, 'ajaxAccount'])->name('ajax-account');
        Route::post('penerimaan-kas/ajax-jenis-biaya', [PenerimaanKasController::class, 'ajaxJenisBiaya'])->name('ajax-jenis-biaya');
        Route::post('penerimaan-kas/ajax-cash-judex', [PenerimaanKasController::class, 'ajaxCashJudex'])->name('ajax-cash-judex');
        Route::delete('penerimaan-kas/delete-detail', [PenerimaanKasController::class, 'deleteDetail'])->name('delete.detail');
        Route::post('penerimaan-kas/update', [PenerimaanKasController::class, 'update'])->name('update');
        Route::delete('penerimaan-kas/delete', [PenerimaanKasController::class, 'destroy'])->name('delete');
        Route::get('penerimaan-kas/{documentId}/input-detail', [PenerimaanKasController::class, 'show'])->name('input-detail');
        Route::post('penerimaan-kas/{documentId}/store-detail', [PenerimaanKasController::class, 'storeDetail'])->name('store.detail');
        Route::get('penerimaan-kas/{documentId}/approval', [PenerimaanKasController::class, 'approval'])->name('approval');
        Route::post('penerimaan-kas/{documentId}/approve', [PenerimaanKasController::class, 'approve'])->name('approve');
        Route::get('penerimaan-kas/{documentId}/cancel-approval', [PenerimaanKasController::class, 'cancel'])->name('approval.cancel-form');
        Route::post('penerimaan-kas/{documentId}/cancel-approval', [PenerimaanKasController::class, 'cancelApproval'])->name('approval.cancel');
        Route::get('penerimaan-kas/{documentId}/{lineNumber}/get-detail', [PenerimaanKasController::class, 'getDetail'])->name('get.detail');
        Route::get('penerimaan-kas/{documentId}/edit', [PenerimaanKasController::class, 'edit'])->name('edit');
        Route::get('penerimaan-kas/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('penerimaan-kas/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('penerimaan-kas/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('penerimaan-kas/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('penerimaan-kas/editdetail/{id}/{no}', 'PenerimaanKasController@editDetail')->name('edit.detail');
        Route::get('penerimaan-kas/export', 'PenerimaanKasController@export')->name('export');
    });
    //end penerimaan kas

    //informasi saldo
    // Route assigned name "informasi_saldo.index"...
    Route::name('informasi_saldo.')->group(function () {
        Route::get('informasi-saldo', [InformasiSaldoController::class, 'index'])->name('index');
        Route::post('informasi-saldo/index/json', [InformasiSaldoController::class, 'indexJson'])->name('index.json');
    });
    //end informasi-saldo


    //data Pajak
    // Route assigned name "data_pajak.index"...
    Route::name('data_pajak.')->group(function () {
        Route::get('data-pajak', 'DataPajakController@index')->name('index');
        Route::post('data-pajak/index/json', 'DataPajakController@indexJson')->name('index.json');
        Route::get('data-pajak/create', 'DataPajakController@create')->name('create');
        Route::post('data-pajak/store', 'DataPajakController@store')->name('store');
        Route::get('data-pajak/edit/{tahun}/{bulan}/{nopek}/{jenis}', 'DataPajakController@edit')->name('edit');
        Route::post('data-pajak/update', 'DataPajakController@update')->name('update');
        Route::delete('data-pajak/delete', 'DataPajakController@delete')->name('delete');
    });
    //end data-pajak

    //proses pajak
    // Route assigned name "proses_pajak.rekap"...
    Route::name('proses_pajak.')->group(function () {
        Route::get('proses-pajak', 'PajakTahunanController@RekapPostPajak')->name('rekap');
        Route::post('proses-pajak/export', 'PajakTahunanController@ExportProses')->name('export.proses');
    });
    //end proses_pajak
 
    //laporan pajak
    // Route assigned name "laporan_pajak.rekap"...
    Route::name('laporan_pajak.')->group(function () {
        Route::get('laporan-pajak', 'PajakTahunanController@RekapLaporanPajak')->name('rekap');
        Route::post('laporan-pajak/export', 'PajakTahunanController@ExportLaporan')->name('export.laporan');
    });
    //end laporan_pajak

    //bulan-perbendaharaan
    // Route assigned name "bulan_perbendaharaan.index"...
    Route::name('bulan_perbendaharaan.')->group(function () {
        Route::get('bulan-perbendaharaan', 'BulanPerbendaharaanController@index')->name('index');
        Route::post('bulan-perbendaharaan/index/search', 'BulanPerbendaharaanController@searchIndex')->name('search.index');
        Route::get('bulan-perbendaharaan/create', 'BulanPerbendaharaanController@create')->name('create');
        Route::post('bulan-perbendaharaan/store', 'BulanPerbendaharaanController@store')->name('store');
        Route::get('bulan-perbendaharaan/edit/{no}', 'BulanPerbendaharaanController@edit')->name('edit');
        Route::post('bulan-perbendaharaan/update', 'BulanPerbendaharaanController@update')->name('update');
        Route::delete('bulan-perbendaharaan/delete', 'BulanPerbendaharaanController@delete')->name('delete');
    });
    //end bulan-perbendaharaan

    //opening-balance
    // Route assigned name "opening-balance.index"...
    Route::name('opening_balance.')->group(function () {
        Route::get('opening-balance', 'OpeningBalanceController@index')->name('index');
        Route::post('opening-balance/index/search', 'OpeningBalanceController@searchIndex')->name('search.index');
        Route::get('opening-balance/create', 'OpeningBalanceController@create')->name('create');
        Route::post('opening-balance/store', 'OpeningBalanceController@store')->name('store');
        Route::get('opening-balance/edit/{no}', 'OpeningBalanceController@edit')->name('edit');
        Route::post('opening-balance/update', 'OpeningBalanceController@update')->name('update');
    });
    //end opening-balance

    //Penempatan deposito
    // Route assigned name "penempatan_deposito.index"...
    Route::name('penempatan_deposito.')->group(function () {
        Route::get('penempatan-deposito', 'PenempatanDepositoController@index')->name('index');
        Route::post('penempatan-deposito/search', 'PenempatanDepositoController@searchIndex')->name('search.index');
        Route::post('penempatan-deposito/lineno/json', 'PenempatanDepositoController@linenoJson')->name('linenoJson');
        Route::post('penempatan-deposito/kurs/json', 'PenempatanDepositoController@kursJson')->name('kursJson');
        Route::post('penempatan-deposito/kdbank/json', 'PenempatanDepositoController@kdbankJson')->name('kdbankJson');
        Route::post('penempatan-deposito/nokas/json', 'PenempatanDepositoController@nokasJson')->name('nokas.json');
        Route::get('penempatan-deposito/create', 'PenempatanDepositoController@create')->name('create');
        Route::post('penempatan-deposito/store', 'PenempatanDepositoController@store')->name('store');
        Route::get('penempatan-deposito/edit/{nodok}/{lineno}/{pjg}', 'PenempatanDepositoController@edit')->name('edit');
        Route::post('penempatan-deposito/update', 'PenempatanDepositoController@update')->name('update');
        Route::delete('penempatan-deposito/delete', 'PenempatanDepositoController@delete')->name('delete');
        Route::get('penempatan-deposito/depopjg/{nodok}/{lineno}/{pjg}', 'PenempatanDepositoController@depopjg')->name('depopjg');
        Route::post('penempatan-deposito/updatedepopjg', 'PenempatanDepositoController@updatedepopjg')->name('updatedepopjg');
        Route::get('penempatan-deposito/rekap', 'PenempatanDepositoController@rekap')->name('rekap');
        Route::post('penempatan-deposito/ctkdepo', 'PenempatanDepositoController@ctkdepo')->name('ctkdepo');
        Route::get('penempatan-deposito/rekaprc/{no}/{id}', 'PenempatanDepositoController@rekaprc')->name('rekaprc');
        Route::get('penempatan-deposito/rekap_rc/{no}/{id}', 'PenempatanDepositoController@rekap_Rc')->name('rekap_rc');
        Route::post('penempatan-deposito/exportrc', 'PenempatanDepositoController@exportRc')->name('export_rc');
    });
    //end penempatan-deposito

    // Perhitungan bagi hasil
    // Route assigned name "perhitungan_bagihasil.index"...
    Route::name('perhitungan_bagihasil.')->group(function () {
        Route::get('perhitungan-bagihasil', 'PerhitunganBagiHasilController@index')->name('index');
        Route::post('perhitungan-bagihasil/search', 'PerhitunganBagiHasilController@index')->name('index.search');
        Route::delete('perhitungan-bagihasil/delete', 'PerhitunganBagiHasilController@delete')->name('delete');
        Route::get('perhitungan-bagihasil/rekap', 'PerhitunganBagiHasilController@RekapPerhitungan')->name('rekap');
        Route::post('perhitungan-bagihasil/export', 'PerhitunganBagiHasilController@exportPerhitungan')->name('export');
    });
    //end perhitungan-bagihasil

    //pembayaran Gaji
    // Route assigned name "pembayaran_gaji.index"...
    Route::name('pembayaran_gaji.')->group(function () {
        Route::get('pembayaran-gaji', 'PembayaranGajiController@index')->name('index');
        Route::post('pembayaran-gaji/search', 'PembayaranGajiController@searchIndex')->name('search.index');
        Route::get('pembayaran-gaji/create', 'PembayaranGajiController@create')->name('create');
        Route::post('pembayaran-gaji/create/json', 'PembayaranGajiController@createJson')->name('createJson');
        Route::post('pembayaran-gaji/lokasi/json', 'PembayaranGajiController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran-gaji/nobukti/json', 'PembayaranGajiController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran-gaji/store', 'PembayaranGajiController@store')->name('store');
        Route::post('pembayaran-gaji/store-detail', 'PembayaranGajiController@storeDetail')->name('store.detail');
        Route::post('pembayaran-gaji/store_app', 'PembayaranGajiController@storeApp')->name('store.app');
        Route::get('pembayaran-gaji/edit/{no}', 'PembayaranGajiController@edit')->name('edit');
        Route::get('pembayaran-gaji/editdetail/{id}/{no}', 'PembayaranGajiController@editDetail')->name('edit.detail');
        Route::post('pembayaran-gaji/update', 'PembayaranGajiController@update')->name('update');
        Route::post('pembayaran-gaji/update/detail', 'PembayaranGajiController@updateDetail')->name('update.detail');
        Route::delete('pembayaran-gaji/delete', 'PembayaranGajiController@delete')->name('delete');
        Route::delete('pembayaran-gaji/deletedetail', 'PembayaranGajiController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran-gaji/deletedetail/all', 'PembayaranGajiController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran-gaji/approv/{id}/{status}', 'PembayaranGajiController@approv')->name('approv');
        Route::get('pembayaran-gaji/rekap/{docno}', 'PembayaranGajiController@rekap')->name('rekap');
        Route::post('pembayaran-gaji/export', 'PembayaranGajiController@export')->name('export');
        Route::get('pembayaran-gaji/rekaprc/{docno}', 'PembayaranGajiController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran-gaji/exportrc', 'PembayaranGajiController@exportRc')->name('export_rc');
    });
    //end pembayaran-gaji

    // pembayaran umk
    // Route assigned name "pembayaran_umk.index"...
    Route::name('pembayaran_umk.')->group(function () {
        Route::get('pembayaran-umk', 'PembayaranUmkController@index')->name('index');
        Route::post('pembayaran-umk/search', 'PembayaranUmkController@searchIndex')->name('search.index');
        Route::get('pembayaran-umk/create', 'PembayaranUmkController@create')->name('create');
        Route::post('pembayaran-umk/create/json', 'PembayaranUmkController@createJson')->name('createJson');
        Route::post('pembayaran-umk/lokasi/json', 'PembayaranUmkController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran-umk/nobukti/json', 'PembayaranUmkController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran-umk/store', 'PembayaranUmkController@store')->name('store');
        Route::post('pembayaran-umk/store-detail', 'PembayaranUmkController@storeDetail')->name('store.detail');
        Route::post('pembayaran-umk/store_app', 'PembayaranUmkController@storeApp')->name('store.app');
        Route::get('pembayaran-umk/edit/{no}', 'PembayaranUmkController@edit')->name('edit');
        Route::get('pembayaran-umk/editdetail/{id}/{no}', 'PembayaranUmkController@editDetail')->name('edit.detail');
        Route::post('pembayaran-umk/update', 'PembayaranUmkController@update')->name('update');
        Route::post('pembayaran-umk/update/detail', 'PembayaranUmkController@updateDetail')->name('update.detail');
        Route::delete('pembayaran-umk/delete', 'PembayaranUmkController@delete')->name('delete');
        Route::delete('pembayaran-umk/deletedetail', 'PembayaranUmkController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran-umk/deletedetail/all', 'PembayaranUmkController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran-umk/approv/{id}/{status}', 'PembayaranUmkController@approv')->name('approv');
        Route::get('pembayaran-umk/rekap/{docno}', 'PembayaranUmkController@rekap')->name('rekap');
        Route::post('pembayaran-umk/export', 'PembayaranUmkController@export')->name('export');
        Route::get('pembayaran-umk/rekaprc/{docno}', 'PembayaranUmkController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran-umk/exportrc', 'PembayaranUmkController@exportRc')->name('export_rc');
    });
    //end pembayaran-umk


    // Pembayaran jumk
    // Route assigned name "pembayaran_jumk.index"...
    Route::name('pembayaran_jumk.')->group(function () {
        Route::get('pembayaran-jumk', 'PembayaranJumkController@index')->name('index');
        Route::post('pembayaran-jumk/search', 'PembayaranJumkController@searchIndex')->name('search.index');
        Route::get('pembayaran-jumk/create', 'PembayaranJumkController@create')->name('create');
        Route::post('pembayaran-jumk/create/json', 'PembayaranJumkController@createJson')->name('createJson');
        Route::post('pembayaran-jumk/lokasi/json', 'PembayaranJumkController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran-jumk/nobukti/json', 'PembayaranJumkController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran-jumk/store', 'PembayaranJumkController@store')->name('store');
        Route::post('pembayaran-jumk/store-detail', 'PembayaranJumkController@storeDetail')->name('store.detail');
        Route::post('pembayaran-jumk/store_app', 'PembayaranJumkController@storeApp')->name('store.app');
        Route::get('pembayaran-jumk/edit/{no}', 'PembayaranJumkController@edit')->name('edit');
        Route::get('pembayaran-jumk/editdetail/{id}/{no}', 'PembayaranJumkController@editDetail')->name('edit.detail');
        Route::post('pembayaran-jumk/update', 'PembayaranJumkController@update')->name('update');
        Route::post('pembayaran-jumk/update/detail', 'PembayaranJumkController@updateDetail')->name('update.detail');
        Route::delete('pembayaran-jumk/delete', 'PembayaranJumkController@delete')->name('delete');
        Route::delete('pembayaran-jumk/deletedetail', 'PembayaranJumkController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran-jumk/deletedetail/all', 'PembayaranJumkController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran-jumk/approv/{id}/{status}', 'PembayaranJumkController@approv')->name('approv');
        Route::get('pembayaran-jumk/rekap/{docno}', 'PembayaranJumkController@rekap')->name('rekap');
        Route::post('pembayaran-jumk/export', 'PembayaranJumkController@export')->name('export');
        Route::get('pembayaran-jumk/rekaprc/{docno}', 'PembayaranJumkController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran-jumk/exportrc', 'PembayaranJumkController@exportRc')->name('export_rc');
    });
    //end pembayaran-jumk

    // Pembayaran pbayar
    // Route assigned name "pembayaran_pbayar.index"...
    Route::name('pembayaran-pbayar.')->group(function () {
        Route::get('pembayaran-pbayar', 'PembayaranPbayarController@index')->name('index');
        Route::post('pembayaran-pbayar/search', 'PembayaranPbayarController@searchIndex')->name('search.index');
        Route::get('pembayaran-pbayar/create', 'PembayaranPbayarController@create')->name('create');
        Route::post('pembayaran-pbayar/create/json', 'PembayaranPbayarController@createJson')->name('createJson');
        Route::post('pembayaran-pbayar/lokasi/json', 'PembayaranPbayarController@lokasiJson')->name('lokasiJson');
        Route::post('pembayaran-pbayar/nobukti/json', 'PembayaranPbayarController@nobuktiJson')->name('nobuktiJson');
        Route::post('pembayaran-pbayar/store', 'PembayaranPbayarController@store')->name('store');
        Route::post('pembayaran-pbayar/store-detail', 'PembayaranPbayarController@storeDetail')->name('store.detail');
        Route::post('pembayaran-pbayar/store_app', 'PembayaranPbayarController@storeApp')->name('store.app');
        Route::get('pembayaran-pbayar/edit/{no}', 'PembayaranPbayarController@edit')->name('edit');
        Route::get('pembayaran-pbayar/editdetail/{id}/{no}', 'PembayaranPbayarController@editDetail')->name('edit.detail');
        Route::post('pembayaran-pbayar/update', 'PembayaranPbayarController@update')->name('update');
        Route::post('pembayaran-pbayar/update/detail', 'PembayaranPbayarController@updateDetail')->name('update.detail');
        Route::delete('pembayaran-pbayar/delete', 'PembayaranPbayarController@delete')->name('delete');
        Route::delete('pembayaran-pbayar/deletedetail', 'PembayaranPbayarController@deleteDetail')->name('delete.detail');
        Route::delete('pembayaran-pbayar/deletedetail/all', 'PembayaranPbayarController@deleteDetailall')->name('delete.detail.all');
        Route::get('pembayaran-pbayar/approv/{id}/{status}', 'PembayaranPbayarController@approv')->name('approv');
        Route::get('pembayaran-pbayar/rekap/{docno}', 'PembayaranPbayarController@rekap')->name('rekap');
        Route::post('pembayaran-pbayar/export', 'PembayaranPbayarController@export')->name('export');
        Route::get('pembayaran-pbayar/rekaprc/{docno}', 'PembayaranPbayarController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran-pbayar/exportrc', 'PembayaranPbayarController@exportRc')->name('export_rc');
        Route::get('pembayaran-pbayar/rekaprc/{docno}', 'PembayaranPbayarController@rekapRc')->name('rekap_rc');
        Route::post('pembayaran-pbayar/exportrc', 'PembayaranPbayarController@exportRc')->name('export_rc');
    });
    //end pembayaran-pbayar

    // Rekap Harian Kas
    // Route assigned name "rekap_harian_kas.index"...
    Route::name('rekap_harian_kas.')->group(function () {
        Route::get('rekap-harian-kas', 'RekapHarianKasController@index')->name('index');
        Route::post('rekap-harian-kas/search', 'RekapHarianKasController@searchIndex')->name('search.index');
        Route::post('rekap-harian-kas/jeniskartu/json', 'RekapHarianKasController@JeniskaruJson')->name('jenis.kartu.json');
        Route::post('rekap-harian-kas/nokas/json', 'RekapHarianKasController@NokasJson')->name('nokas.json');
        Route::get('rekap-harian-kas/create', 'RekapHarianKasController@create')->name('create');
        Route::post('rekap-harian-kas/store', 'RekapHarianKasController@store')->name('store');
        Route::get('rekap-harian-kas/edit/{no}/{id}/{tgl}', 'RekapHarianKasController@edit')->name('edit');
        Route::post('rekap-harian-kas/update', 'RekapHarianKasController@update')->name('update');
        Route::delete('rekap-harian-kas/delete', 'RekapHarianKasController@delete')->name('delete');
        Route::get('rekap-harian-kas/rekap/{no}/{id}/{tanggal}', 'RekapHarianKasController@RekapHarian')->name('rekap');
        Route::post('rekap-harian-kas/ctkharian', 'RekapHarianKasController@CtkHarian')->name('ctkharian');
    });
    //end rekap-harian-kas

    // Rekap Periode Kas
    // Route assigned name "rekap_periode_kas.index"...
    Route::name('rekap_periode_kas.')->group(function () {
        Route::get('rekap-periode-kas/create', 'RekapPeriodeKasController@RekapPeriode')->name('create');
        Route::post('rekap-periode-kas/export', 'RekapPeriodeKasController@exportPeriode')->name('exportperiode');
        Route::post('rekap-periode-kas/json/nokas', 'RekapPeriodeKasController@nokasJson')->name('nokas.json');
        Route::post('rekap-periode-kas/json/jk', 'RekapPeriodeKasController@jkJson')->name('jk.json');
    });
    //end rekap-harian-kas


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
