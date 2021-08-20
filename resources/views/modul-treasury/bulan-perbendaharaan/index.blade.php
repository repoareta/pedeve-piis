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
                Tabel Setting Bulan Buku
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if($data_akses->tambah == 1)
                <a href="{{ route('bulan_perbendaharaan.create') }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->rubah == 1 || $data_akses->lihat == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>TAHUN-BULAN</th>
					<th>STATUS</th>
					<th>OPENDATE</th>
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
                ajax: {
                    url: "{{ route('bulan_perbendaharaan.index.json') }}",
                    data: function (d) {
                        d.pencarian = $('input[name=pencarian]').val();
                    }
                },
                columns: [
                    {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                    {data: 'thnbln', name: 'thnbln'},
                    {data: 'nama_status', name: 'nama_status'},
                    {data: 'data_buka', name: 'data_buka'},
                    {data: 'data_tutup', name: 'data_tutup'},
                    {data: 'description', name: 'description'},
                    {data: 'suplesi', name: 'suplesi'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                t.draw();
                e.preventDefault();
            });
            
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
                        location.replace("{{ url('perbendaharaan/bulan-perbendaharaan/edit') }}"+ '/' +no);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    });
</script>
@endpush