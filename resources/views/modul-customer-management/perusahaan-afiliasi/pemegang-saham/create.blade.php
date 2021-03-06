@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Pemegang Saham
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_cm.perusahaan_afiliasi.pemegang_saham.store', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}" method="POST" id="formPemegangSaham">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Nama</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nama_pemegang_saham" id="nama_pemegang_saham">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">% Kepemilikan</label>
                        <div class="col-10">
                            <input class="form-control persen" type="text" name="kepemilikan" id="kepemilikan" value="0">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Jumlah Lembar Saham</label>
                        <div class="col-10">
                            <input class="form-control saham" type="text" name="jumlah_lembar_saham_pemegang_saham" id="jumlah_lembar_saham_pemegang_saham" value="0">
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
{!! JsValidator::formRequest('App\Http\Requests\PemegangSahamStore', '#formPemegangSaham') !!}
@endpush
