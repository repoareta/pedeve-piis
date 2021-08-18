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
                Tabel Pinjaman Pekerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_sdm_payroll.pinjaman_pekerja.create') }}">
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
                            <th>ID PINJAMAN</th>
                            <th>NOPEK</th>
                            <th>NAMA</th>	
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>TENOR</th>
                            <th>ANGSURAN</th>
                            <th>TOTAL PINJAMAN</th>
                            <th>SISA PINJAMAN</th>
                            <th>NO KONTRAK</th>
                            <th>CAIR</th>
                            <th>LUNAS</th>
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
                url: "{{ route('modul_sdm_payroll.pinjaman_pekerja.index.json') }}",
                data: function (d) {
                    d.nopek = $('input[name=nopek]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'id_pinjaman', name: 'id_pinjaman'},
                {data: 'nopek', name: 'nopek'},
                {data: 'namapegawai', name: 'namapegawai'},
                {data: 'mulai', name: 'mulai'},
                {data: 'sampai', name: 'sampai'},
                {data: 'tenor', name: 'tenor'},
                {data: 'angsuran', name: 'angsuran', class: 'text-right'},
                {data: 'jml_pinjaman', name: 'jml_pinjaman', class: 'text-right'},
                {data: 'curramount', name: 'curramount', class: 'text-right'},
                {data: 'no_kontrak', name: 'no_kontrak'},
                {data: 'cair', name: 'cair', class: 'text-center'},
                {data: 'lunas', name: 'lunas', class: 'text-center'},
            ]
            
    });

    $('#search-form').on('submit', function(e) {
        t.draw();
        e.preventDefault();
    });

    //edit 
    $('#editRow').click(function(e) {
        e.preventDefault();

        if($('input[class=btn-radio]').is(':checked')) { 
            $("input[class=btn-radio]:checked").each(function(){
                var id = $(this).attr('id_pinjaman');
                location.href = "{{ url('sdm-payroll/pinjaman-pekerja/edit') }}" + '/' + id;
            });
        } else {
            swalAlertInit('ubah');
        }
    });

    //delete
    $('#deleteRow').click(function(e) {
        e.preventDefault();
        if($('input[class=btn-radio]').is(':checked')) { 
            $("input[class=btn-radio]:checked").each(function() {
                var id_pinjaman = $(this).attr('id_pinjaman');
                var cair = $(this).attr('cair');
                // delete stuff
                if(cair == 'Y'){
                    Swal.fire({
                                icon  : 'info',
                                title : 'Status cair tidak bisa dihapus.',
                                text  : 'Info',
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
                            text: "ID Pinjaman : " + id_pinjaman,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.pinjaman_pekerja.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "id_pinjaman": id_pinjaman,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus ID Pinjaman ' + id_pinjaman,
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
        } else {
            swalAlertInit('hapus');
        }
    });
});
</script>
@endpush
