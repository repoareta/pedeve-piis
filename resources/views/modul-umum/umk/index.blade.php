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
                Tabel Uang Muka Kerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(721)->tambah == 1)
                <a href="{{ route('modul_umum.uang_muka_kerja.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                @endif
                @if (permission(721)->rubah == 1)
				<a href="#">
					<span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
                @endif
                @if (permission(721)->hapus == 1)
				<a href="#">
					<span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
                @endif
                @if (permission(721)->cetak == 1)
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
			<form class="form" id="search-form">
				<div class="form-group row">
					<label for="" class="col-form-label">No. UMK</label>
					<div class="col-2">
						<input class="form-control" type="text" name="permintaan" value="" size="18" maxlength="18">
					</div>
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select name="bulan" class="form-control select2">
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
		</div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked></th>
                            <th>Tanggal</th>
                            <th>No UMK</th>
                            <th>No Kas/Bank</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Nilai</th>
                            <th>Approval</th>
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
			<form class="form" action="{{ route('modul_umum.uang_muka_kerja.rekap.export') }}" method="POST" id="formCetakData" target="_blank">
                @csrf
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nomor Permintaan</label>
						<div class="col-10">
							<input class="form-control" type="text" readonly name="noumk" id="noumk">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Atasan Ybs</label>
						<div class="col-10">
							<input class="form-control" type="text" name="atasan_ybs" id="atasan_ybs" autocomplete="off">
						</div>
					</div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Menyetujui</label>
						<div class="col-10">
							<input class="form-control" type="text" name="menyetujui" id="menyetujui" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">CS & BS</label>
						<div class="col-10">
							<input class="form-control" type="text" name="sekr_perseroan" id="sekr_perseroan" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Finance</label>
						<div class="col-10">
							<input class="form-control" type="text" name="keuangan" id="keuangan" autocomplete="off">
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
    $(document).ready(function(){
        var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('modul_umum.uang_muka_kerja.index.json') }}",
                data: function (d) {
                    d.permintaan = $('input[name=permintaan]').val();
                    d.bulan = $('select[name=bulan]').val();
                    d.tahun = $('input[name=tahun]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'tgl_panjar', name: 'tgl_panjar'},
                {data: 'no_umk', name: 'no_umk'},
                {data: 'no_kas', name: 'no_kas'},
                {data: 'jenis_um', name: 'jenis_um'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'jumlah', name: 'jumlah'},
                {data: 'approval', name: 'approval', class: 'text-center'},
            ]
        });

        $('#search-form').on('submit', function(e) {
            t.draw();
            e.preventDefault();
        });

        //report Uang Muka Kerja
    $('#exportRow').on('click', function(e) {
        e.preventDefault();

        var allVals = [];
        $(".btn-radio:checked").each(function() {
            e.preventDefault();
            var dataid = $(this).attr('data-id');
            var dataa = $(this).attr('dataumk');

            if(dataid == 1)
            {
                swalAlertInit('cetak');
            } else {
                $('#cetakModal').modal('show');
                $('#noumk').val(dataa);
            }
        });
    });

    //edit
    $('#editRow').on('click', function(e) {
        e.preventDefault();
        var allVals = [];
        $(".btn-radio:checked").each(function() {
            e.preventDefault();
            var dataid = $(this).attr('data-id');
            var dataa = $(this).attr('kt_table');

            if(dataid == 1) {
                swalAlertInit('ubah');
            } else {
                location.href = "{{ url('umum/uang-muka-kerja/edit') }}" + '/' + dataid ;
            }
        });
    });

    //delete
    $('#deleteRow').click(function(e) {
        e.preventDefault();
        $(".btn-radio:checked").each(function() {
            var dataid = $(this).attr('data-id');
            if(dataid == 1) {
                swalAlertInit('hapus');
            } else {
                $("input[type=radio]:checked").each(function() {
                    var id = $(this).attr('dataumk');
                    var status = $(this).attr('data-s');
                    // delete stuff
                    if(status == 'Y'){
                        Swal.fire({
                            icon  : 'info',
                            title : 'Data Tidak Bisa Dihapus, Data Sudah di Proses Perbendaharaan.',
                            text  : 'Failed',
                        });
                    } else {
                        const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-danger'
                        },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: "Data yang akan dihapus?",
                            text: "No. UMK : " + id,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('modul_umum.uang_muka_kerja.delete') }}",
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "id": id,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function () {
                                        Swal.fire({
                                            icon  : 'success',
                                            title : 'Hapus No. UMK ' + id,
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
            }
        });
    });
});
</script>
@endpush
