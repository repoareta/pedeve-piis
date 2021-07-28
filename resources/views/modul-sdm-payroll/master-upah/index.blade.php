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
                Tabel Master Upah
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.perjalanan_dinas.create') }}">
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
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="kt-form" id="search-form" >
				<div class="form-group row">
					<label for="" class="col-form-label">Pegawai</label>
					<div class="col-4">
						<select name="no_pekerja" class="form-control select2" id="no_pekerja">
						<option value="">- Pilih -</option>
							@foreach($pegawai_list as $pegawai)
							    <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg }} - {{ $pegawai->nama }}</option>
							@endforeach
						</select>
					</div>
                    <label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select class="form-control select2" name="bulan" id="bulan">
							<option value="">- Pilih Bulan -</option>
							<option value="1">Januari</option>
							<option value="2">Februari</option>
							<option value="3">Maret</option>
							<option value="4">April</option>
							<option value="5">Mei</option>
							<option value="6">Juni</option>
							<option value="7">Juli</option>
							<option value="8">Agustus</option>
							<option value="9">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
						</select>
					</div>
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<select name="tahun" class="form-control select2" id="tahun">
                        <option value="">- Pilih -</option>
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
                            <th>BULAN</th>
                            <th>PEGAWAI</th>
                            <th>AARD</th>
                            <th>CICILAN KE</th>
                            <th>JUMLAH CICILAN</th>
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

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax      : {
				url: "{{ route('modul_sdm_payroll.master_upah.index.json') }}",
				data: function (d) {
					d.no_pekerja = $('select[name=no_pekerja]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('select[name=tahun]').val();
				}
			},
			columns: [
				{data: 'action', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
				{data: 'bulan_tahun', name: 'bulan_tahun', class:'no-wrap'},
				{data: 'pekerja', name: 'pekerja'},
				{data: 'aard', name: 'aard'},
				{data: 'ccl', name: 'ccl', class:'text-right'},
				{data: 'jmlcc', name: 'jmlcc', class:'no-wrap text-right'},
				{data: 'nilai', name: 'nilai', class:'no-wrap text-right'}
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
					var tahun = $(this).val().split("-")[0];
					var bulan = $(this).val().split("-")[1];
					var nopek = $(this).val().split("-")[2];
					var aard = $(this).val().split("-")[3];

					var url = '{{ route("modul_sdm_payroll.master_upah.edit", [":tahun", ":bulan", ":nopek", ":aard"]) }}';
					// go to page edit
					window.location.href = url
					.replace(':tahun', tahun)
					.replace(':bulan', bulan)
					.replace(':nopek', nopek)
					.replace(':aard', aard);
				});
			} else {
				swalAlertInit('ubah');
			}
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var tahun = $(this).val().split("-")[0];
					var bulan = $(this).val().split("-")[1];
					var nopek = $(this).val().split("-")[2];
					var aard = $(this).val().split("-")[3];
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
						text: nopek + " " + aard,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_sdm_payroll.master_upah.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"tahun": tahun,
									"bulan": bulan,
									"nopek": nopek,
									"aard": aard,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : 'Hapus Upah Master ' + nopek + " " + aard,
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
