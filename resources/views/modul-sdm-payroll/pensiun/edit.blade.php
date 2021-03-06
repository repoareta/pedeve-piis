@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Pensiun
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.pensiun.update') }}" method="post" id="form-edit">
            @csrf
            <div class="alert alert-custom alert-default" role="alert">
                <div class="alert-text">
                    Header Pensiun
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Pribadi <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control money" name="pribadi" type="text" size="2" maxlength="2" autocomplete="off" value="{{ $pensiun->pribadi }}">
                    @error('pribadi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Perusahaan Direksi <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control money" name="perusahaan" type="text" size="40" maxlength="50" autocomplete="off" value="{{ $pensiun->perusahaan }}">
                    @error('perusahaan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Perusahaan Pekerja <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control money" name="perusahaan2" type="text" size="40" maxlength="50" autocomplete="off" value="{{ $pensiun->perusahaan2 }}">
                    @error('perusahaan2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Perusahaan Direksi(BNI) <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control money" name="perusahaan3" type="text" size="40" maxlength="50" autocomplete="off" value="{{ $pensiun->perusahaan3 }}">
                    @error('perusahaan3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_sdm_payroll.pensiun.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PensiunStoreRequest', '#form-edit'); !!}

<script type="text/javascript">
	$(document).ready(function () {
		$('#form-edit').submit(function(e){
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