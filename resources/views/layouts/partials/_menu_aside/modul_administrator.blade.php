<li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.*') ? 'menu-open menu-item-open' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-icon">
            <i class="fa fa-users"></i>
        </span>
        <span class="menu-text">Administrator</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item menu-item-parent" aria-haspopup="true">
                <span class="menu-link">
                    <span class="menu-text">Administrator</span>
                </span>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.set_user.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('modul_administrator.set_user.index') }}" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set User</span>													
                </a>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.set_menu.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('modul_administrator.set_menu.index') }}" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set Menu</span>													
                </a>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.set_function.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('modul_administrator.set_function.index') }}" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Set Function</span>													
                </a>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.tabel_menu.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('modul_administrator.tabel_menu.index') }}" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Tabel Menu</span>													
                </a>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.log.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="{{ route('modul_administrator.log.index') }}" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Log</span>													
                </a>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('modul_administrator.password_administrator.*') ? 'menu-item-active' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Password Administration</span>													
                </a>
            </li>
        </ul>
    </div>
</li>