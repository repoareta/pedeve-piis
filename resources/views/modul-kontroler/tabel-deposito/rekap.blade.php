@extends('layout.global')

@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">
				Cetak Penempatan Deposito </h3>
			<span class="kt-subheader__separator kt-hidden"></span>
			<div class="kt-subheader__breadcrumbs">
				<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<a href="" class="kt-subheader__breadcrumbs-link">
					Perbendaharaan </a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Cetak Penempatan Deposito</span>
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
				Tabel Cetak Penempatan Deposito
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
		<form class="kt-form kt-form--label-right" action="{{route('tabel_deposito.export')}}" method="post">
			{{csrf_field()}}
			<div class="kt-portlet__body">
				<input class="form-control" type="hidden" name="userid" value="{{Auth::user()->userid}}">
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Bank</label>
					<div class="col-10">
						<select name="sanper" class="form-control select2"  oninvalid="this.setCustomValidity('Bank Harus Diisi..')" onchange="setCustomValidity('')">
							<option value="">- All -</option>
							@foreach($data_bank as $data)
							<option value="{{$data->kdbank}}">{{$data->kdbank}} -- {{$data->descacct}}</option>
							@endforeach
						</select>								
					</div>
				</div>
				<div class="form-group row">
				<label for="" class="col-2 col-form-label">Bulan/Tahun<span style="color:red;">*</span></label>
				<div class="col-5">
						<?php 
							$tahun = date('Y');
							$bulan = date('m');
							$kurs = 1;
						?>
						<select class="form-control select2" name="bulan">
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
					<div class="col-5" >
						<input class="form-control" type="text" value="{{$tahun}}"   name="tahun" size="4" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete='off' required> 
					</div>
					<div class="col-2" >
						<input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" size="15" maxlength="15" autocomplete='off'>
					</div>
				</div>
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Kurs<span style="color:red;">*</span></label>
					<div class="col-10">
						<input class="form-control" type="text" name="kurs" value="{{$kurs}}" size="15" maxlength="15" autocomplete='off' onkeypress="return hanyaAngka(event)" required oninvalid="this.setCustomValidity('Kurs Harus Diisi..')" oninput="setCustomValidity('')">				
					</div>
				</div>
				{{-- <div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Lapangan</label>
					<div class="col-10">
						<select name="lapangan" id="select-debetdari" class="form-control select2">
							<option value="">- All -</option>
							@foreach($data_lapang as $data_l)
							<option value="{{$data_l->kodelokasi}}">{{$data_l->kodelokasi}} -- {{$data_l->nama}}</option>
							@endforeach
						</select>								
					</div>
				</div> --}}
				<div class="kt-form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a  href="{{route('tabel_deposito.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-brand"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
							{{--<a  href="{{url('perbendaharaan/tabel_deposito/rekap_rc')}}/{{$no}}/{{$id}}" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak RC</a>--}}
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
	
	$('#tanggal').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		// language : 'id',
		format   : 'dd MM yyyy'
	});
});
		function hanyaAngka(evt) {
			  var charCode = (evt.which) ? evt.which : event.keyCode
			   if (charCode > 31 && (charCode < 48 || charCode > 57))
	 
				return false;
			  return true;
			}
</script>
@endsection