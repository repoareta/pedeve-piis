@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky">

    <div class="card-header">
        <div class="card-title">
             <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Pilih Jenis Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Pilih Jenis Kas/Bank
                        </div>
                    </div>
                </div>
                <form method="POST" id="form-edit">
                    @csrf
                    @method('POST')
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
                            <input type="text" class="form-control"  value="{{ $mp}}" size="1" maxlength="1" name="mp" id="mp" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                            <input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="hidden" value="{{ $nodok}}"  name="nodok" readonly>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control"  value="{{ $nomor}}" size="1" maxlength="1" name="nomor" id="nomor" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                        </div>
                    </div>

                    <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <input class="form-control" type="text" value="{{ $bulan }}"   name="bulan" id="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        <input class="form-control" type="hidden" value="{{ $data->thnbln}}"   name="bulanbuku" id="bulanbuku" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        
                    </div>
                        <div class="col-6" >
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" id="tahun" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Bagian<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="bagian" id="bagian" style="width: 100%;" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach($data_bagian as $row)
                                <option value="{{ $row->kode }}" <?php if($row->kode == $bagian ) echo 'selected'; ?>>{{ $row->kode }} - {{ $row->nama }}</option>
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
                        <div class="col-2" >
                            <input class="form-control" type="text" name="ci" value="{{ $data->ci}}" id="ci" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label">Kurs<span class="text-danger">*</span></label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="kurs" value="{{ number_format($data->rate,0) }}" id="kurs" size="7" maxlength="7" >
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
                        <div class="col-2" >
                            <input class="form-control" type="text" name="nobukti" value="{{ $data->voucher }}" id="nobukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label">No Ver</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="nover" value="{{ $data->mrs_no }}" id="nover" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        @else
                        <label class="col-1 col-form-label">No Bukti</label>
                        <div class="col-5" >
                            <input class="form-control" type="text" name="nobukti" value="{{ $data->voucher }}" id="nobukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <div class="col-1" >
                            <input class="form-control" type="hidden" name="nover" value="{{ $data->mrs_no }}" id="nover" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">
                        @if($mp == "M") Dari @else Kepada @endif<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="kepada" id="kepada" value="{{ $data->kepada }}" size="40" maxlength="40" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Sejumlah</label>
                        <div class="col-10">
                            <input class="form-control" type="text"  value="{{ number_format($count,2,'.',',') }}" size="16" maxlength="16" readonly autocomplete="off">
                            <input class="form-control" type="hidden" name="nilai" id="nilai" value="{{ number_format($count, 2, '.', '') }}" size="16" maxlength="16" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 1</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket1" id="ket1">{{ $data->ket1 }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 2</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket2" id="ket2">{{ $data->ket2}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Catatan 3</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="ket3" id="ket3">{{ $data->ket3}}</textarea>
                        </div>
                    </div>
                    @endforeach
                    <div id="button-area">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('penerimaan_kas.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-check"></i>Save</button>
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
                        <i class="fas icon-2x fa-plus-circle text-success"></i>
                    </span>
                </button>
                <button class="btn p-0" id="btn-edit">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah Data">
                        <i class="fas icon-2x fa-edit text-warning"></i>
                    </span>
                </button>
                <button class="btn p-0" id="btn-delete">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus Data">
                        <i class="fas icon-2x fa-times text-danger"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <table class="table table-bordered table-checkable" id="tabel-detail-permintaan">
            <thead class="thead-light">
                <tr>
                    <th ><input type="radio" hidden name="btn-radio"  data-id="1" class="btn-radio" checked ></th>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Sanper</th>
                    <th>Bagian</th>
                    <th>PK</th>
                    <th>JB</th>
                    <th>Jumlah</th>
                    <th>CJ</th>	
                </tr>
            </thead>
            <tbody>
                <?php $no=0; ?>
                @foreach($data_detail as $data_d)
                <?php $no++; ?>
                <tr class="table-info">
                    <td scope="row" align="center"><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="btn-radio" nodok="{{ $data_d->docno}}" nourut="{{ $data_d->lineno}}"  class="btn-radio"><span></span></label></td>
                    <td scope="row" align="center">{{ $data_d->lineno}}</td>
                    <td>{{ $data_d->keterangan}}</td>
                    <td align="center">{{ $data_d->account}}</td>
                    <td align="center">{{ $data_d->bagian}}</td>
                    <td align="center">{{ $data_d->pk}}</td>
                    <td align="center">{{ $data_d->jb}}</td>
                    <td align="center">{{ $data_d->cj}}</td>
                    <td align="right">{{ number_format($data_d->totprice,2,'.',',') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="8" class="text-right">Jumlah Total : </td>
                <td class="text-right"><?php 
                    if ($count <> "") {
                        echo number_format($count, 2, '.', ',');
                    } else {
                        echo '0.00';
                    }
                ?></td>
            </tr>
        </table>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
$(document).ready(function () {
		var t = $('#tabel-detail-permintaan').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: false,
		});
		$('#tabel-detail-permintaan tbody').on( 'click', 'tr', function (event) {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			} else {
				t.$('tr.selected').removeClass('selected');	
				if (event.target.type !== 'radio') {
					$(':radio', this).trigger('click');
				}
				$(this).addClass('selected');
			}
		} );
		$('.cariaccount').select2({
			placeholder: '-Pilih-',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.search.account') }}",
				type : "get",
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				delay: 250,
			processResults: function (data) {
				return {
				results:  $.map(data, function (item) {
					return {
					text: item.kodeacct +'--'+ item.descacct,
					id: item.kodeacct
					}
				})
				};
			},
			cache: true
			}
		});
		$('.caribagian').select2({
			placeholder: '-Pilih-',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.search.bagian') }}",
				type : "get",
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				delay: 250,
			processResults: function (data) {
				return {
				results:  $.map(data, function (item) {
					return {
					text: item.kode +'--'+ item.nama,
					id: item.kode
					}
				})
				};
			},
			cache: true
			}
		});
		$('.carijb').select2({
			placeholder: '-Pilih-',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.search.jb') }}",
				type : "get",
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				delay: 250,
			processResults: function (data) {
				return {
				results:  $.map(data, function (item) {
					return {
					text: item.kode +'--'+ item.keterangan,
					id: item.kode
					}
				})
				};
			},
			cache: true
			}
		});
		$('.caricj').select2({
			placeholder: '-Pilih-',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.search.cj') }}",
				type : "get",
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				delay: 250,
			processResults: function (data) {
				return {
				results:  $.map(data, function (item) {
					return {
					text: item.kode +'--'+ item.nama,
					id: item.kode
					}
				})
				};
			},
			cache: true
			}
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
		$('#kurs').css("background-color","#DCDCDC");
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
		$('#kurs').css("background-color","#DCDCDC");
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
	url : "{{route('penerimaan_kas.ajax-lokasi') }}",
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
})
$('#form-edit').submit(function(){
	$.ajax({
		url  : "{{route('penerimaan_kas.update', request()->documentId) }}",
		type : "POST",
		data : $('#form-edit').serialize(),
		dataType : "JSON",
		headers: {
		'X-CSRF-Token': '{{ csrf_token() }}',
		},
		success : function(data){
		console.log(data);
		Swal.fire({
			icon  : 'success',
			title : 'Data Berhasil Diproses',
			text  : 'Berhasil',
			timer : 2000
		}).then(function() {
				window.location.replace("{{ route('penerimaan_kas.index') }}");;
			});
		}, 
		error : function(){
			alert("Terjadi kesalahan, coba lagi nanti");
		}
	});	
	return false;
});
$("#bagian").on("change", function(e){
	e.preventDefault();
var bagian = $('#bagian').val();
var mp = $('#mp').val();
var bulan = $('#bulan').val();
var bulanbuku = $('#bulanbuku').val();
	$.ajax({
		url : "{{route('penerimaan_kas.ajax-create') }}",
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
		$('#kurs').css("background-color","#DCDCDC");
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
		$('#kurs').css("background-color","#DCDCDC");
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
		url : "{{route('penerimaan_kas.ajax-lokasi') }}",
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
$("#lokasi").on("click", function(){
	$("#lokasi").on("change", function(){
		
	var lokasi = $('#lokasi').val();
	var mp = $('#mp').val();
	var tahun = $('#tahun').val();
		$.ajax({
			url : "{{route('penerimaan_kas.ajax-bukti') }}",
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
	$('#title-detail').html("Tambah Detail Perbendaharaan - Kas/Bank");
	$('.modal-create').modal('show');
});
//prosess create detail
$('#form-create-detail').submit(function(){
		$.ajax({
			url  : "{{ route('penerimaan_kas.store.detail', [request()->documentId], [request()->documentId]) }}",
			type : "POST",
			data : $('#form-create-detail').serialize(),
			dataType : "JSON",
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
			success : function(data){
				Swal.fire({
					icon  : 'success',
					title : 'Data Berhasil Ditambah',
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
//tampil edit detail
$('#btn-edit').on('click', function(e) {
	e.preventDefault();
var allVals = []; 
if($('input[type=radio]').is(':checked')) {  
	$("input[type=radio]:checked").each(function() {  
		var nodok = $(this).attr('nodok').split("/").join("-");
		var nourut = $(this).attr('nourut');
			$.ajax({
				url :"{{url('perbendaharaan/penerimaan_kas/editdetail') }}"+ '/' +nodok+ '/' +nourut,
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
					$('#title-edit-detail').html("Edit Detail Perbendaharaan - Kas/Bank");
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
$('#form-edit-detail').submit(function(){
		$.ajax({
			url  : "{{route('penerimaan_kas.store.detail', [request()->documentId]) }}",
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
		return false;
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
    var KTBootstrapDatepicker = function () {
var arrows;
if (KTUtil.isRTL()) {
	arrows = {
		leftArrow: '<i class="la la-angle-right"></i>',
		rightArrow: '<i class="la la-angle-left"></i>'
	}
} else {
	arrows = {
		leftArrow: '<i class="la la-angle-left"></i>',
		rightArrow: '<i class="la la-angle-right"></i>'
	}
}
// Private functions
var demos = function () {
	// minimum setup
	$('#tanggal').datepicker({
		rtl: KTUtil.isRTL(),
		todayHighlight: true,
		orientation: "bottom left",
		templates: arrows,
		autoclose: true,
		language : 'id',
		format   : 'yyyy-mm-dd'
	});
	
	$('#bulanbuku').datepicker({
		rtl: KTUtil.isRTL(),
		todayHighlight: true,
		orientation: "bottom left",
		templates: arrows,
		autoclose: true,
		language : 'id',
		format   : 'yyyymm'
	});
};
return {
	// public functions
	init: function() {
		demos(); 
	}
};
}();
KTBootstrapDatepicker.init();
});
</script>
@endpush