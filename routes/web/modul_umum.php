<?php

use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasController;
use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasPertanggungjawabanController;
use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaController;
use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaPertanggungjawabanController;
use App\Http\Controllers\Umum\UangMukaKerja\UangMukaKerjaPertanggungjawabanDetailController;
use App\Http\Controllers\Umum\PermintaanBayarController;
use App\Http\Controllers\Umum\VendorController;
use App\Http\Controllers\Umum\Anggaran\AnggaranController;
use App\Http\Controllers\Umum\Anggaran\AnggaranMappingController;
use App\Http\Controllers\Umum\Anggaran\AnggaranSubmainController;
use App\Http\Controllers\Umum\Anggaran\AnggaranSubmainDetailController;
use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasDetailController;
use App\Http\Controllers\Umum\PerjalananDinas\PerjalananDinasPertanggungjawabanDetailController;

Route::prefix('umum')->name('modul_umum.')->group(function () {

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
        Route::get('perjalanan-dinas/export', [PerjalananDinasController::class, 'rowExport'])->name('export');
        Route::get('perjalanan-dinas/rekap', [PerjalananDinasController::class, 'rekap'])->name('rekap');
        Route::post('perjalanan-dinas/rekap/export', [PerjalananDinasController::class, 'rekapExport'])->name('rekap.export');
        // PERJALANAN DINAS END

        // Matches The "/perusahaan-afiliasi/xxx" URL
        Route::prefix('perjalanan-dinas')->group(function () {
            // PERJALANAN DINAS DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('{no_panjar}/detail/index-json', [PerjalananDinasDetailController::class, 'indexJson'])->name('index.json');
                Route::get('{no_panjar}/detail/create', [PerjalananDinasDetailController::class, 'create'])->name('create');
                Route::post('{no_panjar}/detail/store', [PerjalananDinasDetailController::class, 'store'])->name('store');
                Route::get('{no_panjar}/detail/show', [PerjalananDinasDetailController::class, 'show'])->name('show.json');
                Route::get('{no_panjar}/detail/edit/{no_urut}/{nopek}', [PerjalananDinasDetailController::class, 'edit'])->name('edit');
                Route::post('{no_panjar}/detail/update/{no_urut}/{nopek}', [PerjalananDinasDetailController::class, 'update'])->name('update');
                Route::delete('{no_panjar}/detail/delete', [PerjalananDinasDetailController::class, 'delete'])->name('delete');
            });

            // PERJALANAN DINAS DETAIL END

            // Route assigned name "perjalanan_dinas.pertanggungjawaban.index"...
            // P PERJALANAN DINAS START
            Route::name('pertanggungjawaban.')->group(function () {
                Route::get('pertanggungjawaban', [PerjalananDinasPertanggungjawabanController::class, 'index'])->name('index');
                Route::get('pertanggungjawaban/index-json', [PerjalananDinasPertanggungjawabanController::class, 'indexJson'])->name('index.json');
                Route::get('pertanggungjawaban/create', [PerjalananDinasPertanggungjawabanController::class, 'create'])->name('create');
                Route::post('pertanggungjawaban/store', [PerjalananDinasPertanggungjawabanController::class, 'store'])->name('store');
                Route::get('pertanggungjawaban/edit/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'edit'])->name('edit');
                Route::post('pertanggungjawaban/update/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'update'])->name('update');
                Route::delete('pertanggungjawaban/delete', [PerjalananDinasPertanggungjawabanController::class, 'delete'])->name('delete');
                Route::get('pertanggungjawaban/export/{no_ppanjar}', [PerjalananDinasPertanggungjawabanController::class, 'exportRow'])->name('export');
                // P PERJALANAN DINAS END

                Route::prefix('pertanggungjawaban')->group(function () {
                    // P PERJALANAN DINAS DETAIL START
                    Route::name('detail.')->group(function () {
                        Route::get('{no_ppanjar}/detail/index-json', [PerjalananDinasPertanggungjawabanDetailController::class, 'indexJson'])->name('index.json');
                        Route::get('{no_ppanjar}/detail/create', [PerjalananDinasPertanggungjawabanDetailController::class, 'create'])->name('create');
                        Route::post('{no_ppanjar}/detail/store', [PerjalananDinasPertanggungjawabanDetailController::class, 'store'])->name('store');
                        Route::get('{no_ppanjar}/detail/edit/{no_urut}/{nopek}', [PerjalananDinasPertanggungjawabanDetailController::class, 'edit'])->name('edit');
                        Route::post('{no_ppanjar}/detail/update/{no_urut}/{nopek}', [PerjalananDinasPertanggungjawabanDetailController::class, 'update'])->name('update');
                        Route::delete('{no_ppanjar}/detail/delete', [PerjalananDinasPertanggungjawabanDetailController::class, 'delete'])->name('delete');
                    });

                    // P PERJALANAN DINAS DETAIL END
                });
            });
        });
    });

    // UMK
    // Route assigned name "uang-muka-kerja.index"...
    Route::name('uang_muka_kerja.')->group(function () {
        Route::get('uang-muka-kerja', [UangMukaKerjaController::class, 'index'])->name('index');
        Route::get('uang-muka-kerja/index-json', [UangMukaKerjaController::class, 'indexJson'])->name('index.json');
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
        Route::get('uang-muka-kerja/edit-detail/{id}/{no}', [UangMukaKerjaController::class, 'edit_detail'])->name('edit.detail');
        Route::get('uang-muka-kerja/approve/{id}', [UangMukaKerjaController::class, 'approve'])->name('approve');
        Route::get('uang-muka-kerja/rekap/{id}', [UangMukaKerjaController::class, 'rekap'])->name('rekap');
        Route::get('uang-muka-kerja/rekap-range', [UangMukaKerjaController::class, 'rekapRange'])->name('rekap.range');
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
        Route::get('permintaan-bayar/index-json', [PermintaanBayarController::class, 'indexJson'])->name('index.json');
        Route::get('permintaan-bayar/search/account', 'UangMukaKerjaController@searchAccount')->name('search.account');
        Route::get('permintaan-bayar/search/bagian', 'UangMukaKerjaController@searchBagian')->name('search.bagian');
        Route::get('permintaan-bayar/search/jb', 'UangMukaKerjaController@searchJb')->name('search.jb');
        Route::get('permintaan-bayar/search/cj', 'UangMukaKerjaController@searchCj')->name('search.cj');
        Route::get('permintaan-bayar/create', [PermintaanBayarController::class, 'create'])->name('create');
        Route::post('permintaan-bayar/store', [PermintaanBayarController::class, 'store'])->name('store');
        Route::post('permintaan-bayar/store_detail', [PermintaanBayarController::class, 'storeDetail'])->name('store.detail');
        Route::post('permintaan-bayar/store_app/{no}', [PermintaanBayarController::class, 'storeApp'])->name('store.app');
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
        Route::get('anggaran/edit/{anggaran}', [AnggaranController::class, 'edit'])->name('edit');
        Route::post('anggaran/update/{anggaran}', [AnggaranController::class, 'update'])->name('update');
        Route::delete('anggaran/delete', [AnggaranController::class, 'delete'])->name('delete');
        Route::post('anggaran/rekap/export', [AnggaranController::class, 'rekapExport'])->name('rekap.export');
        Route::get('anggaran/report', [AnggaranController::class, 'report'])->name('report');
        Route::post('anggaran/report/export', [AnggaranController::class, 'reportExport'])->name('report.export');
        Route::get('anggaran/get-by-tahun', [AnggaranController::class, 'getByTahun'])->name('get_by_tahun');

        // ANGGARAN MAPPING
        Route::name('mapping.')->group(function () {
            Route::get('anggaran/mapping', [AnggaranMappingController::class, 'index'])->name('index');
            Route::get('anggaran/mapping/index-json', [AnggaranMappingController::class, 'indexJson'])->name('index.json');
            Route::get('anggaran/mapping/create', [AnggaranMappingController::class, 'create'])->name('create');
            Route::get('anggaran/mapping/ajax-detail-anggaran/{tahun}', [AnggaranMappingController::class, 'ajaxDetailAnggaranList'])->name('ajax_detail_anggaran');
            Route::get('anggaran/mapping/ajax-sanper', [AnggaranMappingController::class, 'ajaxSanper'])->name('ajax_sanper');
            Route::post('anggaran/mapping/store', [AnggaranMappingController::class, 'store'])->name('store');
            Route::get('anggaran/mapping/edit/{anggaranMapping}', [AnggaranMappingController::class, 'edit'])->name('edit');
            Route::put('anggaran/mapping/update/{anggaranMaping}', [AnggaranMappingController::class, 'update'])->name('update');
            Route::delete('anggaran/mapping/delete', [AnggaranMappingController::class, 'delete'])->name('delete');
        });

        // ANGGARAN SUBMAIN START
        Route::name('submain.')->group(function () {
            Route::get('anggaran/submain', [AnggaranSubMainController::class, 'index'])->name('index');
            Route::get('anggaran/submain/index-json', [AnggaranSubMainController::class, 'indexJson'])->name('index.json');
            Route::get('anggaran/submain/create', [AnggaranSubMainController::class, 'create'])->name('create');
            Route::post('anggaran/submain/store', [AnggaranSubMainController::class, 'store'])->name('store');
            Route::get('anggaran/submain/edit/{kode_main}/{anggaran_submain}', [AnggaranSubMainController::class, 'edit'])->name('edit');
            Route::post('anggaran/submain/update/{kode_main}/{anggaran_submain}', [AnggaranSubMainController::class, 'update'])->name('update');
            Route::delete('anggaran/submain/delete', [AnggaranSubMainController::class, 'delete'])->name('delete');
            Route::get('anggaran/submain/get-by-tahun', [AnggaranSubMainController::class, 'getByTahun'])->name('get_by_tahun');
            // ANGGARAN SUBMAIN END

            // ANGGARAN SUBMAIN DETAIL START
            Route::name('detail.')->group(function () {
                Route::get('anggaran/submain/detail', [AnggaranSubMainDetailController::class, 'index'])->name('index');
                Route::get('anggaran/submain/detail/index-json', [AnggaranSubMainDetailController::class, 'indexJson'])->name('index.json');
                Route::get('anggaran/submain/detail/create', [AnggaranSubMainDetailController::class, 'create'])->name('create');
                Route::post('anggaran/submain/detail/store', [AnggaranSubMainDetailController::class, 'store'])->name('store');
                Route::get('anggaran/submain/detail/edit/{kode_submain}/{kode}', [AnggaranSubMainDetailController::class, 'edit'])->name('edit');
                Route::post('anggaran/submain/detail/update/{kode_submain}/{kode}', [AnggaranSubMainDetailController::class, 'update'])->name('update');
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
        Route::get('vendor/edit/{vendor}', [VendorController::class, 'edit'])->name('edit');
        Route::post('vendor/update/{vendor}', [VendorController::class, 'update'])->name('update');
        Route::delete('vendor/delete', [VendorController::class, 'delete'])->name('delete');
    });
    //END VENDOR
});
