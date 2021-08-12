@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-right">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Anggaran Report
            </h3>
        </div>
    </div>
    <div class="card-body">
		<div class="col-12">
			<form class="form" action="{{ route('modul_umum.anggaran.report.export') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="mulai-input" class="col-2 col-form-label">Tahun</label>
                    <div class="col-8">
                        <input type="text" class="form-control tahun" name="tahun" autocomplete="off" />
                    </div>
                </div>
    
                <div class="form__actions">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf" aria-hidden="true"></i> Export .PDF</button>
                        </div>
                    </div>
                </div>
            </form>
		</div>
    </div>
</div>

@endsection
