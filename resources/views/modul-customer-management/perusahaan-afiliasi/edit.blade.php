@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Perusahaan Afiliasi
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="formPerusahaanAfiliasiUpdate" action="{{ route('modul_cm.perusahaan_afiliasi.update', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="nama_perusahaan" class="col-2 col-form-label">Nama Perusahaan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan" value="{{ $perusahaan_afiliasi->nama }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="alamat" class="col-2 col-form-label">Alamat</label>
						<div class="col-10">
							<textarea class="form-control" name="alamat" id="alamat">{{ $perusahaan_afiliasi->alamat }}</textarea>
						</div>
                    </div>
                    
					<div class="form-group row">
						<label for="no_telepon" class="col-2 col-form-label">No Telepon</label>
						<div class="col-10">
							<input class="form-control" type="text" name="no_telepon" id="no_telepon" value="{{ $perusahaan_afiliasi->telepon }}">
						</div>
					</div>

                    <div class="form-group row">
						<label for="npwp" class="col-2 col-form-label">NPWP</label>
						<div class="col-10">
							<input class="form-control" type="text" name="npwp" id="npwp" value="{{ $perusahaan_afiliasi->npwp }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="bidang_usaha" class="col-2 col-form-label">Bidang Usaha</label>
						<div class="col-10">
							<input class="form-control" type="text" name="bidang_usaha" id="bidang_usaha" value="{{ $perusahaan_afiliasi->bidang_usaha }}">
						</div>
                    </div>
                    
                    
					<div class="form-group row">
						<label for="modal_dasar" class="col-2 col-form-label">Modal Dasar</label>
						<div class="col-10">
							<input class="form-control" type="text" name="modal_dasar" id="modal_dasar" min="0" value="{{ nominal_abs($perusahaan_afiliasi->modal_dasar) }}">
						</div>
                    </div>

					<div class="form-group row">
						<label for="modal_disetor" class="col-2 col-form-label">Modal Disetor</label>
						<div class="col-10">
							<input class="form-control" type="text" name="modal_disetor" id="modal_disetor" min="0" value="{{ nominal_abs($perusahaan_afiliasi->modal_disetor) }}">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="jumlah_lembar_saham" class="col-2 col-form-label">Jumlah Lembar Saham</label>
						<div class="col-10">
							<input class="form-control" type="text" name="jumlah_lembar_saham" id="jumlah_lembar_saham" min="0" value="{{ $perusahaan_afiliasi->jumlah_lembar_saham }}">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="nilai_nominal_per_saham" class="col-2 col-form-label">Nilai Nominal per Saham</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nilai_nominal_per_saham" id="nilai_nominal_per_saham" min="0" value="{{ nominal_abs($perusahaan_afiliasi->nilai_nominal_per_saham) }}">
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

    @include('modul-customer-management.perusahaan-afiliasi.pemegang-saham.index')
    @include('modul-customer-management.perusahaan-afiliasi.direksi.index')
    @include('modul-customer-management.perusahaan-afiliasi.komisaris.index')
    @include('modul-customer-management.perusahaan-afiliasi.perizinan.index')
    @include('modul-customer-management.perusahaan-afiliasi.akta.index')

</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerusahaanAfiliasiUpdate', '#formPerusahaanAfiliasiUpdate') !!}

@yield('pemegang_saham_script')
@yield('direksi_script')
@yield('komisaris_script')
@yield('perizinan_script')
@yield('akta_script')
@endpush
