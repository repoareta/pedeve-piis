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
                Tabel Main Account
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_kontroler.main_account.create') }}">
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
                            <th>JENIS</th>
                            <th>AWAL</th>
                            <th>AKHIR</th>
                            <th>URUTAN</th>
                            <th>PENGALI</th>
                            <th>P.TAMPIL</th>
                            <th>SUB.AKUN</th>
                            <th>LOKASI</th>
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
                url: "{{ route('modul_kontroler.main_account.index.json') }}",
                data: function (d) {
                    d.pencarian = $('input[name=pencarian]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'aksi', class:'radio-button text-center'},
                {data: 'jenis', name: 'jenis'},
                {data: 'batas_awal', name: 'batas_awal'},
                {data: 'batas_akhir', name: 'batas_akhir'},
                {data: 'urutan', name: 'urutan'},
                {data: 'pengali', name: 'pengali'},
                {data: 'pengali_tampil', name: 'pengali_tampil'},
                {data: 'sub_akun', name: 'sub_akun'},
                {data: 'lokasi', name: 'lokasi'},
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
                                    url: "{{ route('modul_kontroler.main_account.delete') }}",
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "kode": kode,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            type  : 'success',
                                            title : "Data Main Account dengan jenis  : " +kode+" Berhasil Dihapus.",
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
                    location.replace("{{ url('kontroler/main_account/edit') }}"+ '/' +no);
                });
            } else {
                swalAlertInit('ubah');
            }
        });
});

</script>
@endpush
