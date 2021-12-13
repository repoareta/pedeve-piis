<li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('modul_gcg.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">GCG</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">							
        <ul class="menu-subnav">
            <li class="menu-item {{ Route::is('modul_gcg.index') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Home</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.coc.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.coc.lampiran_satu') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">CoC</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.coi.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.coi.lampiran_satu') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">CoI</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.gratifikasi.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.gratifikasi.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Gratifikasi</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.sosialisasi.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.sosialisasi.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Sosialisasi</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.lhkpn.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.lhkpn.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">LHKPN</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_gcg.report_boundary.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_gcg.report_boundary.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Report Boundary</span>
                </a>
            </li>
        </ul>
    </div>
</li>