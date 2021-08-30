@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Akta
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_cm.perusahaan_afiliasi.akta.store', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}" method="POST" id="form-create" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="hidden" name="perusahaan_afiliasi_id" id="perusahaan_afiliasi_id" value="{{ $perusahaan_afiliasi->id }}">
                    <input class="form-control" type="hidden" name="created_by" id="created_by" value="{{ auth()->user()->nopeg }}">
                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Jenis</label>
						<div class="col-10">
							<input class="form-control" type="text" name="jenis_akta" id="jenis_akta">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Nomor</label>
						<div class="col-10">
							<input class="form-control" type="text" name="nomor_akta" id="nomor_akta">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Tanggal Akta</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="tanggal_akta" id="tanggal_akta" autocomplete="off">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Notaris</label>
						<div class="col-10">
							<input class="form-control" type="text" name="notaris" id="notaris">
						</div>
                    </div>
                    
                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">TMT Berlaku</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="tmt_berlaku" id="tmt_berlaku" autocomplete="off">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">TMT Berakhir</label>
						<div class="col-10">
							<input class="form-control datepicker" type="text" name="tmt_berakhir" id="tmt_berakhir" autocomplete="off">
						</div>
                    </div>

                    <div class="form-group row">
						<label for="" class="col-2 col-form-label">Dokumen Akta</label>
						<div class="col-10">
							<div class="input-group control-group after-add-more">
                                <input type="file" name="filedok[]" class="form-control" title="Dokumen" accept=".pdf,.jpg,.jpeg">
                                <div class="input-group-append">
                                    <button class="btn btn-primary add-more" type="button"><i class="fas fa-plus"></i> Tambah</button>
                                </div>
							</div>
							@if(count($errors) > 0)
								@foreach ($errors->all() as $error)
								<span class="text-danger">Format harus pdf, jpeg, jpg dan png</span>
								@endforeach
							@else
								<span>Format file pdf, jpeg, jpg dan png</span>
							@endif
						</div>
					</div>
					<div style="display:none;">
						<div class="copy hide">
                            <div class="input-group control-group my-2">
                                <input type="file" name="filedok[]" class="form-control" title="Dokumen" accept=".pdf,.jpg,.jpeg">
                                <div class="input-group-append">
                                    <button class="btn btn-danger remove" type="button"><i class="fas fa-minus"></i> Hapus</button>
                                </div>
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
{!! JsValidator::formRequest('App\Http\Requests\AktaStore', '#form-create') !!}

<script>
    $(document).ready(function () {
        $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
		});

        $("body").on("click",".remove",function(){ 
			$(this).parents(".control-group").remove();
		});
    });
</script>
@endpush
