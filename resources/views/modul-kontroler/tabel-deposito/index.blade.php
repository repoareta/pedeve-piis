@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Deposito
            </h3>
        </div>
		<div class="card-toolbar">
			<div class="float-left">
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
						<i class="fas fa-2x fa-print text-info" id="exportRow"></i>
					</span>
				</a>
            </div>
		</div>
	</div>

	<div class="card-body">
		<form class="form" id="search-form">
			<div class="form-group row">
				<label for="" class="col-1 col-form-label">Bulan</label>
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
	</div>
</div>
@endsection

@push('page-scripts')
<script type="text/javascript">
$(document).ready(function () {
	var t = $('#kt_table').DataTable({
		scrollX   : true,
		processing: true,
		serverSide: true,
		scrollY: "500px",
		scrollCollapse: true,
		ajax: {
			url: "{{ route('modul_kontroler.tabel_deposito.index.json') }}",
			data: function (d) {
				d.bulan = $('select[name=bulan]').val();
				d.tahun = $('input[name=tahun]').val();
			}
		},
		columns: [
			{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
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
				location.href = "{{ url('kontroler/tabel-deposito/rekap') }}"+ '/' +no+'/'+id;
			});
		} else{
			swalAlertInit('cetak');
		}
	});
});

</script>
@endpush