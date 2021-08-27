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
                Tambah Pertanggungjawaban Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Pertanggungjawaban Panjar Dinas</div>
                    </div>
                </div>
                <form class="form" id="formPPanjarDinas" action="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No. PJ Panjar</label>
						<div class="col-5">
							<input class="form-control" type="text" readonly name="no_pj_panjar" value="{{ $no_pspd }}" id="no_pj_panjar">
						</div>

						<label for="" class="col-2 col-form-label">Tanggal PJ Panjar</label>
						<div class="col-3">
							<input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No. Panjar</label>
						<div class="col-5">
							<select class="form-control select2" name="no_panjar" id="no_panjar">
								<option value="">- Pilih No. Panjar -</option>
								@foreach ($panjar_header_list as $panjar_header)
									<option value="{{ $panjar_header->no_panjar }}">{{ $panjar_header->no_panjar }}</option>
								@endforeach
							</select>
							<div id="no_panjar-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Keterangan</label>
						<div class="col-3">
							<input class="form-control" type="text" readonly name="keterangan" id="keterangan">
						</div>
					</div>

					<div class="form-group row">
						<label for="nopek-input" class="col-2 col-form-label">Nopek</label>
						<div class="col-10">
							<select class="form-control select2" id="nopek" name="nopek">
								<option value="">- Pilih Nopek -</option>
								@foreach ($pegawai_list as $pegawai)
								<option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
								@endforeach
							</select>
							<div id="nopek-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Jabatan</label>
						<div class="col-5">
							<select class="form-control select2" name="jabatan" id="jabatan">
								<option value="">- Pilih Jabatan -</option>
								@foreach ($jabatan_list as $jabatan)
									<option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
								@endforeach
							</select>
							<div id="jabatan-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Golongan</label>
						<div class="col-3">
							<input class="form-control" type="text" readonly name="golongan" id="golongan">
						</div>
					</div>

					<div class="form-group row">
						<label for="jumlah" class="col-2 col-form-label">Jumlah Panjar Dinas</label>
						<div class="col-5">
							<input class="form-control money" type="text" readonly name="jumlah" id="jumlah" value="0.00">
						</div>

						<label for="" class="col-2 col-form-label">Jumlah Panjar Detail</label>
						<div class="col-3">
							<input class="form-control money" type="text" readonly name="jumlah_detail" id="jumlah_detail">
						</div>
					</div>

					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
						</div>
					</div>
				</form>
            </div>
        </div>        
    </div>

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
                    <a href="#">
                        <span class="fa-disabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas fa-2x fa-plus-circle text-dark"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span class="fa-disabled" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                            <i class="fas fa-2x fa-edit text-dark"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span class="fa-disabled" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                            <i class="fas fa-2x fa-times-circle text-dark"></i>
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

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PPerjalananDinasStore', '#formPPanjarDinas') !!}

<script type="text/javascript">
	$(document).ready(function () {
        
		$("#jumlah_detail, #jumlah").on('change', function(e){
			var jumlah = $('#jumlah').val();
			var jumlah_detail = $('#jumlah_detail').val();

			var selisih = jumlah - jumlah_detail;

			$('#jumlah').val(selisih.toFixed(2));
		});

		$("#formPPanjarDinas").on('submit', function(){

			e.preventDefault();
			
			if ($('#no_panjar-error').length){
				$("#no_panjar-error").insertAfter("#no_panjar-nya");
			}

			if ($('#nopek-error').length){
				$("#nopek-error").insertAfter("#nopek-nya");
			}

			if ($('#jabatan-error').length){
				$("#jabatan-error").insertAfter("#jabatan-nya");
			}

			if($(this).valid()) {
				const swalWithBootstrapButtons = Swal.mixin({
				customClass: {
					confirmButton: 'btn btn-primary',
					cancelButton: 'btn btn-danger'
				},
					buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
					title: "Apakah anda yakin mau menyimpan data ini?",
					text: "",
					type: 'warning',
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Ya, Simpan P Panjar Dinas',
					cancelButtonText: 'Tidak'
				})
				.then((result) => {
					if (result.value) {
						$(this).append('<input type="hidden" name="url" value="edit" />');
						$(this).unbind('submit').submit();
					}
					else if (result.dismiss === Swal.DismissReason.cancel) {
						$(this).append('<input type="hidden" name="url" value="modul_umum.perjalanan_dinas.detail.index" />');
						$(this).unbind('submit').submit();
					}
				});
			}
		});
	});
</script>
@endpush
