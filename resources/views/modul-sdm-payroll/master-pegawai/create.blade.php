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
                Tambah Master Pegawai
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="kt-form kt-form--label-right" id="formMasterPegawai" action="{{ route('modul_sdm_payroll.master_pegawai.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label for="kode" class="col-4 col-form-label">Nomor Pegawai</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="nomor" id="nomor">
                                </div>
                            </div>
            
                            {{-- <div class="form-group row">
                                <label for="nama" class="col-4 col-form-label">Bagian</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="bagian" id="bagian">
                                        <option value=""> - Pilih Bagian- </option>
                                        @foreach ($kode_bagian_list as $kode_bagian)
                                            <option value="{{ $kode_bagian->kode }}">{{ $kode_bagian->kode.' - '.$kode_bagian->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
            
                            <div class="form-group row">
                                <label for="tahun" class="col-4 col-form-label">Status</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="status" id="status">
                                        <option value=""> - Pilih Status- </option>
                                        <option value="C">Aktif</option>
                                        <option value="TA">Tidak Aktif</option>
                                        <option value="P">Pensiun</option>									
                                        <option value="K">Kontrak</option>
                                        <option value="B">Perbantuan</option>
                                        <option value="D">Direksi</option>
                                        <option value="N">Pekerja Baru</option>
                                        <option value="U">Komisaris</option>
                                        <option value="O">Komite</option>
                                    </select>
                                    <div id="status-nya"></div>
                                </div>
                            </div>
            
                            {{-- <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Jabatan</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="jabatan" id="jabatan">
                                        <option value=""> - Pilih Jabatan- </option>
                                        @foreach ($kode_jabatan_list as $kode_jabatan)
                                            <option value="{{ $kode_jabatan->kdjab }}">{{ $kode_jabatan->kdjab.' - '.$kode_jabatan->keterangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
    
                            {{-- <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Golongan</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="golongan" id="golongan" readonly>
                                </div>
                            </div> --}}
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Tgl Aktif Dinas</label>
                                <div class="col-8">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly="" placeholder="Pilih Tanggal Aktif Dinas" name="tanggal_aktif_dinas" id="tanggal_aktif_dinas">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. Dana Pensiun</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_ydp" id="no_ydp">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">NPWP</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="npwp" id="npwp">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. BPJS</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_astek" id="no_astek">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Gelar</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="gelar_1" id="gelar_1">
                                        <option value="">- Pilih Gelar -</option>
                                        @foreach ($pendidikan_list as $pendidikan)
                                            <option value="{{ $pendidikan->kode }}">{{ $pendidikan->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="gelar_1-nya"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <select class="form-control select2" name="gelar_2" id="gelar_2">
                                        <option value="">- Pilih Gelar -</option>
                                        @foreach ($pendidikan_list as $pendidikan)
                                            <option value="{{ $pendidikan->kode }}">{{ $pendidikan->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="gelar_2-nya"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <select class="form-control select2" name="gelar_3" id="gelar_3">
                                        <option value="">- Pilih Gelar -</option>
                                        @foreach ($pendidikan_list as $pendidikan)
                                            <option value="{{ $pendidikan->kode }}">{{ $pendidikan->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="gelar_3-nya"></div>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label for="kode" class="col-4 col-form-label">Nama Pegawai</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="nama" id="nama">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="kode" class="col-4 col-form-label">Nomor KTP</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="ktp" id="ktp">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="nama" class="col-4 col-form-label">Tempat Lahir</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nama" class="col-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-8">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly="" placeholder="Pilih Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="tahun" class="col-4 col-form-label">Provinsi Lahir</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="provinsi" id="provinsi">
                                        <option value=""> - Pilih Provinsi- </option>
                                        @foreach ($provinsi_list as $provinsi)
                                            <option value="{{ $provinsi->kode }}">{{ $provinsi->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="provinsi-nya"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Agama</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="agama" id="agama">
                                        <option value=""> - Pilih Agama- </option>
                                        @foreach ($agama_list as $agama)
                                            <option value="{{ $agama->kode }}">{{ $agama->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="agama-nya"></div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Jenis Kelamin</label>
                                <div class="col-8">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio kt-radio--solid">
                                            <input type="radio" name="jenis_kelamin" checked value="L"> Laki-laki
                                            <span></span>
                                        </label>
                                        <label class="kt-radio kt-radio--solid">
                                            <input type="radio" name="jenis_kelamin" value="P"> Perempuan
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Golongan Darah</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="golongan_darah" id="golongan_darah">
                                        <option value=""> - Pilih Golongan Darah- </option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                    <div id="golongan_darah-nya"></div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Kode Keluarga</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="kode_keluarga" id="kode_keluarga">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Alamat</label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 1" type="text" name="alamat_1" id="alamat_1">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 2" type="text" name="alamat_2" id="alamat_2">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 3" type="text" name="alamat_3" id="alamat_3">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. Handphone</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_handphone" id="no_handphone">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. Telepon</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_telepon" id="no_telepon">
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-2">
                            <div class="image-input image-input-outline" id="kt_image_4" style="background-image: url({{ asset('assets/media/users/blank.png') }})">
                                <div class="image-input-wrapper" style="background-image: url({{ asset('assets/media/users/default.jpg') }})"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
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
    
                    <div class="kt-form__actions">
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-8">
                                    <a href="{{ route('modul_sdm_payroll.master_pegawai.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\MasterPegawaiStore', '#formMasterPegawai') !!}

<script>
    $(document).ready(function () {
        // minimum setup
        $('#tanggal_aktif_dinas, #tanggal_lahir').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'yyyy-mm-dd'
        });

        $('#gelar_1, #gelar_2, #gelar_3').select2().on('change', function() {
            if ($('#gelar_1-error').length){
                $("#gelar_1-error").insertAfter("#gelar_1-nya");
            } else {
                $(this).valid();
            }

            if ($('#gelar_2-error').length){
                $("#gelar_2-error").insertAfter("#gelar_2-nya");
            } else {
                $(this).valid();
            }
            
            if ($('#gelar_3-error').length){
                $("#gelar_3-error").insertAfter("#gelar_3-nya");
            } else {
                $(this).valid();
            }
        });


        $("#formMasterPegawai").on('submit', function(e){
            e.preventDefault();

            if ($('#status-error').length){
                $("#status-error").insertAfter("#status-nya");
            }

            if ($('#provinsi-error').length){
                $("#provinsi-error").insertAfter("#provinsi-nya");
            }

            if ($('#agama-error').length){
                $("#agama-error").insertAfter("#agama-nya");
            }

            if ($('#golongan_darah-error').length){
                $("#golongan_darah-error").insertAfter("#golongan_darah-nya");
            }

            if ($('#gelar_1-error').length){
                $("#gelar_1-error").insertAfter("#gelar_1-nya");
            }
            
            if ($('#gelar_2-error').length){
                $("#gelar_2-error").insertAfter("#gelar_2-nya");
            }
            
            if ($('#gelar_3-error').length){
                $("#gelar_3-error").insertAfter("#gelar_3-nya");
            }

            if ($('#photo-error').length){
                $("#photo-error").insertAfter("#photo-nya");
            }

            if($(this).valid()) {
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: "Ingin melanjutkan isi detail pegawai?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Lanjut Isi Detail Pegawai',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        $(this).append('<input type="hidden" name="url" value="edit" />');
                        $(this).unbind('submit').submit();
                    }
                    else if (result.dismiss === Swal.DismissReason.cancel) {
                        $(this).append('<input type="hidden" name="url" value="modul_sdm_payroll.master_pegawai.index" />');
                        $(this).unbind('submit').submit();
                    }
                });
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
                        title: 'Image successfully removed !',
                        type: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Got it!',
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
