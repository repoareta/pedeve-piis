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
                Tabel Data Perkara
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(801)->tambah == 1)
                <a href="{{ route('modul_cm.data_perkara.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                @endif
                @if (permission(801)->rubah == 1)
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
                @endif
				@if (permission(801)->hapus == 1)
                <a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
                @endif
                @if (permission(801)->cetak == 1)
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
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>No. Perkara</th>
                            <th>Jenis</th>
                            <th>Klasifikasi Perkara</th>
                            <th>Status Perkara</th>
                            <th>Detail</th>
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
                url: "{{ route('modul_cm.data_perkara.index.json') }}",
                data: function (d) {
                    d.pencarian = $('input[name=pencarian]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class: 'text-center', width: '10'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'no_perkara', name: 'no_perkara'},
                {data: 'jenis_perkara', name: 'jenis_perkara'},
                {data: 'klasifikasi_perkara', name: 'klasifikasi_perkara'},
                {data: 'status_perkara', name: 'status_perkara'},
                {data: 'detail', name: 'detail'},
            ]
        });

        $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) {
                $("input[class=btn-radio]:checked").each(function() {
                    var kode = $(this).attr('data-id');
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
                            text: "No Data Perkara  : " +kode,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_cm.data_perkara.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "kode": kode,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : "Data Perkara Dengan No Perkara  : " +kode+" Berhasil Dihapus.",
                                        text  : 'Berhasil',

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
                });
            } else {
                swalAlertInit('hapus');
            }
        });

        //edit
        $('#editRow').click(function(e) {
            e.preventDefault();

            if($('input[class=btn-radio]').is(':checked')) {
                $("input[class=btn-radio]:checked").each(function(){
                    var no = $(this).attr('data-id');
                    location.href = "{{ url('customer-management/data-perkara/edit') }}" + '/' + no;
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#exportRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var no = $(this).data('no');

					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary',
						cancelButton: 'btn btn-danger'
					},
						buttonsStyling: false
					})

					swalWithBootstrapButtons.fire({
						title: "Data yang akan dicetak?",
						text: "No. Perkara : " + no,
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Cetak',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							// go to page edit
							var url = '{{ route("modul_cm.data_perkara.export", ":no") }}';
							// go to page edit
							window.open(url.replace(':no', no), '_blank');
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
