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
                Tabel Balancing Kas Bank Per Nobukti
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" action="{{route('kas_bank.cetak2')}}" method="POST">
            @csrf
            <input class="form-control" type="hidden" name="userid" value="{{ Auth::user()->userid }}">
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                <div class="col-5">
                    <?php 
					foreach($data_tahun as $data){ 
						$tahun = substr($data->thnbln, 0, 4);
						$bulan = substr($data->thnbln, 4, 2);
					}
					?>
                    <select class="form-control" name="bulan">
                        <option value="01" <?php if($bulan == '01' ) echo 'selected' ; ?>>Januari</option>
                        <option value="02" <?php if($bulan == '02' ) echo 'selected' ; ?>>Februari</option>
                        <option value="03" <?php if($bulan == '03' ) echo 'selected' ; ?>>Maret</option>
                        <option value="04" <?php if($bulan == '04' ) echo 'selected' ; ?>>April</option>
                        <option value="05" <?php if($bulan == '05' ) echo 'selected' ; ?>>Mei</option>
                        <option value="06" <?php if($bulan == '06' ) echo 'selected' ; ?>>Juni</option>
                        <option value="07" <?php if($bulan == '07' ) echo 'selected' ; ?>>Juli</option>
                        <option value="08" <?php if($bulan == '08' ) echo 'selected' ; ?>>Agustus</option>
                        <option value="09" <?php if($bulan == '09' ) echo 'selected' ; ?>>September</option>
                        <option value="10" <?php if($bulan == '10' ) echo 'selected' ; ?>>Oktober</option>
                        <option value="11" <?php if($bulan == '11' ) echo 'selected' ; ?>>November</option>
                        <option value="12" <?php if($bulan == '12' ) echo 'selected' ; ?>>Desember</option>
                    </select>
                </div>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{$tahun}}" name="tahun" autocomplete="off" required>
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid}}" name="userid" autocomplete="off">
                    <input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" id="tanggal" size="15" maxlength="15" autocomplete="off" required autocomplete="off">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

