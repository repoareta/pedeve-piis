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
                Edit Penghargaan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.penghargaan.update', ['pegawai' => $pegawai->nopeg, 'tanggal' => $tanggal, 'nama' => $nama]) }}" method="post" id="form-edit-penghargaan">
                    @csrf
                    <div class="form-group row">
						<label class="col-2 col-form-label">Nama Penghargaan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama_penghargaan" id="nama_penghargaan" value="{{ $penghargaan->nama }}">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-2 col-form-label">Pemberi</label>
						<div class="col-10">
							<input class="form-control" type="text" name="pemberi_penghargaan" id="pemberi_penghargaan" value="{{ $penghargaan->pemberi }}">
						</div>
                    </div>

                    <div class="form-group row">
						<label class="col-2 col-form-label">Tanggal</label>
						<div class="col-10">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="tanggal_penghargaan" id="tanggal_penghargaan" value="{{ $penghargaan->tanggal->format('Y-m-d') }}">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
							</div>
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
{!! JsValidator::formRequest('App\Http\Requests\PenghargaanUpdateRequest', '#form-edit-penghargaan') !!}
@endpush
