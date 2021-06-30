<li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('modul_umum.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">Umum</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
        <ul class="menu-subnav">
            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>									
                    <span class="menu-text">Perjalanan Dinas</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.perjalanan_dinas.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Permintaan Panjar Dinas</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanggungjawaban Panjar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>	
                    </i>									
                    <span class="menu-text">Uang Muka Kerja</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.uang_muka_kerja.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Permintaan UMK</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanggungjawaban UMK</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>								
            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Anggaran Umum</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.anggaran.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Master Anggaran</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.anggaran.submain.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Sub Anggaran</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.anggaran.submain.detail.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Detail Anggaran</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.anggaran.report') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Report Anggaran</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Report Umum</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.perjalanan_dinas.rekap') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rekap SPD</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.uang_muka_kerja.rekap.range') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rekap UMK</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_umum.permintaan_bayar.rekap.range') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rekap Permintaan Bayar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item {{ Route::is('modul_umum.permintaan_bayar.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_umum.permintaan_bayar.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Permintaan Bayar</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_umum.vendor.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_umum.vendor.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Vendor</span>
                </a>
            </li>
        </ul>
    </div>
</li>