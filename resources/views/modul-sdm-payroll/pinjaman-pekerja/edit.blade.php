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
                Edit Pinjaman Pekerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_sdm_payroll.pinjaman_pekerja.update') }}" method="post" id="form-edit">
            @csrf
            <div class="alert alert-custom alert-default" role="alert">
                <div class="alert-text">
                    Header Pinjaman Pekerja
                </div>
            </div>
            @if($errors->any())
                {{ implode('', $errors->all('<div>:message</div>')) }}
            @endif
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">ID Pinjaman<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="no_pinjaman" id="no_pinjaman" size="8" maxlength="8" autocomplete="off" disabled value="{{ $data_list->id_pinjaman }}">
                    <input class="form-control" type="hidden" name="id_pinjaman" id="id_pinjaman" value="{{ $data_list->id_pinjaman }}">
                    <input class="form-control" type="hidden" name="nopek" value="{{ $data_list->nopek }}">
                    <input class="form-control" type="hidden" value="{{Auth::user()->userid}}" name="userid" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">NO. Pekerja<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input name="nopek" id="nopekerja" class="form-control selectpicker" data-live-search="true" value="{{ $data_list->nopek }} - {{ $data_list->nama_pegawai }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">NO. Kontrak<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="no_kontrak" size="16" maxlength="16" autocomplete="off" value="{{ $data_list->no_kontrak }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="mulai-input" class="col-2 col-form-label">Mulai</label>
                <div class="col-10">
                    <div class="input-daterange input-group" id="date_range_picker">
                        <input type="text" class="form-control" name="mulai" autocomplete="off" value="{{ date('d-m-Y', strtotime($data_list->mulai)) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input type="text" class="form-control" name="sampai" autocomplete="off" value="{{ date('d-m-Y', strtotime($data_list->sampai)) }}">
                    </div>
                    <span class="form-text text-muted">Pilih rentang waktu Pinjaman</span>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Tenor<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="tenor" size="4" maxlength="4" autocomplete="off" value="{{ $data_list->tenor }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Angsuran<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="angsuran" id="angsuran" size="25" maxlength="25" autocomplete="off" value="{{ number_format($data_list->angsuran, 0, '', '') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">Pinjaman<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input  class="form-control" type="text" name="jml_pinjaman" id="jml_pinjaman" size="35" maxlength="35" autocomplete="off" value="{{ number_format($data_list->jml_pinjaman, 0, '', '') }}">
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('modul_sdm_payroll.pinjaman_pekerja.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
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
                Detail Pinjaman Pekerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>No</th>	
                    <th>TAHUN</th>	
                    <th>BULAN</th>
                    <th>SKED POKOK</th>
                    <th>SKED BUNGA</th>
                    <th>SKED JUMLAH</th>
                    <th>REAL POKOK</th>
                    <th>REAL BUNGA</th>
                    <th>REAL JUMLAH</th>
                    <th>NO BUKTI</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=0; ?>
                @foreach($data_detail as $data_d)
                <?php $no++; ?>
                <tr>
                    <td scope="row" align="center"><label class="kt-radio kt-radio--bold kt-radio--brand"><input type="radio" name="btn-radio" data-no="" class="btn-radio" ><span></span></label></td>
                    <td scope="row" align="center">{{$no}}</td>
                    <td align="center">{{$data_d->tahun}}</td>
                    <td align="center">{{$data_d->bulan}}</td>
                    <td><?php echo number_format($data_d->pokok, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_d->bunga, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_d->jumlah, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_d->realpokok, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_d->realbunga, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($data_d->jumlah2, 0, ',', '.'); ?></td>
                    <td align="center">{{$data_d->nodoc}}</td>
                </tr>
                @endforeach
                @foreach($count as $data_c)
                <tr>
                    <td colspan="4" align="right">Jumlah Total : </td>
                    <td ><?php echo number_format($data_c->jml, 0, ',', '.'); ?></td>
                    <td ><?php echo number_format($data_c->bunga, 0, ',', '.'); ?></td>
                    <td ></td>
                    <td ><?php echo number_format($data_c->realpokok, 0, ',', '.'); ?></td>
                    <td ><?php echo number_format($data_c->realbunga, 0, ',', '.'); ?></td>
                    <td colspan="2" ></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PinjamanKerjaStoreRequest', '#form-edit'); !!}
<script type="text/javascript">
	$(document).ready(function () {
		$('#tanggal').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            format   : 'dd-mm-yyyy',
            autoclose: true,
        });
        
        $('#date_range_picker').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            format   : 'dd-mm-yyyy',
            autoclose: true,
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
                        console.log(result);
                        $(this).unbind('submit').submit();
                    }
                });
            }
		});
	});	
</script>
@endpush