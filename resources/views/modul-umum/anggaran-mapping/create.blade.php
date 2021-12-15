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
                Tambah Anggaran Mapping
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="formAnggaran" action="{{ route('modul_umum.anggaran.mapping.store') }}" method="POST">
					@csrf

                    <div class="form-group row">
						<label for="nama" class="col-2 col-form-label">Tahun</label>
						<div class="col-10">
							<select class="form-control select2" name="tahun" id="tahun" width="100%">
                                @foreach ($tahunList as $tahun)
                                    <option value="{{ $tahun->tahun }}">{{ $tahun->tahun }}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="nama" class="col-2 col-form-label">Nama Detail Anggaran</label>
						<div class="col-10">
							<select class="form-control select2" name="detail_anggaran" id="detail_anggaran" width="100%">
                                <option value="">- Pilih Detail Anggaran -</option>
                                @foreach ($detailAnggaranList as $detailAnggaran)
                                    <option value="{{ $detailAnggaran->kode }}">{{ $detailAnggaran->kode }} - {{ $detailAnggaran->nama }}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="nilai" class="col-2 col-form-label">Sandi Perkiraan</label>
						<div class="col-10">
							<select class="form-control select2-multiple" name="sandi_perkiraan[]" id="sandi_perkiraan" multiple="multiple" width="100%">
                            </select>
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
{!! JsValidator::formRequest('App\Http\Requests\AnggaranStore', '#formAnggaran') !!}

<script>
    $(document).ready(function() {
        $('#sandi_perkiraan').select2({
            placeholder: "Ketik sandi perkiraan",
            allowClear: true,
			tags: true,
			ajax: {
				url: "{{ route('modul_umum.anggaran.mapping.ajax_sanper') }}",
				type : "get",
				dataType : "JSON",
				delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.kodeacct + " - " + item.descacct ,
                                id: item.kodeacct
                            }
                        })
                    };
                },
                cache: true
			}
        });

        $('#tahun').select2().on('change', function() {
            var tahun = $(this).val();
            var url = '{{ route("modul_umum.anggaran.mapping.ajax_detail_anggaran", ":tahun") }}';
            // go to page edit
            url = url.replace(':tahun', tahun);

            // Fetch the preselected item, and add to the control
            $('#detail_anggaran').empty();

            $.ajax({
                type: 'GET',
                url: url,
            }).then(function (data) {
                var data2 = [];

                $.map(data, function(item) {
                    data2.push({ 
                        id: item.kode, 
                        text: item.kode + " - " + item.nama
                    }); 
                });

                $('#detail_anggaran').select2({
                    data: data2
                });
            });
        });
    });
</script>
@endpush
