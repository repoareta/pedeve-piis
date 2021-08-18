@extends('layouts.app')

@section('breadcrumbs')
{{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Edit Koreksi Gaji
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.potongan_koreksi_gaji.update') }}" method="post" id="form-edit">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-custom alert-default" role="alert">
                    <div class="alert-text">
                        Header Koreksi Gaji
                    </div>
                </div>
            </div>
            <div class="form-group row">
            <label for="spd-input" class="col-2 col-form-label">Bulan/Tahun <span class="text-danger">*</span></label>
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
            <input class="form-control" type="text" value="{{ $bulan }}" disabled>
            <input class="form-control" type="hidden" value="{{ $data_list->bulan }}" name="bulan">
            <input class="form-control" type="hidden" value="{{ $data_list->tahun }}" name="tahun">
                    
            </div>
                <div class="col-6">
                    <input class="form-control" type="text" value="{{ $data_list->tahun }}" disabled>
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid }}"  name="userid" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Pegawai <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{ $data_list->nopek}} - {{ $data_list->nama_nopek}}"  disabled>
                    <input class="form-control" type="hidden" value="{{ $data_list->nopek}}" name="nopek">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">AARD <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="hidden" value="{{ $data_list->aard}}" name="aard">
                    <input class="form-control" type="text" value="{{ $data_list->aard}} - {{ $data_list->nama_aard}}"  disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Nilai <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="nilai" type="number" value="{{ $data_list->nilai }}" required autocomplete="off">
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
<script>
    $(document).ready(function () {
        $('#bulan').select2();

        $('#form-edit').submit(function(e){
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