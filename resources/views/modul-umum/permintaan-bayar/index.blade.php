@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Umum Permintaan Bayar
            </h3>
        </div>

        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.permintaan_bayar.create') }}">
					<span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas icon-2x fa-plus-circle text-success"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas icon-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas icon-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
						<i class="fas icon-2x fa-print text-info" id="exportRow"></i>
					</span>                    
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
			<form class="kt-form" id="search-form" >
				<div class="form-group row">
					<label for="" class="col-form-label">No. Permintaan</label>
					<div class="col-2">
						<input class="form-control" type="text" name="permintaan" value="" size="18" maxlength="18">
					</div>
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
					<th>NO. PERMINTAAN</th>
					<th>NO. KAS/BANK</th>
					<th>KEPADA</th>
					<th>KETERANGAN</th>
					<th>LAMPIRAN</th>
					<th>NILAI</th>
					<th>APPROVAL</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<!--end: Datatable -->
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
		searching: false,
		lengthChange: false,
		pageLength: 200,
		language: {
			processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
		},
		ajax: {
			url: "{{ route('modul_umum.permintaan_bayar.index.json') }}",
			data: function (d) {
				d.permintaan = $('input[name=permintaan]').val();
				d.bulan = $('select[name=bulan]').val();
				d.tahun = $('input[name=tahun]').val();
			}
		},
		columns: [
			{data: 'radio', name: 'aksi', orderable: false, searchable: false},
			{data: 'no_bayar', name: 'no_bayar'},
			{data: 'no_kas', name: 'no_kas'},
			{data: 'kepada', name: 'kepada'},
			{data: 'keterangan', name: 'keterangan'},
			{data: 'lampiran', name: 'lampiran'},
			{data: 'nilai', name: 'nilai', class: 'text-right'},
			{data: 'action', name: 'action', class: 'text-center'}
		]
			
		
	});

	$('#search-form').on('submit', function(e) {
		t.draw();
		e.preventDefault();
	});
	
	//report permintaan bayar
	$('#reportRow').on('click', function(e) {
		e.preventDefault();

		if($('input[class=btn-radio]').is(':checked')) { 
			$("input[class=btn-radio]:checked").each(function() {  
				e.preventDefault();
				var dataid = $(this).attr('data-id');
					location.replace("{{url('umum/permintaan-bayar/rekap')}}"+ '/' +dataid);
			});
		} else{
			swalAlertInit('cetak');
		}
		
	});

	//edit permintaan bayar
	$('#editRow').click(function(e) {
		e.preventDefault();

		if($('input[class=btn-radio]').is(':checked')) { 
			$("input[class=btn-radio]:checked").each(function(){
				var id = $(this).attr('data-id');
				location.replace("{{url('umum/permintaan-bayar/edit')}}"+ '/' +id);
			});
		} else {
			swalAlertInit('ubah');
		}
	});

	//delete permintaan bayar
	$('#deleteRow').click(function(e) {
		e.preventDefault();
		if($('input[class=btn-radio]').is(':checked')) { 
			$("input[class=btn-radio]:checked").each(function() {
				var id = $(this).attr('data-id');
				var status = $(this).attr('data-s');
				// delete stuff
				if(status == 'Y'){
					Swal.fire({
								type  : 'info',
								title : 'Data Tidak Bisa Dihapus, Data Sudah di Proses Perbendaharaan.',
								text  : 'Failed',
							});
				}else{
					const swalWithBootstrapButtons = Swal.mixin({
						customClass: {
							confirmButton: 'btn btn-primary',
							cancelButton: 'btn btn-danger'
						},
							buttonsStyling: false
						})
						swalWithBootstrapButtons.fire({
							title: "Data yang akan dihapus?",
							text: "No. bayar : " + id,
							type: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.permintaan_bayar.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : 'Hapus No. Bayar ' + id,
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
				}
			});
		} else {
			swalAlertInit('hapus');
		}
		
	});
});
</script>
@endpush
