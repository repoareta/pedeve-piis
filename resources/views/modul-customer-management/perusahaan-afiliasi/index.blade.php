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
                Perusahaan Afiliasi
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_cm.perusahaan_afiliasi.create') }}">
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
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Perusahaan</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Bidang Usaha</th>
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
        ajax      : "{{ route('modul_cm.perusahaan_afiliasi.index.json') }}",
        columns: [
            {data: 'action', name: 'aksi', class:'radio-button text-center', width:'5px', class:'text-center radio-button'},
            {data: 'nama', name: 'nama', class:'no-wrap'},
            {data: 'telepon', name: 'telepon'},
            {data: 'alamat', name: 'alamat'},
            {data: 'bidang_usaha', name: 'bidang_usaha'}
        ]
    });

    $('#editRow').click(function(e) {
        e.preventDefault();
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function() {
                var id = $(this).val().split("/").join("-");
                var url = '{{ route("modul_cm.perusahaan_afiliasi.edit", ":no_panjar") }}';
                // go to page edit
                window.location.href = url.replace(':no_panjar',id);
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
                var nama = $(this).attr('nama');
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
                    text: "Nama Perusahaan : " + nama,
                    type: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batalkan'
                })
                .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('modul_cm.perusahaan_afiliasi.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire({
                                    type  : 'success',
                                    title : 'Hapus Perusahaan ' + nama,
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
