<?php

use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasController;
use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasPertanggungjawabanController;

use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaController;
use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaPertanggungjawabanController;
use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaPertanggungjawabanDetailController;

use App\Http\Controllers\Umum\PermintaanBayarController;
use App\Http\Controllers\Umum\VendorController;

use App\Http\Controllers\Umum\Anggaran\AnggaranController;
use App\Http\Controllers\Umum\Anggaran\AnggaranSubmainController;
use App\Http\Controllers\Umum\Anggaran\AnggaranSubmainDetailController;
use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasDetailController;

Route::prefix('umum')->group(function () {

    // PERJALANAN DINAS START
    // Route assigned name "perjalanan_dinas.index"...
    Route::name('perjalanan_dinas.')->group(function () {
        Route::get('perjalanan-dinas', [PerjalananDinasController::class, 'index'])->name('index');
        Route::get('perjalanan-dinas/index-json', [PerjalananDinasController::class, 'indexJson'])->name('index.json');
        Route::get('perjalanan-dinas/show_json', [PerjalananDinasController::class, 'showJson'])->name('show.json');
        Route::get('perjalanan-dinas/create', [PerjalananDinasController::class, 'create'])->name('create');
        Route::post('perjalanan-dinas/store', [PerjalananDinasController::class, 'store'])->name('store');
        Route::get('perjalanan-dinas/edit/{no_panjar}', [PerjalananDinasController::class, 'edit'])->name('edit');
        Route::post('perjalanan-dinas/update/{no_panjar}', [PerjalananDinasController::class, 'update'])->name('update');
        Route::delete('perjalanan-dinas/delete', [PerjalananDinasController::class, 'delete'])->name('delete');
        Route::post('perjalanan-dinas/export', [PerjalananDinasController::class, 'rowExport'])->name('export');
        Route::get('perjalanan-dinas/rekap', [PerjalananDinasController::class, 'rekap'])->name('rekap');
        Route::post('perjalanan-dinas/rekap/export', [PerjalananDinasController::class, 'rekapExport'])->name('rekap.export');
        // PERJALANAN DINAS END

        // PERJALANAN DINAS DETAIL START
        Route::name('detail.')->group(function () {
            Route::get('perjalanan-dinas/detail/index-json/{no_panjar?}', [PerjalananDinasDetailController::class, 'indexJson'])->name('index.json');
            Route::post('perjalanan-dinas/detail/store/{no_panjar?}', [PerjalananDinasController::class, 'store'])->name('store');
            Route::get('perjalanan-dinas/detail/show', [PerjalananDinasController::class, 'show'])->name('show.json');
            Route::post('perjalanan-dinas/detail/update/{no_panjar}/{no_urut}/{nopek}', [PerjalananDinasController::class, 'update'])->name('update');
            Route::delete('perjalanan-dinas/detail/delete', [PerjalananDinasController::class, 'delete'])->name('delete');
        });
        
        // PERJALANAN DINAS DETAIL END

        // Route assigned name "perjalanan_dinas.pertanggungjawaban.index"...
        // P PERJALANAN DINAS START
        Route::name('pertanggungjawaban.')->group(function () {
            Route::get('perjalanan-dinas/pertanggungjawaban', [PerjalananDinasPertanggungjawabanController::class, 'index'])->name('index');
            Route::get('perjalanan-dinas/pertanggungjawaban/index-json', [PerjalananDinasPertanggungjawabanController::class, 'indexJson'])->name('index.json');
            Route::get('perjalanan-dinas/pertanggungjawaban/create', [PerjalananDinasPertanggungjawabanController::class, 'create'])->name('create');
            Route::post('perjalanan-dinas/pertanggungjawaban/store', [PerjalananDinasPertanggungjawabanController::class, 'store'])->name('store');
            Route::get('perjalanan-dinas/pertanggungjawaban/edit/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'edit'])->name('edit');
            Route::post('perjalanan-dinas/pertanggungjawaban/update/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'update'])->name('update');
            Route::delete('perjalanan-dinas/pertanggungjawaban/delete', [PerjalananDinasPertanggungjawabanController::class, 'delete'])->name('delete');
            Route::get('perjalanan-dinas/pertanggungjawaban/export/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'exportRow'])->name('export');
            // P PERJALANAN DINAS END

            // P PERJALANAN DINAS DETAIL START
            Route::get('perjalanan-dinas/pertanggungjawaban/detail/index-json', [PerjalananDinasPertanggungjawabanControllerDetail::class, 'indexJson'])->name('detail.index.json');
            Route::get('perjalanan-dinas/pertanggungjawaban/detail/show', [PerjalananDinasPertanggungjawabanControllerDetail::class, 'show'])->name('detail.show');
            Route::post('perjalanan-dinas/pertanggungjawaban/detail/store', [PerjalananDinasPertanggungjawabanControllerDetail::class, 'store'])->name('detail.store');
            Route::post('perjalanan-dinas/pertanggungjawaban/detail/update/{no_ppanjar}/{no_urut}/{nopek}', [PerjalananDinasPertanggungjawabanControllerDetail::class, 'update'])->name('detail.update');
            Route::delete('perjalanan-dinas/pertanggungjawaban/detail/delete', [PerjalananDinasPertanggungjawabanControllerDetail::class, 'delete'])->name('detail.delete');
            // P PERJALANAN DINAS DETAIL END
        });
    });
    
    // UMK
    // Route assigned name "uang-muka-kerja.index"...
    Route::name('uang_muka_kerja.')->group(function () {
        Route::get('uang-muka-kerja', [UangMukaKerjaController::class, 'index'])->name('index');
        Route::post('uang-muka-kerja/search-json', [UangMukaKerjaController::class, 'searchIndex'])->name('search.index');
        Route::get('uang-muka-kerja/search/account', [UangMukaKerjaController::class, 'searchAccount'])->name('search.account');
        Route::get('uang-muka-kerja/search/bagian', [UangMukaKerjaController::class, 'searchBagian'])->name('search.bagian');
        Route::get('uang-muka-kerja/search/jb', [UangMukaKerjaController::class, 'searchJb'])->name('search.jb');
        Route::get('uang-muka-kerja/search/cj', [UangMukaKerjaController::class, 'searchCj'])->name('search.cj');
        Route::get('uang-muka-kerja/create', [UangMukaKerjaController::class, 'create'])->name('create');
        Route::post('uang-muka-kerja/store', [UangMukaKerjaController::class, 'store'])->name('store');
        Route::post('uang-muka-kerja/store-detail', [UangMukaKerjaController::class, 'storeDetail'])->name('store.detail');
        Route::post('uang-muka-kerja/store-app', [UangMukaKerjaController::class, 'storeApp'])->name('store.app');
        Route::delete('uang-muka-kerja/delete', [UangMukaKerjaController::class, 'delete'])->name('delete');
        Route::delete('uang-muka-kerja/delete-detail', [UangMukaKerjaController::class, 'deleteDetail'])->name('delete.detail');
        Route::get('uang-muka-kerja/edit/{no}', [UangMukaKerjaController::class, 'edit'])->name('edit');
        Route::get('uang-muka-kerja/edit-detail/{id}/{no}', [UangMukaKerjaController::class, 'editDetail'])->name('edit.detail');
        Route::get('uang-muka-kerja/approve/{id}', [UangMukaKerjaController::class, 'approve'])->name('approve');
        Route::get('uang-muka-kerja/rekap/{id}', [UangMukaKerjaController::class, 'rekap'])->name('rekap');
        Route::get('uang-muka-kerja/rekaprange', [UangMukaKerjaController::class, 'rekapRange'])->name('rekap.range');
        Route::post('uang-muka-kerja/rekap/export', [UangMukaKerjaController::class, 'rekapExport'])->name('rekap.export');
        Route::post('uang-muka-kerja/rekap/export/range', [UangMukaKerjaController::class, 'rekapExportRange'])->name('rekap.export.range');
        Route::get('uang-muka-kerja/show-json', [UangMukaKerjaController::class, 'showJson'])->name('show.json');

        // Route assigned name "uang-muka-kerja.pertanggungjawaban.index"...
        Route::name('pertanggungjawaban.')->group(function () {
            // P UANG MUKA KERJA START
            Route::get('uang-muka-kerja/pertanggungjawaban', [UangMukaKerjaPertanggungjawabanController::class, 'index'])->name('index');
            Route::get('uang-muka-kerja/pertanggungjawaban/index-json', [UangMukaKerjaPertanggungjawabanController::class, 'indexJson'])->name('index.json');
            Route::get('uang-muka-kerja/pertanggungjawaban/create', [UangMukaKerjaPertanggungjawabanController::class, 'create'])->name('create');
            Route::post('uang-muka-kerja/pertanggungjawaban/store', [UangMukaKerjaPertanggungjawabanController::class, 'store'])->name('store');
            Route::get('uang-muka-kerja/pertanggungjawaban/edit/{no_pumk}', [UangMukaKerjaPertanggungjawabanController::class, 'edit'])->name('edit');
            Route::post('uang-muka-kerja/pertanggungjawaban/update/{no_pumk}', [UangMukaKerjaPertanggungjawabanController::class, 'update'])->name('update');
            Route::get('uang-muka-kerja/pertanggungjawaban/approve/{no_pumk}', [UangMukaKerjaPertanggungjawabanController::class, 'approve'])->name('approval');
            Route::delete('uang-muka-kerja/pertanggungjawaban/delete', [UangMukaKerjaPertanggungjawabanController::class, 'delete'])->name('delete');
            Route::get('uang-muka-kerja/pertanggungjawaban/export/{no_pumk}', [UangMukaKerjaPertanggungjawabanController::class, 'exportRow'])->name('export');
            Route::post('uang-muka-kerja/pertanggungjawaban/store-app', [UangMukaKerjaPertanggungjawabanController::class, 'storeApp'])->name('store.app');
            // P UANG MUKA KERJA END

            // P UANG MUKA KERJA DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('uang-muka-kerja/pertanggungjawaban/detail/index-json', [UangMukaKerjaPertanggungjawabanDetailController::class, 'indexJson'])->name('index.json');
                Route::post('uang-muka-kerja/pertanggungjawaban/detail/store', [UangMukaKerjaPertanggungjawabanDetailController::class, 'store'])->name('store');
                Route::get('uang-muka-kerja/pertanggungjawaban/detail/show', [UangMukaKerjaPertanggungjawabanDetailController::class, 'show'])->name('show.json');
                Route::post('uang-muka-kerja/pertanggungjawaban/detail/update', [UangMukaKerjaPertanggungjawabanDetailController::class, 'update'])->name('update');
                Route::delete('uang-muka-kerja/pertanggungjawaban/detail/delete', [UangMukaKerjaPertanggungjawabanDetailController::class, 'delete'])->name('delete');
            });
            // P UANG MUKA KERJA DETAIL END
        });
    });
    //END UANG MUKA KERJA
    
    

    // Permintaan Bayar
    // Route assigned name "permintaan-bayar.index"...
    Route::name('permintaan_bayar.')->group(function () {
        Route::get('permintaan-bayar', [PermintaanBayarController::class, 'index'])->name('index');
        Route::post('permintaan-bayar/search-index', [PermintaanBayarController::class, 'searchIndex'])->name('search.index');
        Route::get('permintaan-bayar/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('permintaan-bayar/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('permintaan-bayar/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('permintaan-bayar/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('permintaan-bayar/create', [PermintaanBayarController::class, 'create'])->name('create');
        Route::post('permintaan-bayar/store', [PermintaanBayarController::class, 'store'])->name('store');
        Route::post('permintaan-bayar/store_detail', [PermintaanBayarController::class, 'storeDetail'])->name('store.detail');
        Route::post('permintaan-bayar/store_app', [PermintaanBayarController::class, 'storeApp'])->name('store.app');
        Route::get('permintaan-bayar/edit/{no}', [PermintaanBayarController::class, 'edit'])->name('edit');
        Route::get('permintaan-bayar/editdetail/{id}/{no}', [PermintaanBayarController::class, 'editDetail'])->name('edit.detail');
        Route::get('permintaan-bayar/approv/{id}', [PermintaanBayarController::class, 'approv'])->name('approv');
        Route::delete('permintaan-bayar/delete', [PermintaanBayarController::class, 'delete'])->name('delete');
        Route::delete('permintaan-bayar/delete-detail', [PermintaanBayarController::class, 'deleteDetail'])->name('delete.detail');
        Route::get('permintaan-bayar/rekap/{id}', [PermintaanBayarController::class, 'rekap'])->name('rekap');
        Route::get('permintaan-bayar/rekaprange', [PermintaanBayarController::class, 'rekapRange'])->name('rekap.range');
        Route::post('permintaan-bayar/rekap/export', [PermintaanBayarController::class, 'rekapExport'])->name('rekap.export');
        Route::post('permintaan-bayar/rekap/export/range', [PermintaanBayarController::class, 'rekapExportRange'])->name('rekap.export.range');
    });
    //END PERMINTAAN BAYAR

    Route::name('anggaran.')->group(function () {
        // Anggaran
        Route::get('anggaran', [AnggaranController::class, 'index'])->name('index');
        Route::get('anggaran/index-json', [AnggaranController::class, 'indexJson'])->name('index.json');
        Route::get('anggaran/create', [AnggaranController::class, 'create'])->name('create');
        Route::post('anggaran/store', [AnggaranController::class, 'store'])->name('store');
        Route::get('anggaran/edit/{kode_main}', [AnggaranController::class, 'edit'])->name('edit');
        Route::post('anggaran/update/{kode_main}', [AnggaranController::class, 'update'])->name('update');
        Route::delete('anggaran/delete', [AnggaranController::class, 'delete'])->name('delete');
        Route::post('anggaran/rekap/export', [AnggaranController::class, 'rekapExport'])->name('rekap.export');
        Route::get('anggaran/report', [AnggaranController::class, 'report'])->name('report');
        Route::post('anggaran/report/export', [AnggaranController::class, 'reportExport'])->name('report.export');
    
        // ANGGARAN SUBMAIN START
        Route::name('submain.')->group(function () {
            Route::get('anggaran/submain', [AnggaranSubMainController::class, 'index'])->name('index');
            Route::get('anggaran/submain/index-json', [AnggaranSubMainController::class, 'indexJson'])->name('index.json');
            Route::get('anggaran/submain/create', [AnggaranSubMainController::class, 'create'])->name('create');
            Route::post('anggaran/submain/store', [AnggaranSubMainController::class, 'store'])->name('store');
            Route::get('anggaran/submain/edit/{kode_main}/{kode_submain}', [AnggaranSubMainController::class, 'edit'])->name('edit');
            Route::post('anggaran/submain/update/{kode_main}/{kode_submain}', [AnggaranSubMainController::class, 'update'])->name('update');
            Route::delete('anggaran/submain/delete', [AnggaranSubMainController::class, 'delete'])->name('delete');
            // ANGGARAN SUBMAIN END

            // ANGGARAN SUBMAIN DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('anggaran/submain/detail', [AnggaranSubMainDetailController::class, 'index'])->name('index');
                Route::get('anggaran/submain/detail/index-json', [AnggaranSubMainDetailController::class, 'indexJson'])->name('index.json');
                Route::get('anggaran/submain/detail/create', [AnggaranSubMainDetailController::class, 'create'])->name('create');
                Route::post('anggaran/submain/detail/store', [AnggaranSubMainDetailController::class, 'store'])->name('store');
                Route::get('anggaran/submain/detail/edit/{kode}', [AnggaranSubMainDetailController::class, 'edit'])->name('edit');
                Route::post('anggaran/submain/detail/update/{kode}', [AnggaranSubMainDetailController::class, 'update'])->name('update');
                Route::delete('anggaran/submain/detail/delete', [AnggaranSubMainDetailController::class, 'delete'])->name('delete');
            });
            // ANGGARAN SUBMAIN DETAIL END
        });
    });
    
    
    //vendor
    // Route assigned name "vendor.index"...
    Route::name('vendor.')->group(function () {
        Route::get('vendor', [VendorController::class, 'index'])->name('index');
        Route::get('vendor/index-json', [VendorController::class, 'indexJson'])->name('index.json');
        Route::get('vendor/create', [VendorController::class, 'create'])->name('create');
        Route::post('vendor/store', [VendorController::class, 'store'])->name('store');
        Route::get('vendor/edit/{id}', [VendorController::class, 'edit'])->name('edit');
        Route::delete('vendor/delete', [VendorController::class, 'delete'])->name('delete');
    });
    //END VENDOR
});
