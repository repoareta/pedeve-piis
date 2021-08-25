@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Pinjaman Pekerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.pinjaman_pekerja.store') }}" method="post" id="form-create">
            @csrf
            <div class="alert alert-custom alert-default" role="alert">
                <div class="alert-text">
                    Header Pinjaman Pekerja
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">ID Pinjaman<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="no_pinjaman" id="no_pinjaman" size="8" maxlength="8" autocomplete="off" disabled>
                    <input class="form-control" type="hidden" name="id_pinjaman" id="id_pinjaman" autocomplete="off">
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid}}" name="userid" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">NO. Pekerja<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="nopek" id="nopekerja" class="form-control selectpicker" data-live-search="true">
                        <option value="">- Pilih -</option>
                        @foreach($data_pegawai as $data)
                        <option value="{{$data->nopeg}}">{{$data->nopeg}} - {{$data->nama}}</option>
                        @endforeach
                    </select>								
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">NO. Kontrak<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value=""  name="no_kontrak" size="16" maxlength="16" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                <div class="col-10">
                    <div class="input-daterange input-group" id="date_range_picker">
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" name="mulai" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" name="sampai" autocomplete="off">
                    </div>
                    <span class="form-text text-muted">Pilih rentang waktu Pinjaman</span>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Tenor<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value=""  name="tenor" size="4" maxlength="4" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Angsuran<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="0"  name="angsuran" id="angsuran" size="25" maxlength="25" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Pinjaman<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="0"  name="jml_pinjaman" id="jml_pinjaman" size="35" maxlength="35" autocomplete="off">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_sdm_payroll.pinjaman_pekerja.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Pinjaman Pekerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table">
            <thead class="thead-light">
                <tr>
                <th></th>
                <th>No</th>
                <th>Tahun</th>	
                <th>Bulan</th>
                <th>Pokok</th>
                <th>Bunga</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PinjamanKerjaStoreRequest', '#form-create'); !!}
<script type="text/javascript">
	$(document).ready(function () {
		$('#tanggal').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            format   : 'dd-mm-yyyy',
            autoclose: true,
        });
        
        $('#date_range_picker').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            format   : 'dd-mm-yyyy',
            autoclose: true,
        });

		$("#nopekerja").on("change", function(){
			var nopek = $(this).val();
			$.ajax({
				url : "{{route('modul_sdm_payroll.pinjaman_pekerja.idpinjaman.json')}}",
				type : "POST",
				dataType: 'JSON',
				data : {
                    nopek: nopek
                },
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
                },
				success : function(data){
					$('#id_pinjaman').val(data);
					$('#no_pinjaman').val(data);
				},
				error : function(){
					alert("Ada kesalahan controller!");
				}
			});
		});

		$('#form-create').submit(function(e){
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