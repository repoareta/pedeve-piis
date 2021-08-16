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
                Tambah Koreksi Gaji
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.potongan_koreksi_gaji.store') }}" method="post" id="form-create">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-custom alert-default" role="alert">
                    <div class="alert-text">
                        Header Koreksi Gaji
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Bulan/Tahun<span style="color:red;">*</span></label>
                <div class="col-4">
                    <select class="form-control kt-select2" style="width: 100% !important;" name="bulan" id="bulan" required>
                        <option value="1" <?php if($bulan == 1) echo 'selected' ; ?>>Januari</option>
                        <option value="2" <?php if($bulan == 2) echo 'selected' ; ?>>Februari</option>
                        <option value="3" <?php if($bulan == 3) echo 'selected' ; ?>>Maret</option>
                        <option value="4" <?php if($bulan == 4) echo 'selected' ; ?>>April</option>
                        <option value="5" <?php if($bulan == 5) echo 'selected' ; ?>>Mei</option>
                        <option value="6" <?php if($bulan == 6) echo 'selected' ; ?>>Juni</option>
                        <option value="7" <?php if($bulan == 7) echo 'selected' ; ?>>Juli</option>
                        <option value="8" <?php if($bulan == 8) echo 'selected' ; ?>>Agustus</option>
                        <option value="9" <?php if($bulan == 9) echo 'selected' ; ?>>September</option>
                        <option value="10" <?php if($bulan ==10) echo 'selected' ; ?>>Oktober</option>
                        <option value="11" <?php if($bulan == 11) echo 'selected' ; ?>>November</option>
                        <option value="12" <?php if($bulan == 12) echo 'selected' ; ?>>Desember</option>
                    </select>
                </div>
                <div class="col-6">
                    <input class="form-control" type="text" value="{{ $tahun }}" name="tahun" size="4" maxlength="4" autocomplete="off" required>
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid }}" name="userid" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Pegawai<span style="color:red;">*</span></label>
                <div class="col-10">
                    <select name="nopek" class="form-control selectpicker" data-live-search="true" required autocomplete="off">
                        <option value="">- Pilih -</option>
                        @foreach($data_pegawai as $data)
                        <option value="{{ $data->nopeg }}">{{ $data->nopeg }} - {{ $data->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">AARD<span style="color:red;">*</span></label>
                <div class="col-10">
                    <select name="aard" id="aard" class="form-control selectpicker" data-live-search="true" required autocomplete="off">
                        <option value="">- Pilih -</option>
                        @foreach($pay_aard as $dataa)
                        <option value="{{ $dataa->kode }}">{{ $dataa->kode }} - {{ $dataa->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Nilai<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="nilai" type="text" required autocomplete="off">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_sdm_payroll.potongan_koreksi_gaji.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PotonganKoreksiGajiStoreRequest', '#form-create'); !!}

<script>
    $(document).ready(function () {
        $('#bulan').select2();

        $('#form-create').submit(function(e){
			e.preventDefault();

            if($(this).valid()) {
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: "Apakah anda yakin mau menyimpan data ini?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value == true) {
                        $(this).unbind('submit').submit();
                    }
                });
            }
		});
    });
</script>
@endpush