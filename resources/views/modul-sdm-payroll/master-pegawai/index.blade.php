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
                Tabel Master Pegawai
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.perjalanan_dinas.create') }}">
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
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">Nopeg</label>
					<div class="col-2">
						<input class="form-control" type="text" name="nopeg" id="nopeg">
					</div>
	
					<label for="" class="col-form-label">Status</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="status" id="status">
							<option value=""> - Pilih Status- </option>
							<option value="C">Aktif</option>
							<option value="P">Pensiun</option>									
							<option value="K">Kontrak</option>
							<option value="B">Perbantuan</option>
							<option value="D">Direksi</option>
							<option value="N">Pekerja Baru</option>
							<option value="U">Komisaris</option>
							<option value="O">Komite</option>
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
                            <th>NOPEG</th>
                            <th>NAMA</th>
                            <th>STATUS</th>
                            <th>KODE & NAMA BAGIAN</th>
                            <th>KODE & NAMA JABATAN</th>
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
			ajax      : {
				url: "{{ route('modul_sdm_payroll.master_pegawai.index.json') }}",
				data: function (d) {
					d.nopeg = $('input[name=nopeg]').val();
					d.status = $('select[name=status]').val();
				}
			},
			columns: [
				{data: 'action', name: 'aksi', class:'radio-button', width: '10'},
				{data: 'nopeg', name: 'nopeg', class:'no-wrap'},
				{data: 'nama', name: 'nama', class:'no-wrap'},
				{data: 'status', name: 'status', class:'no-wrap'},
				{data: 'bagian', name: 'bagian', class:'no-wrap'},
				{data: 'jabatan', name: 'jabatan', class:'no-wrap'}
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
					var url = '{{ route("modul_sdm_payroll.master_pegawai.edit", ":kode") }}';
					// go to page edit
					window.location.href = url.replace(':kode',id);
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
						text: "Nomor Pegawai : " + id,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_sdm_payroll.master_pegawai.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : 'Hapus Nomor Pegawai: ' + id,
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
	});
</script>
@endpush
