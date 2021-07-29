@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-right">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Umum Anggaran Submain
            </h3>
        </div>
    </div>
    <div class="card-body">
		<div class="col-12">
			<form class="kt-form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">Kode Sub Anggaran</label>
					<div class="col-2">
						<input class="form-control" type="text" name="kode_anggaran" id="kode_anggaran">
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100%;" name="tahun" id="tahun">
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
                            <th>Main</th>
                            <th>Sub Anggaran</th>
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
        ajax      : {
            url: "{{ route('modul_umum.anggaran.submain.index.json') }}",
            data: function (d) {
                d.kode = $('input[name=kode]').val();
                d.tahun = $('select[name=tahun]').val();
            }
        },
        columns: [
            {data: 'action', name: 'action', orderable: false, searchable: false, class:'radio-button'},
            {data: 'main', name: 'main', class:'no-wrap'},
            {data: 'sub_anggaran', name: 'sub_anggaran', class:'no-wrap'},
            {data: 'tahun', name: 'tahun'},
            {data: 'nilai', name: 'nilai'},
            {data: 'nilai_real', name: 'nilai_real'},
            {data: 'sisa', name: 'sisa'},
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
                var kode_main = $(this).val().split("-")[0];
                var kode_submain = $(this).val().split("-")[1];
                var url = '{{ route("modul_umum.anggaran.submain.edit", [":kode_main", ":kode_submain"]) }}';
                // go to page edit
                window.location.href = url
                .replace(':kode_main', kode_main)
                .replace(':kode_submain', kode_submain);
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
                    type: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batalkan'
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('modul_umum.anggaran.submain.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire({
                                    type  : 'success',
                                    title : 'Hapus Kode ' + id,
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
