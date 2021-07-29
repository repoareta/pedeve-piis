@extends('layout.global')
@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">
				Cetak D5 (General Ledger) </h3>
			<span class="kt-subheader__separator kt-hidden"></span>
			<div class="kt-subheader__breadcrumbs">
				<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<a href="" class="kt-subheader__breadcrumbs-link">
					Kontroler </a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Cetak D5 (General Ledger)</span>
			</div>
		</div>
	</div>
</div>
<!-- end:: Subheader -->

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head kt-portlet__head--lg">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Tabel Cetak D5 (General Ledger)
			</h3>			
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="kt-portlet__head-wrapper">
				<div class="kt-portlet__head-actions">
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<form class="kt-form" action="{{route('d5_report.export')}}" method="post">
			@csrf
			<div class="kt-portlet__body">
				<input class="form-control" type="hidden" name="userid" value="{{Auth::user()->userid}}">

				<div class="form-group row">
				<label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
				<div class="col-4">
						<?php 
						foreach($data_tahun as $data){ 
							$tahun = substr($data->sbulan, 0, 4);
							$bulan = substr($data->sbulan, 4, 2);
							$suplesi = substr($data->sbulan, 6);
						}
						?>
						<select class="form-control select2" name="bulan">
							<option value="">-- All --</option>
							<option value="01" <?php if($bulan  == '01' ) echo 'selected' ; ?>>Januari</option>
							<option value="02" <?php if($bulan  == '02' ) echo 'selected' ; ?>>Februari</option>
							<option value="03" <?php if($bulan  == '03' ) echo 'selected' ; ?>>Maret</option>
							<option value="04" <?php if($bulan  == '04' ) echo 'selected' ; ?>>April</option>
							<option value="05" <?php if($bulan  == '05' ) echo 'selected' ; ?>>Mei</option>
							<option value="06" <?php if($bulan  == '06' ) echo 'selected' ; ?>>Juni</option>
							<option value="07" <?php if($bulan  == '07' ) echo 'selected' ; ?>>Juli</option>
							<option value="08" <?php if($bulan  == '08' ) echo 'selected' ; ?>>Agustus</option>
							<option value="09" <?php if($bulan  == '09' ) echo 'selected' ; ?>>September</option>
							<option value="10" <?php if($bulan  =='10'  ) echo 'selected' ; ?>>Oktober</option>
							<option value="11" <?php if($bulan  == '11' ) echo 'selected' ; ?>>November</option>
							<option value="12" <?php if($bulan  == '12' ) echo 'selected' ; ?>>Desember</option>
						</select>
				</div>
					<div class="col-4" >
						<input class="form-control tahun" type="text" name="tahun" value="{{$tahun}}" autocomplete="off" required> 
					</div>
					<div class="col-2" >
						<input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" size="15" maxlength="15" autocomplete="off">
						<input class="form-control" type="text" value="{{$suplesi}}"   name="suplesi" autocomplete="off" required>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Sandi Perkiraan</label>
					<div class="col-10">
						<select class="cariaccount form-control" style="width: 100% !important;" name="sandi"></select>
					</div>
				</div>
				<div class="kt-form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a  href="{{ route('default.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Cancel</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-brand"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
   
	
	
	$('.cariaccount').select2({
		placeholder: '-Pilih-',
		allowClear: true,
		ajax: {
			url: "{{ route('d5_report.search.account') }}",
			type : "get",
			dataType : "JSON",
			headers: {
			'X-CSRF-Token': '{{ csrf_token() }}',
			},
			delay: 250,
		processResults: function (data) {
			return {
			results:  $.map(data, function (item) {
				return {
				text: item.kodeacct +'--'+ item.descacct,
				id: item.kodeacct
				}
			})
			};
		},
		cache: true
		}
	});
	$('#tanggal').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		// language : 'id',
		format   : 'dd MM yyyy'
	});
});
			var myVar;



function myFunction() {

myVar = setTimeout(showPage, 500);

}



function showPage() {

document.getElementById("loader").style.display = "none";

document.getElementById("myDiv").style.display = "block";

}
$(document).ready(function(){
$("#myDiv").fadeOut();
})
</script>
@endsection