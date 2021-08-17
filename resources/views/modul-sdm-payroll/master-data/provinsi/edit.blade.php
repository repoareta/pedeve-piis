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
                Ubah Provinsi
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="formProvinsi" action="{{ route('modul_sdm_payroll.provinsi.update', ['provinsi' => $provinsi->kode]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Kode Provinsi</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kode" id="kode" value="{{ $provinsi->kode }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nama Provinsi</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $provinsi->nama }}">
						</div>
					</div>

					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\ProvinsiUpdate', '#formProvinsi') !!}
@endpush
