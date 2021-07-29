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
                Tambah RKAP & Realisasi
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form id="form-create" action="{{ route('modul_cm.rkap_realisasi.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-2 col-form-label"></label>
                        <div class="col-8 col-form-label">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="rkap" name="kategori" id="rkap" checked>
                                <span></span>RKAP</label>
                                <label class="radio">
                                    <input type="radio" value="realisasi" name="kategori" id="realisasi">
                                <span></span>REALISASI</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Nama Perusahaan<span class="text-danger">*</span></label>
                        <div class="col-8">
                            <select name="nama" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($perusahaanList as $perusahaan)
                                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Tahun</label>
                        <div class="col-8" >
                            <input class="form-control" type="text" value="{{ date('Y') }}" name="tahun"> 
                        </div>
                    </div>
                    <div class="form-group row" id="bulan-group" style="display: none;">
                        <label class="col-2 col-form-label">Bulan</label>
                        <div class="col-8" >
                            <select class="form-control select2" style="width: 100%;" name="bulan" id="bulan" style="width: 100%">
                                <option value="">- Pilih -</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">CI</label>
                        <div class="col-8 col-form-label">
                            <div class="radio-inline">
                                <label class="radio">
                                    <input type="radio" value="1" name="ci" id="idr" checked>
                                <span></span>Rp</label>
                                <label class="radio">
                                    <input type="radio" value="2" name="ci" id="usd">
                                <span></span>US $</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="kurs-group" style="display: none;">
                        <label class="col-2 col-form-label">Kurs</label>
                        <div class="col-8">
                            <input class="form-control" type="text" value="1" name="kurs" id="kurs">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Aset</label>
                        <div class="col-8">
                            <input class="form-control money" type="text" value="0" name="aset" id="aset">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Revenue</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="0" name="revenue" id="revenue">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Beban Pokok</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="0" name="beban_pokok" id="beban_pokok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Biaya Operasi</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="0" name="biaya_operasi" id="biaya_operasi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Laba Bersih</label>
                        <div class="col-8">
                            <input class="form-control money" type="text" value="0" name="laba_bersih" id="laba_bersih" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">TKP</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="0" name="tkp" id="tkp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">KPI</label>
                        <div class="col-8">						
                            <input class="form-control money" type="text" value="0" name="kpi" id="kpi">
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
