@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="fa fa-plus-circle text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah RKAP & Realisasi
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form id="form-create" action="{{ route('modul_cm.rkap_realisasi.update', ['kd_rencana_kerja' => $rkapRealisasi->kd_rencana_kerja]) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-2 col-form-label"></label>
                        <div class="col-8 col-form-label">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="rkap" name="kategori" id="rkap" @if($rkapRealisasi->bulan === null) checked @endif>
                                <span></span>RKAP</label>
                                <label class="radio">
                                    <input type="radio" value="realisasi" name="kategori" id="realisasi" @if($rkapRealisasi->bulan !== null) checked @endif>
                                <span></span>REALISASI</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Nama Perusahaan<span class="text-danger">*</span></label>
                        <div class="col-8">
                            <select name="nama" class="form-control kt-select2">
                                <option value="">- Pilih -</option>
                                @foreach ($perusahaanList as $perusahaan)
                                <option value="{{ $perusahaan->id }}" @if ($perusahaan->id == $rkapRealisasi->kd_perusahaan) selected @endif>{{ $perusahaan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Tahun</label>
                        <div class="col-8" >
                            <input class="form-control" type="text" value="{{ $rkapRealisasi->tahun }}" name="tahun" size="4" maxlength="4"> 
                        </div>
                    </div>
                    <div class="form-group row" id="bulan-group" @if($rkapRealisasi->bulan === null) style="display: none;" @endif>
                        <label class="col-2 col-form-label">Bulan</label>
                        <div class="col-8" >
                            <select class="form-control kt-select2" name="bulan" id="bulan" style="width: 100%">
                                <option value="">- Pilih -</option>
                                <option value="01" @if($rkapRealisasi->bulan == '01') selected @endif>Januari</option>
                                <option value="02" @if($rkapRealisasi->bulan == '02') selected @endif>Februari</option>
                                <option value="03" @if($rkapRealisasi->bulan == '03') selected @endif>Maret</option>
                                <option value="04" @if($rkapRealisasi->bulan == '04') selected @endif>April</option>
                                <option value="05" @if($rkapRealisasi->bulan == '05') selected @endif>Mei</option>
                                <option value="06" @if($rkapRealisasi->bulan == '06') selected @endif>Juni</option>
                                <option value="07" @if($rkapRealisasi->bulan == '07') selected @endif>Juli</option>
                                <option value="08" @if($rkapRealisasi->bulan == '08') selected @endif>Agustus</option>
                                <option value="09" @if($rkapRealisasi->bulan == '09') selected @endif>September</option>
                                <option value="10" @if($rkapRealisasi->bulan == '10') selected @endif>Oktober</option>
                                <option value="11" @if($rkapRealisasi->bulan == '11') selected @endif>November</option>
                                <option value="12" @if($rkapRealisasi->bulan == '12') selected @endif>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">CI</label>
                        <div class="col-8 col-form-label">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="ci" id="idr" @if($rkapRealisasi->ci_r == 1) checked @endif>
                                <span></span>Rp</label>
                                <label class="radio">
                                    <input type="radio" value="2" name="ci" id="usd" @if($rkapRealisasi->ci_r == 2) checked @endif>
                                <span></span>US $</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="kurs-group" @if($rkapRealisasi->ci_r == 1) style="display: none;" @endif>
                        <label class="col-2 col-form-label">Kurs</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="1" name="kurs" id="kurs">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Aset</label>
                        <div class="col-8">
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->aset_r) }}" name="aset" id="aset">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Revenue</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->revenue_r) }}" name="revenue" id="revenue">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Beban Pokok</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->beban_pokok_r) }}" name="beban_pokok" id="beban_pokok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Biaya Operasi</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->biaya_bersih_r) }}" name="biaya_operasi" id="biaya_operasi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Laba Bersih</label>
                        <div class="col-8">
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->laba_bersih_r) }}" name="laba_bersih" id="laba_bersih" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">TKP</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->tkp_r) }}" name="tkp" id="tkp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">KPI</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="{{ currency_format($rkapRealisasi->kpi_r) }}" name="kpi" id="kpi">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a  href="{{ route('modul_cm.rkap_realisasi.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
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
    $(document).ready(function(){
        $('.kt-select2').select2().on('change', function() {
            $(this).valid();
        });

        $("input[name=kategori]").change(function(){
            if($("#realisasi").is(':checked')){
                $("#bulan-group").show();
            }else if($("#rkap").is(':checked')){
                $("#bulan-group").hide();
            }
        });

        $("input[name=ci]").change(function(){
            if($("#usd").is(':checked')){
                $("#kurs-group").show();
            }else if($("#idr").is(':checked')){
                $("#kurs-group").hide();
            }
        });
    });		
</script>
@endpush