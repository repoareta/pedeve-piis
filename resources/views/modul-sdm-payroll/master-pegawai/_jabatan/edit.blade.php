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
                Tambah Jabatan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('modul_sdm_payroll.master_pegawai.jabatan.update', ['pegawai' => $pegawai->nopeg, 'mulai' => $mulai, 'kode_bagian' => $kode_bagian, 'kode_jabatan' => $kode_jabatan]) }}" method="post" id="form-create">
                    @csrf
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Bagian</label>
                        <div class="col-10">
                            <select class="form-control select2 " name="bagian" id="bagian" style="width: 100% !important;">
                                <option value=""> - Pilih Bagian- </option>
                                @foreach($kodeBagian as $bagian)
								<option value="{{ $bagian->kode }}" {{ $bagian->kode == $kode_bagian ? 'selected' : null }}>{{ $bagian->kode }} - {{ $bagian->nama }}</option>
                                @endforeach
                            </select>
                            <div id="bagian-error-placement"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                            <select class="form-control select2" name="jabatan" id="jabatan" style="width: 100% !important;">
                                <option value=""> - Pilih Jabatan- </option>
                            </select>
                            <div id="jabatan-error-placement"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Golongan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" readonly="" name="golongan" id="golongan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Mulai</label>
                        <div class="col-4">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="mulai" id="mulai" value="{{ $jabatan->mulai->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <label class="col-2 col-form-label">Sampai</label>
                        <div class="col-4">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" readonly="" placeholder="Pilih Tanggal" name="sampai" id="sampai" value="{{ $jabatan->sampai->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nomor SKEP</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_skep" id="no_skep" value="{{ $jabatan->noskep }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Tanggal SKEP</label>
                        <div class="col-10">
                            <div class="input-group date">
                                <input type="text" class="form-control datepicker" placeholder="Pilih Tanggal" name="tanggal_skep" id="tanggal_skep" value="{{ $jabatan->tglskep->format('Y-m-d') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
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
{!! JsValidator::formRequest('App\Http\Requests\JabatanStoreRequest', '#form-create') !!}

<script>
    $(document).ready(function () {

        $('#form-create').on('submit', function () {
            if ($('#bagian-error').length) $('#bagian-error').insertAfter('#bagian-error-placement');
            if ($('#jabatan-error').length) $('#jabatan-error').insertAfter('#jabatan-error-placement');
        });

        $('#bagian').on('change', function(){
            var bagian = $('#bagian').val();

            $.ajax({
                url: "{{ route('modul_sdm_payroll.kode_jabatan.index.json.bagian') }}",
                type: "GET",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    "kodebagian" : bagian
                },
                success: function(response){
                    let jabatan = $('#jabatan');

                    $('#golongan').val(null);
                    jabatan.empty();
                    $.each(response, function(value, key) {
                        jabatan.append(
                            $("<option></option>")
                            .attr('selected', "{{ $kode_jabatan }}" === key.id ? true : false)
                            .attr("value", key.id)
                            .attr('data-golongan', key.golongan)
                            .text(`${key.text}`)
                        );
                    })

                    jabatan.trigger('change');
                },
                error: function () {
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });
        }).trigger('change');

        $('#jabatan').on('change', function () {
            let golongan = $('#jabatan :selected').attr('data-golongan');
            $('#golongan').val(golongan);
        });
    });
</script>
@endpush
