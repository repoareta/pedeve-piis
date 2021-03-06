@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Menu Permintaan Bayar
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="card-body">
            <form action="{{ $data_bayar->app_pbd == 'Y' ? '#' : route('modul_umum.permintaan_bayar.store') }}" method="post" id="form-edit-permintaan-bayar">
                @csrf
                <div class="alert alert-custom alert-default" role="alert">
                    <div class="alert-text">
                        Header Permintaan Bayar
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">No. Permintaan <span class="text-danger">*</span></label>
                    <div class="col-5">
                        <input class="form-control disabled bg-secondary" type="text" name="nobayar" value="{{$data_bayar->no_bayar}}" id="nobayar" readonly>
                    </div>

                    <label for="" class="col-2 col-form-label">Tanggal <span class="text-danger">*</span></label>
                    <div class="col-3">
                        <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ date("d-m-Y", strtotime($data_bayar->tgl_bayar)) }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nopek-input" class="col-2 col-form-label">Terlampir <span class="text-danger">*</span></label>
                    <div class="col-10">
                        <textarea class="form-control" type="text" name="lampiran" value=""  id="lampiran"  required>{{$data_bayar->lampiran}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id-pekerja;-input" class="col-2 col-form-label">Keterangan <span class="text-danger">*</span></label>
                    <div class="col-10">
                        <textarea class="form-control" type="text" value=""  name="keterangan" size="50" maxlength="200" required>{{$data_bayar->keterangan}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis-dinas-input" class="col-2 col-form-label">Dibayar Kepada <span class="text-danger">*</span></label>
                    <div class="col-10">
                        <select name="dibayar" id="dibayar" class="form-control selectpicker" data-live-search="true" required oninvalid="this.setCustomValidity('Dibayar Kepada Harus Diisi..')" onchange="setCustomValidity('')">
                            <option value="">- Pilih -</option>
                            @foreach ($vendor as $row)
                            <option value="{{ $row->nama }}" <?php if($row->nama  == $data_bayar->kepada ) echo 'selected' ; ?>>{{ $row->nama }}</option>
                            @endforeach
                        </select>
                        <div id="dibayar-error-placement"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Rekening Bank</label>
                    <div class="col-10">
                        <input style="width: 17px;height: 30px;" name="rekyes" type="checkbox"  id="rekyes" value="{{$data_bayar->rekyes}}" <?php if ($data_bayar->rekyes == '1' )  echo 'checked' ; ?>></td>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dari-input" class="col-2 col-form-label">Debet Dari</label>
                    <div class="col-10">
                        <select name="debetdari" id="select-debetdari" class="form-control selectpicker" data-live-search="true" >
                            <option value="">- Pilih -</option>
                            @foreach ($debit_nota as $row)
                            <option value="{{ $row->kode }}" <?php if($row->kode == $data_bayar->debet_dari ) echo 'selected' ; ?>>{{ $row->kode.' - '.$row->keterangan }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">No. Debet</label>
                    <div class="col-5">
                        <input class="form-control" type="text" name="nodebet" id="nodebet" value="{{$data_bayar->debet_no}}" size="15" maxlength="15" >
                    </div>
                    <label class="col-2 col-form-label">Tgl Debet</label>
                    <div class="col-3" >
                        <input class="form-control" type="text" name="tgldebet" value="<?php echo date("d-m-Y", strtotime($data_bayar->debet_tgl)) ?>" id="tgldebet" size="15" maxlength="15" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for=""  class="col-2 col-form-label">No. Kas</label>
                    <div class="col-5">
                        <input readonly class="form-control disabled bg-secondary" name="nokas" type="text" value="{{ $data_bayar->no_kas }}" id="nokas" size="10" maxlength="25">
                    </div>
                    <label for=""  class="col-2 col-form-label">Bulan Buku <span class="text-danger">*</span></label>
                    <div class="col-3" >
                        <input class="form-control disabled bg-secondary" type="text" value="{{ $data_bayar->bulan_buku }}"  name="bulanbuku" size="6" maxlength="6" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">CI</label>
					<div class="col-5 col-form-label">
						<div class="radio-inline">
							<label class="radio">
								<input type="radio" value="1" name="ci" id="1" onclick="displayResult(1)" checked>
							<span></span>IDR</label>
							<label class="radio">
								<input type="radio" value="2" name="ci" id="2" onclick="displayResult(2)">
							<span></span>USD</label>
						</div>
					</div>
                    <label for="" class="col-2 col-form-label">Kurs <span class="text-danger">*</span></label>
                    <div class="col-3">
                        <input class="form-control" type="text" name="kurs" id="kurs" value="<?php echo number_format($data_bayar->rate, 0, ',', '.'); ?>" size="10" maxlength="10" onkeypress="return hanyaAngka(event)" >
                        <input class="form-control" type="hidden" id="data-kurs" value="<?php echo number_format($data_bayar->rate, 0, ',', '.'); ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mulai-input" class="col-2 col-form-label">Periode <span class="text-danger">*</span></label>
                    <div class="col-10">
                        <div class="input-daterange input-group" id="date_range_picker">
                            <input type="text" class="form-control" name="mulai" value="<?php echo date("d-m-Y", strtotime($data_bayar->mulai)) ?>" />
                            <div class="input-group-append">
                                 <span class="input-group-text">s/d</span>
                            </div>
                            <input type="text" class="form-control" name="sampai"  value="<?php echo date("d-m-Y", strtotime($data_bayar->sampai)) ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Total Nilai</label>
                    <div class="col-10">
                        <input class="form-control disabled bg-secondary" value="<?php echo number_format($count, 2, '.', ','); ?>" readonly>
                        <input class="form-control disabled bg-secondary" name="totalnilai" type="text" id="totalnilai" value="<?php echo number_format($count, 2, '.', ''); ?>" hidden>
                    </div>
                </div>

                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{route('modul_umum.permintaan_bayar.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Batal</a>
                            <button type="submit" class="btn btn-primary {{ $data_bayar->app_pbd == 'Y' ? 'd-none' : null }}"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-header justify-content-start">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Detail Permintaan Bayar
            </h3>
        </div>

        <div class="card-toolbar">
            <div class="float-left">
                <a href="#" data-toggle="modal" data-target="#modal-create-detail-bayar">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="table-detail">
            <thead class="thead-light">
                <tr>
                    <th ><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked ></th>
                    <th >No.</th>
                    <th >Keterangan</th>
                    <th >Bagian</th>
                    <th >Account</th>
                    <th >JB</th>
                    <th >PK</th>
                    <th >CJ</th>
                    <th >Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=0; ?>
                @foreach($data_bayar_details as $data_bayar_detail)
                <?php $no++; ?>
                    <tr>
                        <td scope="row" align="center"><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="btn-radio" data-no="{{$data_bayar_detail->no}}"  data-id="{{str_replace('/', '-', $data_bayar_detail->no_bayar)}}" nobayar="{{$data_bayar_detail->no_bayar}}" class="btn-radio" ><span></span></label></td>
                        <td scope="row" align="center">{{$no}}</td>
                        <td>{{$data_bayar_detail->keterangan}}</td>
                        <td align="center">{{$data_bayar_detail->bagian}}</td>
                        <td align="center">{{$data_bayar_detail->account}}</td>
                        <td align="center">{{$data_bayar_detail->jb}}</td>
                        <td align="center">{{$data_bayar_detail->pk}}</td>
                        <td align="center">{{$data_bayar_detail->cj}}</td>
                        <td><?php echo number_format($data_bayar_detail->nilai, 2, '.', ','); ?></td>
                    </tr>
                @endforeach
            </tbody>
			<tfoot>
				<tr>
					<td colspan="8" align="right">Jumlah Total : </td>
					<td ><?php echo number_format($count, 2, '.', ','); ?></td>
				</tr>
			</tfoot>
        </table>
    </div>
</div>

<!--begin::Modal-->
<div class="modal fade modal-create-detail-bayar" id="modal-create-detail-bayar"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Tambah Menu Rincian Minta Bayar</h5>
			</div>
			<div class="modal-body">
                <form class="kt-form" id="form-tambah-bayar-detail" enctype="multipart/form-data">
					@csrf
                    <input class="form-control" hidden type="text" value="{{ $data_bayar->no_bayar }}" name="nobayar">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" value="{{ $no_bayar_details }}" name="no" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value=""  name="keterangan" required oninvalid="this.setCustomValidity('Keterangan Harus Diisi..')" oninput="setCustomValidity('')">-</textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div  class="col-10" >
							<select class="cariaccount form-control select2" style="width: 100% !important;" name="acc" id="acc">
                                <option value="">-Pilih-</option>
                                @foreach($data_account as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
                            </select>
							<div id="acc-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-10">
							<select class="caribagian form-control select2" style="width: 100% !important;" name="bagian" id="bagian">
                                <option value="">-Pilih-</option>
                                @foreach($data_bagian as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
							<div id="bagian-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input  class="form-control" type="text" value="000"  name="pk" size="6" maxlength="6" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-10">
							<select class="carijb form-control select2" style="width: 100% !important;" name="jb" id="jb">
                                <option value="">-Pilih-</option>
                                @foreach($data_jenisbiaya as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
                            </select>
							<div id="jb-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-10">
							<select class="caricj form-control select2" style="width: 100% !important;" name="cj" id="cj">
                                <option value="">-Pilih-</option>
                                @foreach($data_cj as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
								@endforeach
                            </select>
							<div id="cj-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control money" type="text" name="nilai" required autocomplete="off">
						</div>
					</div>

					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset" class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i>Batal</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--end::Modal-->
<div class="modal fade modal-edit-detail-bayar" id="modal-edit-detail-bayar"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Edit Menu Rincian Minta Bayar</h5>
			</div>
			<div class="modal-body">
                <form class="kt-form" id="form-edit-bayar-detail" enctype="multipart/form-data">
					@csrf
                    <input class="form-control" hidden type="text" value="{{$data_bayar->no_bayar}}" name="nobayar">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-10">
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="text" value="{{$no_bayar_details}}" id="no" name="no" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value="" id="keterangan" name="keterangan"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div id="div-acc" class="col-10">
							<select name="acc" id="select-acc" class="cariaccount form-control" style="width: 100% !important;" id="acc-edit">
								<option value="">-Pilih-</option>
                                @foreach($data_account as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
							</select>
							<div id="acc-edit-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div id="div-bagian" class="col-10">
							<select name="bagian" id="select-bagian"  class="caribagian form-control" style="width: 100% !important;" id="bagian-edit">
								<option value="">-Pilih-</option>
                                @foreach($data_bagian as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
							</select>
							<div id="bagian-edit-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input  class="form-control" type="text" value="" id="pk" name="pk" size="6" maxlength="6" autocomplete="off">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div id="div-jb" class="col-10">
							<select name="jb" id="select-jb" class="carijb form-control" style="width: 100% !important;" id="jb-edit">
								<option value="">-Pilih-</option>
                                @foreach($data_jenisbiaya as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
							</select>
							<div id="jb-edit-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-10" id="div-cj">
							<select name="cj" id="select-cj" class="caricj form-control" style="width: 100% !important;" id="cj-edit">
								<option value="">-Pilih-</option>
                                @foreach($data_cj as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
								@endforeach
							</select>
							<div id="cj-edit-error-placement"></div>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<div class="col-10">
							<input  class="form-control money" type="text" name="nilai" id="nilai" autocomplete="off">
						</div>
					</div>
					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i>Batal</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Simpan</button>
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
{!! JsValidator::formRequest('App\Http\Requests\PermintaanBayarStoreRequest', '#form-edit-permintaan-bayar'); !!}
{!! JsValidator::formRequest('App\Http\Requests\PermintaanBayarDetailStoreRequest', '#form-tambah-bayar-detail'); !!}
{!! JsValidator::formRequest('App\Http\Requests\PermintaanBayarDetailStoreRequest', '#form-edit-bayar-detail'); !!}

<script>
    $(document).ready(function () {
		var t = $('#table-detail').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});

		$('#table-detail tbody').on( 'click', 'tr', function (event) {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			} else {
				t.$('tr.selected').removeClass('selected');
				// $(':radio', this).trigger('click');
				if (event.target.type !== 'radio') {
					$(':radio', this).trigger('click');
				}
				$(this).addClass('selected');
			}
		} );

		$('.kt-select2').select2().on('change', function() {
			// $(this).valid();
		});

		$("input[name=ci]:checked").each(function() {
			var ci = $(this).val();
			if(ci == 1) {
				$('#kurs').val(1);
				$('#simbol-kurs').hide();
				$( "#kurs" ).prop( "required", false );
				$( "#kurs" ).prop( "readonly", true );
				$('#kurs').addClass("disabled bg-secondary");
			} else {
				var kurs1 = $('#data-kurs').val();
				$('#kurs').val(kurs1);
				$('#simbol-kurs').show();
				$( "#kurs" ).prop( "required", true );
				$( "#kurs" ).prop( "readonly", false );
                $('#kurs').removeClass("disabled bg-secondary");
			}

		});

		// proses update permintaan bayar
		$('#form-edit-permintaan-bayar').submit(function(e){
			e.preventDefault();

            if ($('#dibayar-error').length) $('#dibayar-error').insertAfter('#dibayar-error-placement');

			if ($(this).valid()) {
				var no_umk = $("#noumk").val();
				$.ajax({
					url : "{{route('modul_umum.permintaan_bayar.store')}}",
					type : "POST",
					data : $('#form-edit-permintaan-bayar').serialize(),
					dataType : "JSON",
					success : function(data){
						Swal.fire({
							icon : 'success',
							title : 'Data Permintaan Biaya Berhasil Disimpan',
							text : 'Berhasil',
							timer : 2000
						}).then(function() {
							location.href = "{{ route('modul_umum.permintaan_bayar.index')}}";
						});
					},
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		//prosess create detail
		$('#form-tambah-bayar-detail').submit(function(e) {
			e.preventDefault();

			if ($('#acc-error').length) $('#acc-error').insertAfter('#acc-error-placement');
			if ($('#bagian-error').length) $('#bagian-error').insertAfter('#bagian-error-placement');
			if ($('#jb-error').length) $('#jb-error').insertAfter('#jb-error-placement');
			if ($('#cj-error').length) $('#cj-error').insertAfter('#cj-error-placement');

			if ($(this).valid()) {
				$.ajax({
					url  : "{{route('modul_umum.permintaan_bayar.store.detail')}}",
					type : "POST",
					data : $('#form-tambah-bayar-detail').serialize(),
					dataType : "JSON",
					success : function(data){
						Swal.fire({
							icon  : 'success',
							title : 'Data Detail Permintaan Biaya Berhasil Ditambah',
							text  : 'Berhasil',
							timer : 2000
						}).then(function() {
							location.reload();
						});
					},
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		//proses update detail
		$('#form-edit-bayar-detail').submit(function(e) {
			e.preventDefault();

			if ($('#acc-edit-error').length) $('#acc-edit-error').insertAfter('#acc-edit-error-placement');
			if ($('#bagian-edit-error').length) $('#bagian-edit-error').insertAfter('#bagian-edit-error-placement');
			if ($('#jb-edit-error').length) $('#jb-edit-error').insertAfter('#jb-edit-error-placement');
			if ($('#cj-edit-error').length) $('#cj-edit-error').insertAfter('#cj-edit-error-placement');

			if ($(this).valid()) {
				$.ajax({
					url  : "{{route('modul_umum.permintaan_bayar.store.detail')}}",
					type : "POST",
					data : $('#form-edit-bayar-detail').serialize(),
					dataType : "JSON",
					success : function(data){
						Swal.fire({
							icon : 'success',
							title : 'Data Detail Permintaan Biaya Berhasil Diubah',
							text : 'Berhasil',
							timer : 2000
						}).then(function() {
							window.location.reload();
						});
					},
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});

		//tampil edit detail
		$('#editRow').on('click', function(e) {
			e.preventDefault();
			var allVals = [];
			$(".btn-radio:checked").each(function() {
				var dataid = $(this).attr('data-id');
				var datano = $(this).attr('data-no');
				if(dataid == 1) {
					swalAlertInit('ubah');
				}  else {
					$.ajax({
						url :"{{url('umum/permintaan-bayar/editdetail')}}"+ '/' +dataid+ '/' +datano,
						type : 'get',
						dataType:"json",
						headers: {
							'X-CSRF-Token': '{{ csrf_token() }}',
						},
						success:function(data) {
							$('#no').val(data.no);
							$('#keterangan').val(data.keterangan);
							$('#pk').val(data.pk);
							var d=parseFloat(data.nilai);
							var rupiah = d.toFixed(2);
							$('#nilai').val(rupiah);
							$('.modal-edit-detail-bayar').modal('show');
							$('#select-bagian').val(data.bagian).trigger('change');
							$('#select-acc').val(data.account).trigger('change');
							$('#select-jb').val(data.jb).trigger('change');
							$('#select-cj').val(data.cj).trigger('change');
						}
					})
				}

			});
		});

		//delete permintaan bayar detail
		$('#deleteRow').click(function(e) {
			e.preventDefault();
			$(".btn-radio:checked").each(function() {
				var dataid = $(this).attr('data-id');
				if(dataid == 1)   {
					swalAlertInit('hapus');
				} else {
				$("input[type=radio]:checked").each(function() {
                    var id = $(this).attr('nobayar');
                    var no = $(this).attr('data-no');
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
							text: "No. Bayar : " + id+"dan NO urut :"+no,
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
							if (result.value) {
								$.ajax({
									url: "{{ route('modul_umum.permintaan_bayar.delete.detail') }}",
									type: 'DELETE',
									dataType: 'json',
									data: {
										"id": id,
										"no": no,
										"_token": "{{ csrf_token() }}",
									},
									success: function () {
										Swal.fire({
											icon  : 'success',
											title : 'Hapus Data Detail Permintaan Bayar',
											text  : 'Berhasil',
											timer : 2000
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
				}
			});
		});

		// range picker
		$('#date_range_picker').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});

		// minimum setup
		$('#tgldebet').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
	});

	function displayResult(ci){
		if(ci == 1) {
			$('#kurs').val(1);
			$('#simbol-kurs').hide();
			$( "#kurs" ).prop( "required", false );
			$( "#kurs" ).prop( "readonly", true );
			$('#kurs').addClass("disabled bg-secondary");
		} else {
			var kurs1 = $('#data-kurs').val();
			$('#kurs').val(kurs1);
			$('#simbol-kurs').show();
			$( "#kurs" ).prop( "required", true );
			$( "#kurs" ).prop( "readonly", false );
			$('#kurs').removeClass("disabled bg-secondary");
		}
	}
</script>
@endpush
