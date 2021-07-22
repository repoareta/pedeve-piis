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
                Tabel Jurnal Umum
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_kontroler.jurnal_umum.create') }}">
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
                            <th>DOC.NO</th>
                            <th>KETERANGAN</th>
                            <th>JK</th>
                            <th>STORE</th>
                            <th>NOBUKTI</th>
                            <th>POSTED</th>	
                            <th>COPY</th>
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
            searching: false,
            lengthChange: false,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
            },
            ajax      : {
                        url: "{{ route('modul_kontroler.jurnal_umum.search.index') }}",
                        type : "POST",
                        dataType : "JSON",
                        headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        data: function (d) {
                            d.tahun = $('input[name=tahun]').val();
                            d.bulan = $('select[name=bulan]').val();
                        }
                    },
            columns: [
                {data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
                {data: 'docno', name: 'docno'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'jk', name: 'jk'},
                {data: 'store', name: 'store'},
                {data: 'voucher', name: 'voucher'},
                {data: 'posted', name: 'posted'},
                {data: 'action', name: 'action', class: 'text-center'},
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
                    var docno = $(this).attr('docno');
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
                            text: "No Dokumen  : " +docno,
                            type: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_kontroler.jurnal_umum.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "docno": docno,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    if(data == 1){
                                        Swal.fire({
                                            type  : 'success',
                                            title : "Data Jurnal Umum dengan No Dokumen  : " +docno+" Berhasil Dihapus.",
                                            text  : 'Berhasil',
                                            
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }else if(data == 2){
                                        Swal.fire({
                                        type  : 'info',
                                        title : 'Penghapusan Gagal, Data Tidak Dalam Status Opening.',
                                        text  : 'Info',
                                        });
                                    }else{
                                        Swal.fire({
                                        type  : 'info',
                                        title : 'Data Sudah Di Posting, Tidak Bisa Di Update/Hapus.',
                                        text  : 'Info',
                                        });
                                        
                                    }
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
                    var no = $(this).attr('docno');
                    location.replace("{{url('kontroler/jurnal_umum/edit')}}"+ '/' +no);
                });
            } else {
                swalAlertInit('ubah');
            }
        });
        //export 
        $('#exportRow').click(function(e) {
            e.preventDefault();

            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function(){
                    var docno = $(this).attr('docno');
                    location.replace("{{url('kontroler/jurnal_umum/rekap')}}"+ '/' +docno);
                });
            } else {
                swalAlertInit('cetak');
            }
        });

});
</script>
@endpush
