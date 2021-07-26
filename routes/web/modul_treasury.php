<?php

//PERBENDAHARAAN

use App\Http\Controllers\Treasury\BulanPerbendaharaanController;
use App\Http\Controllers\Treasury\DataPajakController;
use App\Http\Controllers\Treasury\InformasiSaldoController;
use App\Http\Controllers\Treasury\KasCashJudexController;
use App\Http\Controllers\Treasury\OpeningBalanceController;
use App\Http\Controllers\Treasury\PajakTahunanController;
use App\Http\Controllers\Treasury\PembayaranGajiController;
use App\Http\Controllers\Treasury\PembayaranJUMKController;
use App\Http\Controllers\Treasury\PembayaranPBayarController;
use App\Http\Controllers\Treasury\PembayaranUMKController;
use App\Http\Controllers\Treasury\PenempatanDepositoController;
use App\Http\Controllers\Treasury\PenerimaanKasController;
use App\Http\Controllers\Treasury\PerhitunganBagiHasilController;
use App\Http\Controllers\Treasury\RekapHarianKasController;
use App\Http\Controllers\Treasury\RekapPeriodeKasController;

Route::prefix('perbendaharaan')->group(function () {

    // Penerimaan kas
    // Route assigned name "penerimaan_kas.index"...
    Route::name('penerimaan_kas.')->group(function () {
        Route::get('penerimaan-kas', [PenerimaanKasController::class, 'index'])->name('index');
        Route::post('penerimaan-kas/index-json', [PenerimaanKasController::class, 'search'])->name('search');
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
        Route::get('penerimaan-kas/export', [PenerimaanKasController::class, 'export'])->name('export');
        Route::get('penerimaan-kas/{documentId}/input-detail', [PenerimaanKasController::class, 'show'])->name('input-detail');
        Route::post('penerimaan-kas/{documentId}/store-detail', [PenerimaanKasController::class, 'storeDetail'])->name('store.detail');
        Route::get('penerimaan-kas/{documentId}/approval', [PenerimaanKasController::class, 'approval'])->name('approval');
        Route::post('penerimaan-kas/{documentId}/approve', [PenerimaanKasController::class, 'approve'])->name('approve');
        Route::get('penerimaan-kas/{documentId}/cancel-approval', [PenerimaanKasController::class, 'cancel'])->name('approval.cancel-form');
        Route::post('penerimaan-kas/{documentId}/cancel-approval', [PenerimaanKasController::class, 'cancelApproval'])->name('approval.cancel');
        Route::get('penerimaan-kas/{documentId}/{lineNumber}/get-detail', [PenerimaanKasController::class, 'getDetail'])->name('get.detail');
        Route::get('penerimaan-kas/{documentId}/edit', [PenerimaanKasController::class, 'edit'])->name('edit');
        // Route::get('penerimaan-kas/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        // Route::get('penerimaan-kas/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        // Route::get('penerimaan-kas/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        // Route::get('penerimaan-kas/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        // Route::get('penerimaan-kas/editdetail/{id}/{no}', 'PenerimaanKasController@editDetail')->name('edit.detail');
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
        Route::get('data-pajak', [DataPajakController::class, 'index'])->name('index');
        Route::post('data-pajak/index/json', [DataPajakController::class, 'indexJson'])->name('index.json');
        Route::get('data-pajak/create', [DataPajakController::class, 'create'])->name('create');
        Route::post('data-pajak/store', [DataPajakController::class, 'store'])->name('store');
        Route::get('data-pajak/edit/{tahun}/{bulan}/{nopek}/{jenis}', [DataPajakController::class, 'edit'])->name('edit');
        Route::post('data-pajak/update', [DataPajakController::class, 'update'])->name('update');
        Route::delete('data-pajak/delete', [DataPajakController::class, 'destroy'])->name('delete');
    });
    //end data-pajak

    //proses pajak
    // Route assigned name "proses_pajak.rekap"...
    Route::name('proses_pajak.')->group(function () {
        Route::get('proses-pajak', [PajakTahunanController::class, 'index'])->name('rekap');
        Route::post('proses-pajak/export', [PajakTahunanController::class, 'export'])->name('export.proses');
    });
    //end proses_pajak
 
    //laporan pajak
    // Route assigned name "laporan_pajak.rekap"...
    Route::name('laporan_pajak.')->group(function () {
        Route::get('laporan-pajak', [PajakTahunanController::class, 'rekapLaporan'])->name('rekap');
        Route::post('laporan-pajak/export', [PajakTahunanController::class, 'exportLaporan'])->name('export.laporan');
    });
    //end laporan_pajak

    //bulan-perbendaharaan
    // Route assigned name "bulan_perbendaharaan.index"...
    Route::name('bulan_perbendaharaan.')->group(function () {
        Route::get('bulan-perbendaharaan', [BulanPerbendaharaanController::class, 'index'])->name('index');
        Route::post('bulan-perbendaharaan/index/index-json', [BulanPerbendaharaanController::class, 'indexJson'])->name('index.json');
        Route::get('bulan-perbendaharaan/create', [BulanPerbendaharaanController::class, 'create'])->name('create');
        Route::post('bulan-perbendaharaan/store', [BulanPerbendaharaanController::class, 'store'])->name('store');
        Route::get('bulan-perbendaharaan/edit/{id}', [BulanPerbendaharaanController::class, 'edit'])->name('edit');
        Route::post('bulan-perbendaharaan/update', [BulanPerbendaharaanController::class, 'update'])->name('update');
        Route::delete('bulan-perbendaharaan/delete', [BulanPerbendaharaanController::class, 'destroy'])->name('delete');
    });
    //end bulan-perbendaharaan

    //opening-balance
    // Route assigned name "opening-balance.index"...
    Route::name('opening_balance.')->group(function () {
        Route::get('opening-balance', [OpeningBalanceController::class, 'index'])->name('index');
        Route::post('opening-balance/index/index-json', [OpeningBalanceController::class, 'indexJson'])->name('index.json');
        Route::get('opening-balance/create', [OpeningBalanceController::class, 'create'])->name('create');
        Route::post('opening-balance/store', [OpeningBalanceController::class, 'store'])->name('store');
        Route::get('opening-balance/edit/{id}', [OpeningBalanceController::class, 'edit'])->name('edit');
        Route::post('opening-balance/update', [OpeningBalanceController::class, 'update'])->name('update');
    });
    //end opening-balance

    //Penempatan deposito
    // Route assigned name "penempatan_deposito.index"...
    Route::name('penempatan_deposito.')->group(function () {
        Route::get('penempatan-deposito', [PenempatanDepositoController::class, 'index'])->name('index');
        Route::post('penempatan-deposito/index-json', [PenempatanDepositoController::class, 'indexJson'])->name('index.json');
        Route::post('penempatan-deposito/lineno/json', [PenempatanDepositoController::class, 'linenoJson'])->name('linenoJson');
        Route::post('penempatan-deposito/kurs/json', [PenempatanDepositoController::class, 'kursJson'])->name('kursJson');
        Route::post('penempatan-deposito/kdbank/json', [PenempatanDepositoController::class, 'kdbankJson'])->name('kdbankJson');
        Route::post('penempatan-deposito/nokas/json', [PenempatanDepositoController::class, 'nokasJson'])->name('nokas.json');
        Route::get('penempatan-deposito/create', [PenempatanDepositoController::class, 'create'])->name('create');
        Route::post('penempatan-deposito/store', [PenempatanDepositoController::class, 'store'])->name('store');
        Route::get('penempatan-deposito/edit/{nodok}/{lineno}/{pjg}', [PenempatanDepositoController::class, 'edit'])->name('edit');
        Route::post('penempatan-deposito/update', [PenempatanDepositoController::class, 'update'])->name('update');
        Route::delete('penempatan-deposito/delete', [PenempatanDepositoController::class, 'delete'])->name('delete');
        Route::get('penempatan-deposito/depopjg/{nodok}/{lineno}/{pjg}', [PenempatanDepositoController::class, 'depopjg'])->name('depopjg');
        Route::post('penempatan-deposito/updatedepopjg', [PenempatanDepositoController::class, 'updatedepopjg'])->name('updatedepopjg');
        Route::get('penempatan-deposito/rekap', [PenempatanDepositoController::class, 'rekap'])->name('rekap');
        Route::post('penempatan-deposito/ctkdepo', [PenempatanDepositoController::class, 'ctkdepo'])->name('ctkdepo');
        Route::get('penempatan-deposito/rekaprc/{no}/{id}', [PenempatanDepositoController::class, 'rekaprc'])->name('rekaprc');
        Route::get('penempatan-deposito/rekap_rc/{no}/{id}', [PenempatanDepositoController::class, 'rekap_Rc'])->name('rekap_rc');
        Route::post('penempatan-deposito/exportrc', [PenempatanDepositoController::class, 'exportRc'])->name('export_rc');
    });
    //end penempatan-deposito

    // Perhitungan bagi hasil
    // Route assigned name "perhitungan_bagihasil.index"...
    Route::name('perhitungan_bagihasil.')->group(function () {
        Route::get('perhitungan-bagi-hasil', [PerhitunganBagiHasilController::class, 'index'])->name('index');
        Route::post('perhitungan-bagi-hasil/index-json', [PerhitunganBagiHasilController::class, 'index'])->name('index.search');
        Route::delete('perhitungan-bagi-hasil/delete', [PerhitunganBagiHasilController::class, 'delete'])->name('delete');
        Route::get('perhitungan-bagi-hasil/rekap', [PerhitunganBagiHasilController::class, 'RekapPerhitungan'])->name('rekap');
        Route::post('perhitungan-bagi-hasil/export', [PerhitunganBagiHasilController::class, 'exportPerhitungan'])->name('export');
    });
    //end perhitungan-bagihasil

    //pembayaran Gaji
    // Route assigned name "pembayaran_gaji.index"...
    Route::name('pembayaran_gaji.')->group(function () {
        Route::get('pembayaran-gaji', [PembayaranGajiController::class, 'index'])->name('index');
        Route::post('pembayaran-gaji/index-json', [PembayaranGajiController::class, 'indexJson'])->name('index.json');
        Route::get('pembayaran-gaji/create', [PembayaranGajiController::class, 'create'])->name('create');
        Route::post('pembayaran-gaji/create/json', [PembayaranGajiController::class, 'createJson'])->name('createJson');
        Route::post('pembayaran-gaji/lokasi/json', [PembayaranGajiController::class, 'lokasiJson'])->name('lokasiJson');
        Route::post('pembayaran-gaji/nobukti/json', [PembayaranGajiController::class, 'nobuktiJson'])->name('nobuktiJson');
        Route::post('pembayaran-gaji/store', [PembayaranGajiController::class, 'store'])->name('store');
        Route::post('pembayaran-gaji/store-detail', [PembayaranGajiController::class, 'storeDetail'])->name('store.detail');
        Route::post('pembayaran-gaji/store_app', [PembayaranGajiController::class, 'storeApp'])->name('store.app');
        Route::get('pembayaran-gaji/edit/{no}', [PembayaranGajiController::class, 'edit'])->name('edit');
        Route::get('pembayaran-gaji/editdetail/{id}/{no}', [PembayaranGajiController::class, 'editDetail'])->name('edit.detail');
        Route::post('pembayaran-gaji/update', [PembayaranGajiController::class, 'update'])->name('update');
        Route::post('pembayaran-gaji/update/detail', [PembayaranGajiController::class, 'updateDetail'])->name('update.detail');
        Route::delete('pembayaran-gaji/delete', [PembayaranGajiController::class, 'delete'])->name('delete');
        Route::delete('pembayaran-gaji/deletedetail', [PembayaranGajiController::class, 'deleteDetail'])->name('delete.detail');
        Route::delete('pembayaran-gaji/deletedetail/all', [PembayaranGajiController::class, 'deleteDetailall'])->name('delete.detail.all');
        Route::get('pembayaran-gaji/approv/{id}/{status}', [PembayaranGajiController::class, 'approv'])->name('approv');
        Route::get('pembayaran-gaji/rekap/{docno}', [PembayaranGajiController::class, 'rekap'])->name('rekap');
        Route::post('pembayaran-gaji/export', [PembayaranGajiController::class, 'export'])->name('export');
        Route::get('pembayaran-gaji/rekaprc/{docno}', [PembayaranGajiController::class, 'rekapRc'])->name('rekap_rc');
        Route::post('pembayaran-gaji/exportrc', [PembayaranGajiController::class, 'exportRc'])->name('export_rc');
    });
    //end pembayaran-gaji

    // pembayaran umk
    // Route assigned name "pembayaran_umk.index"...
    Route::name('pembayaran_umk.')->group(function () {
        Route::get('pembayaran-umk', [PembayaranUMKController::class, 'index'])->name('index');
        Route::post('pembayaran-umk/index-json', [PembayaranUMKController::class, 'indexJson'])->name('index.json');
        Route::get('pembayaran-umk/create', [PembayaranUMKController::class, 'create'])->name('create');
        Route::post('pembayaran-umk/create/json', [PembayaranUMKController::class, 'createJson'])->name('createJson');
        Route::post('pembayaran-umk/lokasi/json', [PembayaranUMKController::class, 'lokasiJson'])->name('lokasiJson');
        Route::post('pembayaran-umk/nobukti/json', [PembayaranUMKController::class, 'nobuktiJson'])->name('nobuktiJson');
        Route::post('pembayaran-umk/store', [PembayaranUMKController::class, 'store'])->name('store');
        Route::post('pembayaran-umk/store-detail', [PembayaranUMKController::class, 'storeDetail'])->name('store.detail');
        Route::post('pembayaran-umk/store_app', [PembayaranUMKController::class, 'storeApp'])->name('store.app');
        Route::get('pembayaran-umk/edit/{no}', [PembayaranUMKController::class, 'edit'])->name('edit');
        Route::get('pembayaran-umk/editdetail/{id}/{no}', [PembayaranUMKController::class, 'editDetail'])->name('edit.detail');
        Route::post('pembayaran-umk/update', [PembayaranUMKController::class, 'update'])->name('update');
        Route::post('pembayaran-umk/update/detail', [PembayaranUMKController::class, 'updateDetail'])->name('update.detail');
        Route::delete('pembayaran-umk/delete', [PembayaranUMKController::class, 'delete'])->name('delete');
        Route::delete('pembayaran-umk/deletedetail', [PembayaranUMKController::class, 'deleteDetail'])->name('delete.detail');
        Route::delete('pembayaran-umk/deletedetail/all', [PembayaranUMKController::class, 'deleteDetailall'])->name('delete.detail.all');
        Route::get('pembayaran-umk/approv/{id}/{status}', [PembayaranUMKController::class, 'approv'])->name('approv');
        Route::get('pembayaran-umk/rekap/{docno}', [PembayaranUMKController::class, 'rekap'])->name('rekap');
        Route::post('pembayaran-umk/export', [PembayaranUMKController::class, 'export'])->name('export');
        Route::get('pembayaran-umk/rekaprc/{docno}', [PembayaranUMKController::class, 'rekapRc'])->name('rekap_rc');
        Route::post('pembayaran-umk/exportrc', [PembayaranUMKController::class, 'exportRc'])->name('export_rc');
    });
    //end pembayaran-umk


    // Pembayaran jumk
    // Route assigned name "pembayaran_jumk.index"...
    Route::name('pembayaran_jumk.')->group(function () {
        Route::get('pembayaran-jumk', [PembayaranJUMKController::class, 'index'])->name('index');
        Route::post('pembayaran-jumk/index-json', [PembayaranJUMKController::class, 'indexJson'])->name('index.json');
        Route::get('pembayaran-jumk/create', [PembayaranJUMKController::class, 'create'])->name('create');
        Route::post('pembayaran-jumk/create/json', [PembayaranJUMKController::class, 'createJson'])->name('createJson');
        Route::post('pembayaran-jumk/lokasi/json', [PembayaranJUMKController::class, 'lokasiJson'])->name('lokasiJson');
        Route::post('pembayaran-jumk/nobukti/json', [PembayaranJUMKController::class, 'nobuktiJson'])->name('nobuktiJson');
        Route::post('pembayaran-jumk/store', [PembayaranJUMKController::class, 'store'])->name('store');
        Route::post('pembayaran-jumk/store-detail', [PembayaranJUMKController::class, 'storeDetail'])->name('store.detail');
        Route::post('pembayaran-jumk/store_app', [PembayaranJUMKController::class, 'storeApp'])->name('store.app');
        Route::get('pembayaran-jumk/edit/{no}', [PembayaranJUMKController::class, 'edit'])->name('edit');
        Route::get('pembayaran-jumk/editdetail/{id}/{no}', [PembayaranJUMKController::class, 'editDetail'])->name('edit.detail');
        Route::post('pembayaran-jumk/update', [PembayaranJUMKController::class, 'update'])->name('update');
        Route::post('pembayaran-jumk/update/detail', [PembayaranJUMKController::class, 'updateDetail'])->name('update.detail');
        Route::delete('pembayaran-jumk/delete', [PembayaranJUMKController::class, 'delete'])->name('delete');
        Route::delete('pembayaran-jumk/deletedetail', [PembayaranJUMKController::class, 'deleteDetail'])->name('delete.detail');
        Route::delete('pembayaran-jumk/deletedetail/all', [PembayaranJUMKController::class, 'deleteDetailall'])->name('delete.detail.all');
        Route::get('pembayaran-jumk/approv/{id}/{status}', [PembayaranJUMKController::class, 'approv'])->name('approv');
        Route::get('pembayaran-jumk/rekap/{docno}', [PembayaranJUMKController::class, 'rekap'])->name('rekap');
        Route::post('pembayaran-jumk/export', [PembayaranJUMKController::class, 'export'])->name('export');
        Route::get('pembayaran-jumk/rekaprc/{docno}', [PembayaranJUMKController::class, 'rekapRc'])->name('rekap_rc');
        Route::post('pembayaran-jumk/exportrc', [PembayaranJUMKController::class, 'exportRc'])->name('export_rc');
    });
    //end pembayaran-jumk

    // Pembayaran pbayar
    // Route assigned name "pembayaran_pbayar.index"...
    Route::name('pembayaran_pbayar.')->group(function () {
        Route::get('pembayaran-pbayar', [PembayaranPBayarController::class, 'index'])->name('index');
        Route::post('pembayaran-pbayar/index-json', [PembayaranPBayarController::class, 'indexJson'])->name('index.json');
        Route::get('pembayaran-pbayar/create', [PembayaranPBayarController::class, 'create'])->name('create');
        Route::post('pembayaran-pbayar/create/json', [PembayaranPBayarController::class, 'createJson'])->name('createJson');
        Route::post('pembayaran-pbayar/lokasi/json', [PembayaranPBayarController::class, 'lokasiJson'])->name('lokasiJson');
        Route::post('pembayaran-pbayar/nobukti/json', [PembayaranPBayarController::class, 'nobuktiJson'])->name('nobuktiJson');
        Route::post('pembayaran-pbayar/store', [PembayaranPBayarController::class, 'store'])->name('store');
        Route::post('pembayaran-pbayar/store-detail', [PembayaranPBayarController::class, 'storeDetail'])->name('store.detail');
        Route::post('pembayaran-pbayar/store_app', [PembayaranPBayarController::class, 'storeApp'])->name('store.app');
        Route::get('pembayaran-pbayar/edit/{no}', [PembayaranPBayarController::class, 'edit'])->name('edit');
        Route::get('pembayaran-pbayar/editdetail/{id}/{no}', [PembayaranPBayarController::class, 'editDetail'])->name('edit.detail');
        Route::post('pembayaran-pbayar/update', [PembayaranPBayarController::class, 'update'])->name('update');
        Route::post('pembayaran-pbayar/update/detail', [PembayaranPBayarController::class, 'updateDetail'])->name('update.detail');
        Route::delete('pembayaran-pbayar/delete', [PembayaranPBayarController::class, 'delete'])->name('delete');
        Route::delete('pembayaran-pbayar/deletedetail', [PembayaranPBayarController::class, 'deleteDetail'])->name('delete.detail');
        Route::delete('pembayaran-pbayar/deletedetail/all', [PembayaranPBayarController::class, 'deleteDetailall'])->name('delete.detail.all');
        Route::get('pembayaran-pbayar/approv/{id}/{status}', [PembayaranPBayarController::class, 'approv'])->name('approv');
        Route::get('pembayaran-pbayar/rekap/{docno}', [PembayaranPBayarController::class, 'rekap'])->name('rekap');
        Route::post('pembayaran-pbayar/export', [PembayaranPBayarController::class, 'export'])->name('export');
        Route::get('pembayaran-pbayar/rekaprc/{docno}', [PembayaranPBayarController::class, 'rekapRc'])->name('rekap_rc');
        Route::post('pembayaran-pbayar/exportrc', [PembayaranPBayarController::class, 'exportRc'])->name('export_rc');
        Route::get('pembayaran-pbayar/rekaprc/{docno}', [PembayaranPBayarController::class, 'rekapRc'])->name('rekap_rc');
        Route::post('pembayaran-pbayar/exportrc', [PembayaranPBayarController::class, 'exportRc'])->name('export_rc');
    });
    //end pembayaran-pbayar

    // Rekap Harian Kas
    // Route assigned name "rekap_harian_kas.index"...
    Route::name('rekap_harian_kas.')->group(function () {
        Route::get('rekap-harian-kas', [RekapHarianKasController::class, 'index'])->name('index');
        Route::post('rekap-harian-kas/index-json', [RekapHarianKasController::class, 'indexJson'])->name('index.json');
        Route::post('rekap-harian-kas/jeniskartu/json', [RekapHarianKasController::class, 'JeniskaruJson'])->name('jenis.kartu.json');
        Route::post('rekap-harian-kas/nokas/json', [RekapHarianKasController::class, 'NokasJson'])->name('nokas.json');
        Route::get('rekap-harian-kas/create', [RekapHarianKasController::class, 'create'])->name('create');
        Route::post('rekap-harian-kas/store', [RekapHarianKasController::class, 'store'])->name('store');
        Route::get('rekap-harian-kas/edit/{no}/{id}/{tgl}', [RekapHarianKasController::class, 'edit'])->name('edit');
        Route::post('rekap-harian-kas/update', [RekapHarianKasController::class, 'update'])->name('update');
        Route::delete('rekap-harian-kas/delete', [RekapHarianKasController::class, 'delete'])->name('delete');
        Route::get('rekap-harian-kas/rekap/{no}/{id}/{tanggal}', [RekapHarianKasController::class, 'RekapHarian'])->name('rekap');
        Route::post('rekap-harian-kas/ctkharian', [RekapHarianKasController::class, 'CtkHarian'])->name('ctkharian');
    });
    //end rekap-harian-kas

    // Rekap Periode Kas
    // Route assigned name "rekap_periode_kas.index"...
    Route::name('rekap_periode_kas.')->group(function () {
        Route::get('rekap-periode-kas/create', [RekapPeriodeKasController::class, 'RekapPeriode'])->name('create');
        Route::post('rekap-periode-kas/export', [RekapPeriodeKasController::class, 'exportPeriode'])->name('exportperiode');
        Route::post('rekap-periode-kas/json/nokas', [RekapPeriodeKasController::class, 'nokasJson'])->name('nokas.json');
        Route::post('rekap-periode-kas/json/jk', [RekapPeriodeKasController::class, 'jkJson'])->name('jk.json');
    });
    //end rekap-harian-kas


    //Report Kas Kas Bank
    // Route assigned name "report_kas_bank.index"...
    Route::name('kas_bank.')->group(function () {
        Route::get('kas_bank/report/create1', [KasCashJudexController::class, 'create1'])->name('create1');
        Route::get('kas_bank/search/account', [KasCashJudexController::class, 'searchAccount'])->name('search.account');
        Route::post('kas_bank/report/cetak1', [KasCashJudexController::class, 'cetak1'])->name('cetak1');
        Route::get('kas_bank/report/create2', [KasCashJudexController::class, 'create2'])->name('create2');
        Route::post('kas_bank/report/cetak2', [KasCashJudexController::class, 'cetak2'])->name('cetak2');
        Route::get('kas_bank/report/create3', [KasCashJudexController::class, 'create3'])->name('create3');
        Route::post('kas_bank/report/cetak3', [KasCashJudexController::class, 'cetak3'])->name('cetak3');
        Route::get('kas_bank/report/create4', [KasCashJudexController::class, 'create4'])->name('create4');
        Route::post('kas_bank/report/cetak4', [KasCashJudexController::class, 'cetak4'])->name('cetak4');
        Route::get('kas_bank/report/create5', [KasCashJudexController::class, 'create5'])->name('create5');
        Route::post('kas_bank/report/cetak5', [KasCashJudexController::class, 'cetak5'])->name('cetak5');
        Route::get('kas_bank/report/create6', [KasCashJudexController::class, 'create6'])->name('create6');
        Route::post('kas_bank/report/cetak6', [KasCashJudexController::class, 'cetak6'])->name('cetak6');
        Route::get('kas_bank/report/create7', [KasCashJudexController::class, 'create7'])->name('create7');
        Route::get('kas_bank/report/cetak7', [KasCashJudexController::class, 'cetak7'])->name('cetak7');
        Route::get('kas_bank/report/create8', [KasCashJudexController::class, 'create8'])->name('create8');
        Route::get('kas_bank/report/cetak8', [KasCashJudexController::class, 'cetak8'])->name('cetak8');
        Route::get('kas_bank/report/create9', [KasCashJudexController::class, 'create9'])->name('create9');
        Route::get('kas_bank/report/cetak9', [KasCashJudexController::class, 'cetak9'])->name('cetak9');
        Route::get('kas_bank/report/create10', [KasCashJudexController::class, 'create10'])->name('create10');
        Route::get('kas_bank/search/cj', [KasCashJudexController::class, 'searchCj'])->name('search.cj');
        Route::get('kas_bank/report/cetak10', [KasCashJudexController::class, 'cetak10'])->name('cetak10');
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
