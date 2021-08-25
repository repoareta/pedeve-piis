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
                Tambah Pertanggungjawaban Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.store') }}" method="post" id="form-create">
            @csrf

            <div class="form-group row">
                <label for="spd-input" class="col-2 col-form-label">No. PUMK</label>
                <div class="col-5">
                    <input class="form-control disabled bg-secondary" type="text" name="no_pumk" value="{{ sprintf("%03s", $pumk_header_count + 1).'/CS/'.date('d').'/'.date('m').'/'.date('Y') }}" id="no_pumk" readonly>
                </div>

                <label for="spd-input" class="col-2 col-form-label">Tanggal PUMK</label>
                <div class="col-3">
                    <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="no_umk" class="col-2 col-form-label">No. UMK</label>
                <div class="col-10">
                    <select class="form-control kt-select2" id="no_umk" name="no_umk">
                        <option value="">- Pilih No. UMK -</option>
                        @foreach ($umk_header_list as $umk)
                        <option value="{{ $umk->no_umk }}">{{ $umk->no_umk }}</option>
                        @endforeach
                    </select>
                    <div id="no_umk-nya"></div>
                </div>
            </div>
            

            <div class="form-group row">
                <label for="nopek-input" class="col-2 col-form-label">Nopek</label>
                <div class="col-10">
                    <select class="form-control kt-select2" name="nopek">
                        <option value="">- Pilih Nopek -</option>
                        @foreach ($pegawai_list as $pegawai)
                        <option value="{{ $pegawai->nopeg }}">{{ $pegawai->nopeg.' - '.$pegawai->nama }}</option>
                        @endforeach
                    </select>
                    <div id="nopek-nya"></div>
                </div>
            </div>

            <div class="form-group row">
                <label for="example-email-input" class="col-2 col-form-label">Jabatan</label>
                <div class="col-5">
                    <select class="form-control kt-select2" name="jabatan" id="jabatan">
                        <option value="">- Pilih Jabatan -</option>
                        @foreach ($jabatan_list as $jabatan)
                            <option value="{{ $jabatan->keterangan }}">{{ $jabatan->keterangan }}</option>
                        @endforeach
                    </select>
                    <div id="jabatan-nya"></div>
                </div>

                <label for="example-email-input" class="col-2 col-form-label">Golongan</label>
                <div class="col-3">
                    <input class="form-control" type="text" name="golongan" id="golongan">
                </div>
            </div>

            <div class="form-group row">
                <label for="jumlah" class="col-2 col-form-label">Keterangan</label>
                <div class="col-10">
                    <input class="form-control" type="text" name="keterangan" id="keterangan">
                </div>
            </div>

            <div class="form-group row">
                <label for="jumlah" class="col-2 col-form-label">Jumlah Header PUMK</label>
                <div class="col-5">
                    <input class="form-control money" type="text" name="jumlah" id="jumlah" value="0.00">
                </div>

                <label for="jumlah_detail" class="col-2 col-form-label">Jumlah Detail PUMK</label>
                <div class="col-3">
                    <input class="form-control money" type="text" name="jumlah_detail_pumk" id="jumlah_detail_pumk">
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Pertanggungjawaban Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Account</th>
                    <th>CJ</th>
                    <th>JB</th>
                    <th>Bagian</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PUMKStoreRequest', '#form-create'); !!}

<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.index.json', ['no_pumk' => 'null']) }}").load(function() {
			// Callback loads updated row count into a DOM element
			// (a Bootstrap badge on a menu item in this case):
			var rowCount = table.rows().count();
			$('#no_urut').val(rowCount + 1);
		});
	}
    
	$(document).ready(function () {
		$('.kt-select2').select2().on('change', function() {
			$(this).valid();
		});
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: "{{ route('modul_umum.uang_muka_kerja.pertanggungjawaban.detail.index.json', ['no_pumk' => 'null']) }}",
			columns: [
				{data: 'radio', name: 'radio', orderable: false, searchable: false, class:'text-center radio-button'},
				{data: 'no', name: 'no'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'account', name: 'account'},
				{data: 'cj', name: 'cj'},
				{data: 'jb', name: 'jb'},
				{data: 'bagian', name: 'bagian'},
				{data: 'nilai', name: 'nilai', class:'text-right'},
				{data: 'total', name: 'total', class:'no-wrap text-right', visible: false},
			],
			drawCallback: function () {
				var sum = $('#kt_table').DataTable().column(8).data().sum();
				$('#jumlah_detail_pumk').val(sum.toFixed(2)).trigger("change");
			},
			order: [[ 0, "asc" ], [ 1, "asc" ]]
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			// language : 'id',
			format   : 'yyyy-mm-dd'
		});

		$("#form-create").on('submit', function(e){
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