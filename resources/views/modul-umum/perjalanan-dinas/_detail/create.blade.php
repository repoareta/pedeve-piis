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
                Tambah Detail Panjar Dinas
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="" method="POST" id="formPanjarDinasDetail">
                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">No. Urut</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_urut" id="no_urut">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Keterangan</label>
                        <div class="col-10">
                            <textarea class="form-control" name="keterangan_detail" id="keterangan_detail"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Nopek</label>
                        <div class="col-10">
                            <select class="form-control select2" id="nopek_detail" name="nopek_detail" style="width: 100% !important;">
                                <option value="">- Pilih Nopek -</option>
                                @foreach ($pegawai_list as $pegawai)
                                    <option value="{{ $pegawai->nopeg.'-'.$pegawai->nama }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                                @endforeach
                            </select>
                            <div id="nopek_detail-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                            <select class="form-control select2" name="jabatan_detail" readonly id="jabatan_detail" style="width: 100% !important;">
                                <option value="">- Pilih Jabatan -</option>
                                @foreach ($jabatan_list as $jabatan)
                                    <option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
                                @endforeach
                            </select>
                            <div id="jabatan_detail-nya"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="spd-input" class="col-2 col-form-label">Golongan</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="golongan_detail" id="golongan_detail" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_umum.perjalanan_dinas.edit', ['no_panjar' => $no_panjar]) }}" class="btn btn-warning"><i class="fa fa-reply"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasStore', '#formPanjarDinas'); !!}
<script>
    $(document).ready(function () {
        // range picker
		$('#date_range_picker').datepicker({
			todayHighlight: true,
			// autoclose: true,
			language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			// format   : 'yyyy-mm-dd'
			format   : 'dd-mm-yyyy'
		});

        $("#formPanjarDinas").on('submit', function(e){

            e.preventDefault();

            if ($('#nopek-error').length){
                $("#nopek-error").insertAfter("#nopek-nya");
            }

            if ($('#jabatan-error').length){
                $("#jabatan-error").insertAfter("#jabatan-nya");
            }

            if ($('#jenis_dinas-error').length){
                $("#jenis_dinas-error").insertAfter("#jenis_dinas-nya");
            }

            if ($('#biaya-error').length){
                $("#biaya-error").insertAfter("#biaya-nya");
            }

            if ($('#sampai-error').length){
                $("#sampai-error").addClass("float-right");
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
                title: "Apakah anda yakin mau menyimpan data ini?",
                text: "",
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Ya, Simpan Panjar',
                cancelButtonText: 'Tidak'
            })
            .then((result) => {
                if (result.value) {
                    $(this).append('<input type="hidden" name="url" value="edit" />');
                    $(this).unbind('submit').submit();
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    $(this).append('<input type="hidden" name="url" value="modul_umum.perjalanan_dinas.index" />');
                    $(this).unbind('submit').submit();
                }
            });
            }
        });
    });
    
</script>
@endpush
