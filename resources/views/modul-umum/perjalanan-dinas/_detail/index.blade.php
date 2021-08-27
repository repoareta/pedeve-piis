<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-plus-1 text-primary"></i>
        </span>
        <h3 class="card-label">
            Detail Panjar Dinas
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <div class="">
                <a href="{{ route('modul_umum.perjalanan_dinas.detail.create', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#">
                    <span data-toggle="tooltip" data-placement="top" id="editRow" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning"></i>
                    </span>
                </a>
                <a href="#">
                    <span data-toggle="tooltip" data-placement="top" id="deleteRow" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xl-12">
            <table class="table table-hover table-checkable" id="kt_table">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>NO</th>
                        <th>NOPEK</th>
                        <th>NAMA</th>
                        <th>GOL</th>
                        <th>JABATAN</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>        
</div>

@push('detail-scripts')
<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.perjalanan_dinas.detail.index.json', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}").load(function() {
			var rowCount = table.rows().count();
			$('#no_urut').val(rowCount + 1);
		});
	}

    $(document).ready(function () {
        var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: "{{ route('modul_umum.perjalanan_dinas.detail.index.json', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}",
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no', name: 'no'},
				{data: 'nopek', name: 'nopek'},
				{data: 'nama', name: 'nama'},
				{data: 'golongan', name: 'golongan'},
				{data: 'jabatan', name: 'jabatan'},
				{data: 'keterangan', name: 'keterangan'}
			],
			order: [[ 0, "asc" ], [ 1, "asc" ]]
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var no_nopek = $(this).val();
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
						text: "Nopek : " + no_nopek,
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.perjalanan_dinas.detail.delete', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"no_nopek": no_nopek,
									"no_panjar": "{{ $panjar_header->no_panjar }}",
									"session": false,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title: 'Hapus detail Panjar',
										text : 'Berhasil',
										timer: 2000
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
				swalAlertInit('hapus');
			}
		});
    });
</script>    
@endpush