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
                Tabel Cetak Penempatan Deposito
            </h3>
        </div>
	</div>

	<div class="card-body">
		<form class="form" action="{{ route('modul_kontroler.tabel_deposito.export') }}" method="POST">
			@csrf
			<div class="portlet__body">
				<input class="form-control" type="hidden" name="userid" value="{{ Auth::user()->userid }}">
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Bank</label>
					<div class="col-10">
						<select name="sanper" class="form-control select2" style="width: 100% !important;"
							oninvalid="this.setCustomValidity('Bank Harus Diisi..')">
							<option value="">- All -</option>
							@foreach($data_bank as $data)
							<option value="{{ $data->kdbank }}">{{ $data->kdbank }} -- {{ $data->descacct }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
					<div class="col-5">
						<?php 
						$tahun = date('Y');
						$bulan = date('m');
						$kurs = 1;
						?>
						<select class="form-control select2" style="width: 100% !important;" name="bulan">
							<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
							<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
							<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
							<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
							<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
							<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
							<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
							<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
							<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
							<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
							<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
							<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
						</select>
					</div>
					<div class="col-5">
						<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
					</div>
					<div class="col-2">
						<input class="form-control" type="hidden" name="tanggal" value="{{ date('d-m-Y') }}" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Kurs<span class="text-danger">*</span></label>
					<div class="col-10">
						<input class="form-control" type="text" name="kurs" value="{{ $kurs}}" size="15" maxlength="15"
							autocomplete="off" required oninvalid="this.setCustomValidity('Kurs Harus Diisi..')">
					</div>
				</div>
				<div class="form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a href="{{ route('modul_kontroler.tabel_deposito.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function () {
	
	$('#tanggal').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		language : 'id',
		format   : 'dd MM yyyy'
	});
});
</script>
@endsection