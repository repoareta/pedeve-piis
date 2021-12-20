@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Kursus
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.kursus.update', ['pegawai' => $pegawai->nopeg, 'mulai' => $mulai, 'nama' => $nama]) }}" method="post" id="form-edit-kursus">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Nama Kursus</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nama_kursus" id="nama_kursus" value="{{ $kursus->nama }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Penyelenggara</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="penyelenggara_kursus" id="penyelenggara_kursus" value="{{ $kursus->penyelenggara }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Mulai</label>
                        <div class="col-4">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="mulai_kursus" id="mulai_kursus" value="{{ $kursus->mulai->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <label for="" class="col-2 col-form-label">Sampai</label>
                        <div class="col-4">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="sampai_kursus" id="sampai_kursus" value="{{ $kursus->sampai->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row has-success">
                        <label for="" class="col-2 col-form-label">Negara</label>
                        <div class="col-10">
                            <input class="form-control valid" type="text" name="negara_kursus" id="negara_kursus" value="{{ $kursus->negara }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Kota</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="kota_kursus" id="kota_kursus" value="{{ $kursus->kota }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="keterangan_kursus" id="keterangan_kursus" value="{{ $kursus->keterangan }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_sdm_payroll.master_pegawai.edit', ['pegawai' => $pegawai->nopeg]) }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\KursusUpdate', '#form-edit-kursus') !!}
@endpush
