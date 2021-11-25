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
                Ubah Detail Anggaran
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="formAnggaranSubmainDetail" action="{{ route('modul_umum.anggaran.submain.detail.update', ['kode_submain' => $kode_submain, 'kode' => $kode]) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="tahun" class="col-2 col-form-label">Tahun</label>
						<div class="col-10">
							<input class="form-control tahun" type="text" name="tahun" id="tahun" value="{{ $anggaran->tahun }}" onkeyup="getSubmain(this.value)" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="kode_main" class="col-2 col-form-label">Anggaran Submain</label>
						<div class="col-10">
							<select class="form-control select2" name="kode_submain" id="kode_submain">
								<option value="">- Pilih Sub Main -</option>
                                @foreach ($anggaran_submain_list as $anggaran_submain)
									<option value="{{ $anggaran_submain->kode_submain }}" @if($anggaran_submain->kode_submain == $anggaran->kode_submain) selected @endif>{{ $anggaran_submain->kode_submain.' - '.$anggaran_submain->nama_submain }}</option>
								@endforeach
							</select>
							<div id="kode_submain-nya"></div>
						</div>
					</div>

                    <div class="form-group row">
						<label for="tahun" class="col-2 col-form-label">Kode Detail Anggaran</label>
						<div class="col-10">
							<input class="form-control" type="text" name="kode" id="kode" value="{{ $anggaran->kode }}" autocomplete="off">
						</div>
					</div>

                    <div class="form-group row">
						<label for="tahun" class="col-2 col-form-label">Nama Detail Anggaran</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nama" id="nama" value="{{ $anggaran->nama }}" autocomplete="off">
						</div>
					</div>

					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_umum.anggaran.submain.detail.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\AnggaranSubmainDetailStore', '#formAnggaranSubmainDetail') !!}

<script type="text/javascript">
    $(document).ready(function () {
		$("#formAnggaranSubmainDetail").on('submit', function(){
			if ($('#kode_submain-error').length){
				$("#kode_submain-error").insertAfter("#kode_submain-nya");
			}
		});
	});

	function getSubmain(tahun) {
		$('#kode_submain').select2({
            placeholder: '- Pilih Submain Anggaran -',
            ajax: {
                url: "{{ route('modul_umum.anggaran.submain.get_by_tahun') }}",
                dataType: 'json',
                delay: 250,
                data: {
                    "tahun": tahun,
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.kode_submain + " - " + item.nama_submain,
                                id: item.kode_submain
                            }
                        })
                    };
                },
                cache: true
            }
        });
	}
</script>
@endpush
