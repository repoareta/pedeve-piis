@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

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
                Cetak Cash Flow Perbulan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" action="{{ route('cash_flow.perbulan.export') }}" method="GET"
            target="_blank">
            <div class="portlet__body">
                <div class="form-group row">
                    <label for="mulai-input" class="col-2 col-form-label">Bulan<span class="text-danger">*</span></label>
                    <div class="col-10">
                        <div class="input-daterange input-group" id="date_range_picker">
                            @php
                            $bulan = date('m');
                            $tahun = date('Y');
                            @endphp
                            <select class="form-control select2" name="bulan">
                                <option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
                                <option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
                                <option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
                                <option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
                                <option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
                                <option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
                                <option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
                                <option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
                                <option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
                                <option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
                                <option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
                                <option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
                            </select>
                        </div>
                        <span class="form-text text-muted">Pilih periode bulan rekap arus kas</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Tahun<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" autocomplete="off">
                    </div>
                    <label for="" class="col-2 col-form-label">Kurs<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <input class="form-control money" type="text" value="{{ $kurs }}" name="kurs" autocomplete="off">
                    </div>
                </div>

                <div class="form__actions">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="#" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')"
                                class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
@endpush
