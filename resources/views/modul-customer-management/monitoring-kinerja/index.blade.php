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
                Tabel Monitoring Kinerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_cm.perusahaan_afiliasi.create') }}">
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
        <div class="col-12">
			<form class="kt-form" id="search-form" >
				<div class="form-group row">
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<?php 
							$tgl = date_create(now());
							$bulan = date_format($tgl, 'm'); 
							$tahun = date_format($tgl, 'Y'); 
							$array_bln	 = array (
								1 =>   'Januari',
								'Februari',
								'Maret',
								'April',
								'Mei',
								'Juni',
								'Juli',
								'Agustus',
								'September',
								'Oktober',
								'November',
								'Desember'
							);
							
							$bulan_1 = ($array_bln[ltrim($bulan,0)]);
						?>
						<select class="form-control select2" style="width: 100% !important;" name="bulan">
							<option value="01" <?php if($bulan == '01' ) echo 'selected' ; ?>>Januari</option>
							<option value="02" <?php if($bulan == '02' ) echo 'selected' ; ?>>Februari</option>
							<option value="03" <?php if($bulan == '03' ) echo 'selected' ; ?>>Maret</option>
							<option value="04" <?php if($bulan == '04' ) echo 'selected' ; ?>>April</option>
							<option value="05" <?php if($bulan == '05' ) echo 'selected' ; ?>>Mei</option>
							<option value="06" <?php if($bulan == '06' ) echo 'selected' ; ?>>Juni</option>
							<option value="07" <?php if($bulan == '07' ) echo 'selected' ; ?>>Juli</option>
							<option value="08" <?php if($bulan == '08' ) echo 'selected' ; ?>>Agustus</option>
							<option value="09" <?php if($bulan == '09' ) echo 'selected' ; ?>>September</option>
							<option value="10" <?php if($bulan == '10' ) echo 'selected' ; ?>>Oktober</option>
							<option value="11" <?php if($bulan == '11' ) echo 'selected' ; ?>>November</option>
							<option value="12" <?php if($bulan == '12' ) echo 'selected' ; ?>>Desember</option>
						</select>
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
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
                        <tr >
                            <th rowspan="3">No</th>
                            <th rowspan="3" class="no-wrap">Perusahaan</th>
                            <th rowspan="3" class="no-wrap">BULAN/TAHUN</th>
                            <th rowspan="3">CI</th>
                        </tr>
                        <tr>
                            <th colspan="10" class="text-center">REALISASI</th>
                        </tr>
                        <tr>
                            <th class="no-wrap">Aset</th>
                            <th class="no-wrap">Revenue</th>
                            <th class="no-wrap">Beban Pokok</th>
                            <th class="no-wrap">Laba Kotor</th>
                            <th class="no-wrap">Biaya Operasi</th>
                            <th class="no-wrap">Laba Operasi</th>
                            <th class="no-wrap">Laba Bersih</th>
                            <th class="no-wrap">TKP</th>
                            <th class="no-wrap">KPI</th>
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
    $(document).ready(function(){
        var t =$('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            
            
            pageLength: 100,
            ajax      : {
                url: "{{ route('modul_cm.monitoring_kinerja.index.json') }}",
                type : "POST",
                dataType : "JSON",
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: function (d) {
                    d.bulan = $('select[name=bulan]').val();
                    d.tahun = $('input[name=tahun]').val();
                }
            },
            columns: [
                {data: 'action', name: 'action'},
                {data: 'nama', name: 'nama'},
                {data: 'thnbln', name: 'thnbln'},
                {data: 'ci', name: 'ci'},
                {data: 'aset', name: 'aset', class: 'text-right'},
                {data: 'revenue', name: 'revenue', class: 'text-right'},
                {data: 'beban_pokok', name: 'beban_pokok', class: 'text-right'},
                {data: 'laba_kotor', name: 'laba_kotor', class: 'text-right'},
                {data: 'biaya_operasi', name: 'biaya_operasi', class: 'text-right'},
                {data: 'laba_operasi', name: 'laba_operasi', class: 'text-right'},
                {data: 'laba_bersih', name: 'laba_bersih', class: 'text-right'},
                {data: 'tkp', name: 'tkp', class: 'text-right'},
                {data: 'kpi', name: 'kpi', class: 'text-right'},
            ]
    });
    $('#search-form').on('submit', function(e) {
        t.draw();
        e.preventDefault();
                var bulan = $('select[name=bulan]').val();
        $('#acc').val(bulan);
    });
    
    //edit monitoring_kinerja
    $('#editRow').click(function(e) {
            e.preventDefault();

            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function(){
                    var id = $(this).attr('data-id');
                    location.replace("{{url('customer_management/monitoring_kinerja/edit')}}"+ '/' +id);
                });
            } else {
                swalAlertInit('ubah');
            }
        });


    //delete monitoring_kinerja
    $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function() {
                    var id = $(this).attr('data-id');
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
                            text: "No. monitoring kinerja : " + id,
                            type: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_cm.monitoring_kinerja.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "id": id,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        type  : 'success',
                                        title : 'Hapus No. monitoring kinerja ' + id,
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
