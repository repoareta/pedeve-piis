
<!--begin::Header-->
<div id="kt_header" class="header header-fixed">

	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">

		<!--begin::Header Menu Wrapper-->
		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">			

			<!--begin::Header Menu-->
			<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default header-menu-root-arrow">
				<!--begin::Header Nav-->
				<ul class="menu-nav">
					<div class="header-logo menu-item mr-5">
						<a href="{{ route('dashboard.index') }}">
							<img alt="Logo" height="40px" src="{{ asset('images/pertamina.png') }}">
						</a>
					</div>

					<!--begin::Umum Menu-->
					@include('layouts.partials._menu_header.modul_umum')
					<!--end::Umum Menu-->

					<!--begin::SDM & Payroll Menu-->
					@include('layouts.partials._menu_header.modul_sdm_payroll')
					<!--end::SDM & Payroll Menu-->

					<!--begin::Treasury Menu-->
					@include('layouts.partials._menu_header.modul_treasury')
					<!--end::Treasury Menu-->

					<!--begin::Kontroler Menu-->
					@include('layouts.partials._menu_header.modul_kontroler')
					<!--end::Kontroler Menu-->

					<!--begin::Customer Management Menu-->
					@include('layouts.partials._menu_header.modul_customer_management')
					<!--end::Customer Management Menu-->
					
					<!--begin::Administrator Menu-->
					@include('layouts.partials._menu_header.modul_administrator')
					<!--end::Administrator Menu-->
				</ul>

				<!--end::Header Nav-->
			</div>

			<!--end::Header Menu-->
		</div>

		<!--end::Header Menu Wrapper-->

		<!--begin::Topbar-->
		<div class="topbar">

			<!--begin::Notifications-->
			{{-- <div class="dropdown">

				<!--begin::Toggle-->
				<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
					<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
						<span class="svg-icon svg-icon-xl svg-icon-primary">

							<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24" />
									<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
									<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
								</g>
							</svg>

							<!--end::Svg Icon-->
						</span>
						<span class="pulse-ring"></span>
					</div>
				</div>

				<!--end::Toggle-->

				<!--begin::Dropdown-->
				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
					<form>

						<!--[html-partial:include:{"file":"partials/_extras/dropdown/notifications.html"}]/-->
						@include('layouts.partials._extras.dropdown.notifications')
					</form>
				</div>

				<!--end::Dropdown-->
			</div> --}}

			<!--end::Notifications-->

			<!--begin::Quick panel-->
			<div class="topbar-item">
				<div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
					<span class="svg-icon svg-icon-xl svg-icon-primary">

						<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24" />
								<rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
								<path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
							</g>
						</svg>

						<!--end::Svg Icon-->
					</span>
				</div>
			</div>

			<!--end::Quick panel-->

			<!--begin::User-->
			<div class="topbar-item">
				<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
					<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
					<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->usernm }}</span>
					<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
						<span class="symbol-label font-size-h5 font-weight-bold">{{ substr(Auth::user()->usernm, 0, 1) }}</span>
					</span>
				</div>
			</div>

			<!--end::User-->
		</div>

		<!--end::Topbar-->
	</div>

	<!--end::Container-->
</div>

<!--end::Header-->