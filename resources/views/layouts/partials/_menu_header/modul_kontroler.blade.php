<li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('modul_kontroler.*') ? 'menu-item-active' : '' }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">Kontroler</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">							
        <ul class="menu-subnav">
            <li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Tabel</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.cash_judex.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Cash Judex</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.jenis_biaya.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Jenis Biaya</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.kas_bank_kontroler.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kas Bank</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.lokasi_kontroler.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Lokasi</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.sandi_perkiraan.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Sandi Perkiraan</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.bulan_kontroler.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Setting Bulan Buku</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel.main_account.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Main Account</span>
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
                    <span class="menu-text">Report</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.d2_perbulan.create_d2_perbulan') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">D2 Per Bulan</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.d2_periode.create_d2_periode') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">D2 Per Periode</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.d5_report.create_d5_report') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">D5</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.neraca_konsolidasi.create_neraca_konsolidasi') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Neraca Konsolidasi</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.neraca_detail.create_neraca_detail') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Neraca Detail</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.laba_rugi_konsolidasi.create_laba_rugi_konsolidasi') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Laba Rugi Konsolidasi</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.laba_rugi_detail.create_laba_rugi_detail') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Laba Rugi Detail</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.laporan_keuangan.create_laporan_keuangan') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Catatan Atas Lap. Keuangan</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.biaya_pegawai.create_biaya_pegawai') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Biaya Pegawai dan Kantor</span>
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
                    <span class="menu-text">Treassury</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.cetak_kas_bank.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Cetak Kas Bank</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ route('modul_kontroler.tabel_deposito.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tabel Deposito</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item {{ Route::is('modul_kontroler.postingan_kas_bank.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_kontroler.postingan_kas_bank.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Posting Kas Bank</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_kontroler.postingan_kas_bank.verkass') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_kontroler.postingan_kas_bank.verkass') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Verifikasi Kas Bank</span>
                </a>
            </li>
            <li class="menu-item {{ Route::is('modul_kontroler.jurnal_umum.*') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                <a href="{{ route('modul_kontroler.jurnal_umum.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Jurnal Umum</span>
                </a>
            </li>
        </ul>
    </div>
</li>