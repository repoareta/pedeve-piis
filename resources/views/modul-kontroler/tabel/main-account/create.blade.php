@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Main Account
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Main Account</div>
                    </div>
                </div>
                <form class="form" id="formMainAccount" action="{{ route('modul_kontroler.tabel.main_account.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="jenis-input" class="col-2 col-form-label">Jenis<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="jenis" id="jenis" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="batas-awal-input" class="col-2 col-form-label">Batas Awal<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="batas_awal" id="batas_awal" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="batas-akhir-input" class="col-2 col-form-label">Batas Akhir<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="batas_akhir" id="batas_akhir" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="urutan-input" class="col-2 col-form-label">Urutan<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="urutan" id="urutan" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="pengali-input" class="col-2 col-form-label">Pengali<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="pengali" id="pengali" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="pengali-input" class="col-2 col-form-label">Pengali Tampil<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="pengali_tampil" id="pengali_tampil" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="sub-akun-input" class="col-2 col-form-label">Sub Akun<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="sub_akun" id="sub_akun" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="lokasi-input" class="col-2 col-form-label">Lokasi<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="lokasi" id="lokasi" autocomplete="off">
						</div>
					</div>
					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
				</form>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\MainAccountStore', '#formMainAccount'); !!}
<script>
    $(document).ready(function () {
        
        $("#formMainAccount").on('submit', function(e){            
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
                    title: "Apakah anda yakin mau menyimpan data ini?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value == true) {
                        console.log(result);
                        $(this).unbind('submit').submit();
                    }
                });
            }
        });
        
    });
    
</script>
@endpush
