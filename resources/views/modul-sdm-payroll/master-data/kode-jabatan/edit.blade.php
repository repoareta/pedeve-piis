@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Kode Jabatan
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="formKodeJabatan" action="{{ route('modul_sdm_payroll.kode_jabatan.update', ['kdjab' => $kode_jabatan->kdjab, 'kode_bagian' => $kode_bagian]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Kode Bagian</label>
						<div class="col-10">
							<select class="form-control select2" name="kode_bagian" id="kode_bagian">
								<option value="">- Pilih Kode Bagian -</option>
								@foreach ($kode_bagian_list as $kdbag)
									<option value="{{ $kdbag->kode }}" {{ $kode_bagian->kode == $kdbag->kode ? 'selected' : null }}>{{ $kdbag->kode.' - '.$kdbag->nama }}</option>
								@endforeach
							</select>
							<div id="kode_bagian-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Kode Jabatan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kdjab" id="kdjab" value="{{ $kode_jabatan->kdjab }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nama</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $kode_jabatan->keterangan }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Golongan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="golongan" id="golongan" value="{{ $kode_jabatan->goljob }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Tunjangan</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="tunjangan" id="tunjangan" value="{{ $kode_jabatan->tunjangan }}">
						</div>
					</div>

					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<a href="{{ route('modul_sdm_payroll.kode_jabatan.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\KodeJabatanUpdate', '#formKodeJabatan') !!}

<script>
	$(document).ready(function () {
		$('#formKodeJabatan').on('submit', function () {
			if ($('#kode_bagian-error').length) $('#kode_bagian-error').insertAfter('#kode_bagian-error-placement');
		});
	});
</script>
@endpush
