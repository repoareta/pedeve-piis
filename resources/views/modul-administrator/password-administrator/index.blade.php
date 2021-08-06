@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')
    <style>
        span i{
            cursor:pointer;
        }

        .help-block.error-help-block{            
            position: absolute;
            display: block;
            width: auto;
            left: 0 !important;
            bottom: 100px;
            top: unset;
            bottom: -18px !important;
        }
    </style>
@endpush

@section('content')

<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Password Administrator
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Password Adminstrator</div>
                    </div>
                </div>
                <form class="form" id="formPasswordAdministrator" action="{{ route('modul_administrator.password_administrator.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="password-lama-input" class="col-md-2 col-form-label">Password Lama<span class="text-danger">*</span></label>
						<div class="col-md-10">
                            <div class="input-icon input-icon-right">
                                <input class="form-control password" type="password" name="password_lama" id="password_lama" autocomplete="off">
                                <span class="mr-3">
                                    <i id="eye1" class="fas fa-eye-slash icon-md eye"></i>
                                </span>
                            </div>
						</div>
					</div>
					<div class="form-group row">
						<label for="password-baru-input" class="col-md-2 col-form-label">Password Baru<span class="text-danger">*</span></label>
						<div class="col-md-10">
                            <div class="input-icon input-icon-right">
                                <input class="form-control password" type="password" name="password_baru" id="password_baru" autocomplete="off">
                                <span class="mr-3">
                                    <i id="eye2" class="fas fa-eye-slash icon-md eye"></i>
                                </span>
                            </div>							
						</div>
					</div>
					<div class="form-group row">
						<label for="password-konfirmasi-input" class="col-md-2 col-form-label">Konfirmasi Password<span class="text-danger">*</span></label>
						<div class="col-md-10">
                            <div class="input-icon input-icon-right">
                                <input class="form-control password" type="password" name="password_konfirmasi" id="password_konfirmasi" autocomplete="off">
                                <span class="mr-3">
                                    <i id="eye3" class="fas fa-eye-slash icon-md eye"></i>
                                </span>
                            </div>							
						</div>
					</div>
					<div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
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
{!! JsValidator::formRequest('App\Http\Requests\PasswordAdministratorStore', '#formPasswordAdministrator'); !!}
<script>
    $(document).ready(function () {
        

        $('span #eye1').click(function(){
            
            if($(this).hasClass('fa-eye-slash')){
                
                $(this).removeClass('fa-eye-slash');
                
                $(this).addClass('fa-eye');
                
                $('#password_lama').attr('type','text');
                
            } else {
                
                $(this).removeClass('fa-eye');
                
                $(this).addClass('fa-eye-slash');  
                
                $('#password_lama').attr('type','password');
            }
        });

        $('span #eye2').click(function(){
            
            if($(this).hasClass('fa-eye-slash')){
                
                $(this).removeClass('fa-eye-slash');
                
                $(this).addClass('fa-eye');
                
                $('#password_baru').attr('type','text');
                
            } else {
                
                $(this).removeClass('fa-eye');
                
                $(this).addClass('fa-eye-slash');  
                
                $('#password_baru').attr('type','password');
            }
        });

        $('span #eye3').click(function(){
            
            if($(this).hasClass('fa-eye-slash')){
                
                $(this).removeClass('fa-eye-slash');
                
                $(this).addClass('fa-eye');
                
                $('#password_konfirmasi').attr('type','text');
                
            } else {
                
                $(this).removeClass('fa-eye');
                
                $(this).addClass('fa-eye-slash');  
                
                $('#password_konfirmasi').attr('type','password');
            }
        });

        $("#formPasswordAdministrator").on('submit', function(e){            
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
