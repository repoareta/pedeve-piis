<?php


use App\Http\Controllers\CustomerManagement\DataPerkaraController;
use App\Http\Controllers\CustomerManagement\MonitoringKinerjaController;
use App\Http\Controllers\CustomerManagement\PencapaianKinerjaController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\AktaController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\DireksiController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\KomisarisController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\PemegangSahamController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\PerizinanController;
use App\Http\Controllers\CustomerManagement\PerusahaanAfiliasi\PerusahaanAfiliasiController;
use App\Http\Controllers\CustomerManagement\RencanaKerjaController;

// Customer Management
Route::prefix('customer_management')->group(function () {

    //data-perkara
    // Route assigned name "data-perkara.index"...
    Route::name('data_erkara.')->group(function () {
        Route::get('data-perkara', [DataPerkaraController::class, 'index'])->name('index');
        Route::post('data-perkara/index/search', [DataPerkaraController::class, 'searchIndex'])->name('search.index');
        Route::get('data-perkara/create', [DataPerkaraController::class, 'create'])->name('create');
        Route::post('data-perkara/store', [DataPerkaraController::class, 'store'])->name('store');
        Route::get('data-perkara/edit/{no}', [DataPerkaraController::class, 'edit'])->name('edit');
        Route::get('data-perkara/detail/{no}', [DataPerkaraController::class, 'detail'])->name('detail');
        Route::post('data-perkara/update', [DataPerkaraController::class, 'update'])->name('update');
        Route::delete('data-perkara/delete', [DataPerkaraController::class, 'delete'])->name('delete');
        Route::get('data-perkara/pihak/search', [DataPerkaraController::class, 'searchPihak'])->name('search.pihak');
        Route::post('data-perkara/show', [DataPerkaraController::class, 'showPihakJson'])->name('show.pihak.json');
        Route::post('data-perkara/pihak', [DataPerkaraController::class, 'pihak'])->name('store.pihak');
        Route::delete('data-perkara/delete/pihak', [DataPerkaraController::class, 'deletePihak'])->name('delete.pihak');

        Route::get('data-perkara/hakim/search', [DataPerkaraController::class, 'searchHakim'])->name('search.hakim');
        Route::post('data-perkara/hakim/show', [DataPerkaraController::class, 'showHakim'])->name('show.json');
        Route::post('data-perkara/hakim', [DataPerkaraController::class, 'hakim'])->name('store.hakim');
        Route::post('data-perkara/hakim/pihak', [DataPerkaraController::class, 'pihakJson'])->name('pihakJson');
        Route::delete('data-perkara/hakim/delete', [DataPerkaraController::class, 'deleteHakim'])->name('delete.hakim');
        
        Route::post('data-perkara/dokumen', [DataPerkaraController::class, 'dokumen'])->name('store.dokumen');
        Route::get('data-perkara/dokumen/search', [DataPerkaraController::class, 'searchDokumen'])->name('search.dokumen');
        Route::post('data-perkara/dokumen/pihak', [DataPerkaraController::class, 'dokumenPihak'])->name('pihakJson');
        Route::delete('data-perkara/dokumen/delete', [DataPerkaraController::class, 'deleteDokumen'])->name('delete.dokumen');
    });
    //end data-perkara

    //monitoring-kinerja
    // Route assigned name "monitoring-kinerja.index"...
    Route::name('monitoring_kinerja.')->group(function () {
        Route::get('monitoring-kinerja', [MonitoringKinerjaController::class, 'index'])->name('index');
        Route::post('monitoring-kinerja/index/search', [MonitoringKinerjaController::class, 'indexJson'])->name('index.json');
        Route::get('monitoring-kinerja/create', [MonitoringKinerjaController::class, 'create'])->name('create');
        Route::post('monitoring-kinerja/store', [MonitoringKinerjaController::class, 'store'])->name('store');
        Route::get('monitoring-kinerja/edit/{no}', [MonitoringKinerjaController::class, 'edit'])->name('edit');
        Route::get('monitoring-kinerja/detail/{no}', [MonitoringKinerjaController::class, 'detail'])->name('detail');
        Route::post('monitoring-kinerja/update', [MonitoringKinerjaController::class, 'update'])->name('update');
        Route::delete('monitoring-kinerja/delete', [MonitoringKinerjaController::class, 'delete'])->name('delete');
    });
    //end monitoring-kinerja

    //rencana-kerja
    // Route assigned name "rencana_kerja.index"...
    Route::name('rencana_kerja.')->group(function () {
        Route::get('rencana-kerja', [RencanaKerjaController::class, 'index'])->name('index');
        Route::post('rencana-kerja/index/search', [RencanaKerjaController::class, 'indexJson'])->name('index.json');
        Route::get('rencana-kerja/create', [RencanaKerjaController::class, 'create'])->name('create');
        Route::post('rencana-kerja/store', [RencanaKerjaController::class, 'store'])->name('store');
        Route::get('rencana-kerja/edit/{no}', [RencanaKerjaController::class, 'edit'])->name('edit');
        Route::get('rencana-kerja/detail/{no}', [RencanaKerjaController::class, 'detail'])->name('detail');
        Route::post('rencana-kerja/update', [RencanaKerjaController::class, 'update'])->name('update');
        Route::delete('rencana-kerja/delete', [RencanaKerjaController::class, 'delete'])->name('delete');
    });
    //end rencana-kerja

    // pencapaian kinerja
    // Route assigned name "pencapaian_kerja.index"...
    Route::name('pencapaian_kinerja.')->group(function () {
        Route::get('pencapaian-kinerja', [PencapaianKinerjaController::class, 'index'])->name('index');
        Route::post('pencapaian-kinerja/search', [PencapaianKinerjaController::class, 'search'])->name('search');
        Route::get('pencapaian-kinerja/export', [PencapaianKinerjaController::class, 'export'])->name('export');
    });
    //end pencapaian kinerja

    // perusahaan afiliasi START
    // Route assigned name "perusahaan-afiliasi.index"...
    Route::name('perusahaan-afiliasi.')->group(function () {
        Route::get('perusahaan-afiliasi', [PerusahaanAfiliasiController::class, 'index'])->name('index');
        Route::get('perusahaan-afiliasi/index_json', [PerusahaanAfiliasiController::class, 'indexJson'])->name('index.json');
        Route::get('perusahaan-afiliasi/create', [PerusahaanAfiliasiController::class, 'create'])->name('create');
        Route::post('perusahaan-afiliasi/store', [PerusahaanAfiliasiController::class, 'store'])->name('store');
        Route::get('perusahaan-afiliasi/edit/{perusahaan_afiliasi}', [PerusahaanAfiliasiController::class, 'edit'])->name('edit');
        Route::post('perusahaan-afiliasi/update/{perusahaan_afiliasi}', [PerusahaanAfiliasiController::class, 'update'])->name('update');
        Route::get('perusahaan-afiliasi/detail/{perusahaan_afiliasi}', [PerusahaanAfiliasiController::class, 'detail'])->name('detail');
        Route::delete('perusahaan-afiliasi/delete', [PerusahaanAfiliasiController::class, 'delete'])->name('delete');

        
        // Matches The "/perusahaan-afiliasi/xxx" URL
        Route::prefix('perusahaan-afiliasi')->group(function () {
            
            // Route assigned name "perusahaan-afiliasi.pemegang_saham.index"...
            Route::name('pemegang_saham.')->group(function () {
                Route::get('{perusahaan_afiliasi}/pemegang-saham', [PemegangSahamController::class, 'indexJson'])->name('index.json');
                Route::get('{perusahaan_afiliasi}/pemegang-saham/{pemegang_saham}', [PemegangSahamController::class, 'show'])->name('show.json');
                Route::post('{perusahaan_afiliasi}/pemegang-saham/store', [PemegangSahamController::class, 'store'])->name('store');
                Route::post('{perusahaan_afiliasi}/pemegang-saham/update/{pemegang_saham}', [PemegangSahamController::class, 'update'])->name('update');
                Route::delete('{perusahaan_afiliasi}/pemegang-saham/{pemegang_saham}', [PemegangSahamController::class, 'delete'])->name('delete');
            });

            // Route assigned name "perusahaan-afiliasi.direksi.index"...
            Route::name('direksi.')->group(function () {
                Route::get('{perusahaan_afiliasi}/direksi', [DireksiController::class, 'indexJson'])->name('index.json');
                Route::get('{perusahaan_afiliasi}/direksi/{direksi}', [DireksiController::class, 'show'])->name('show.json');
                Route::post('{perusahaan_afiliasi}/direksi/store', [DireksiController::class, 'store'])->name('store');
                Route::post('{perusahaan_afiliasi}/direksi/update/{direksi}', [DireksiController::class, 'update'])->name('update');
                Route::delete('{perusahaan_afiliasi}/direksi/{direksi}', [DireksiController::class, 'delete'])->name('delete');
            });

            // Route assigned name "perusahaan-afiliasi.komisaris.index"...
            Route::name('komisaris.')->group(function () {
                Route::get('{perusahaan_afiliasi}/komisaris', [KomisarisController::class, 'indexJson'])->name('index.json');
                Route::get('{perusahaan_afiliasi}/komisaris/{komisaris}', [KomisarisController::class, 'show'])->name('show.json');
                Route::post('{perusahaan_afiliasi}/komisaris/store', [KomisarisController::class, 'store'])->name('store');
                Route::post('{perusahaan_afiliasi}/komisaris/update/{komisaris}', [KomisarisController::class, 'update'])->name('update');
                Route::delete('{perusahaan_afiliasi}/komisaris/{komisaris}', [KomisarisController::class, 'delete'])->name('delete');
            });

            // Route assigned name "perusahaan-afiliasi.perizinan.index"...
            Route::name('perizinan.')->group(function () {
                Route::get('{perusahaan_afiliasi}/perizinan', [PerizinanController::class, 'indexJson'])->name('index.json');
                Route::get('{perusahaan_afiliasi}/perizinan/{perizinan}', [KomisarisController::class, 'show'])->name('show.json');
                Route::post('{perusahaan_afiliasi}/perizinan/store', [KomisarisController::class, 'store'])->name('store');
                Route::post('{perusahaan_afiliasi}/perizinan/update/{perizinan}', [KomisarisController::class, 'update'])->name('update');
                Route::delete('{perusahaan_afiliasi}/perizinan/{perizinan}', [KomisarisController::class, 'delete'])->name('delete');
            });

            // Route assigned name "perusahaan-afiliasi.akta.index"...
            Route::name('akta.')->group(function () {
                Route::get('{perusahaan_afiliasi}/akta', [AktaController::class, 'indexJson'])->name('index.json');
                Route::get('{perusahaan_afiliasi}/akta/{akta}', [AktaController::class, 'show'])->name('show.json');
                Route::post('{perusahaan_afiliasi}/akta/store', [AktaController::class, 'store'])->name('store');
                Route::post('{perusahaan_afiliasi}/akta/update/{akta}', [AktaController::class, 'update'])->name('update');
                Route::delete('{perusahaan_afiliasi}/akta/{akta}', [AktaController::class, 'delete'])->name('delete');
            });
        });
    });
    // perusahaan afiliasi END
});
