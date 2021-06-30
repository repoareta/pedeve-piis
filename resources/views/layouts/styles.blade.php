<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

<!--end::Fonts-->

<!--begin::Page Vendors Styles(used by this page)-->
<link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->
<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

<!--end::Global Theme Styles-->

<!--begin::Layout Themes(used by all pages)-->
<link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />

@stack('page-styles')
<!--end::Layout Themes-->
<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

<style>
    .fa-disabled {
		opacity: 0.6;
		cursor: not-allowed;
	}

    tr {
        cursor: pointer;
    }

    .error-help-block {
        color: crimson;
    }

    /* .swal2-popup .swal2-icon {
        margin: 2rem 0 0 4.5rem;
    } */
    
    td.no-wrap {
        white-space: nowrap;
    }

    .swal2-popup .swal2-icon {
        margin: auto;
        margin-top: 30px;
    }

    .dataTables_wrapper .dataTable {
        border-radius: 0rem;
    }
</style>