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
                Pemberian Hadiah/Cindera Mata dan Hiburan (Entertaiment)
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="kt-form kt-form--label-right" id="formPemberian" action="{{ route('modul_sdm_payroll.gcg.gratifikasi.pemberian.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="pemberian_bulan_lalu" class="col-3 col-form-label">Tidak ada pemberian bulan lalu</label>
						<div class="col-9">
							<div class="kt-checkbox-inline">
								<label class="kt-checkbox kt-checkbox--brand">
									<input type="checkbox" name="pemberian_bulan_lalu" value="1"> *Klik pada kotak jika tidak ada pemberian untuk periode bulan lalu
									<span></span>
								</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="tanggal_pemberian" class="col-3 col-form-label">Tanggal Pemberian</label>
						<div class="col-9">
							<input class="form-control" type="text" name="tanggal_pemberian" id="tanggal_pemberian">
						</div>
					</div>

					<div class="form-group row">
						<label for="bentuk_jenis_pemberian" class="col-3 col-form-label">Bentuk/Jenis yang diberikan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="bentuk_jenis_pemberian" id="bentuk_jenis_pemberian">
						</div>
					</div>

					<div class="form-group row">
						<label for="nilai" class="col-3 col-form-label">Nilai Pemberian</label>
						<div class="col-9">
							<input class="form-control money" type="text" name="nilai" id="nilai">
						</div>
					</div>

					<div class="form-group row">
						<label for="jumlah" class="col-3 col-form-label">Jumlah yang diberikan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="jumlah" id="jumlah">
						</div>
					</div>

					<div class="form-group row">
						<label for="penerima_hadiah" class="col-3 col-form-label">Penerima Hadiah</label>
						<div class="col-9">
							<input class="form-control" type="text" name="penerima_hadiah" id="penerima_hadiah">
						</div>
					</div>

					<div class="form-group row">
						<label for="keterangan" class="col-3 col-form-label">Keterangan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="keterangan" id="keterangan">
						</div>
					</div>

					<div class="kt-form__actions">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-9">
								<a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
							</div>
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		// minimum setup
		$('#tanggal_pemberian').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'yyyy-mm-dd'
		});
	});
</script>
@endpush
