<li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('modul_cm.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">Customer Management</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">							
        <ul class="menu-subnav">
            <li class="menu-item {{ Route::is('modul_cm.data_perkara.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_cm.data_perkara.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Data Perkara</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_cm.perusahaan_afiliasi.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_cm.perusahaan_afiliasi.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Perusahaan Afiliasi</span>
                </a>
            </li>
            {{-- <li class="menu-item {{ Route::is('modul_cm.monitoring_kinerja.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_cm.monitoring_kinerja.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Monitoring Kinerja</span>
                </a>
            </li> --}}
            <li class="menu-item {{ Route::is('modul_cm.rkap_realisasi.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_cm.rkap_realisasi.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">RKAP & Realisasi</span>
                </a>
            </li>
            {{-- <li class="menu-item {{ Route::is('modul_cm.pencapaian_kinerja.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_cm.pencapaian_kinerja.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Pencapaian Kinerja</span>
                </a>
            </li> --}}
        </ul>
    </div>
</li>