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
                Edit Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{ route('modul_umum.uang_muka_kerja.store') }}" method="post" id="form-edit">
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
                    <input class="form-control" type="hidden" value="{{ str_replace('/', '-', $noumk) }}" id="noumk"  size="25" maxlength="25" readonly>
                    <input class="form-control disabled bg-secondary" type="text" value="{{$noumk}}" name="no_umk" size="25" maxlength="25" readonly required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nopek-input" class="col-2 col-form-label">Tanggal <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" name="tgl_panjar" value="{{ date('d-m-Y', strtotime($data_umk->tgl_panjar)) }}" id="datepicker" id="tgl_panjar" size="15" maxlength="15" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis-dinas-input" class="col-2 col-form-label">Dibayar Kepada <span class="text-danger">*</span></label>
                <div class="col-10">
                    <select name="kepada" id="kepada" class="form-control selectpicker" data-live-search="true" required>
                        <option value="">- Pilih -</option>
                        @foreach ($vendor as $row)
                        <option value="{{ $row->nama }}" {{ $data_umk->kepada == $row->nama ? 'selected' : null }}>{{ $row->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-email-input" class="col-2 col-form-label">Jenis Uang Muka <span class="text-danger">*</span></label>
                <div class="col-6">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="K" type="radio" name="jenis_um" {{ $data_umk->jenis_um == "K" ? 'checked' : null }}>
                            <span></span> Uang Muka Kerja
                        </label>
                        <label class="radio">
                            <input value="D" type="radio" name="jenis_um" {{ $data_umk->jenis_um == "K" ? null : 'checked' }}>
                            <span></span> Uang Muka Dinas
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="id-pekerja;-input" class="col-2 col-form-label">Bulan Buku <span class="text-danger">*</span></label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary" type="text"  value="{{ $data_umk->bulan_buku }}"  name="bulan_buku" size="6" maxlength="6">
                </div>
            </div>
            <div class="form-group row">
                <label for="dari-input" class="col-2 col-form-label">Mata Uang <span class="text-danger">*</span></label>
                <div class="col-10">
                    <div class="radio-inline">
                        <label class="radio">
                            <input value="1" type="radio" name="ci" onclick="displayResult(1)" {{ $data_umk->ci == "1" ? 'checked' : null }}>
                            <span></span> IDR
                        </label>
                        <label class="radio">
                            <input value="2" type="radio" name="ci" onclick="displayResult(2)" {{ $data_umk->ci == "1" ? null : 'checked'}}>
                            <span></span> USD
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="tujuan-input" class="col-2 col-form-label">Kurs  <span class="text-danger d-none" id="simbol-kurs">*</span></label>
                <div class="col-10">
                    <input class="form-control" type="text" value="{{ number_format($data_umk->rate, 0, '', '') }}" name="rate" id="kurs" readonly  size="10" maxlength="10" autocomplete='off'>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-2 col-form-label">Untuk <span class="text-danger">*</span></label>
                <div class="col-10">
                    <textarea  class="form-control" type="text" value="" name="keterangan" id="keterangan" size="70" maxlength="200">{{ $data_umk->keterangan }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-2 col-form-label">Jumlah</label>
                <div class="col-10">
                    <input class="form-control disabled bg-secondary" type="text" value="Rp. {{ currency_format($data_umk->jumlah) }}" readonly>
                    <input class="form-control" type="hidden" value="{{ number_format($data_umk->jumlah, 0, '', '') }}" name="jumlah" id="jumlah" size="70" maxlength="200" readonly>
                </div>
            </div>
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a  href="{{route('modul_umum.uang_muka_kerja.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
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
                Detail Uang Muka Kerja
            </h3>
        </div>

        <div class="card-toolbar">
            <div class="float-left">
                <a href="#" data-target="modal-create-detail-umk">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success" id="btn-create-detail"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="btn-edit-detail"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
            </div>
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
            <?php $no = 0; ?>
            @foreach($data_umk_details as $data_umk_detail)
                <?php $no++; ?>
                <tr>
                    <td scope="row" align="center"><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" name="btn-radio" data-no="{{$data_umk_detail->no}}"  data-id="{{str_replace('/', '-', $data_umk_detail->no_umk)}}" noumk="{{$data_umk_detail->no_umk}}" class="btn-radio" ><span></span></label></td>
                    <td scope="row" align="center">{{$no}}</td>
                    <td>{{$data_umk_detail->keterangan}}</td>
                    <td align="center">{{$data_umk_detail->account}}</td>
                    <td align="center">{{$data_umk_detail->bagian}}</td>
                    <td align="center">{{$data_umk_detail->pk}}</td>
                    <td align="center">{{$data_umk_detail->jb}}</td>
                    <td align="center">{{$data_umk_detail->cj}}</td>
                    <td><?php echo number_format($data_umk_detail->nilai, 2, '.', ','); ?></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!--begin::Modal creaate--> 
<div class="modal fade modal-create-detail-umk" id="modal-create-detail-umk"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail"></h5>
			</div>
			<div class="modal-body">
			<span id="form_result"></span>
                <form  class="kt-form " id="form-tambah-umk-detail"  enctype="multipart/form-data">
					@csrf
                    <input  class="form-control" hidden type="text" value="{{ $data_umk->no_umk }}" name="no_umk">
                    <div class="form-group row ">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut<span class="text-danger">*</span></label>
						<div class="col-8">
							<input class="form-control disabled bg-secondary" type="text" value="{{$no_umk_details}}" name="no">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan<span class="text-danger">*</span></label>
						<div class="col-8">
							<textarea  class="form-control" type="text" value="" id="keterangan-create" name="keterangan" required>-</textarea>
						</div>
					</div>
                    		
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div  class="col-8" >
							<select class="cariaccount form-control select2" style="width: 100% !important;" name="acc">
                                <option value="">-Pilih-</option>
                                @foreach($data_account as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-8">
							<select class="caribagian form-control select2" style="width: 100% !important;" name="bagian">
                                <option value="">-Pilih-</option>
                                @foreach($data_bagian as $row)
								<option value="{{ $row->kode }}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="000"  name="pk" size="6" maxlength="6" autocomplete='off'>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-8">
							<select class="carijb form-control select2" style="width: 100% !important;" name="jb">
                                <option value="">-Pilih-</option>
                                @foreach($data_jenisbiaya as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-8">
							<select class="caricj form-control select2" style="width: 100% !important;" name="cj">
                                <option value="">-Pilih-</option>
                                @foreach($data_cj as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
                            </select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah <span class="text-danger">*</span></label>
						<div class="col-8">
							<input class="form-control" type="text" value="" name="nilai" required oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete='off'>
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

<!--begin::Modal edit--> 
<div class="modal fade modal-edit-detail-umk" id="modal-edit-detail-umk"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Edit Detail Uang Muka Kerja</h5>
			</div>
			<div class="modal-body">
			<span id="form_result"></span>
                <form  class="kt-form " id="form-edit-tambah-umk-detail"  enctype="multipart/form-data">
					{{csrf_field()}}
                    <input  class="form-control" hidden type="text" value="{{$data_umk->no_umk}}"  name="no_umk">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-8">
							<input class="form-control disabled bg-secondary" type="text" id="no-edit" name="no">
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Keterangan</label>
						<div class="col-8">
							<textarea  class="form-control" type="text" value="" id="keterangan-edit" name="keterangan"></textarea>
						</div>
					</div>
									
																					
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Account</label>
						<div id="div-acc" class="col-8">
							<select name="acc" id="select-acc" class="cariaccount form-control" style="width: 100% !important;">
								<option value="">-Pilih-</option>
                                @foreach($data_account as $row)
								<option value="{{$row->kodeacct}}">{{$row->kodeacct}} - {{$row->descacct}}</option>
                                @endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div id="div-bagian" class="col-8">
							<select name="bagian" id="select-bagian"  class="caribagian form-control kt-select2" style="width: 100% !important;">
								<option value="">-Pilih-</option>
                                @foreach($data_bagian as $row)
								<option value="{{$row->kode}}" <?php if( '<input value="$row->kode">' == '<input id="bagian">' ) echo 'selected' ; ?>>{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="000" id="pk" name="pk" size="6" maxlength="6" autocomplete='off'>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div id="div-jb" class="col-8">
							<select name="jb" id="select-jb"  class="carijb form-control kt-select2" style="width: 100% !important;">
								<option value="">-Pilih-</option>
                                @foreach($data_jenisbiaya as $row)
								<option value="{{$row->kode}}" >{{$row->kode}} - {{$row->keterangan}}</option>
                                @endforeach
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<div class="col-8" id="div-cj">
							<select name="cj" id="select-cj" class="caricj form-control kt-select2" style="width: 100% !important;">
								<option value="">-Pilih-</option>
                                @foreach($data_cj as $row)
								<option value="{{$row->kode}}">{{$row->kode}} - {{$row->nama}}</option>
                                @endforeach
							</select>
						</div>
					</div>
                    
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah</label>
						<div class="col-8">
							<input  class="form-control" type="text" value="" name="nilai" id="nilai" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete='off'>
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
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\UMKStoreRequest', '#form-edit'); !!}

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
	});
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
	// minimum setup
	$('#datepicker').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		// language : 'id',
		format   : 'dd-mm-yyyy'
	});
	// minimum setup
	$('#bulan_buku').datepicker({
		todayHighlight: true,
		orientation: "bottom left",
		autoclose: true,
		// language : 'id',
		format   : 'yyyymm'
	});

    $('#btn-create-detail').on('click', function(e) {
		e.preventDefault();
		$('#title-detail').html("Tambah Detail Uang Muka Kerja");
		$('.modal-create-detail-umk').modal('show');
	});

    //create detail
    $('#form-tambah-umk-detail').submit(function(){
		$.ajax({
			url  : "{{route('modul_umum.uang_muka_kerja.store.detail')}}",
			type : "POST",
			data : $('#form-tambah-umk-detail').serialize(),
			dataType : "JSON",
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
			success : function(data){
                Swal.fire({
					icon  : 'success',
					title : 'Data Detail UMK Berhasil Ditambah',
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
    //proses update detail
    $('#form-edit-tambah-umk-detail').submit(function(){
		$.ajax({
			url  : "{{route('modul_umum.uang_muka_kerja.store.detail')}}",
			type : "POST",
			data : $('#form-edit-tambah-umk-detail').serialize(),
			dataType : "JSON",
            headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
            },
			success : function(data){
                Swal.fire({
					icon  : 'success',
					title : 'Data Detail UMK Berhasil Diubah',
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
$('#btn-edit-detail').on('click', function(e) {
	e.preventDefault();
var allVals = [];  
$(".btn-radio:checked").each(function() {  
	var dataid = $(this).attr('data-id');
	var datano = $(this).attr('data-no');
	if(dataid == 1)  
	{  
		swalAlertInit('ubah');  
	}  else { 
		$.ajax({
			url :"{{url('umum/uang-muka-kerja/edit-detail')}}"+ '/' + dataid + '/' + datano,
			type : 'get',
			dataType:"json",
			headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
			success:function(data)
			{
				$('#no-edit').val(data.no);
				$('#keterangan-edit').val(data.keterangan);
				$('#pk').val(data.pk);
				var d=parseFloat(data.nilai);
				var rupiah = d.toFixed(2);
				$('#nilai').val(rupiah);
				$('#title-detail').html("Edit Detail Uang Muka Kerja");
				$('.modal-edit-detail-umk').modal('show');
				$('#select-bagian').val(data.bagian).trigger('change');
				$('#select-acc').val(data.account).trigger('change');
				$('#select-jb').val(data.jb).trigger('change');
				$('#select-cj').val(data.cj).trigger('change');
			}
		})
	}
				
});
});

        $('#deleteRow').click(function(e) {
			e.preventDefault();
			$(".btn-radio:checked").each(function() {  
			var dataid = $(this).attr('data-id');
				if(dataid == 1)  
				{  
					swalAlertInit('hapus'); 
				}  else { 
				$("input[type=radio]:checked").each(function() {
					var id = $(this).attr('noumk');
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
							text: "No. UMK : " + id+" dan NO urut : "+no,
							icon: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_umum.uang_muka_kerja.delete.detail') }}",
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
										title : 'Hapus Data Detail UMK',
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
	//create
    $('#form-edit').submit(function(e){
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
</script>
@endpush