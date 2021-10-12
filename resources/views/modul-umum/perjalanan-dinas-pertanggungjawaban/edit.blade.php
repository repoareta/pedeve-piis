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
                Ubah Pertanggungjawaban Panjar Dinas
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
                <form class="form" id="formPPanjarDinas" action="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.update', [
					'no_ppanjar' => str_replace(
						'/',
						'-',
						$ppanjar_header->no_ppanjar
					)]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No. PJ Panjar</label>
						<div class="col-5">
							<input class="form-control" type="text" readonly name="no_pj_panjar" value="{{ $ppanjar_header->no_ppanjar }}" id="no_pj_panjar">
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
									<option value="{{ $panjar_header->no_panjar }}" @if($panjar_header->no_panjar == $ppanjar_header->no_panjar)
                                        selected
                                    @endif>{{ $panjar_header->no_panjar }}</option>
								@endforeach
							</select>
							<div id="no_panjar-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Keterangan</label>
						<div class="col-3">
							<input class="form-control" type="text" readonly name="keterangan" id="keterangan" value="{{ $ppanjar_header->keterangan }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="nopek-input" class="col-2 col-form-label">Nopek</label>
						<div class="col-10">
							<select class="form-control select2" id="nopek" name="nopek">
								<option value="">- Pilih Nopek -</option>
								@foreach ($pegawai_list as $pegawai)
								<option value="{{ $pegawai->nopeg }}" @if($pegawai->nopeg == $ppanjar_header->nopek)
                                    selected
                                @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
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
									<option value="{{ $jabatan->keterangan }}" @if($jabatan->keterangan == $ppanjar_header->pangkat)
                                        selected
                                    @endif>{{ $jabatan->keterangan }}</option>
								@endforeach
							</select>
							<div id="jabatan-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Golongan</label>
						<div class="col-3">
							<input class="form-control" type="text" readonly name="golongan" id="golongan" value="{{ $ppanjar_header->gol }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="jumlah" class="col-2 col-form-label">Jumlah Panjar Dinas</label>
						<div class="col-5">
							<input class="form-control money" type="text" readonly name="jumlah" id="jumlah" data-jumlah="{{ float_two($ppanjar_header->panjar_header->jum_panjar) }}" value="{{ float_two($ppanjar_header->jmlpanjar) }}">
						</div>

						<label for="" class="col-2 col-form-label">Jumlah Panjar Detail</label>
						<div class="col-3">
							<input class="form-control money" type="text" readonly name="jumlah_detail" id="jumlah_detail" value="{{ float_two($ppanjar_detail_total) }}">
						</div>
					</div>

					<div class="form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>

    @include('modul-umum.perjalanan-dinas-pertanggungjawaban._detail.index')
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PPerjalananDinasUpdate', '#formPPanjarDinas') !!}
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
				$(this).unbind('submit').submit();
			}
		});
	});
</script>

@stack('detail-scripts')
@endpush
