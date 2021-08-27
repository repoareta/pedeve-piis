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
                Ubah Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Panjar Dinas</div>
                    </div>
                </div>
                <form class="form" id="formPanjarDinas" action="{{ route('modul_umum.perjalanan_dinas.update', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No. SPD</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="no_spd" value="{{ $panjar_header->no_panjar }}" id="no_spd">
                        </div>
    
                        <label for="" class="col-2 col-form-label">Tanggal Panjar</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('d-m-Y', strtotime($panjar_header->tgl_panjar)) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nopek-input" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" id="nopek" name="nopek">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                <option value="{{ $pegawai->nopeg }}" @if($pegawai->nopeg == $panjar_header->nopek)
                                    selected
                                @endif>{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek-nya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-5">
                            <select class="form-control select2" style="width: 100% !important;" name="jabatan" id="jabatan">
                                <option value="">- Pilih Jabatan -</option>
                                @foreach ($jabatan_list as $jabatan)
                                    <option value="{{ $jabatan->keterangan }}" @if($jabatan->keterangan == $panjar_header->jabatan)
                                        selected
                                    @endif>{{ $jabatan->keterangan }}</option>
                                @endforeach
                            </select>
                            <div id="jabatan-nya"></div>
                        </div>
    
                        <label for="" class="col-2 col-form-label">Golongan</label>
                        <div class="col-3">
                            <input class="form-control" type="text" readonly name="golongan" id="golongan" value="{{ $panjar_header->gol }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id-pekerja;-input" class="col-2 col-form-label">KTP/Passport</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="ktp" id="ktp" value="{{ $panjar_header->ktp }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Jenis Dinas</label>
                        <div class="col-10">
                            <select class="form-control" name="jenis_dinas" id="jenis_dinas">
                                <option value="">- Pilih Jenis Dinas -</option>
                                <option value="DN" @if($panjar_header->jenis_dinas == 'DN') selected @endif>PDN-DN</option>
                                <option value="LN" @if($panjar_header->jenis_dinas == 'LN') selected @endif>PDN-LN</option>
                                <option value="SIJ" @if($panjar_header->jenis_dinas == 'SIJ') selected @endif>SIJ</option>
                                <option value="CUTI" @if($panjar_header->jenis_dinas == 'CUTI') selected @endif>CUTI</option>
                            </select>
                            <div id="jenis_dinas-nya"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dari-input" class="col-2 col-form-label">Dari/Asal</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="dari" id="dari" value="{{ $panjar_header->dari }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tujuan-input" class="col-2 col-form-label">Tujuan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="tujuan" id="tujuan" value="{{ $panjar_header->tujuan }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                        <div class="col-10">
                            <div class="input-daterange input-group" id="date_range_picker">
                                <input type="text" class="form-control" name="mulai" value="{{ date('d-m-Y', strtotime($panjar_header->mulai)) }}" autocomplete="off" />
                                <div class="input-group-append">
                                    <span class="input-group-text">Sampai</span>
                                </div>
                                <input type="text" class="form-control" name="sampai" value="{{ date('d-m-Y', strtotime($panjar_header->sampai)) }}" autocomplete="off" />
                            </div>
                            <span class="form-text text-muted">Pilih rentang waktu mulai dan sampai</span>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="kendaraan" class="col-2 col-form-label">Kendaraan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="kendaraan" id="kendaraan" value="{{ $panjar_header->kendaraan }}">
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="biaya" class="col-2 col-form-label">Biaya</label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" name="biaya" id="biaya">
                                <option value="">- Pilih Biaya -</option>
                                <option value="P" @if($panjar_header->ditanggung_oleh == 'P') selected @endif>Ditanggung Perusahaan</option>
                                <option value="K" @if($panjar_header->ditanggung_oleh == 'K') selected @endif>Ditanggung Pribadi</option>
                                <option value="U" @if($panjar_header->ditanggung_oleh == 'U') selected @endif>Ditanggung PPU</option>
                            </select>
                            <div id="biaya-nya"></div>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="keterangan" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan" id="keterangan">{{ $panjar_header->keterangan }}</textarea>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="jumlah" class="col-2 col-form-label">Jumlah</label>
                        <div class="col-10">
                            <input class="form-control money" type="text" name="jumlah" id="jumlah" value="{{ float_two($panjar_header->jum_panjar) }}">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_umum.perjalanan_dinas.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>

	@include('modul-umum.perjalanan-dinas._detail.index')
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasUpdate', '#formPanjarDinas') !!}

@stack('detail-scripts')
@endpush
