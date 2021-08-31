@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Pertanggungjawaban Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.update', ['no_pumk' => str_replace('/', '-', $pumk_header->no_pumk)]) }}" method="post" id="form-edit">
            @csrf

            <div class="form-group row">
                <label for="" class="col-2 col-form-label">No. PUMK</label>
                <div class="col-5">
                    <input class="form-control disabled bg-secondary" type="text" name="no_pumk" value="{{ str_replace('-', '/', $pumk_header->no_pumk) }}" id="no_pumk" readonly>
                </div>

                <label for="" class="col-2 col-form-label">Tanggal PUMK</label>
                <div class="col-3">
                    <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="no_umk" class="col-2 col-form-label">No. UMK</label>
                <div class="col-10">
                    <select class="form-control kt-select2" id="no_umk" name="no_umk">
                        <option value="">- Pilih No. UMK -</option>
                        @foreach ($umk_header_list as $umk)
                        <option value="{{ $umk->no_umk }}" {{ $pumk_header->no_umk == $umk->no_umk ? 'selected' : null }}>{{ $umk->no_umk }}</option>
                        @endforeach
                    </select>
                    <div id="no_umk-nya"></div>
                </div>
            </div>
            

            <div class="form-group row">
                <label for="nopek-input" class="col-2 col-form-label">Nopek</label>
                <div class="col-10">
                    <select class="form-control kt-select2" name="nopek">
                        <option value="">- Pilih Nopek -</option>
                        @foreach ($pegawai_list as $pegawai)
                        <option value="{{ $pegawai->nopeg }}" {{ $pumk_header->nopek == $pegawai->nopeg ? 'selected' : null }}>{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                        @endforeach
                    </select>
                    <div id="nopek-nya"></div>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Jabatan</label>
                <div class="col-5">
                    <select class="form-control kt-select2" name="jabatan" id="jabatan">
                        <option value="">- Pilih Jabatan -</option>
                        @foreach ($jabatan_list as $jabatan)
                            <option value="{{ $jabatan->keterangan }}" {{ $pegawai_jabatan->kdjab == $jabatan->kdjab ? 'selected' : null }}>{{ $jabatan->keterangan }}</option>
                        @endforeach
                    </select>
                    <div id="jabatan-nya"></div>
                </div>

                <label for="" class="col-2 col-form-label">Golongan</label>
                <div class="col-3">
                    <input class="form-control" type="text" name="golongan" id="golongan" value="{{ $pegawai_jabatan->goljob }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="jumlah" class="col-2 col-form-label">Keterangan</label>
                <div class="col-10">
                    <input class="form-control" type="text" name="keterangan" id="keterangan" value="{{ $pumk_header->keterangan }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="jumlah" class="col-2 col-form-label">Jumlah Header PUMK</label>
                <div class="col-5">
                    <input class="form-control money disabled bg-secondary" type="text" name="jumlah" id="jumlah" data-jumlah="{{ $pumk_header->umk_header->jumlah }}" value="0.00" readonly>
                </div>

                <label for="jumlah_detail" class="col-2 col-form-label">Jumlah Detail PUMK</label>
                <div class="col-3">
                    <input class="form-control money disabled bg-secondary" type="text" name="jumlah_detail_pumk" id="jumlah_detail_pumk" readonly>
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Pertanggungjawaban Uang Muka Kerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="#">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success" id="btn-create-detail"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="btn-edit-detail"></i>
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

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Account</th>
                    <th>CJ</th>
                    <th>JB</th>
                    <th>Bagian</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>

<!--begin::Modal-->
<div class="modal fade modal-create-detail-pumk" id="modal-create-detail-pumk"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Tambah Detail Pertanggungjawaban Uang Muka Kerja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<form  class="kt-form " id="form-tambah-pumk-detail"  enctype="multipart/form-data">
				<div class="modal-body">
					@csrf
                    <input  class="form-control" hidden type="text" value="{{ $pumk_header->no_pumk }}" name="no_pumk">
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" name="no_urut" id="no_urut" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value="" id="keterangan-create" name="keterangan" required>-</textarea>
						</div>
					</div>
                    		
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div  class="col-10" >
							<select class="cariaccount form-control select2" style="width: 100% !important;" name="account">
                                <option value="">-Pilih-</option>
                                @foreach($account_list as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-10">
							<select class="caribagian form-control select2" style="width: 100% !important;" name="bagian">
                                <option value="">-Pilih-</option>
                                @foreach($bagian_list as $row)
								<option value="{{ $row->kode }}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input  class="form-control" type="text" value="000"  name="pk" size="6" maxlength="6" autocomplete='off'>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-10">
							<select class="carijb form-control select2" style="width: 100% !important;" name="jb">
                                <option value="">-Pilih-</option>
                                @foreach($jenis_biaya_list as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-10">
							<select class="caricj form-control select2" style="width: 100% !important;" name="cj">
                                <option value="">-Pilih-</option>
                                @foreach($c_judex_list as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah <span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control money" type="text" value="" name="nilai" required autocomplete='off'>
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

<div class="modal fade modal-edit-detail-pumk" id="modal-edit-detail-pumk"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Edit Detail Pertanggungjawaban Uang Muka Kerja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<form  class="kt-form " id="form-edit-pumk-detail"  enctype="multipart/form-data">
				<div class="modal-body">
					@csrf
                    <input  class="form-control" hidden type="text" value="{{ $pumk_header->no_pumk }}" name="no_pumk">
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" name="no_urut" id="no_urut_edit" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value="" id="keterangan_edit" name="keterangan" required>-</textarea>
						</div>
					</div>
                    		
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div  class="col-10" >
							<select class="cariaccount form-control select2" style="width: 100% !important;" name="account" id="account_edit">
                                <option value="">-Pilih-</option>
                                @foreach($account_list as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-10">
							<select class="caribagian form-control select2" style="width: 100% !important;" name="bagian" id="bagian_edit">
                                <option value="">-Pilih-</option>
                                @foreach($bagian_list as $row)
								<option value="{{ $row->kode }}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input  class="form-control" type="text" value="000"  name="pk" size="6" maxlength="6" autocomplete='off' id="pk_edit">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-10">
							<select class="carijb form-control select2" style="width: 100% !important;" name="jb" id="jb_edit">
                                <option value="">-Pilih-</option>
                                @foreach($jenis_biaya_list as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-10">
							<select class="caricj form-control select2" style="width: 100% !important;" name="cj" id="cj_edit">
                                <option value="">-Pilih-</option>
                                @foreach($c_judex_list as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah <span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control money" type="text" value="" name="nilai" required autocomplete='off' id="nilai_edit">
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

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PUMKUpdateRequest', '#form-edit'); !!}
{!! JsValidator::formRequest('App\Http\Requests\PUMKDetailStoreRequest', '#form-tambah-pumk-detail'); !!}
{!! JsValidator::formRequest('App\Http\Requests\PUMKDetailStoreRequest', '#form-edit-pumk-detail'); !!}

<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.index.json', ['no_pumk' => str_replace('/', '-', $pumk_header->no_pumk)]) }}").load(function() {
			// Callback loads updated row count into a DOM element
			// (a Bootstrap badge on a menu item in this case):
		});
	}
	$(document).ready(function () {
		$('.kt-select2').select2().on('change', function() {
			$(this).valid();
		});
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.index.json', ['no_pumk' => str_replace('/', '-', $pumk_header->no_pumk)]) }}",
			columns: [
				{data: 'radio', name: 'radio', orderable: false, searchable: false, class:'radio-button'},
				{data: 'no', name: 'no'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'account', name: 'account'},
				{data: 'cj', name: 'cj'},
				{data: 'jb', name: 'jb'},
				{data: 'bagian', name: 'bagian'},
				{data: 'nilai', name: 'nilai', class:'text-right'},
				{data: 'total', name: 'total', class:'no-wrap text-right', visible: false},
			],
			drawCallback: function () {
				var sum = $('#kt_table').DataTable().column(8).data().sum();
				$('#jumlah_detail_pumk').val(sum.toFixed(2)).trigger("change");
			},
			order: [[ 0, "asc" ], [ 1, "asc" ]]
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'yyyy-mm-dd'
		});

		$("#jumlah_detail_pumk, #jumlah").on('change', function(e){
			var jumlah = parseInt($('#jumlah').data('jumlah'));
			var jumlah_detail = parseInt($('#jumlah_detail_pumk').val().replaceAll(',', ''));
			var selisih = jumlah - jumlah_detail;
			$('#jumlah').val(selisih.toFixed(2));
		});

		$('#btn-create-detail').on('click', function(e) {
			e.preventDefault();
			var rowCount = t.rows().count();
			$('#no_urut').val(rowCount + 1);
			$('#title-detail').html("Tambah Detail Uang Muka Kerja");
			$('#modal-create-detail-pumk').modal('show');
		});

		$('#form-tambah-pumk-detail').submit(function(e) {
			e.preventDefault();

			if($(this).valid()) {
				$.ajax({
					url  : "{{route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.store')}}",
					type : "POST",
					data : $('#form-tambah-pumk-detail').serialize(),
					dataType : "JSON",
					headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
					},
					success : function(data){
						Swal.fire({
							icon : 'success',
							title : 'Data Detail UMK Berhasil Ditambah',
							text : 'Berhasil',
							timer : 2000
						}).then(function() {
							t.ajax.reload();
							$('#modal-create-detail-pumk').modal('toggle');
							$('#form-tambah-pumk-detail').trigger('reset');
						});
					}, 
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		$('#form-edit-pumk-detail').submit(function(e) {
			e.preventDefault();

			if($(this).valid()) {
				$.ajax({
					url  : "{{route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.update')}}",
					type : "POST",
					data : $('#form-edit-pumk-detail').serialize(),
					dataType : "JSON",
					headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
					},
					success : function(data){
						Swal.fire({
							icon : 'success',
							title : 'Data Detail UMK Berhasil Diubah',
							text : 'Berhasil',
							timer : 2000
						}).then(function() {
							t.ajax.reload();
							$('#modal-edit-detail-pumk').modal('toggle');
							$('#form-edit-pumk-detail').trigger('reset');
						});
					}, 
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var no = $(this).val().split('-')[0];
					var no_pumk = $(this).val().split('-')[1];
					
					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary',
						cancelButton: 'btn btn-danger'
					},
						buttonsStyling: false
					})
					swalWithBootstrapButtons.fire({
						title: "Data yang akan dihapus?",
						text: "No : " + no,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"no": no,
									"no_pumk": "{{ $pumk_header->no_pumk }}",
									"session": false,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : 'Hapus Detail Pertanggungjawaban UMK ' + no,
										text  : 'Berhasil',
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
				swalAlertInit('hapus');
			}
		});

		$('#btn-edit-detail').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					// get value from row					
					var no_urut = $(this).val().split('-')[0];
					var no_pumk = $(this).val().split('-')[1];
					var url = "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.show.json') }}";
					$.ajax({
						url: url,
						type: 'GET',
						data: {
							"no_urut": no_urut,
							"no_pumk": no_pumk,
							"session": false,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							// update stuff
							// append value
							$('#no_urut_edit').val(response.no);
							$('#keterangan_edit').val(response.keterangan);
							$('#account_edit').val(response.account).trigger('change');
							$('#pk_edit').val(response.pk);
							$('#bagian_edit').val(response.bagian).trigger('change');
							$('#jb_edit').val(response.jb).trigger('change');
							$('#cj_edit').val(response.cj).trigger('change');
							$('#nilai_edit').val(parseFloat(response.nilai).toFixed(2));
							$('#no_urut_edit').data('no_urut', response.no);
							// open modal
							$('#modal-edit-detail-pumk').modal('toggle');
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
	});
</script>
@endpush