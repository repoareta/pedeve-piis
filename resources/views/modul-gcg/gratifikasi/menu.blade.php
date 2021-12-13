<div class="card-toolbar">
    <div class="float-left">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a class="btn btn-outline-secondary {{ Route::is('modul_gcg.gratifikasi.index') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.index') }}" role="button">Outstanding</a>
            <a class="btn btn-outline-secondary {{ Route::is('modul_gcg.gratifikasi.index.penerimaan') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.penerimaan') }}" role="button">Penerimaan</a>
            <a class="btn btn-outline-secondary {{ Route::is('modul_gcg.gratifikasi.index.pemberian') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.pemberian') }}" role="button">Pemberian</a>
            <a class="btn btn-outline-secondary {{ Route::is('modul_gcg.gratifikasi.index.permintaan') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.permintaan') }}" role="button">Permintaan</a>
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle {{ Route::is('modul_gcg.gratifikasi.index.report.*') ? 'active' : '' }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Report
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                    <a class="dropdown-item {{ Route::is('modul_gcg.gratifikasi.index.report.personal') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.report.personal') }}">Personal</a>
                    <a class="dropdown-item {{ Route::is('modul_gcg.gratifikasi.index.report.management') ? 'active' : '' }}" href="{{ route('modul_gcg.gratifikasi.report.management') }}">Management</a>
                </div>
            </div>
        </div>
    </div>
</div>