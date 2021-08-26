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

	<div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Panjar Dinas
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="{{ route('modul_umum.perjalanan_dinas.detail.create', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}">
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                            <i class="fas fa-2x fa-plus-circle text-success"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span data-toggle="tooltip" data-placement="top" id="editRow" title="Ubah Data">
                            <i class="fas fa-2x fa-edit text-warning"></i>
                        </span>
                    </a>
                    <a href="#">
                        <span data-toggle="tooltip" data-placement="top" id="deleteRow" title="Hapus Data">
                            <i class="fas fa-2x fa-times-circle text-danger"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-hover table-checkable" id="kt_table">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NO</th>
                            <th>NOPEK</th>
                            <th>NAMA</th>
                            <th>GOL</th>
                            <th>JABATAN</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PerjalananDinasUpdate', '#formPanjarDinas') !!}
<script>
    function refreshTable() {
		var table = $('#kt_table').DataTable();
		table.clear();
		table.ajax.url("{{ route('modul_umum.perjalanan_dinas.detail.index.json', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}").load(function() {
			var rowCount = table.rows().count();
			$('#no_urut').val(rowCount + 1);
		});
	}

    $(document).ready(function () {
        var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			ajax: "{{ route('modul_umum.perjalanan_dinas.detail.index.json', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}",
			columns: [
				{data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
				{data: 'no', name: 'no'},
				{data: 'nopek', name: 'nopek'},
				{data: 'nama', name: 'nama'},
				{data: 'golongan', name: 'golongan'},
				{data: 'jabatan', name: 'jabatan'},
				{data: 'keterangan', name: 'keterangan'}
			],
			order: [[ 0, "asc" ], [ 1, "asc" ]]
		});

		$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var no_nopek = $(this).val();
					// delete stuff
					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary',
						cancelButton: 'btn btn-danger'
					},
						buttonsStyling: false
					})

					swalWithBootstrapButtons.fire({
						title: "Data yang akan dihapus?",
						text: "Nopek : " + no_nopek,
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.perjalanan_dinas.detail.delete', ['no_panjar' => str_replace('/', '-', $panjar_header->no_panjar)]) }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"no_nopek": no_nopek,
									"no_panjar": "{{ $panjar_header->no_panjar }}",
									"session": false,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title: 'Hapus detail Panjar',
										text : 'Berhasil',
										timer: 2000
									}).then(function() {
										t.ajax.reload();
									});
								},
								error: function () {
									alert("Terjadi kesalahan, coba lagi nanti");
								}
							});
						}
					});
				});
			} else {
				swalAlertInit('hapus');
			}
		});
    });
</script>
@endpush
