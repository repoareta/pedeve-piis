
<!--begin::Aside-->
<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">

	<!--begin::Brand-->
	<div class="brand flex-column-auto" id="kt_brand">

		<!--begin::Logo-->
		<a href="index.html" class="brand-logo">
			<img alt="Logo" height="40px" src="{{ asset('images/pedeve.png') }}" />
		</a>

		<!--end::Logo-->

		<!--begin::Toggle-->
		<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
			<span class="svg-icon svg-icon svg-icon-xl">

				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
						<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
					</g>
				</svg>

				<!--end::Svg Icon-->
			</span>
		</button>

		<!--end::Toolbar-->
	</div>

	<!--end::Brand-->

	<!--begin::Aside Menu-->
	<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

		<!--begin::Menu Container-->
		<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">

			<!--begin::Menu Nav-->
			<ul class="menu-nav">
				<li class="menu-item" aria-haspopup="true">
					<img class="img-responsive avatar-view pointer-link" style="margin: auto;width: 50%;height: 50%;-moz-border-radius: 100px 100px 100px 100px; -webkit-border-radius: 100px 100px 100px 100px; border-radius: 100px;" id="btn-profile" data-target="#kt_modal_4" src="{{ asset('images/pertamina.png') }}" alt="ADMIN" title="Ubah foto profil">
					<div class="menu-toggle menu-link d-flex flex-column align-items-center">
						<h6 style="padding-top:20px;" class="menu-text">
							Welcome
						</h6>
						<h4 style="color:#ffffff;" class="menu-text">ADMIN</h4>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="menu-icon">
							<i class="fa fa-boxes"></i>
						</span>
						<span class="menu-text">Umum</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">Umum</span>
								</span>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Perjalanan Dinas</span>
									<span class="menu-label">
										<span class="label label-rounded label-primary">6</span>
									</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Permintaan Panjar Dinas</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Pertanggungjawaban Panjar</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Uang Muka Kerja</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Permintaan UMK</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Pertanggungjawaban UMK</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Permintaan Bayar</span>													
								</a>
							</li>											
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Anggaran Umum</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Master Anggaran</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Sub Anggaran</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Detail Anggaran</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Report Anggaran</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Report Umum</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap SPD</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap UMK</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Permintaan Bayar</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Vendor</span>													
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="menu-icon">
							<i class="fa fa-book-reader"></i>
						</span>
						<span class="menu-text">SDM & Payroll</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">SDM & Payroll</span>
								</span>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Master Data</span>
									<span class="menu-label">
										<span class="label label-rounded label-primary">6</span>
									</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Provinsi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Perguruan Tinggi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Kode Bagian</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Kode Jabatan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Agama</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Master Pegawai</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Master Payroll</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Master Upah</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Master Insentif</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Master Hutang</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Beban Perusahaan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Master THR</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Potongan</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Manual Gaji</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Potongan Otomatis</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Potongan Insentif</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Lembur</span>
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Pinjaman Kerja</span>
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Koreksi Gaji</span>
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Honor Komite/Rapat</span>													
								</a>
							</li>																						
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Proses Payroll</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Upah</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">THR</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Insentif</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Tabel Payroll</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Tunjangan Pergolongan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Jenis Upah</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekening Pekerja</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">AARD</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">BANK</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">PTKP</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Jamsostek</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Dana Pensiun</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Tabungan</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Report SDM & Payroll</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Daftar Upah Kerja</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Daftar Iuran Jamsostek</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Daftar Iuran Pensiun</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Lembur</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Gaji</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap THR</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Insentif</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Iuran Pensiun</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Slip Gaji</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Slip THR</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Slip Insentif</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Absensi Karyawan</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Implementasi GCG</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Home</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">CoC</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Col</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Gratifikasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Sosialisasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">LHKPN</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Insentif</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Report Boundary</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="menu-icon">
							<i class="fa fa-chalkboard"></i>
						</span>
						<span class="menu-text">Treasury</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">Treasury</span>
								</span>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Bukti Kas/Bank</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Pembayaran</span>
									<span class="menu-label">
										<span class="label label-rounded label-primary">6</span>
									</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Pembayaran Gaji</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Uang Muka Kerja</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Pertanggungjawaban UMK</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Permintaan Bayar</span>
											</a>
										</li>
									</ul>
								</div>
							</li>											
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Saldo</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Informasi Saldo</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Tool</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Setting Bulan Buku</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Opening Balance</span>
											</a>
										</li>
									</ul>
								</div>
							</li>																					
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Deposito</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Penempatan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rata Tertimbang</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Pajak Tahunan</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Data Pajak</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Form 1721-A1</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">SPT Tahunan 21</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Rekap Perbendaharaan</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Harian Kas</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Rekap Periode</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Report Perbendaharaan</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">D2 Kas Bank</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Kas/Bank Per Cash Judex</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Cash Flow Mutasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Cash Flow Per Mata Uang</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Cash Flow Lengkap</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Report Proyeksi Cashflow</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Report Per Cash Judex</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="menu-icon">
							<i class="fa fa-crosshairs"></i>
						</span>
						<span class="menu-text">Kontroler</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">Kontroler</span>
								</span>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Jurnal Umum</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Verifikasi Kas Bank</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Posting Kas Bank</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Treassury</span>
									<span class="menu-label">
										<span class="label label-rounded label-primary">6</span>
									</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Cetak Kas Bank</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Tabel Deposito</span>
											</a>
										</li>
									</ul>
								</div>
							</li>											
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Report</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">D2 Per Bulan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">D2 Per Periode</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">D5</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Neraca Konsolidasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Neraca Detail</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Laba Rugi Konsolidasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Laba Rugi Detail</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Catatan Atas Lap.Keuangan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Biaya Pegawai dan Kantor</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Tabel</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Cash Judex</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Jenis Biaya</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Kas Bank</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Lokasi</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Sandi Perkiraan</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Setting Bulan Buku</span>
											</a>
										</li>
										<li class="menu-item" aria-haspopup="true">
											<a href="#" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Main Account</span>
											</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="menu-icon">
							<i class="fa fa-handshake"></i>
						</span>
						<span class="menu-text">Customer Management</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">Customer Management</span>
								</span>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Data Perkara</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Perusahaan Afiliasi</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Monitoring Pekerja</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Rencana Kerja</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Pencapaian Kinerja</span>													
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
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
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Set User</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Set Menu</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Set Function</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Tabel Menu</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
								<a href="#" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Log</span>													
								</a>
							</li>
							<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
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
			</ul>

			<!--end::Menu Nav-->
		</div>

		<!--end::Menu Container-->
	</div>

	<!--end::Aside Menu-->
</div>

<!--end::Aside-->