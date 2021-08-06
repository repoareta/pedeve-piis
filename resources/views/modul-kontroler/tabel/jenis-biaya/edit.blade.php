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
                Edit Jenis Biaya
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Jenis Biaya</div>
                    </div>
                </div>
                <form class="form" id="formCashJudex" action="{{ route('modul_kontroler.tabel.jenis_biaya.update') }}" method="POST">
					@csrf
                    <div class="form-group row">
						<label for="userid-input" class="col-2 col-form-label">Kode<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="kode" id="kode" value="{{ $data->kode }}" style="background-color:#DCDCDC; cursor:not-allowed" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="usernm-input" class="col-2 col-form-label">Nama JB<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" value="{{ $data->keterangan }}" type="text" name="keterangan" id="keterangan" onkeyup="this.value = this.value.toUpperCase()">
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
{!! JsValidator::formRequest('App\Http\Requests\CashJudexUpdate', '#formCashJudex'); !!}
<script>
    $(document).ready(function () {
        
        $("#formCashJudex").on('submit', function(e){            
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

        $("#kode").on("keypress keyup blur",function (event) {    
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });
    
</script>
@endpush
