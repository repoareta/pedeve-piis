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
        <form class="kt-form" id="form-edit">
            @csrf
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                <div class="col-4">
                <?php 
                    $tgl = date_create(now());
                    $tahun = substr($thnbln,0,-2); 
                    $bulan = substr($thnbln,4); 
                ?>
                        <input class="form-control" type="text" value="{{ $bulan }}"   name="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                </div>
                        <div class="col-4" >
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <div class="col-2" >
<<<<<<< Updated upstream
                            <input class="form-control" type="text" value="{{ $suplesi}}"   name="suplesi" size="2" maxlength="2" autocomplete="off" required oninvalid="this.setCustomValidity('Suplesi Harus Diisi...')">
=======
                            <input class="form-control" type="text" value="{{$suplesi}}"   name="suplesi" size="2" maxlength="2" autocomplete="off" required>
>>>>>>> Stashed changes
                        </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
                <div class="col-10">
<<<<<<< Updated upstream
                    <input class="form-control" type="text" value="{{ $keterangan}}" name="keterangan"  size="35" maxlength="35" title="Keterangan" autocomplete="off" required oninvalid="this.setCustomValidity('Keterangan Harus Diisi...')">
=======
                    <input class="form-control" type="text" value="{{$keterangan}}" name="keterangan"  size="35" maxlength="35" title="Keterangan" autocomplete="off" required>
>>>>>>> Stashed changes
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-2 col-form-label"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="1" <?php if ($status == '1' )  echo 'checked' ; ?> type="radio" name="status"> Opening 
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label">Tanggal Opening</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $tanggal}}" name="tanggal" id="tanggal"  size="11" maxlength="11" title="Tanggal Opening" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="2" <?php if ($status == '2' )  echo 'checked' ; ?> type="radio"   name="status"> Stoping
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label">Tanggal Stoping</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $tanggal2}}" name="tanggal2" id="tanggal2" size="11" maxlength="11" title="Tanggal Stoping" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="3" <?php if ($status == '3' )  echo 'checked' ; ?> type="radio"   name="status"> Closing
                            <span></span>
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label">Tanggal Closing</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $tanggal3}}" name="tanggal3" id="tanggal3"  size="11" maxlength="11" title="Tanggal Closing" autocomplete="off">
                </div>
            </div>
            
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('bulan_perbendaharaan.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
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
		
		$('#form-edit').submit(function(){
			$.ajax({
				url  : "{{ route('bulan_perbendaharaan.update') }}",
				type : "POST",
				data : $('#form-edit').serialize(),
				dataType : "JSON",
				headers: {
				    'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					Swal.fire({
						icon  : 'success',
						title : 'Data Berhasil Diedit',
						text  : 'Berhasil',
						timer : 2000
					}).then(function(data) {
						window.location.replace("{{ route('bulan_perbendaharaan.index') }}");
						});
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
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
		$('#tanggal2').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
		$('#tanggal3').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
	});
</script>
@endpush