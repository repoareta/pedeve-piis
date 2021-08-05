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

        <div class="col-12">
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">BULAN</label>
					<div class="col-3">
						<select class="form-control select2" style="width: 100% !important;" name="bulan" id="bulan">
							<option value="">- Pilih -</option>
							<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
							<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
							<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
							<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
							<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
							<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
							<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
							<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
							<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
							<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
							<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
							<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
						</select>
					</div>

                    <label for="" class="col-form-label">TAHUN</label>
					<div class="col-2">
						<input class="form-control tahun" type="text" name="tahun" id="tahun" value="{{ date('Y') }}">
					</div>

					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>
        
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
            ajax      : {
                        url: "{{ route('modul_kontroler.jurnal_umum.index.json') }}",
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
                {data: 'radio', name: 'aksi', class:'radio-button text-center'},
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
                                    } else {
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
                    location.replace("{{url('kontroler/jurnal_umum/edit') }}"+ '/' +no);
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
                    location.replace("{{url('kontroler/jurnal_umum/rekap') }}"+ '/' +docno);
                });
            } else {
                swalAlertInit('cetak');
            }
        });

});
</script>
@endpush
