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
                Tambah SMK
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.smk.store', ['pegawai' => $pegawai->nopeg]) }}" method="post" id="form-create-smk">
                    @csrf
                    <div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Tahun</label>
						<div class="col-10">
							<input class="form-control" type="text" name="tahun_smk" id="tahun_smk" value="{{ date('Y') }}">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="spd-input" class="col-2 col-form-label">Nilai</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nilai_smk" id="nilai_smk">
						</div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_sdm_payroll.master_pegawai.edit', ['pegawai' => $pegawai->nopeg]) }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
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
{!! JsValidator::formRequest('App\Http\Requests\SMKStoreRequest', '#form-create-smk') !!}
@endpush