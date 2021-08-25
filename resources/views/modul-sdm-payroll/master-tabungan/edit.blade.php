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
                Tambah Master Tabungan
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.master_tabungan.update', ['master_tabungan' => $masterTabungan->perusahaan]) }}" id="form" method="POST">
                    @csrf
                    <div class="form-group form-group-last">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-text">
                                Header Master Tabungan
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Perusahaan<span class="text-danger">*</span></label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="perusahaan" value="{{ $masterTabungan->perusahaan }}" autocomplete="off">
                            </div>
                        </div>
                                            
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <a href="{{ route('modul_sdm_payroll.master_tabungan.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                                    <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
@endpush
