<li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('modul_administrator.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">Administrator</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">							
        <ul class="menu-subnav">
            <li class="menu-item {{ Route::is('modul_administrator.set_user.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_administrator.set_user.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set User</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_administrator.set_menu.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="#" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set Menu</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_administrator.set_function.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="#" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set Function</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_administrator.tabel_menu.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="#" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Tabel Menu</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_administrator.log.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="#" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Log</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_administrator.password_administrator.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="#" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Password Administration</span>
                </a>
            </li>
        </ul>
    </div>
</li>