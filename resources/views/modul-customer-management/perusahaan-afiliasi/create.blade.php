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
                Tambah Perusahaan Afiliasi
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
                <form class="form" id="formPerusahaanAfiliasi" action="{{ route('modul_cm.perusahaan_afiliasi.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="nama_perusahaan" class="col-2 col-form-label">Nama Perusahaan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama_perusahaan" id="nama_perusahaan">
						</div>
					</div>

					<div class="form-group row">
						<label for="alamat" class="col-2 col-form-label">Alamat</label>
						<div class="col-10">
							<textarea class="form-control" name="alamat" id="alamat"></textarea>
						</div>
                    </div>

					<div class="form-group row">
						<label for="no_telepon" class="col-2 col-form-label">No Telepon</label>
						<div class="col-10">
							<input class="form-control" type="text" name="no_telepon" id="no_telepon">
						</div>
					</div>

                    <div class="form-group row">
						<label for="npwp" class="col-2 col-form-label">NPWP</label>
						<div class="col-10">
							<input class="form-control" type="text" name="npwp" id="npwp">
						</div>
					</div>

					<div class="form-group row">
						<label for="bidang_usaha" class="col-2 col-form-label">Bidang Usaha</label>
						<div class="col-10">
							<input class="form-control" type="text" name="bidang_usaha" id="bidang_usaha">
						</div>
                    </div>

					<div class="form-group row">
						<label for="modal_dasar" class="col-2 col-form-label">Modal Dasar</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="modal_dasar" id="modal_dasar" value="0" min="0">
						</div>
                    </div>

					<div class="form-group row">
						<label for="modal_disetor" class="col-2 col-form-label">Modal Disetor</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="modal_disetor" id="modal_disetor" value="0" min="0">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="jumlah_lembar_saham" class="col-2 col-form-label">Jumlah Lembar Saham</label>
						<div class="col-10">
							<input class="form-control saham" type="text" name="jumlah_lembar_saham" id="jumlah_lembar_saham" value="0" min="0">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="nilai_nominal_per_saham" class="col-2 col-form-label">Nilai Nominal per Saham</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="nilai_nominal_per_saham" id="nilai_nominal_per_saham" value="0" min="0">
						</div>
					</div>

					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_cm.perusahaan_afiliasi.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\PerusahaanAfiliasiStore', '#formPerusahaanAfiliasi') !!}

<script type="text/javascript">
	$(document).ready(function () {

		$("#formPerusahaanAfiliasi").on('submit', function(e){
			e.preventDefault();

			if($(this).valid()) {
			const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-danger'
			},
				buttonsStyling: false
			})

			swalWithBootstrapButtons.fire({
				title: "Ingin melanjutkan isi detail perusahaan afiliasi?",
				text: "",
				icon: 'warning',
				showCancelButton: true,
				reverseButtons: true,
				confirmButtonText: 'Ya, Lanjut Isi Detail Perusahaan Afiliasi',
				cancelButtonText: 'Tidak'
			})
			.then((result) => {
				if (result.value) {
					$(this).append('<input type="hidden" name="url" value="edit" />');
					$(this).unbind('submit').submit();
				}
				else if (result.dismiss === Swal.DismissReason.cancel) {
					$(this).append('<input type="hidden" name="url" value="modul_cm.perusahaan_afiliasi.index" />');
					$(this).unbind('submit').submit();
				}
			});
		}
		});
	});
</script>
@endpush
