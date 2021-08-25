@extends('layouts.app')

@push('page-styles')

@endpush

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Verifikasi Kas Bank
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3 alert alert-secondary">
                <div id="treeview" class="tree-demo">
                    <ul>
                        @foreach ($data_rsjurnal as $data_rsj)
                        <li>
                            {{ $data_rsj->store }}
                            <ul>
                                @foreach (DB::table('kasdoc')->where('store',$data_rsj->store)->where('paid', 'Y')->where('verified','N')->orderBy('docno', 'asc')->get() as $data_doc)
                                <li data-jstree='{ "type" : "file" @if(str_replace('/', '-',$data_doc->docno) == Request::segment(4)) , "selected": true @endif  }'>
                                    <a href="{{ route('modul_kontroler.postingan_kas_bank.verkas',['no' => str_replace('/', '-',$data_doc->docno),'id' =>$data_doc->verified])}}">
                                        {{ $data_doc->docno }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <form class="form" id="form-create">
                    @csrf
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Verifikasi Kas Bank
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No</label>
                        <div class="col-2">
                            <input class="form-control" type="hidden" name="tanggal" value="{{ date('Y-m-d') }}" disabled="disabled">
                            <input class="form-control" type="text" name="mp" id="mp1" value="{{ $mp }}" disabled="disabled">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="text" name="nomor" id="nomor1" value="{{ $nomor }}" disabled="disabled">
                        </div>
                        <label for="" class="col-2 col-form-label">Sejumlah</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="nilai" value="{{ $nilai }}" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Kode Bagian</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="bagian" id="bagian1" value="{{ $bagian }}" disabled="disabled">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="text" name="nama_bagian" value="{{ $nama_bagian }}" disabled="disabled">
                        </div>
                        <label for="" class="col-2 col-form-label">Kurs</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="kurs" value="{{ $kurs }}" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Jenis Kartu</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="jk" value="{{ $jk }}" disabled="disabled">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="text" name="namajk" value="{{ $namajk }}" disabled="disabled">
                        </div>
                        <label for="" class="col-2 col-form-label">Currency</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="ci" value="{{ $namaci }}" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Bulan/Tahun</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="bulan" value="{{ $bulan }}" disabled="disabled">
                        </div>
                        <div class="col-2">
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" disabled="disabled">
                        </div>
                        <label for="" class="col-1 col-form-label">No Kas</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="nokas" value="{{ $nokas }}" disabled="disabled">
                        </div>
                        <div class="col-3">
                            <input class="form-control" type="text" name="namakas" value="{{ $nama_kas }}" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">{{ $darkep }}</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="kepada" value="{{ $kepada }}" disabled="disabled">
                        </div>
                        <label for="" class="col-2 col-form-label">Bo.Bukti</label>
                        <div class="col-3">
                            <input class="form-control" type="text" name="nobukti" value="{{ $nobukti }}" disabled="disabled">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ route('modul_kontroler.postingan_kas_bank.index') }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                        </div>
                    </div>
                        
                    <div class="mt-10">
                        <div class="kt-portlet__head-label">
                            <h5>
                                Tabel Detail Kas Bank
                            </h5>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                    @foreach(DB::table('usermenu')->where('userid',Auth::user()->userid)->where('menuid',202)->limit(1)->get() as $data_akses)
                                    @if($docno<>"")
                                        @if($data_akses->tambah == 1)
                                        <a href="#" data-toggle="modal" data-target="#kt_modal_4">
                                            <span style="font-size: 2em;" class="kt-font-success">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                        </a>
                                        @endif

                                        @if($data_akses->rubah == 1)					
                                        <a href="#" id="editRow">
                                            <span style="font-size: 2em;" class="kt-font-warning">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>
                                        @endif

                                    @endif
                                        @if($verified == "N")
                                            @if($data_akses->hapus == 1)
                                            <a href="#" id="deleteRow">
                                                <span style="font-size: 2em;" class="kt-font-danger">
                                                    <i class="fas fa-times-circle"></i>
                                                </span>
                                            </a>
                                            @endif
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <table class="table table-bordered" id="kt_table">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>NO</th>
                                    <th>RINCIAN</th>	
                                    <th>KL</th>
                                    <th>SANPER</th>
                                    <th>BAGIAN</th>
                                    <th>PK</th>
                                    <th>JB</th>
                                    <th>JUMLAH</th>
                                    <th>CJ</th>	
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data_detail as $data_d)
                                <tr>
                                    <td class="text-center"><label class="radio"><input type="radio" name="btn-radio" docno="{{str_replace('/', '-', $data_d->docno)}}" lineno="{{ $data_d->lineno }}" class="btn-radio"><span></span></label></td>
                                    <td>{{ $data_d->lineno }}</td>
                                    <td>{{ $data_d->keterangan }}</td>
                                    <td>{{ $data_d->lokasi }}</td>
                                    <td>{{ $data_d->account }}</td>
                                    <td>{{ $data_d->bagian }}</td>
                                    <td>{{ $data_d->pk }}</td>
                                    <td>{{ $data_d->jb }}</td>
                                    <td>{{ number_format($data_d->totprice,2,'.',',') }}</td>
                                    <td>{{ $data_d->cj }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                @if($docno<>"")
                                <td colspan="2" align="left">
                                    @if($status1 == 'Y')
                                    <input id="status1" name="status1" value="N"  type="checkbox" <?php if($status1  == 'Y' ) echo 'checked' ; ?> > Verifikasi
                                    @else
                                    <input id="status1" name="status1" value="Y"  type="checkbox"> Verifikasi
                                    @endif
                                </td>
                                <td colspan="6" align="right">Jumlah Total : </td>
                                <td colspan="2"><?php echo number_format($jumlahnya, 2, ',', '.'); ?></td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--begin::Modal Edit-->
<!--end::Modal-->
<div class="modal fade modal-edit-detail" id="kt_modal_4"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title-detail">Edit Menu Detail Kas/Bank</h5>
			</div>
			<div class="modal-body">
			<span id="form_result"></span>
			<form class="kt-form " id="form-edit-detail"  enctype="multipart/form-data">
			@csrf
				<input class="form-control" hidden type="text" value="{{ $docno }}"  name="kode">
                    <div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">No. Urut</label>
						<div class="col-8">
							<input class="form-control" type="text" value="{{ $nu }}"  name="nourut" id="nourut" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Rincian</label>
						<div class="col-8">
							<input class="form-control" type="text" value="-"  size="35" maxlength="35" name="rincian" id="rincian" autocomplete="off">
						</div>
					</div>	
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Sandi Perkiraan</label>
						<div  class="col-8">
							<select name="sanper" id="sanper" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_sandi as $data_san)
								<option value="{{ $data_san->kodeacct }}">{{ $data_san->kodeacct }} - {{ $data_san->descacct }}</option>
									@endforeach
							</select>
						</div>
					</div>			
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<div  class="col-8">
							<select name="bagian" id="bagian" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_bagian as $data_bag)
								<option value="{{ $data_bag->kode }}">{{ $data_bag->kode }} - {{ $data_bag->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>		
					@if($mp == "P")
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<div class="col-8">
							<input class="form-control" type="text" value="000000" size="6" maxlength="6" name="wo" id="wo">
						</div>
					</div>	
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-8">
							<select name="jnsbiaya" id="jnsbiaya" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah</label>
						<div class="col-8">
							<input class="form-control" type="text" value="" name="jumlah" id="jumlah" size="16" maxlength="16" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C.Judex</label>
						<div  class="col-8">
							<select name="cjudex"  id="cjudex" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_cjudex as $data_judex)
								<option value="{{ $data_judex->kode }}">{{ $data_judex->kode }} - {{ $data_judex->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>	
					@else
					<input class="form-control" type="hidden"  size="6" maxlength="6" name="wo" id="wo">
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<div  class="col-8">
							<select name="jnsbiaya" id="jnsbiaya" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan }}</option>
									@endforeach
							</select>
						</div>
					</div>		

					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah</label>
						<div class="col-8">
							<input class="form-control" type="text" value="" name="jumlah" id="jumlah" size="16" maxlength="16" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete="off">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C.Judex</label>
						<div  class="col-8">
							<select name="cjudex"  id="cjudex" class="form-control selectpicker" data-live-search="true">
								<option value="">-Pilih-</option>
									@foreach($data_cjudex as $data_judex)
								<option value="{{ $data_judex->kode }}">{{ $data_judex->kode }} - {{ $data_judex->nama }}</option>
									@endforeach
							</select>
						</div>
					</div>	
					@endif												
					<div class="kt-form__actions">
						<div class="row">
							<div class="col-2"></div>
							<div class="col-10">
								<button type="reset"  class="btn btn-warning"  data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</button>
								@if($verified == "N")
								<button type="submit" name="update" value="update" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i>Save</button>
								@endif
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
<script src="{{ asset('assets/plugins/custom/jstree/jstree.bundle.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#kt_table').DataTable();

        $("#treeview").jstree({
            "core": {
                "themes": {
                    "responsive": true
                }
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder"
                },
                "file": {
                    "icon": "fa fa-file"
                }
            },
            "plugins": ["types"]
        });

        $("#treeview li").on("click", "a", 
            function() {
                document.location.href = this;
            }
        );

		//verifikasi
		$("#status1").on("change", function(){
            var bagian = $("#bagian1").val();
            var mp = $("#mp1").val();
            var nomor = $("#nomor1").val();
            var tanggal = $("#tanggal").val();
            var status1 = $("#status1").val();
			$.ajax({
				url  : "{{ route('modul_kontroler.postingan_kas_bank.verifikasi') }}",
				type : "POST",
				data: {
						"bagian": bagian,
						"mp": mp,
						"nomor": nomor,
						"tanggal": tanggal,
						"status1": status1,
						"_token": "{{ csrf_token() }}",
					},
				dataType : "JSON",
				success : function(data){
					if(data == 1){
						Swal.fire({
							icon  : 'success',
							title : 'Data Berhasil Diverifikasi',
							text  : 'Berhasil',
							timer : 2000
						}).then(function() {
							location.reload();
						});
					}else if(data == 2){
						Swal.fire({
							type  : 'info',
							title : 'Data Sudah Di Posting, Tidak Bisa Di Tambah/Update/Hapus.',
							text  : 'Info',
							timer : 2000
							}).then(function() {
								location.reload();
							});
					}else{
						Swal.fire({
							icon  : 'success',
							title : 'Verifikasi Berhasil Dibatalkan.',
							text  : 'Berhasil',
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

		//prosess create detail
		$('#form-tambah-detail').submit(function(){
			$.ajax({
				url  : "{{ route('modul_kontroler.postingan_kas_bank.store.detail') }}",
				type : "POST",
				data : $('#form-tambah-detail').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					if(data == 1){
						Swal.fire({
							icon  : 'success',
							title : 'Data Detail Berhasil Ditambah',
							text  : 'Berhasil',
							timer : 2000
						}).then(function() {
							location.reload();
						});
					}else{
						Swal.fire({
							type  : 'info',
							title : 'Data Sudah Di Posting, Tidak Bisa Di Tambah/Update/Hapus.',
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
						url :"{{ url('kontroler/postingan_kas_bank/editdetail') }}"+'/'+no+'/'+id,
						type : 'get',
						dataType:"json",
						headers: {
							'X-CSRF-Token': '{{ csrf_token() }}',
							},
						success:function(data)
						{
							$('#nourut').val(data.lineno);
							$('#rincian').val(data.keterangan);
							var d=parseFloat(data.totprice);
							var rupiah = d.toFixed(2);
							$('#jumlah').val(rupiah);
							$('#wo').val(data.pk);
							$('.modal-edit-detail').modal('show');
							$('#sanper').val(data.account).trigger('change');
							$('#lapangan').val(data.lokasi).trigger('change');
							$('#jnsbiaya').val(data.jb).trigger('change');
							$('#bagian').val(data.bagian).trigger('change');
							$('#cjudex').val(data.cj).trigger('change');

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
				url  : "{{ route('modul_kontroler.postingan_kas_bank.update.detail') }}",
				type : "POST",
				data : $('#form-edit-detail').serialize(),
				dataType : "JSON",
				headers: {
				'X-CSRF-Token': '{{ csrf_token() }}',
				},
				success : function(data){
					if(data == 1){
						Swal.fire({
							icon  : 'success',
							title : 'Data Detail Kas Bank Sudah Update.',
							text  : 'Berhasil',
							timer : 2000
							}).then(function() {
								location.reload();
							});
					}else{
						Swal.fire({
							type  : 'info',
							title : 'Data Sudah Di Posting, Tidak Bisa Di Tambah/Update/Hapus.',
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
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_kontroler.postingan_kas_bank.delete.detail') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "no": no,
                                    "id": id,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : "Detail Kas Bank Dengan Nourut : " +id+" Berhasil Dihapus.",
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
    });
</script>
@endpush
