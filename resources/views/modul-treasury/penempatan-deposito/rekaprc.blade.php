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
                Tambah Penempatan Deposito
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="post" id="form-create" action="{{ route('penempatan_deposito.ctkdepo') }}">
            @csrf
            <input type="hidden" name="userid" value="{{ auth()->user()->userid }}">
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Bank</label>
                <div class="col-10">
                    <select name="sanper" class="form-control select2" style="width: 100%;"  oninvalid="this.setCustomValidity('Bank Harus Diisi..')" onchange="setCustomValidity('')">
                        <option value="">- All -</option>
                        @foreach($data_bank as $data)
                        <option value="{{$data->kdbank}}">{{$data->kdbank}} -- {{$data->descacct}}</option>
                        @endforeach
                    </select>								
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                <div class="col-5">
                    <?php 
                    $tahun = date('Y');
                    $bulan = date('m');
                    $kurs = 1;
                    ?>
                    <select class="form-control select2" style="width: 100%;" name="bulan">
                        <option value="01" <?php if($bulan  == '01' ) echo 'selected' ; ?>>Januari</option>
                        <option value="02" <?php if($bulan  == '02' ) echo 'selected' ; ?>>Februari</option>
                        <option value="03" <?php if($bulan  == '03' ) echo 'selected' ; ?>>Maret</option>
                        <option value="04" <?php if($bulan  == '04' ) echo 'selected' ; ?>>April</option>
                        <option value="05" <?php if($bulan  == '05' ) echo 'selected' ; ?>>Mei</option>
                        <option value="06" <?php if($bulan  == '06' ) echo 'selected' ; ?>>Juni</option>
                        <option value="07" <?php if($bulan  == '07' ) echo 'selected' ; ?>>Juli</option>
                        <option value="08" <?php if($bulan  == '08' ) echo 'selected' ; ?>>Agustus</option>
                        <option value="09" <?php if($bulan  == '09' ) echo 'selected' ; ?>>September</option>
                        <option value="10" <?php if($bulan  =='10'  ) echo 'selected' ; ?>>Oktober</option>
                        <option value="11" <?php if($bulan  == '11' ) echo 'selected' ; ?>>November</option>
                        <option value="12" <?php if($bulan  == '12' ) echo 'selected' ; ?>>Desember</option>
                    </select>
                </div>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{$tahun}}" name="tahun"
                        autocomplete="off" required>
                </div>
                <div class="col-2">
                    <input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" size="15" maxlength="15"
                        autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Kurs<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" name="kurs" value="{{$kurs}}" size="15" maxlength="15"
                        autocomplete="off" required
                        oninvalid="this.setCustomValidity('Kurs Harus Diisi..')" oninput="setCustomValidity('')">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{route('penempatan_deposito.index')}}" class="btn btn-warning"><i class="fa fa-reply"></i>Cancel</a>
                        <button type="submit" id="btn-save" onclick="$('form-create').attr('target', '_blank');" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection