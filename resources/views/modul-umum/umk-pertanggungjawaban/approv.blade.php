@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Approval Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.store.app') }}" method="post" id="form-approve">
            @csrf
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">No.Dokumen</label>
                <div class="col-10">
                    <input type="text" class="form-control disabled bg-secondary" name="no_pumk" value="{{ $pumk_header->no_pumk }}" readonly />
                    <input type="text" hidden name="userid" value="{{ auth()->user()->userid }}" readonly />
                </div>
            </div>
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Tanggal Approval</label>
                <div class="col-10">
                    <div class="input-daterange input-group" >
                        <input type="text" class="form-control" name="tgl_app" id="tgl_app" autocomplete='off' required/>
                    </div>
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{route('modul_umum.uang_muka_kerja.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
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
        $('#tgl_app').datepicker({
            todayHighlight: true,
            autoclose: true,
            language : 'id',
            format   : 'dd-mm-yyyy',
            orientation: 'bottom'
        });
    });
</script>
@endpush