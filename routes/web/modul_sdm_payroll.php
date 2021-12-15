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
use App\Http\Controllers\SdmPayroll\MasterPegawai\GajiPokokController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\GolonganGajiController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\JabatanController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\KeluargaController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\KursusController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\PegawaiController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\PendidikanController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\PengalamanKerjaController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\PenghargaanController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\SeminarController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\SmkController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\UpahAllInController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\UpahTetapController;
use App\Http\Controllers\SdmPayroll\MasterPegawai\UpahTetapPensiunController;
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
        Route::get('perguruan-tinggi/edit/{perguruan_tinggi}', [PerguruanTinggiController::class, 'edit'])->name('edit');
        Route::post('perguruan-tinggi/update/{perguruan_tinggi}', [PerguruanTinggiController::class, 'update'])->name('update');
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
    // Route assigned name "master_pegawai.index"...
    Route::name('master_pegawai.')->group(function () {
        Route::get('master-pegawai', [PegawaiController::class, 'index'])->name('index');
        Route::get('master-pegawai/index-json', [PegawaiController::class, 'indexJson'])->name('index.json');
        Route::get('master-pegawai/show-json/{pegawai}', [PegawaiController::class, 'showJson'])->name('show.json');
        Route::get('master-pegawai/create', [PegawaiController::class, 'create'])->name('create');
        Route::post('master-pegawai/store', [PegawaiController::class, 'store'])->name('store');
        Route::get('master-pegawai/edit/{pegawai}', [PegawaiController::class, 'edit'])->name('edit');
        Route::post('master-pegawai/update/{pegawai}', [PegawaiController::class, 'update'])->name('update');
        Route::delete('master-pegawai/delete', [PegawaiController::class, 'delete'])->name('delete');

        Route::prefix('master-pegawai')->group(function () {
            // Route assigned name "master_pegawai.keluarga.index"...
            Route::name('keluarga.')->group(function () {
                Route::get('{pegawai}/keluarga/index-json', [KeluargaController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/keluarga/create', [KeluargaController::class, 'create'])->name('create');
                Route::post('{pegawai}/keluarga/store', [KeluargaController::class, 'store'])->name('store');
                Route::get('{pegawai}/keluarga/edit/{status}/{nama}', [KeluargaController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/keluarga/update/{status}/{nama}', [KeluargaController::class, 'update'])->name('update');
                Route::delete('{pegawai}/keluarga/delete/{status}/{nama}', [KeluargaController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.keluarga.index"...
            Route::name('jabatan.')->group(function () {
                Route::get('{pegawai}/jabatan/index-json', [JabatanController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/jabatan/create', [JabatanController::class, 'create'])->name('create');
                Route::post('{pegawai}/jabatan/store', [JabatanController::class, 'store'])->name('store');
                Route::get('{pegawai}/jabatan/edit/{mulai}/{kode_bagian}/{kode_jabatan}', [JabatanController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/jabatan/update/{mulai}/{kode_bagian}/{kode_jabatan}', [JabatanController::class, 'update'])->name('update');
                Route::delete('{pegawai}/jabatan/delete', [JabatanController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.gaji-pokok.index"...
            Route::name('gaji_pokok.')->group(function () {
                Route::get('{pegawai}/gaji-pokok/index-json', [GajiPokokController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/gaji-pokok/create', [GajiPokokController::class, 'create'])->name('create');
                Route::post('{pegawai}/gaji-pokok/store', [GajiPokokController::class, 'store'])->name('store');
                Route::get('{pegawai}/gaji-pokok/edit/{nilai}', [GajiPokokController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/gaji-pokok/update/{nilai}', [GajiPokokController::class, 'udpate'])->name('update');
                Route::delete('{pegawai}/gaji-pokok/delete', [GajiPokokController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.golongan_gaji.index"...
            Route::name('golongan_gaji.')->group(function () {
                Route::get('{pegawai}/golongan-gaji/index-json', [GolonganGajiController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/golongan-gaji/create', [GolonganGajiController::class, 'create'])->name('create');
                Route::post('{pegawai}/golongan-gaji/store', [GolonganGajiController::class, 'store'])->name('store');
                Route::get('{pegawai}/golongan-gaji/edit/{golongan_gaji}/{tanggal}', [GolonganGajiController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/golongan-gaji/update/{golongan_gaji}/{tanggal}', [GolonganGajiController::class, 'update'])->name('update');
                Route::delete('{pegawai}/golongan-gaji/delete', [GolonganGajiController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.kursus.index"...
            Route::name('kursus.')->group(function () {
                Route::get('{pegawai}/kursus/index-json', [KursusController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/kursus/create', [KursusController::class, 'create'])->name('create');
                Route::post('{pegawai}/kursus/store', [KursusController::class, 'store'])->name('store');
                Route::get('{pegawai}/kursus/edit/{mulai}/{nama}', [KursusController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/kursus/update/{mulai}/{nama}', [KursusController::class, 'update'])->name('update');
                Route::delete('{pegawai}/kursus/delete', [KursusController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.pendidikan.index"...
            Route::name('pendidikan.')->group(function () {
                Route::get('{pegawai}/pendidikan/index-json', [PendidikanController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/pendidikan/create', [PendidikanController::class, 'create'])->name('create');
                Route::post('{pegawai}/pendidikan/store', [PendidikanController::class, 'store'])->name('store');
                Route::get('{pegawai}/pendidikan/edit/{mulai}/{tempatdidik}/{kodedidik}', [PendidikanController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/pendidikan/update/{mulai}/{tempatdidik}/{kodedidik}', [PendidikanController::class, 'update'])->name('update');
                Route::delete('{pegawai}/pendidikan/delete', [PendidikanController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.penghargaan.index"...
            Route::name('penghargaan.')->group(function () {
                Route::get('{pegawai}/penghargaan/index-json', [PenghargaanController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/penghargaan/create', [PenghargaanController::class, 'create'])->name('create');
                Route::post('{pegawai}/penghargaan/store', [PenghargaanController::class, 'store'])->name('store');
                Route::get('{pegawai}/penghargaan/edit/{tanggal}/{nama}', [PenghargaanController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/penghargaan/update/{tanggal}/{nama}', [PenghargaanController::class, 'update'])->name('update');
                Route::delete('{pegawai}/penghargaan/delete', [PenghargaanController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.pengalaman_kerja.index"...
            Route::name('pengalaman_kerja.')->group(function () {
                Route::get('{pegawai}/pengalaman-kerja/index-json', [PengalamanKerjaController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/pengalaman-kerja/create', [PengalamanKerjaController::class, 'create'])->name('create');
                Route::post('{pegawai}/pengalaman-kerja/store', [PengalamanKerjaController::class, 'store'])->name('store');
                Route::get('{pegawai}/pengalaman-kerja/edit/{mulai}/{pangkat}', [PengalamanKerjaController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/pengalaman-kerja/update/{mulai}/{pangkat}', [PengalamanKerjaController::class, 'update'])->name('update');
                Route::delete('{pegawai}/pengalaman-kerja/delete', [PengalamanKerjaController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.seminar.index"...
            Route::name('seminar.')->group(function () {
                Route::get('{pegawai}/seminar/index-json', [SeminarController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/seminar/create', [SeminarController::class, 'create'])->name('create');
                Route::post('{pegawai}/seminar/store', [SeminarController::class, 'store'])->name('store');
                Route::get('{pegawai}/seminar/edit/{mulai}', [SeminarController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/seminar/update/{mulai}', [SeminarController::class, 'update'])->name('update');
                Route::delete('{pegawai}/seminar/delete', [SeminarController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.smk.index"...
            Route::name('smk.')->group(function () {
                Route::get('{pegawai}/smk/index-json', [SmkController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/smk/create', [SmkController::class, 'create'])->name('create');
                Route::post('{pegawai}/smk/store', [SmkController::class, 'store'])->name('store');
                Route::get('{pegawai}/smk/edit/{tahun}', [SmkController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/smk/update/{tahun}', [SmkController::class, 'update'])->name('update');
                Route::delete('{pegawai}/smk/delete', [SmkController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.upah_tetap.index"...
            Route::name('upah_tetap.')->group(function () {
                Route::get('{pegawai}/upah-tetap/index-json', [UpahTetapController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/upah-tetap/create', [UpahTetapController::class, 'create'])->name('create');
                Route::post('{pegawai}/upah-tetap/store', [UpahTetapController::class, 'store'])->name('store');
                Route::get('{pegawai}/upah-tetap/edit/{nilai}', [UpahTetapController::class, 'nilai'])->name('nilai');
                Route::post('{pegawai}/upah-tetap/update/{nilai}', [UpahTetapController::class, 'update'])->name('update');
                Route::delete('{pegawai}/upah-tetap/delete', [UpahTetapController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.upah_tetap_pensiun.index"...
            Route::name('upah_tetap_pensiun.')->group(function () {
                Route::get('{pegawai}/upah-tetap-pensiun/index-json', [UpahTetapPensiunController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/upah-tetap-pensiun/create', [UpahTetapPensiunController::class, 'create'])->name('create');
                Route::post('{pegawai}/upah-tetap-pensiun/store', [UpahTetapPensiunController::class, 'store'])->name('store');
                Route::get('{pegawai}/upah-tetap-pensiun/edit/{nilai}', [UpahTetapPensiunController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/upah-tetap-pensiun/update/{nilai}', [UpahTetapPensiunController::class, 'update'])->name('update');
                Route::delete('{pegawai}/upah-tetap-pensiun/delete', [UpahTetapPensiunController::class, 'delete'])->name('delete');
            });

            // Route assigned name "master_pegawai.upah_all_in.index"...
            Route::name('upah_all_in.')->group(function () {
                Route::get('{pegawai}/upah-all-in/index-json', [UpahAllInController::class, 'indexJson'])->name('index.json');
                Route::get('{pegawai}/upah-all-in/create', [UpahAllInController::class, 'create'])->name('create');
                Route::post('{pegawai}/upah-all-in/store', [UpahAllInController::class, 'store'])->name('store');
                Route::get('{pegawai}/upah-all-in/edit/{nilai}', [UpahAllInController::class, 'edit'])->name('edit');
                Route::post('{pegawai}/upah-all-in/update/{nilai}', [UpahAllInController::class, 'update'])->name('update');
                Route::delete('{pegawai}/upah-all-in/delete', [UpahAllInController::class, 'delete'])->name('delete');
            });
        });
    });
    // Master Pekerja END

    // Master Payroll START
    // Master Upah START
    // Route assigned name "upah.index"...
    Route::name('master_upah.')->group(function () {
        Route::get('master-upah', [UpahController::class, 'index'])->name('index');
        Route::get('master-upah/index-json', [UpahController::class, 'indexJson'])->name('index.json');
        Route::get('master-upah/create', [UpahController::class, 'create'])->name('create');
        Route::post('master-upah/store', [UpahController::class, 'store'])->name('store');
        Route::get('master-upah/edit/{tahun}/{bulan}/{nopek}/{aard}', [UpahController::class, 'edit'])->name('edit');
        Route::post('master-upah/update/{tahun}/{bulan}/{nopek}/{aard}', [UpahController::class, 'update'])->name('update');
        Route::delete('master-upah/delete', [UpahController::class, 'delete'])->name('delete');
    });
    // Master Upah END

    // Master Insentif START
    Route::name('master_insentif.')->group(function () {
        Route::get('master-insentif', [InsentifController::class, 'index'])->name('index');
        Route::get('master-insentif/index-json', [InsentifController::class, 'indexJson'])->name('index.json');
        Route::get('master-insentif/create', [InsentifController::class, 'create'])->name('create');
        Route::post('master-insentif/store', [InsentifController::class, 'store'])->name('store');
        Route::get('master-insentif/edit/{tahun}/{bulan}/{nopek}/{aard}', [InsentifController::class, 'edit'])->name('edit');
        Route::post('master-insentif/update/{tahun}/{bulan}/{nopek}/{aard}', [InsentifController::class, 'update'])->name('update');
        Route::delete('master-insentif/delete', [InsentifController::class, 'delete'])->name('delete');
    });
    // Master Insentif END

    // Master Hutang START
    Route::name('master_hutang.')->group(function () {
        Route::get('master-hutang', [HutangController::class, 'index'])->name('index');
        Route::get('master-hutang/index-json', [HutangController::class, 'indexJson'])->name('index.json');
        Route::get('master-hutang/create', [HutangController::class, 'create'])->name('create');
        Route::post('master-hutang/store', [HutangController::class, 'store'])->name('store');
        Route::get('master-hutang/edit/{tahun}/{bulan}/{nopek}/{aard}', [HutangController::class, 'edit'])->name('edit');
        Route::post('master-hutang/update/{tahun}/{bulan}/{nopek}/{aard}', [HutangController::class, 'update'])->name('update');
        Route::delete('master-hutang/delete', [HutangController::class, 'delete'])->name('delete');
    });
    // Master Hutang END

    // Master Beban Perusahaan START
    Route::name('master_beban_perusahaan.')->group(function () {
        Route::get('master-beban-perusahaan', [BebanPerusahaanController::class, 'index'])->name('index');
        Route::get('master-beban-perusahaan/index-json', [BebanPerusahaanController::class, 'indexJson'])->name('index.json');
        Route::get('master-beban-perusahaan/create', [BebanPerusahaanController::class, 'create'])->name('create');
        Route::post('master-beban-perusahaan/store', [BebanPerusahaanController::class, 'store'])->name('store');
        Route::get('master-beban-perusahaan/edit/{tahun}/{bulan}/{nopek}/{aard}', [BebanPerusahaanController::class, 'edit'])->name('edit');
        Route::post('master-beban-perusahaan/update/{tahun}/{bulan}/{nopek}/{aard}', [BebanPerusahaanController::class, 'update'])->name('update');
        Route::delete('master-beban-perusahaan/delete', [BebanPerusahaanController::class, 'delete'])->name('delete');
    });
    // Master Beban Perusahaan END

    // Master THR START
    Route::name('master_thr.')->group(function () {
        Route::get('master-thr', [ThrController::class, 'index'])->name('index');
        Route::get('master-thr/index-json', [ThrController::class, 'indexJson'])->name('index.json');
        Route::get('master-thr/create', [ThrController::class, 'create'])->name('create');
        Route::post('master-thr/store', [ThrController::class, 'store'])->name('store');
        Route::get('master-thr/edit/{tahun}/{bulan}/{nopek}/{aard}', [ThrController::class, 'edit'])->name('edit');
        Route::post('master-thr/update/{tahun}/{bulan}/{nopek}/{aard}', [ThrController::class, 'update'])->name('update');
        Route::delete('master-thr/delete', [ThrController::class, 'delete'])->name('delete');
    });
    // Master THR END
    // Master Payroll END

    //potongan koreksi gaji
    // Route assigned name "potongan-koreksi-gaji.index"...
    Route::name('potongan_koreksi_gaji.')->group(function () {
        Route::get('potongan-koreksi-gaji', [PotonganKoreksiGajiController::class, 'index'])->name('index');
        Route::get('potongan-koreksi-gaji/index-json', [PotonganKoreksiGajiController::class, 'indexJson'])->name('index.json');
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
        Route::get('potongan-manual/index-json', [PotonganManualController::class, 'indexJson'])->name('index.json');
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
        Route::get('potongan-otomatis/index-json', [PotonganOtomatisController::class, 'indexJson'])->name('index.json');
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
        Route::get('potongan-insentif/index-json', [PotonganInsentifController::class, 'indexJson'])->name('index.json');
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
        Route::get('honor-komite/index-json', [HonorKomiteController::class, 'indexJson'])->name('index.json');
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
        Route::get('pinjaman-pekerja/index-json', [PinjamanPekerjaController::class, 'indexJson'])->name('index.json');
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
        Route::get('proses-gaji/rekap-gaji/export', [ProsesGajiController::class, 'rekapGajiExport'])->name('rekap_gaji.export');
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
        Route::get('tunjangan-golongan', [TunjanganGolonganController::class, 'index'])->name('index');
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
        Route::get('master-tabungan/edit/{master_tabungan}', [MasterTabunganController::class, 'edit'])->name('edit');
        Route::post('master-tabungan/update/{master_tabungan}', [MasterTabunganController::class, 'update'])->name('update');
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
        Route::post('jamsostek/daftar-iuran/export', [JamsostekController::class, 'daftarIuranExport'])->name('daftar_iuran.export');
        Route::get('jamsostek/rekap-iuran', [JamsostekController::class, 'rekapIuran'])->name('rekap_iuran');
        Route::post('jamsostek/rekap-iuran/export', [JamsostekController::class, 'rekapIuranExport'])->name('rekap_iuran.export');
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
        Route::post('pensiun/daftar-iuran/export', [PensiunController::class, 'daftarIuranExport'])->name('daftar_iuran.export');
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
});
