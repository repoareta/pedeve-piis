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
                Tabel Cetak Rekap THR
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.proses_thr.rekap_thr.export') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                        <div class="col-4">
                            <?php 
                                $tgl = date_create(now());
                                $tahun = date_format($tgl, 'Y'); 
                                $bulan = date_format($tgl, 'n');
                            ?>
                            <select class="form-control select2" style="width: 100% !important;"  name="bulan" required>
                                <option value="1" <?php if($bulan == 1 ) echo 'selected' ; ?>>Januari</option>
                                <option value="2" <?php if($bulan == 2 ) echo 'selected' ; ?>>Februari</option>
                                <option value="3" <?php if($bulan == 3 ) echo 'selected' ; ?>>Maret</option>
                                <option value="4" <?php if($bulan == 4 ) echo 'selected' ; ?>>April</option>
                                <option value="5" <?php if($bulan == 5 ) echo 'selected' ; ?>>Mei</option>
                                <option value="6" <?php if($bulan == 6 ) echo 'selected' ; ?>>Juni</option>
                                <option value="7" <?php if($bulan == 7 ) echo 'selected' ; ?>>Juli</option>
                                <option value="8" <?php if($bulan == 8 ) echo 'selected' ; ?>>Agustus</option>
                                <option value="9" <?php if($bulan == 9 ) echo 'selected' ; ?>>September</option>
                                <option value="10" <?php if($bulan == 10 ) echo 'selected' ; ?>>Oktober</option>
                                <option value="11" <?php if($bulan == 11 ) echo 'selected' ; ?>>November</option>
                                <option value="12" <?php if($bulan == 12 ) echo 'selected' ; ?>>Desember</option>
                            </select>
                        </div>
                        <div class="col-4" >
                            <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" autocomplete="off" required oninvalid="this.setCustomValidity('Tahun Harus Diisi..')" autocomplete="off">
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Penandatangan<span class="text-danger">*</span></label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="" name="nama" id="nama" required autocomplete="off">
                        </div>
                        <label class="col-1 col-form-label">Jabatan<span class="text-danger">*</span></label>
                        <div class="col-3" >
                            <input class="form-control" type="text" value="Sekretaris Perseroan, " name="jabatan" id="jabatan" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Tanggal Cetak<span class="text-danger">*</span></label>
                        <div class="col-8">
                            <input class="form-control" type="text" name="tanggal" value="{{ date('d F Y') }}" id="tanggal" size="15" maxlength="15" autocomplete="off" required oninvalid="this.setCustomValidity('Tanggal Cetak Harus Diisi..')" autocomplete="off">
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
        // minimum setup
        $('#tanggal').datepicker({
            todayHighlight: true,
            // orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'dd MM yyyy'
        });
    });
</script>
@endpush
