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
                Ubah Master Beban Perusahaan
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="formMasterBebanPerusahaan" action="{{ route('modul_sdm_payroll.master_beban_perusahaan.update', [
					'tahun' => $beban_perusahaan->tahun,
					'bulan' => $beban_perusahaan->bulan,
					'nopek' => $beban_perusahaan->nopek,
					'aard'  => $beban_perusahaan->aard
				]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Bulan</label>
						<div class="col-4">
							<select class="form-control select2" name="bulan" id="bulan">
								<option value="">- Pilih Bulan -</option>
								<option value="1" @if($beban_perusahaan->bulan == '1') selected @endif>Januari</option>
								<option value="2" @if($beban_perusahaan->bulan == '2') selected @endif>Februari</option>
								<option value="3" @if($beban_perusahaan->bulan == '3') selected @endif>Maret</option>
								<option value="4" @if($beban_perusahaan->bulan == '4') selected @endif>April</option>
								<option value="5" @if($beban_perusahaan->bulan == '5') selected @endif>Mei</option>
								<option value="6" @if($beban_perusahaan->bulan == '6') selected @endif>Juni</option>
								<option value="7" @if($beban_perusahaan->bulan == '7') selected @endif>Juli</option>
								<option value="8" @if($beban_perusahaan->bulan == '8') selected @endif>Agustus</option>
								<option value="9" @if($beban_perusahaan->bulan == '9') selected @endif>September</option>
								<option value="10" @if($beban_perusahaan->bulan == '10') selected @endif>Oktober</option>
								<option value="11" @if($beban_perusahaan->bulan == '11') selected @endif>November</option>
								<option value="12" @if($beban_perusahaan->bulan == '12') selected @endif>Desember</option>
							</select>
							<div id="bulan-nya"></div>
						</div>

						<label for="" class="col-2 col-form-label">Tahun</label>
						<div class="col-4">
							<input class="form-control tahun" type="text" name="tahun" id="tahun" value="{{ $beban_perusahaan->tahun }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="kode" class="col-2 col-form-label">Pegawai</label>
						<div class="col-10">
							<select class="form-control select2" name="pegawai" id="pegawai">
								<option value="">- Pilih Pegawai -</option>
								@foreach ($pegawai_list as $pegawai)
									<option value="{{ $pegawai->nopeg }}" @if($pegawai->nopeg == $beban_perusahaan->nopek) selected @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama.' - '.pekerja_status($pegawai->status) }}</option>
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
									<option value="{{ $aard->kode }}" @if($aard->kode == $beban_perusahaan->aard) selected @endif>{{ $aard->kode.' - '.$aard->nama }}</option>
								@endforeach
							</select>
							<div id="aard-nya"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Last Amount</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="last_amount" id="last_amount" value="{{ float_two($beban_perusahaan->lastamount) }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-2 col-form-label">Current Amount</label>
						<div class="col-10">
							<input class="form-control money" type="text" name="current_amount" id="current_amount" value="{{ float_two($beban_perusahaan->curramount) }}">
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
{!! JsValidator::formRequest('App\Http\Requests\MasterBebanPerusahaanUpdate', '#formMasterBebanPerusahaan') !!}

<script type="text/javascript">
	$(document).ready(function () {
		$("#formMasterBebanPerusahaan").on('submit', function(){
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
