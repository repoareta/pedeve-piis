@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">

    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Pilih Jenis Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group form-group-last">
					<div class="alert alert-secondary" role="alert">
						<div class="alert-text">
							Header Pilih Jenis Kas/Bank
						</div>
					</div>
				</div>
                <form action="{{ route('penerimaan_kas.create') }}" method="POST">
                    @csrf
                    <input class="form-control" type="hidden" name="userid" value="{{ auth()->user()->userid }}">
                    <div class="form-group row">
                        <label for="user-lv-input" class="col-2 col-form-label"></label>
                        <div class="col-10 col-form-label">
                            <div class="radio-inline">
                                <label class="radio radio-outline radio-primary">
                                    <input type="radio" name="mp" checked="" value="M">
                                    <span></span> PENERIMAAN / BKM
                                </label>
                                <label class="radio radio-outline radio-primary">
                                    <input type="radio" name="mp" checked="" value="P">
                                    <span></span> PENGELUARAN / BKP
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('penerimaan_kas.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check"></i>Proses</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection