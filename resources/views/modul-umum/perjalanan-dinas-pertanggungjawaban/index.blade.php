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
                Tabel Umum Pertanggungjawaban Panjar Dinas
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas icon-2x fa-plus-circle text-success"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas icon-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
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
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">NO. PPANJAR</label>
					<div class="col-4">
						<input class="form-control" type="text" name="noppanjar" id="noppanjar">
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
                            <th>NO. PJ PANJAR</th>
                            <th>NO. PANJAR</th>
                            <th>TANGGAL</th>
                            <th>NOPEK</th>
                            <th>KETERANGAN</th>
                            <th>JUMLAH</th>
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
				url: "{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.index.json') }}",
				data: function (d) {
					d.noppanjar = $('input[name=noppanjar]').val();
				}
			},
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no_ppanjar', name: 'no_ppanjar', class:'no-wrap'},
				{data: 'no_panjar', name: 'no_panjar', class:'no-wrap'},
				{data: 'tgl_ppanjar', name: 'tgl_ppanjar', class:'no-wrap'},
				{data: 'nopek', name: 'nopek', class:'no-wrap'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'jmlpanjar', name: 'jmlpanjar', class:'no-wrap text-right'},
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
					var url = '{{ route("modul_umum.perjalanan_dinas.pertanggungjawaban.edit", ":no_ppanjar") }}';
					// go to page edit
					window.location.href = url.replace(':no_ppanjar', id);
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
						text: "No. PJ Panjar : " + id,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.delete') }}",
								type: 'DELETE',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Hapus Detail PJ Panjar ' + id,
										text  : 'Success',
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
						text: "No. PPanjar : " + id,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Cetak',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							var id = $(this).val().split("/").join("-");
					        var url = '{{ route("modul_umum.perjalanan_dinas.pertanggungjawaban.export", ":no_ppanjar") }}';

                            window.location.href = url.replace(':no_ppanjar', id);

							// var url = "{{ url('umum/perjalanan-dinas/pertanggungjawaban/export') }}" + '/' + id;
							// window.open(url, '_blank');
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
