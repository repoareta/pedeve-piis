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
                Tambah Jamsostek
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.jamsostek.store') }}" method="post" id="form-create">
            @csrf
            <div class="alert alert-secondary" role="alert">
                <div class="alert-text">
                    <h5 class="kt-portlet__head-title">
                        Header Jamsostek
                    </h5>	
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Pribadi <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="pribadi" type="number" value="" size="2" maxlength="2" autocomplete='off'>
                    @error('pribadi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Accident <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="accident" type="number" value="" size="40" maxlength="50" autocomplete='off'>
                    @error('accident')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Pensiun <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="pensiun" type="number" value="" size="40" maxlength="50" autocomplete='off'>
                    @error('pensiun')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Life <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="life" type="number" value="" size="40" maxlength="50" autocomplete='off'>
                    @error('life')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Manulife <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" name="manulife" type="number" value="" size="40" maxlength="50" autocomplete='off'>
                    @error('manulife')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{route('modul_sdm_payroll.jamsostek.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
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
		$('#form-create').submit(function(){
			$.ajax({
				url  : "{{ route('modul_sdm_payroll.jamsostek.store') }}",
				type : "POST",
				data : $('#form-create').serialize(),
				dataType : "JSON",
				success : function(data){
                    if(data == 1){
                        Swal.fire({
                            icon  : 'success',
                            title : 'Data Berhasil Ditambah',
                            text  : 'Berhasil',
                            timer : 2000
                        }).then(function() {
                                location.href = "{{ route('modul_sdm_payroll.jamsostek.index')}}";
                            });
                    }else{
                        Swal.fire({
                            icon  : 'info',
                            title : 'Duplikasi data, entri dibatalkan.',
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
	});
</script>
@endpush