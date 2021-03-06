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
                Tabel Riwayat Hutang
            </h3>
        </div>
        {{-- <div class="card-toolbar">
            <div class="float-left">
                @if (permission(625)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_hutang.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                @endif
                @if (permission(625)->rubah == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
                @endif
                @if (permission(625)->hapus == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
                @endif
            </div>
        </div> --}}
    </div>
    <div class="card-body">

		<div class="col-12">
			<form class="form" id="search-form">
				<div class="form-group row">
					<label for="" class="col-form-label">Pegawai</label>
					<div class="col-4">
						<select name="no_pekerja" class="form-control select2" style="width: 100% !important;" id="nopek">
						<option value="">- Pilih -</option>
							@foreach($pegawai_list as $pegawai)
							    <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg }} - {{ $pegawai->nama }}</option>
							@endforeach
						</select>
					</div>

					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="bulan" id="bulan">
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
                            <th>BULAN</th>
                            <th>PEGAWAI</th>
                            <th>KOMPONEN UPAH</th>
                            <th>LAST AMOUNT</th>
                            <th>CURRENT AMOUNT</th>
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
                url: "{{ route('modul_sdm_payroll.master_hutang.index.json') }}",
                data: function (d) {
                    d.no_pekerja = $('select[name=no_pekerja]').val();
                    d.bulan = $('select[name=bulan]').val();
                    d.tahun = $('select[name=tahun]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'bulan_tahun', name: 'bulan_tahun'},
                {data: 'pekerja', name: 'pekerja'},
                {data: 'aard', name: 'aard'},
                {data: 'lastamount', name: 'lastamount', class: 'text-right'},
                {data: 'curramount', name: 'curramount', class: 'no-wrap text-right'}
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

                    var url = '{{ route("modul_sdm_payroll.master_hutang.edit", [
                        ":tahun",
                        ":bulan",
                        ":nopek",
                        ":aard"
                    ]) }}';
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
                        text: "Nopek : " + nopek + " Komponen Upah : " + aard,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_hutang.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "tahun": tahun,
                                    "bulan": bulan,
                                    "nopek": nopek,
                                    "aard" : aard,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : "Hapus Nopek : " + nopek + " Komponen Upah : " + aard,
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
