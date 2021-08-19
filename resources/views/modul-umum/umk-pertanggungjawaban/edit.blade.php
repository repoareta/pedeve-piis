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
                <label for="spd-input" class="col-2 col-form-label">No. PUMK</label>
                <div class="col-5">
                    <input class="form-control disabled bg-secondary" type="text" name="no_pumk" value="{{ str_replace('-', '/', $pumk_header->no_pumk) }}" id="no_pumk" readonly>
                </div>

                <label for="spd-input" class="col-2 col-form-label">Tanggal PUMK</label>
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
                <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                <div class="col-5">
                    <select class="form-control kt-select2" name="jabatan" id="jabatan">
                        <option value="">- Pilih Jabatan -</option>
                        @foreach ($jabatan_list as $jabatan)
                            <option value="{{ $jabatan->keterangan }}" {{ $pegawai_jabatan->kdjab == $jabatan->kdjab ? 'selected' : null }}>{{ $jabatan->keterangan }}</option>
                        @endforeach
                    </select>
                    <div id="jabatan-nya"></div>
                </div>

                <label for="example-email-input" class="col-2 col-form-label">Golongan</label>
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
                        <a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
						<i class="fas fa-2x fa-plus-circle text-success" id="openDetail"></i>
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
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_modal" data-state="add">Tambah Detail Pertanggungjawaban Panjar Dinas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="kt-form kt-form--label-right" action="" method="POST" id="formPUmkDetail">
				<div class="modal-body">
					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" name="no_urut" id="no_urut" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea class="form-control" name="keterangan_detail" id="keterangan_detail"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Account</label>
						<div class="col-10">
							<select class="form-control kt-select2" id="account_detail" name="account_detail" style="width: 100% !important;">
								<option value="">- Pilih Account -</option>
								@foreach ($account_list as $account)
									<option value="{{ $account->kodeacct.'-'.$account->descacct }}">{{$account->kodeacct}} - {{$account->descacct}}</option>
								@endforeach
							</select>
							<div id="account_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Kode Bagian</label>
						<div class="col-10">
							<select class="form-control kt-select2" id="kode_bagian_detail" name="kode_bagian_detail" style="width: 100% !important;">
								<option value="">- Pilih Kode Bagian -</option>
								@foreach ($bagian_list as $bagian)
									<option value="{{ $bagian->kode.'-'.$bagian->nama }}">{{ $bagian->kode.' - '.$bagian->nama }}</option>
								@endforeach
							</select>
							<div id="kode_bagian_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input class="form-control" type="text" name="perintah_kerja_detail" id="perintah_kerja_detail" value="000">
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div class="col-10">
							<select class="form-control kt-select2" id="jenis_biaya_detail" name="jenis_biaya_detail" style="width: 100% !important;">
								<option value="">- Pilih Jenis Biaya -</option>
								@foreach ($jenis_biaya_list as $jenis_biaya)
									<option value="{{ $jenis_biaya->kode.'-'.$jenis_biaya->keterangan }}">{{ $jenis_biaya->kode.' - '.$jenis_biaya->keterangan }}</option>
								@endforeach
							</select>
							<div id="jenis_biaya_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">C.Judex</label>
						<div class="col-10">
							<select class="form-control kt-select2" id="c_judex_detail" name="c_judex_detail" style="width: 100% !important;">
								<option value="">- Pilih C Judex -</option>
								@foreach ($c_judex_list as $c_judex)
									<option value="{{ $c_judex->kode.'-'.$c_judex->nama }}">{{ $c_judex->kode.' - '.$c_judex->nama }}</option>
								@endforeach
							</select>
							<div id="c_judex_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Jumlah</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="jumlah_detail" id="jumlah_detail">
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

<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.index.json', ['no_pumk' => str_replace('/', '-', $pumk_header->no_pumk)]) }}").load(function() {
			// Callback loads updated row count into a DOM element
			// (a Bootstrap badge on a menu item in this case):
			var rowCount = table.rows().count();
			$('#no_urut').val(rowCount + 1);
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
	
		$('#openDetail').click(function(e) {
			e.preventDefault();
			refreshTable();
			$('#kt_modal_4').modal('show');
			$('#title_modal').data('state', 'add');
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
			var jumlah = $('#jumlah').data('jumlah');
			var jumlah_detail = $('#jumlah_detail_pumk').val();
			var selisih = jumlah - jumlah_detail;
			$('#jumlah').val(selisih.toFixed(2));
		});
		$("#formPPUmk").on('submit', function(){
			if ($('#no_umk-error').length){
				$("#no_umk-error").insertAfter("#no_umk-nya");
			}
			if ($('#nopek-error').length){
				$("#nopek-error").insertAfter("#nopek-nya");
			}
			if ($('#jabatan-error').length){
				$("#jabatan-error").insertAfter("#jabatan-nya");
			}
		});
		$("#formPUmkDetail").on('submit', function(){
			if ($('#account_detail-error').length){
				$("#account_detail-error").insertAfter("#account_detail-nya");
			}
			if ($('#kode_bagian_detail-error').length){
				$("#kode_bagian_detail-error").insertAfter("#kode_bagian_detail-nya");
			}
			if ($('#jenis_biaya_detail-error').length){
				$("#jenis_biaya_detail-error").insertAfter("#jenis_biaya_detail-nya");
			}
			if ($('#c_judex_detail-error').length){
				$("#c_judex_detail-error").insertAfter("#c_judex_detail-nya");
			}
			if($(this).valid()) {
				// do your ajax stuff here
				var no = $('#no_urut').val();
				var no_urut = $('#no_urut').data('no_urut');
				var keterangan = $('#keterangan_detail').val();
				var account = $('#account_detail').val().split('-')[0];
				var account_nama = $('#account_detail').val().split('-')[1];
				var kode_bagian = $('#kode_bagian_detail').val().split('-')[0];
				var kode_bagian_nama = $('#kode_bagian_detail').val().split('-')[1];
				var jenis_biaya = $('#jenis_biaya_detail').val().split('-')[0];
				var jenis_biaya_nama = $('#jenis_biaya_detail').val().split('-')[1];
				var c_judex = $('#c_judex_detail').val().split('-')[0];
				var c_judex_nama = $('#c_judex_detail').val().split('-')[1];
				var perintah_kerja = $('#perintah_kerja_detail').val();
				var jumlah = $('#jumlah_detail').val();
				var state = $('#title_modal').data('state');
				var url, session, swal_title;
				if(state == 'add'){
					url = "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.store') }}";
					session = false;
					swal_title = "Tambah Detail Pertanggungjawaban UMK";
				} else {
					url = "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.update') }}";
					session = false;
					swal_title = "Update Detail Pertanggungjawaban UMK";
				}
				$.ajax({
					url: url,
					type: "POST",
					data: {
						no          : no,
						no_urut     : no_urut,
						no_pumk     : "{{ $pumk_header->no_pumk }}",
						keterangan  : keterangan,
						account     : account,
						account_nama: account_nama,
						bagian      : kode_bagian,
						bagian_nama : kode_bagian_nama,
						pk          : perintah_kerja,
						jb          : jenis_biaya,
						jb_nama     : jenis_biaya_nama,
						cj          : c_judex,
						cj_nama     : c_judex_nama,
						nilai       : jumlah,
						session     : session,
						_token:"{{ csrf_token() }}"		
					},
					success: function(dataResult){
						Swal.fire({
							type : 'success',
							title: swal_title,
							text : 'Berhasil',
							timer: 2000
						});
						// close modal
						$('#kt_modal_4').modal('toggle');
						// clear form
						$('#kt_modal_4').on('hidden.bs.modal', function () {
							$(this).find('form').trigger('reset');
							$('#account_detail').val('').trigger('change');
							$('#kode_bagian_detail').val('').trigger('change');
							$('#jenis_biaya_detail').val('').trigger('change');
							$('#c_judex_detail').val('').trigger('change');
						});
						// append to datatable
						t.ajax.reload();
					},
					error: function () {
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
			return false;
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
		$('#editRow').click(function(e) {
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
							$('#no_urut').val(response.no);
							$('#keterangan_detail').val(response.keterangan);
							$('#perintah_kerja_detail').val(response.pk);
							$('#jumlah_detail').val(parseFloat(response.nilai).toFixed(2));
							$('#account_detail').val(response.account + '-' + response.account_nama).trigger('change');
							$('#kode_bagian_detail').val(response.bagian + '-' + response.bagian_nama).trigger('change');
							$('#jenis_biaya_detail').val(response.jb + '-' + response.jb_nama).trigger('change');
							$('#c_judex_detail').val(response.cj + '-' + response.cj_nama).trigger('change');
							// title
							$('#title_modal').text('Ubah Detail Pertanggungjawaban UMK');
							$('#title_modal').data('state', 'update');
							$('#no_urut').data('no_urut', response.no);
							// open modal
							$('#kt_modal_4').modal('toggle');
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