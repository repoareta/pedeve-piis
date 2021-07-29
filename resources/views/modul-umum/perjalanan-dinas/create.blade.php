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
                Tambah Panjar Dinas
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
                <form class="form" id="formPanjarDinas" action="{{ route('modul_umum.perjalanan_dinas.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No. SPD</label>
						<div class="col-5">
							<input class="form-control" type="text" name="no_spd" value="{{ $no_spd }}" id="no_spd" readonly>
						</div>

						<label for="" class="col-2 col-form-label">Tanggal Panjar</label>
						<div class="col-3">
							<input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('d-m-Y') }}">
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
						<label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
						<div class="col-5">
							<select class="form-control select2" name="jabatan" id="jabatan" readonly>
								<option value="">- Pilih Jabatan -</option>
								@foreach ($jabatan_list as $jabatan)
									<option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
								@endforeach
							</select>
							<div id="jabatan-nya"></div>
						</div>

						<label for="example-email-input" class="col-2 col-form-label">Golongan</label>
						<div class="col-3">
							<input class="form-control" type="text" name="golongan" id="golongan">
						</div>
					</div>
					<div class="form-group row">
						<label for="id-pekerja;-input" class="col-2 col-form-label">KTP/Passport</label>
						<div class="col-10">
							<input class="form-control" type="text" name="ktp" id="ktp" value="-">
						</div>
					</div>
					<div class="form-group row">
						<label for="jenis-dinas-input" class="col-2 col-form-label">Jenis Dinas</label>
						<div class="col-10">
							<select class="form-control select2" name="jenis_dinas" id="jenis_dinas">
								<option value="DN">PDN-DN</option>
								<option value="LN">PDN-LN</option>
								<option value="SIJ">SIJ</option>
								<option value="CUTI">CUTI</option>
							</select>
							<div id="jenis_dinas-nya"></div>
						</div>
					</div>
					<div class="form-group row">
						<label for="dari-input" class="col-2 col-form-label">Dari/Asal</label>
						<div class="col-10">
							<input class="form-control" type="text" name="dari" id="dari">
						</div>
					</div>
					<div class="form-group row">
						<label for="tujuan-input" class="col-2 col-form-label">Tujuan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="tujuan" id="tujuan">
						</div>
					</div>
					<div class="form-group row">
						<label for="mulai-input" class="col-2 col-form-label">Mulai</label>
						<div class="col-10">
							<div class="input-daterange input-group" id="date_range_picker">
								<input type="text" class="form-control" name="mulai" autocomplete="off" value="{{ date('d-m-Y') }}" />
								<div class="input-group-append">
									<span class="input-group-text">Sampai</span>
								</div>
								<input type="text" class="form-control" name="sampai" autocomplete="off" value="{{ date('d-m-Y') }}" />
							</div>
							<span class="form-text text-muted">Pilih rentang waktu mulai dan sampai</span>
						</div>
					</div>

					<div class="form-group row">
						<label for="kendaraan" class="col-2 col-form-label">Kendaraan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kendaraan" id="kendaraan">
						</div>
					</div>

					<div class="form-group row">
						<label for="biaya" class="col-2 col-form-label">Biaya</label>
						<div class="col-10">
							<select class="form-control select2" name="biaya" id="biaya">
								<option value="P">Ditanggung Perusahaan</option>
								<option value="K">Ditanggung Pribadi</option>
								<option value="U">Ditanggung PPU</option>
							</select>
							<div id="biaya-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="keterangan" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<textarea class="form-control" name="keterangan" id="keterangan"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="jumlah" class="col-2 col-form-label">Jumlah</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="jumlah" id="jumlah" value="0,00" maxlength="22">
						</div>
					</div>

					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
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
                    <a href="#">
                        <span class="fa-disabled" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas icon-2x fa-plus-circle text-dark"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span class="fa-disabled" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                            <i class="fas icon-2x fa-edit text-dark"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span class="text-dark fa-disabled" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                            <i class="fas icon-2x fa-times-circle text-dark"></i>
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
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasStore', '#formPanjarDinas'); !!}
<script>
    $(document).ready(function () {

        

        // range picker
		$('#date_range_picker').datepicker({
			todayHighlight: true,
			// autoclose: true,
			// language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

        $("#formPanjarDinas").on('submit', function(e){

            e.preventDefault();

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
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Ya, Simpan Panjar',
                cancelButtonText: 'Tidak'
            })
            .then((result) => {
                if (result.value) {
                    $(this).append('<input type="hidden" name="url" value="edit" />');
                    $(this).unbind('submit').submit();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    $(this).append('<input type="hidden" name="url" value="modul_umum.perjalanan_dinas.index" />');
                    $(this).unbind('submit').submit();
                }
            });
            }
        });
    });
    
</script>
@endpush
