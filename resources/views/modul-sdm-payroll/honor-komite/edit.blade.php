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
                Edit Honorarium Komite/Rapat
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.honor_komite.update') }}" method="post" id="form-edit">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-secondary" role="alert">
                    <div class="alert-text">
                        <h5 class="kt-portlet__head-title">
                            Header Honorarium Komite/Rapat
                        </h5>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                <div class="col-5">
                <?php 
                    $array_bln = array (
                        1 => 'Januari',
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
                <input class="form-control" type="text" value="{{$bulan}}" disabled>
                <input class="form-control" type="hidden" value="{{$data_list->bulan}}" name="bulan"> 
                <input class="form-control" type="hidden" value="{{$data_list->tahun}}" name="tahun"> 
            </div>
                <div class="col-5" >
                    <input class="form-control" type="text" value="{{$data_list->tahun}}" name="tahun" disabled>
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Pegawai<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{$data_list->nopek}} - {{$data_list->nama_nopek}}" disabled>
                    <input class="form-control" type="hidden" value="{{$data_list->nopek}}" name="nopek">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Nilai<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="nilai" type="text" value="<?php echo number_format($data_list->nilai, 2, '.', ''); ?>" required autocomplete='off'>
                    <input type="hidden" value="<?php echo number_format($data_list->pajak, 2, '.', ''); ?>" name="pajak" id="pajak">
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
<script type="text/javascript">
	$(document).ready(function () {
		$('#nilai').keyup(function(){
            var nilai=parseInt($('#nilai').val());
            var pajak=(35/65)*nilai;
			var a =parseInt(pajak);
            $('#pajak').val(a);
        });
		$('#form-edit').submit(function(){
			$.ajax({
				url  : "{{route('modul_sdm_payroll.honor_komite.update')}}",
				type : "POST",
				data : $('#form-edit').serialize(),
				dataType : "JSON",
				success : function(data){
                    console.log(data);
                    Swal.fire({
                        icon  : 'success',
                        title : 'Data Berhasil Diubah',
                        text  : 'Berhasil',
                        timer : 2000
                    }).then(function() {
                        window.location.href = "{{ route('modul_sdm_payroll.honor_komite.index')}}";
                    });
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});	
			return false;
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