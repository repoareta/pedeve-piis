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
                Tambah Potongan Otomatis
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="form-create">
                    @csrf
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Potongan Otomatis
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="userid" value="{{ Auth::user()->userid }}">
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
                        <label for="" class="col-2 col-form-label">Potongan<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="aard" id="aard" class="form-control select2" style="width: 100% !important;" required autocomplete="off" oninvalid="this.setCustomValidity('Potongan Harus Diisi..')">
                                <option value="">- Pilih -</option>
                                @foreach($pay_aard as $data)
                                <option value="{{ $data->kode }}">{{ $data->kode }} - {{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                        </div>
                    </div>
                    <div class="form-group row">
                    <?php $ccl =1; $jmlcc=999; ?>
                        <label class="col-2 col-form-label">Mulai Cicilan Ke<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="ccl" type="text" value="{{ $ccl }}" id="ccl" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jml Cicilan<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" name="jmlcc" type="text" value="{{ $jmlcc }}" id="jmlcc" size="3" maxlength="3" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Cicilan/Bulan<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control nominal" name="nilai" type="text" value="0" size="25" maxlength="25" required autocomplete="off">
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
        $('#form-create').submit(function(){
            $.ajax({
                url  : "{{ route('modul_sdm_payroll.potongan_otomatis.store') }}",
                type : "POST",
                data : $('#form-create').serialize(),
                dataType : "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success : function(data){
                    console.log(data);
                    if(data == 1){
                        Swal.fire({
                            type  : 'success',
                            title : 'Data Berhasil Ditambah',
                            text  : 'Berhasil',
                            timer : 2000
                        }).then(function() {
                            window.location.replace("{{ route('modul_sdm_payroll.potongan_manual.index') }}");;
                        });
                    } else {
                        Swal.fire({
                            type  : 'info',
                            title : 'Data Potongan Otomatis Yang Diinput Sudah Ada.',
                            text  : 'Failed',
                        });
                    }
                }, 
                error : function(){
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });	
            return false;
        });
    
        $('#nilai').keyup(function(){
            var nilai=parseInt($('#nilai').val());
            var pajak=(35/65)*nilai;
            var a =parseInt(pajak);
            $('#pajak').val(a);
        });
    
        // minimum setup
        $('#tgldebet').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            format   : 'mm/yyyy'
        });
    });

    var nilai = document.getElementById('nilai');
    nilai.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatnilai() untuk mengubah angka yang di ketik menjadi format angka
        nilai.value = formatRupiah(this.value, '');
    });
</script>
@endpush
