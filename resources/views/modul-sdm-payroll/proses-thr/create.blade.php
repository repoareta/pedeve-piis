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
                Proses THR
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.proses_thr.store') }}" method="POST">
                    @csrf
                    <div class="portlet__body">
                        <div class="form-group form-group-last">
                            <div class="alert alert-secondary" role="alert">
                                <div class="alert-text">
                                    Header Proses THR
                                </div>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" name="userid" value="{{ Auth::user()->userid }}">
                        <div class="form-group row">
                            <label for="dari-input" class="col-2 col-form-label">Status Pekerja<span class="text-danger">*</span></label>
                            <div class="col-10">
                                <select name="prosesthr" id="select-debetdari" class="form-control select2">
                                    <option value="A">Semua</option>
                                    <option value="C">Pekerja Tetap</option>
                                    <option value="K">Kontrak</option>
                                    <option value="B">Perbantuan</option>
                                </select>								
                            </div>
                        </div>
                        <div class="form-group row">
                            <?php 
                                $tgl = date_create(now());
                                $bulantahun = date_format($tgl, 'm/Y'); 
                            ?>
                            <label for="nopek-input" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="tanggal" value="{{ $bulantahun }}" id="tanggal" required autocomplete="off"">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nopek-input" class="col-2 col-form-label">Keterangan</label>
                            <div class="col-10">
                                <input class="form-control" type="text" name="keterangan" value="" size="30" maxlength="30"  autocomplete="off">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label for="" class="col-2 col-form-label"></label>
                            <div class="col-8">
                                <div class="radio-inline">
                                    <label class="radio">
                                        <input value="proses" type="radio" name="radioupah" checked>
                                        <span></span> PROSES
                                    </label>
                                    <label class="radio">
                                        <input value="batal" type="radio" name="radioupah"> 
                                        <span></span> BATALKAN
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form__actions">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <a href="#" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                    <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check"></i>Proses</button>
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
<script type="text/javascript">
	$(document).ready(function () {
        // minimum setup
        $('#tanggal').datepicker({
            startView: "months", 
            minViewMode: "months",
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'mm/yyyy'
        });
    });
</script>
@endpush
