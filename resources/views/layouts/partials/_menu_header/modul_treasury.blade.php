<li class="menu-item menu-item-submenu menu-item-rel {{ Request::is('perbendaharaan/*') ? 'menu-item-active' : null }}" data-menu-toggle="click" aria-haspopup="true">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="menu-text">Treasury</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu menu-submenu-classic menu-submenu-left">							
        <ul class="menu-subnav">
            <li class="menu-item menu-item-submenu {{ Route::is(['kas_bank.*', 'cash_flow.*']) ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Report Perbendaharaan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('kas_bank.create1') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('kas_bank.create1') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">D2 Kas Bank</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('kas_bank.create3') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('kas_bank.create3') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kas/Bank Per Cash Judex</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('pembayaran_jumk.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="javascript:;" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">CF Per Bulan</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('pembayaran_jumk.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="javascript:;" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">CF Per Periode</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('cash_flow.lengkap') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('cash_flow.lengkap') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Cash Flow Lengkap</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('kas_bank.create9') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('kas_bank.create9') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Report Proyeksi Cashflow</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is(['rekap_harian_kas.*', 'rekap_periode_kas.*']) ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Rekap Perbendaharaan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('rekap_harian_kas.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('rekap_harian_kas.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rekap Harian Kas</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('rekap_periode_kas.create') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('rekap_periode_kas.create') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rekap Periode</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is(['data_pajak.*', 'proses_pajak.*', 'laporan_pajak.*']) ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Pajak Tahunan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('data_pajak.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('data_pajak.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Pajak</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('proses_pajak.rekap') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('proses_pajak.rekap') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Form 1721-A1</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('laporan_pajak.rekap') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('laporan_pajak.rekap') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">SPT Tahunan 21</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is(['pembayaran_gaji.*', 'pembayaran_jumk.*', 'pembayaran_umk.*', 'pembayaran_pbayar.*']) ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>									
                    <span class="menu-text">Pembayaran</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('pembayaran_gaji.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('pembayaran_gaji.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pembayaran Gaji</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('pembayaran_umk.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('pembayaran_umk.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Uang Muka Kerja</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('pembayaran_jumk.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('pembayaran_jumk.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pertanggungjawaban UMK</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('pembayaran_pbayar.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('pembayaran_pbayar.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Permintaan Bayar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('informasi_saldo.*') ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>									
                    <span class="menu-text">Saldo</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('informasi_saldo.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('informasi_saldo.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Informasi Saldo</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>						
            <li class="menu-item menu-item-submenu {{ Route::is(['bulan_perbendaharaan.*', 'opening_balance.*']) ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Tool</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('bulan_perbendaharaan.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('bulan_perbendaharaan.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Setting Bulan Buku</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('opening_balance.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('opening_balance.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Opening Balance</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item menu-item-submenu {{ Route::is('penempatan_deposito.*') ? 'menu-item-active' : null }}" data-menu-toggle="hover" aria-haspopup="true">
                <a href="javascript:;" class="menu-link menu-toggle">	
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>							
                    <span class="menu-text">Deposito</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu menu-submenu-classic menu-submenu-right">
                    <ul class="menu-subnav">
                        <li class="menu-item {{ Route::is('penempatan_deposito.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('penempatan_deposito.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Penempatan</span>
                            </a>
                        </li>
                        <li class="menu-item {{ Route::is('perhitungan_bagihasil.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                            <a href="{{ route('perhitungan_bagihasil.index') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Rata Tertimbang</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="menu-item {{ Route::is('penerimaan_kas.index') ? 'menu-item-active' : null }}" aria-haspopup="true">
                <a href="{{ route('penerimaan_kas.index') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-line">
                        <span></span>
                    </i>
                    <span class="menu-text">Bukti Kas/Bank</span>
                </a>
            </li>
        </ul>
    </div>
</li>