<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Dokumen Perkara
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="#" id="addRowDokumen">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#" id="deleteRowDokumen">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dokumen">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>Nama Dokumen</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade" id="dokumenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_modal_jabatan" data-state="add">Tambah Dokumen Perkara</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form id="form-create-dokumen" enctype="multipart/form-data">
                @csrf
				@foreach($data_list as $data)
					<input class="form-control" type="hidden" value="{{$data->no_perkara}}"  name="no_perkara">
				@endforeach
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="col-3 col-form-label">Dokumen Perkara</label>
						<div class="col-9">
							<div class="input-group control-group after-add-more">
                                <input type="file" name="filedok[]" class="form-control" title="Dokumen" accept=".pdf,.jpg,.jpeg">
                                <div class="input-group-append">
                                    <button class="btn btn-primary add-more" type="button"><i class="fas fa-plus"></i> Tambah</button>
                                </div>
							</div>
							@if(count($errors) > 0)
								@foreach ($errors->all() as $error)
								<span class="text-danger">Frotmat harus pdf, jpeg, jpg dan png</span>
								@endforeach
							@else
								<span>Frotmat file pdf, jpeg, jpg dan png</span>
							@endif
						</div>
					</div>
					<div style="display:none;">
						<div class="copy hide">
                            <div class="input-group control-group my-2">
                                <input type="file" name="filedok[]" class="form-control" title="Dokumen" accept=".pdf,.jpg,.jpeg">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove" type="button"><i class="fas fa-minus"></i> Hapus</button>
                                </div>
							</div>
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
{!! JsValidator::formRequest('App\Http\Requests\DetailDokumenStoreRequest', '#form-create-dokumen'); !!}

<script>
    $(document).ready(function () {
		var t = $('#dokumen').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax: "{{ route('modul_cm.data_perkara.search.dokumen', ['no_perkara' => $data->no_perkara]) }}",
			columns: [
				{data: 'radio', name: 'radio'},
				{data: 'file', name: 'file'},
				{data: 'nama', name: 'nama'},
			]
		});
		$('#dokumen tbody').on( 'click', 'tr', function (event) {
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
		$('#reload-dokumen').click(function(e) {
			e.preventDefault();
			t.ajax.reload();
		});
		$('.kt-select2').select2().on('change', function() {
			$(this).valid();
		});
		$(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
		});
		$("body").on("click",".remove",function(){ 
			$(this).parents(".control-group").remove();
		});
		$('#addRowDokumen').click(function(e) {
			e.preventDefault();
			$('#form-create-dokumen').trigger('reset');
			$('#cek').trigger('reset');
			$('#cek').val('B');
			$('#dokumenModal').modal('show');
			$('#title_modal_jabatan').data('state', 'add');
		});
		$('#form-create-dokumen').submit(function(){
			let formData = new FormData($('#form-create-dokumen')[0]);
			let file = $('input[type=file]')[0].files[0];
			formData.append('file', file, file.name);
			$.ajax({
				url  : "{{route('modul_cm.data_perkara.store.dokumen')}}",
				type : "POST",
				data : formData,
				dataType : "JSON",  
				cache: false,
				contentType: false,
				processData: false,
				success : function(data){
						Swal.fire({
							icon  : 'success',
							title: "Berhasil di tambah",
							text : 'Success',
						});
						$('#dokumenModal').modal('toggle');
						// clear form
						$('#dokumenModal').on('hidden.bs.modal', function () {
							$('#status_dokumen').trigger('reset');
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
		$("#status_dokumen").on("change", function(){
			var status = $('#status_dokumen').val();
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
		$('#editRowDokumen').click(function(e) {
		e.preventDefault();
			if($('input[name=btn-radio]').is(':checked')) { 
				$("input[name=btn-radio]:checked").each(function() {
					// get value from row					
					var kd = $(this).attr('data-id');
					$('#cek').trigger('reset');
					$('#cek').val('A');
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
							$('#status_dokumen').val(data.status).trigger('change');
							var status = $('#status_dokumen').val();
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
							$('#dokumenModal').modal('show');
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
		$('#deleteRowDokumen').click(function(e) {
			e.preventDefault();
			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function() {
					var kd_dok = $(this).attr('data-id');
					var filed= $(this).attr('file-id');
					var noperkara= $(this).attr('no-perkara');
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
							text: "Dengan Kode : " + kd_dok,
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_cm.data_perkara.delete.dokumen') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"kd_dok": kd_dok,
									"filed": filed,
									"noperkara": noperkara,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Hapus Kode ' + kd_dok,
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