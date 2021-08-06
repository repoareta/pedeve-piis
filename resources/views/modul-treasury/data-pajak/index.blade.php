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
                Tabel Data Pajak Tahunan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if($data_akses->tambah == 1)
                <a href="{{ route('data_pajak.create') }}">
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
        <form class="form" id="search-form">
            <div class="form-group row">
                <label for="" class="col-1 col-form-label">Pencarian</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="pencarian" value="" autocomplete="off">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th width="50"></th>
					<th>TAHUN</th>
					<th>BULAN</th>
					<th>PEKERJA</th>
					<th>JENIS</th>
					<th>NILAI</th>
					<th>PAJAK</th>
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
                scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('data_pajak.index.json') }}",
                    data: function (d) {
                        d.pencarian = $('input[name=pencarian]').val();
                    }
                },
                columns: [
                    {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                    {data: 'tahun', name: 'tahun'},
                    {data: 'bulan', name: 'bulan'},
                    {data: 'pekerja', name: 'pekerja'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'nilai', name: 'nilai'},
                    {data: 'pajak', name: 'pajak'},
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
                        var tahun = $(this).attr('tahun');
                        var bulan = $(this).attr('bulan');
                        var nopek = $(this).attr('nopek');
                        var jenis = $(this).attr('jenis');
                        location.href = "{{ url('perbendaharaan/data-pajak/edit') }}" + '/' + tahun + '/' + bulan + '/' + nopek + '/' + jenis;
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
            $('#tanggal').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                autoclose: true,
                language : 'id',
                format   : 'yyyy-mm-dd'
            });
            //delete data_pajak
            $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function() {
                    var tahun = $(this).attr('tahun');
                    var bulan = $(this).attr('bulan');
                    var nopek = $(this).attr('nopek');
                    var jenis = $(this).attr('jenis');
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
                            text: "Tahun  : " +tahun+ " Bulan : " +bulan+" Nopek : "+nopek ,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('data_pajak.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "tahun": tahun,
                                    "bulan": bulan,
                                    "jenis": jenis,
                                    "nopek": nopek,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: "Tahun  : " +tahun+ " Bulan : " +bulan+" Nopek : "+nopek + " Berhasil Dihapus.",
                                        text: 'Berhasil',
                                        
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