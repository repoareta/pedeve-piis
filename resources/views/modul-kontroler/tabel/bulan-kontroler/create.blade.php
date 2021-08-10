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
                Tambah Setting Bulan Kontroler
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Setting Bulan Kontroler</div>
                    </div>
                </div>
                <form class="form" id="formBulanKontroler" action="{{ route('modul_kontroler.tabel.bulan_kontroler.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="bulan-tahun-input" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
						<div class="col-4">
							<select class="form-control select2"" name="bulan">
                                <option value="">-- All --</option>
                                <option value="01" {{ date('m') == '01' ? 'selected' : '' }} >Januari</option>
                                <option value="02" {{ date('m') == '02' ? 'selected' : '' }} >Februari</option>
                                <option value="03" {{ date('m') == '03' ? 'selected' : '' }} >Maret</option>
                                <option value="04" {{ date('m') == '04' ? 'selected' : '' }} >April</option>
                                <option value="05" {{ date('m') == '05' ? 'selected' : '' }} >Mei</option>
                                <option value="06" {{ date('m') == '06' ? 'selected' : '' }} >Juni</option>
                                <option value="07" {{ date('m') == '07' ? 'selected' : '' }} >Juli</option>
                                <option value="08" {{ date('m') == '08' ? 'selected' : '' }} >Agustus</option>
                                <option value="09" {{ date('m') == '09' ? 'selected' : '' }} >September</option>
                                <option value="10" {{ date('m') == '10' ? 'selected' : '' }} >Oktober</option>
                                <option value="11" {{ date('m') == '11' ? 'selected' : '' }} >November</option>
                                <option value="12" {{ date('m') == '12' ? 'selected' : '' }} >Desember</option>
                            </select>
						</div>
                        <div class="col-4" >
                            <input class="form-control" type="text" value="{{ date('Y') }}" name="tahun" autocomplete="off"> 
                        </div>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="suplesi" autocomplete="off">
                        </div>
					</div>
					<div class="form-group row">
						<label for="keterangan-input" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control" type="text" name="keterangan" id="keterangan" >
						</div>
					</div>
					<div class="form-group row">
						<div class="col-2"></div>
						<div class="col-3">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="status" checked>
                                <span></span>Opening</label>
                            </div>
						</div>
                        <label for="opendate-input" class="col-2 col-form-label">Tanggal Opening</label>
						<div class="col-5">
							<input class="form-control date-picker" type="text" name="opendate" id="opendate" >
						</div>
					</div>
					<div class="form-group row">
						<div class="col-2"></div>
						<div class="col-3">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="2" name="status">
                                <span></span>Stoping</label>
                            </div>
						</div>
                        <label for="stopdate-input" class="col-2 col-form-label">Tanggal Stoping</label>
						<div class="col-5">
							<input class="form-control date-picker" type="text" name="stopdate" id="stopdate" >
						</div>
					</div>
					<div class="form-group row">
						<div class="col-2"></div>
						<div class="col-3">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="3" name="status">
                                <span></span>Closing</label>
                            </div>
						</div>
                        <label for="closedate-input" class="col-2 col-form-label">Tanggal Closing</label>
						<div class="col-5">
							<input class="form-control date-picker" type="text" name="closedate" id="closedate" >
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
{!! JsValidator::formRequest('App\Http\Requests\BulanKontrolerStore', '#formBulanKontroler'); !!}
<script>
    $(document).ready(function () {
        
        $("#formBulanKontroler").on('submit', function(e){            
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

        $('.date-picker').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});
        
    });
    
</script>
@endpush
