@extends('layout.global')

@section('content')
<!-- begin:: Subheader -->
<div class="subheader   grid__item" id="kt_subheader">
	<div class="container  container--fluid ">
		<div class="subheader__main">
			<h3 class="subheader__title">
				Jurnal Umum </h3>
			<span class="subheader__separator hidden"></span>
			<div class="subheader__breadcrumbs">
				<a href="#" class="subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
				<span class="subheader__breadcrumbs-separator"></span>
				<a href="" class="subheader__breadcrumbs-link">
					Kontroler </a>
				<span class="subheader__breadcrumbs-separator"></span>
				<a href="" class="subheader__breadcrumbs-link">
					Jurnal Umum </a>
				<span class="subheader__breadcrumbs-separator"></span>
				<span class="subheader__breadcrumbs-link subheader__breadcrumbs-link--active">Tambah</span>
			</div>
		</div>
	</div>
</div>
<!-- end:: Subheader -->

<div class="container  container--fluid  grid__item grid__item--fluid">
	<div class="portlet portlet--mobile">
		<div class="portlet__head portlet__head--lg">
			<div class="portlet__head-label">
				<span class="portlet__head-icon">
					<i class="font-brand flaticon2-plus-1"></i>
				</span>
				<h3 class="portlet__head-title">
					Tambah Jurnal Umum
				</h3>			
			</div>
			<div class="portlet__head-toolbar">
				<div class="portlet__head-wrapper">
				</div>
			</div>
		</div>
			<!--begin: Datatable -->
			<form class="form" id="form-edit">
				@csrf
				<div class="portlet__body">
					<div class="form-group form-group-last">
						<div class="alert alert-secondary" role="alert">
							<div class="alert-text">
								<h5 class="portlet__head-title">
									Header Jurnal Umum
								</h5>	
							</div>
						</div>
						@foreach($data_jur as $data)
						<?php 
							$docno = $data->docno;
							$nodok = str_replace('/', '-', $docno);
							$mp = $data->mp;
							$bagian = $data->bagian;
							$nomor = $data->nomor;
							$thnbln = $data->thnbln;
							$bulan = $data->bulan;
							$tahun = $data->tahun;
							$jk = $data->jk;
							$suplesi = $data->suplesi;
							$store = $data->store;
							$keterangan = $data->keterangan;
							$ci = $data->ci;
							$rate = $data->rate;
							$debet = $data->debet;
							$kredit = $data->kredit;
							$nobukti = $data->voucher;
							$status2 = $data->posted;
							$nama_bagian = $data->nama_bagian;
						?>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">No.Dokumen</label>
							<div class="col-5">
								<input style="background-color:#DCDCDC; cursor:not-allowed" class="form-control" type="text" name="mp" value="{{ $mp}}" id="mp" readonly>
								<input  type="hidden" name="docno" value="{{ $docno}}" >
							</div>
							<div class="col-5">
								<input style="background-color:#DCDCDC; cursor:not-allowed" class="form-control" type="text" name="nomor" value="{{ $nomor}}" id="nomor" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Bulan</label>
							<div class="col-3">
								<input class="form-control" type="text" value="{{ $bulan }}"   name="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
							<label for="" class="col-1 col-form-label">Tahun</label>
							<div class="col-3" >
								<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" readonly style="background-color:#DCDCDC; cursor:not-allowed">
								<input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
							</div>
							<label for="" class="col-1 col-form-label">suplesi</label>
							<div class="col-2" >
								<input class="form-control" type="text" value="{{ $suplesi}}"   name="suplesi" size="2" maxlength="2" autocomplete="off">
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Bagian</label>
							<div class="col-5">
								<input class="form-control" type="text" name="bagian" value="{{ $bagian}}" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
							<div class="col-5">
								<input class="form-control" type="text" name="nama_bagian" value="{{ $nama_bagian}}" id="nama_bagian" readonly readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Jenis Kartu</label>
							<div class="col-5">
								<select name="jk" id="jk" class="form-control select2">
									<option value="15" <?php if($jk  == '15' ) echo 'selected' ; ?>>Rupiah</option>
									<option value="18" <?php if($jk  == '18' ) echo 'selected' ; ?>>Dollar</option>

								</select>
								<input name="kurs" type="hidden" value="{{ $rate}}"></td>
							</div>
							<label for="nopek-input" class="col-2 col-form-label">Currency Index</label>
							<div class="col-3">
								<input class="form-control" type="text" name="ci" value="{{ $ci}}"  id="ci" <?php if($ci == 1){ ?> readonly style="background-color:#DCDCDC; cursor:not-allowed" <?php } else { }?>>
							</div>
						</div>
						<div class="form-group row">
							<label for="id-pekerja;-input" class="col-2 col-form-label">Store</label>
							<div class="col-5">
								<input class="form-control" type="text" value="99" name="nokas" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
							<div class="col-5">
								<input class="form-control" type="text" value="JURNAL" name="nama_kas" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">No. Bukti</label>
							<div class="col-10">
								<input class="form-control" type="text" value="{{ $nobukti}}" name="nobukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
						</div>
						<div class="form-group row">
							<label for="id-pekerja;-input" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
							<div class="col-10">
								<textarea class="form-control" type="text" value="" id="kepada" name="kepada" required oninvalid="this.setCustomValidity('Keterangan Harus Diisi..')">{{ $keterangan}}</textarea>
								<input class="form-control" type="hidden" name="tanggal" value="{{ date('Y-m-d') }}" size="15" maxlength="15">
							</div>
						</div>
						@endforeach
						<div class="form__actions">
							<div class="row">
								<div class="col-2"></div>
								<div class="col-10">
									<a href="{{route('jurnal_umum.index')}}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
									@if($status2 <> "Y")
									<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
									@else
									<button type="submit" disabled style="cursor:not-allowed" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				

					
				<div class="portlet__head portlet__head">
					<div class="portlet__head-label">
						<span class="portlet__head-icon">
							<i class="font-brand flaticon2-line-chart"></i>
						</span>
						<h3 class="portlet__head-title">
							Detail Jurnal Umum
						</h3>			
						<div class="portlet__head-toolbar">
							<div class="portlet__head-wrapper">
								<div class="portlet__head-actions">
								@if($status2 <> "Y")
									<a href="#" data-toggle="modal" data-target="#kt_modal_4">
										<span class="font-success">
											<i class="fas fa-plus-circle"></i>
										</span>
									</a>
					
									<a href="#" id="editRow">
										<span class="font-warning">
											<i class="fas fa-edit"></i>
										</span>
									</a>
					
									<a href="#" id="deleteRow">
										<span class="font-danger">
											<i class="fas fa-times-circle"></i>
										</span>
									</a>
								@else
									<span style="font-size: 2em;cursor:not-allowed" class="font-success">
										<i class="fas fa-plus-circle"></i>
									</span>
				
									<span style="font-size: 2em;cursor:not-allowed" class="font-warning">
										<i class="fas fa-edit"></i>
									</span>
				
									<span style="font-size: 2em;cursor:not-allowed" class="font-danger">
										<i class="fas fa-times-circle"></i>
									</span>
								@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="portlet__body">
					<table class="table table-striped table-bordered table-hover table-checkable" id="kt_table">
						<thead class="thead-light">
							<tr>
								<th ></th>
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
						@foreach($data_detail as $data_d)
							<tr>
								<td scope="row" align="center"><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="btn-radio" docno="{{str_replace('/', '-', $data_d->docno)}}" lineno="{{ $data_d->lineno}}" class="btn-radio"><span></span></label></td>
								<td>{{ $data_d->lineno}}</td>
								<td>{{ $data_d->lokasi}}</td>
								<td>{{ $data_d->account}}</td>
								<td>{{ $data_d->bagian}}</td>
								<td>{{ $data_d->pk}}</td>
								<td>{{ $data_d->jb}}</td>
								<td>{{number_format($data_d->debet,2,'.',',')}}</td>
								<td>{{number_format($data_d->kredit,2,'.',',')}}</td>
								<td>{{number_format($data_d->rate,0)}}</td>
								<td>{{ $data_d->keterangan}}</td>
							</tr>
						@endforeach
						</tbody>
						<tr>
							<td colspan="2" align="left"><input id="status2" name="status2" type="checkbox" <?php if($status2  == 'Y' ) echo 'checked' ; ?>> Posting</td>
							<td colspan="6" align="right">Out of Balance : </td>
							<td colspan="3" ><?php echo number_format($jumlahnya, 2, ',', '.').' '.$lab2; ?></td>
						</tr>
					</table>
				</div>
			</form>
			<!--end: Datatable -->
	</div>
</div>


<!--begin::Modal-->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Tambah Detail Transaksi</h5>
			</div>
			<div class="modal-body">
			<span id="form_result"></span>
                <form class="form" id="form-tambah-detail"  enctype="multipart/form-data">
					@csrf
					<input  class="form-control" hidden type="text" value="{{ $docno}}"  name="kode">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-8">
							<input class="form-control" type="hidden" name="tanggal" value="{{ date('Y-m-d') }}" size="15" maxlength="15">
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="text" value="{{ $nu}}"  name="nourut" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian<span class="text-danger">*</span></label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="rincian" autocomplete="off" required oninvalid="this.setCustomValidity('Rincian Harus Diisi..')">
						</div>
					</div>
									
																					
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kd.Lapangan<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="lapangan"  class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Kd.Lapangan Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_lapang as $data_lap)
								<option value="{{ $data_lap->kodelokasi}}">{{ $data_lap->kodelokasi}} - {{ $data_lap->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>			
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="sanper"  class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Sandi Perkiraan Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_sandi as $data_san)
								<option value="{{ $data_san->kodeacct}}">{{ $data_san->kodeacct}} - {{ $data_san->descacct}}</option>
									@endforeach
							</select>
						</div>
					</div>			
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="bagian"  class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Kode Bagian Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja<span class="text-danger">*</span></label>
						<div class="col-8">
							<input  class="form-control" type="text" value="000000"  name="wo" required oninvalid="this.setCustomValidity('Wo Harus Diisi..')">
						</div>
					</div>	
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="jnsbiaya" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Jenis Biaya Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}" <?php if($data_jen->kode  == '000000' ) echo 'selected' ; ?>>{{ $data_jen->kode }} - {{ $data_jen->keterangan}}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Debet</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="debet" size="16" maxlength="16" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kredit</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="kredit" size="16" maxlength="16"  autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kurs</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="rate" size="16" maxlength="16" autocomplete="off" >
						</div>
					</div>

																					
					<div class="form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i>Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!--begin::Modal Edit-->
<!--end::Modal-->
<div class="modal fade modal-edit-detail" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Edit Detail Transaksi</h5>
			</div>
			<div class="modal-body">
			<span id="form_result"></span>
			<form class="form" id="form-edit-detail"  enctype="multipart/form-data">
					@csrf
					<input  class="form-control" hidden type="text" value="{{ $docno}}"  name="kode">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-8">
							<input class="form-control" type="hidden" name="tanggal" value="{{ date('Y-m-d') }}" size="15" maxlength="15">
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="text" value="" name="nourut" id="nourut" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian<span class="text-danger">*</span></label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="rincian" id="rincian" autocomplete="off" required oninvalid="this.setCustomValidity('Rincian Harus Diisi..')">
						</div>
					</div>
									
																					
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kd.Lapangan<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="lapangan" id="lapangan"  class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Kd.Lapangan Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_lapang as $data_lap)
								<option value="{{ $data_lap->kodelokasi}}">{{ $data_lap->kodelokasi}} - {{ $data_lap->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>			
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="sanper" id="sanper" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Sandi Perkiraan Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_sandi as $data_san)
								<option value="{{ $data_san->kodeacct}}">{{ $data_san->kodeacct}} - {{ $data_san->descacct}}</option>
									@endforeach
							</select>
						</div>
					</div>			
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="bagian" id="bagian" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Kode Bagian Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja<span class="text-danger">*</span></label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" id="wo"  name="wo" required oninvalid="this.setCustomValidity('Wo Harus Diisi..')">
						</div>
					</div>	
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya<span class="text-danger">*</span></label>
						<div  class="col-8" >
							<select name="jnsbiaya" id="jnsbiaya" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Jenis Biaya Harus Diisi..')">
								<option value="">-Pilih-</option>
									@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan}}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Debet</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="debet" id="debet" size="16" maxlength="16" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kredit</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="kredit" id="kredit" size="16" maxlength="16"  autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kurs</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="rate" id="rate" size="16" maxlength="16" autocomplete="off" >
						</div>
					</div>

																					
					<div class="form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i>Save</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
	$(document).ready(function () {
		$('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});

$("#status2").on("change", function(){
	window.location.replace("{{ route('jurnal_umum.posting', ['no' => $nodok, 'status' =>$status2] ) }}");
});
$("#jk").on("change", function(){
	var jk = $("#jk").val();
	if(jk == 15){
		$('#ci').val(1);
		$( "#ci" ).prop( "required", false );
		$( "#ci" ).prop( "readonly", true );
		$('#ci').css("background-color","#DCDCDC");
		$('#ci').css("cursor","not-allowed");
	} else {
		$('#ci').val(2);
		$( "#ci" ).prop( "required", true );
		$( "#ci" ).prop( "readonly", false );
		$('#ci').css("background-color","#ffffff");
		$('#ci').css("cursor","text");
	}

});

$('#form-edit').submit(function(){
			$.ajax({
				url  : "{{route('jurnal_umum.update')}}",
				type : "POST",
				data : $('#form-edit').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					if(data == 1){
						Swal.fire({
							type  : 'success',
							title : 'Data Berhasil Diedit',
							text  : 'Berhasil',
							timer : 2000
						}).then(function(data) {
							window.location.replace("{{ route('jurnal_umum.index') }}");
							});
					}else if(data == 2){
						Swal.fire({
						type  : 'info',
						title : 'Status Harus None, Opening Atau Data Sudah Diposting.',
						text  : 'Info',
						timer : 2000
						});
					} else {
						Swal.fire({
						type  : 'info',
						title : 'Data Sudah Di Posting, Tidak Bisa Di Update/Hapus.',
						text  : 'Info',
						timer : 2000
						});
					}
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});	
			return false;
		});
	});

//prosess create detail
 $('#form-tambah-detail').submit(function(){
		$.ajax({
			url  : "{{route('jurnal_umum.store.detail')}}",
			type : "POST",
			data : $('#form-tambah-detail').serialize(),
			dataType : "JSON",
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
			success : function(data){
                if(data == 1){
					Swal.fire({
						type  : 'success',
						title : 'Data Detail Berhasil Ditambah',
						text  : 'Berhasil',
						timer : 2000
					}).then(function() {
						location.reload();
					});
				}else if(data == 2){
					Swal.fire({
						type  : 'info',
						title : 'duplikasi data dokumen detail, entri dibatalkan.',
						text  : 'Info',
						timer : 2000
						}).then(function() {
							location.reload();
						});
				} else {
					Swal.fire({
						type  : 'info',
						title : 'Sandi Perkiraan Salah/Tidak Ditemukan.',
						text  : 'Info',
						timer : 2000
						}).then(function() {
							location.reload();
						});
				}	
			}, 
			error : function(){
				alert("Terjadi kesalahan, coba lagi nanti");
			}
		});	
		return false;
	});


//tampil edit detail
$('#editRow').on('click', function(e) {
	e.preventDefault();
	if($('input[class=btn-radio]').is(':checked')) { 
		$("input[class=btn-radio]:checked").each(function(){
			var no = $(this).attr('docno');
			var id = $(this).attr('lineno');
			$.ajax({
				url :"{{url('kontroler/jurnal_umum/editdetail')}}"+ '/' +no+'/'+id,
				type : 'get',
				dataType:"json",
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
					},
				success:function(data)
				{
					$('#nourut').val(data.lineno);
					$('#rincian').val(data.keterangan);
					var debet=parseInt(data.debet);
					$('#debet').val(debet);
					var kredit=parseInt(data.kredit);
					$('#kredit').val(kredit);
					var rate=parseInt(data.rate);
					$('#rate').val(rate);
					$('#wo').val(data.pk);
					$('.modal-edit-detail').modal('show');
					$('#sanper').val(data.account).trigger('change');
					$('#lapangan').val(data.lokasi).trigger('change');
					$('#jnsbiaya').val(data.jb).trigger('change');
					$('#bagian').val(data.bagian).trigger('change');

				}
			})
		});
	} else {
		swalAlertInit('ubah');
	}
});


	//prosess create detail
	$('#form-edit-detail').submit(function(){
		$.ajax({
			url  : "{{route('jurnal_umum.update.detail')}}",
			type : "POST",
			data : $('#form-edit-detail').serialize(),
			dataType : "JSON",
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
			success : function(data){
					Swal.fire({
						type  : 'success',
						title : 'Data Detail Berhasil Diedit',
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
		return false;
	});


	$('#deleteRow').click(function(e) {
		e.preventDefault();
		if($('input[class=btn-radio]').is(':checked')) { 
			$("input[class=btn-radio]:checked").each(function() {
				var no = $(this).attr('docno');
				var id = $(this).attr('lineno');
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
						text: "Nourut  : " +id,
						type: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
					if (result.value) {
						$.ajax({
							url: "{{ route('jurnal_umum.delete.detail') }}",
							type: 'DELETE',
							dataType: 'json',
							data: {
								"no": no,
								"id": id,
								"_token": "{{ csrf_token() }}",
							},
							success: function () {
								Swal.fire({
									type  : 'success',
									title : "Detail Jurnal Umum Dengan Nourut : " +id+" Berhasil Dihapus.",
									text  : 'Berhasil',
									
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
</script>

@endsection
