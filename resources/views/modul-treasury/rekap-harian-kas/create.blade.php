@extends('layouts.app')

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
                Menu Tambah Rekap Harian Kas Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" id="form-create">
            @csrf

            <div class="form-group row">
                <label class="col-2 col-form-label">Tanggal Rekap</label>
                <div class="col-10">
                    <input class="form-control" type="hidden" name="add" value="add">
                    <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{(date('Y-m-d'))}}" size="11" maxlength="11"  autocomplete="off" required oninvalid="this.setCustomValidity('Tanggal Rekap Harus Diisi..')">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Jenis Kartu<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="jk" id="jk" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Jenis Kartu Harus Diisi..')">
                        <option value="">- Pilih -</option>
                        <option value="10">Kas(Rupiah)</option>
                        <option value="11">Bank(Rupiah)</option>
                        <option value="13">Bank(Dollar)</option>
                    </select>							
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label">No. Kas/Bank<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="nokas" id="nokas" class="form-control" required oninvalid="this.setCustomValidity('No. Kas/Bank Harus Diisi..')">
                        <option value="">- Pilih -</option>
                        
                        
                    </select>
                    <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid" autocomplete="off">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{route('rekap_harian_kas.index')}}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" class="btn btn-primary" name="submit" ><i class="fa fa-check"></i>Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
$('#form-create').submit(function(){
	$.ajax({
		url  : "{{route('rekap_harian_kas.store')}}",
		type : "POST",
		data : $('#form-create').serialize(),
		dataType : "JSON",
		headers: {
		'X-CSRF-Token': '{{ csrf_token() }}',
		},
		success : function(data){
		console.log(data);
		if(data == 1){
			Swal.fire({
				icon  : 'success',
				title : 'Data Berhasil Ditambah',
				text  : 'Berhasil',
				timer : 2000
			}).then(function() {
				location.replace("{{route('rekap_harian_kas.index')}}");
				});
		}else if(data == 2){
			Swal.fire({
				icon  : 'info',
				title : 'rekap gagal !',
				text  : 'Info',
			});
		}else if(data == 3){
			Swal.fire({
				icon  : 'info',
				title : 'rekap harian sudah dilakukan sebelumnya, rekap gagal!',
				text  : 'Info',
			});
		}else if(data == 4){
			Swal.fire({
				icon  : 'info',
				title : 'rekap harian ini sudah ada!',
				text  : 'Info',
			});
		}else{
			Swal.fire({
				icon  : 'info',
				title : 'rekap kas sudah dilakukan!',
				text  : 'Info',
			});
		}
		}, 
		error : function(){
			alert("Terjadi kesalahan, coba lagi nanti");
		}
	});	
	return false;
});
$("#tanggal").on("change", function(){
var tanggal = $('#tanggal').val();
	$.ajax({
		url : "{{route('rekap_harian_kas.jenis.kartu.json')}}",
		type : "POST",
		dataType: 'json',
		data : {
			tanggal:tanggal
			},
		headers: {
			'X-CSRF-Token': '{{ csrf_token() }}',
			},
		success : function(data){
			if(data == 1){
				Swal.fire({
                icon  : 'info',
				title : 'Tidak Di temuka Data kas Bank Pada Tanggal '+tanggal,
				text  : 'Failed',
			});
			}else{
				$('#jk').val(data.jk).trigger('change');
			}
		},
		error : function(){
			alert("Terjadi kesalahan, coba lagi nanti");
		}
	})
});
$("#jk").on("change", function(){
var tanggal = $('#tanggal').val();
var jk = $('#jk').val();
	$.ajax({
		url : "{{route('rekap_harian_kas.nokas.json')}}",
		type : "POST",
		dataType: 'json',
		data : {
			jk:jk,
			tanggal:tanggal
			},
		headers: {
			'X-CSRF-Token': '{{ csrf_token() }}',
			},
		success : function(data){
			if(data == 1){
				Swal.fire({
				icon  : 'info',
				title : 'Tidak Di temuka Data kas Bank Pada Tanggal '+tanggal,
				text  : 'Failed',
			});
			}else{
				$('#nokas').html(data.html);
			}
		},
		error : function(){
			alert("Terjadi kesalahan, coba lagi nanti");
		}
	})
});

    $('#tanggal').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        autoclose: true,
        language : 'id',
        format   : 'yyyy-mm-dd'
    });
});
</script>
@endpush