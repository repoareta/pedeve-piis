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
                Tabel Mencetak Periode Kas Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" action="{{route('rekap_periode_kas.exportperiode')}}" method="post">
            @csrf
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label text-right">Mulai Tanggal<span class="text-danger">*</span></label>
                <div class="col-10">
                    <div class="input-daterange input-group" id="date_range_picker">
                        <input type="text" class="form-control" name="tanggal" id="tanggal" autocomplete="off" required oninvalid="this.setCustomValidity('Mulai Harus Diisi..')"/>
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input type="text" class="form-control" name="tanggal2" id="tanggal2" autocomplete="off" required oninvalid="this.setCustomValidity('Sampai Harus Diisi..')"/>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label text-right">Jenis Kartu<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select class="form-control select2" style="width: 100%;"  name="jk" id="jk" required oninvalid="this.setCustomValidity('Jenis Kartu Harus Diisi..')">
                        <option value="">- Pilih -</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label text-right">No.Kas/Bank<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select class="form-control select2" style="width: 100%;"  name="nokas" id="nokas" required oninvalid="this.setCustomValidity('No.Kas/Bank Harus Diisi..')">
                        <option value="">- Pilih -</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-2 col-form-label text-right">Setuju<span class="text-danger">*</span></label>
                <div class="col-4">
                    <input class="form-control" type="text" value="" name="setuju" id="setuju" size="50" maxlength="50" required oninvalid="this.setCustomValidity('Setuju Harus Diisi..')" autocomplete="off">
                </div>
                <label class="col-2 col-form-label text-right">Dibuat Oleh<span class="text-danger">*</span></label>
                <div class="col-4" >
                    <input class="form-control" type="text" value="" name="dibuat" id="dibuat" size="50" maxlength="50" required oninvalid="this.setCustomValidity('Dibuat Oleh Harus Diisi..')" autocomplete="off">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
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
	
   
	$('#date_range_picker').datepicker({
		todayHighlight: true,
		autoclose: true,
        format   : 'dd-mm-yyyy',
	});
	
	$("#tanggal").on("change", function(e){
		e.preventDefault();
		var tanggal = $('#tanggal').val();
		var tanggal2 = $('#tanggal2').val();
		$.ajax({
			url : "{{route('rekap_periode_kas.jk.json')}}",
			type : "POST",
			dataType: 'json',
			data : {
				tanggal:tanggal,
				tanggal2:tanggal2,
				},
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
			success : function(data){
						var html = '';
						var i;
						html += '<option value="">- Pilih - </option>';
						for(i=0; i<data.length; i++){
							html += '<option value="'+data[i].jk+'">'+data[i].jk+'</option>';
						}
						$('#jk').html(html);		
			},
			error : function(){
				alert("Ada kesalahan controller!");
			}
		})
	});
	$("#tanggal2").on("change", function(e){
		e.preventDefault();
		var tanggal = $('#tanggal').val();
		var tanggal2 = $('#tanggal2').val();
		$.ajax({
			url : "{{route('rekap_periode_kas.jk.json')}}",
			type : "POST",
			dataType: 'json',
			data : {
				tanggal:tanggal,
				tanggal2:tanggal2,
				},
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
			success : function(data){
						var html = '';
						var i;
						html += '<option value="">- Pilih - </option>';
						for(i=0; i<data.length; i++){
							html += '<option value="'+data[i].jk+'">'+data[i].jk+'</option>';
						}
						$('#jk').html(html);		
			},
			error : function(){
				alert("Ada kesalahan controller!");
			}
		})
	});
	$("#jk").on("change", function(e){
		e.preventDefault();
		var tanggal = $('#tanggal').val();
		var tanggal2 = $('#tanggal2').val();
		var jk = $('#jk').val();
		$.ajax({
			url : "{{route('rekap_periode_kas.nokas.json')}}",
			type : "POST",
			dataType: 'json',
			data : {
				tanggal:tanggal,
				tanggal2:tanggal2,
				jk:jk
				},
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
			success : function(data){
						var html = '';
						var i;
						html += '<option value="">- Pilih - </option>';
						for(i=0; i<data.length; i++){
							html += '<option value="'+data[i].store+'">'+data[i].store+' -- '+data[i].namabank+' -- '+data[i].norekening+'</option>';
						}
						$('#nokas').html(html);		
			},
			error : function(){
				alert("Ada kesalahan controller!");
			}
		})
	});
});
</script>
@endpush