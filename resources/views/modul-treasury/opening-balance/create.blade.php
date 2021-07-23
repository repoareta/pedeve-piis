@extends('layouts.app')

@push('page-styles')
<style type="text/css">
   #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Add animation to "page content" */
    .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
        from { bottom:-100px; opacity:0 }
        to { bottom:0px; opacity:1 }
    }

    @keyframes animatebottom {
        from{ bottom:-100px; opacity:0 }
        to{ bottom:0; opacity:1 }
    }

    #myDiv {
        display: none;
    }

    </style>
@endpush

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Opening Balance
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form  class="kt-form kt-form--label-right" id="form-create">
            @csrf
            <div class="kt-portlet__body">
                <div class="form-group form-group-last">
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label text-right">Bulan<span style="color:red;">*</span></label>
                        <div class="col-10">
                        <?php 
                            $tgl = date_create(now());
                            $tahun = date_format($tgl, 'Y'); 
                            $bulan = date_format($tgl, 'n'); 
                        ?>
                            <select class="form-control kt-select2"  name="bulan">
                                <option value="01" <?php if($bulan  == 1 ) echo 'selected' ; ?>>Januari</option>
                                <option value="02" <?php if($bulan  == 2 ) echo 'selected' ; ?>>Februari</option>
                                <option value="03" <?php if($bulan  == 3 ) echo 'selected' ; ?>>Maret</option>
                                <option value="04" <?php if($bulan  == 4 ) echo 'selected' ; ?>>April</option>
                                <option value="05" <?php if($bulan  == 5 ) echo 'selected' ; ?>>Mei</option>
                                <option value="06" <?php if($bulan  == 6 ) echo 'selected' ; ?>>Juni</option>
                                <option value="07" <?php if($bulan  == 7 ) echo 'selected' ; ?>>Juli</option>
                                <option value="08" <?php if($bulan  == 8 ) echo 'selected' ; ?>>Agustus</option>
                                <option value="09" <?php if($bulan  == 9 ) echo 'selected' ; ?>>September</option>
                                <option value="10" <?php if($bulan  ==10  ) echo 'selected' ; ?>>Oktober</option>
                                <option value="11" <?php if($bulan  == 11 ) echo 'selected' ; ?>>November</option>
                                <option value="12" <?php if($bulan  == 12 ) echo 'selected' ; ?>>Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label text-right">Tahun<span style="color:red;">*</span></label>
                            <div class="col-10" >
                                <input class="form-control" type="text" value="{{ $tahun }}" name="tahun" size="4" maxlength="4" onkeypress="return hanyaAngka(event)" autocomplete='off' required oninvalid="this.setCustomValidity('Tahun Harus Diisi...')" oninput="setCustomValidity('')">
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label text-right">Suplesi<span style="color:red;">*</span></label>
                            <div class="col-10" >
                                <input class="form-control" type="text" value="0" name="suplesi" size="2" maxlength="2" onkeypress="return hanyaAngka(event)" autocomplete='off' required oninvalid="this.setCustomValidity('Suplesi Harus Diisi...')" oninput="setCustomValidity('')">
                            </div>
                    </div>
                    
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a  href="{{ route('opening_balance.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Process</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="display:none;" id="loader"></div>
<div style="display:true;" id="myDiv" class="animate-bottom"></div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
		$('.kt-select2').select2().on('change', function() {
			$(this).valid();
		});

		$('#form-create').submit(function(){
			$('#loader').show();

			$.ajax({
				url  : "{{route('opening_balance.store')}}",
				type : "POST",
				data : $('#form-create').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
                    if(data == 1){
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Data Berhasil Ditambah',
                            text: 'Berhasil',
                            timer: 2000
                        }).then(function(data) {
                            window.location.replace("{{ route('opening_balance.index') }}");
                            });
                    } else if (data == 2){
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'info',
                            title: 'Data sudah ada, entri dibatalkan',
                            text: 'Info',
                        });
                    } else {
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'info',
                            title: 'Opening balance terakhir adalah! ' +data,
                            text: 'Info',
                        });
                    }
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