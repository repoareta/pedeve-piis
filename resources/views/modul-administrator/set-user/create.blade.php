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
                <form class="form" id="formSetUser" action="{{ route('modul_administrator.set_user.store') }}" method="POST">
					@csrf

					<div class="form-group row">
						<label for="userid-input" class="col-2 col-form-label">User ID<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="userid" id="userid" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="usernm-input" class="col-2 col-form-label">User Name<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="usernm" id="usernm" autocomplete="off">
						</div>
					</div>
                    <div class="form-group row">
						<label for="kode-input" class="col-2 col-form-label">Jenis Dinas</label>
						<div class="col-10">
							<select class="form-control select2" name="kode" id="kode">
								<option value="KONTROLER">KONTROLER</option>
                                <option value="CUSTOMER MANAGEMENT">CUSTOMER MANAGEMENT</option>
                                <option value="PERBENDAHARAAN">PERBENDAHARAAN</option>
                                <option value="SDM">SDM</option>
                                <option value="UMUM">UMUM</option>
                                <option value="ADMIN">SYSTEM ADMINISTRATOR</option>
							</select>
						</div>
					</div>
                    <div class="form-group row">
                        <label for="user-lv-input" class="col-2 col-form-label">User Level</label>
                        <div class="col-10 col-form-label">
                            <div class="radio-inline">
                                <label class="radio ">
                                <input type="radio" name="userlv" value="0">
                                <span></span>ADMINISTRATOR</label>
                                <label class="radio ">
                                <input type="radio" name="userlv" value="1">
                                <span></span>USER</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user-app-input" class="col-2 col-form-label">User Application</label>
                        <div class="col-10 col-form-label">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="akt" value="A">
                                <span></span>Kontroler</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="cm" value="G">
                                <span></span>Customer Management</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="pbd" value="D">
                                <span></span>Perbendaharaan</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="umu" value="E">
                                <span></span>Umum</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="sdm" value="F">
                                <span></span>SDM</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nopeg-input" class="col-2 col-form-label">Nopeg Pekerja</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="nopeg" id="nopeg">
                                <option value="">- Pilih Data -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg." - ".$pegawai->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="gcg-fungsi-input" class="col-2 col-form-label">GCG Fungsi</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="gcg_fungsi_id" id="gcg_fungsi_id">
                                <option value="">- Pilih Data -</option>
                                @foreach ($gcg_fungsi_list as $fungsi)
                                    <option value="{{ $fungsi->id }}">{{ $fungsi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gcg-jabatan-input" class="col-2 col-form-label">GCG Jabatan</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="gcg_jabatan_id" id="gcg_jabatan_id">
                                <option value="">- Pilih Data -</option>
                                @foreach ($gcg_jabatan_list as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
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
{!! JsValidator::formRequest('App\Http\Requests\SetUserStore', '#formSetUser'); !!}
<script>
    $(document).ready(function () {


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
