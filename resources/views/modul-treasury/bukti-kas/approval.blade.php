@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel <span style="color:blue;">{{ $kasDocument->paid == 'N' ? 'Eksekusi' : 'Pembatalan' }}</span> Approval Perbendaharaan - Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" action="{{ route(($kasDocument->paid == 'N' ? 'penerimaan_kas.approve' : 'penerimaan_kas.approval.cancel'), [request()->documentId]) }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">No. Dokumen</label>
                <div class="col-10">
                    <input style="background-color:#e4e6ef; cursor:not-allowed" type="text" class="form-control" name="no_dokumen" value="{{ $kasDocument->docno }}" readonly />
                    <input type="hidden" class="form-control" name="userid" value="{{ auth()->user()->userid }}" />
                </div>
            </div>
            <div class="form-group row">
                <label for="tanggal_approval" class="col-2 col-form-label">Tanggal Approval</label>
                <div class="col-10">
                    <input type="text" class="form-control @error('tanggal_approval') is-invalid @enderror" id="tanggal_approval" name="tanggal_approval" value="{{ old('tanggal_approval') }}" autocomplete="off">
                    @error('tanggal_approval')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('penerimaan_kas.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
        // range picker
        $('#tanggal_approval').datepicker({
            todayHighlight: true,
            autoclose: true,
            language : 'id',
            format   : 'dd-mm-yyyy',
            orientation: 'bottom'
        });
});
</script>
@endpush