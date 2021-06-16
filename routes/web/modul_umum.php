<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('umum')->group(function () {

    // PERJALANAN DINAS START
    // Route assigned name "perjalanan_dinas.index"...
    Route::name('perjalanan_dinas.')->group(function () {
        Route::get('perjalanan_dinas', 'PerjalananDinasController@index')->name('index');
        Route::get('perjalanan_dinas/index_json', 'PerjalananDinasController@indexJson')->name('index.json');
        Route::get('perjalanan_dinas/show_json', 'PerjalananDinasController@showJson')->name('show.json');
        Route::get('perjalanan_dinas/create', 'PerjalananDinasController@create')->name('create');
        Route::post('perjalanan_dinas/store', 'PerjalananDinasController@store')->name('store');
        
        Route::get('perjalanan_dinas/edit/{no_panjar}', 'PerjalananDinasController@edit')->name('edit');
        Route::post('perjalanan_dinas/update/{no_panjar}', 'PerjalananDinasController@update')->name('update');
        Route::delete('perjalanan_dinas/delete', 'PerjalananDinasController@delete')->name('delete');
        Route::post('perjalanan_dinas/export', 'PerjalananDinasController@rowExport')->name('export');
        Route::get('perjalanan_dinas/rekap', 'PerjalananDinasController@rekap')->name('rekap');
        Route::post('perjalanan_dinas/rekap/export', 'PerjalananDinasController@rekapExport')->name('rekap.export');
        // PERJALANAN DINAS END

        // PERJALANAN DINAS DETAIL START
        Route::name('detail.')->group(function () {
            Route::get('perjalanan_dinas/detail/index_json/{no_panjar?}', 'PerjalananDinasDetailController@indexJson')->name('index.json');
            Route::post('perjalanan_dinas/detail/store/{no_panjar?}', 'PerjalananDinasDetailController@store')->name('store');
            Route::get('perjalanan_dinas/detail/show', 'PerjalananDinasDetailController@show')->name('show.json');
            Route::post('perjalanan_dinas/detail/update/{no_panjar}/{no_urut}/{nopek}', 'PerjalananDinasDetailController@update')->name('update');
            Route::delete('perjalanan_dinas/detail/delete', 'PerjalananDinasDetailController@delete')->name('delete');
        });
        
        // PERJALANAN DINAS DETAIL END

        // Route assigned name "perjalanan_dinas.pertanggungjawaban.index"...
        // P PERJALANAN DINAS START
        Route::name('pertanggungjawaban.')->group(function () {
            Route::get('perjalanan_dinas/pertanggungjawaban', 'PerjalananDinasPertanggungJawabanController@index')->name('index');
            Route::get('perjalanan_dinas/pertanggungjawaban/index_json', 'PerjalananDinasPertanggungJawabanController@indexJson')->name('index.json');
            Route::get('perjalanan_dinas/pertanggungjawaban/create', 'PerjalananDinasPertanggungJawabanController@create')->name('create');
            Route::post('perjalanan_dinas/pertanggungjawaban/store', 'PerjalananDinasPertanggungJawabanController@store')->name('store');
            Route::get('perjalanan_dinas/pertanggungjawaban/edit/{no_ppanjar}', 'PerjalananDinasPertanggungJawabanController@edit')->name('edit');
            Route::post('perjalanan_dinas/pertanggungjawaban/update/{no_ppanjar}', 'PerjalananDinasPertanggungJawabanController@update')->name('update');

            Route::delete('perjalanan_dinas/pertanggungjawaban/delete', 'PerjalananDinasPertanggungJawabanController@delete')->name('delete');

            Route::get('perjalanan_dinas/pertanggungjawaban/export/{no_ppanjar}', 'PerjalananDinasPertanggungJawabanController@exportRow')->name('export');
            // P PERJALANAN DINAS END

            // P PERJALANAN DINAS DETAIL START
            Route::get('perjalanan_dinas/pertanggungjawaban/detail/index_json', 'PerjalananDinasPertanggungJawabanDetailController@indexJson')->name('detail.index.json');
            Route::get('perjalanan_dinas/pertanggungjawaban/detail/show', 'PerjalananDinasPertanggungJawabanDetailController@show')->name('detail.show');
            Route::post('perjalanan_dinas/pertanggungjawaban/detail/store', 'PerjalananDinasPertanggungJawabanDetailController@store')->name('detail.store');
            Route::post('perjalanan_dinas/pertanggungjawaban/detail/update/{no_ppanjar}/{no_urut}/{nopek}', 'PerjalananDinasPertanggungJawabanDetailController@update')->name('detail.update');
            Route::delete('perjalanan_dinas/pertanggungjawaban/detail/delete', 'PerjalananDinasPertanggungJawabanDetailController@delete')->name('detail.delete');
            // P PERJALANAN DINAS DETAIL END
        });
    });
    
    // UMK
    // Route assigned name "uang_muka_kerja.index"...
    Route::name('uang_muka_kerja.')->group(function () {
        Route::get('uang_muka_kerja', 'UangMukaKerjaController@index')->name('index');
        Route::post('uang_muka_kerja/search_json', 'UangMukaKerjaController@searchIndex')->name('search.index');
        Route::get('uang_muka_kerja/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('uang_muka_kerja/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('uang_muka_kerja/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('uang_muka_kerja/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('uang_muka_kerja/create', 'UangMukaKerjaController@create')->name('create');
        Route::post('uang_muka_kerja/store', 'UangMukaKerjaController@store')->name('store');
        Route::post('uang_muka_kerja/store_detail', 'UangMukaKerjaController@storeDetail')->name('store.detail');
        Route::post('uang_muka_kerja/store_app', 'UangMukaKerjaController@storeApp')->name('store.app');
        Route::delete('uang_muka_kerja/delete', 'UangMukaKerjaController@delete')->name('delete');
        Route::delete('uang_muka_kerja/delete_detail', 'UangMukaKerjaController@deleteDetail')->name('delete.detail');
        Route::get('uang_muka_kerja/edit/{no}', 'UangMukaKerjaController@edit')->name('edit');
        Route::get('uang_muka_kerja/edit_detail/{id}/{no}', 'UangMukaKerjaController@edit_detail')->name('edit.detail');
        Route::get('uang_muka_kerja/approv/{id}', 'UangMukaKerjaController@approv')->name('approv');
        Route::get('uang_muka_kerja/rekap/{id}', 'UangMukaKerjaController@rekap')->name('rekap');
        Route::get('uang_muka_kerja/rekaprange', 'UangMukaKerjaController@rekapRange')->name('rekap.range');
        Route::post('uang_muka_kerja/rekap/export', 'UangMukaKerjaController@rekapExport')->name('rekap.export');
        Route::post('uang_muka_kerja/rekap/export/range', 'UangMukaKerjaController@rekapExportRange')->name('rekap.export.range');

        Route::get('uang_muka_kerja/show_json', 'UangMukaKerjaController@showJson')->name('show.json');

        // Route assigned name "uang_muka_kerja.pertanggungjawaban.index"...
        Route::name('pertanggungjawaban.')->group(function () {
            // P UANG MUKA KERJA START
            Route::get('uang_muka_kerja/pertanggungjawaban', 'UangMukaKerjaPertanggungJawabanController@index')->name('index');
            Route::get('uang_muka_kerja/pertanggungjawaban/index_json', 'UangMukaKerjaPertanggungJawabanController@indexJson')->name('index.json');
            Route::get('uang_muka_kerja/pertanggungjawaban/create', 'UangMukaKerjaPertanggungJawabanController@create')->name('create');
            Route::post('uang_muka_kerja/pertanggungjawaban/store', 'UangMukaKerjaPertanggungJawabanController@store')->name('store');
            Route::get('uang_muka_kerja/pertanggungjawaban/edit/{no_pumk}', 'UangMukaKerjaPertanggungJawabanController@edit')->name('edit');
            Route::post('uang_muka_kerja/pertanggungjawaban/update/{no_pumk}', 'UangMukaKerjaPertanggungJawabanController@update')->name('update');
            Route::get('uang_muka_kerja/pertanggungjawaban/approval/{no_pumk}', 'UangMukaKerjaPertanggungJawabanController@approv')->name('approval');
            Route::delete('uang_muka_kerja/pertanggungjawaban/delete', 'UangMukaKerjaPertanggungJawabanController@delete')->name('delete');
            Route::get('uang_muka_kerja/pertanggungjawaban/export/{no_pumk}', 'UangMukaKerjaPertanggungJawabanController@exportRow')->name('export');
            Route::post('uang_muka_kerja/pertanggungjawaban/store_app', 'UangMukaKerjaPertanggungJawabanController@storeApp')->name('store.app');
            // P UANG MUKA KERJA END

            // P UANG MUKA KERJA DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('uang_muka_kerja/pertanggungjawaban/detail/index_json', 'UangMukaKerjaPertanggungJawabanDetailController@indexJson')->name('index.json');
                Route::post('uang_muka_kerja/pertanggungjawaban/detail/store', 'UangMukaKerjaPertanggungJawabanDetailController@store')->name('store');
                Route::get('uang_muka_kerja/pertanggungjawaban/detail/show', 'UangMukaKerjaPertanggungJawabanDetailController@show')->name('show.json');
                Route::post('uang_muka_kerja/pertanggungjawaban/detail/update', 'UangMukaKerjaPertanggungJawabanDetailController@update')->name('update');
                Route::delete('uang_muka_kerja/pertanggungjawaban/detail/delete', 'UangMukaKerjaPertanggungJawabanDetailController@delete')->name('delete');
            });
            // P UANG MUKA KERJA DETAIL END
        });
    });
    //END UANG MUKA KERJA
    
    

    // Permintaan Bayar
    // Route assigned name "permintaan_bayar.index"...
    Route::name('permintaan_bayar.')->group(function () {
        Route::get('permintaan_bayar', 'PermintaanBayarController@index')->name('index');
        Route::post('permintaan_bayar/search_index', 'PermintaanBayarController@searchIndex')->name('search.index');
        Route::get('permintaan_bayar/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('permintaan_bayar/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('permintaan_bayar/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('permintaan_bayar/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('permintaan_bayar/create', 'PermintaanBayarController@create')->name('create');
        Route::post('permintaan_bayar/store', 'PermintaanBayarController@store')->name('store');
        Route::post('permintaan_bayar/store_detail', 'PermintaanBayarController@storeDetail')->name('store.detail');
        Route::post('permintaan_bayar/store_app', 'PermintaanBayarController@storeApp')->name('store.app');
        Route::get('permintaan_bayar/edit/{no}', 'PermintaanBayarController@edit')->name('edit');
        Route::get('permintaan_bayar/editdetail/{id}/{no}', 'PermintaanBayarController@editDetail')->name('edit.detail');
        Route::get('permintaan_bayar/approv/{id}', 'PermintaanBayarController@approv')->name('approv');
        Route::delete('permintaan_bayar/delete', 'PermintaanBayarController@delete')->name('delete');
        Route::delete('permintaan_bayar/delete_detail', 'PermintaanBayarController@deleteDetail')->name('delete.detail');
        Route::get('permintaan_bayar/rekap/{id}', 'PermintaanBayarController@rekap')->name('rekap');
        Route::get('permintaan_bayar/rekaprange', 'PermintaanBayarController@rekapRange')->name('rekap.range');
        Route::post('permintaan_bayar/rekap/export', 'PermintaanBayarController@rekapExport')->name('rekap.export');
        Route::post('permintaan_bayar/rekap/export/range', 'PermintaanBayarController@rekapExportRange')->name('rekap.export.range');
    });
    //END PERMINTAAN BAYAR

    Route::name('anggaran.')->group(function () {
        // Anggaran
        Route::get('anggaran', 'AnggaranController@index')->name('index');
        Route::get('anggaran/index_json', 'AnggaranController@indexJson')->name('index.json');
        Route::get('anggaran/create', 'AnggaranController@create')->name('create');
        Route::post('anggaran/store', 'AnggaranController@store')->name('store');
        Route::get('anggaran/edit/{kode_main}', 'AnggaranController@edit')->name('edit');
        Route::post('anggaran/update/{kode_main}', 'AnggaranController@update')->name('update');
        Route::delete('anggaran/delete', 'AnggaranController@delete')->name('delete');
        Route::post('anggaran/rekap/export', 'AnggaranController@rekapExport')->name('rekap.export');
        Route::get('anggaran/report', 'AnggaranController@report')->name('report');
        Route::post('anggaran/report/export', 'AnggaranController@reportExport')->name('report.export');
    
        // ANGGARAN SUBMAIN START
        Route::name('submain.')->group(function () {
            Route::get('anggaran/submain', 'AnggaranSubMainController@index')->name('index');
            Route::get('anggaran/submain/index_json', 'AnggaranSubMainController@indexJson')->name('index.json');
            Route::get('anggaran/submain/create', 'AnggaranSubMainController@create')->name('create');
            Route::post('anggaran/submain/store', 'AnggaranSubMainController@store')->name('store');
            Route::get('anggaran/submain/edit/{kode_main}/{kode_submain}', 'AnggaranSubMainController@edit')->name('edit');
            Route::post('anggaran/submain/update/{kode_main}/{kode_submain}', 'AnggaranSubMainController@update')->name('update');
            Route::delete('anggaran/submain/delete', 'AnggaranSubMainController@delete')->name('delete');
            // ANGGARAN SUBMAIN END

            // ANGGARAN SUBMAIN DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('anggaran/submain/detail', 'AnggaranSubMainDetailController@index')->name('index');
                Route::get('anggaran/submain/detail/index_json', 'AnggaranSubMainDetailController@indexJson')->name('index.json');
                Route::get('anggaran/submain/detail/create', 'AnggaranSubMainDetailController@create')->name('create');
                Route::post('anggaran/submain/detail/store', 'AnggaranSubMainDetailController@store')->name('store');
                Route::get('anggaran/submain/detail/edit/{kode}', 'AnggaranSubMainDetailController@edit')->name('edit');
                Route::post('anggaran/submain/detail/update/{kode}', 'AnggaranSubMainDetailController@update')->name('update');
                Route::delete('anggaran/submain/detail/delete', 'AnggaranSubMainDetailController@delete')->name('delete');
            });
            // ANGGARAN SUBMAIN DETAIL END
        });
    });
    
    
    
    //vendor
    // Route assigned name "vendor.index"...
    Route::name('vendor.')->group(function () {
        Route::get('vendor', 'VendorController@index')->name('index');
        Route::get('vendor/index_json', 'VendorController@indexJson')->name('index.json');
        Route::get('vendor/create', 'VendorController@create')->name('create');
        Route::post('vendor/store', 'VendorController@store')->name('store');
        Route::get('vendor/edit/{id}', 'VendorController@edit')->name('edit');
        Route::delete('vendor/delete', 'VendorController@delete')->name('delete');
    });
    //END VENDOR
});
