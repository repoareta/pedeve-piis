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
                Tabel Umum Anggaran
            </h3>
        </div>
        <div class="card-toolbar">
			<div class="float-left">
                <a href="{{ route('modul_umum.perjalanan_dinas.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
						<i class="fas fa-2x fa-print text-info" id="exportRow"></i>
					</span>                    
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">Kode Anggaran</label>
					<div class="col-2">
						<input class="form-control" type="text" name="kode_anggaran" id="kode_anggaran">
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="tahun" id="tahun">
							<option value="">- Pilih Tahun -</option>
							@foreach ($tahun as $key => $row)
								<option value="{{ $row->tahun }}"
									@if($key == 0)
										selected
									@endif
								>{{ $row->tahun }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
							<th></th>
							<th>Kode</th>
							<th>Nama Master</th>
							<th>Tahun</th>
							<th>Nilai</th>
							<th>Realisasi</th>
							<th>Sisa</th>
						</tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
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
		ajax: {
			url: "{{ route('modul_umum.anggaran.index.json') }}",
			data: function (d) {
				d.kode_anggaran = $('input[name=kode_anggaran]').val();
				d.tahun = $('select[name=tahun]').val();
			}
		},
		columns: [
			{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
			{data: 'kode_main', name: 'kode_main', class:'no-wrap'},
			{data: 'nama_main', name: 'nama_main'},
			{data: 'tahun', name: 'tahun'},
			{data: 'nilai_real', name: 'nilai_real', class: 'no-wrap text-right'},
			{data: 'realisasi', name: 'realisasi', class:'no-wrap text-right'},
			{data: 'sisa', name: 'sisa', class:'no-wrap text-right'}
		]
	});

	$('#search-form').on('submit', function(e) {
		t.draw();
		e.preventDefault();
	});

	$('#editRow').click(function(e) {
		e.preventDefault();
		if($('input[type=radio]').is(':checked')) { 
			$("input[type=radio]:checked").each(function() {
				var id = $(this).val().split("/").join("-");
				var url = '{{ route("modul_umum.anggaran.edit", ":kode_main") }}';
				// go to page edit
				window.location.href = url.replace(':kode_main',id);
			});
		} else {
			swalAlertInit('ubah');
		}
	});

	$('#deleteRow').click(function(e) {
		e.preventDefault();
		if($('input[type=radio]').is(':checked')) { 
			$("input[type=radio]:checked").each(function() {
				var id = $(this).val();
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
					text: "Kode : " + id,
					icon: 'warning',
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Ya, hapus',
					cancelButtonText: 'Batalkan'
				})
				.then((result) => {
					if (result.value) {
						$.ajax({
							url: "{{ route('modul_umum.anggaran.delete') }}",
							type: 'DELETE',
							dataType: 'json',
							data: {
								"id": id,
								"_token": "{{ csrf_token() }}",
							},
							success: function () {
								Swal.fire({
									icon  : 'success',
									title : 'Hapus Anggaran ' + id,
									text  : 'Berhasil',
									timer : 2000
								}).then(function() {
									t.ajax.reload();
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

	$('#exportRow').click(function(e) {
		e.preventDefault();
		if($('input[type=radio]').is(':checked')) { 
			$("input[type=radio]:checked").each(function() {
				var id = $(this).val();
				
				const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-primary',
					cancelButton: 'btn btn-danger'
				},
					buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
					title: "Data yang akan dicetak?",
					text: "No. Panjar : " + id,
					icon: 'warning',
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Cetak',
					cancelButtonText: 'Batalkan'
				})
				.then((result) => {
					if (result.value) {
						var id = $(this).val().split("/").join("-");
						// go to page edit
						var url = "{{ url('umum/perjalanan_dinas/export') }}" + '/' + id;
						window.open(url, '_blank');
					}
				});
			});
		} else {
			swalAlertInit('cetak');
		}
	});

});
</script>
@endpush
