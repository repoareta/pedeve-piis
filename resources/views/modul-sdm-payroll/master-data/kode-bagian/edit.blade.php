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
                Edit Kode Bagian
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="formKodeBagian" action="{{ route('modul_sdm_payroll.kode_bagian.update', ['kode_bagian' => $kode_bagian]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Kode Bagian</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kode" id="kode" value="{{ $kode_bagian->kode }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nama Bagian</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $kode_bagian->nama }}">
						</div>
					</div>

                    <div class="form-group row">
                        <label for="nopeg-input" class="col-2 col-form-label">Pimpinan</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="nopeg" id="nopeg">
                                <option value="">- Pilih Data -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg }}" {{ $pegawai->nopeg == $kode_bagian->nopeg ? 'selected' : null }}>{{ $pegawai->nopeg . " - " . $pegawai->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<a href="{{ route('modul_sdm_payroll.kode_bagian.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\KodeBagianUpdate', '#formKodeBagian') !!}
@endpush
