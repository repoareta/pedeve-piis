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
                @if($status == 'Y')
				Tabel <span style="color:blue;">Pembatalan</span> Approval Pemabayaran UMK Pekerja
                @elseif($status == 'N')
				Tabel <span style="color:blue;">Eksekusi</span> Approval Pemabayaran UMK Pekerja
                @endif
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" action="{{ route('pembayaran_umk.store.app') }}" method="post">
            @csrf
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">No.Dokumen</label>
                <div class="col-10">
                    <input style="background-color:#DCDCDC; cursor:not-allowed" type="text" class="form-control" name="nodok" value="{{ $data->docno}}" readonly />
                    <input type="text" class="form-control" hidden name="userid" value="{{ auth()->user()->userid }}" readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Tanggal Approval</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="tgl_app" id="date_range_picker" value="" autocomplete="off" required oninvalid="this.setCustomValidity('Tanggal Approval Harus Diisi..')"/>
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('pembayaran_gaji.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
    // Class definition
    var KTBootstrapDatepicker = function () {
    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }
    // Private functions
    var demos = function () {
        // range picker
        $('#date_range_picker').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows,
            autoclose: true,
            // language : 'id',
            format   : 'yyyy-mm-dd',
            orientation: 'bottom'
        });
    };
    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
    }();
        KTBootstrapDatepicker.init(); 
    });
</script>
@endpush