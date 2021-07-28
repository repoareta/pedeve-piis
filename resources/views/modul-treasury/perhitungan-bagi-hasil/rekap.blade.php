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
                Posisi Saldo Penempatan Deposito
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form kt-form--label-right" action="{{route('perhitungan_bagihasil.export')}}" method="post">
			{{csrf_field()}}
			<div class="kt-portlet__body">
				<div class="form-group row">
					<label for="dari-input" class="col-2 col-form-label">Per Tanggal<span style="color:red;">*</span></label>
					<div class="col-8">
					<input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}">
					</div>
				</div>
				<div class="kt-form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a  href="{{ route('perhitungan_bagihasil.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
						</div>
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
	$('#tanggal').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		// language : 'id',
		format   : 'yyyy-mm-dd'
	});
});
</script>
@endpush