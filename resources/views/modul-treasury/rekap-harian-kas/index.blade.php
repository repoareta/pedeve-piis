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
                Tabel Rekap Harian Kas/Bank
            </h3>
            <div class="text-right">
                <a href="{{ route('rekap_harian_kas.create') }}" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas icon-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <button id="editRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah Data">
                        <i class="fas icon-2x fa-edit text-warning"></i>
                    </span>
                </button>
                <button id="deleteRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data">
                        <i class="fas icon-2x fa-trash text-danger"></i>
                    </span>
                </button>
                <button id="exportRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cetak Data">
                        <i class="fas icon-2x fa-print text-primary"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="form" id="search-form" >
            <div class="form-group row">
                <label for="" class="col-1 col-form-label">No. Kas</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="nokas" value="" size="6" maxlength="6" autocomplete="off">
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
				<th>JK</th>
				<th>NO.KAS</th>
				<th>NO</th>
				<th>TGL.REKAP</th>
				<th>SALDO AWAL</th>
				<th>DEBET</th>
				<th>KREDIT</th>
				<th>SALDO AKHIR</th>
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
						url: "{{ route('rekap_harian_kas.index.json') }}",
						type : "POST",
						dataType : "JSON",
						headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
						},
						data: function (d) {
							d.nama = $('input[name=nokas]').val();
						}
					},
			columns: [
				{data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
				{data: 'jk', name: 'jk'},
				{data: 'store', name: 'store'},
				{data: 'no', name: 'no'},
				{data: 'tglrekap', name: 'tglrekap'},
				{data: 'saldoawal', name: 'saldoawal'},
				{data: 'debet', name: 'debet'},
				{data: 'kredit', name: 'kredit'},
				{data: 'saldoakhir', name: 'saldoakhir'},
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
					var tanggal = $(this).attr('tanggal');
					var jk = $(this).attr('jk');
					var nokas = $(this).attr('nokas');
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
							text: "Tanggal  : " +tanggal+ " Nokas : " +nokas,
							type: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('rekap_harian_kas.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"tanggal": tanggal,
									"jk": jk,
									"nokas": nokas,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : "Data Kas Bank Tanggal  : " +tanggal+ " Nokas : " +nokas+ " Berhasil Dihapus.",
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
					var tgl = $(this).attr('tanggal');
					var id = $(this).attr('jk');
					var no = $(this).attr('nokas');
					location.replace("{{url('perbendaharaan/rekap_harian_kas/edit')}}"+ '/' +no+'/'+id+'/'+tgl);
				});
			} else {
				swalAlertInit('ubah');
			}
		});
		//edit 
		$('#exportRow').click(function(e) {
			e.preventDefault();
			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function(){
					var id = $(this).attr('jk');
					var no = $(this).attr('nokas');
					var tanggal = $(this).attr('tanggal');
					location.replace("{{url('perbendaharaan/rekap_harian_kas/rekap')}}"+ '/' +no+'/'+id+'/'+tanggal);
				});
			} else {
				swalAlertInit('cetak');
			}
		});
});
</script>
@endpush