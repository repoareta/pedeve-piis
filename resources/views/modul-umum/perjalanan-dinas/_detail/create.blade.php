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
                Tambah Detail Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_umum.perjalanan_dinas.detail.store', ['no_panjar' => $no_panjar]) }}" method="POST" id="formPanjarDinasDetail">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No. Urut</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_urut" id="no_urut">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" id="nopek" name="nopek" style="width: 100% !important;">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                            <select class="form-control select2" name="jabatan" id="jabatan" style="width: 100% !important;" readonly>
                                <option value="">- Pilih Jabatan -</option>
                                @foreach ($jabatan_list as $jabatan)
                                    <option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
                                @endforeach
                            </select>
                            <div id="jabatan-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Golongan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="golongan" id="golongan" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_umum.perjalanan_dinas.edit', ['no_panjar' => $no_panjar]) }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasDetailStore', '#formPanjarDinasDetail'); !!}

<script>
    $(document).ready(function () {
        $("#formPanjarDinasDetail").on('submit', function(){
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
@endpush
