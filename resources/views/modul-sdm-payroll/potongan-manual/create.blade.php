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
                Tambah Potongan Manual
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('modul_sdm_payroll.potongan_manual.store') }}" id="form-create" method="POST">
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
                        <?php
                            $tgl = date_create(now());
                            $tahun = date_format($tgl, 'Y');
                            $bulan = date_format($tgl, 'n');
                        ?>
                        <select class="form-control select2" style="width: 100% !important;" name="bulan">
                            <option value="1" <?php if($bulan == 1) echo 'selected'; ?>>Januari</option>
                            <option value="2" <?php if($bulan == 2) echo 'selected'; ?>>Februari</option>
                            <option value="3" <?php if($bulan == 3) echo 'selected'; ?>>Maret</option>
                            <option value="4" <?php if($bulan == 4) echo 'selected'; ?>>April</option>
                            <option value="5" <?php if($bulan == 5) echo 'selected'; ?>>Mei</option>
                            <option value="6" <?php if($bulan == 6) echo 'selected'; ?>>Juni</option>
                            <option value="7" <?php if($bulan == 7) echo 'selected'; ?>>Juli</option>
                            <option value="8" <?php if($bulan == 8) echo 'selected'; ?>>Agustus</option>
                            <option value="9" <?php if($bulan == 9) echo 'selected'; ?>>September</option>
                            <option value="10" <?php if($bulan == 10) echo 'selected'; ?>>Oktober</option>
                            <option value="11" <?php if($bulan == 11) echo 'selected'; ?>>November</option>
                            <option value="12" <?php if($bulan == 12) echo 'selected'; ?>>Desember</option>
                        </select>
                    </div>
                        <div class="col-5">
                            <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Pegawai<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="nopek" class="form-control select2" style="width: 100% !important;" required autocomplete="off" oninvalid="this.setCustomValidity('Pegawai Harus Diisi..')">
                                <option value="">- Pilih -</option>
                                @foreach($data_pegawai as $data)
                                <option value="{{ $data->nopeg }}">{{ $data->nopeg }} - {{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Komponen Upah<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="aard" id="aard" class="form-control select2" style="width: 100% !important;" required autocomplete="off" oninvalid="this.setCustomValidity('Potongan Harus Diisi..')">
                                <option value="">- Pilih Komponen Upah -</option>
                                @foreach($pay_aard as $data)
                                <option value="{{ $data->kode }}">{{ $data->kode }} - {{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                    <?php $ccl =1; $jmlcc=999; ?>
                        <label class="col-2 col-form-label">Cicilan Ke<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="ccl" type="text" value="1" id="ccl" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jml Cicilan<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="jmlcc" type="text" value="{{ $jmlcc }}" id="jmlcc" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nilai<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control money" name="nilai" type="text" value="0" size="25" maxlength="25" required autocomplete="off">
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
