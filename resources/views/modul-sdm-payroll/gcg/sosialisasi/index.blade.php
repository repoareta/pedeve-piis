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
                Sosialisasi
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_sdm_payroll.gcg.sosialisasi.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                KETERANGAN
                            </th>
                            <th>
                                DOKUMEN
                            </th>
                            <th>
                                TANGGAL DIBUAT
                            </th>
                            <th>
                                DIBUAT OLEH
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sosialisasi_list as $sosialisasi)
                            <tr>
                                <td>{{ $sosialisasi->keterangan }}</td>
                                <td>
                                    <a href="{{ asset('storage/sosialisasi/'.$sosialisasi->dokumen) }}" target="_blank">{{ $sosialisasi->dokumen }}</a>
                                </td>
                                <td>{{ Carbon\Carbon::parse($sosialisasi->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ $sosialisasi->pekerja->nama }}</td>
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
