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
                Cetak Cash Flow Per Periode
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form kt-form--label-right" action="{{route('kas_bank.cetak8')}}" method="GET" target="_blank">
            @csrf
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                <div class="col-10">
                    <div class="input-daterange input-group" id="date_range_picker">
                        <input type="text" class="form-control" name="mulai" autocomplete="off" />
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input type="text" class="form-control" name="sampai" autocomplete="off" />
                    </div>
                    <span class="form-text text-muted">Pilih rentang waktu cash flow</span>
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Kurs<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input type="text" class="form-control" name="kurs">							
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{ route('dashboard.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
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
		format   : 'dd MM yyyy'
	});

    $('#date_range_picker').datepicker({
        todayHighlight: true,
        format   : 'yyyy-mm-dd',
        orientation: "bottom left",
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