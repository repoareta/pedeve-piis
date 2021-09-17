<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-plus-1 text-primary"></i>
        </span>
        <h3 class="card-label">
            Detail Pertanggungjawaban Panjar Dinas
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <div class="">
                <a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.detail.create', [
                    'no_ppanjar' => str_replace(
                        '/',
                        '-',
                        $ppanjar_header->no_ppanjar
                    )]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xl-12">
            <table class="table table-bordered" id="kt_table">
                <thead class="thead-light">
                    <tr>
						<th></th>
						<th>NO</th>
						<th>NOPEK</th>
						<th>KETERANGAN</th>
						<th>NILAI</th>
						<th>QTY</th>
						<th>TOTAL</th>
					</tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>        
</div>

@push('detail-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: "{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.detail.index.json', ['no_ppanjar' => str_replace('/', '-', $ppanjar_header->no_ppanjar)]) }}",
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no', name: 'no'},
				{data: 'nopek', name: 'nopek'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'nilai', name: 'nilai', class:'no-wrap text-right'},
				{data: 'qty', name: 'qty', class:'no-wrap text-right'},
				{data: 'total', name: 'total', class:'no-wrap text-right'}
			]
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var no = $(this).data('no');
					var nopek = $(this).data('nopek');
					
					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary',
						cancelButton: 'btn btn-danger'
					},
						buttonsStyling: false
					})

					swalWithBootstrapButtons.fire({
						title: "Data yang akan dihapus?",
						text: "Nopek : " + no + ' - ' + nopek,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.detail.delete', ['no_ppanjar' => str_replace('/', '-', $ppanjar_header->no_ppanjar)]) }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"no": no,
									"nopek": nopek,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Hapus Detail Pertanggungjawaban Panjar ' + no + ' - ' + nopek,
										text  : 'Success',
										timer : 2000
									}).then(function() {
										t.ajax.reload();
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
				Swal.fire({
					type: 'warning',
					timer: 2000,
					title: 'Oops...',
					text: 'Tandai baris yang ingin dihapus'
				});
			}
		});
	});
</script>
@endpush