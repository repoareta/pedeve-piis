
<?php

use App\Http\Controllers\Gcg\CocController;
use App\Http\Controllers\Gcg\CoiController;
use App\Http\Controllers\Gcg\GcgController;
use App\Http\Controllers\Gcg\GratifikasiController;
use App\Http\Controllers\Gcg\LhkpnController;
use App\Http\Controllers\Gcg\ReportBoundaryController;
use App\Http\Controllers\Gcg\SosialisasiController;

// Modul GCG
Route::prefix('gcg')->name('modul_gcg.')->group(function () {
    Route::get('/', [GcgController::class, 'index'])->name('index');

    Route::get('coc/lampiran-satu', [CocController::class, 'index'])->name('coc.lampiran_satu');
    Route::post('coc/lampiran-satu/print', [CocController::class, 'lampiranSatuPrint'])->name('coc.lampiran_satu.print');
    Route::get('coc/lampiran-dua', [CocController::class, 'lampiranDua'])->name('coc.lampiran_dua');
    Route::post('coc/lampiran-dua/print', [CocController::class, 'lampiranDuaPrint'])->name('coc.lampiran_dua.print');

    Route::get('coi/lampiran-satu', [CoiController::class, 'index'])->name('coi.lampiran_satu');
    Route::post('coi/lampiran-satu/print', [CoiController::class, 'lampiranSatuPrint'])->name('coi.lampiran_satu.print');
    Route::get('coi/lampiran-dua', [CoiController::class, 'lampiranDua'])->name('coi.lampiran_dua');
    Route::post('coi/lampiran-dua/print', [CoiController::class, 'lampiranDuaPrint'])->name('coi.lampiran_dua.print');

    Route::get('gratifikasi', [GratifikasiController::class, 'index'])->name('gratifikasi.index');
    Route::get('gratifikasi/penerimaan', [GratifikasiController::class, 'penerimaan'])->name('gratifikasi.penerimaan');
    Route::post('gratifikasi/penerimaan/store', [GratifikasiController::class, 'penerimaanStore'])->name('gratifikasi.penerimaan.store');

    Route::get('gratifikasi/pemberian', [GratifikasiController::class, 'pemberian'])->name('gratifikasi.pemberian');
    Route::post('gratifikasi/pemberian/store', [GratifikasiController::class, 'pemberianStore'])->name('gratifikasi.pemberian.store');

    Route::get('gratifikasi/permintaan', [GratifikasiController::class, 'permintaan'])->name('gratifikasi.permintaan');
    Route::post('gratifikasi/permintaan/store', [GratifikasiController::class, 'permintaanStore'])->name('gratifikasi.permintaan.store');

    Route::get('gratifikasi/report/personal', [GratifikasiController::class, 'reportPersonal'])->name('gratifikasi.report.personal');
    Route::get('gratifikasi/report/personal/index-json', [GratifikasiController::class, 'reportPersonalIndexJson'])->name('gratifikasi.report.personal.json');
    Route::post('gratifikasi/report/personal/export', [GratifikasiController::class, 'reportPersonalExport'])->name('gratifikasi.report.personal.export');

    Route::get('gratifikasi/report/management', [GratifikasiController::class, 'reportManagement'])->name('gratifikasi.report.management');
    Route::get('gratifikasi/report/management/index-json', [GratifikasiController::class, 'reportManagementIndexJson'])->name('gratifikasi.report.management.json');
    Route::get('gratifikasi/report/management/export', [GratifikasiController::class, 'reportManagementExport'])->name('gratifikasi.report.management.export');

    Route::get('gratifikasi/edit/{gratifikasi}', [GratifikasiController::class, 'edit'])->name('gratifikasi.edit');
    Route::post('gratifikasi/update/{gratifikasi}', [GratifikasiController::class, 'update'])->name('gratifikasi.update');

    Route::get('sosialisasi', [SosialisasiController::class, 'index'])->name('sosialisasi.index');
    Route::get('sosialisasi/create', [SosialisasiController::class, 'create'])->name('sosialisasi.create');
    Route::post('sosialisasi/store', [SosialisasiController::class, 'store'])->name('sosialisasi.store');
    Route::post('sosialisasi/reader/store', [SosialisasiController::class, 'storeReader'])->name('sosialisasi.reader.store');
    Route::post('sosialisasi/reader/check', [SosialisasiController::class, 'checkReader'])->name('sosialisasi.reader.check');

    Route::get('lhkpn', [LhkpnController::class, 'index'])->name('lhkpn.index');
    Route::get('lhkpn/create', [LhkpnController::class, 'create'])->name('lhkpn.create');
    Route::post('lhkpn/store', [LhkpnController::class, 'store'])->name('lhkpn.store');
    Route::get('lhkpn/{lhkpn}/edit', [LhkpnController::class, 'edit'])->name('lhkpn.edit');
    Route::put('lhkpn/{lhkpn}', [LhkpnController::class, 'update'])->name('lhkpn.update');
    Route::delete('lhkpn/{lhkpn}', [LhkpnController::class, 'destroy'])->name('lhkpn.destroy');

    Route::get('report-boundary', [ReportBoundaryController::class, 'index'])->name('report_boundary.index');
    Route::get('report-boundary/export', [ReportBoundaryController::class, 'export'])->name('report_boundary.export');
});
