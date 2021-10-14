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
                Tabel Umum Pertanggungjawaban UMK
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.create') }}">
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
			<form class="form" id="search-form">
				<div class="form-group row">
					<label for="" class="col-form-label">No. PUMK</label>
					<div class="col-2">
						<input class="form-control" type="text" name="permintaan" value="" size="18" maxlength="18">
					</div>
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select name="bulan" class="form-control select2" id="bulan">
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
                        <select class="form-control select2" name="tahun" id="tahun">
                            <option value="">- Pilih Tahun -</option>
                            @foreach ($tahun as $row)
                                <option value="{{ $row->year }}">{{ $row->year }}</option>
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
                            <th>No. PUMK</th>
                            <th>No. UMK</th>
                            <th>No. KAS/BANK</th>
                            <th>PEGAWAI</th>
                            <th>KETERANGAN</th>
                            <th>NILAI (REALISASI)</th>
                            <th>APPROVAL</th>
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
			searching : false,
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.index.json') }}",
				data: function (d) {
					d.no_pumk = $('input[name=no_pumk]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('select[name=tahun]').val();
				}
			},
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no_pumk', name: 'no_pumk'},
				{data: 'no_umk', name: 'no_umk'},
				{data: 'no_kas', name: 'no_kas'},
				{data: 'nama', name: 'nama'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'nilai', name: 'nilai', class:'text-right'},
				{data: 'approval', name: 'approval', class:'text-center'}
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
					// go to page edit
					url = "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.edit', [
						'no_pumk' => ':no_pumk'
					]) }}";

					window.location.href = url.replace(':no_pumk', id);
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
						text: "No. P UMK : " + id,
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Hapus P UMK ' + id,
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
						text: "No. PUMK : " + id,
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
                            var url = "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.export', ['no_pumk' => ':no_pumk']) }}";

							window.open(url.replace(':no_pumk', id), '_blank');
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
