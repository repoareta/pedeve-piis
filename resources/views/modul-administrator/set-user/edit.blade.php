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
                Tambah Set User
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Set User</div>
                    </div>
                </div>
                <form class="kt-form kt-form--label-right" id="formSetUser" action="{{ route('modul_administrator.set_user.update', $data->userid) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="userid-input" class="col-2 col-form-label">User ID</label>
						<div class="col-10">
							<input class="form-control" type="text" name="userid" id="userid" value="{{ $data->userid }}" style="background-color:#DCDCDC; cursor:not-allowed" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="usernm-input" class="col-2 col-form-label">User Name</label>
						<div class="col-10">
							<input class="form-control" type="text" name="usernm" id="usernm" onkeyup="this.value = this.value.toUpperCase()" value="{{ $data->userid }}">
						</div>
					</div>
                    <div class="form-group row">
						<label for="kode-input" class="col-2 col-form-label">Jenis Dinas</label>
						<div class="col-10">
							<select class="form-control kt-select2" name="kode" id="kode">
								<option value="KONTROLER" {{ $data->kode == 'KONTROLLER' ? 'selected' : '' }}>KONTROLER</option>		
                                <option value="CUSTOMER MANAGEMENT" {{ $data->kode == 'CUSTOMER MANAGEMENT' ? 'selected' : '' }}>CUSTOMER MANAGEMENT</option>
                                <option value="PERBENDAHARAAN" {{ $data->kode == 'PERBENDAHARAAN' ? 'selected' : '' }}>PERBENDAHARAAN</option>
                                <option value="SDM" {{ $data->kode == 'SDM' ? 'selected' : '' }}>SDM</option>
                                <option value="UMUM" {{ $data->kode == 'UMUM' ? 'selected' : '' }}>UMUM</option>
                                <option value="ADMIN" {{ $data->kode == 'ADMIN' ? 'selected' : '' }}>SYSTEM ADMINISTRATOR</option>	
							</select>
						</div>
					</div>
                    <div class="form-group row">
                        <label for="user-lv-input" class="col-2 col-form-label">User Level</label>
                        <div class="col-10 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-outline radio-primary">
                                <input type="radio" name="userlv" value="0" {{ $data->userlv == 0 ? 'checked' : '' }}>
                                <span></span>ADMINISTRATOR</label>
                                <label class="radio radio-outline radio-primary">
                                <input type="radio" name="userlv" value="1" {{ $data->userlv == 1 ? 'checked' : '' }}>
                                <span></span>USER</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <?php
                            if(substr_count($data->userap,"A") > 0){
                                $userp1 = "A"; 
                            }else{ 
                                $userp1="";
                            } 
                            if(substr_count($data->userap,"G") > 0){
                                $userp2 = "G"; 
                            }else{ 
                                $userp2="";
                            } 
                            if(substr_count($data->userap,"D") > 0){ 
                                $userp3 = "D"; 
                            }else{ 
                                $userp3="";
                            } 
                            if(substr_count($data->userap,"E") > 0){ 
                                $userp4 = "E"; 
                            }else{ 
                                $userp4="";
                            } 
                            if(substr_count($data->userap,"F") > 0){ 
                                $userp5 = "F"; 
                            }else{ 
                                $userp5="";
                            } 
						?>
                        <label for="user-app-input" class="col-2 col-form-label">User Application</label>
                        <div class="col-10 col-form-label">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="akt" value="A" {{ $userp1 == 'A' ? 'checked' : '' }}>
                                <span></span>Kontroler</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="cm" value="G" {{ $userp2 == 'G' ? 'checked' : '' }}>
                                <span></span>Customer Management</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="pbd" value="D" {{ $userp3 == 'D' ? 'checked' : '' }}>
                                <span></span>Perbendaharaan</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="umu" value="E" {{ $userp3 == 'E' ? 'checked' : '' }}>
                                <span></span>Umum</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="sdm" value="F" {{ $userp3 == 'F' ? 'checked' : '' }}>
                                <span></span>SDM</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
							<label for="nopeg-input" class="col-2 col-form-label">Nopeg Pekerja</label>
							<div class="col-10">
								<select class="form-control kt-select2" name="nopeg" id="nopeg">									
									@foreach ($pekerja_list as $pekerja)
									    <option value="{{ $pekerja->nopeg }}" {{ $data->nopeg == $pekerja->nopeg ? 'selected' : '' }}>{{ $pekerja->nopeg." - ".$pekerja->nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="gcg-fungsi-input" class="col-2 col-form-label">GCG Fungsi</label>
							<div class="col-10">
								<select class="form-control kt-select2" name="gcg_fungsi_id" id="gcg_fungsi_id">									
									@foreach ($gcg_fungsi_list as $fungsi)
									    <option value="{{ $fungsi->id }}" {{ $data->gcg_fungsi_id == $fungsi->id ? 'selected' : '' }}>{{ $fungsi->nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="gcg-jabatan-input" class="col-2 col-form-label">GCG Jabatan</label>
							<div class="col-10">
								<select class="form-control kt-select2" name="gcg_jabatan_id" id="gcg_jabatan_id">									
									@foreach ($gcg_jabatan_list as $jabatan)
									    <option value="{{ $jabatan->id }}" {{ $data->gcg_jabatan_id == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama }}</option>
									@endforeach
								</select>
							</div>
						</div>
                    <div class="form-group row">
                        <label for="user-app-input" class="col-2 col-form-label">Last Updated By</label>
                        <div class="col-10">
                            <input class="form-control" type="text" value="{{ $data->usrupd }}" style="background-color:#DCDCDC; cursor:not-allowed" readonly="">
                        </div>
                    </div>


					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\SetUserUpdate', '#formSetUser'); !!}
<script>
    $(document).ready(function () {
        $('.kt-select2').select2().on('change', function() {
            $(this).valid();
        });

        $("#formSetUser").on('submit', function(e){            
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
