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
                Edit Keluarga
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.master_pegawai.keluarga.update', ['pegawai' => $pegawai->nopeg, 'status' => $keluarga->status, 'nama' => $keluarga->nama]) }}" method="POST" id="form-keluarga" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Nama</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nama" id="nama" value="{{ $keluarga->nama }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Status</label>
                        <div class="col-10">
                            <select class="form-control select2" id="status" name="status" style="width: 100% !important;">
                                <option value="">- Pilih Status -</option>
                                <option {{ $keluarga->status == 'S' ? 'selected' : null }} value="S">Suami</option>
                                <option {{ $keluarga->status == 'I' ? 'selected' : null }} value="I">Istri</option>
                                <option {{ $keluarga->status == 'A' ? 'selected' : null }} value="A">Anak</option>
                            </select>
                            <div id="status-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Tempat Lahir</label>
                        <div class="col-4">
                            <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" value="{{ $keluarga->tempatlahir }}">
                        </div>

                        <label for="" class="col-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-4">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir" value="{{ $keluarga->tgllahir->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Agama</label>
                        <div class="col-10">
                            <select class="form-control select2" name="agama" id="agama" style="width: 100% !important;">
                                <option value="">- Pilih Agama -</option>
                                @foreach ($agama_list as $agama)
                                    <option value="{{ $agama->kode }}" {{ $keluarga->agama == $agama->kode ? 'selected' : null }}>{{ $agama->nama }}</option>
                                @endforeach
                            </select>
                            <div id="agama-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Golongan Darah</label>
                        <div class="col-10">
                            <select class="form-control select2" name="golongan_darah" id="golongan_darah" style="width: 100% !important;">
                                <option value=""> - Pilih Golongan Darah- </option>
                                    <option {{ $keluarga->goldarah == 'A' ? 'selected' : null }} value="A">A</option>
                                    <option {{ $keluarga->goldarah == 'B' ? 'selected' : null }} value="B">B</option>
                                    <option {{ $keluarga->goldarah == 'AB' ? 'selected' : null }} value="AB">AB</option>
                                    <option {{ $keluarga->goldarah == 'O' ? 'selected' : null }} value="O">O</option>
                            </select>
                            <div id="golongan_darah-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Pendidikan</label>
                        <div class="col-4">
                            <select class="form-control select2" name="pendidikan" id="pendidikan" style="width: 100% !important;">
                                <option value="">- Pilih Pendidikan -</option>
                                @foreach ($pendidikan_list as $pendidikan)
                                    <option value="{{ $pendidikan->kode }}" {{ $keluarga->kodependidikan == $pendidikan->kode ? 'selected' : null }}>{{ $pendidikan->nama }}</option>
                                @endforeach
                            </select>
                            <div id="pendidikan-nya"></div>
                        </div>

                        <label for="" class="col-2 col-form-label" style="padding-right:0px;">Tempat Pendidikan</label>
                        <div class="col-4">
                            <input class="form-control" type="text" name="tempat_pendidikan" id="tempat_pendidikan" value="{{ $keluarga->tempatpendidikan }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <div class="image-input image-input-outline" id="kt_image_4" style="background-image: url({{ asset('assets/media/users/blank.png') }})">
                                <div class="image-input-wrapper" style="background-image: url({{ asset('assets/media/users/default.jpg') }})"></div>
                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="photo" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="profile_avatar_remove"/>
                                </label>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                            <span class="form-text text-muted" id="photo-nya">Tipe berkas: .png, .jpg, jpeg.</span>
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
{!! JsValidator::formRequest('App\Http\Requests\KeluargaStore') !!}

<script>
    $(document).ready(function () {
        $("#form-keluarga").on('submit', function() {

            if ($('#status-error').length){
                $("#status-error").insertAfter("#status-nya");
            }

            if ($('#agama-error').length){
                $("#agama-error").insertAfter("#agama-nya");
            }

            if ($('#golongan_darah-error').length){
                $("#golongan_darah-error").insertAfter("#golongan_darah-nya");
            }

            if ($('#pendidikan-error').length){
                $("#pendidikan-error").insertAfter("#pendidikan-nya");
            }

            if ($('#photo-error').length){
                $("#photo-error").insertAfter("#photo-nya");
            }
        });

        'use strict';

        // Class definition
        var KTImageInputDemo = function () {
            // Private functions
            var initDemos = function () {
                // Example 4
                var avatar4 = new KTImageInput('kt_image_4');

                avatar4.on('cancel', function(imageInput) {
                    swal.fire({
                        title: 'Foto Profil Berhasil Di Hapus',
                        type: 'success',
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary font-weight-bold'
                    });
                });

                avatar4.on('change', function(imageInput) {
                    swal.fire({
                        title: 'Foto Profil Berhasil Ditambahkan',
                        type: 'success',
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary font-weight-bold'
                    });
                });

                avatar4.on('remove', function(imageInput) {
                    swal.fire({
                        title: 'Foto Profil Berhasil Di Hapus',
                        type: 'success',
                        icon: 'success',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok',
                        confirmButtonClass: 'btn btn-primary font-weight-bold'
                    });
                });
            }

            return {
                // public functions
                init: function() {
                    initDemos();
                }
            };
        }();

        KTUtil.ready(function() {
            KTImageInputDemo.init();
        });

    });
</script>
@endpush
