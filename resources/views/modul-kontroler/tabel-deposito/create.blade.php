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
			<form class="form" id="form-create">
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
					
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">No.Dokumen</label>
							<div class="col-5">
							<?php 
								$docno = $mp.'-'.$bagian.'-'.$nomor;
							?>
								<input style="background-color:#DCDCDC; cursor:not-allowed" class="form-control" type="text" name="mp" value="{{ $mp}}" id="mp" readonly>
							</div>
							<div class="col-5">
								<input style="background-color:#DCDCDC; cursor:not-allowed" class="form-control" type="text" name="nomor" value="{{ $nomor}}" id="nomor" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Bulan</label>
							<div class="col-3">
								<?php
									$jabatan = "Sekretaris Perseroan";
									$nama = "Silahkan Isi";
									?>
								<select class="form-control" name="bulan">
									<option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
									<option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
									<option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
									<option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
									<option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
									<option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
									<option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
									<option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
									<option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
									<option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
									<option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
									<option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
								</select>
							</div>
							<label for="" class="col-1 col-form-label">Tahun</label>
							<div class="col-3">
								<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
								<input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
							</div>
							<label for="" class="col-1 col-form-label">suplesi</label>
							<div class="col-2">
								<input class="form-control" type="text" name="suplesi" value="{{ $suplesi }}" size="2" maxlength="2" autocomplete="off">
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Bagian</label>
							<div class="col-5">
								<input class="form-control" type="text" name="bagian" value="{{ $bagian}}" id="bagian">
							</div>
							<div class="col-5">
								<input class="form-control" type="text" name="nama_bagian" value="{{ $nama_bagian}}" id="nama_bagian" readonly style="background-color:#DCDCDC; cursor:not-allowed">
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-2 col-form-label">Jenis Kartu</label>
							<div class="col-5">
								<select name="jk" id="jk" class="form-control select2">
									<option value="15">Rupiah</option>
									<option value="18">Dollar</option>

								</select>
								<input name="kurs" type="hidden" value="{{ $rate}}"></td>
							</div>
							<label for="nopek-input" class="col-2 col-form-label">Currency Index</label>
							<div class="col-3">
								<input class="form-control" type="text" name="ci" value="1" id="ci"  readonly style="background-color:#DCDCDC; cursor:not-allowed">
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
								<textarea class="form-control" type="text" value="" id="kepada" name="kepada" required oninvalid="this.setCustomValidity('Keterangan Harus Diisi..')"></textarea>
								<input class="form-control" type="hidden" name="tanggal" value="{{ date('Y-m-d') }}" size="15" maxlength="15">
							</div>
						</div>
						
						<div class="form__actions">
							<div class="row">
								<div class="col-2"></div>
								<div class="col-10">
									<a href="{{ route('jurnal_umum.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
									<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
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
									<span style="font-size: 2em;cursor:not-allowed" class="font-success">
										<i class="fas fa-plus-circle"></i>
									</span>
				
									<span style="font-size: 2em;cursor:not-allowed" class="font-warning">
										<i class="fas fa-edit"></i>
									</span>
				
									<span style="font-size: 2em;cursor:not-allowed" class="font-danger">
										<i class="fas fa-times-circle"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="portlet__body">
					<table class="table table-bordered" id="tabel-detail-permintaan">
						<thead class="thead-light">
							<tr>
								<th ><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked ></th>
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
			</form>
			<!--end: Datatable -->
	</div>
</div>
@endsection

@section('scripts')
	<script type="text/javascript">
	$(document).ready(function () {
		$('#tabel-detail-permintaan').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
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
		


		$('#form-create').submit(function(){
			$.ajax({
				url  : "{{ route('jurnal_umum.store') }}",
				type : "POST",
				data : $('#form-create').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
				if(data == 1){
					Swal.fire({
						icon  : 'success',
						title : 'Data Berhasil Ditambah',
						text  : 'Berhasil',
						timer : 2000
					}).then(function(data) {
						window.location.replace("{{ route('jurnal_umum.edit', ['no' => $docno] ) }}");
						});
				} else {
					Swal.fire({
						type  : 'info',
						title : 'Duplikasi data dokumen, entri dibatalkan.',
						text  : 'Info',
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
	
</script>

@endsection
