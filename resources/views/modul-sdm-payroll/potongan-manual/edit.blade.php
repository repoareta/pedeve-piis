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
                Edit Potongan Manual
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('modul_sdm_payroll.potongan_manual.update') }}" id="form-edit" method="POST">
                    @csrf
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Potongan Manual
                        </div>
                    </div>
                    <input type="hidden" name="userid" value="{{ auth()->user()->userid }}">
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Mulai Bulan<span class="text-danger">*</span></label>
                        <div class="col-5">
                        <input type="text" class="form-control bg-secondary" readonly value="{{ bulan($data->bulan) }}">
                    </div>
                        <div class="col-5">
                            <input class="form-control bg-secondary" type="text" readonly value="{{ $data->tahun }}" name="tahun" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Pegawai<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input type="text" class="form-control bg-secondary" value="{{ $data->nopeg }} - {{ $data->nama_nopek }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">AARD<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input type="text" class="form-control bg-secondary" value="{{ $data->aard }} - {{ $data->nama_aard }}">
                        </div>
                    </div>
                    <div class="form-group row">
                    <?php $ccl =1; $jmlcc=999; ?>
                        <label class="col-2 col-form-label">Cicilan Ke<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="ccl" type="text" value="{{ number_format($data->ccl) }}" id="ccl" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jml Cicilan<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="jmlcc" type="text" value="{{ number_format($data->jmlcc) }}" id="jmlcc" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nilai<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control money" name="nilai" type="text" value="{{ number_format($data->nilai) }}" size="25" maxlength="25" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('modul_sdm_payroll.potongan_manual.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        // minimum setup
        $('#tgldebet').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            format   : 'mm/yyyy'
        });
    });
</script>
@endpush
