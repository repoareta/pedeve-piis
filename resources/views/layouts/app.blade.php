<!DOCTYPE html>
<html lang="en">

	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		
		<title>
			{{ config('app.name', 'Pertamina PDV') }} | 
			{{ ucwords(str_replace('_', ' ', Request::segment(1) == 'sdm' ? 'SDM & Payroll' : str_replace('-', ' ', Request::segment(1)))) }}
			@if(Request::segment(2)) - {{ ucwords(str_replace('-', ' ', Request::segment(2))) }} @endif
		</title>
		
		<meta name="description" content="Pedeve Pertamina" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="{{ config('app.url', url()) }}" />

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		@include('layouts.styles')
	</head>

	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize">
		
	<!--begin::Main-->

	<!--[html-partial:include:{"file":"partials/_header-mobile.html"}]/-->
	@include('layouts.partials._header-mobile')
	<div class="d-flex flex-column flex-root">

		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">

			<!--[html-partial:include:{"file":"partials/_aside.html"}]/-->
			@include('layouts.partials._aside')

			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

				<!--[html-partial:include:{"file":"partials/_header.html"}]/-->
				@include('layouts.partials._header')
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

					<!--[html-partial:include:{"file":"partials/_subheader/subheader-v1.html"}]/-->
					@include('layouts.partials._subheader.subheader-v1')
					
					<!--Content area start-->
					{{-- edit here start --}}
					<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container-fluid">
							@yield('content')
						</div>
					</div>
					{{-- edit here end --}}
					<!--Content area here END-->
				</div>

				<!--end::Content-->

				<!--[html-partial:include:{"file":"partials/_footer.html"}]/-->
				@include('layouts.partials._footer')
			</div>

			<!--end::Wrapper-->
		</div>

		<!--end::Page-->
	</div>

	<!--end::Main-->

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->
		@include('layouts.partials._extras.offcanvas.quick-user')
		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-panel.html"}]/-->
		@include('layouts.partials._extras.offcanvas.quick-panel')
		<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
		@include('layouts.partials._extras.scrolltop')
		<!--[html-partial:include:{"file":"partials/_extras/toolbar.html"}]/-->
		{{-- @include('layouts.partials._extras.toolbar') --}}
		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/demo-panel.html"}]/-->
		@include('layouts.partials._extras.offcanvas.demo-panel')

		@include('layouts.scripts')

		@include('sweetalert::alert')
	</body>

	<!--end::Body-->
</html>