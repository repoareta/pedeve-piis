@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Akta
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_cm.perusahaan_afiliasi.perizinan.update', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id, 'perizinan' => $perizinan]) }}" method="POST" id="form-edit" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="hidden" name="perusahaan_afiliasi_id" id="perusahaan_afiliasi_id" value="{{ $perusahaan_afiliasi->id }}">
                    <input class="form-control" type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->nopeg }}">
                    <div class="form-group row">
						<label for="keterangan" class="col-2 col-form-label">Keterangan</label>
						<div class="col-10">
							<input class="form-control" type="text" name="keterangan" id="keterangan" value="{{ $perizinan->keterangan }}">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="nomor" class="col-2 col-form-label">Nomor</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nomor" id="nomor" value="{{ $perizinan->nomor }}">
						</div>
					</div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Masa Berlaku Akhir</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="masa_berlaku_akhir" id="masa_berlaku_akhir" autocomplete="off" value="{{ date('d-m-Y', strtotime($perizinan->masa_berlaku_akhir)) }}">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Dokumen Upload</label>
						<div class="col-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="dokumen_perizinan" title="Dokumen Akta" accept=".pdf">
                                <label class="custom-file-label" for="customFile">Pilih File</label>
                                <span class="form-text text-muted" id="photo-nya">Tipe dokumen: .pdf</span>
                                <div id="dokumen_perizinan-nya"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_cm.perusahaan_afiliasi.edit', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerizinanUpdate', '#form-edit') !!}

<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            format   : 'dd-mm-yyyy'
        });
    });
</script>
@endpush
