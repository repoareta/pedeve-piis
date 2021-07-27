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
                Tambah Setting Bulan Buku
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form  class="kt-form kt-form--label-right" id="form-create">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label text-right">Bulan/Tahun<span style="color:red;">*</span></label>
                <div class="col-4">
                    <?php 
                    $tgl = date_create(now());
                    $tahun = date_format($tgl, 'Y'); 
                    $bulan = date_format($tgl, 'n'); 
                ?>
                    <select class="form-control select2" style="width: 100% !important;" name="bulan">
                        <option value="01" <?php if($bulan  == 1 ) echo 'selected' ; ?>>Januari</option>
                        <option value="02" <?php if($bulan  == 2 ) echo 'selected' ; ?>>Februari</option>
                        <option value="03" <?php if($bulan  == 3 ) echo 'selected' ; ?>>Maret</option>
                        <option value="04" <?php if($bulan  == 4 ) echo 'selected' ; ?>>April</option>
                        <option value="05" <?php if($bulan  == 5 ) echo 'selected' ; ?>>Mei</option>
                        <option value="06" <?php if($bulan  == 6 ) echo 'selected' ; ?>>Juni</option>
                        <option value="07" <?php if($bulan  == 7 ) echo 'selected' ; ?>>Juli</option>
                        <option value="08" <?php if($bulan  == 8 ) echo 'selected' ; ?>>Agustus</option>
                        <option value="09" <?php if($bulan  == 9 ) echo 'selected' ; ?>>September</option>
                        <option value="10" <?php if($bulan  == 10 ) echo 'selected' ; ?>>Oktober</option>
                        <option value="11" <?php if($bulan  == 11 ) echo 'selected' ; ?>>November</option>
                        <option value="12" <?php if($bulan  == 12 ) echo 'selected' ; ?>>Desember</option>
                    </select>
                </div>
                <div class="col-4">
                    <input class="form-control" type="text" value="{{$tahun}}" name="tahun" size="4" maxlength="4"
                        onkeypress="return hanyaAngka(event)" autocomplete='off' required
                        oninvalid="this.setCustomValidity('Tahun Harus Diisi...')" oninput="setCustomValidity('')">
                </div>
                <div class="col-2">
                    <input class="form-control" type="text" value="0" name="suplesi" size="2" maxlength="2"
                        onkeypress="return hanyaAngka(event)" autocomplete='off' required
                        oninvalid="this.setCustomValidity('Suplesi Harus Diisi...')" oninput="setCustomValidity('')">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Keterangan<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="" name="keterangan" size="35" maxlength="35"
                        title="Keterangan" autocomplete='off' required
                        oninvalid="this.setCustomValidity('Keterangan Harus Diisi...')" oninput="setCustomValidity('')">
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--solid">
                            <input value="1" type="radio" name="status" checked> Opening
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Opening</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal" id="tanggal" size="11" maxlength="11"
                        title="Tanggal Opening" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--solid">
                            <input value="2" type="radio" name="status"> Stoping
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Stoping</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal2" id="tanggal2" size="11" maxlength="11"
                        title="Tanggal Stoping" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--solid">
                            <input value="3" type="radio" name="status"> Closing
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Closing</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal3" id="tanggal3" size="11" maxlength="11"
                        title="Tanggal Closing" autocomplete='off'>
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{route('bulan_perbendaharaan.index')}}" class="btn btn-warning"><i class="fa fa-reply"
                                aria-hidden="true"></i>Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"
                                aria-hidden="true"></i>Save</button>
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
		        
		$('#form-create').submit(function(){
			$.ajax({
				url  : "{{ route('bulan_perbendaharaan.store') }}",
				type : "POST",
				data : $('#form-create').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
				if(data == 1){
					Swal.fire({
						icon  : 'success',
						title : 'Data Berhasil Ditambah',
						text  : 'Berhasil',
						timer : 2000
					}).then(function(data) {
						location.href = "{{ route('bulan_perbendaharaan.index') }}";
						});
				}else{
					Swal.fire({
						icon  : 'info',
						title : 'Duplikasi data dokumen, entri dibatalkan.',
						text  : 'Info',
					});
				}
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});	
			return false;
		});

		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'dd-mm-yyyy'
		});
		$('#tanggal2').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'dd-mm-yyyy'
		});
		$('#tanggal3').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'dd-mm-yyyy'
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