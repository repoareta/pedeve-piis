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
                Tambah Pendidikan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.pendidikan.store', ['pegawai' => $pegawai->nopeg]) }}" method="post" id="form-create-pendidikan">
                    @csrf

                    <div class="form-group row">
						<label class="col-3 col-form-label">Tingkat Pendidikan</label>
						<div class="col-9">
							<select class="form-control select2" name="kode_pendidikan_pegawai" id="kode_pendidikan_pegawai" style="width: 100% !important;">
								<option value=""> - Pilih Tingkat Pendidikan - </option>
									@foreach ($pendidikan_list as $pendidikan)
                                    <option value="{{ $pendidikan->kode }}">{{ $pendidikan->nama }}</option>
									@endforeach
							</select>
							<div id="kode_pendidikan_pegawai-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-3 col-form-label">Jurusan/Program studi</label>
						<div class="col-9">
							<input class="form-control" type="text" name="tempat_didik_pegawai" id="tempat_didik_pegawai">
							<span class="form-text text-muted" id="photo-nya">Isi nama sekolah/institusi jika bukan perguruan tinggi</span>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-3 col-form-label">Nama Lembaga Pendidikan</label>
						<div class="col-9">
							<select class="form-control select2" name="kode_pt_pendidikan_pegawai" id="kode_pt_pendidikan_pegawai" style="width: 100% !important;">
								<option value=""> - Pilih Lembaga Pendidikan - </option>
                                @foreach ($perguruan_tinggi_list as $pt)
                                    <option value="{{ $pt->kode }}">{{ $pt->nama }}</option>
                                @endforeach
							</select>
							<div id="kode_pt_pendidikan_pegawai-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-3 col-form-label">Mulai</label>
						<div class="col-4">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" placeholder="Pilih Tanggal" name="mulai_pendidikan_pegawai" id="mulai_pendidikan_pegawai">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
							</div>
                        </div>
                        
                        <label class="col-1 col-form-label">Sampai</label>
						<div class="col-4">
							<div class="input-group date">
								<input type="text" class="form-control datepicker" placeholder="Pilih Tanggal" name="sampai_pendidikan_pegawai" id="sampai_pendidikan_pegawai">
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
							</div>
						</div>
					</div>

                    <div class="form-group row">
						<label for="" class="col-3 col-form-label">Catatan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="catatan_pendidikan_pegawai" id="catatan_pendidikan_pegawai">
						</div>
					</div>

                    <div class="form-group row">
                        <div class="col-3"></div>
                        <div class="col-9">
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
{!! JsValidator::formRequest('App\Http\Requests\PendidikanStore', '#form-create-pendidikan') !!}
@endpush