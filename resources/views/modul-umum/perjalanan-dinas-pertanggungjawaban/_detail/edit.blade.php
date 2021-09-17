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
                Ubah Pertanggungjawaban Detail Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form" action="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.detail.update', [
                    'no_ppanjar' => $no_ppanjar,
                    'no_urut' => $ppanjar_detail->no,
                    'nopek' => $ppanjar_detail->nopek,
                ]) }}" method="POST" id="formPPanjarDinasDetail">
                    @csrf
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">No. Urut</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_urut" id="no_urut" value="{{ $ppanjar_detail->no }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" id="nopek" name="nopek" style="width: 100% !important;">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg }}" @if ($pegawai->nopeg == $ppanjar_detail->nopek)
                                        selected
                                    @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan" id="keterangan">{{ $ppanjar_detail->keterangan }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Nilai</label>
                        <div class="col-10">
                            <input class="form-control money" type="text" name="nilai" id="nilai" value="{{ float_two($ppanjar_detail->nilai) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Qty</label>
                        <div class="col-10">
                            <input class="form-control qty" type="text" name="qty" id="qty" value="{{ abs($ppanjar_detail->qty) }}">
                        </div>
                    </div>

                    <div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a href="{{ route('modul_umum.perjalanan_dinas.pertanggungjawaban.edit', ['no_ppanjar' => $no_ppanjar]) }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\PPerjalananDinasDetailUpdate', '#formPPanjarDinasDetail') !!}

<script type="text/javascript">
	$(document).ready(function () {

		$("#formPPanjarDinasDetail").on('submit', function(){
            
			if ($('#nopek-error').length){
				$("#nopek-error").insertAfter("#nopek-nya");
			}

			if($(this).valid()) {
                $(this).unbind('submit').submit();
			}
		});
	});
</script>
@endpush
