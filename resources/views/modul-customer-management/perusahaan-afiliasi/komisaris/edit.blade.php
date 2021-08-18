@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Komisaris
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_cm.perusahaan_afiliasi.komisaris.update', 
                    [
                        'perusahaan_afiliasi' => $perusahaan_afiliasi->id,
                        'komisaris' => $komisaris->id
                    ]) }}" method="POST" id="formKomisaris">
                    @csrf
                    <div class="form-group row">
						<label for="nama_direksi" class="col-2 col-form-label">Nama</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $komisaris->nama }}">
						</div>
					</div>

					<div class="form-group row">
						<label for="tmt_dinas" class="col-2 col-form-label">TMT Dinas</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="tmt_dinas" id="tmt_dinas" autocomplete="off" style="width: 100%" value="{{ $komisaris->tmt_dinas }}">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="akhir_masa_dinas" class="col-2 col-form-label">Akhir Masa Dinas</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="akhir_masa_dinas" id="akhir_masa_dinas" autocomplete="off" style="width: 100%" value="{{ $komisaris->akhir_masa_dinas }}">
						</div>
					</div>

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_cm.perusahaan_afiliasi.edit', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\KomisarisUpdate', '#formKomisaris') !!}

<script type="text/javascript">
	$(document).ready(function () {
        // minimum setup
        $('.datepicker').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'yyyy-mm-dd'
        });
    });
</script>
@endpush
