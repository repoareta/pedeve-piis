@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Master Insentif
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="formMasterInsentif" action="{{ route('modul_sdm_payroll.master_insentif.update', [
					'tahun' => $insentif->tahun,
					'bulan' => $insentif->bulan,
					'nopek' => $insentif->nopek,
					'aard' => $insentif->aard
				]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Bulan</label>
						<div class="col-4">
							<select class="form-control select2" name="bulan" id="bulan">
								<option value="">- Pilih Bulan -</option>
								<option value="1" @if($insentif->bulan == '1') selected @endif>Januari</option>
								<option value="2" @if($insentif->bulan == '2') selected @endif>Februari</option>
								<option value="3" @if($insentif->bulan == '3') selected @endif>Maret</option>
								<option value="4" @if($insentif->bulan == '4') selected @endif>April</option>
								<option value="5" @if($insentif->bulan == '5') selected @endif>Mei</option>
								<option value="6" @if($insentif->bulan == '6') selected @endif>Juni</option>
								<option value="7" @if($insentif->bulan == '7') selected @endif>Juli</option>
								<option value="8" @if($insentif->bulan == '8') selected @endif>Agustus</option>
								<option value="9" @if($insentif->bulan == '9') selected @endif>September</option>
								<option value="10" @if($insentif->bulan == '10') selected @endif>Oktober</option>
								<option value="11" @if($insentif->bulan == '11') selected @endif>November</option>
								<option value="12" @if($insentif->bulan == '12') selected @endif>Desember</option>
							</select>
							<div id="bulan-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Tahun</label>
						<div class="col-4">
							<input class="form-control tahun" type="text" name="tahun" id="tahun" value="{{ $insentif->tahun }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Pegawai</label>
						<div class="col-10">
							<select class="form-control select2" name="pegawai" id="pegawai">
								<option value="">- Pilih Pegawai -</option>
								@foreach ($pegawai_list as $pegawai)
									<option value="{{ $pegawai->nopeg }}" @if($pegawai->nopeg == $insentif->nopek) selected @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama.' - '.pekerja_status($pegawai->status) }}</option>
								@endforeach
							</select>
							<div id="pegawai-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">AARD</label>
						<div class="col-10">
							<select class="form-control select2" name="aard" id="aard">
								<option value="">- Pilih AARD -</option>
								@foreach ($aard_list as $aard)
									<option value="{{ $aard->kode }}" @if($aard->kode == $insentif->aard) selected @endif>{{ $aard->kode.' - '.$aard->nama }}</option>
								@endforeach
							</select>
							<div id="aard-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Tahun Insentif</label>
						<div class="col-10">
							<input class="form-control tahun" type="text" name="tahun_insentif" id="tahun_insentif" value="{{ $insentif->tahunins }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Nilai</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="nilai" id="nilai" value="{{ $insentif->nilai }}">
						</div>
					</div>

					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\MasterInsentifUpdate', '#formMasterInsentif') !!}

<script type="text/javascript">
	$(document).ready(function () {
		$("#formMasterInsentif").on('submit', function(){
			if ($('#bulan-error').length){
				$("#bulan-error").insertAfter("#bulan-nya");
			}

			if ($('#pegawai-error').length){
				$("#pegawai-error").insertAfter("#pegawai-nya");
			}

			if ($('#aard-error').length){
				$("#aard-error").insertAfter("#aard-nya");
			}
		});
	});
</script>
@endpush
