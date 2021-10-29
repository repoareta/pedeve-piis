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
                Tabel RKAP & Realisasi
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(803)->tambah == 1)
                <a href="{{ route('modul_cm.rkap_realisasi.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                @endif
                @if (permission(803)->rubah == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
                @endif
                @if (permission(803)->hapus == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
                @endif

                {{-- <a href="{{ route('modul_cm.rkap_realisasi.create') }}">
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
				</a> --}}
            </div>
        </div>
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" id="search-form">
				<div class="form-group row">
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<select name="tahun" class="form-control select2" style="width: 100% !important;" id="tahun">
                            @foreach ($rkapRealisasiTahunList as $tahun)
                                <option value="{{ $tahun->tahun }}">{{ $tahun->tahun }}</option>
                            @endforeach
                        </select>
					</div>
					<div class="col-4">
						<select name="perusahaan" class="form-control select2" style="width: 100% !important;" id="perusahaan">
							<option value="">- Semua Perusahaan -</option>
                            @foreach ($perusahaanList as $perusahaan)
                                <option value="{{ $perusahaan->id }}" data-nama="{{ $perusahaan->nama }}">{{ $perusahaan->nama }}</option>
                            @endforeach
                        </select>
					</div>
					<div class="col-4">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
						<button type="button" class="btn btn-danger" id="cetak"><i class="fa fa-file-pdf"></i> Cetak .PDF</button>
						<button type="button" class="btn btn-success" id="cetak-xlsx"><i class="fa fa-file-excel"></i> Cetak .XLSX</button>
					</div>
				</div>
			</form>
		</div>

        <div class="row">
            <div class="col-xl-12">
                <table id="kt_table" class="table table-bordered" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2" class="text-center">Perusahaan</th>
                            <th rowspan="2">TAHUN</th>
                            <th rowspan="2">BULAN</th>
                            <th rowspan="2">CI</th>
                            <th colspan="12" class="text-center">RKAP & REALISASI</th>
                        </tr>
                        <tr>
                            <th class="no-wrap">Aset</th>
                            <th class="no-wrap">Pendapatan Usaha</th>
                            <th class="no-wrap">Beban Usaha</th>
                            <th class="no-wrap">Laba Kotor</th>
                            <th class="no-wrap">Pendapatan/Beban Lain</th>
                            <th class="no-wrap">Laba Operasi</th>
                            <th class="no-wrap">Laba Bersih</th>
                            <th class="no-wrap">EBITDA</th>
                            <th class="no-wrap">Investasi BD</th>
                            <th class="no-wrap">Investasi NBD</th>
                            <th class="no-wrap">TKP</th>
                            <th class="no-wrap">KPI</th>
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
    $(document).ready(function(){
        var t =$('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            pageLength: 100,
            rowsGroup: [1],
            ajax: {
                url: "{{ route('modul_cm.rkap_realisasi.index.json') }}",
                data: function (d) {
                    d.tahun = $('select[name=tahun]').val();
                    d.perusahaan = $('select[name=perusahaan]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class: 'text-center', width: '10'},
                {data: 'nama', name: 'nama'},
                {data: 'tahun', name: 'tahun'},
                {data: 'bulan', name: 'bulan'},
                {data: 'ci', name: 'ci'},
                {data: 'aset', name: 'aset', class: 'text-right'},
                {data: 'pendapatan_usaha', name: 'pendapatan_usaha', class: 'text-right'},
                {data: 'beban_usaha', name: 'beban_usaha', class: 'text-right'},
                {data: 'laba_kotor', name: 'laba_kotor', class: 'text-right'},
                {data: 'pendapatan_or_beban_lain', name: 'pendapatan_or_beban_lain', class: 'text-right'},
                {data: 'laba_operasi', name: 'laba_operasi', class: 'text-right'},
                {data: 'laba_bersih', name: 'laba_bersih', class: 'text-right'},
                {data: 'ebitda', name: 'ebitda', class: 'text-right'},
                {data: 'investasi_bd', name: 'investasi_bd', class: 'text-right'},
                {data: 'investasi_nbd', name: 'investasi_nbd', class: 'text-right'},
                {data: 'tkp', name: 'tkp', class: 'text-right'},
                {data: 'kpi', name: 'kpi', class: 'text-right'},
            ],
			"createdRow": function(row, data, dataIndex){
                if(data.bulan == null){
                    $(row).addClass('table-secondary');
					$('td', row).eq(1).css("background-color", "white");
                }
            }
        });

        $('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});

		$('#cetak').on('click', function(e) {
			e.preventDefault();
			// get tahun
			var tahun = $('#tahun').val();
			// perusahaan
			var perusahaan = $('#perusahaan').val();
			var perusahaan_nama = $('#perusahaan').find(':selected').data('nama');
			// akses url to generate pdf
			$.ajax({
				url: "{{ route('modul_cm.rkap_realisasi.export') }}",
				type: 'GET',
				xhrFields: {
					responseType: 'blob'
				},
				data: {
					"tahun": tahun,
					"perusahaan": perusahaan,
					"perusahaan_nama": perusahaan_nama,
					"_token": "{{ csrf_token() }}",
				},
				success: function (response) {
					var blob = new Blob([response], { type: 'application/pdf' });
					var link = document.createElement('a');
					link.href = window.URL.createObjectURL(blob);
					link.download = "{{ 'report_rkap_realisasi_'.date('Y-m-d_H:i:s').'.pdf' }}";
					link.click();
				},
				error: function () {
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});

		});

		$('#cetak-xlsx').on('click', function(e) {
			e.preventDefault();
			// get tahun
			var tahun = $('#tahun').val();
			// perusahaan
			var perusahaan = $('#perusahaan').val();
			var perusahaan_nama = $('#perusahaan').find(':selected').data('nama');
			// akses url to generate pdf
			$.ajax({
				url: "{{ route('modul_cm.rkap_realisasi.export.xlsx') }}",
				type: 'GET',
				xhrFields: {
					responseType: 'blob'
				},
				data: {
					"tahun": tahun,
					"perusahaan": perusahaan,
					"perusahaan_nama": perusahaan_nama,
					"_token": "{{ csrf_token() }}",
				},
				success: function (response) {
					var blob = new Blob([response], { type: 'application/xlsx' });
					var link = document.createElement('a');
					link.href = window.URL.createObjectURL(blob);
					link.download = "{{ 'report_rkap_realisasi_'.date('Y-m-d_H:i:s').'.xlsx' }}";
					link.click();
				},
				error: function () {
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});

		});

        $('#editRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var data_rkaprealisasi = $(this).data('id');
					if (data_rkaprealisasi === true) {
						Swal.fire({
							icon: 'warning',
							timer: 2000,
							title: 'Oops...',
							text: 'Data tidak bisa diubah'
						});
					} else {
						var url = '{{ route("modul_cm.rkap_realisasi.edit", ":kd_rencana_kerja") }}';
						// go to page edit
						window.location.href = url.replace(':kd_rencana_kerja', data_rkaprealisasi);
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
							text: "RKAP & Realisasi : " + id,
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
							if (result.value) {
								$.ajax({
									url: "{{ route('modul_cm.rkap_realisasi.delete') }}",
									type: 'DELETE',
									dataType: 'json',
									data: {
										"id": id,
										"_token": "{{ csrf_token() }}",
									},
									success: function () {
										Swal.fire({
											icon  : 'success',
											title : 'Hapus RKAP & Realisasi ' + id,
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
    });
</script>
@endpush
