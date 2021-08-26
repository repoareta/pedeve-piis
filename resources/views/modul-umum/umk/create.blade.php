@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_umum.uang_muka_kerja.store') }}" method="post" id="form-create">
            @csrf
            <div class="form-group mb-8">
                <div class="alert alert-custom alert-default" role="alert">
                    <div class="alert-text">
                        Header Uang Muka Kerja
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">No. UMK <span class="text-danger">*</span></label>
                <div class="col-10">
                    <?php $data_no_umk = str_replace('/', '-', $no_umk); ?>
                    <input class="form-control" type="hidden" value="{{$data_no_umk}}" id="noumk"  size="25" maxlength="25" readonly>
                    <input class="form-control disabled bg-secondary" type="text" value="{{$no_umk}}" name="no_umk" size="25" maxlength="25" readonly required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nopek-input" class="col-2 col-form-label">Tanggal <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" name="tgl_panjar" value="{{ date('d-m-Y') }}" id="tgl_panjar" size="15" maxlength="15" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label">Dibayar Kepada <span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="kepada" id="kepada" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">- Pilih -</option>
                        @foreach ($vendor as $row)
                        <option value="{{ $row->nama }}">{{ $row->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-2 col-form-label">Jenis Uang Muka <span class="text-danger">*</span></label>
                <div class="col-6">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="K" type="radio" name="jenis_um" checked>
                            <span></span> Uang Muka Kerja
                        </label>
                        <label class="radio">
                            <input value="D" type="radio" name="jenis_um">
                            <span></span> Uang Muka Dinas
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="id-pekerja;-input" class="col-2 col-form-label">Bulan Buku <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary" type="text"  value="{{ $bulan_buku }}"  name="bulan_buku" size="6" maxlength="6">
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Mata Uang <span class="text-danger">*</span></label>
                <div class="col-10">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="1" type="radio" name="ci" onclick="displayResult(1)" checked>
                            <span></span> IDR
                        </label>
                        <label class="radio">
                            <input value="2" type="radio" name="ci" onclick="displayResult(2)">
                            <span></span> USD
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="tujuan-input" class="col-2 col-form-label">Kurs  <span class="text-danger d-none" id="simbol-kurs">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="1" name="rate" id="kurs" readonly  size="10" maxlength="10" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-2 col-form-label">Untuk <span class="text-danger">*</span></label>
                <div class="col-10">
                    <textarea class="form-control" type="text" value="" name="keterangan" id="keterangan" size="70" maxlength="200"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-2 col-form-label">Jumlah</label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary" type="text" value="Rp. 0" readonly>
                    <input class="form-control" type="hidden" value="0" name="jumlah" id="jumlah" size="70" maxlength="200" readonly>
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{route('modul_umum.uang_muka_kerja.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="kt_table">
            <thead class="thead-light">
                <tr>
                    <th ><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked></th>
                    <th >No.</th>
                    <th >Keterangan</th>
                    <th >Account</th>
                    <th >Bagian</th>
                    <th >PK</th>
                    <th >JB</th>
                    <th >KK</th>
                    <th >Jumlah</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\UMKStoreRequest', '#form-create'); !!}

<script>
    $(document).ready(function () {
		$('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});
		$("input[name=ci]:checked").each(function() {  
			var ci = $(this).val();
			if(ci == 1) {
				$('#kurs').val(1);
				$('#simbol-kurs').addClass('d-none');
				$( "#kurs" ).prop( "required", false );
				$( "#kurs" ).prop( "readonly", true );
				$('#kurs').addClass("disabled bg-secondary");
			} else {
                var kurs1 = $('#data-kurs').val();
				$('#kurs').val(kurs1);
				$('#kurs').removeClass("d-none");
				$( "#kurs" ).prop( "required", true );
				$( "#kurs" ).prop( "readonly", false );
				$('#kurs').removeClass("disabled bg-secondary");
			}
				
		});

        // minimum setup
        $('#tgl_panjar').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'dd-mm-yyyy'
        });

        //create
        $('#form-create').submit(function(e) {
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

	}); // end jquery
	function displayResult(ci){ 
		if(ci == 1) {
            $('#kurs').val(1);
            $('#simbol-kurs').addClass('d-none');
            $( "#kurs" ).prop( "required", false );
            $( "#kurs" ).prop( "readonly", true );
            $('#kurs').addClass("disabled bg-secondary");
        } else {
            var kurs1 = $('#data-kurs').val();
            $('#kurs').val(kurs1);
            $('#simbol-kurs').removeClass('d-none');
            $( "#kurs" ).prop( "required", true );
            $( "#kurs" ).prop( "readonly", false );
            $('#kurs').removeClass("disabled bg-secondary");
        }
	}
</script>
@endpush