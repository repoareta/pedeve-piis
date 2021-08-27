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
                Tabel Jenis Upah
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_sdm_payroll.jenis_upah.create') }}">
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
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>CETAK</th>
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
        ajax      : "{{ route('modul_sdm_payroll.jenis_upah.index.json') }}",
        columns: [
            {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
            {data: 'kode', name: 'kode'},
            {data: 'nama', name: 'nama'},
            {data: 'cetak', name: 'cetak'},
        ]
    });

    //edit potongan Manual
    $('#editRow').click(function(e) {
        e.preventDefault();
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function() {
                var id = $('input[type=radio]:checked').val();
                var url = '{{ route("modul_sdm_payroll.jenis_upah.edit", ":kode") }}';
                // go to page edit
                window.location.href = url.replace(':kode',id);
            });
        } else {
            swalAlertInit('ubah');
        }
    });

    //delete potongan manual
    $('#deleteRow').click(function(e) {
        e.preventDefault();
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function() {
                var kode = $(this).val();
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
                        text: "Dedail data Jenis Upah Kode: "+kode,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('modul_sdm_payroll.jenis_upah.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "kode": kode,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire({
                                    icon  : 'success',
                                    title : "Dedail data Jenis Upah Kode: "+kode,
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
            });
        } else {
            swalAlertInit('hapus');
        }
    });
});
</script>
@endpush
