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
                Tabel Pembayaran Permintaan Bayar
            </h3>
            <div class="text-right">
                @if($data_akses->tambah == 1)
                <a href="{{ route('pembayaran_pbayar.create') }}" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
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
                        <i class="fas icon-2x fa-trash text-danger"></i>
                    </span>
                </button>
                @endif
                @if($data_akses->cetak == 1)
                <button id="exportRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cetak Data">
                        <i class="fas icon-2x fa-print text-primary"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" id="search-form" >
            <div class="form-group row">
                <label for="" class="col-form-label">No. Bukti</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="bukti" value="" size="18" maxlength="18" autocomplete="off">
                </div>
                <label for="" class="col-form-label">Bulan</label>
                <div class="col-2">
                    <select name="bulan" class="form-control selectpicker" data-live-search="true">
                        <option value="" >-- Pilih --</option>
                        <option value="01" <?php if($bulan  == '01' ) echo 'selected' ; ?>>Januari</option>
                        <option value="02" <?php if($bulan  == '02' ) echo 'selected' ; ?>>Februari</option>
                        <option value="03" <?php if($bulan  == '03' ) echo 'selected' ; ?>>Maret</option>
                        <option value="04" <?php if($bulan  == '04' ) echo 'selected' ; ?>>April</option>
                        <option value="05" <?php if($bulan  == '05' ) echo 'selected' ; ?>>Mei</option>
                        <option value="06" <?php if($bulan  == '06' ) echo 'selected' ; ?>>Juni</option>
                        <option value="07" <?php if($bulan  == '07' ) echo 'selected' ; ?>>Juli</option>
                        <option value="08" <?php if($bulan  == '08' ) echo 'selected' ; ?>>Agustus</option>
                        <option value="09" <?php if($bulan  == '09' ) echo 'selected' ; ?>>September</option>
                        <option value="10" <?php if($bulan  == '10' ) echo 'selected' ; ?>>Oktober</option>
                        <option value="11" <?php if($bulan  == '11' ) echo 'selected' ; ?>>November</option>
                        <option value="12" <?php if($bulan  == '12' ) echo 'selected' ; ?>>Desember</option>
                    </select>
                </div>

                <label for="" class="col-form-label">Tahun</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="tahun" value="{{$tahun}}" autocomplete="off">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>STATUS BYR</th>
					<th>NO.DOKUMEN</th>
					<th>TANGGAL</th>
					<th>NO.BUKTI</th>
					<th>KEPADA</th>
					<th>JK</th>
					<th>NO.KAS</th>
					<th>CI</th>
					<th>KURS</th>
					<th>NILAI</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax      : {
						url: "{{ route('pembayaran_pbayar.index.json') }}",
						type : "POST",
						dataType : "JSON",
						headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
						},
						data: function (d) {
							d.bukti = $('input[name=bukti]').val();
							d.bulan = $('select[name=bulan]').val();
							d.tahun = $('input[name=tahun]').val();
						}
					},
			columns: [
				{data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
				{data: 'action', name: 'action'},
				{data: 'docno', name: 'docno'},
				{data: 'tanggalinput', name: 'tanggalinput'},
				{data: 'nobukti', name: 'nobukti'},
				{data: 'kepada', name: 'kepada'},
				{data: 'jk', name: 'jk'},
				{data: 'nokas', name: 'nokas'},
				{data: 'ci', name: 'ci'},
				{data: 'kurs', name: 'kurs'},
				{data: 'nilai', name: 'nilai'},
			]
		});
		$('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});
		
		// edit Kas/Bank Otomatis
			$('#editRow').click(function(e) {
				e.preventDefault();
				if($('input[type=radio]').is(':checked')) { 
					$("input[type=radio]:checked").each(function(){
						var nodok = $(this).val().split("/").join("-");
						// var nodok = $(this).attr('nodok');
						location.href = "{{url('perbendaharaan/pembayaran-pbayar/edit')}}"+ '/' +nodok;
					});
				} else {
					swalAlertInit('ubah');
				}
			});
			// delete Kas/Bank otomatis
			$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var nodok = $(this).val();
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
							text: "No Dokumen: "+nodok,
							type: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('pembayaran_pbayar.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"nodok": nodok,
									"_token": "{{ csrf_token() }}",
								},
								success: function (data) {
									if(data == 1){
										Swal.fire({
											type  : 'success',
											title : "No Dokumen: "+nodok,
											text  : 'Berhasil',
											timer : 2000
										}).then(function() {
											location.reload();
										});
									}else if(data == 2){
										Swal.fire({
											type  : 'info',
											title : 'Penghapusan gagal,data tidak dalam status Opening.',
											text  : 'Failed',
										});
									}else{
										Swal.fire({
											type  : 'info',
											title : 'Sebelum dihapus,status bayar harus dibatalkan dulu.',
											text  : 'Failed',
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
			//export 
			$('#exportRow').click(function(e) {
				e.preventDefault();
				if($('input[class=btn-radio]').is(':checked')) { 
					$("input[class=btn-radio]:checked").each(function(){
						var docno = $(this).attr('docno');
						location.href = "{{url('perbendaharaan/pembayaran-pbayar/rekap')}}"+ '/' +docno;
					});
				} else {
					swalAlertInit('cetak');
				}
			});
});
</script>
@endpush