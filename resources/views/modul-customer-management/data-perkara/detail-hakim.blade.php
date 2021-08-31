<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Kuasa Hukum
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="#" id="addRowHakim">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#" id="editRowHakim" data-toggle="modal">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" ></i>
                    </span>
                </a>
                <a href="#" id="deleteRowHakim">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="hakim">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Nama Pihak</th>
                            <th>Nama Kuasa Hukum</th>
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
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="hakimModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_modal_hakim" data-state="add"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form kt-form--label-right"  id="form-create-hakim" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nama</label>
						<div class="col-10">
							<input class="form-control" type="text"  name="nama" id="nama_hakim" size="100" maxlength="100" autocomplete='off'>
							<input class="form-control" type="hidden" value=""  name="kd_hakim" id="kd_hakim">
							<input class="form-control" type="hidden" value=""  name="cekhakim" id="cekhakim">
							@foreach($data_list as $data)
							<input class="form-control" type="hidden" value="{{$data->no_perkara}}"  name="no_perkara" id="no_perkara_hakim">
							@endforeach
						</div>
					</div>
                    
                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Alamat</label>
						<div class="col-10">
							<textarea class="form-control" type="text"  name="alamat" id="alamat_hakim" size="100" maxlength="100" autocomplete='off'></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Telp</label>
						<div class="col-10">
							<input class="form-control" type="text" name="telp" id="telp_hakim" autocomplete='off'>
						</div>
                    </div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea class="form-control" type="text" name="keterangan" id="keterangan_hakim" autocomplete='off'></textarea>
						</div>
                    </div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Status</label>
						<div class="col-10">
							<select class="form-control select2" name="status" id="status_hakim" style="width: 100% !important;" required>
								<option value=""> - Pilih - </option>
								<option value="1">Penggugat</option>
								<option value="2">Tergugat</option>
								<option value="3">Turut Tergugat</option>
							</select>
							<div id="status_hakim-nya"></div>
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Pihak</label>
						<div class="col-10">
							<select class="form-control select2" name="kd_pihak" id="pihak_hakim" style="width: 100% !important;" required>
								<option value=""> - Pilih - </option>
							</select>
							<div id="pihak_hakim-nya"></div>
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
{!! JsValidator::formRequest('App\Http\Requests\DetailKuasaHukumStoreRequest', '#form-create-hakim'); !!}

<script>
    $(document).ready(function () {
		var t = $('#hakim').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax: "{{ route('modul_cm.data_perkara.search.hakim', ['no_perkara' => $data->no_perkara]) }}",
			columns: [
				{data: 'radio', name: 'radio'},
				{data: 'nama_p', name: 'nama_p'},
				{data: 'nama', name: 'nama'},
				{data: 'alamat', name: 'alamat'},
				{data: 'telp', name: 'telp'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'status', name: 'status'},
			]
		});
		$('#hakim tbody').on( 'click', 'tr', function (event) {
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
		} );
		$('#reload-hakim').click(function(e) {
			e.preventDefault();
			t.ajax.reload();
		});
		$('.select2').select2().on('change', function() {
			$(this).valid();
		});
		$('#addRowHakim').click(function(e) {
			e.preventDefault();
			$('#form-create-hakim').trigger('reset');
			$('#cekhakim').trigger('reset');
			$('#cekhakim').val('B');
			$('#title_modal_hakim').text('Tambah Kuasa Hukum');
			$('#hakimModal').modal('show');
			$('#title_modal_hakim').data('state', 'add');
		});

		$('#form-create-hakim').submit(function(e) {
			e.preventDefault();

			if ($('#status_hakim-error').length){
				$("#status_hakim-error").insertAfter("#status_hakim-nya");
			}

			if ($('#pihak_hakim-error').length){
				$("#pihak_hakim-error").insertAfter("#pihak_hakim-nya");
			}

			if ($(this).valid()) {
				$.ajax({
					url  : "{{ route('modul_cm.data_perkara.store.hakim') }}",
					type : "POST",
					data : $('#form-create-hakim').serialize(),
					dataType : "JSON",
					headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
					},
					success : function(data){
						if(data == 1){
							Swal.fire({
								icon  : 'success',
								title: "Berhasil di ubah",
								text : 'Success',
								timer: 2000
							});
							$('#hakimModal').modal('toggle');
							// clear form
							$('#hakimModal').on('hidden.bs.modal', function () {
								$('#status_hakim').trigger('reset');
							});
							// append to datatable
							t.ajax.reload();
						}else if(data == 2){
							Swal.fire({
								icon  : 'success',
								title: "Berhasil di tambah",
								text : 'Success',
								timer: 2000
							});
							$('#hakimModal').modal('toggle');
							// clear form
							$('#hakimModal').on('hidden.bs.modal', function () {
								$('#status_hakim').trigger('reset');
							});
							// append to datatable
							t.ajax.reload();
						}
					}, 
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		$("#status_hakim").on("change", function(){
			var status = $('#status_hakim').val();
			var no_perkara = $('#no_perkara_hakim').val();
			$.ajax({
				url : "{{route('modul_cm.data_perkara.pihakJson')}}",
				type : "POST",
				dataType: 'json',
				data : {
					status:status,
					no_perkara:no_perkara
                },
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
                },
				success : function(data){
					var html = '';
					var i;
					html += '<option value="">- Pilih - </option>';
					for(i=0; i<data.length; i++){
						html += '<option value="'+data[i].kd_pihak+'">'+data[i].nama+'</option>';
					}
					$('#pihak_hakim').html(html);		
				},
				error : function(){
					alert("Ada kesalahan controller!");
				}
			})
        });
		$('#editRowHakim').click(function(e) {
		e.preventDefault();
			if($('input[name=btn-radio]').is(':checked')) { 
				$("input[name=btn-radio]:checked").each(function() {
					// get value from row					
					var kd = $(this).val();
					$('#cekhakim').trigger('reset');
					$('#cekhakim').val('A');
					$('#title_modal_hakim').text('Ubah Kuasa Hukum');
					$('#title_modal_hakim').data('state', 'update');
					$.ajax({
						url: "{{ route('modul_cm.data_perkara.show.json') }}",
						type: 'POST',
						dataType: 'json',
						data: {
							"kd" : kd,
							"_token": "{{ csrf_token() }}",
						},
						success: function (data) {
							$('#kd_hakim').val(data.kd_hakim);
							$('#nama_hakim').val(data.nama);
							$('#alamat_hakim').val(data.alamat);
							$('#telp_hakim').val(data.telp);
							$('#keterangan_hakim').val(data.keterangan);
							$('#no_perkara').val(data.no_perkara);
							$('#status_hakim').val(data.status).trigger('change');
							var status = $('#status_hakim').val();
							var no_perkara = $('#no_perkara_hakim').val();
							$.ajax({
								url : "{{route('modul_cm.data_perkara.pihakJson')}}",
								type : "POST",
								dataType: 'json',
								data : {
									status:status,
									no_perkara:no_perkara
								},
								headers: {
									'X-CSRF-Token': '{{ csrf_token() }}',
								},
								success : function(data){
									var html = '1';
									var i;
									for(i=0; i<data.length; i++){
										html += '<option value="'+data[i].kd_pihak+'">'+data[i].nama+'</option>';
									}
									$('#pihak_hakim').html(html);		
								},
								error : function(){
									alert("Ada kesalahan controller!");
								}
							})
							// open modal
							$('#hakimModal').modal('show');
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
		$('#deleteRowHakim').click(function(e) {
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
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_cm.data_perkara.delete.hakim') }}",
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