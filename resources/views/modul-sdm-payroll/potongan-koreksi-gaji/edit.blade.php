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
                Edit Koreksi Gaji
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.potongan_koreksi_gaji.update') }}" method="post" id="form-create">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-secondary" role="alert">
                    <div class="alert-text">
                        <h5 class="kt-portlet__head-title">
                            Header Koreksi Gaji
                        </h5>
                    </div>
                </div>
            </div>
            <div class="form-group row">
            <label for="spd-input" class="col-2 col-form-label">Bulan/Tahun<span style="color:red;">*</span></label>
            <div class="col-4">
                <?php 
                $array_bln	 = array (
                            1 =>   'Januari',
                            'Februari',
                            'Maret',
                            'April',
                            'Mei',
                            'Juni',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'November',
                            'Desember'
                        );
                        $bulan= strtoupper($array_bln[$data_list->bulan]);
                ?>
            <input class="form-control" type="text" value="{{$bulan}}"readonly style="background-color:#DCDCDC; cursor:not-allowed">
            <input class="form-control" type="hidden" value="{{$data_list->bulan}}" name="bulan">
                    
            </div>
                    <div class="col-6" >
                        <input class="form-control" type="text" value="{{$data_list->tahun}}" name="tahun" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete='off'>
                    </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Pegawai<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{$data_list->nopek}} - {{$data_list->nama_nopek}}"  readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    <input class="form-control" type="hidden" value="{{$data_list->nopek}}" name="nopek">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">AARD<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="hidden" value="{{$data_list->aard}}" name="aard">
                    <input class="form-control" type="text" value="{{$data_list->aard}} - {{$data_list->nama_aard}}"  readonly style="background-color:#DCDCDC; cursor:not-allowed">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Nilai<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="nilai" type="text" value="<?php echo number_format($data_list->nilai, 2, '.', ''); ?>"  required oninvalid="this.setCustomValidity('Nilai Harus Diisi..')" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');setCustomValidity('')" autocomplete='off' >
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{route('modul_sdm_payroll.potongan_koreksi_gaji.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
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