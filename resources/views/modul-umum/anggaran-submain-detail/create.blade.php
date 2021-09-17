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
                Tambah Detail Anggaran
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="formAnggaranSubmainDetail" action="{{ route('modul_umum.anggaran.submain.detail.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="tahun" class="col-2 col-form-label">Tahun</label>
						<div class="col-10">
							<input class="form-control tahun" type="text" name="tahun" id="tahun" value="{{ date('Y') }}" onkeyup="getSubmain(this.value)" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="kode_main" class="col-2 col-form-label">Sub Main</label>
						<div class="col-10">
							<select class="form-control select2" name="sub_main" id="sub_main">
								<option value="">- Pilih Sub Main -</option>
                                @foreach ($anggaran_main_list as $anggaran)
									<option value="{{ $anggaran->kode_main }}">{{ $anggaran->kode_main.' - '.$anggaran->nama_main }}</option>
								@endforeach
							</select>
							<div id="sub_main-nya"></div>
						</div>
					</div>

                    <div class="form-group row">
						<label for="kode_main" class="col-2 col-form-label">Detail Anggaran</label>
						<div class="col-10">
							<select class="form-control select2" name="detail_anggaran" id="detail_anggaran">
								<option value="">- Pilih Detail Anggaran -</option>
                                @foreach ($anggaran_main_list as $anggaran)
									<option value="{{ $anggaran->kode_main }}">{{ $anggaran->kode_main.' - '.$anggaran->nama_main }}</option>
								@endforeach
							</select>
							<div id="detail_anggaran-nya"></div>
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
			if ($('#kode_main-error').length){
				$("#kode_main-error").insertAfter("#kode_main-nya");
			}
		});
	});

	function getSubmain(tahun) {
		$('#sub_main').select2({
            placeholder: '- Pilih Master Anggaran -',
            ajax: {
                url: "{{ route('modul_umum.anggaran.get_by_tahun') }}",
                dataType: 'json',
                delay: 250,
                data: {
                    "tahun": tahun,
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.kode_main + " - " + item.nama_main,
                                id: item.kode_main
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
