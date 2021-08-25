@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Master Pegawai
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form form--label-right" id="formMasterPegawai" action="{{ route('modul_sdm_payroll.master_pegawai.update', ['pegawai' => $pegawai->nopeg]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group row">
                                <label for="kode" class="col-4 col-form-label">Nomor Pegawai</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="nomor" id="nomor" value="{{ $pegawai->nopeg }}">
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
                                        <option value="C" 
                                        @if($pegawai->status == 'C')
											selected
										@endif>Aktif</option>

                                        <option value="TA"
                                        @if($pegawai->status == 'TA')
											selected
										@endif>Tidak Aktif</option>

                                        <option value="P"
                                        @if($pegawai->status == 'P')
											selected
										@endif>Pensiun</option>	

                                        <option value="K"
                                        @if($pegawai->status == 'K')
											selected
										@endif>Kontrak</option>

                                        <option value="B"
                                        @if($pegawai->status == 'B')
											selected
										@endif>Perbantuan</option>

                                        <option value="D"
                                        @if($pegawai->status == 'D')
											selected
										@endif>Direksi</option>

                                        <option value="N"
                                        @if($pegawai->status == 'N')
											selected
										@endif>Pekerja Baru</option>

                                        <option value="U"
                                        @if($pegawai->status == 'U')
											selected
										@endif>Komisaris</option>

                                        <option value="O"
                                        @if($pegawai->status == 'O')
											selected
										@endif>Komite</option>
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
                                        <input type="text" class="form-control" readonly="" placeholder="Pilih Tanggal Aktif Dinas" name="tanggal_aktif_dinas" id="tanggal_aktif_dinas" value="{{ date('Y-m-d', strtotime($pegawai->tglaktifdns)) }}">
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
                                    <input class="form-control" type="text" name="no_ydp" id="no_ydp" value="{{ $pegawai->noydp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">NPWP</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="npwp" id="npwp" value="{{ $pegawai->npwp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. BPJS</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_astek" id="no_astek" value="{{ $pegawai->noastek }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Gelar</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="gelar_1" id="gelar_1">
                                        <option value="">- Pilih Gelar -</option>
                                        @foreach ($pendidikan_list as $pendidikan)
                                            <option value="{{ $pendidikan->kode }}" 
                                                @if($pendidikan->kode == $pegawai->gelar1)
                                                    selected
                                                @endif 
                                            >{{ $pendidikan->nama }}</option>
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
                                            <option value="{{ $pendidikan->kode }}"
                                                @if($pendidikan->kode == $pegawai->gelar2)
                                                    selected
                                                @endif 
                                            >{{ $pendidikan->nama }}</option>
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
                                            <option value="{{ $pendidikan->kode }}"
                                                @if($pendidikan->kode == $pegawai->gelar3)
                                                    selected
                                                @endif
                                            >{{ $pendidikan->nama }}</option>
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
                                    <input class="form-control" type="text" name="nama" id="nama" value="{{ $pegawai->nama }}">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="kode" class="col-4 col-form-label">Nomor KTP</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="ktp" id="ktp" value="{{ $pegawai->noktp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="nama" class="col-4 col-form-label">Tempat Lahir</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" value="{{ $pegawai->tempatlhr }}">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="nama" class="col-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-8">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" readonly="" placeholder="Pilih Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir" value="{{ date('Y-m-d', strtotime($pegawai->tgllahir)) }}">
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
                                            <option value="{{ $provinsi->kode }}"
                                                @if($provinsi->kode == $pegawai->proplhr)
                                                    selected
                                                @endif
                                            >{{ $provinsi->nama }}</option>
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
                                            <option value="{{ $agama->kode }}"
                                                @if($agama->kode == $pegawai->agama)
                                                    selected
                                                @endif
                                            >{{ $agama->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="agama-nya"></div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Jenis Kelamin</label>
                                <div class="col-8 col-form-label">
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" name="jenis_kelamin" value="L"
                                            @if($pegawai->gender == 'L')
											checked
											@endif>
                                            <span></span> Laki-laki
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="jenis_kelamin" value="P"
                                            @if($pegawai->gender == 'P')
											checked
											@endif>
                                            <span></span> Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Golongan Darah</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="golongan_darah" id="golongan_darah">
                                        <option value=""> - Pilih Golongan Darah- </option>
                                        <option value="A"
                                            @if($pegawai->goldarah == 'A')
                                            selected
                                            @endif>A</option>

                                        <option value="B"
                                            @if($pegawai->goldarah == 'B')
                                            selected
                                            @endif>B</option>

                                        <option value="AB"
                                            @if($pegawai->goldarah == 'AB')
                                            selected
                                            @endif>AB</option>

                                        <option value="O"
                                            @if($pegawai->goldarah == 'O')
                                            selected
                                            @endif>O</option>
                                    </select>
                                    <div id="golongan_darah-nya"></div>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Kode Keluarga</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="kode_keluarga" id="kode_keluarga" value="{{ $pegawai->kodekeluarga }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Alamat</label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 1" type="text" name="alamat_1" id="alamat_1" value="{{ $pegawai->alamat1 }}">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 2" type="text" name="alamat_2" id="alamat_2" value="{{ $pegawai->alamat2 }}">
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label"></label>
                                <div class="col-8">
                                    <input class="form-control" placeholder="Alamat 3" type="text" name="alamat_3" id="alamat_3" value="{{ $pegawai->alamat3 }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. Handphone</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_handphone" id="no_handphone" value="{{ $pegawai->nohp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <label for="" class="col-4 col-form-label">No. Telepon</label>
                                <div class="col-8">
                                    <input class="form-control" type="text" name="no_telepon" id="no_telepon" value="{{ $pegawai->notlp }}">
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-2">
                            <div class="image-input image-input-outline" id="kt_image_4" style="background-image: url({{ asset('assets/media/users/blank.png') }})">
                                @if ($pegawai->photo)
                                <div class="image-input-wrapper" style="background-image: url({{ asset('storage/pekerja_img/'.$pegawai->photo) }})"></div>
                                @else
                                <div class="image-input-wrapper" style="background-image: url({{ asset('assets/media/users/default.jpg') }})"></div>
                                @endif
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
    
                    <div class="form__actions">
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

    <div class="card-header card-header-tabs-line">
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line d-flex flex-nowrap">
                <li class="nav-item no-wrap">
                    <a class="nav-link active" data-toggle="tab" href="#detail_keluarga">
                        <span class="nav-text">Keluarga</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n5">
                    <a class="nav-link" data-toggle="tab" href="#detail_jabatan">
                        <span class="nav-text">Jabatan</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_gaji_pokok">
                        <span class="nav-text">Gaji Pokok</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_golongan_gaji">
                        <span class="nav-text">Golongan Gaji</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_kursus">
                        <span class="nav-text">Kursus</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_pendidikan">
                        <span class="nav-text">Pendidikan</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_penghargaan">
                        <span class="nav-text">Penghargaan</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_pengalaman_kerja">
                        <span class="nav-text">Pengalaman Kerja</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_seminar">
                        <span class="nav-text">Seminar</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_smk">
                        <span class="nav-text">SMK</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_upah_tetap">
                        <span class="nav-text">Upah Tetap</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_upah_tetap_pensiun">
                        <span class="nav-text">Upah Tetap Pensiun</span>
                    </a>
                </li>
                <li class="nav-item no-wrap ml-n1">
                    <a class="nav-link" data-toggle="tab" href="#detail_upah_all_in">
                        <span class="nav-text">Upah All In</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="detail_keluarga" role="tabpanel" aria-labelledby="detail_keluarga">
            @include('modul-sdm-payroll.master-pegawai._keluarga.index')
        </div>
        <div class="tab-pane fade" id="detail_jabatan" role="tabpanel" aria-labelledby="detail_jabatan">
            @include('modul-sdm-payroll.master-pegawai._jabatan.index')
        </div>
        <div class="tab-pane fade" id="detail_gaji_pokok" role="tabpanel" aria-labelledby="detail_gaji_pokok">
            @include('modul-sdm-payroll.master-pegawai._gaji-pokok.index')
        </div>
        <div class="tab-pane fade" id="detail_golongan_gaji" role="tabpanel" aria-labelledby="detail_golongan_gaji">
            @include('modul-sdm-payroll.master-pegawai._golongan-gaji.index')
        </div>
        <div class="tab-pane fade" id="detail_kursus" role="tabpanel" aria-labelledby="detail_kursus">
            @include('modul-sdm-payroll.master-pegawai._kursus.index')
        </div>
        <div class="tab-pane fade" id="detail_pendidikan" role="tabpanel" aria-labelledby="detail_pendidikan">
            @include('modul-sdm-payroll.master-pegawai._pendidikan.index')
        </div>
        <div class="tab-pane fade" id="detail_penghargaan" role="tabpanel" aria-labelledby="detail_penghargaan">
            @include('modul-sdm-payroll.master-pegawai._penghargaan.index')
        </div>
        <div class="tab-pane fade" id="detail_pengalaman_kerja" role="tabpanel" aria-labelledby="detail_pengalaman_kerja">
            @include('modul-sdm-payroll.master-pegawai._pengalaman-kerja.index')
        </div>
        <div class="tab-pane fade" id="detail_seminar" role="tabpanel" aria-labelledby="detail_seminar">
            @include('modul-sdm-payroll.master-pegawai._seminar.index')
        </div>
        <div class="tab-pane fade" id="detail_smk" role="tabpanel" aria-labelledby="detail_smk">
            @include('modul-sdm-payroll.master-pegawai._smk.index')
        </div>
        <div class="tab-pane fade" id="detail_upah_tetap" role="tabpanel" aria-labelledby="detail_upah_tetap">
            @include('modul-sdm-payroll.master-pegawai._upah-tetap.index')
        </div>
        <div class="tab-pane fade" id="detail_upah_tetap_pensiun" role="tabpanel" aria-labelledby="detail_upah_tetap_pensiun">
            @include('modul-sdm-payroll.master-pegawai._upah-tetap-pensiun.index')
        </div>
        <div class="tab-pane fade" id="detail_upah_all_in" role="tabpanel" aria-labelledby="detail_upah_all_in">
            @include('modul-sdm-payroll.master-pegawai._upah-all-in.index')
        </div>
    </div>

</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\MasterPegawaiUpdate', '#formMasterPegawai') !!}

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
                $(this).unbind('submit').submit();
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
