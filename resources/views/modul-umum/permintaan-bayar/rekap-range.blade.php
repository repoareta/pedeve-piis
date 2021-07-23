@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Umum Rekap Permintaan Bayar
            </h3>
        </div>
    </div>
    <div class="card-body">
        <form class="kt-form kt-form--label-right" action="{{ route('modul_umum.permintaan_bayar.rekap.export') }}" method="post" id="formRekapSPD">
            @csrf
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                <div class="col-8">
                    <div class="input-daterange input-group" id="date_range_picker">
                        <input type="text" class="form-control" name="mulai" autocomplete="off" />
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input type="text" class="form-control" name="sampai" autocomplete="off" />
                    </div>
                    <span class="form-text text-muted">Pilih rentang waktu rekap panjar dinas</span>
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                        <button type="submit" onclick="exportPDF()" name="submit" value="pdf" class="btn btn-danger"><i class="fa fa-file-pdf" aria-hidden="true"></i> Export .PDF</button>
                        <button type="submit" onclick="exportNonPDF()" name="submit" value="csv" class="btn btn-success"><i class="fa fa-file-csv" aria-hidden="true"></i> Export .CSV</button>
                        <button type="submit" onclick="exportNonPDF()" name="submit" value="xlsx" class="btn btn-success"><i class="fa fa-file-excel" aria-hidden="true"></i> Export .XLSX</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\RekapSPDStore', '#formRekapSPD') !!}
<script type="text/javascript">
    $(document).ready(function () {
        // range picker
        $('#date_range_picker').datepicker({
            todayHighlight: true,
            format   : 'yyyy-mm-dd',
        });

        $("#formRekapSPD").on('submit', function(){
            if ($('#sampai-error').length){
                $("#sampai-error").addClass("float-right");
            }
        });
    });

    function exportPDF() {
        $("#formRekapSPD").attr("target", "_blank");
    }

    function exportNonPDF() {
        $("#formRekapSPD").removeAttr("target", "_blank");
    }
</script>
@endpush
