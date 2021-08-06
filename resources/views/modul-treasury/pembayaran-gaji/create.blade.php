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
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Pembayaran Gaji
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" id="form-create">
            @csrf
            <div class="portlet__body">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            <h5 class="portlet__head-title">
                                Header Pembayaran Gaji
                            </h5>	
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No.Dokumen</label>
                        <div class="col-10">
                            <input type="hidden" class="form-control"  value="{{date('Y-m-d') }}" size="1" maxlength="1" name="tanggal" id="tanggal" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                            <input type="text" class="form-control"  value="{{ $mp}}" size="1" maxlength="1" name="mp" id="mp" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                        </div>
                    </div>

                    <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <input class="form-control" type="text" value="{{ $bulan }}" name="bulan" id="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{ $bulan_buku}}" name="bulanbuku" id="bulanbuku" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        
                    </div>
                        <div class="col-6" >
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" id="tahun" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Bagian<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="bagian" id="bagian" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach($data_bagian as $data)
                                <option value="{{ $data->kode }}">{{ $data->kode }} - {{ $data->nama }}</option>
                                @endforeach
                                
                            </select>
                                <input class="form-control" type="hidden" value=""  name="nomor" id="nomor" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jenis Kartu<span class="text-danger">*</span></label>
                        <div class="col-3">
                            <select name="jk" id="jk" class="form-control select2">
                                <option value="">- Pilih -</option>
                                <option value="10">Kas(Rupiah)</option>
                                <option value="11">Bank(Rupiah)</option>
                                <option value="13">Bank(Dollar)</option>
                                
                            </select>							</div>
                        <label class="col-2 col-form-label">Currency Index</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="ci" value="" id="ci" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label">Kurs<span class="text-danger">*</span></label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="kurs" value="" id="kurs" size="7" maxlength="7" >
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Lokasi<span class="text-danger">*</span></label>
                        <div class="col-4">
                            <select name="lokasi" id="lokasi" class="form-control select2">
                                <option value="">- Pilih -</option>
                                
                            </select>
                        </div>
                        <label class="col-1 col-form-label">No Bukti</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="nobukti" value="" id="nobukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label">No Ver</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="nover" value="{{ $nover}}" id="nover" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">
                        @if($mp == "M") {{ $darkep}} @else {{ $darkep}} @endif<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select class="kepada form-control" style="width: 100% !important;" name="kepada" ></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Sejumlah</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nilai" id="nilai" value="0" size="16" maxlength="16" autocomplete="off" readonly>
                            <input class="form-control" type="hidden" name="iklan" value="" id="iklan" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 1</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket1" id="ket1"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 2</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket2" id="ket2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 3</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket3" id="ket3"></textarea>
                        </div>
                    </div>
                    <div class="form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('pembayaran_gaji.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
		
		
		$("#jk").on("change", function(){ 
		var ci = $(this).val();
		console.log(ci);
		if(ci != 13)
		{
			$('#kurs').val(1);
			$('#simbol-kurs').hide();
			$( "#kurs" ).prop( "required", false );
			$( "#kurs" ).prop( "readonly", true );
			$('#kurs').css("background-color","#DCDCDC");
			$('#kurs').css("cursor","not-allowed");
		} else {
			var kurs1 = $('#data-kurs').val();
			$('#kurs').val(kurs1);
			$('#simbol-kurs').show();
			$( "#kurs" ).prop( "required", true );
			$( "#kurs" ).prop( "readonly", false );
			$('#kurs').css("background-color","#ffffff");
			$('#kurs').css("cursor","text");
		}
			
	});
$('#form-create').submit(function(){
	var mp = $("#mp").val();
	var bagian = $("#bagian").val();
	var nomor = $("#nomor").val();
	var scurrdoc = mp+'-'+bagian+'-'+nomor;
	$.ajax({
		url  : "{{ route('pembayaran_gaji.store') }}",
		type : "POST",
		data : $('#form-create').serialize(),
		dataType : "JSON",
		headers: {
		'X-CSRF-Token': '{{ csrf_token() }}',
		},
		success : function(data){
		console.log(data);
		if(data == 1){
			Swal.fire({
				type  : 'success',
				title : 'Data Berhasil Ditambah',
				text  : 'Berhasil',
				timer : 2000
			}).then(function() {
                location.href = "{{ url('perbendaharaan/pembayaran-gaji/edit') }}"+ '/' +scurrdoc;
            });
		}else if(data = 2){
			Swal.fire({
				type  : 'info',
				title : 'Bulan Buku Tidak Ada Atau Sudah Di Posting.',
				text  : 'Failed',
			});
		} else {
			Swal.fire({
				type  : 'info',
				title : 'Data Yang Diinput Sudah Ada.',
				text  : 'Failed',
			});
		}
		}, 
		error : function(){
			alert("Terjadi kesalahan, coba lagi nanti");
		}
	});	
	return false;
});
$("#bagian").on("change", function(){
var bagian = $('#bagian').val();
var mp = $('#mp').val();
var bulan = $('#bulan').val();
var bulanbuku = $('#bulanbuku').val();
	$.ajax({
		url : "{{ route('pembayaran_gaji.createJson') }}",
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
		$("#jnskas").val('2');
		$("#nokas").val("");
		$("#nobukti1").val("");
		$("#nama_kas").val("");
	} else if (jk == '11'){
		$("#ci").val('1');
		$("#kurs").val('1');
		$("#jnskas").val('2');
		$("#nokas").val("");
		$("#nobukti1").val("");
		$("#nama_kas").val("");
	}else if (jk == '10'){
		$("#ci").val('1');
		$("#kurs").val('1');
		$("#jnskas").val('1');
		$("#nokas").val("");
		$("#nobukti1").val("");
		$("#nama_kas").val("");
	} else {
		$("#ci").val("");
		$("#kurs").val("");
		$("#jnskas").val("");
		$("#nokas").val("");
		$("#nobukti1").val("");
		$("#nama_kas").val("");
	}	
	var ci = $('#ci').val();
	$.ajax({
		url : "{{ route('pembayaran_gaji.lokasiJson') }}",
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
						html += '<option value="">- Pilih - </option>';
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
$("#lokasi").on("change", function(){
var lokasi = $('#lokasi').val();
var mp = $('#mp').val();
var tahun = $('#tahun').val();
	$.ajax({
		url : "{{ route('pembayaran_gaji.nobuktiJson') }}",
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
	$('.kepada').select2({
		placeholder: '-Pilih-',
		allowClear: true,
		tags: true,
		ajax: {
			url: "{{ route('penerimaan_kas.ajax-kepada') }}",
			type : "post",
			dataType : "JSON",
			headers: {
			'X-CSRF-Token': '{{ csrf_token() }}',
			},
			delay: 250,
		processResults: function (data) {
			console.log(data.length);
			return {
			results:  $.map(data, function (item) {
				return {
				text: item.kepada,
				id: item.kepada
				}
			})
			};
		},
		cache: true
		}
	});
});
		var nilai = document.getElementById('nilai');
		nilai.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatnilai() untuk mengubah angka yang di ketik menjadi format angka
			nilai.value = formatRupiah(this.value, '');
		});
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			nilai     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				nilai += separator + ribuan.join('.');
			}
			nilai = split[1] != undefined ? nilai + ',' + split[1] : nilai;
			$a= prefix == undefined ? nilai : (nilai ? nilai: '');
         return $a;
		}
</script>
@endpush