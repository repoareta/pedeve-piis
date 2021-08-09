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
                Tambah Kas Bank Kontroler
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Kas Bank Kontroler</div>
                    </div>
                </div>
                <form class="form" id="formJenisBiaya" action="{{ route('modul_kontroler.tabel.jenis_biaya.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="kode-input" class="col-2 col-form-label">
                            Kode
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<input class="form-control only-number" type="text" name="kode" maxlength="2" id="kode">
						</div>
					</div>
					<div class="form-group row">
						<label for="nama-input" class="col-2 col-form-label">
                            Nama
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" onkeyup="this.value = this.value.toUpperCase()">
						</div>
					</div>
                    <div class="form-group row">
						<label for="jk-input" class="col-2 col-form-label">
                            Jenis Kartu
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="jk" id="jk">
                                <option value="10">Kas (Rupiah)</option>
                                <option value="11">Bank (Rupiah)</option>
                                <option value="13">Bank (Dollar)</option>
							</select>
						</div>
					</div>
                    <div class="form-group row">
						<label for="sanper-input" class="col-2 col-form-label">
                            Sandi Perkiraan
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="sanper" id="sanper">
                                @foreach ($data_sanper as $data)
                                    <option value="{{ $data->kodeacct }}">
                                        {{ $data->kodeacct }} -- {{ $data->descacct }}
                                    </option>
                                @endforeach
							</select>
						</div>
					</div>
                    <div class="form-group row">
						<label for="norek-input" class="col-2 col-form-label">
                            No.Rekening
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<input class="form-control only-number" type="text" name="norek" maxlength="2" id="norek">
						</div>
					</div>
                    <div class="form-group row">
						<label for="currency-index-input" class="col-2 col-form-label">
                            Currency Index
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="ci" id="ci">	
                                <option value="1">RP</option>
                                <option value="2">US$</option>
							</select>
						</div>
					</div>
                    <div class="form-group row">
						<label for="lokasi-input" class="col-2 col-form-label">
                            Lokasi
                            <span class="text-danger">*</span>
                        </label>
						<div class="col-10">
							<select class="form-control select2" name="lokasi" id="lokasi">	
                                <option value="MD">MD</option>
                                <option value="MS">MS</option>
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
{!! JsValidator::formRequest('App\Http\Requests\JenisBiayaStore', '#formJenisBiaya'); !!}
<script>
    $(document).ready(function () {
        
        $("#formJenisBiaya").on('submit', function(e){            
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

        $(".only-number").on("keypress keyup blur",function (event) {    
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });
    
</script>
@endpush
