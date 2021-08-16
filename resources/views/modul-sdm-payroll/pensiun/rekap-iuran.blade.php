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
                Tabel Rekap Iuran Pensiun
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.pensiun.rekap_iuran.export') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                            <?php 
                                $tgl = date_create(now());
                                $tahun = date_format($tgl, 'Y'); 
                            ?>
                        <label for="" class="col-2 col-form-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-4">
                            <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" autocomplete="off">
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label"></label>
                        <div class="col-8">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="dp" value="BK" checked>
                                    <span></span> IURAN DANA PENSIUN (BEBAN PEKERJA)
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" name="dp" value="BR">
                                    <span></span> IURAN DANA PENSIUN (BEBAN PERUSAHAAN)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label"></label>
                        <div class="col-8">
                            <input class="form-control" type="hidden" name="tanggal" value="{{ date('d F Y') }}" id="tanggal" size="15" maxlength="15" autocomplete="off" required oninvalid="this.setCustomValidity('Tanggal Cetak Harus Diisi..')" onchange="setCustomValidity('')" autocomplete="off">
                        </div>
                    </div>
                    <div class="form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                                <button type="submit" class="btn btn-primary" onclick="$('form').attr('target', '_blank')"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
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
        $('#tanggal').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'dd MM yyyy'
        });
    });
</script>
@endpush
