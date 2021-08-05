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
                Tabel Penempatan Deposito
            </h3>
            <div class="text-right">
                @if($data_akses->tambah == 1)
                <a href="{{ route('penempatan_deposito.create') }}" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->rubah == 1 or $data_akses->lihat == 1)
                <button id="editRow" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
                        <i class="fas fa-2x fa-edit text-warning"></i>
                    </span>
                </button>
                @endif
                @if($data_akses->hapus == 1)
                <button id="deleteRow" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </button>
                @endif

                @if($data_akses->tambah == 1)
                <button id="dolarRow" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Perpanjang Deposito">
                        <i class="fas fa-2x fa-dollar-sign text-primary"></i>
                    </span>
                </button>
                @endif

                @if($data_akses->cetak == 1)
                <button id="exportRow" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Cetak Data">
                        <i class="fas fa-2x fa-print text-info"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="form" id="search-form" >
            <div class="form-group row">
                <label for="" class="col-1 col-form-label">Bulan</label>
                <div class="col-2">
                    <select name="bulan" class="form-control select2" style="width: 100% !important;">
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
					<th>NOMINAL</th>
					<th>TGL.DEPOSITO</th>
					<th>TGL.JTH TEMPO</th>
					<th>HARI BUNGA</th>
					<th>RATE</th>
					<th>BUNGA %/THN</th>
					<th>BUNGA/BULAN</th>
					<th>PPH 20%/BLN</th>
					<th>NET/BULAN</th>
					<th>ACCRUE HARI</th>
					<th>ACCRUED NOMINAL</th>
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
			pageLength: 100,
			scrollY:        "500px",
			scrollCollapse: true,
			ajax: {
				url: "{{ route('penempatan_deposito.index.json') }}",
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
//edit penempatan deposito
$('#editRow').click(function(e) {
	e.preventDefault();
	if($('input[type=radio]').is(':checked')) { 
		$("input[type=radio]:checked").each(function(){
			var nodok = $(this).attr('nodok').split("/").join("-");
			var lineno = $(this).attr('lineno');
			var pjg = $(this).attr('pjg');
			location.href = "{{ url('perbendaharaan/penempatan-deposito/edit') }}" + '/' + nodok +'/' + lineno + '/' + pjg;
		});
	} else {
		swalAlertInit('ubah');
	}
});
//exportRow penempatan deposito
$('#exportRow').on('click', function(e) {
	e.preventDefault();
	if($('input[class=btn-radio]').is(':checked')) { 
		$("input[class=btn-radio]:checked").each(function() {  
			e.preventDefault();
			var no = $(this).attr('nodok').split("/").join("-");
			var id = $(this).attr('lineno');
				location.href = "{{ url('perbendaharaan/penempatan-deposito/rekaprc') }}" + '/' + no + '/' + id;
		});
	} else{
		swalAlertInit('cetak');
	}
	
});
//perpanjang deposito
$('#dolarRow').click(function(e) {
	e.preventDefault();
	if($('input[type=radio]').is(':checked')) { 
		$("input[type=radio]:checked").each(function(){
			var nodok = $(this).attr('nodok').split("/").join("-");
			var lineno = $(this).attr('lineno');
			var pjg = $(this).attr('pjg');
			location.href = "{{ url('perbendaharaan/penempatan-deposito/depopjg') }}" + '/' + nodok + '/' + lineno + '/' + pjg;
		});
	} else {
		swalAlertInit('perpanjangan deposito');
	}
});
//refresh data
$('#show-data').on('click', function(e) {
	e.preventDefault();
    location.href = "{{ route('penempatan_deposito.index') }}";
});
//delete penempatan deposito
$('#deleteRow').click(function(e) {
	e.preventDefault();
	if($('input[type=radio]').is(':checked')) { 
		$("input[type=radio]:checked").each(function() {
			var nodok = $(this).attr('nodok').split("/").join("-");
			var lineno = $(this).attr('lineno');
			var pjg = $(this).attr('pjg');
			// delete stuff
			const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-primary',
					cancelButton: 'btn btn-danger'
				},
					buttonsStyling: false
				})
				swalWithBootstrapButtons.fire({
					title: "Data yang akan dihapus?",
					text: "Detail data No. dokumen : "+nodok+ ' nomer lineno : '  +lineno,
					icon: 'warning',
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Ya, hapus',
					cancelButtonText: 'Batalkan'
				})
				.then((result) => {
				if (result.value) {
					$.ajax({
						url: "{{ route('penempatan_deposito.delete') }}",
						type: 'DELETE',
						dataType: 'json',
						data: {
							"nodok": nodok,
							"lineno": lineno,
							"pjg": pjg,
							"_token": "{{ csrf_token() }}",
						},
						success: function () {
							Swal.fire({
								type  : 'success',
								title : "Detail data No. dokumen : "+ nodok + ' nomer lineno : '  +lineno,
								text  : 'Berhasil',
								timer : 2000
							}).then(function() {
								location.reload();
							});
						},
						error: function () {
							alert("Terjadi kesalahan, coba lagi nanti");
						}
					});
				}
			});
		});
	} else {
		swalAlertInit('hapus');
	}
	
});
});
</script>
@endpush