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
                Penerimaan Hadiah/Cindera Mata dan Hiburan (Entertaiment)
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="formPermintaan" action="{{ route('modul_sdm_payroll.gcg.gratifikasi.permintaan.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="permintaan_bulan_lalu" class="col-3 col-form-label">Tidak ada permintaan bulan lalu</label>
						<div class="col-9">
							<div class="checkbox-inline">
								<label class="checkbox checkbox--brand">
									<input type="checkbox" name="permintaan_bulan_lalu" value="1"> *Klik pada kotak jika tidak ada permintaan untuk periode bulan lalu
									<span></span>
								</label>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="tanggal_permintaan" class="col-3 col-form-label">Tanggal Permintaan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="tanggal_permintaan" id="tanggal_permintaan">
						</div>
					</div>

					<div class="form-group row">
						<label for="peminta" class="col-3 col-form-label">Peminta</label>
						<div class="col-9">
							<input class="form-control" type="text" name="peminta" id="peminta">
						</div>
					</div>

					<div class="form-group row">
						<label for="bentuk_jenis_permintaan" class="col-3 col-form-label">Bentuk/Jenis yang diberikan</label>
						<div class="col-9">
							<input class="form-control" type="text" name="bentuk_jenis_permintaan" id="bentuk_jenis_permintaan">
						</div>
					</div>

					<div class="form-group row">
						<label for="" class="col-3 col-form-label">Nilai yang diberi (Rp)</label>
						<div class="col-9">
							<input class="form-control money" type="text" name="nilai" id="nilai">
						</div>
					</div>

					<div class="form-group row">
						<label for="jumlah" class="col-3 col-form-label">Jumlah Hadiah</label>
						<div class="col-9">
							<input class="form-control" type="text" name="jumlah" id="jumlah">
						</div>
					</div>

					<div class="form-group row">
						<label for="keterangan" class="col-3 col-form-label">Permintaan dalam rangka</label>
						<div class="col-9">
							<input class="form-control" type="text" name="keterangan" id="keterangan">
						</div>
					</div>

					<div class="form__actions">
						<div class="row">
							<div class="col-3"></div>
							<div class="col-9">
								<a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
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
		$('#tanggal_permintaan').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'yyyy-mm-dd'
		});
	});
</script>
@endpush
