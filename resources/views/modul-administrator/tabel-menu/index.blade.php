@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')
    
@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Menu
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="{{ route('modul_administrator.tabel_menu.create') }}">
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
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>MENU ID</th>
                            <th>MENU NAME</th>
                            <th>USER APPLICATION</th>
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
        // datatable
        var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('modul_administrator.tabel_menu.index.json') }}",
                data: function (d) {
                    d.pencarian = $('input[name=pencarian]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'menuid', name: 'menuid'},
                {data: 'menunm', name: 'menunm'},
                {data: 'userap', name: 'userap'},
            ]
        });

        // delete
        $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function() {
                    var kode = $(this).attr('kode');
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
                            text: "Jenis  : " +kode,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_administrator.tabel_menu.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "kode": kode,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    Swal.fire({
                                        icon  : 'success',
                                        text : "Data Set User dengan jenis  : " +kode+" Berhasil Dihapus.",
                                        title  : 'Berhasil',
                                        
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
                    var no = $(this).attr('kode');
                    location.replace("{{ url('administrator/tabel-menu/edit') }}"+ '/' +no);
                });
            } else {
                swalAlertInit('ubah');
            }
        });

    });
</script>
@endpush
