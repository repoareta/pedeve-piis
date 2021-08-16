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
                Edit AARD
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header AARD</div>
                    </div>
                </div>
                <form class="form" id="formTabelAard" action="{{ route('modul_sdm_payroll.tabel_aard.update') }}" method="POST">
					@csrf
                    <div class="form-group row">
						<label for="golongan-input" class="col-2 col-form-label">Kode<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="kode" maxlength="2" id="kode" value="{{ $data_list->kode }}" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="nama-input" class="col-2 col-form-label">Nama<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $data_list->nama }}" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="jenis-input" class="col-2 col-form-label">
                            Jenis
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="jenis" id="jenis">
                                @foreach ($data_jenisupah as $data)
									<option value="{{ $data->kode }}" {{ $data_list->jenis == $data->kode ? 'selected' : '' }}>
                                        {{ $data->kode }} -- {{ $data->nama }}  -- Cetak {{ $data->cetak}}
                                    </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="kenapajak-input" class="col-2 col-form-label">
                            Kena Pajak
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="kenapajak" id="kenapajak">
                                <option value="Y" {{ $data_list->kenapajak == 'Y' ? 'selected' : '' }}>YA</option>
								<option value="N" {{ $data_list->kenapajak == 'N' ? 'selected' : '' }}>TIDAK</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="lappajak-input" class="col-2 col-form-label">
                            Lap Pajak
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="lappajak" id="lappajak">
                                <option value="Y" {{ $data_list->lappajak == 'Y' ? 'selected' : '' }}>YA</option>
								<option value="N" {{ $data_list->lappajak == 'N' ? 'selected' : '' }}>TIDAK</option>
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
{!! JsValidator::formRequest('App\Http\Requests\TabelAardUpdate', '#formTabelAard'); !!}
<script>
    $(document).ready(function () {
        
        $("#formTabelAard").on('submit', function(e){            
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
