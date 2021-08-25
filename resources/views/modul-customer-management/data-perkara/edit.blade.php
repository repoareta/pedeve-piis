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
                Edit Data Perkara
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_cm.data_perkara.update') }}" method="post" id="form-edit">
            @csrf
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">No. Perkara <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{ $data->no_perkara }}" name="no_perkara" size="100" maxlength="100" title="No. Perkara" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Tanggal Perkara</label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{ date('d-m-Y', strtotime($data->tgl_perkara)) }}" name="tgl_perkara" id="tanggal" size="15" maxlength="10" title="Tanggal Perkara" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Jenis</label>
                <div class="col-10">
                    <select name="jenis_perkara" class="form-control select2">
                        <option value="">- Pilih -</option>
                        <option value="perdata" <?php if( $data->jenis_perkara == 'perdata' ) echo 'selected' ; ?>>Perdata</option>		
                        <option value="pidana" <?php if( $data->jenis_perkara == 'pidana' ) echo 'selected' ; ?>>Pidana</option>
                        <option value="kepailitan" <?php if( $data->jenis_perkara == 'kepailitan' ) echo 'selected' ; ?>>Kepailitan</option>
                        <option value="arbitrase" <?php if( $data->jenis_perkara == 'arbitrase' ) echo 'selected' ; ?>>Arbitrase</option>
                        <option value="hubungan industrial" <?php if( $data->jenis_perkara == 'hubungan industrial' ) echo 'selected' ; ?>>Hubungan Industrial</option>						
                    </select>							
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Klasifikasi Perkara</label>
                <div class="col-10">						
                    <input class="form-control" type="text" value="{{ $data->klasifikasi_perkara }}" name="klasifikasi_perkara"  size="100" maxlength="100" title="Klasifikasi Perkara" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Status Perkara</label>
                <div class="col-10">
                    <select name="status_perkara" class="form-control select2">
                        <option value="">- Pilih -</option>		
                        <option value="Pemeriksaan" <?php if( $data->status_perkara == 'Pemeriksaan' ) echo 'selected' ; ?>>Pemeriksaan</option>		
                        <option value="Mediasi" <?php if( $data->status_perkara == 'Mediasi' ) echo 'selected' ; ?>>Mediasi</option>
                        <option value="Persidangan" <?php if( $data->status_perkara == 'Persidangan' ) echo 'selected' ; ?>>Persidangan</option>
                        <option value="Selesai" <?php if( $data->status_perkara == 'Selesai' ) echo 'selected' ; ?>>Selesai</option>
                        <option value="Inkracht" <?php if( $data->status_perkara == 'Inkracht' ) echo 'selected' ; ?>>Inkracht</option>						
                        <option value="Banding" <?php if( $data->status_perkara == 'Banding' ) echo 'selected' ; ?>>Banding</option>						
                        <option value="Kasasi" <?php if( $data->status_perkara == 'Kasasi' ) echo 'selected' ; ?>>Kasasi</option>						
                        <option value="Peninjauan Kembali" <?php if( $data->status_perkara == 'Peninjauan Kembali' ) echo 'selected' ; ?>>Peninjauan Kembali</option>						
                        <option value="Arbitrase" <?php if( $data->status_perkara == 'Arbitrase' ) echo 'selected' ; ?>>Arbitrase</option>						
                    </select>							
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Ringkasan Perkara</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="r_perkara" title="Ringkasan Perkara" autocomplete='off'>{{ $data->r_perkara }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Ringkasan Petitum</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="r_patitum" title="Ringkasan Petitum" autocomplete='off'>{{ $data->r_patitum }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Ringkasan Putusan</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="r_putusan" title="Ringkasan Putusan" autocomplete='off'>{{ $data->r_putusan }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">CI</label>
                <div class="col-8 col-form-label">
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" value="1" name="ci" id="idr" onclick="displayResult(1)" {{ $data->ci == '1' ? 'checked' : null }}>
                        <span></span>Rp</label>
                        <label class="radio">
                            <input type="radio" value="2" name="ci" id="usd" onclick="displayResult(2)" {{ $data->ci == '1' ? null : 'checked' }}>
                        <span></span>US $</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Nilai Perkara <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control money" type="text" name="nilai_perkara" size="25" maxlength="20" title="Nilai Perkara" autocomplete='off' value="{{ $data->nilai_perkara }}">
                </div>
            </div>
                                                            
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{route('modul_cm.data_perkara.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\DataPerkaraStoreRequest', '#form-edit'); !!}

<script>
    $(document).ready(function () {
		$('#tabel-detail-permintaan').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});
			
		$("input[name=ci]:checked").each(function() {  
			var ci = $(this).val();
			if(ci == 1)
			{
				$('#kurs').val(1);
				$('#simbol-kurs').hide();
				$( "#kurs" ).prop( "required", false );
				$( "#kurs" ).prop( "readonly", true );
				$('#kurs').css("background-color","#e4e6ef");
				$('#kurs').css("cursor","not-allowed");
			}else{
				var kurs1 = $('#data-kurs').val();
				$('#kurs').val(kurs1);
				$('#simbol-kurs').show();
				$( "#kurs" ).prop( "required", true );
				$( "#kurs" ).prop( "readonly", false );
				$('#kurs').css("background-color","#ffffff");
				$('#kurs').css("cursor","text");
			}
				
		});
		
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
                        console.log(result);
                        $(this).unbind('submit').submit();
                    }
                });
            }
		});
		
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			format   : 'dd-mm-yyyy'
		});
	});
	
  
    function displayResult(ci){ 
        if(ci == 1)
        {
            $('#kurs').val(1);
            $('#simbol-kurs').hide();
            $( "#kurs" ).prop( "required", false );
            $( "#kurs" ).prop( "readonly", true );
            $('#kurs').css("background-color","#e4e6ef");
            $('#kurs').css("cursor","not-allowed");
        }else{
            $('#kurs').val("");
            $('#simbol-kurs').show();
            $( "#kurs" ).prop( "required", true );
            $( "#kurs" ).prop( "readonly", false );
            $('#kurs').css("background-color","#ffffff");
            $('#kurs').css("cursor","text");
        }
    }
</script>
@endpush