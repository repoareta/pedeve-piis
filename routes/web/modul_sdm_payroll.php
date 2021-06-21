<?php

use App\Http\Controllers\SdmPayroll\MasterBebanPerusahaan\BebanPerusahaanController;
use App\Http\Controllers\SdmPayroll\MasterData\AgamaController;
use App\Http\Controllers\SdmPayroll\MasterData\KodeBagianController;
use App\Http\Controllers\SdmPayroll\MasterData\KodeJabatanController;
use App\Http\Controllers\SdmPayroll\MasterData\PerguruanTinggiController;
use App\Http\Controllers\SdmPayroll\MasterData\ProvinsiController;
use App\Http\Controllers\SdmPayroll\MasterHutang\HutangController;
use App\Http\Controllers\SdmPayroll\MasterInsentif\InsentifController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\GajiPokokController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\GolonganGajiController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\JabatanController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\KeluargaController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\KursusController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\PekerjaController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\PendidikanController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\PengalamanKerjaController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\PenghargaanController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\SeminarController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\SmkController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\UpahAllInController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\UpahTetapController;
use App\Http\Controllers\SdmPayroll\MasterPekerja\UpahTetapPensiunController;
use App\Http\Controllers\SdmPayroll\MasterThr\ThrController;
use App\Http\Controllers\SdmPayroll\MasterUpah\UpahController;
use App\Http\Controllers\SdmPayroll\Potongan\PotonganKoreksiGajiController;

//MODUL SDM & Payroll

Route::prefix('sdm')->group(function () {
    // Tabel data Master
    // Provinsi START
    // Route assigned name "provinsi.index"...
    Route::name('provinsi.')->group(function () {
        Route::get('provinsi', [ProvinsiController::class, 'index'])->name('index');
        Route::get('provinsi/index-json', [ProvinsiController::class, 'indexJson'])->name('index.json');
        Route::get('provinsi/create', [ProvinsiController::class, 'create'])->name('create');
        Route::post('provinsi/store', [ProvinsiController::class, 'store'])->name('store');
        Route::get('provinsi/edit/{provinsi}', [ProvinsiController::class, 'edit'])->name('edit');
        Route::post('provinsi/update/{provinsi}', [ProvinsiController::class, 'update'])->name('update');
        Route::delete('provinsi/delete', [ProvinsiController::class, 'delete'])->name('delete');
    });
    
    // Provinsi END

    // Perguruan Tinggi START
    // Route assigned name "perguruan-tinggi.index"...
    Route::name('perguruan_tinggi.')->group(function () {
        Route::get('perguruan-tinggi', [PerguruanTinggiController::class, 'index'])->name('index');
        Route::get('perguruan-tinggi/index-json', [PerguruanTinggiController::class, 'indexJson'])->name('index.json');
        Route::get('perguruan-tinggi/create', [PerguruanTinggiController::class, 'create'])->name('create');
        Route::post('perguruan-tinggi/store', [PerguruanTinggiController::class, 'store'])->name('store');
        Route::get('perguruan-tinggi/edit/{perguruan-tinggi}', [PerguruanTinggiController::class, 'edit'])->name('edit');
        Route::post('perguruan-tinggi/update/{perguruan-tinggi}', [PerguruanTinggiController::class, 'update'])->name('update');
        Route::delete('perguruan-tinggi/delete', [PerguruanTinggiController::class, 'delete'])->name('delete');
    });
    
    // Perguruan Tinggi END

    // Kode Bagian START
    // Route assigned name "kode-bagian.index"...
    Route::name('kode_bagian.')->group(function () {
        Route::get('kode-bagian', [KodeBagianController::class, 'index'])->name('index');
        Route::get('kode-bagian/index-json', [KodeBagianController::class, 'indexJson'])->name('index.json');
        Route::get('kode-bagian/create', [KodeBagianController::class, 'create'])->name('create');
        Route::post('kode-bagian/store', [KodeBagianController::class, 'store'])->name('store');
        Route::get('kode-bagian/edit/{kode_bagian}', [KodeBagianController::class, 'edit'])->name('edit');
        Route::post('kode-bagian/update/{kode_bagian}', [KodeBagianController::class, 'update'])->name('update');
        Route::delete('kode-bagian/delete', [KodeBagianController::class, 'delete'])->name('delete');
    });
    // Kode Bagian END

    // Kode Jabatan START
    // Route assigned name "kode-jabatan.index"...
    Route::name('kode_jabatan.')->group(function () {
        Route::get('kode-jabatan', [KodeJabatanController::class, 'index'])->name('index');
        Route::get('kode-jabatan/index-json', [KodeJabatanController::class, 'indexJson'])->name('index.json');
        Route::get('kode-jabatan/index-json-bagian', [KodeJabatanController::class, 'indexJsonByBagian'])->name('index.json.bagian');
        Route::get('kode-jabatan/create', [KodeJabatanController::class, 'create'])->name('create');
        Route::post('kode-jabatan/store', [KodeJabatanController::class, 'store'])->name('store');
        Route::get('kode-jabatan/edit/{kode_bagian}/{kdjab}', [KodeJabatanController::class, 'edit'])->name('edit');
        Route::post('kode-jabatan/update/{kode_bagian}/{kdjab}', [KodeJabatanController::class, 'update'])->name('update');
        Route::delete('kode-jabatan/delete', [KodeJabatanController::class, 'delete'])->name('delete');
    });
    // Kode Jabatan END

    
    // Agama START
    // Route assigned name "agama.index"...
    Route::name('agama.')->group(function () {
        Route::get('agama', [AgamaController::class, 'index'])->name('index');
        Route::get('agama/index-json', [AgamaController::class, 'indexJson'])->name('index.json');
        Route::get('agama/create', [AgamaController::class, 'create'])->name('create');
        Route::post('agama/store', [AgamaController::class, 'store'])->name('store');
        Route::get('agama/edit/{agama}', [AgamaController::class, 'edit'])->name('edit');
        Route::post('agama/update/{agama}', [AgamaController::class, 'update'])->name('update');
        Route::delete('agama/delete', [AgamaController::class, 'delete'])->name('delete');
    });
    
    // Agama END

    // master pekerja START
    // Route assigned name "pekerja.index"...
    Route::name('pekerja.')->group(function () {
        Route::get('pekerja', [PekerjaController::class, 'index'])->name('index');
        Route::get('pekerja/index-json', [PekerjaController::class, 'indexJson'])->name('index.json');
        Route::get('pekerja/show-json/{pekerja}', [PekerjaController::class, 'showJson'])->name('show.json');
        Route::get('pekerja/create', [PekerjaController::class, 'create'])->name('create');
        Route::post('pekerja/store', [PekerjaController::class, 'store'])->name('store');
        Route::get('pekerja/edit/{pekerja}', [PekerjaController::class, 'edit'])->name('edit');
        Route::post('pekerja/update/{pekerja}', [PekerjaController::class, 'update'])->name('update');
        Route::delete('pekerja/delete', [PekerjaController::class, 'delete'])->name('delete');
        
        // Route assigned name "pekerja.keluarga.index"...
        Route::name('keluarga.')->group(function () {
            Route::get('pekerja/keluarga/index-json/{pekerja}', [KeluargaController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/keluarga/store/{pekerja}', [KeluargaController::class, 'store'])->name('store');
            Route::get('pekerja/keluarga/show-json', [KeluargaController::class, 'showJson'])->name('show.json'); // get issue when combine with prefix pekerja
            Route::post('pekerja/keluarga/update/{pekerja}/{status}/{nama}', [KeluargaController::class, 'update'])->name('update');
            Route::delete('pekerja/keluarga/delete', [KeluargaController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.keluarga.index"...
        Route::name('jabatan.')->group(function () {
            Route::get('pekerja/jabatan/index-json/{pekerja}', [JabatanController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/jabatan/store/{pekerja}', [JabatanController::class, 'store'])->name('store');
            Route::get('pekerja/jabatan/show-json', [JabatanController::class, 'showJson'])->name('show.json'); // get issue when combine with prefix pekerja
            Route::post('pekerja/jabatan/update/{pekerja}/{status}/{nama}', [JabatanController::class, 'update'])->name('update');
            Route::delete('pekerja/jabatan/delete', [JabatanController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.gaji-pokok.index"...
        Route::name('gaji_pokok.')->group(function () {
            Route::get('pekerja/gaji-pokok/index-json/{pekerja}', [GajiPokokController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/gaji-pokok/store/{pekerja}', [GajiPokokController::class, 'store'])->name('store');
            Route::get('pekerja/gaji-pokok/show-json', [GajiPokokController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/gaji-pokok/update/{pekerja}/{nilai}', [GajiPokokController::class, 'udpate'])->name('update');
            Route::delete('pekerja/gaji-pokok/delete', [GajiPokokController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.golongan_gaji.index"...
        Route::name('golongan_gaji.')->group(function () {
            Route::get('pekerja/golongan_gaji/index-json/{pekerja}', [GolonganGajiController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/golongan_gaji/store/{pekerja}', [GolonganGajiController::class, 'store'])->name('store');
            Route::get('golongan_gaji/show-json', [GolonganGajiController::class, 'showJson'])->name('show.json'); // get issue when combine with prefix pekerja
            Route::post('pekerja/golongan_gaji/update/{pekerja}/{golongan_gaji}/{tanggal}', [GolonganGajiController::class, 'update'])->name('update');
            Route::delete('pekerja/golongan_gaji/delete', [GolonganGajiController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.kursus.index"...
        Route::name('kursus.')->group(function () {
            Route::get('pekerja/kursus/index-json/{pekerja}', [KursusController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/kursus/store/{pekerja}', [KursusController::class, 'store'])->name('store');
            Route::get('pekerja/kursus/show-json', [KursusController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/kursus/update/{pekerja}/{mulai}/{nama}', [KursusController::class, 'update'])->name('update');
            Route::delete('pekerja/kursus/delete', [KursusController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.pendidikan.index"...
        Route::name('pendidikan.')->group(function () {
            Route::get('pekerja/pendidikan/index-json/{pekerja}', [PendidikanController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/pendidikan/store/{pekerja}', [PendidikanController::class, 'store'])->name('store');
            Route::get('pekerja/pendidikan/show-json', [PendidikanController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/pendidikan/update/{pekerja}/{mulai}/{tempatdidik}/{kodedidik}', [PendidikanController::class, 'update'])->name('update');
            Route::delete('pekerja/pendidikan/delete', [PendidikanController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.penghargaan.index"...
        Route::name('penghargaan.')->group(function () {
            Route::get('pekerja/penghargaan/index-json/{pekerja}', [PenghargaanController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/penghargaan/store/{pekerja}', [PenghargaanController::class, 'store'])->name('store');
            Route::get('pekerja/penghargaan/show-json', [PenghargaanController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/penghargaan/update/{pekerja}/{tanggal}/{nama}', [PenghargaanController::class, 'update'])->name('update');
            Route::delete('pekerja/penghargaan/delete', [PenghargaanController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.pengalaman_kerja.index"...
        Route::name('pengalaman_kerja.')->group(function () {
            Route::get('pekerja/pengalaman_kerja/index-json/{pekerja}', [PengalamanKerjaController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/pengalaman_kerja/store/{pekerja}', [PengalamanKerjaController::class, 'store'])->name('store');
            Route::get('pekerja/pengalaman_kerja/show-json', [PengalamanKerjaController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/pengalaman_kerja/update/{pekerja}/{mulai}/{pangkat}', [PengalamanKerjaController::class, 'update'])->name('update');
            Route::delete('pekerja/pengalaman_kerja/delete', [PengalamanKerjaController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.seminar.index"...
        Route::name('seminar.')->group(function () {
            Route::get('pekerja/seminar/index-json/{pekerja}', [SeminarController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/seminar/store/{pekerja}', [SeminarController::class, 'store'])->name('store');
            Route::get('pekerja/seminar/show-json', [SeminarController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/seminar/update/{pekerja}/{mulai}', [SeminarController::class, 'update'])->name('update');
            Route::delete('pekerja/seminar/delete', [SeminarController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.smk.index"...
        Route::name('smk.')->group(function () {
            Route::get('pekerja/smk/index-json/{pekerja}', [SmkController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/smk/store/{pekerja}', [SmkController::class, 'store'])->name('store');
            Route::get('pekerja/smk/show-json', [SmkController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/smk/update/{pekerja}/{tahun}', [SmkController::class, 'update'])->name('update');
            Route::delete('pekerja/smk/delete', [SmkController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.upah_tetap.index"...
        Route::name('upah_tetap.')->group(function () {
            Route::get('pekerja/upah-tetap/index-json/{pekerja}', [UpahTetapController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/upah-tetap/store/{pekerja}', [UpahTetapController::class, 'store'])->name('store');
            Route::get('pekerja/upah-tetap/show-json', [UpahTetapController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/upah-tetap/update/{pekerja}/{nilai}', [UpahTetapController::class, 'update'])->name('update');
            Route::delete('pekerja/upah-tetap/delete', [UpahTetapController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.upah_tetap_pensiun.index"...
        Route::name('upah_tetap_pensiun.')->group(function () {
            Route::get('pekerja/upah-tetap-pensiun/index-json/{pekerja}', [UpahTetapPensiunController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/upah-tetap-pensiun/store/{pekerja}', [UpahTetapPensiunController::class, 'store'])->name('store');
            Route::get('pekerja/upah-tetap-pensiun/show-json', [UpahTetapPensiunController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/upah-tetap-pensiun/update/{pekerja}/{nilai}', [UpahTetapPensiunController::class, 'update'])->name('update');
            Route::delete('pekerja/upah-tetap-pensiun/delete', [UpahTetapPensiunController::class, 'delete'])->name('delete');
        });

        // Route assigned name "pekerja.upah_all_in.index"...
        Route::name('upah_all_in.')->group(function () {
            Route::get('pekerja/upah-all-in/index-json/{pekerja}', [UpahAllInController::class, 'indexJson'])->name('index.json');
            Route::post('pekerja/upah-all-in/store/{pekerja}', [UpahAllInController::class, 'store'])->name('store');
            Route::get('pekerja/upah-all-in/show-json', [UpahAllInController::class, 'showJson'])->name('show.json');
            Route::post('pekerja/upah-all-in/update/{pekerja}/{nilai}', [UpahAllInController::class, 'update'])->name('update');
            Route::delete('pekerja/upah-all-in/delete', [UpahAllInController::class, 'delete'])->name('delete');
        });
    });
    // Master Pekerja END

    // Master Payroll START
    // Master Upah START
    // Route assigned name "upah.index"...
    Route::name('upah.')->group(function () {
        Route::get('upah', [UpahController::class, 'index'])->name('index');
        Route::get('upah/index-json', [UpahController::class, 'indexJson'])->name('index.json');
        Route::get('upah/create', [UpahController::class, 'create'])->name('create');
        Route::post('upah/store', [UpahController::class, 'store'])->name('store');
        Route::get('upah/edit/{tahun}/{bulan}/{nopek}/{aard}', [UpahController::class, 'edit'])->name('edit');
        Route::post('upah/update/{tahun}/{bulan}/{nopek}/{aard}', [UpahController::class, 'update'])->name('update');
        Route::delete('upah/delete', [UpahController::class, 'delete'])->name('delete');
    });
    // Master Upah END
    
    // Master Insentif START
    Route::name('insentif.')->group(function () {
        Route::get('insentif', [InsentifController::class, 'index'])->name('index');
        Route::get('insentif/index-json', [InsentifController::class, 'indexJson'])->name('index.json');
        Route::get('insentif/create', [InsentifController::class, 'create'])->name('create');
        Route::post('insentif/store', [InsentifController::class, 'store'])->name('store');
        Route::get('insentif/edit/{tahun}/{bulan}/{nopek}/{aard}', [InsentifController::class, 'edit'])->name('edit');
        Route::post('insentif/update/{tahun}/{bulan}/{nopek}/{aard}', [InsentifController::class, 'update'])->name('update');
        Route::delete('insentif/delete', [InsentifController::class, 'delete'])->name('delete');
    });
    // Master Insentif END

    // Master Hutang START
    Route::name('hutang.')->group(function () {
        Route::get('hutang', [HutangController::class, 'index'])->name('index');
        Route::get('hutang/index-json', [HutangController::class, 'indexJson'])->name('index.json');
        Route::get('hutang/create', [HutangController::class, 'create'])->name('create');
        Route::post('hutang/store', [HutangController::class, 'store'])->name('store');
        Route::get('hutang/edit/{tahun}/{bulan}/{nopek}/{aard}', [HutangController::class, 'edit'])->name('edit');
        Route::post('hutang/update/{tahun}/{bulan}/{nopek}/{aard}', [HutangController::class, 'update'])->name('update');
        Route::delete('hutang/delete', [HutangController::class, 'delete'])->name('delete');
    });
    // Master Hutang END

    // Master Beban Perusahaan START
    Route::name('beban_perusahaan.')->group(function () {
        Route::get('beban-perusahaan', [BebanPerusahaanController::class, 'index'])->name('index');
        Route::get('beban-perusahaan/index-json', [BebanPerusahaanController::class, 'indexJson'])->name('index.json');
        Route::get('beban-perusahaan/create', [BebanPerusahaanController::class, 'create'])->name('create');
        Route::post('beban-perusahaan/store', [BebanPerusahaanController::class, 'store'])->name('store');
        Route::get('beban-perusahaan/edit/{tahun}/{bulan}/{nopek}/{aard}', [BebanPerusahaanController::class, 'edit'])->name('edit');
        Route::post('beban-perusahaan/update/{tahun}/{bulan}/{nopek}/{aard}', [BebanPerusahaanController::class, 'update'])->name('update');
        Route::delete('beban-perusahaan/delete', [BebanPerusahaanController::class, 'delete'])->name('delete');
    });
    // Master Beban Perusahaan END

    // Master THR START
    Route::name('thr.')->group(function () {
        Route::get('thr', [ThrController::class, 'index'])->name('index');
        Route::get('thr/index-json', [ThrController::class, 'indexJson'])->name('index.json');
        Route::get('thr/create', [ThrController::class, 'create'])->name('create');
        Route::post('thr/store', [ThrController::class, 'store'])->name('store');
        Route::get('thr/edit/{tahun}/{bulan}/{nopek}/{aard}', [ThrController::class, 'edit'])->name('edit');
        Route::post('thr/update/{tahun}/{bulan}/{nopek}/{aard}', [ThrController::class, 'update'])->name('update');
        Route::delete('thr/delete', [ThrController::class, 'delete'])->name('delete');
    });
    // Master THR END
    // Master Payroll END
    
    //potongan koreksi gaji
    // Route assigned name "potongan-koreksi-gaji.index"...
    Route::name('potongan_koreksi_gaji.')->group(function () {
        Route::get('potongan-koreksi-gaji', [PotonganKoreksiGajiController::class, 'index'])->name('index');
        Route::post('potongan-koreksi-gaji/search', [PotonganKoreksiGajiController::class, 'searchIndex'])->name('search.index');
        Route::get('potongan-koreksi-gaji/create', [PotonganKoreksiGajiController::class, 'create'])->name('create');
        Route::post('potongan-koreksi-gaji/store', [PotonganKoreksiGajiController::class, 'store'])->name('store');
        Route::get('potongan-koreksi-gaji/edit/{bulan}/{tahun}/{arrd}/{nopek}', [PotonganKoreksiGajiController::class, 'edit'])->name('edit');
        Route::post('potongan-koreksi-gaji/update', [PotonganKoreksiGajiController::class, 'update'])->name('update');
        Route::delete('potongan-koreksi-gaji/delete', [PotonganKoreksiGajiController::class, 'delete'])->name('delete');
        Route::get('potongan-koreksi-gaji/koreksi', [PotonganKoreksiGajiController::class, 'ctkKoreksi'])->name('ctkkoreksi');
        Route::post('potongan-koreksi-gaji/koreksi/export', [PotonganKoreksiGajiController::class, 'koreksiExport'])->name('koreksi.export');
    });
    //end potongan-koreksi-gaji

    //potongan manual
    // Route assigned name "potongan_manual.index"...
    Route::name('potongan_manual.')->group(function () {
        Route::get('potongan-manual', 'PotonganManualController@index')->name('index');
        Route::post('potongan-manual/search', 'PotonganManualController@searchIndex')->name('search.index');
        Route::get('potongan-manual/create', 'PotonganManualController@create')->name('create');
        Route::post('potongan-manual/store', 'PotonganManualController@store')->name('store');
        Route::get('potongan-manual/edit/{bulan}/{tahun}/{arrd}/{nopek}', 'PotonganManualController@edit')->name('edit');
        Route::post('potongan-manual/update', 'PotonganManualController@update')->name('update');
        Route::delete('potongan-manual/delete', 'PotonganManualController@delete')->name('delete');
    });
    //end potongan-manual

    //potongan otomatis
    // Route assigned name "potongan_otomatis.index"...
    Route::name('potongan_otomatis.')->group(function () {
        Route::get('potongan_otomatis', 'PotonganOtomatisController@index')->name('index');
        Route::post('potongan_otomatis/search', 'PotonganOtomatisController@searchIndex')->name('search.index');
        Route::get('potongan_otomatis/create', 'PotonganOtomatisController@create')->name('create');
        Route::post('potongan_otomatis/store', 'PotonganOtomatisController@store')->name('store');
        Route::get('potongan_otomatis/edit/{bulan}/{tahun}/{arrd}/{nopek}', 'PotonganOtomatisController@edit')->name('edit');
        Route::post('potongan_otomatis/update', 'PotonganOtomatisController@update')->name('update');
        Route::delete('potongan_otomatis/delete', 'PotonganOtomatisController@delete')->name('delete');
    });
    //end potongan_otomatis

    //potongan insentif
    // Route assigned name "potongan_insentif.index"...
    Route::name('potongan_insentif.')->group(function () {
        Route::get('potongan_insentif', 'PotonganInsentifController@index')->name('index');
        Route::post('potongan_insentif/search', 'PotonganInsentifController@searchIndex')->name('search.index');
        Route::get('potongan_insentif/create', 'PotonganInsentifController@create')->name('create');
        Route::post('potongan_insentif/store', 'PotonganInsentifController@store')->name('store');
        Route::get('potongan_insentif/edit/{bulan}/{tahun}/{nopek}', 'PotonganInsentifController@edit')->name('edit');
        Route::post('potongan_insentif/update', 'PotonganInsentifController@update')->name('update');
        Route::delete('potongan_insentif/delete', 'PotonganInsentifController@delete')->name('delete');
    });
    //end potongan_insentif

    //honor komite
    // Route assigned name "honor_komite.index"...
    Route::name('honor_komite.')->group(function () {
        Route::get('honor_komite', 'HonorKomiteController@index')->name('index');
        Route::post('honor_komite/search', 'HonorKomiteController@searchIndex')->name('search.index');
        Route::get('honor_komite/create', 'HonorKomiteController@create')->name('create');
        Route::post('honor_komite/store', 'HonorKomiteController@store')->name('store');
        Route::get('honor_komite/edit/{bulan}/{tahun}/{nopek}', 'HonorKomiteController@edit')->name('edit');
        Route::post('honor_komite/update', 'HonorKomiteController@update')->name('update');
        Route::delete('honor_komite/delete', 'HonorKomiteController@delete')->name('delete');
    });
    //end honor_komite

    // Lembur
    // Route assigned name "lembur.index"...
    Route::name('lembur.')->group(function () {
        Route::get('lembur', 'LemburController@index')->name('index');
        Route::post('lembur/search', 'LemburController@searchIndex')->name('search.index');
        Route::get('lembur/create', 'LemburController@create')->name('create');
        Route::post('lembur/store', 'LemburController@store')->name('store');
        Route::get('lembur/edit/{id}/{nopek}', 'LemburController@edit')->name('edit');
        Route::post('lembur/update', 'LemburController@update')->name('update');
        Route::delete('lembur/delete', 'LemburController@delete')->name('delete');
        Route::get('lembur/ctkrekaplembur', 'LemburController@ctkrekaplembur')->name('ctkrekaplembur');
        Route::post('lembur/rekap/export', 'LemburController@rekapExport')->name('rekap.export');
    });
    //end lembur

    //pinjaman pekerja
    Route::name('pinjaman_pekerja.')->group(function () {
        Route::get('pinjaman_pekerja', 'PinjamanPekerjaController@index')->name('index');
        Route::post('pinjaman_pekerja/search', 'PinjamanPekerjaController@searchIndex')->name('search.index');
        Route::post('pinjaman_pekerja/idpinjaman/json', 'PinjamanPekerjaController@IdpinjamanJson')->name('idpinjaman.json');
        Route::get('pinjaman_pekerja/detail/json', 'PinjamanPekerjaController@detailJson')->name('detail.json');
        Route::get('pinjaman_pekerja/create', 'PinjamanPekerjaController@create')->name('create');
        Route::post('pinjaman_pekerja/store', 'PinjamanPekerjaController@store')->name('store');
        Route::get('pinjaman_pekerja/edit/{no}', 'PinjamanPekerjaController@edit')->name('edit');
        Route::post('pinjaman_pekerja/update', 'PinjamanPekerjaController@update')->name('update');
        Route::delete('pinjaman_pekerja/delete', 'PinjamanPekerjaController@delete')->name('delete');
    });
        
    //proses gaji
    // Route assigned name "proses_gaji.index"...
    Route::name('proses_gaji.')->group(function () {
        Route::get('proses_gaji', 'ProsesGajiController@index')->name('index');
        Route::post('proses_gaji/store', 'ProsesGajiController@store')->name('store');
        Route::get('proses_gaji/edit', 'ProsesGajiController@edit')->name('edit');
        Route::get('proses_gaji/slip/gaji', 'ProsesGajiController@slipGaji')->name('slipGaji');
        Route::post('proses_gaji/cetak/slipgaji', 'ProsesGajiController@cetak_slipgaji')->name('cetak_slipgaji');
        Route::get('proses_gaji/ctkrekapgaji', 'ProsesGajiController@ctkrekapgaji')->name('ctkrekapgaji');
        Route::post('proses_gaji/rekap/export', 'ProsesGajiController@rekapExport')->name('rekap.export');
        Route::get('proses_gaji/daftar/upah', 'ProsesGajiController@ctkdaftarupah')->name('ctkdaftarupah');
        Route::post('proses_gaji/daftar/upah/export', 'ProsesGajiController@daftarExport')->name('daftar.export');
    });
    //end proses_gaji

    //proses thr
    // Route assigned name "proses_thr.index"...
    Route::name('proses_thr.')->group(function () {
        Route::get('proses_thr', 'ProsesThrController@index')->name('index');
        Route::post('proses_thr/store', 'ProsesThrController@store')->name('store');
        Route::get('proses_thr/edit', 'ProsesThrController@edit')->name('edit');
        Route::get('proses_thr/ctkslipthr', 'ProsesThrController@ctkslipthr')->name('ctkslipthr');
        Route::post('proses_thr/cetak/slipgaji', 'ProsesThrController@cetak_slipthr')->name('cetak_slipthr');
        Route::get('proses_thr/ctkrekapthr', 'ProsesThrController@ctkrekapthr')->name('ctkrekapthr');
        Route::post('proses_thr/rekap/export', 'ProsesThrController@rekapExport')->name('rekap.export');
    });
    //end proses_thr

    //proses insentif
    // Route assigned name "proses_insentif.index"...
    Route::name('proses_insentif.')->group(function () {
        Route::get('proses_insentif', 'ProsesInsentifController@index')->name('index');
        Route::post('proses_insentif/store', 'ProsesInsentifController@store')->name('store');
        Route::get('proses_insentif/edit', 'ProsesInsentifController@edit')->name('edit');
        Route::get('proses_insentif/ctkslipinsentif', 'ProsesInsentifController@ctkslipinsentif')->name('ctkslipinsentif');
        Route::post('proses_insentif/cetak/slipinsentif', 'ProsesInsentifController@cetak_slipinsentif')->name('cetak_slipinsentif');
        Route::get('proses_insentif/ctkrekapinsentif', 'ProsesInsentifController@ctkrekapinsentif')->name('ctkrekapinsentif');
        Route::post('proses_insentif/rekap/export', 'ProsesInsentifController@rekapExport')->name('rekap.export');
    });
    //end proses_insentif

    //tunjangan golongan
    // Route assigned name "tunjangan_golongan.index"...
    Route::name('tunjangan_golongan.')->group(function () {
        Route::get('tunjangan_golongan', 'TunjanganGolonganController@index')->name('index');
        Route::get('tunjangan_golongan/index-json', 'TunjanganGolonganController@indexJson')->name('index.json');
        Route::get('tunjangan_golongan/create', 'TunjanganGolonganController@create')->name('create');
        Route::post('tunjangan_golongan/cek_golongan/json', 'TunjanganGolonganController@cekGolonganJson')->name('golongan.json');
        Route::post('tunjangan_golongan/store', 'TunjanganGolonganController@store')->name('store');
        Route::get('tunjangan_golongan/edit/{id}', 'TunjanganGolonganController@edit')->name('edit');
        Route::post('tunjangan_golongan/update', 'TunjanganGolonganController@update')->name('update');
        Route::delete('tunjangan_golongan/delete', 'TunjanganGolonganController@delete')->name('delete');
    });
    //end tunjangan_golongan

    //Jenis Upah
    // Route assigned name "jenis_upah.index"...
    Route::name('jenis_upah.')->group(function () {
        Route::get('jenis_upah', 'JenisUpahController@index')->name('index');
        Route::get('jenis_upah/index-json', 'JenisUpahController@indexJson')->name('index.json');
        Route::get('jenis_upah/create', 'JenisUpahController@create')->name('create');
        Route::post('jenis_upah/cek_golongan/json', 'JenisUpahController@cekGolonganJson')->name('golongan.json');
        Route::post('jenis_upah/store', 'JenisUpahController@store')->name('store');
        Route::get('jenis_upah/edit/{id}', 'JenisUpahController@edit')->name('edit');
        Route::post('jenis_upah/update', 'JenisUpahController@update')->name('update');
        Route::delete('jenis_upah/delete', 'JenisUpahController@delete')->name('delete');
    });
    //end jenis_upah


    //Rekening Pekerja
    // Route assigned name "rekening_pekerja.index"...
    Route::name('rekening_pekerja.')->group(function () {
        Route::get('rekening_pekerja', 'RekeningPekerjaController@index')->name('index');
        Route::get('rekening_pekerja/index-json', 'RekeningPekerjaController@indexJson')->name('index.json');
        Route::get('rekening_pekerja/create', 'RekeningPekerjaController@create')->name('create');
        Route::post('rekening_pekerja/cek_golongan/json', 'RekeningPekerjaController@cekGolonganJson')->name('golongan.json');
        Route::post('rekening_pekerja/store', 'RekeningPekerjaController@store')->name('store');
        Route::get('rekening_pekerja/edit/{id}', 'RekeningPekerjaController@edit')->name('edit');
        Route::post('rekening_pekerja/update', 'RekeningPekerjaController@update')->name('update');
        Route::delete('rekening_pekerja/delete', 'RekeningPekerjaController@delete')->name('delete');
    });
    //end rekening_pekerja

    //Tabel AARD
    // Route assigned name "tabel_aard.index"...
    Route::name('tabel_aard.')->group(function () {
        Route::get('tabel_aard', 'TabelAardController@index')->name('index');
        Route::get('tabel_aard/index-json', 'TabelAardController@indexJson')->name('index.json');
        Route::get('tabel_aard/create', 'TabelAardController@create')->name('create');
        Route::post('tabel_aard/cek_golongan/json', 'TabelAardController@cekGolonganJson')->name('golongan.json');
        Route::post('tabel_aard/store', 'TabelAardController@store')->name('store');
        Route::get('tabel_aard/edit/{id}', 'TabelAardController@edit')->name('edit');
        Route::post('tabel_aard/update', 'TabelAardController@update')->name('update');
        Route::delete('tabel_aard/delete', 'TabelAardController@delete')->name('delete');
    });
    //end tabel_aard

    //Master Bank
    // Route assigned name "master_bank.index"...
    Route::name('master_bank.')->group(function () {
        Route::get('master_bank', 'MasterBankController@index')->name('index');
        Route::get('master_bank/index-json', 'MasterBankController@indexJson')->name('index.json');
        Route::get('master_bank/create', 'MasterBankController@create')->name('create');
        Route::post('master_bank/cek_golongan/json', 'MasterBankController@cekGolonganJson')->name('golongan.json');
        Route::post('master_bank/store', 'MasterBankController@store')->name('store');
        Route::get('master_bank/edit/{id}', 'MasterBankController@edit')->name('edit');
        Route::post('master_bank/update', 'MasterBankController@update')->name('update');
        Route::delete('master_bank/delete', 'MasterBankController@delete')->name('delete');
    });
    //end master_bank

    //Master ptkp
    // Route assigned name "master_ptkp.index"...
    Route::name('master_ptkp.')->group(function () {
        Route::get('master_ptkp', 'MasterPtkpController@index')->name('index');
        Route::get('master_ptkp/index-json', 'MasterPtkpController@indexJson')->name('index.json');
        Route::get('master_ptkp/create', 'MasterPtkpController@create')->name('create');
        Route::post('master_ptkp/cek_golongan/json', 'MasterPtkpController@cekGolonganJson')->name('golongan.json');
        Route::post('master_ptkp/store', 'MasterPtkpController@store')->name('store');
        Route::get('master_ptkp/edit/{id}', 'MasterPtkpController@edit')->name('edit');
        Route::post('master_ptkp/update', 'MasterPtkpController@update')->name('update');
        Route::delete('master_ptkp/delete', 'MasterPtkpController@delete')->name('delete');
    });
    //end master_ptkp

    //Master Tabungan
    // Route assigned name "master_tabungan.index"...
    Route::name('master_tabungan.')->group(function () {
        Route::get('master_tabungan', 'MasterTabunganController@index')->name('index');
        Route::get('master_tabungan/index-json', 'MasterTabunganController@indexJson')->name('index.json');
        Route::get('master_tabungan/create', 'MasterTabunganController@create')->name('create');
        Route::post('master_tabungan/cek_golongan/json', 'MasterTabunganController@cekGolonganJson')->name('golongan.json');
        Route::post('master_tabungan/store', 'MasterTabunganController@store')->name('store');
        Route::get('master_tabungan/edit/{id}', 'MasterTabunganController@edit')->name('edit');
        Route::post('master_tabungan/update', 'MasterTabunganController@update')->name('update');
        Route::delete('master_tabungan/delete', 'MasterTabunganController@delete')->name('delete');
    });
    //end master_ptkp

    //jamsostek
    // Route assigned name "jamsostek.index"...
    Route::name('jamsostek.')->group(function () {
        Route::get('jamsostek', 'JamsostekController@index')->name('index');
        Route::get('jamsostek/index-json', 'JamsostekController@indexJson')->name('index.json');
        Route::get('jamsostek/create', 'JamsostekController@create')->name('create');
        Route::post('jamsostek/cek_golongan/json', 'JamsostekController@cekGolonganJson')->name('golongan.json');
        Route::post('jamsostek/store', 'JamsostekController@store')->name('store');
        Route::get('jamsostek/edit/{id}', 'JamsostekController@edit')->name('edit');
        Route::post('jamsostek/update', 'JamsostekController@update')->name('update');
        Route::delete('jamsostek/delete', 'JamsostekController@delete')->name('delete');
        Route::get('jamsostek/ctkiuranjs', 'JamsostekController@ctkiuranjs')->name('ctkiuranjs');
        Route::post('jamsostek/rekap/export', 'JamsostekController@rekapExport')->name('rekap.export');
        Route::get('jamsostek/ctkrekapiuranjamsostek', 'JamsostekController@ctkrekapiuranjamsostek')->name('ctkrekapiuranjamsostek');
        Route::post('jamsostek/rekapiuran/export', 'JamsostekController@rekapIuranExport')->name('rekapiuran.export');
    });
    //end jamsostek
    
    //pensiun
    // Route assigned name "pensiun.index"...
    Route::name('pensiun.')->group(function () {
        Route::get('pensiun', 'PensiunController@index')->name('index');
        Route::get('pensiun/index-json', 'PensiunController@indexJson')->name('index.json');
        Route::get('pensiun/create', 'PensiunController@create')->name('create');
        Route::post('pensiun/cek_golongan/json', 'PensiunController@cekGolonganJson')->name('golongan.json');
        Route::post('pensiun/store', 'PensiunController@store')->name('store');
        Route::get('pensiun/edit/{id}', 'PensiunController@edit')->name('edit');
        Route::post('pensiun/update', 'PensiunController@update')->name('update');
        Route::delete('pensiun/delete', 'PensiunController@delete')->name('delete');
        Route::get('pensiun/ctkiuranpensiun', 'PensiunController@ctkiuranpensiun')->name('ctkiuranpensiun');
        Route::post('pensiun/rekap/export', 'PensiunController@rekapExport')->name('rekap.export');
        Route::get('pensiun/ctkrekapiuranpensiun', 'PensiunController@ctkrekapiuranpensiun')->name('ctkrekapiuranpensiun');
        Route::post('pensiun/rekapiuran/export', 'PensiunController@rekapIuranExport')->name('rekapiuran.export');
    });
    //end pensiun
    

    //proses report sdm payroll
    Route::get('report_sdm_payroll', 'ReportSdmPayrollController@index')->name('report_sdm_payroll.index');
    Route::get('report_sdm_payroll/create', 'ReportSdmPayrollController@create')->name('report_sdm_payroll.create');
    Route::get('report_sdm_payroll/edit', 'ReportSdmPayrollController@edit')->name('report_sdm_payroll.edit');
    
    //absensi karyawan
    Route::get('absensi_karyawan', 'AbsensiKaryawanController@index')->name('absensi_karyawan.index');
    Route::get('absensi_karyawan/index-json', 'AbsensiKaryawanController@indexJson')->name('absensi_karyawan.index.json');
    Route::get('absensi_karyawan/download', 'AbsensiKaryawanController@download')->name('absensi_karyawan.download');
    Route::post('absensi_karyawan/mapping', 'AbsensiKaryawanController@mapping')->name('absensi_karyawan.mapping');
    //absensi karyawan


    // GCG
    // Route assigned name "gcg.index"...
    Route::name('gcg.')->group(function () {
        Route::get('gcg', 'GcgController@index')->name('index');

        Route::get('gcg/coc', 'GcgCocController@index')->name('coc.lampiran_satu');
        Route::post('gcg/coc/lampiran_satu_print', 'GcgCocController@lampiranSatuPrint')->name('coc.lampiran_satu.print');
        Route::get('gcg/coc/lampiran_dua', 'GcgCocController@lampiranDua')->name('coc.lampiran_dua');
        Route::post('gcg/coc/lampiran_dua_print', 'GcgCocController@lampiranDuaPrint')->name('coc.lampiran_dua.print');
        
        Route::get('gcg/coi', 'GcgCoiController@index')->name('coi.lampiran_satu');
        Route::post('gcg/coi/lampiran_satu_print', 'GcgCoiController@lampiranSatuPrint')->name('coi.lampiran_satu.print');
        Route::get('gcg/coi/lampiran_dua', 'GcgCoiController@lampiranDua')->name('coi.lampiran_dua');
        Route::post('gcg/coi/lampiran_dua_print', 'GcgCoiController@lampiranDuaPrint')->name('coi.lampiran_dua.print');

        Route::get('gcg/gratifikasi', 'GcgGratifikasiController@index')->name('gratifikasi.index');
        Route::get('gcg/gratifikasi/penerimaan', 'GcgGratifikasiController@penerimaan')->name('gratifikasi.penerimaan');
        Route::post('gcg/gratifikasi/penerimaan/store', 'GcgGratifikasiController@penerimaanStore')->name('gratifikasi.penerimaan.store');

        Route::get('gcg/gratifikasi/pemberian', 'GcgGratifikasiController@pemberian')->name('gratifikasi.pemberian');
        Route::post('gcg/gratifikasi/pemberian/store', 'GcgGratifikasiController@pemberianStore')->name('gratifikasi.pemberian.store');

        Route::get('gcg/gratifikasi/permintaan', 'GcgGratifikasiController@permintaan')->name('gratifikasi.permintaan');
        Route::post('gcg/gratifikasi/permintaan/store', 'GcgGratifikasiController@permintaanStore')->name('gratifikasi.permintaan.store');

        Route::get('gcg/gratifikasi/report/personal', 'GcgGratifikasiController@reportPersonal')->name('gratifikasi.report.personal');
        Route::get('gcg/gratifikasi/report/personal/index-json', 'GcgGratifikasiController@reportPersonalIndexJson')->name('gratifikasi.report.personal.json');
        Route::post('gcg/gratifikasi/report/personal/export', 'GcgGratifikasiController@reportPersonalExport')->name('gratifikasi.report.personal.export');

        Route::get('gcg/gratifikasi/report/management', 'GcgGratifikasiController@reportManagement')->name('gratifikasi.report.management');
        Route::get('gcg/gratifikasi/report/management/index-json', 'GcgGratifikasiController@reportManagementIndexJson')->name('gratifikasi.report.management.json');
        Route::get('gcg/gratifikasi/report/management/export', 'GcgGratifikasiController@reportManagementExport')->name('gratifikasi.report.management.export');

        Route::get('gcg/gratifikasi/edit/{gratifikasi}', 'GcgGratifikasiController@edit')->name('gratifikasi.edit');
        Route::post('gcg/gratifikasi/update/{gratifikasi}', 'GcgGratifikasiController@update')->name('gratifikasi.update');

        Route::get('gcg/sosialisasi', 'GcgSosialisasiController@index')->name('sosialisasi.index');
        Route::get('gcg/sosialisasi/create', 'GcgSosialisasiController@create')->name('sosialisasi.create');
        Route::post('gcg/sosialisasi/store', 'GcgSosialisasiController@store')->name('sosialisasi.store');

        Route::get('gcg/lhkpn', 'GcgLhkpnController@index')->name('lhkpn.index');
        Route::get('gcg/lhkpn/create', 'GcgLhkpnController@create')->name('lhkpn.create');
        Route::post('gcg/lhkpn/store', 'GcgLhkpnController@store')->name('lhkpn.store');
        
        Route::get('gcg/report_boundary', 'GcgReportBoundaryController@index')->name('report_boundary.index');
        Route::get('gcg/report_boundary/export', 'GcgReportBoundaryController@export')->name('report_boundary.export');
    });
    //end GCG
});
