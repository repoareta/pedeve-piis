@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky">

    <div class="card-header">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Menu Edit Perbendaharaan - Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Edit Perbendaharaan - Kas/Bank
                        </div>
                    </div>
                </div>
                <form action="{{ route('penerimaan_kas.update') }}" method="POST" id="form-edit">
                    @csrf
                    <?php
						$nodok = $data->docno;
						$mp = substr($data->docno,0,1);
						$nomor = substr($data->docno,8);
						$tahun = substr($data->thnbln,0,4);
						$bulan = substr($data->thnbln,4);
						$bulan = substr($data->thnbln,4);
						$bagian = substr($data->docno,2,5);
					?>
					<div class="form-group row">
						<label for="" class="col-2 col-form-label">No.Dokumen</label>
						<div class="col-6">
							<input type="text" class="form-control disabled bg-secondary"  value="{{ $mp }}" size="1" maxlength="1" name="mp" id="mp" readonly>
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="hidden" value="{{$nodok}}"  name="nodok" readonly>
						</div>
						<div class="col-4">
							<input type="text" class="form-control disabled bg-secondary"  value="{{ $nomor }}" size="1" maxlength="1" name="nomor" id="nomor" readonly>
						</div>
					</div>

					<div class="form-group row">
					<label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
					<div class="col-4">
						<input class="form-control disabled bg-secondary" type="text" value="{{$bulan}}"   name="bulan" id="bulan" size="2" maxlength="2" readonly>
						<input class="form-control disabled bg-secondary" type="hidden" value="{{$data->thnbln}}"   name="bulanbuku" id="bulanbuku" size="6" maxlength="6" readonly>

					</div>
						<div class="col-6" >
							<input class="form-control disabled bg-secondary" type="text" value="{{$tahun}}"   name="tahun" id="tahun" size="4" maxlength="4" readonly>
							<input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="jenis-dinas-input" class="col-2 col-form-label">Bagian<span class="text-danger">*</span></label>
						<div class="col-10">
							<select name="bagian" id="bagian" class="form-control selectpicker" data-live-search="true" required oninvalid="this.setCustomValidity('Bagian Harus Diisi..')" onchange="setCustomValidity('')">
								<option value="">- Pilih -</option>
								@foreach($data_bagian as $row)
								<option value="{{$row->kode}}" <?php if($row->kode == $bagian ) echo 'selected' ; ?>>{{$row->kode}} - {{$row->nama}}</option>
								@endforeach

							</select>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-2 col-form-label">Jenis Kartu<span class="text-danger">*</span></label>
						<div class="col-3">
							<select name="jk" id="jk" class="form-control select2" data-live-search="true" required>
								<option value="">- Pilih -</option>
								<option value="10" <?php if($data->jk == '10' ) echo 'selected' ; ?>>Kas(Rupiah)</option>
								<option value="11" <?php if($data->jk == '11' ) echo 'selected' ; ?>>Bank(Rupiah)</option>
								<option value="13" <?php if($data->jk == '13' ) echo 'selected' ; ?>>Bank(Dollar)</option>

							</select>							</div>
						<label class="col-2 col-form-label">Currency Index</label>
						<div class="col-2" >
							<input class="form-control disabled bg-secondary" type="text" name="ci" value="{{$data->ci}}"  id="ci" size="6" maxlength="6" readonly>
						</div>
						<label class="col-1 col-form-label">Kurs<span class="text-danger">*</span></label>
						<div class="col-2" >
							<input class="form-control" type="text" name="kurs" value="{{number_format($data->rate,0)}}"  id="kurs" size="7" maxlength="7" >
						</div>
					</div>

					<div class="form-group row">
						<label for="jenis-dinas-input" class="col-2 col-form-label">Lokasi<span class="text-danger">*</span></label>
						<div class="col-4">
							<select name="lokasi" id="lokasi" class="form-control" data-live-search="true">
								<option value="">- Pilih -</option>

							</select>
							<input class="form-control" type="hidden"  value="{{$data->store}}" id="lokasi2">
							<input class="form-control" type="hidden"  value="{{$data->namabank}}-{{$data->norekening}}" id="lokasi1">
						</div>
						@if($mp == 'P')
						<label class="col-1 col-form-label">No Bukti</label>
						<div class="col-2" >
							<input class="form-control disabled bg-secondary" type="text" name="nobukti" value="{{$data->voucher}}"  id="nobukti" size="4" maxlength="4" readonly>
						</div>
						<label class="col-1 col-form-label">No Ver</label>
						<div class="col-2" >
							<input class="form-control disabled bg-secondary" type="text" name="nover" value="{{$data->mrs_no}}"  id="nover" size="4" maxlength="4" readonly>
						</div>
						@else
						<label class="col-1 col-form-label">No Bukti</label>
						<div class="col-5" >
							<input class="form-control disabled bg-secondary" type="text" name="nobukti" value="{{$data->voucher}}"  id="nobukti" size="4" maxlength="4" readonly>
						</div>
						<div class="col-1" >
							<input class="form-control disabled bg-secondary" type="hidden" name="nover" value="{{$data->mrs_no}}"  id="nover" size="4" maxlength="4" readonly>
						</div>
						@endif
					</div>

					<div class="form-group row">
						<label class="col-2 col-form-label">
						@if($mp == "M") Dari @else Kepada @endif<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" name="kepada" id="kepada" value="{{$data->kepada}}" size="40" maxlength="40" required autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-2 col-form-label">Sejumlah</label>
						<div class="col-10">
							<input class="form-control money disabled bg-secondary" type="text"  value="{{ $count }}" size="16" maxlength="16" readonly autocomplete="off">
							<input class="form-control money" type="hidden" name="nilai" id="nilai" value="{{ $count }}" size="16" maxlength="16" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-2 col-form-label">Catatan 1</label>
						<div class="col-10">
							<textarea class="form-control" type="text" name="ket1" id="ket1">{{$data->ket1}}</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-2 col-form-label">Catatan 2</label>
						<div class="col-10">
							<textarea class="form-control" type="text" name="ket2" id="ket2">{{$data->ket2}}</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-2 col-form-label">Catatan 3</label>
						<div class="col-10">
							<textarea class="form-control" type="text" name="ket3" id="ket3">{{$data->ket3}}</textarea>
						</div>
					</div>
                    <div id="button-area">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('penerimaan_kas.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<div class="card-header">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Perbendaharaan &mdash; Kas/Bank
            </h3>
            <div class="text-right">
                <button data-toggle="modal" data-target="#createDetailModal" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </button>
                <button class="btn p-0" id="btn-edit">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning"></i>
                    </span>
                </button>
                <button class="btn p-0" id="btn-delete">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="tabel-detail-permintaan">
            <thead class="thead-light">
                <tr>
                    <th ><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked ></th>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Sanper</th>
                    <th>Bagian</th>
                    <th>PK</th>
                    <th>JB</th>
                    <th>CJ</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data_detail as $detail)
                <tr>
                    <td class="text-center">
                        <label class="radio radio-outline radio-outline-2x radio-primary">
                            <input type="radio" name="btn-radio" nodok="{{ $detail->docno }}" nourut="{{ $detail->lineno }}" class="btn-radio">
                            <span></span>
                        </label>
                    </td>
                    <td>{{ $detail->lineno }}</td>
                    <td>{{ $detail->keterangan }}</td>
                    <td>{{ $detail->account }}</td>
                    <td>{{ $detail->bagian }}</td>
                    <td>{{ $detail->pk }}</td>
                    <td>{{ $detail->jb }}</td>
                    <td>{{ $detail->cj }}</td>
                    <td>{{ number_format($detail->totprice, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="createDetailModal" tabindex="-1" aria-labelledby="createDetailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDetailModalLabel">Tambah Detail Perbendaharaan - Kas/Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form-create-detail" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
					@csrf
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<input style="background-color:#e4e6ef; cursor:not-allowed"  class="form-control" type="text" value="{{ $no_urut }}"  name="nourut" readonly>
							<input style="background-color:#e4e6ef; cursor:not-allowed"  class="form-control" type="hidden" value="{{ $data->docno }}"  name="nodok" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<textarea  class="form-control" type="text" value="" name="rincian" size="50" maxlength="250"  onkeyup="this.value = this.value.toUpperCase()">-</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<select class="form-control select2" style="width: 100% !important;" name="sanper" id="sanper">
								<option value="">- Pilih -</option>
								@foreach($data_account as $data_acc)
								<option value="{{ $data_acc->kodeacct }}">{{ $data_acc->kodeacct }} - {{ $data_acc->descacct }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<select class="form-control select2" style="width: 100% !important;" name="bagian" id="search-bagian">
								<option value="">- Pilih -</option>
								@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<input class="form-control" type="text" value="000000"  name="pk" size="6" maxlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div  class="col-9">
							<select class="form-control select2" style="width: 100% !important;" name="jb" id="search-jenis-biaya">
								<option value="">- Pilih -</option>
								@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<select class="form-control select2" style="width: 100% !important;" name="cj" id="search-cash-judex">
								<option value="">- Pilih -</option>
								@foreach($data_casj as $data_cas)
								<option value="{{ $data_cas->kode }}">{{ $data_cas->kode }} - {{ $data_cas->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<input class="form-control money" type="text" value="" id="nilai-line" name="nilai" size="16" maxlength="16"  required autocomplete="off">
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="modal-editLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-editLabel">Tambah Detail Perbendaharaan - Kas/Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" id="form-edit-detail" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
					@csrf
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<input style="background-color:#e4e6ef; cursor:not-allowed"  class="form-control" type="text" value="" name="nourut" id="nourut" readonly>
							<input style="background-color:#e4e6ef; cursor:not-allowed"  class="form-control" type="hidden" value="" name="nodok" id="nodok" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian<span class="text-danger">*</span></label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<textarea  class="form-control" type="text" value=""  name="rincian" id="rincian" size="50" maxlength="250" required onkeyup="this.value = this.value.toUpperCase()"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<select name="sanper" id="select-sanper" class="cariaccount form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_account as $data_acc)
								<option value="{{ $data_acc->kodeacct }}">{{ $data_acc->kodeacct }} - {{ $data_acc->descacct }}</option>
								@endforeach

							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div  class="col-8">
							<select name="bagian" id="select-bagian" class="caribagian form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<input class="form-control" type="text" value="000000"  name="pk" id="pk" size="6" maxlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div  class="col-8">
							<select name="jb" id="select-jb"  class="carijb form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<select name="cj" id="select-cj" class="caricj form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_casj as $data_cas)
								<option value="{{ $data_cas->kode }}">{{ $data_cas->kode }} - {{ $data_cas->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<input class="form-control money" type="text" name="nilai" id="nilai1"  size="16" maxlength="16"  required autocomplete="off">
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\PenerimaanKasStoreRequest', '#form-edit'); !!}

<script>
	$(document).ready(function () {
		var detailTable = $('#tabel-detail-permintaan').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});

		$('#tabel-detail-permintaan tbody').on( 'click', 'tr', function (event) {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			} else {
				detailTable.$('tr.selected').removeClass('selected');
				if (event.target.type !== 'radio') {
					$(':radio', this).trigger('click');
				}
				$(this).addClass('selected');
			}
		} );

		$('#form-create-detail').on('submit', function () {
            $.ajax({
                url: "{{ route('penerimaan_kas.store.detail', request()->documentId) }}",
                type: "POST",
                data: $('#form-create-detail').serialize(),
                dataType: "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(result){
                    Swal.fire({
                        icon: result.type,
                        title: result.message,
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan, silahkan coba lagi.',
                        text: 'ERROR',
                    });
                }
            });

            return false;
        });

		$('#jk').on('change', function () {
            let jenisKartu = $(this).val();
            let kurs = $("#kurs");

            switch (jenisKartu) {
                case '13':
                    $("#ci").val('2');
                    kurs.val('0')
                    kurs.prop("required", true);
                    kurs.prop("readonly", false);
                    kurs.css("background-color", "#ffffff");
                    kurs.css("cursor", "text");
                    break;
                case '11':
                    $("#ci").val('1');
                    kurs.val('1');
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#e4e6ef");
                    kurs.css("cursor", "not-allowed");
                    break;
                case '10':
                    $("#ci").val('1');
                    kurs.val('1');
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#e4e6ef");
                    kurs.css("cursor", "not-allowed");
                    break;
                default:
                    $("#ci").val(null);
                    kurs.val(null);
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#e4e6ef");
                    kurs.css("cursor", "not-allowed");
                    break;
            }

            let currencyIndex = $('#ci').val();

            $.ajax({
                url : "{{ route('penerimaan_kas.ajax-lokasi') }}",
                type : "POST",
                dataType: 'json',
                data : {
                    jenis_kartu: jenisKartu,
                    currency_index: currencyIndex
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success : function(data){
                    var html = '';
                    var i;

                    html += '<option value="">- Pilih - </option>';

                    for(i = 0; i < data.length; i++){

                        html += '<option value="' + data[i].kode_store + '">' + data[i].kode_store + ' - ' + data[i].nama_bank +' - '+ data[i].nomor_rekening + '</option>';
                    }

                    $('#lokasi').html(html);
                },
                error : function(){
                    alert("Ada kesalahan controller!");
                }
            })
        });

        $('#form-edit-detail').on('submit', function () {
            $.ajax({
                url: "{{ route('penerimaan_kas.store.detail', request()->documentId) }}",
                type: "POST",
                data: $('#form-edit-detail').serialize(),
                dataType: "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(result){
                    Swal.fire({
                        icon: result.type,
                        title: result.message,
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan, silahkan coba lagi.',
                        text: 'ERROR',
                    });
                }
            });

            return false;
        });

		$('#btn-edit').on('click', function(e) {
            e.preventDefault();
            var allVals = [];
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    var nodok = $(this).attr('nodok');
                    if (nodok == ('' || null)) {
                        swalAlertInit('ubah');
                        return;
                    }

                    nodok = nodok.split("/").join("-");
                    var nourut = $(this).attr('nourut');
                        $.ajax({
                            url :"{{ url('perbendaharaan/penerimaan-kas') }}"+ '/' +nodok+ '/' +nourut + '/' + 'get-detail',
                            type : 'get',
                            dataType:"json",
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                            },
                            success:function(data)
                            {
                                $('#nodok').val(data.docno);
                                $('#nourut').val(data.lineno);
                                $('#rincian').val(data.keterangan);
                                $('#pk').val(data.pk);
                                var d=parseFloat(data.totprice);
                                var rupiah = d.toFixed(2);
                                $('#nilai1').val(rupiah);
                                $('#select-lapangan').val(data.lokasi).trigger('change');
                                $('#select-sanper').val(data.account).trigger('change');
                                $('#select-bagian').val(data.bagian).trigger('change');
                                $('#select-jb').val(data.jb).trigger('change');
                                $('#select-cj').val(data.cj).trigger('change');
                                $('#modal-edit').modal('show');
                            }
                        })
                });
            } else {
                swalAlertInit('ubah');
            }
        });

		$('#btn-delete').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var nodok = $(this).attr('nodok');
                    if (nodok == ('' || null)) {
                        swalAlertInit('hapus');
                        return;
                    }

                    nodok = nodok.split("/").join("-");
					var nourut = $(this).attr('nourut');
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
						text: "No. Dokumen : " + nodok+ " No Detail : "+nourut,
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('penerimaan_kas.delete.detail') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"nodok": nodok,
									"nourut": nourut,
									"_token": "{{ csrf_token() }}",
								},
								success: function (data) {
									Swal.fire({
										icon  : 'success',
										title: 'Hapus detail Berhasil',
										text : 'Berhasil',
										timer: 2000
									}).then(function() {
										location.reload();
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

		var jk = $('#jk').val();
		var ci = $('#ci').val();
		var lokasi1 = $('#lokasi1').val();
		var lokasi2 = $('#lokasi2').val();

		$.ajax({
			url : "{{route('penerimaan_kas.ajax-lokasi')}}",
			type : "POST",
			dataType: 'json',
			data : {
				jk:jk,
				ci:ci
			},
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
			},
			success : function(data) {
				var html = '';
				var i;
					html += '<option value="'+lokasi2+'">'+lokasi1+'</option>';
				for(i=0; i<data.length; i++){
					html += '<option value="'+data[i].kodestore+'">'+data[i].namabank+'-'+data[i].norekening+'</option>';
				}
				$('#lokasi').html(html);
			},
			error : function(){
				alert("Ada kesalahan controller!");
			}
		})
	});
</script>
@endpush
