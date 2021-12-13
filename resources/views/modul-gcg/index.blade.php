@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                {{ optional(Auth::user()->pekerja)->nama.' - '.optional($jabatan)->keterangan }}
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>BULAN</th>
                            <th>PENERIMAAN</th>
                            <th>PERMINTAAN</th>
                            <th>PEMBERIAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gratifikasi_list as $gratifikasi)
                            <tr>
                                <td>{{ bulan($gratifikasi->month).' '.$gratifikasi->year}}</td>
                                <td>{{ $gratifikasi->penerimaan }}</td>
                                <td>{{ $gratifikasi->permintaan }}</td>
                                <td>{{ $gratifikasi->pemberian }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$('#kt_table').DataTable();
	});
</script>
@endpush
