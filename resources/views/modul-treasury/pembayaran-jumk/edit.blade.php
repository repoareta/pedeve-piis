@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')
<div class="card card-custom" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Menu Edit Pembayaran Pertanggungjawaban UMK
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" id="form-edit">
            @csrf
            @foreach($data_list as $data)
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
                    <input type="text" class="form-control disabled bg-secondary"  value="{{ $mp}}" size="1" maxlength="1" name="mp" id="mp" readonly>
                    <input class="form-control disabled bg-secondary" type="hidden" value="{{ $nodok}}"  name="nodok" readonly>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control disabled bg-secondary"  value="{{ $nomor}}" size="1" maxlength="1" name="nomor" id="nomor" readonly>
                </div>
            </div>

            <div class="form-group row">
            <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
            <div class="col-4">
                <input class="form-control disabled bg-secondary" type="text" value="{{ $bulan }}" name="bulan" id="bulan" size="2" maxlength="2" readonly>
                <input class="form-control disabled bg-secondary" type="hidden" value="{{ $data->thnbln}}" name="bulanbuku" id="bulanbuku" size="6" maxlength="6" readonly>
                
            </div>
                <div class="col-6">
                    <input class="form-control tahun disabled bg-secondary" type="text" name="tahun" value="{{ $tahun }}" id="tahun" readonly>
                    <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                </div>
            </div>

            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label">Bagian<span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="bagian" id="bagian" class="form-control select2" style="width: 100%;">
                        <option value="">- Pilih -</option>
                        @foreach($data_bagian as $row)
                        <option value="{{ $row->kode }}" <?php if($row->kode == $bagian) echo 'selected'; ?>>{{ $row->kode }} - {{ $row->nama }}</option>
                        @endforeach
                        
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Jenis Kartu<span class="text-danger">*</span></label>
                <div class="col-3">
                    <select name="jk" id="jk" class="form-control select2" style="width: 100% !important;">
                        <option value="">- Pilih -</option>
                        <option value="10" <?php if($data->jk == '10') echo 'selected'; ?>>Kas(Rupiah)</option>
                        <option value="11" <?php if($data->jk == '11') echo 'selected'; ?>>Bank(Rupiah)</option>
                        <option value="13" <?php if($data->jk == '13') echo 'selected'; ?>>Bank(Dollar)</option>
                        
                    </select>							</div>
                <label class="col-2 col-form-label">Currency Index</label>
                <div class="col-2">
                    <input class="form-control disabled bg-secondary" type="text" name="ci" value="{{ $data->ci}}" id="ci" size="6" maxlength="6" readonly>
                </div>
                <label class="col-1 col-form-label">Kurs<span class="text-danger">*</span></label>
                <div class="col-2">
                    <input class="form-control" type="text" name="kurs" value="{{ number_format($data->rate,0) }}" id="kurs" size="7" maxlength="7">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label">Lokasi<span class="text-danger">*</span></label>
                <div class="col-4">
                    <select name="lokasi" id="lokasi" class="form-control">
                        <option value="">- Pilih -</option>
                        
                    </select>
                    <input class="form-control" type="hidden" value="{{ $data->store }}" id="lokasi2">
                    <input class="form-control" type="hidden" value="{{ $data->namabank }}-{{ $data->norekening }}" id="lokasi1">
                </div>
                @if($mp == 'P')
                <label class="col-1 col-form-label">No Bukti</label>
                <div class="col-2">
                    <input class="form-control disabled bg-secondary" type="text" name="nobukti" value="{{ $data->voucher }}" id="nobukti" readonly>
                </div>
                <label class="col-1 col-form-label">No Ver</label>
                <div class="col-2">
                    <input class="form-control disabled bg-secondary" type="text" name="nover" value="{{ $data->mrs_no }}" id="nover" readonly>
                </div>
                @else
                <label class="col-1 col-form-label">No Bukti</label>
                <div class="col-5">
                    <input class="form-control disabled bg-secondary" type="text" name="nobukti" value="{{ $data->voucher }}" id="nobukti" readonly>
                </div>
                <div class="col-1">
                    <input class="form-control disabled bg-secondary" type="hidden" name="nover" value="{{ $data->mrs_no }}" id="nover" readonly>
                </div>
                @endif
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">
                @if($mp == "M") Dari @else Kepada @endif<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary" type="text" name="kepada" id="kepada" value="{{ $data->kepada }}" size="40" maxlength="40" required readonly autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Sejumlah<span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary money" type="text"  value="{{ $data->nilai_dok }}" size="16" maxlength="16" readonly required autocomplete="off">
                    <input class="form-control disabled bg-secondary" type="hidden" name="nilai" id="nilai" value="{{ $count }}" size="16" maxlength="16" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Catatan 1</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="ket1" id="ket1" autocomplete="off">{{ $data->ket1 }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Catatan 2</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="ket2" id="ket2" autocomplete="off">{{ $data->ket2}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">Catatan 3</label>
                <div class="col-10">
                    <textarea class="form-control" type="text" name="ket3" id="ket3" autocomplete="off">{{ $data->ket3}}</textarea>
                </div>
            </div>
            @endforeach
            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('pembayaran_jumk.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
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
                Detail Pembayaran Pertanggungjawaban UMK
            </h3>
        </div>
		<div class="card-toolbar">
			<div class="float-left">
				<button id="btn-create" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data Detail">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </button>
                <button id="btn-edit" class="btn p-0">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah Data Detail">
                        <i class="fas fa-2x fa-edit text-warning"></i>
                    </span>
                </button>
                <button id="btn-delete" class="btn p-0">
                    <span class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data Detail">
                        <i class="fas fa-2x fa-times-circle text-danger"></i>
                    </span>
                </button>
			</div>
		</div>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="kt_table">
            <thead class="thead-light">
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">No</th>
                    <th>Rincian</th>
                    <th class="text-center">Sanper</th>
                    <th class="text-center">Bagian</th>
                    <th class="text-center">PK</th>
                    <th class="text-center">JB</th>
                    <th class="text-center">CJ</th>	
                    <th class="text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=0; ?>
                @foreach($data_detail as $data_d)
                <?php $no++; ?>
                <tr>
                    <td scope="row" class="text-center"><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="btn-radio" nodok="{{ $data_d->docno }}" nourut="{{ $data_d->lineno }}"  class="btn-radio"><span></span></label></td>
                    <td scope="row" class="text-center">{{ $data_d->lineno }}</td>
                    <td>{{ $data_d->keterangan }}</td>
                    <td class="text-center">{{ $data_d->account}}</td>
                    <td class="text-center">{{ $data_d->bagian}}</td>
                    <td class="text-center">{{ $data_d->pk}}</td>
                    <td class="text-center">{{ $data_d->jb}}</td>
                    <td class="text-center">{{ $data_d->cj}}</td>
                    <td class="text-center">{{ number_format($data_d->totprice,2,'.',',') }}</td>
                </tr>
                @endforeach
            </tbody>
			<tfoot>
                <tr>
                    <td colspan="8" align="right">Jumlah Total : </td>
                    <td >Rp. <?php echo number_format($count, 0, '.', ','); ?></td>
                </tr>
			</tfoot>
        </table>
    </div>
</div>

<!--begin::Modal creaate--> 
<div class="modal fade modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail"></h5>
			</div>
			<div class="modal-body">
				<span id="form_result"></span>
				<form class="form" id="form-create-detail"  enctype="multipart/form-data">
					@csrf
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" value="{{ $no_urut }}"  name="nourut" readonly>
							<input class="form-control disabled bg-secondary" type="hidden" value="{{ $nodok }}"  name="nodok" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian<span class="text-danger">*</span></label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value=""  name="rincian" size="50" maxlength="250"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan<span class="text-danger">*</span></label>
						<div class="col-10">
							<select name="sanper"  class="form-control select2" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach($data_account as $data_acc)
								<option value="{{ $data_acc->kodeacct }}">{{ $data_acc->kodeacct }} - {{ $data_acc->descacct }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian<span class="text-danger">*</span></label>
						<div  class="col-10">
							<select name="bagian"  class="form-control select2" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>
	
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input class="form-control" type="text" value="000000"  name="pk" size="6" maxlength="6">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya<span class="text-danger">*</span></label>
						<div  class="col-10">
							<select name="jb"  class="form-control select2" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
								@endforeach
							</select>
						</div>
					</div>
									
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex<span class="text-danger">*</span></label>
						<div class="col-10">
							<select name="cj" class="form-control select2" style="width: 100%;">
								<option value="">- Pilih -</option>
								@foreach($data_casj as $data_cas)
								<option value="{{ $data_cas->kode }}">{{ $data_cas->kode }} - {{ $data_cas->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control money" type="text" name="nilai" size="25" maxlength="25" required autocomplete="off">
						</div>
					</div>

					<div class="form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<!--begin::Modal Edit--> 
<div class="modal fade modal-edit" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-edit-detail"></h5>
			</div>
			<div class="modal-body">
				<span id="form_result"></span>
                <form class="form" id="form-edit-detail"  enctype="multipart/form-data" autocomplete="off">
					@csrf
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control disabled bg-secondary" type="text" value="" name="nourut" id="nourut" readonly>
							<input class="form-control" type="hidden" value="" name="nodok" id="nodok" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian<span class="text-danger">*</span></label>
						<div class="col-10">
							<textarea  class="form-control" type="text" value=""  name="rincian" id="rincian" size="50" maxlength="250"></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan</label>
						<div class="col-10">
							<select name="sanper" id="select-sanper" class="form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_account as $data_acc)
								<option value="{{ $data_acc->kodeacct }}">{{ $data_acc->kodeacct }} - {{ $data_acc->descacct }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-10">
							<select name="bagian" id="select-bagian" class="form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-10">
							<input class="form-control" type="text"   name="pk" id="pk" size="6" maxlength="6">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-10">
							<select name="jb" id="select-jb"  class="form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-10">
							<select name="cj" id="select-cj" class="form-control select2" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_casj as $data_cas)
								<option value="{{ $data_cas->kode }}">{{ $data_cas->kode }} - {{ $data_cas->nama }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<div class="col-10">
							<input class="form-control money" type="text" value="" name="nilai" id="nilai1" size="16" maxlength="16" required autocomplete="off">
						</div>
					</div>
												
					<div class="form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply"></i>Cancel</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
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
{!! JsValidator::formRequest('App\Http\Requests\PembayaranGajiStoreRequest', '#form-edit'); !!}

<script>
	$(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});
		
		var jk = $('#jk').val();
		if(jk == '13'){
			$("#ci").val('2');
			$("#kurs").val('0');
			$( "#kurs" ).prop( "required", true );
			$( "#kurs" ).prop( "readonly", false );
			$('#kurs').css("background-color","#ffffff");
			$('#kurs').css("cursor","text");
			$("#jnskas").val('2');
			$("#nokas").val("");
			$("#nobukti1").val("");
			$("#nama_kas").val("");
		} else if (jk == '11'){
			$("#ci").val('1');
			$("#kurs").val('1');
			$( "#kurs" ).prop( "required", false );
			$( "#kurs" ).prop( "readonly", true );
			$('#kurs').css("background-color","#e4e6ef");
			$('#kurs').css("cursor","not-allowed");
			$("#jnskas").val('2');
			$("#nokas").val("");
			$("#nobukti1").val("");
			$("#nama_kas").val("");
		}else if (jk == '10'){
			$("#ci").val('1');
			$("#kurs").val('1');
			$( "#kurs" ).prop( "required", false );
			$( "#kurs" ).prop( "readonly", true );
			$('#kurs').css("background-color","#e4e6ef");
			$('#kurs').css("cursor","not-allowed");
			$("#jnskas").val('1');
			$("#nokas").val("");
			$("#nobukti1").val("");
			$("#nama_kas").val("");
		} else {
			$("#ci").val("");
			$("#kurs").val("");
			$( "#kurs" ).prop( "required", true );
			$( "#kurs" ).prop( "readonly", false );
			$('#kurs').css("background-color","#ffffff");
			$('#kurs').css("cursor","text");
			$("#jnskas").val("");
			$("#nokas").val("");
			$("#nobukti1").val("");
			$("#nama_kas").val("");
		}

		var jk = $('#jk').val();
		var ci = $('#ci').val();
		var lokasi1 = $('#lokasi1').val();
		var lokasi2 = $('#lokasi2').val();

		$.ajax({
			url : "{{ route('pembayaran_jumk.lokasiJson') }}",
			type : "POST",
			dataType: 'json',
			data : {
				jk:jk,
				ci:ci
			},
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
			},
			success : function(data){
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
		});

		$('#form-edit').submit(function(e){
			e.preventDefault();

			if ($(this).valid()) {
				$.ajax({
					url  : "{{ route('pembayaran_jumk.update') }}",
					type : "POST",
					data : $('#form-edit').serialize(),
					dataType : "JSON",
					headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
					},
					success : function(data){
						Swal.fire({
							icon  : 'success',
							title : 'Data Berhasil Diproses',
							text  : 'Berhasil',
							timer : 2000
						})
						.then(function() {
							location.href = "{{ route('pembayaran_jumk.index') }}";
						});
					}, 
					error : function(){
						alert("Terjadi kesalahan, coba lagi nanti");
					}
				});
			}
		});
		$("#bagian").on("change", function(e){
			e.preventDefault();
			var bagian = $('#bagian').val();
			var mp = $('#mp').val();
			var bulan = $('#bulan').val();
			var bulanbuku = $('#bulanbuku').val();
			$.ajax({
				url : "{{ route('pembayaran_jumk.createJson') }}",
				type : "POST",
				dataType: 'json',
				data : {
					bagian:bagian,
					mp:mp,
					bulanbuku:bulanbuku
					},
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
					},
				success : function(data){
					var tahun = bulanbuku.substr(2,2);
					var nodata = tahun+''+bulan+''+data;
					var nomor = parseInt(nodata)+parseInt(1);
					$("#nomor").val(nomor);
				},
				error : function(){
					alert("Ada kesalahan controller!");
				}
			})
		});

		$("#jk").on("change", function(){
			var jk = $('#jk').val();
			if(jk == '13'){
				$("#ci").val('2');
				$("#kurs").val('0');
				$( "#kurs" ).prop( "required", true );
				$( "#kurs" ).prop( "readonly", false );
				$('#kurs').css("background-color","#ffffff");
				$('#kurs').css("cursor","text");
				$("#jnskas").val('2');
				$("#nokas").val("");
				$("#nobukti1").val("");
				$("#nama_kas").val("");
			} else if (jk == '11'){
				$("#ci").val('1');
				$("#kurs").val('1');
				$( "#kurs" ).prop( "required", false );
				$( "#kurs" ).prop( "readonly", true );
				$('#kurs').css("background-color","#e4e6ef");
				$('#kurs').css("cursor","not-allowed");
				$("#jnskas").val('2');
				$("#nokas").val("");
				$("#nobukti1").val("");
				$("#nama_kas").val("");
			}else if (jk == '10'){
				$("#ci").val('1');
				$("#kurs").val('1');
				$( "#kurs" ).prop( "required", false );
				$( "#kurs" ).prop( "readonly", true );
				$('#kurs').css("background-color","#e4e6ef");
				$('#kurs').css("cursor","not-allowed");
				$("#jnskas").val('1');
				$("#nokas").val("");
				$("#nobukti1").val("");
				$("#nama_kas").val("");
			} else {
				$("#ci").val("");
				$("#kurs").val("");
				$( "#kurs" ).prop( "required", true );
				$( "#kurs" ).prop( "readonly", false );
				$('#kurs').css("background-color","#ffffff");
				$('#kurs').css("cursor","text");
				$("#jnskas").val("");
				$("#nokas").val("");
				$("#nobukti1").val("");
				$("#nama_kas").val("");
			}	

			var ci = $('#ci').val();

			$.ajax({
				url : "{{ route('pembayaran_jumk.lokasiJson') }}",
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
					html += '<option value="">- Pilih - </option>';
					for(i = 0; i < data.length; i++){
						html += '<option value="'+data[i].kodestore+'">'+data[i].namabank+'-'+data[i].norekening+'</option>';
					}
					$('#lokasi').html(html);		
				},
				error : function(){
					alert("Ada kesalahan controller!");
				}
			})
		});

		$("#lokasi").on("click", function(){
			$("#lokasi").on("change", function(){
				
			var lokasi = $('#lokasi').val();
			var mp = $('#mp').val();
			var tahun = $('#tahun').val();
				$.ajax({
					url : "{{ route('pembayaran_jumk.nobuktiJson') }}",
					type : "POST",
					dataType: 'json',
					data : {
						lokasi:lokasi,
						mp:mp,
						tahun:tahun
					},
					headers: {
						'X-CSRF-Token': '{{ csrf_token() }}',
					},
					success : function(data){
						var nobukti = data;
						$("#nobukti").val(nobukti);
					},
					error : function(){
						alert("Ada kesalahan controller!");
					}
				})
			});
		});

		$('#nilai').keyup(function(){
			var nilai = $('#nilai').val();
			if(nilai < '0'){
				$("#iklan").val('CR');
			}else if(nilai > '0'){
				$("#iklan").val('DR');
			} else {
				$("#iklan").val('');
			}
		});
		
		//detail
		$('#btn-create').on('click', function(e) {
			e.preventDefault();
			$('#title-detail').html("Tambah Detail Pembayaran UMK");
			$('.modal-create').modal('show');
		});

		$('#btn-delete-all').on('click', function(e) {
			e.preventDefault();
			$('#title-delete-detail').html("Hapus Detail Pembayaran UMK All");
			$('.modal-delete-all').modal('show');
		});

		//prosess create detail
		$('#form-create-detail').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url  : "{{ route('pembayaran_jumk.store.detail') }}",
				type : "POST",
				data : $('#form-create-detail').serialize(),
				dataType : "JSON",
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){ 
					console.log(data);
					if(data == 1){
						Swal.fire({
							icon  : 'success',
							title : 'Data Berhasil Ditambah',
							text  : 'Berhasil',
							timer : 2000
						}).then(function() {
							location.reload();
						});
					} else {
						Swal.fire({
							icon  : 'info',
							title : 'Duplikasi data dokumen detail, entri dibatalkan',
							text  : 'Failed',
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

		//prosess delete all detail
		$('#form-delete-all').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url  : "{{ route('pembayaran_jumk.delete.detail.all') }}",
				type : "delete",
				data : $('#form-delete-all').serialize(),
				dataType : "JSON",
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					Swal.fire({
						icon : 'success',
						title : 'Data Berhasil Dihapus',
						text : 'Berhasil',
						timer : 2000
					}).then(function() {
						location.reload();
						});
				}, 
				error : function(){
					alert("Terjadi kesalahan, coba lagi nanti");
				}
			});
		});

		//tampil edit detail
		$('#btn-edit').on('click', function(e) {
			e.preventDefault();
			var allVals = []; 
			if($('input[type=radio]').is(':checked')) {  
				$("input[type=radio]:checked").each(function() {  
					var nodok = $(this).attr('nodok').split("/").join("-");
					var nourut = $(this).attr('nourut');
					$.ajax({
						url :"{{ url('perbendaharaan/pembayaran-jumk/editdetail') }}"+ '/' +nodok+ '/' +nourut,
						type : 'get',
						dataType:"json",
						headers: {
							'X-CSRF-Token': '{{ csrf_token() }}',
						},
						success:function(data) {
							$('#nodok').val(data.docno);
							$('#nourut').val(data.lineno);
							$('#rincian').val(data.keterangan);
							$('#pk').val(data.pk);
							var d=parseFloat(data.totprice);
							var rupiah = d.toFixed(2);
							$('#nilai1').val(rupiah);
							$('#title-edit-detail').html("Edit Detail Pembayaran UMK");
							$('#select-lapangan').val(data.lokasi).trigger('change');
							$('#select-sanper').val(data.account).trigger('change');
							$('#select-bagian').val(data.bagian).trigger('change');
							$('#select-jb').val(data.jb).trigger('change');
							$('#select-cj').val(data.cj).trigger('change');
							$('.modal-edit').modal('show');
						}
					})
				});
			} else {
				swalAlertInit('ubah'); 
			}			
		});

		$('#form-edit-detail').submit(function(e) {
			e.preventDefault();

			$.ajax({
				url  : "{{ route('pembayaran_jumk.update.detail') }}",
				type : "POST",
				data : $('#form-edit-detail').serialize(),
				dataType : "JSON",
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					Swal.fire({
						icon  : 'success',
						title : 'Data Berhasil Diubah',
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
		});

		//delete
		$('#btn-delete').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) { 
				$("input[type=radio]:checked").each(function() {
					var nodok = $(this).attr('nodok');
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
								url: "{{ route('pembayaran_jumk.delete.detail') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"nodok": nodok,
									"nourut": nourut,
									"_token": "{{ csrf_token() }}",
								},
								success: function (data) {
									Swal.fire({
										icon : 'success',
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

		// minimum setup
		$('#tanggal').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'dd-mm-yyyy'
		});
		
		$('#bulanbuku').datepicker({
			todayHighlight: true,
			orientation: "bottom left",
			autoclose: true,
			language : 'id',
			format   : 'yyyymm'
		});

	});
</script>
@endpush