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
        <form class="form" action="{{ route('modul_umum.permintaan_bayar.rekap.export') }}" method="POST" target="_blank">
            @csrf

            <div class="form-group row">
				<label for="jenis-dinas-input" class="col-2 col-form-label">Kepada</label>
				<div class="col-10">
                @foreach($data_report as $data)
					<input class="form-control" type="hidden" value="{{$data->no_bayar}}" name="nobayar" id="nobayar" size="50" maxlength="200" readonly>
				@endforeach
                    <input class="form-control" type="text" value="MAN. FINANCE" name="kepada" id="kepada" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Kepada Harus Diisi...')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
			</div>
            <div class="form-group row">
				<label for="jenis-dinas-input" class="col-2 col-form-label">Dari</label>
				<div class="col-10">
					<input class="form-control" type="text" value="IA & RM" name="dari" id="dari" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Dari Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Menyetujui <span class="text-danger">*</span></label>
				<div class="col-5">
					<input class="form-control" type="text" value="{{$setuju}}" name="menyetujui" id="menyetujui" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Menyetujui Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
				<label class="col-2 col-form-label">Jabatan <span class="text-danger">*</span></label>
				<div class="col-3" >
					<input class="form-control" type="text" value="{{$setujus}}" name="menyetujuijb" id="menyetujuijb" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Jabatan Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-2 col-form-label">Pemohon <span class="text-danger">*</span></label>
				<div class="col-5">
					<input class="form-control" type="text" value="{{$pemohon}}" name="pemohon" id="pemohon" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Pemohon Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
				<label class="col-2 col-form-label">Jabatan <span class="text-danger">*</span></label>
				<div class="col-3" >
					<input class="form-control" type="text" value="{{$pemohons}}" name="pemohonjb" id="pemohonjb" size="50" maxlength="200" required oninvalid="this.setCustomValidity('Jabatan Harus Diisi..')" oninput="setCustomValidity('')" autocomplete='off'>
				</div>
			</div>
            <div class="form-group row">
				<label for="jenis-dinas-input" class="col-2 col-form-label">Tanggal Cetak</label>
				<div class="col-10">
                    <input class="form-control" type="text" name="tglsurat" value="{{date('d/m/Y')}}"  id="tglsurat" size="15" maxlength="15" required autocomplete='off'>
				</div>
			</div>

            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_umum.permintaan_bayar.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection

@push('page-scripts')

@endpush
