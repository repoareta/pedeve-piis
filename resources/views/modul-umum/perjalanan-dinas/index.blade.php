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
                Tabel Umum Panjar Dinas
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(703)->tambah == 1)
                <a href="{{ route('modul_umum.perjalanan_dinas.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                @endif
                @if (permission(703)->rubah == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
                @endif
                @if (permission(703)->hapus == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
                @endif
                @if (permission(703)->cetak == 1)
				<a href="#">
					<span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
						<i class="fas fa-2x fa-print text-info" id="exportRow"></i>
					</span>
				</a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">NO. PANJAR</label>
					<div class="col-4">
						<input class="form-control" type="text" name="nopanjar" id="nopanjar">
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
                            <th>NO. PANJAR</th>
                            <th>JENIS</th>
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>DARI</th>
                            <th>TUJUAN</th>
                            <th>NOPEK</th>
                            <th>KETERANGAN</th>
                            <th>NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cetak Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form" action="{{ route('modul_umum.perjalanan_dinas.export') }}" method="GET" id="formCetakData" target="_blank">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nomor Panjar</label>
						<div class="col-10">
							<input class="form-control" type="text" readonly name="no_panjar_dinas" id="no_panjar_dinas">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Atasan Ybs</label>
						<div class="col-10">
							<input class="form-control" type="text" name="atasan_ybs" id="atasan_ybs">
						</div>
					</div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Menyetujui</label>
						<div class="col-10">
							<input class="form-control" type="text" name="menyetujui" id="menyetujui">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">CS & BS</label>
						<div class="col-10">
							<input class="form-control" type="text" name="sekr_perseroan" id="sekr_perseroan">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Finance</label>
						<div class="col-10">
							<input class="form-control" type="text" name="keuangan" id="keuangan">
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i> Batal</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Cetak Data</button>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- MODAL END --}}

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('modul_umum.perjalanan_dinas.index.json') }}",
				data: function (d) {
					d.nopanjar = $('input[name=nopanjar]').val();
				}
			},
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no_panjar', name: 'no_panjar', class:'no-wrap'},
				{data: 'jenis_dinas', name: 'jenis'},
				{data: 'mulai', name: 'mulai', class:'no-wrap'},
				{data: 'sampai', name: 'sampai', class:'no-wrap'},
				{data: 'dari', name: 'dari', class:'no-wrap'},
				{data: 'tujuan', name: 'tujuan', class:'no-wrap'},
				{data: 'nopek', name: 'nopek', class:'no-wrap'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'nilai', name: 'nilai', class:'text-right no-wrap'}
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
					var data_ppanjar = $(this).data('ppanjar');
					if (data_ppanjar === true) {
						Swal.fire({
							icon: 'warning',
							timer: 2000,
							title: 'Oops...',
							text: 'Data tidak bisa diubah'
						});
					} else {
						var id = $(this).val().split("/").join("-");
						var url = '{{ route("modul_umum.perjalanan_dinas.edit", ":no_panjar") }}';
						// go to page edit
						window.location.href = url.replace(':no_panjar',id);
					}
				});
			} else {
				swalAlertInit('ubah');
			}
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var data_ppanjar = $(this).data('ppanjar');
					if (data_ppanjar === true) {
						Swal.fire({
							icon: 'warning',
							timer: 2000,
							title: 'Oops...',
							text: 'Data tidak bisa dihapus'
						});
					} else {
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
							text: "No. Panjar : " + id,
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
							if (result.value) {
								$.ajax({
									url: "{{ route('modul_umum.perjalanan_dinas.delete') }}",
									type: 'DELETE',
									dataType: 'json',
									data: {
										"id": id,
										"_token": "{{ csrf_token() }}",
									},
									success: function () {
										Swal.fire({
											icon  : 'success',
											text : 'Hapus No. Panjar: ' + id,
											title  : 'Berhasil',
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
					}
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
					// open modal
					$('#cetakModal').modal('show');
					// fill no_panjar to no_panjar field
					$('#no_panjar_dinas').val(id);
				});
			} else {
				swalAlertInit('cetak');
			}
		});

		$('#cetakModal').on('hidden.bs.modal', function (e) {
			$(this).find('form').trigger('reset');
		})
	});
	</script>
@endpush
