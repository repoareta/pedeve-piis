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
                Tambah Golongan Gaji
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.golongan_gaji.update', ['pegawai' => $pegawai->nopeg, 'golongan_gaji' => $golongan_gaji, 'tanggal' => $tanggal]) }}" method="post" id="form-edit-golongan-gaji">
                    @csrf
                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Golongan Gaji</label>
						<div class="col-10">
							<select class="form-control select2" name="golongan_gaji" id="golongan_gaji" style="width: 100% !important;">
								<option value="">- Pilih Golongan Gaji -</option>
								@foreach ($golongan_gaji_list as $data)
                                <option value="{{ $data->golongan }}" {{ $data->golongan == $golongan_gaji ? 'selected' : null }}>{{ $data->golongan . ' - ' . float_two($data->nilai) }}</option>
								@endforeach
							</select>
							<div id="gelar_1-nya"></div>
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Tanggal</label>
						<div class="col-10">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="tanggal_golongan_gaji" id="tanggal_golongan_gaji" value="{{ $golonganGaji->tanggal->format('Y-m-d') }}">
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
{!! JsValidator::formRequest('App\Http\Requests\GolonganGajiUdpate', '#form-edit-golongan-gaji') !!}
@endpush
