@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Edit Penempatan Deposito
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" id="form-edit">
            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label text-right">No. Dokumen<span class="text-danger">*</span></label>
                <div class="col-10">
                        <input class="form-control" type="text" value="{{ $data->docno}}" name="nodok" id="nodok" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{ $data->kurs}}" name="kurs" id="kurs" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{ $data->lineno}}" name="lineno" id="lineno" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{ $data->keterangan}}" name="keterangan" id="keterangan" size="50" maxlength="50" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                </div>
            </div>
            <div class="form-group row">
            {{--<label for="" class="col-2 col-form-label text-right">Asal<span class="text-danger">*</span></label>--}}
                <div class="col-10">
                    <input  class="form-control" type="hidden" value="{{ $data->asal}}" id="asal" name="asal" size="2" maxlength="2" onkeyup="this.value = this.value.toUpperCase()" required autocomplete="off">
                    <input  class="form-control" type="hidden" value="{{ $data->perpanjangan}}" id="perpanjangan" name="perpanjangan" size="2" maxlength="2" onkeyup="this.value = this.value.toUpperCase()" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Bank<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="{{ $data->namabank }}" id="namabank" name="namabank" size="30" maxlength="30" onkeyup="this.value = this.value.toUpperCase()" required autocomplete="off">
                    <input  class="form-control" type="hidden" value="{{ $data->kdbank }}" id="kdbank" name="kdbank" size="30" maxlength="30" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Nominal<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="{{ number_format($data->nominal,2,'.','') }}"  name="nominal" size="25" maxlength="25" required oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Tgl Deposito<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="<?php $tgl= date_create($data->tgldep); echo date_format($tgl, 'd-m-Y') ?>" id="tanggal" name="tanggal" size="15" maxlength="15" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Jatuh Tempo<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="<?php $tgl= date_create($data->tgltempo); echo date_format($tgl, 'd-m-Y') ?>" id="tanggal2" name="tanggal2" size="15" maxlength="15" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Bunga % Tahun<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="number" value="{{ number_format($data->bungatahun,2,'.','') }}" name="tahunbunga" size="25" required oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">No. Seri<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" value="{{ $data->noseri}}" id="noseri" name="noseri" size="15" maxlength="15" onkeyup="this.value = this.value.toUpperCase()" required autocomplete="off">
                </div>
            </div>
            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('penempatan_deposito.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$('#form-edit').submit(function(){
			$.ajax({
				url  : "{{ route('penempatan_deposito.update') }}",
				type : "POST",
				data : $('#form-edit').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
				console.log(data);
					Swal.fire({
						icon  : 'success',
						title : 'Data Berhasil Diubah',
						text  : 'Berhasil',
						timer : 2000
					}).then(function() {
							location.href = "{{ route('penempatan_deposito.index') }}";
						});
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});	
			return false;
		});
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
		$('#tanggal2').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
    });
</script>
@endpush