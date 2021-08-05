@extends('layout.global')

@section('content')
<!-- begin:: Subheader -->
<div class="subheader   grid__item" id="kt_subheader">
	<div class="container  container--fluid ">
		<div class="subheader__main">
			<h3 class="subheader__title">
				Tabel Deposito </h3>
			<span class="subheader__separator hidden"></span>
			<div class="subheader__breadcrumbs">
				<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
				<span class="subheader__breadcrumbs-separator"></span>
				<a href="" class="subheader__breadcrumbs-link">
					Kontroler </a>
				<span class="subheader__breadcrumbs-separator"></span>
				<span class="subheader__breadcrumbs-link subheader__breadcrumbs-link--active">Tabel Deposito</span>
			</div>
		</div>
	</div>
</div>
<!-- end:: Subheader -->

<div class="container  container--fluid  grid__item grid__item--fluid">
<div class="portlet portlet--mobile">
	<div class="portlet__head portlet__head--lg">
		<div class="portlet__head-label">
			<span class="portlet__head-icon">
				<i class="font-brand flaticon2-line-chart"></i>
			</span>
			<h3 class="portlet__head-title">
				Tabel Deposito
			</h3>			
			<div class="portlet__head-toolbar">
				<div class="portlet__head-wrapper">
					<div class="portlet__head-actions">
						<span class="font-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
							<i class="fas fa-print" id="exportRow"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="portlet__body">
		<div class="">
			<form class="form" id="search-form" >
				<div class="form-group row">
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select name="bulan" class="form-control select2">
							<option value="">- Pilih -</option>
							<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
							<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
							<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
							<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
							<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
							<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
							<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
							<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
							<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
							<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
							<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
							<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
						</select>
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>
		<!--begin: Datatable -->
		<table class="table table-bordered" id="kt_table" width="100%">
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
				scrollY:        "500px",
				scrollCollapse: true,
				ajax      : {
					url: "{{route('tabel_deposito.index.json') }}",
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
					{data: 'radio', name: 'aksi', class:'radio-button text-center'},
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
					} else {
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
						location.replace("{{url('kontroler/tabel_deposito/rekap') }}"+ '/' +no+'/'+id);
				});
			} else{
				swalAlertInit('cetak');
			}
			
		});
});

</script>
@endsection