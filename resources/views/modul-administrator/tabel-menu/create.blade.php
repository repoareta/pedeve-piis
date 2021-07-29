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
                Tambah Tabel Menu
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Tabel Menu</div>
                    </div>
                </div>
                <form class="form" id="formTabelMenu" action="{{ route('modul_administrator.tabel_menu.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="menuid-input" class="col-2 col-form-label">Menu ID</label>
						<div class="col-10">
							<input class="form-control" type="text" name="menuid" id="menuid" onkeyup="this.value = this.value.toUpperCase()">
						</div>
					</div>
					<div class="form-group row">
						<label for="menunm-input" class="col-2 col-form-label">Nama Menu</label>
						<div class="col-10">
							<input class="form-control" type="text" name="menunm" id="menunm" onkeyup="this.value = this.value.toUpperCase()">
						</div>
					</div>
                    <div class="form-group row">
						<label for="userap-input" class="col-2 col-form-label">User Application</label>
						<div class="col-10">
							<select class="form-control select2" name="userap" id="userap">
								<option value="">- Pilih Data -</option>
                                <option value="UMU">UMUM</option>
                                <option value="SDM">SDM & Payroll</option>
                                <option value="PBD">PERBENDAHARAAN</option>
                                <option value="AKT">KONTROLER</option>
                                <option value="CM">CUSTOMER MANAGEMENT</option>
							</select>
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
{!! JsValidator::formRequest('App\Http\Requests\TabelMenuStore', '#formTabelMenu'); !!}
<script>
    $(document).ready(function () {

        // select2
        

        // submit form
        $("#formTabelMenu").on('submit', function(e){            
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

        // only number
        $('input[name="menuid"]').keyup(function(e)
        {
            if (/\D/g.test(this.value))
            {
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
    });
    
</script>
@endpush
