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
                Tabel Cetak Transaksi D2 Kas Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form kt-form--label-right" action="{{route('kas_bank.cetak1')}}" method="post">
            @csrf
            <input class="form-control" type="hidden" name="userid" value="{{Auth::user()->userid}}">
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">JK<span style="color:red;">*</span></label>
                <div class="col-10">
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--solid">
                            <input value="1" type="radio" name="status">[10,11,13]
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--solid">
                            <input value="2" type="radio" name="status">[15,18]
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--solid">
                            <input value="3" type="radio" name="status" checked>All
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Bulan/Tahun<span style="color:red;">*</span></label>
                <div class="col-4">
                    <?php 
                    foreach($data_tahun as $data){ 
                        $tahun = substr($data->sbulan, 0, 4);
                        $bulan = substr($data->sbulan, 4, 2);
                        $suplesi = substr($data->sbulan, 6);
                        $lapangan = "KL";
                    }
                    ?>
                    <select class="form-control select2" name="bulan">
                        <option value="">-- All --</option>
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
                <div class="col-6">
                    <input class="form-control" type="text" value="{{$tahun}}" name="tahun" size="4" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete='off' required>
                </div>
                <div class="col-2">
                    <input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" size="15" maxlength="15" autocomplete='off'>
                    <input class="form-control" type="hidden" value="" name="suplesi" size="4" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete='off' required>
                </div>
            </div>

            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label text-right">Sandi Perkiraan</label>
                <div class="col-10">
                    <select class="cariaccount form-control" style="width: 100% !important;" name="sanper"></select>
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                        <button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
   
   $('.cariaccount').select2({
           placeholder: '-Pilih-',
           allowClear: true,
           ajax: {
               url: "{{ route('kas_bank.search.account') }}",
               type : "get",
               dataType : "JSON",
               headers: {
               'X-CSRF-Token': '{{ csrf_token() }}',
               },
               delay: 250,
           processResults: function (data) {
               return {
               results:  $.map(data, function (item) {
                   return {
                   text: item.kodeacct +'--'+ item.descacct,
                   id: item.kodeacct
                   }
               })
               };
           },
           cache: true
           }
       });
   $('#tanggal').datepicker({
       todayHighlight: true,
       orientation: "bottom left",
       autoclose: true,
       // language : 'id',
       format   : 'dd MM yyyy'
   });
});
       function hanyaAngka(evt) {
             var charCode = (evt.which) ? evt.which : event.keyCode
              if (charCode > 31 && (charCode < 48 || charCode > 57))
    
               return false;
             return true;
           }
</script>
@endpush