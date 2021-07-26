<?php

use App\Http\Controllers\SdmPayroll\AbsensiKaryawanController;
use App\Http\Controllers\SdmPayroll\HonorKomiteController;
use App\Http\Controllers\SdmPayroll\LemburController;
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
use App\Http\Controllers\SdmPayroll\PinjamanPekerjaController;
use App\Http\Controllers\SdmPayroll\Potongan\PotonganInsentifController;
use App\Http\Controllers\SdmPayroll\Potongan\PotonganKoreksiGajiController;
use App\Http\Controllers\SdmPayroll\Potongan\PotonganManualController;
use App\Http\Controllers\SdmPayroll\Potongan\PotonganOtomatisController;
use App\Http\Controllers\SdmPayroll\ProsesPayroll\ProsesGajiController;
use App\Http\Controllers\SdmPayroll\ProsesPayroll\ProsesInsentifController;
use App\Http\Controllers\SdmPayroll\ProsesPayroll\ProsesThrController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\JamsostekController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\JenisUpahController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\MasterBankController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\MasterTabunganController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\PensiunController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\PtkpController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\RekeningPekerjaController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\TabelAardController;
use App\Http\Controllers\SdmPayroll\TabelPayroll\TunjanganGolonganController;

//MODUL SDM & Payroll

Route::prefix('sdm-payroll')->name('modul_sdm_payroll.')->group(function () {
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
        Route::get('potongan-manual', [PotonganManualController::class, 'index'])->name('index');
        Route::post('potongan-manual/search', [PotonganManualController::class, 'searchIndex'])->name('search.index');
        Route::get('potongan-manual/create', [PotonganManualController::class, 'create'])->name('create');
        Route::post('potongan-manual/store', [PotonganManualController::class, 'store'])->name('store');
        Route::get('potongan-manual/edit/{bulan}/{tahun}/{arrd}/{nopek}', [PotonganManualController::class, 'edit'])->name('edit');
        Route::post('potongan-manual/update', [PotonganManualController::class, 'update'])->name('update');
        Route::delete('potongan-manual/delete', [PotonganManualController::class, 'delete'])->name('delete');
    });
    //end potongan-manual

    //potongan otomatis
    // Route assigned name "potongan-otomatis.index"...
    Route::name('potongan_otomatis.')->group(function () {
        Route::get('potongan-otomatis', [PotonganOtomatisController::class, 'index'])->name('index');
        Route::post('potongan-otomatis/search', [PotonganOtomatisController::class, 'searchIndex'])->name('search.index');
        Route::get('potongan-otomatis/create', [PotonganOtomatisController::class, 'create'])->name('create');
        Route::post('potongan-otomatis/store', [PotonganOtomatisController::class, 'store'])->name('store');
        Route::get('potongan-otomatis/edit/{bulan}/{tahun}/{arrd}/{nopek}', [PotonganOtomatisController::class, 'edit'])->name('edit');
        Route::post('potongan-otomatis/update', [PotonganOtomatisController::class, 'update'])->name('update');
        Route::delete('potongan-otomatis/delete', [PotonganOtomatisController::class, 'delete'])->name('delete');
    });
    //end potongan-otomatis

    //potongan insentif
    // Route assigned name "potongan_insentif.index"...
    Route::name('potongan_insentif.')->group(function () {
        Route::get('potongan-insentif', [PotonganInsentifController::class, 'index'])->name('index');
        Route::post('potongan-insentif/search', [PotonganInsentifController::class, 'searchIndex'])->name('search.index');
        Route::get('potongan-insentif/create', [PotonganInsentifController::class, 'create'])->name('create');
        Route::post('potongan-insentif/store', [PotonganInsentifController::class, 'store'])->name('store');
        Route::get('potongan-insentif/edit/{bulan}/{tahun}/{nopek}', [PotonganInsentifController::class, 'edit'])->name('edit');
        Route::post('potongan-insentif/update', [PotonganInsentifController::class, 'update'])->name('update');
        Route::delete('potongan-insentif/delete', [PotonganInsentifController::class, 'delete'])->name('delete');
    });
    //end potongan insentif

    //honor komite
    // Route assigned name "honor-komite.index"...
    Route::name('honor_komite.')->group(function () {
        Route::get('honor-komite', [HonorKomiteController::class, 'index'])->name('index');
        Route::post('honor-komite/search', [HonorKomiteController::class, 'searchIndex'])->name('search.index');
        Route::get('honor-komite/create', [HonorKomiteController::class, 'create'])->name('create');
        Route::post('honor-komite/store', [HonorKomiteController::class, 'store'])->name('store');
        Route::get('honor-komite/edit/{bulan}/{tahun}/{nopek}', [HonorKomiteController::class, 'edit'])->name('edit');
        Route::post('honor-komite/update', [HonorKomiteController::class, 'update'])->name('update');
        Route::delete('honor-komite/delete', [HonorKomiteController::class, 'delete'])->name('delete');
    });
    //end honor-komite

    // Lembur
    // Route assigned name "lembur.index"...
    Route::name('lembur.')->group(function () {
        Route::get('lembur', [LemburController::class, 'index'])->name('index');
        Route::get('lembur/index-json', [LemburController::class, 'indexJson'])->name('index.json');
        Route::get('lembur/create', [LemburController::class, 'create'])->name('create');
        Route::post('lembur/store', [LemburController::class, 'store'])->name('store');
        Route::get('lembur/edit/{id}/{nopek}', [LemburController::class, 'edit'])->name('edit');
        Route::post('lembur/update', [LemburController::class, 'update'])->name('update');
        Route::delete('lembur/delete', [LemburController::class, 'delete'])->name('delete');
        Route::get('lembur/rekap-lembur', [LemburController::class, 'rekapLembur'])->name('rekap_lembur');
        Route::post('lembur/rekap-lembur/export', [LemburController::class, 'rekapLemburExport'])->name('rekap_lembur.export');
    });
    //end lembur

    //pinjaman pekerja
    Route::name('pinjaman_pekerja.')->group(function () {
        Route::get('pinjaman-pekerja', [PinjamanPekerjaController::class, 'index'])->name('index');
        Route::post('pinjaman-pekerja/search', [PinjamanPekerjaController::class, 'searchIndex'])->name('search.index');
        Route::post('pinjaman-pekerja/idpinjaman/json', [PinjamanPekerjaController::class, 'IdpinjamanJson'])->name('idpinjaman.json');
        Route::get('pinjaman-pekerja/detail/json', [PinjamanPekerjaController::class, 'detailJson'])->name('detail.json');
        Route::get('pinjaman-pekerja/create', [PinjamanPekerjaController::class, 'create'])->name('create');
        Route::post('pinjaman-pekerja/store', [PinjamanPekerjaController::class, 'store'])->name('store');
        Route::get('pinjaman-pekerja/edit/{no}', [PinjamanPekerjaController::class, 'edit'])->name('edit');
        Route::post('pinjaman-pekerja/update', [PinjamanPekerjaController::class, 'update'])->name('update');
        Route::delete('pinjaman-pekerja/delete', [PinjamanPekerjaController::class, 'delete'])->name('delete');
    });
    //end Pinjaman Pekerja
        
    //proses gaji
    // Route assigned name "proses_upah.index"...
    Route::name('proses_gaji.')->group(function () {
        Route::get('proses-gaji', [ProsesGajiController::class, 'index'])->name('index');
        Route::post('proses-gaji/store', [ProsesGajiController::class, 'store'])->name('store');
        Route::get('proses-gaji/edit', [ProsesGajiController::class, 'edit'])->name('edit');
        Route::get('proses-gaji/slip-gaji', [ProsesGajiController::class, 'slipGaji'])->name('slip_gaji');
        Route::post('proses-gaji/slip-gaji/cetak', [ProsesGajiController::class, 'slipGajiExport'])->name('slip_gaji.export');
        Route::get('proses-gaji/rekap-gaji', [ProsesGajiController::class, 'rekapGaji'])->name('rekap_gaji');
        Route::post('proses-gaji/rekap-gaji/export', [ProsesGajiController::class, 'rekapGajiExport'])->name('rekap_gaji.export');
        Route::get('proses-gaji/daftar-upah', [ProsesGajiController::class, 'daftarUpah'])->name('daftar_upah');
        Route::post('proses-gaji/daftar-upah/export', [ProsesGajiController::class, 'daftarUpahExport'])->name('daftar_upah.export');
    });
    //end proses_upah

    //proses thr
    // Route assigned name "proses_thr.index"...
    Route::name('proses_thr.')->group(function () {
        Route::get('proses-thr', [ProsesThrController::class, 'index'])->name('index');
        Route::post('proses-thr/store', [ProsesThrController::class, 'store'])->name('store');
        Route::get('proses-thr/edit', [ProsesThrController::class, 'edit'])->name('edit');
        Route::get('proses-thr/slip-thr', [ProsesThrController::class, 'slipThr'])->name('slip_thr');
        Route::post('proses-thr/slip-thr/cetak', [ProsesThrController::class, 'slipThrExport'])->name('slip_thr.export');
        Route::get('proses-thr/rekap-thr', [ProsesThrController::class, 'rekapThr'])->name('rekap_thr');
        Route::post('proses-thr/rekap-thr/cetak', [ProsesThrController::class, 'rekapThrExport'])->name('rekap_thr.export');
    });
    //end proses_thr

    //proses insentif
    // Route assigned name "proses_insentif.index"...
    Route::name('proses_insentif.')->group(function () {
        Route::get('proses-insentif', [ProsesInsentifController::class, 'index'])->name('index');
        Route::post('proses-insentif/store', [ProsesInsentifController::class, 'store'])->name('store');
        Route::get('proses-insentif/edit', [ProsesInsentifController::class, 'edit'])->name('edit');
        Route::get('proses-insentif/slip-insentif', [ProsesInsentifController::class, 'slipInsentif'])->name('slip_insentif');
        Route::post('proses-insentif/slip-insentif/export', [ProsesInsentifController::class, 'slipInsentifExport'])->name('slip_insentif.export');
        Route::get('proses-insentif/rekap-insentif/', [ProsesInsentifController::class, 'rekapInsentif'])->name('rekap_insentif');
        Route::post('proses-insentif/rekap-insentif/export', [ProsesInsentifController::class, 'rekapInsentifExport'])->name('rekap_insentif.export');
    });
    //end proses_insentif

    //tunjangan golongan
    // Route assigned name "tunjangan_golongan.index"...
    Route::name('tunjangan_golongan.')->group(function () {
        Route::get('tunjangan_golongan', [TunjanganGolonganController::class, 'index'])->name('index');
        Route::get('tunjangan-golongan/index-json', [TunjanganGolonganController::class, 'indexJson'])->name('index.json');
        Route::get('tunjangan-golongan/create', [TunjanganGolonganController::class, 'create'])->name('create');
        Route::post('tunjangan-golongan/cek-golongan/json', [TunjanganGolonganController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('tunjangan-golongan/store', [TunjanganGolonganController::class, 'store'])->name('store');
        Route::get('tunjangan-golongan/edit/{id}', [TunjanganGolonganController::class, 'edit'])->name('edit');
        Route::post('tunjangan-golongan/update', [TunjanganGolonganController::class, 'update'])->name('update');
        Route::delete('tunjangan-golongan/delete', [TunjanganGolonganController::class, 'delete'])->name('delete');
    });
    //end tunjangan_golongan

    //Jenis Upah
    // Route assigned name "jenis_upah.index"...
    Route::name('jenis_upah.')->group(function () {
        Route::get('jenis-upah', [JenisUpahController::class, 'index'])->name('index');
        Route::get('jenis-upah/index-json', [JenisUpahController::class, 'indexJson'])->name('index.json');
        Route::get('jenis-upah/create', [JenisUpahController::class, 'create'])->name('create');
        Route::post('jenis-upah/cek-golongan/json', [JenisUpahController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('jenis-upah/store', [JenisUpahController::class, 'store'])->name('store');
        Route::get('jenis-upah/edit/{id}', [JenisUpahController::class, 'edit'])->name('edit');
        Route::post('jenis-upah/update', [JenisUpahController::class, 'update'])->name('update');
        Route::delete('jenis-upah/delete', [JenisUpahController::class, 'delete'])->name('delete');
    });
    //end jenis-upah

    //Rekening Pekerja
    // Route assigned name "rekening-pekerja.index"...
    Route::name('rekening_pekerja.')->group(function () {
        Route::get('rekening-pekerja', [RekeningPekerjaController::class, 'index'])->name('index');
        Route::get('rekening-pekerja/index-json', [RekeningPekerjaController::class, 'indexJson'])->name('index.json');
        Route::get('rekening-pekerja/create', [RekeningPekerjaController::class, 'create'])->name('create');
        Route::post('rekening-pekerja/cek-golongan/json', [RekeningPekerjaController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('rekening-pekerja/store', [RekeningPekerjaController::class, 'store'])->name('store');
        Route::get('rekening-pekerja/edit/{id}', [RekeningPekerjaController::class, 'edit'])->name('edit');
        Route::post('rekening-pekerja/update', [RekeningPekerjaController::class, 'update'])->name('update');
        Route::delete('rekening-pekerja/delete', [RekeningPekerjaController::class, 'delete'])->name('delete');
    });
    //end rekening-pekerja

    //Tabel AARD
    // Route assigned name "tabel-aard.index"...
    Route::name('tabel_aard.')->group(function () {
        Route::get('tabel-aard', [TabelAardController::class, 'index'])->name('index');
        Route::get('tabel-aard/index-json', [TabelAardController::class, 'indexJson'])->name('index.json');
        Route::get('tabel-aard/create', [TabelAardController::class, 'create'])->name('create');
        Route::post('tabel-aard/cek-golongan/json', [TabelAardController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('tabel-aard/store', [TabelAardController::class, 'store'])->name('store');
        Route::get('tabel-aard/edit/{id}', [TabelAardController::class, 'edit'])->name('edit');
        Route::post('tabel-aard/update', [TabelAardController::class, 'update'])->name('update');
        Route::delete('tabel-aard/delete', [TabelAardController::class, 'delete'])->name('delete');
    });
    //end tabel-aard

    //Master Bank
    // Route assigned name "master-bank.index"...
    Route::name('master_bank.')->group(function () {
        Route::get('master-bank', [MasterBankController::class, 'index'])->name('index');
        Route::get('master-bank/index-json', [MasterBankController::class, 'indexJson'])->name('index.json');
        Route::get('master-bank/create', [MasterBankController::class, 'create'])->name('create');
        Route::post('master-bank/cek-golongan/json', [MasterBankController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('master-bank/store', [MasterBankController::class, 'store'])->name('store');
        Route::get('master-bank/edit/{id}', [MasterBankController::class, 'edit'])->name('edit');
        Route::post('master-bank/update', [MasterBankController::class, 'update'])->name('update');
        Route::delete('master-bank/delete', [MasterBankController::class, 'delete'])->name('delete');
    });
    //end master-bank

    //Master ptkp
    // Route assigned name "master_ptkp.index"...
    Route::name('master_ptkp.')->group(function () {
        Route::get('master-ptkp', [PtkpController::class, 'index'])->name('index');
        Route::get('master-ptkp/index-json', [PtkpController::class, 'indexJson'])->name('index.json');
        Route::get('master-ptkp/create', [PtkpController::class, 'create'])->name('create');
        Route::post('master-ptkp/cek-golongan/json', [PtkpController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('master-ptkp/store', [PtkpController::class, 'store'])->name('store');
        Route::get('master-ptkp/edit/{id}', [PtkpController::class, 'edit'])->name('edit');
        Route::post('master-ptkp/update', [PtkpController::class, 'update'])->name('update');
        Route::delete('master-ptkp/delete', [PtkpController::class, 'delete'])->name('delete');
    });
    //end master ptkp

    //Master Tabungan
    // Route assigned name "master-tabungan.index"...
    Route::name('master_tabungan.')->group(function () {
        Route::get('master-tabungan', [MasterTabunganController::class, 'index'])->name('index');
        Route::get('master-tabungan/index-json', [MasterTabunganController::class, 'indexJson'])->name('index.json');
        Route::get('master-tabungan/create', [MasterTabunganController::class, 'create'])->name('create');
        Route::post('master-tabungan/cek-golongan/json', [MasterTabunganController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('master-tabungan/store', [MasterTabunganController::class, 'store'])->name('store');
        Route::get('master-tabungan/edit/{id}', [MasterTabunganController::class, 'edit'])->name('edit');
        Route::post('master-tabungan/update', [MasterTabunganController::class, 'update'])->name('update');
        Route::delete('master-tabungan/delete', [MasterTabunganController::class, 'delete'])->name('delete');
    });
    //end master-ptkp

    //jamsostek
    // Route assigned name "jamsostek.index"...
    Route::name('jamsostek.')->group(function () {
        Route::get('jamsostek', [JamsostekController::class, 'index'])->name('index');
        Route::get('jamsostek/index-json', [JamsostekController::class, 'indexJson'])->name('index.json');
        Route::get('jamsostek/create', [JamsostekController::class, 'create'])->name('create');
        Route::post('jamsostek/cek-golongan/json', [JamsostekController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('jamsostek/store', [JamsostekController::class, 'store'])->name('store');
        Route::get('jamsostek/edit/{id}', [JamsostekController::class, 'edit'])->name('edit');
        Route::post('jamsostek/update', [JamsostekController::class, 'update'])->name('update');
        Route::delete('jamsostek/delete', [JamsostekController::class, 'delete'])->name('delete');
        Route::get('jamsostek/daftar-iuran', [JamsostekController::class, 'daftarIuran'])->name('daftar_iuran');
        Route::post('jamsostek/rekap-iuran', [JamsostekController::class, 'rekapExport'])->name('rekap.export');
        Route::get('jamsostek/ctkrekapiuranjamsostek', [JamsostekController::class, 'ctkrekapiuranjamsostek'])->name('ctkrekapiuranjamsostek');
        Route::post('jamsostek/rekapiuran/export', [JamsostekController::class, 'rekapIuranExport'])->name('rekapiuran.export');
    });
    //end jamsostek
    
    //pensiun
    // Route assigned name "pensiun.index"...
    Route::name('pensiun.')->group(function () {
        Route::get('pensiun', [PensiunController::class, 'index'])->name('index');
        Route::get('pensiun/index-json', [PensiunController::class, 'indexJson'])->name('index.json');
        Route::get('pensiun/create', [PensiunController::class, 'create'])->name('create');
        Route::post('pensiun/cek-golongan/json', [PensiunController::class, 'cekGolonganJson'])->name('golongan.json');
        Route::post('pensiun/store', [PensiunController::class, 'store'])->name('store');
        Route::get('pensiun/edit/{id}', [PensiunController::class, 'edit'])->name('edit');
        Route::post('pensiun/update', [PensiunController::class, 'update'])->name('update');
        Route::delete('pensiun/delete', [PensiunController::class, 'delete'])->name('delete');
        Route::get('pensiun/daftar-iuran', [PensiunController::class, 'daftarIuran'])->name('daftar_iuran');
        Route::post('pensiun/rekap/export', [PensiunController::class, 'rekapExport'])->name('rekap.export');
        Route::get('pensiun/rekap-iuran', [PensiunController::class, 'rekapIuran'])->name('rekap_iuran');
        Route::post('pensiun/rekap-iuran/export', [PensiunController::class, 'rekapIuranExport'])->name('rekap_iuran.export');
    });
    //end pensiun
    
    //absensi karyawan
    Route::name('absensi_karyawan.')->group(function () {
        Route::get('absensi-karyawan', [AbsensiKaryawanController::class, 'index'])->name('index');
        Route::get('absensi-karyawan/index-json', [AbsensiKaryawanController::class, 'indexJson'])->name('index.json');
        Route::get('absensi-karyawan/download', [AbsensiKaryawanController::class, 'download'])->name('download');
        Route::post('absensi-karyawan/mapping', [AbsensiKaryawanController::class, 'mapping'])->name('mapping');
    });
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
