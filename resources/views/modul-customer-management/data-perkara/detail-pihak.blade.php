<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Pihak
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="text-left">
                <a href="#" id="addRowPihak" data-toggle="modal" data-target="#pihakModal">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#" id="editRowPihak" data-toggle="modal">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" ></i>
                    </span>
                </a>
                <a href="#" id="deleteRowPihak">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table width="100%" class="table table-bordered" id="pihak">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="pihakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_modal_pihak" data-state="add"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form action="" method="POST" id="form-create" enctype="multipart/form-data">
                @csrf
				<div class="modal-body">
					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Nama</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama_pihak" size="100" maxlength="100" autocomplete='off'>
							<input class="form-control" type="hidden" name="kd_pihak" id="kd_pihak">
							<input class="form-control" type="hidden" name="cek" id="cek">
							@foreach($data_list as $data)
							<input class="form-control" type="hidden" value="{{ $data->no_perkara }}"  name="no_perkara" id="no_perkara">
							@endforeach
							<div id="bagian_pekerja-nya"></div>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Alamat</label>
						<div class="col-10">
							<textarea class="form-control" type="text"  name="alamat" id="alamat_pihak" size="100" maxlength="100" autocomplete='off'></textarea>
							<div id="jabatan_pekerja-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Telp</label>
						<div class="col-10">
							<input class="form-control" type="text" name="telp" id="telp_pihak" autocomplete='off'>
						</div>
                    </div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea class="form-control" type="text" name="keterangan" id="keterangan_pihak" autocomplete='off'></textarea>
						</div>
                    </div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Status</label>
						<div class="col-10">
							<select class="form-control select2" name="status" id="status_pihak" style="width: 100% !important;">
								<option value=""> - Pilih - </option>
								<option value="1">Penggugat</option>
								<option value="2">Tergugat</option>
								<option value="3">Turut Tergugat</option>
                               
							</select>
						</div>
					</div>                    
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i> Batal</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end::Modal-->

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#pihak').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax: "{{ route('modul_cm.data_perkara.search.pihak', ['no_perkara' => $data->no_perkara]) }}",
			columns: [
				{data: 'radio', name: 'radio'},
				{data: 'nama', name: 'nama'},
				{data: 'alamat', name: 'alamat'},
				{data: 'telp', name: 'telp'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'status', name: 'status'},
			]
		});

		$('#pihak tbody').on( 'click', 'tr', function (event) {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			} else {
				t.$('tr.selected').removeClass('selected');
				// $(':radio', this).trigger('click');
				if (event.target.type !== 'radio') {
					$(':radio', this).trigger('click');
				}
				$(this).addClass('selected');
			}
		});

		$('#reload-pihak').click(function(e) {
			e.preventDefault();
			t.ajax.reload();
		});

		$('#addRowPihak').click(function(e) {
			e.preventDefault();
			$('#form-create').trigger('reset');
			$('#cek').trigger('reset');
			$('#cek').val('B');
			$('#pihakModal').modal('show');
			$('#title_modal_pihak').text('Tambah Pihak');
			$('#title_modal_pihak').data('state', 'add');
		});
        
		$('#form-create').submit(function(){
			$.ajax({
				url  : "{{route('modul_cm.data_perkara.store.pihak')}}",
				type : "POST",
				data : $('#form-create').serialize(),
				dataType : "JSON",
				success : function(data){
					Swal.fire({
                        icon : 'success',
                        title: "Data Berhasil Ditambah",
                        text : 'Success',
                        timer: 2000
                    });
                    $('#pihakModal').modal('toggle');
                    // clear form
                    $('#pihakModal').on('hidden.bs.modal', function () {
                        $(this).find('form').trigger('reset');
                    });
                    // append to datatable
                    t.ajax.reload();
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});	
			return false;
		});
		$('#editRowPihak').click(function(e) {
		    e.preventDefault();
			if($('input[name=btn-radio]').is(':checked')) { 
				$("input[name=btn-radio]:checked").each(function() {
					// get value from row					
					var kd = $(this).val();
					$('#cek').trigger('reset');
					$('#cek').val('A');
					$('#title_modal_pihak').text('Ubah Pihak');
					$('#title_modal_pihak').data('state', 'update');
					$.ajax({
						url: "{{ route('modul_cm.data_perkara.show.pihak.json') }}",
						type: 'POST',
						dataType: 'json',
						data: {
							"kd" : kd,
							"_token": "{{ csrf_token() }}",
						},
						success: function (data) {
							$('#kd_pihak').val(data.kd_pihak);
							$('#nama_pihak').val(data.nama);
							$('#alamat_pihak').val(data.alamat);
							$('#telp_pihak').val(data.telp);
							$('#keterangan_pihak').val(data.keterangan);
							$('#no_perkara').val(data.no_perkara);
							$('#status_pihak').val(data.status).trigger('change');
							
							// open modal
							$('#pihakModal').modal('show');
						},
						error: function () {
							alert("Terjadi kesalahan, coba lagi nanti");
						}
					});
					
				});
			} else {
				swalAlertInit('ubah');
			}
		});
		//delete vendor
		$('#deleteRowPihak').click(function(e) {
			e.preventDefault();
			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function() {
					var id = $(this).val();
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
							text: "Dengan Kode : " + id,
							type: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_cm.data_perkara.delete.pihak') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Hapus Kode ' + id,
										text  : 'Berhasil',
										timer : 2000
									});
									t.ajax.reload();
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