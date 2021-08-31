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
                Tambah Pertanggungjawaban Detail Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.detail.create', [
                    'no_ppanjar' => 123
                ]) }}" method="POST" id="formPPanjarDinasDetail">
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">No. Urut</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_urut" id="no_urut">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" id="nopek" name="nopek" style="width: 100% !important;">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek_detail-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Nilai</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nilai" id="nilai">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Qty</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="qty" id="qty">
                        </div>
                    </div>

                    <div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
						</div>
					</div>
                </form>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PPerjalananDinasStore', '#formPPanjarDinas') !!}

<script type="text/javascript">
	$(document).ready(function () {

		$("#formPPanjarDinas").on('submit', function(e){
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
