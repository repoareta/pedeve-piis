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
                LHKPN
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_gcg.lhkpn.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
            </div>
            <a href="{{ route('modul_gcg.lhkpn.create') }}" class="pt-2 ml-10">
                <span class="badge badge-primary mb-3" data-original-title="Tambah Data">
                    View as Admin
                </span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>
                                TANGGAL LHKPN
                            </th>
                            <th>
                                DOKUMEN LHKPN
                            </th>
                            <th>
                                TANGGAL DIBUAT
                            </th>
                            <th>
                                STATUS LAPORAN LHKPN
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lhkpn_list as $lhkpn)
                            <tr>
                                <td>
                                    {{ Carbon\Carbon::parse($lhkpn->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    @foreach ($lhkpn->dokumen as $file)
                                        <a href="{{ asset('lhkpn/'.$file->dokumen) }}" target="_blank"><span class="badge badge-primary mb-3">{{ $file->dokumen }}</span></a>
                                    @endforeach
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($lhkpn->created_at)->translatedFormat('d F Y') }}
                                </td>                                
                                <td>
                                    {{ ucfirst($lhkpn->status) }}
                                </td>
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
