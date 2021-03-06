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
                Tambah Seminar
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.seminar.store', ['pegawai' => $pegawai->nopeg]) }}" method="post" id="form-create-seminar">
                    @csrf
                    <div class="form-group row">
						<label class="col-2 col-form-label">Nama</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama_seminar" id="nama_seminar">
						</div>
                    </div>

                    <div class="form-group row">
						<label class="col-2 col-form-label">Mulai</label>
						<div class="col-4">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="mulai_seminar" id="mulai_seminar">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
							</div>
                        </div>
                        
                        <label class="col-2 col-form-label">Sampai</label>
						<div class="col-4">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="sampai_seminar" id="sampai_seminar">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
							</div>
						</div>
                    </div>

                    <div class="form-group row">
						<label class="col-2 col-form-label">Penyelenggara</label>
						<div class="col-10">
							<input class="form-control" type="text" name="penyelenggara_seminar" id="penyelenggara_seminar">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-2 col-form-label">Kota</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kota_seminar" id="kota_seminar">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-2 col-form-label">Negara</label>
						<div class="col-10">
							<input class="form-control" type="text" name="negara_seminar" id="negara_seminar">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="keterangan_seminar" id="keterangan_seminar">
						</div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_sdm_payroll.master_pegawai.edit', ['pegawai' => $pegawai->nopeg]) }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\SeminarStoreRequest', '#form-create-seminar') !!}
@endpush