@extends('layouts.app')

@section('breadcrumbs')
{{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom card-sticky">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Edit Jurnal Umum
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_kontroler.jurnal_umum.update') }}" method="post" id="form-edit">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-custom alert-default" role="alert">
                    <div class="alert-text">
                        Header Jurnal Umum
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">No.Dokumen</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $data_jur->mp }}" disabled>
                    <input class="form-control" type="hidden" name="mp" value="{{ $data_jur->mp }}" id="mp">
                    <input class="form-control" type="hidden" name="docno" value="{{ $data_jur->docno }}" id="docno">
                </div>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $data_jur->nomor }}" disabled>
                    <input class="form-control" type="hidden" name="nomor" value="{{ $data_jur->nomor }}" id="nomor">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Bulan</label>
                <div class="col-3">
                    <?php
                    $jabatan = "Sekretaris Perseroan";
                    $nama = "Silahkan Isi";
                    ?>
                    <input type="text" class="form-control" value="{{ $data_jur->bulan }}" disabled>
                    <input type="hidden" class="form-control" value="{{ $data_jur->bulan }}" name="bulan">
                </div>
                <label for="spd-input" class="col-1 col-form-label">Tahun</label>
                <div class="col-3" >
                    <input class="form-control" type="text" value="{{ $data_jur->tahun }}" disabled>
                    <input class="form-control" type="hidden" value="{{ $data_jur->tahun }}" name="tahun">
                    <input class="form-control" type="hidden" name="inputid" value="{{ auth()->user()->userid }}" autocomplete="off">
                </div>
                <label for="spd-input" class="col-1 col-form-label">suplesi</label>
                <div class="col-2" >
                    <input class="form-control" type="text" value="{{ $data_jur->suplesi }}" name="suplesi" size="2" maxlength="2" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Bagian</label>
                <div class="col-5">
                    <input class="form-control" type="text" name="bagian" value="{{ $data_jur->bagian }}" id="bagian" disabled>
                </div>
                <div class="col-5">
                    <input class="form-control" type="text" value="{{ $data_jur->nama_bagian }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Jenis Kartu</label>
                <div class="col-5">
                    <select name="jk" id="jk" class="form-control selectpicker" data-live-search="true">
                        <option value="15" <?php if($data_jur->jk  == '15' ) echo 'selected' ; ?>>Rupiah</option>
                        <option value="18" <?php if($data_jur->jk  == '18' ) echo 'selected' ; ?>>Dollar</option>
                    </select>
                    <input name="rate" type="hidden" value="{{ $data_jur->rate }}"></td>
                </div>
                <label for="nopek-input" class="col-2 col-form-label">Currency Index</label>
                <div class="col-3">
                    <input class="form-control" type="text" value="1" id="show_ci" disabled>
                    <input class="form-control" type="hidden" name="ci" value="1" id="ci">
                </div>
            </div>
            <div class="form-group row">
                <label for="id-pekerja;-input" class="col-2 col-form-label">Store</label>
                <div class="col-5">
                    <input class="form-control" type="text" value="99" id="show_store" disabled>
                    <input class="form-control" type="hidden" value="99" name="store">
                </div>
                <div class="col-5">
                    <input class="form-control" type="text" value="JURNAL" disabled>
                    <input class="form-control" type="hidden" value="JURNAL" name="nama_kas">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">No. Bukti</label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{ $data_jur->voucher }}" id="show_vourcher" disabled>
                    <input class="form-control" type="hidden" name="voucher" value="{{ $data_jur->voucher }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="id-pekerja;-input" class="col-2 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-10">
                    <textarea class="form-control" type="text" id="keterangan" name="keterangan" required>{{ $data_jur->keterangan }}</textarea>
                    <input class="form-control" type="hidden" name="inputdate" value="{{ date('Y-m-d') }}" size="15" maxlength="15">
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_kontroler.jurnal_umum.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Jurnal Umum
            </h3>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="tabel-detail-permintaan">
            <thead class="thead-light">
                <tr>
                    <th><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked ></th>
                    <th>NO</th>
                    <th>LP</th>	
                    <th>SANPER</th>
                    <th>BAGIAN</th>
                    <th>PK</th>
                    <th>JB</th>
                    <th>DR</th>
                    <th>CR</th>
                    <th>KURS</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\JurnalUmumUpdateRequest', '#form-edit'); !!}

<script type="text/javascript">
	$(document).ready(function () {
		$('#tabel-detail-permintaan').DataTable({
			scrollX: true,
			processing: true,
			serverSide: false,
		});
        
		$("#jk").on("change", function(){
			var jk = $("#jk").val();
			if(jk == 15){
				$('#ci').val(1);
				$('#show_ci').val(1);
				$('#show_ci').prop("disabled", true);
			}else{
                $('#ci').val(2);
				$('#show_ci').val(2);
				$('#show_ci').prop("disabled", false);
			}
		});

        $('#show_ci').on('change', function () {
            $('#ci').val($(this).val());
        });
		
		$('#form-edit').submit(function(e){
			e.preventDefault();

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
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value == true) {
                        $(this).unbind('submit').submit();
                    }
                });
            }
		});
	});
</script>
@endpush