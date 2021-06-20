@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}">    
@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
            Set User
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="#">
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
                    <a href="#">
                        <span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
                            <i class="fas icon-2x fa-print text-info" id="exportRow"></i>
                        </span>                    
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>USER ID</th>
                            <th>USER NAME  </th>
                            <th>USER GROUP </th>
                            <th>USER LEVEL</th>
                            <th>USER APPLICATION</th>
                            <th>RESET PASSWORD</th>
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
<!--begin::Page Vendors(used by this page) -->
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
            var t = $('#kt_table').DataTable({
                scrollX   : true,
                processing: true,
                serverSide: true,
                searching: true,
                lengthChange: true,
                pageLength: 200,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
                },
                ajax      : {
                            url: "{{ route('modul_administrator.set_user.search.index') }}",
                            type : "POST",
                            dataType : "JSON",
                            headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                            },
                            data: function (d) {
                                d.pencarian = $('input[name=pencarian]').val();
                            }
                        },
                columns: [
                    {data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
                    {data: 'userid', name: 'userid'},
                    {data: 'usernm', name: 'usernm'},
                    {data: 'kode', name: 'kode'},
                    {data: 'userlv', name: 'userlv'},
                    {data: 'userap', name: 'userap'},
                    {data: 'reset', name: 'reset'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                t.draw();
                e.preventDefault();
            });
            $('#kt_table tbody').on( 'click', 'tr', function (event) {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                } else {
                    t.$('tr.selected').removeClass('selected');
                    // $(':radio', this).trigger('click');
                    if (event.target.type !== 'radio') {
                        $(':radio', this).trigger('click');
                    }
                    $(this).addClass('selected');
                }
            } );
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
                                type: 'warning',
                                showCancelButton: true,
                                reverseButtons: true,
                                confirmButtonText: 'Ya, hapus',
                                cancelButtonText: 'Batalkan'
                            })
                            .then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('modul_administrator.set_user.delete') }}",
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "kode": kode,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            type  : 'success',
                                            title : "Data Set User dengan jenis  : " +kode+" Berhasil Dihapus.",
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
                        var no = $(this).attr('kode');
                        location.replace("{{url('administrator/set_user/edit')}}"+ '/' +no);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    
            $('#exportRow').click(function(e) {
                e.preventDefault();
                    $('#cetakModal').modal('show');
                    $('#userid').hide();
            });
    
        });
        function displayResult(cetak){ 
            if(cetak == 1)
            {
                $('#userid').val(1);
                $('#userid').hide();
            }else{
                $('#userid').val("");
                $('#userid').show();
            }
        }
    
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
    
            return false;
            return true;
        }
    
    </script>
@endpush
