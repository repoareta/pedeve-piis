@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Panjar Dinas</div>
                    </div>
                </div>
                <form class="form" id="formPanjarDinas" action="{{ route('modul_umum.perjalanan_dinas.update', ['no_panjar' => Request::segment(4)]) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No. SPD</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="no_spd" value="{{ $panjar_header->no_panjar }}" id="no_spd">
                        </div>
    
                        <label for="" class="col-2 col-form-label">Tanggal Panjar</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('d-m-Y', strtotime($panjar_header->tgl_panjar)) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nopek-input" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" id="nopek" name="nopek">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                <option value="{{ $pegawai->nopeg }}" @if($pegawai->nopeg == $panjar_header->nopek)
                                    selected
                                @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek-nya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-5">
                            <select class="form-control select2" style="width: 100% !important;" name="jabatan" id="jabatan">
                                <option value="">- Pilih Jabatan -</option>
                                @foreach ($jabatan_list as $jabatan)
                                    <option value="{{ $jabatan->keterangan }}" @if($jabatan->keterangan == $panjar_header->jabatan)
                                        selected
                                    @endif>{{ $jabatan->keterangan }}</option>
                                @endforeach
                            </select>
                            <div id="jabatan-nya"></div>
                        </div>
    
                        <label for="example-email-input" class="col-2 col-form-label">Golongan</label>
                        <div class="col-3">
                            <input class="form-control" type="text" readonly name="golongan" id="golongan" value="{{ $panjar_header->gol }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id-pekerja;-input" class="col-2 col-form-label">KTP/Passport</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="ktp" id="ktp" value="{{ $panjar_header->ktp }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Jenis Dinas</label>
                        <div class="col-10">
                            <select class="form-control" name="jenis_dinas" id="jenis_dinas">
                                <option value="">- Pilih Jenis Dinas -</option>
                                <option value="DN" @if($panjar_header->jenis_dinas == 'DN') selected @endif>PDN-DN</option>
                                <option value="LN" @if($panjar_header->jenis_dinas == 'LN') selected @endif>PDN-LN</option>
                                <option value="SIJ" @if($panjar_header->jenis_dinas == 'SIJ') selected @endif>SIJ</option>
                                <option value="CUTI" @if($panjar_header->jenis_dinas == 'CUTI') selected @endif>CUTI</option>
                            </select>
                            <div id="jenis_dinas-nya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dari-input" class="col-2 col-form-label">Dari/Asal</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="dari" id="dari" value="{{ $panjar_header->dari }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tujuan-input" class="col-2 col-form-label">Tujuan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="tujuan" id="tujuan" value="{{ $panjar_header->tujuan }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                        <div class="col-10">
                            <div class="input-daterange input-group" id="date_range_picker">
                                <input type="text" class="form-control" name="mulai" value="{{ date('d-m-Y', strtotime($panjar_header->mulai)) }}" autocomplete="off" />
                                <div class="input-group-append">
                                    <span class="input-group-text">Sampai</span>
                                </div>
                                <input type="text" class="form-control" name="sampai" value="{{ date('d-m-Y', strtotime($panjar_header->sampai)) }}" autocomplete="off" />
                            </div>
                            <span class="form-text text-muted">Pilih rentang waktu mulai dan sampai</span>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="kendaraan" class="col-2 col-form-label">Kendaraan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="kendaraan" id="kendaraan" value="{{ $panjar_header->kendaraan }}">
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="biaya" class="col-2 col-form-label">Biaya</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="biaya" id="biaya">
                                <option value="">- Pilih Biaya -</option>
                                <option value="P" @if($panjar_header->ditanggung_oleh == 'P') selected @endif>Ditanggung Perusahaan</option>
                                <option value="K" @if($panjar_header->ditanggung_oleh == 'K') selected @endif>Ditanggung Pribadi</option>
                                <option value="U" @if($panjar_header->ditanggung_oleh == 'U') selected @endif>Ditanggung PPU</option>
                            </select>
                            <div id="biaya-nya"></div>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="keterangan" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan" id="keterangan">{{ $panjar_header->keterangan }}</textarea>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="jumlah" class="col-2 col-form-label">Jumlah</label>
                        <div class="col-10">
                            <input class="form-control money" type="text" name="jumlah" id="jumlah" value="{{ float_two($panjar_header->jum_panjar) }}">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>

<div class="card card-custom gutter-b">
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
                    <a href="#" id="openDetail">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas icon-2x fa-plus-circle text-primary"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span data-toggle="tooltip" data-placement="top" id="editRow" title="Ubah Data">
                            <i class="fas icon-2x fa-edit text-warning"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span data-toggle="tooltip" data-placement="top" id="deleteRow" title="Hapus Data">
                            <i class="fas icon-2x fa-times-circle text-danger"></i>
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
</div>

<!--begin::Modal-->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_modal" data-state="add">Tambah Detail Panjar Dinas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<form class="form" action="" method="POST" id="formPanjarDinasDetail">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No. Urut</label>
						<div class="col-10">
							<input class="form-control" type="number" name="no_urut" id="no_urut">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea class="form-control" name="keterangan_detail" id="keterangan_detail"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nopek</label>
						<div class="col-10">
							<select class="form-control select2" style="width: 100% !important;" id="nopek_detail" name="nopek_detail" style="width: 100% !important;">
								<option value="">- Pilih Nopek -</option>
								@foreach ($pegawai_list as $pegawai)
									<option value="{{ $pegawai->nopeg.'-'.$pegawai->nama }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
								@endforeach
							</select>
							<div id="nopek_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Jabatan</label>
						<div class="col-10">
							<select class="form-control select2" style="width: 100% !important;" name="jabatan_detail" readonly id="jabatan_detail" style="width: 100% !important;">
								<option value="">- Pilih Jabatan -</option>
								@foreach ($jabatan_list as $jabatan)
									<option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
								@endforeach
							</select>
							<div id="jabatan_detail-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Golongan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="golongan_detail" id="golongan_detail" readonly>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--end::Modal-->

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasUpdate', '#formPanjarDinas') !!}
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasDetailStore', '#formPanjarDinasDetail') !!}
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasDetailUpdate', '#formPanjarDinasDetail') !!}
<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.perjalanan_dinas.detail.index.json', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}").load(function() {
			// Callback loads updated row count into a DOM element
			// (a Bootstrap badge on a menu item in this case):
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
				{data: 'action', name: 'aksi', class:'radio-button text-center'},
				{data: 'no', name: 'no'},
				{data: 'nopek', name: 'nopek'},
				{data: 'nama', name: 'nama'},
				{data: 'golongan', name: 'golongan'},
				{data: 'jabatan', name: 'jabatan'},
				{data: 'keterangan', name: 'keterangan'}
			],
			order: [[ 0, "asc" ], [ 1, "asc" ]]
		});

        $('#openDetail').click(function(e) {
			e.preventDefault();
			refreshTable();
			$('#kt_modal_4').modal('show');
			$('#title_modal').data('state', 'add');
		});

        // range picker
		$('#date_range_picker').datepicker({
			todayHighlight: true,
			// autoclose: true,
			language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

        
		$("#formPanjarDinas").on('submit', function(){
			if ($('#nopek-error').length){
				$("#nopek-error").insertAfter("#nopek-nya");
			}

			if ($('#jabatan-error').length){
				$("#jabatan-error").insertAfter("#jabatan-nya");
			}

			if ($('#jenis_dinas-error').length){
				$("#jenis_dinas-error").insertAfter("#jenis_dinas-nya");
			}

			if ($('#biaya-error').length){
				$("#biaya-error").insertAfter("#biaya-nya");
			}

			if ($('#sampai-error').length){
				$("#sampai-error").addClass("float-right");
			}
		});

        $("#formPanjarDinasDetail").on('submit', function(){
			if ($('#nopek_detail-error').length){
				$("#nopek_detail-error").insertAfter("#nopek_detail-nya");
			}

			if ($('#jabatan_detail-error').length){
				$("#jabatan_detail-error").insertAfter("#jabatan_detail-nya");
			}

			if($(this).valid()) {
				// do your ajax stuff here
				var no = $('#no_urut').val();
				var keterangan = $('#keterangan_detail').val();
				var nopek = $('#nopek_detail').val().split('-')[0];
				var nama = $('#nopek_detail').val().split('-')[1];
				var jabatan = $('#jabatan_detail').val();
				var golongan = $('#golongan_detail').val();

				var state = $('#title_modal').data('state');

				var url, session, swal_title;

				if(state == 'add'){
					url = "{{ route('modul_umum.perjalanan_dinas.detail.store') }}";
					session = false;
					swal_title = "Tambah Detail Panjar";
				} else {
					url = "{{ route('modul_umum.perjalanan_dinas.detail.update', [
						'no_panjar' => str_replace('/', '-', $panjar_header->no_panjar),
						'no_urut' => ':no_urut',
						'nopek' => ':nopek'
					]) }}";
					url = url
						.replace(':no_urut', $('#no_urut').data('no_urut'))
						.replace(':nopek', $('#nopek_detail').data('nopek_detail'));
					session = false;
					swal_title = "Update Detail Panjar";
				}

				$.ajax({
					url: url,
					type: "POST",
					data: {
						no: no,
						no_panjar: "{{ $panjar_header->no_panjar }}",
						keterangan: keterangan,
						nopek: nopek,
						nama: nama,
						jabatan: jabatan,				
						golongan: golongan,
						session: session,
						_token:"{{ csrf_token() }}"
					},
					success: function(dataResult){
						swalSuccessInit(swal_title);
						// close modal
						$('#kt_modal_4').modal('toggle');
						// clear form
						$('#kt_modal_4').on('hidden.bs.modal', function () {
							$(this).find('form').trigger('reset');
							$('#nopek_detail').val('').trigger('change');
							$('#jabatan_detail').val('').trigger('change');
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
								url: "{{ route('modul_umum.perjalanan_dinas.detail.delete') }}",
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
										icon : 'success',
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

		$('#editRow').click(function(e) {
			e.preventDefault();

			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					// get value from row					
					var no_urut = $(this).val().split('-')[0];
					var no_nopek = $(this).val().split('-')[1];
					$.ajax({
						url: "{{ route('modul_umum.perjalanan_dinas.detail.show.json') }}",
						type: 'GET',
						data: {
							"no_urut": no_urut,
							"no_nopek": no_nopek,
							"no_panjar": "{{ $panjar_header->no_panjar }}",
							"session": false,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							// update stuff
							// append value
							$('#no_urut').val(response.no);
							$('#keterangan_detail').val(response.keterangan);
							$('#nopek_detail').val(response.nopek + '-' + response.nama).trigger('change');
							$('#jabatan_detail').val(response.jabatan).trigger('change');
							$('#golongan_detail').val(response.status);
							// title
							$('#title_modal').text('Ubah Detail Panjar Dinas');
							$('#title_modal').data('state', 'update');
							$('#no_urut').data('no_urut', response.no);
							$('#nopek_detail').data('nopek_detail', response.nopek);
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
