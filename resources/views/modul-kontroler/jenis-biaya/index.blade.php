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
                Tabel Jenis Biaya
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_kontroler.jenis_biaya.create') }}">
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
                            <th>KODE JENIS</th>
                            <th>KETERANGAN</th>
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
            ajax      : {
                        url: "{{ route('modul_kontroler.jenis_biaya.index.json') }}",
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
                {data: 'radio', name: 'aksi', class:'radio-button text-center'},
                {data: 'kode', name: 'kode'},
                {data: 'nama', name: 'nama'},
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
                            text: "Kode  : " +kode,
                            type: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_kontroler.jenis_biaya.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "kode": kode,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    Swal.fire({
                                        type  : 'success',
                                        title : "Data Jenis Biaya dengan kode  : " +kode+" Berhasil Dihapus.",
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
                    location.replace("{{url('kontroler/jenis_biaya/edit') }}"+ '/' +no);
                });
            } else {
                swalAlertInit('ubah');
            }
        });
});

</script>
@endpush
