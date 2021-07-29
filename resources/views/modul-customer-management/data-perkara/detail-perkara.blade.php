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
                INFORMASI DETAIL PERKARA
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No. Perkara</th>
                            <th>Jenis</th>
                            <th>Status Perkara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data_list as $data)
                            <tr>
                                <td>{{ $data->no_perkara}}</td>
                                <td>{{ $data->jenis_perkara}}</td>
                                <td>{{ $data->status_perkara}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="kt-portlet__head kt-portlet__head">
                    <div class="kt-portlet__head-toolbar">
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-primary" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#detail_umum" id="reload-umum" role="tab" aria-selected="true">
                                Data Umum
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#detail_pihak" id="reload-pihak" role="tab" aria-selected="false">
                                Pihak
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#detail_hakim" id="reload-hakim" role="tab" aria-selected="false">
                                Kuasa Hukum
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#detail_dokumen" id="reload-dokumen" role="tab" aria-selected="false">
                                Dokumen Perkara
                                </a>
                            </li>
                            <li class="nav-item">
                            <a href="{{ route('modul_cm.data_perkara.index') }}" class="btn btn-primary"><i class="fa fa-reply"></i>Kembali</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="kt-portlet__body" style="padding-top:10px">
                    <div class="tab-content">
                        <div class="tab-pane active" id="detail_umum">
                            @include('modul-customer-management.data-perkara.detail-umum')
                        </div>
    
                        <div class="tab-pane" id="detail_pihak">
                            @include('modul-customer-management.data-perkara.detail-pihak')
                        </div>
    
                        <div class="tab-pane" id="detail_hakim">
                            @include('modul-customer-management.data-perkara.detail-hakim')
                        </div>
    
                        <div class="tab-pane" id="detail_dokumen">
                            @include('modul-customer-management.data-perkara.detail-dokumen')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
$(document).ready(function () {
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
                                url: "{{ route('modul_cm.data_perkara.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "kode": kode,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    Swal.fire({
                                        type  : 'success',
                                        title : "Data Data Perkara dengan jenis  : " +kode+" Berhasil Dihapus.",
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
                    location.replace("{{url('administrator/data_perkara/edit')}}"+ '/' +no);
                });
            } else {
                swalAlertInit('ubah');
            }
        });
});
</script>
@endpush
