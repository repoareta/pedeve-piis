@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Vendor
            </h3>
        </div>

        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.vendor.create') }}">
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
       <!--begin: Datatable -->
		<table class="table table-bordered" id="data-vendor" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>NAMA VENDOR</th>
					<th>NO. REKENING</th>
					<th>NAMA BANK</th>
					<th>CABANG BANK</th>
					<th>ALAMAT</th>
					<th>NO. TELEPON</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		<!--end: Datatable -->
    </div>
</div>


@endsection

@push('page-scripts')
<script type="text/javascript">
    $(document).ready(function(){
        var t = $('#data-vendor').DataTable({
                scrollX   : true,
                processing: true,
                serverSide: true,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
                },
                ajax      : "{{ route('modul_umum.vendor.index.json') }}",
                columns: [
                    {data: 'action', name: 'action'},
                    {data: 'nama', name: 'nama'},
                    {data: 'no_rekening', name: 'no_rekening'},
                    {data: 'nama_bank', name: 'nama_bank'},
                    {data: 'cabang_bank', name: 'cabang_bank'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'telepon', name: 'telepon'},
                ]
        });
    
        $('#data-vendor tbody').on( 'click', 'tr', function (event) {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
                t.$('tr.selected').removeClass('selected');
                
                if (event.target.type !== 'radio') {
                    $(':radio', this).trigger('click');
                }
                $(this).addClass('selected');
            }
        });
    
        //edit vendor
        $('#editRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function(){
                    var id = $(this).attr('data-id');
                    var url = '{{ route("modul_umum.vendor.edit", ":vendor_id") }}';
                    window.location.href = url.replace(':vendor_id',id);
                });
            } else {
                swalAlertInit('ubah');
            }
        });
    
        //delete vendor
        $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function() {
                    var id = $(this).attr('data-id');
                    var nama = $(this).attr('data-nama');
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
                            text: "Nama Vendor : " + nama,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_umum.vendor.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "id": id,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Nama Vendor ' + nama,
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
