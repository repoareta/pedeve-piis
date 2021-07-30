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
                Gratifikasi
            </h3>
        </div>

        @include('modul-sdm-payroll.gcg.gratifikasi.menu')

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Nopek</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Pemberi</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>NIHIL</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gratifikasi_list as $gratifikasi)
                        <tr>
                            <td>{{ $gratifikasi->nopeg }}</td>
                            <td>{{ $gratifikasi->pekerja->nama }}</td>
                            <td>{{ Carbon\Carbon::parse($gratifikasi->tgl_gratifikasi)->translatedFormat('d F Y') }}</td>
                            <td>{{ $gratifikasi->bentuk }}</td>
                            <td>{{ $gratifikasi->jumlah }}</td>
                            <td>{{ $gratifikasi->pemberi }}</td>
                            <td>{{ $gratifikasi->keterangan }}</td>
                            <td>{{ $gratifikasi->status }}</td>
                            <td>NIHIL</td>
                            <td>{{ ucwords($gratifikasi->jenis_gratifikasi) }}</td>
                            <td>
                                <a href="{{ route('modul_sdm_payroll.gcg.gratifikasi.edit', ['gratifikasi' => $gratifikasi->id]) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit" aria-hidden="true"></i> Ubah</a>
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
