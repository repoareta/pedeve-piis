@extends('layout.global')

@section('content')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
	<div class="kt-container  kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">
				Tabel Deposito </h3>
			<span class="kt-subheader__separator kt-hidden"></span>
			<div class="kt-subheader__breadcrumbs">
				<a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<a href="" class="kt-subheader__breadcrumbs-link">
					Kontroler </a>
				<span class="kt-subheader__breadcrumbs-separator"></span>
				<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Tabel Deposito</span>
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
				Tabel Deposito
			</h3>			
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<div class="kt-portlet__head-actions">
						<span style="font-size: 2em;" class="kt-font-info pointer-link" data-toggle="kt-tooltip" data-placement="top" title="Cetak Data">
							<i class="fas fa-print" id="exportRow"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="">
			<form class="kt-form" id="search-form" >
				<div class="form-group row col-12">
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select name="bulan" class="form-control selectpicker" data-live-search="true">
							<option value="" >-- Pilih --</option>
							<option value="01" <?php if($bulan  == '01' ) echo 'selected' ; ?>>Januari</option>
							<option value="02" <?php if($bulan  == '02' ) echo 'selected' ; ?>>Februari</option>
							<option value="03" <?php if($bulan  == '03' ) echo 'selected' ; ?>>Maret</option>
							<option value="04" <?php if($bulan  == '04' ) echo 'selected' ; ?>>April</option>
							<option value="05" <?php if($bulan  == '05' ) echo 'selected' ; ?>>Mei</option>
							<option value="06" <?php if($bulan  == '06' ) echo 'selected' ; ?>>Juni</option>
							<option value="07" <?php if($bulan  == '07' ) echo 'selected' ; ?>>Juli</option>
							<option value="08" <?php if($bulan  == '08' ) echo 'selected' ; ?>>Agustus</option>
							<option value="09" <?php if($bulan  == '09' ) echo 'selected' ; ?>>September</option>
							<option value="10" <?php if($bulan  == '10' ) echo 'selected' ; ?>>Oktober</option>
							<option value="11" <?php if($bulan  == '11' ) echo 'selected' ; ?>>November</option>
							<option value="12" <?php if($bulan  == '12' ) echo 'selected' ; ?>>Desember</option>
						</select>
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<input class="form-control" type="text" name="tahun" value="{{$tahun}}" size="4" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete='off'>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-brand"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>
		<!--begin: Datatable -->
		<table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>NO.SERI</th>
					<th>NAMA BANK</th>
					<th>ASAL DANA</th>
					<th>NOMINAL</th>
					<th>TGL.DEPOSITO</th>
					<th>TGL.JTH TEMPO</th>
					<th>HARI BUNGA</th>
					<th>BUNGA %/THN</th>
					<th>BUNGA/BULAN</th>
					<th>PPH 20%/BLN</th>
					<th>NET/BULAN</th>
					<th>ACCRUE HARI</th>
					<th>ACCRUE NOMINAL</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

		<!--end: Datatable -->
	</div>
</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
		var t = $('#kt_table').DataTable({
				scrollX   : true,
				processing: true,
				serverSide: true,
				searching: false,
				lengthChange: false,
				pageLength: 200,
				scrollY:        "500px",
				scrollCollapse: true,
				language: {
				processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
				},
				ajax      : {
					url: "{{route('tabel_deposito.index.json')}}",
					type : "POST",
					dataType : "JSON",
					headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
					},
					data: function (d) {
						d.bulan = $('select[name=bulan]').val();
						d.tahun = $('input[name=tahun]').val();
					}
				},
				columns: [
					{data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
					{data: 'noseri', name: 'noseri'},
					{data: 'namabank', name: 'namabank'},
					{data: 'nominal', name: 'nominal'},
					{data: 'tgldep', name: 'tgldep'},
					{data: 'tgltempo', name: 'tgltempo'},
					{data: 'haribunga', name: 'haribunga'},
					{data: 'rate', name: 'rate'},
					{data: 'bungatahun', name: 'bungatahun'},
					{data: 'bungabulan', name: 'bungabulan'},
					{data: 'pph20', name: 'pph20'},
					{data: 'netbulan', name: 'netbulan'},
					{data: 'accharibunga', name: 'accharibunga'},
					{data: 'accnetbulan', name: 'accnetbulan'},
				],
				columnDefs: [
							{"className": "dt-center", "targets": "_all"}
						],
				createdRow: function( row, data, dataIndex ) {
					if(data["warna"] == 1){
						$( row ).css( "background-color", "#FF0000" );
						$('td', row ).css( "color", "#FFFEFE" );
					}else if(data["warna"] == 2){
						$( row ).css( "background-color", "#666666" );
						$('td', row ).css( "color", "#FFFEFE" );
					}else{
						$( row ).css( "background-color", "#000000" );
						$('td', row ).css( "color", "#FFFEFE" );
					}
				},
				
		});
		$('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});
		
		//exportRow penempatan deposito
		$('#exportRow').on('click', function(e) {
			e.preventDefault();

			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function() {  
					e.preventDefault();
					var no = $(this).attr('nodok').split("/").join("-");
					var id = $(this).attr('lineno');
						location.replace("{{url('kontroler/tabel_deposito/rekap')}}"+ '/' +no+'/'+id);
				});
			} else{
				swalAlertInit('cetak');
			}
			
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