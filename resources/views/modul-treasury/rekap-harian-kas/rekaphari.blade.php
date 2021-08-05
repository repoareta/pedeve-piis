@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

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
                Menu Tambah Rekap Harian Kas Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('rekap_harian_kas.ctkharian') }}" method="post">
            @csrf
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Jenis Kartu<span style="color:red;">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" name="jk" value="{{$jk}}"  size="15" maxlength="15" autocomplete='off' readonly style="background-color:#DCDCDC; cursor:not-allowed">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Tanggal<span style="color:red;">*</span></label>
                <div class="col-10" >
                    <input class="form-control" type="text" name="tanggal" value="{{$tanggal}}" id="tanggal" size="15" maxlength="15" autocomplete='off' readonly style="background-color:#DCDCDC; cursor:not-allowed">
                <input class="form-control" type="hidden" name="tglctk" value="{{ date('d F Y') }}" id="tglctk" size="15" maxlength="15" autocomplete='off' required oninvalid="this.setCustomValidity('Tanggal Cetak Harus Diisi..')" onchange="setCustomValidity('')" autocomplete='off'>
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">No.Kas/Bank<span style="color:red;">*</span></label>
                <div class="col-10" >
                    <input class="form-control" type="text" name="nokas" value="{{$nokas}}"  size="15" maxlength="15" autocomplete='off' readonly style="background-color:#DCDCDC; cursor:not-allowed">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Setuju<span style="color:red;">*</span></label>
                <div class="col-4">
                    <input class="form-control" type="text" value="" name="setuju" id="setuju" size="50" maxlength="50" required oninvalid="this.setCustomValidity('Setuju Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
                </div>
                <label class="col-2 col-form-label">Dibuat Oleh<span style="color:red;">*</span></label>
                <div class="col-4" >
                    <input class="form-control" type="text" value="" name="dibuat" id="dibuat" size="50" maxlength="50" required oninvalid="this.setCustomValidity('Dibuat Oleh Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-2"></div>
                <div class="col-10">
                    <a  href="{{ route('rekap_harian_kas.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                    <button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection