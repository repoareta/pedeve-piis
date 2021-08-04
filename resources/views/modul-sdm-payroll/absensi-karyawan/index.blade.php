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
                Absensi Karyawan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
				<a href="#">
					<span class="pointer-link" data-toggle="modal" data-target="#mapping" data-placement="top" title="Mapping Data Absen.">
                        <i class="fab fa-hubspot icon-2x text-success"></i>
                    </span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" action="{{ route('modul_sdm_payroll.absensi_karyawan.download') }}" id="search-form" method="GET">
                <div class="form-group row">
                    <label for="" class="col-1 col-form-label">IP Address</label>
                    <div class="col-2">
                        <input class="form-control" type="text" name="ip_address" value="{{ $ip }}">
                    </div>
    
                    <label for="" class="col-form-label">Comm Key</label>
                    <div class="col-2">
                        <input class="form-control" type="text" name="comm_key" value="{{ $key }}">
                    </div>
    
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Download</button>
                    </div>
                </div>
            </form>
		</div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Pegawai</th>
                            <th>Tanggal & Jam</th>
                            <th>Verifikasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="mapping" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mapping data absen dengan data pegawai.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
			</div>
			<form action="{{ route('modul_sdm_payroll.absensi_karyawan.mapping') }}" method="POST">
				@csrf
				<div class="modal-body">
					<div class="form-group row">
						<label for="kode_main" class="col-2 col-form-label">Pegawai</label>
						<div class="col-10">
							<select class="form-control select2" style="width: 100% !important;" name="nopeg" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach ($pegawai_list as $pegawai)
									<option value="{{ $pegawai->nopeg }}">{{ $pegawai->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="kode_main" class="col-2 col-form-label">No Absen</label>
						<div class="col-10">
							<select class="form-control select2" style="width: 100% !important;" name="noabsen" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach ($data_absensi->unique('userid')  as $item)
									@if ($item->noabsen == null)
										<option value="{{ $item->userid }}">{{ $item->userid }}</option>
									@endif
								@endforeach
							</select>
							<div id="kode_main-nya"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
				</div>
			</form>
        </div>
    </div>
</div>
<!-- Modal-->

@endsection

@push('page-scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax      : "{{ route('modul_sdm_payroll.absensi_karyawan.index.json') }}",
            columns: [
                {data: 'pegawai', name: 'userid', class:'no-wrap'},
                {data: 'tanggal', name: 'tanggal', class:'no-wrap'},
                {data: 'verifikasi', name: 'verifikasi', class:'no-wrap'},
                {data: 'status', name: 'status', class:'no-wrap'}
            ]
        });
    });
</script>
@endpush
