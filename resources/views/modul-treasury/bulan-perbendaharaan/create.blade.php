@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Setting Bulan Buku
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" id="form-create">
            @csrf
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Bulan/Tahun<span class="text-danger">*</span></label>
                <div class="col-4">
                    <select class="form-control select2" style="width: 100% !important;" name="bulan">
                        <option value="01" <?php if($bulan == 1) echo 'selected'; ?>>Januari</option>
                        <option value="02" <?php if($bulan == 2) echo 'selected'; ?>>Februari</option>
                        <option value="03" <?php if($bulan == 3) echo 'selected'; ?>>Maret</option>
                        <option value="04" <?php if($bulan == 4) echo 'selected'; ?>>April</option>
                        <option value="05" <?php if($bulan == 5) echo 'selected'; ?>>Mei</option>
                        <option value="06" <?php if($bulan == 6) echo 'selected'; ?>>Juni</option>
                        <option value="07" <?php if($bulan == 7) echo 'selected'; ?>>Juli</option>
                        <option value="08" <?php if($bulan == 8) echo 'selected'; ?>>Agustus</option>
                        <option value="09" <?php if($bulan == 9) echo 'selected'; ?>>September</option>
                        <option value="10" <?php if($bulan == 10) echo 'selected'; ?>>Oktober</option>
                        <option value="11" <?php if($bulan == 11) echo 'selected'; ?>>November</option>
                        <option value="12" <?php if($bulan == 12) echo 'selected'; ?>>Desember</option>
                    </select>
                </div>
                <div class="col-4">
                    <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" autocomplete="off">
                </div>
                <div class="col-2">
                    <input class="form-control" type="text" value="0" name="suplesi" size="2" maxlength="2" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Keterangan<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="" name="keterangan" size="35" maxlength="35" title="Keterangan" autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="1" type="radio" name="status" checked>
                            <span></span> Opening
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Opening</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal" id="tanggal" size="11" maxlength="11" title="Tanggal Opening" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="2" type="radio" name="status">
                            <span></span> Stoping
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Stoping</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal2" id="tanggal2" size="11" maxlength="11"
                        title="Tanggal Stoping" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right"></label>
                <div class="col-3">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="3" type="radio" name="status">
                            <span></span> Closing
                        </label>
                    </div>
                </div>
                <label for="" class="col-2 col-form-label text-right">Tanggal Closing</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="" name="tanggal3" id="tanggal3" size="11" maxlength="11"
                        title="Tanggal Closing" autocomplete="off">
                </div>
            </div>

            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('bulan_perbendaharaan.index') }}" class="btn btn-warning"><i class="fa fa-reply"
                                aria-hidden="true"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"
                                aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\BulanPerbendaharaanStoreRequest', '#form-create'); !!}

<script>
    $(document).ready(function () {
		$('#form-create').submit(function(e){
            e.preventDefault();
            
            if($(this).valid()) {
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
                    } else {
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
            }
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