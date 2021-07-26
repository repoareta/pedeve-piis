@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Setting Bulan Buku
            </h3>
            <div class="text-right">
                @if($data_akses->tambah == 1)
                <a href="{{ route('bulan_perbendaharaan.create') }}" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas icon-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->rubah == 1 or $data_akses->lihat == 1)
                <button id="editRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
                        <i class="fas icon-2x fa-edit text-warning"></i>
                    </span>
                </button>
                @endif
                @if($data_akses->hapus == 1)
                <button id="deleteRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data">
                        <i class="fas icon-2x fa-times text-danger"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>TAHUN-BULAN</th>
					<th>STATUS</th>
					<th>OPENDATE</th>
					<th>STOPDATE</th>
					<th>CLOSEDATE</th>
					<th>KETERANGAN</th>
					<th>SUPLESI</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
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
                searching: true,
                lengthChange: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
                },
                ajax: {
                    url: "{{ route('bulan_perbendaharaan.index.json') }}",
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
                    {data: 'thnbln', name: 'thnbln'},
                    {data: 'nama_status', name: 'nama_status'},
                    {data: 'data_buka', name: 'data_buka'},
                    {data: 'data_stop', name: 'data_stop'},
                    {data: 'data_tutup', name: 'data_tutup'},
                    {data: 'description', name: 'description'},
                    {data: 'suplesi', name: 'suplesi'},
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
                                text: "Tahun-Bulan  : " +kode,
                                icon: 'warning',
                                showCancelButton: true,
                                reverseButtons: true,
                                confirmButtonText: 'Ya, hapus',
                                cancelButtonText: 'Batalkan'
                            })
                            .then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('bulan_perbendaharaan.delete') }}",
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "kode": kode,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            icon  : 'success',
                                            title : "Data Setting Bulan Buku dengan kode  : " +kode+" Berhasil Dihapus.",
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
                        location.replace("{{url('perbendaharaan/bulan-perbendaharaan/edit')}}"+ '/' +no);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    });
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
</script>
@endpush