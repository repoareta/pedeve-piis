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
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Jenis Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            Header Jenis Kas/Bank
                        </div>
                    </div>
                </div>
                <input class="form-control" type="hidden" name="user_id" value="{{ auth()->user()->userid }}">
                <input type="hidden" name="nomor" id="nomor" value="{{ $nomor }}">
                <input class="form-control" type="hidden" value="{{ $document->thnbln }}" name="tanggal_buku" id="tanggal_buku">
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label text-right">No. Dokumen</label>
                    <div class="col-10">
                        <input type="text" class="form-control" value="{{ $document->docno }}" name="nodoc" id="nodoc" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-2 col-form-label text-right">Bulan/Tahun</label>
                    <div class="col-4">
                        <input class="form-control" type="text" value="{{ $bulan }}" name="bulan_buku" id="bulan_buku" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                    <div class="col-6">
                        <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun_buku" id="tahun_buku" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bagian" class="col-2 col-form-label text-right">Bagian</label>
                    <div class="col-10">
                        <input type="text" class="form-control" value="{{ $bagian->kode . ' - ' . $bagian->nama }}" name="bagian" id="bagian" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label text-right">Jenis Kartu</label>
                    <div class="col-3">
                        <input type="text" class="form-control" value="{{ $document->jk == '10' ? 'Kas(Rupiah)' : ($document->jk == '11' ? 'Bank(Rupiah)' : 'Bank(Dollar)') }}" name="jenis_kartu" id="jenis_kartu" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                    <label class="col-2 col-form-label text-right">Currency Index</label>
                    <div class="col-2" >
                        <input class="form-control" type="text" value="{{ $document->ci }}" name="currency_index" id="currency_index" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                    <label class="col-1 col-form-label text-right">Kurs</label>
                    <div class="col-2" >
                        <input class="form-control" type="text" value="{{ number_format($document->rate, 0) }}" name="kurs" id="kurs" size="7" maxlength="7" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis-dinas-input" class="col-2 col-form-label text-right">Lokasi</label>
                    <div class="col-4">
                        <input type="text" class="form-control" value="{{ $document->storejk->namabank . ' - ' . $document->storejk->norekening }}" name="lokasi" id="lokasi" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                    <label class="col-1 col-form-label text-right">No Bukti</label>
                    <div class="col-2" >
                        <input class="form-control" value="{{ $document->voucher }}" type="text" name="no_bukti" id="no_bukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                    <label class="col-1 col-form-label text-right">No Ver</label>
                    <div class="col-2" >
                        <input class="form-control" value="{{ $document->mrs_no }}" type="text" name="no_ver" id="nover" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">{{ $document->mp == 'M' ? 'Dari' : 'Kepada' }}</label>
                    <div class="col-10">
                        <input class="form-control" value="{{ $document->kepada }}" type="text" name="{{ $document->mp == 'M' ? 'dari' : 'kepada' }}" id="{{ $document->mp == 'M' ? 'dari' : 'kepada' }}" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Sejumlah</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="nilai" id="nilai" value="{{ number_format($count, 2, '.', ',') }}" size="16" maxlength="16" autocomplete="off" readonly>
                        <input class="form-control" type="hidden" name="iklan" id="iklan" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Catatan 1</label>
                    <div class="col-10">
                        <textarea class="form-control" type="text" name="ket1" id="ket1" readonly style="background-color:#DCDCDC; cursor:not-allowed">{{ $document->ket1 }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Catatan 2</label>
                    <div class="col-10">
                        <textarea class="form-control" type="text" name="ket2" id="ket2" readonly style="background-color:#DCDCDC; cursor:not-allowed">{{ $document->ket2 }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Catatan 3</label>
                    <div class="col-10">
                        <textarea class="form-control" type="text" name="ket3" id="ket3" readonly style="background-color:#DCDCDC; cursor:not-allowed">{{ $document->ket3 }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label"></label>
                    <div class="col-10">
                        <a href="{{ route('penerimaan_kas.index') }}" class="btn btn-primary"><i class="fa fa-reply"></i>Save & Back</a>
                    </div>
                </div>
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
                    <th>Jumlah</th>
                    <th>CJ</th>	
                </tr>
            </thead>
            <tbody>
                @foreach($kasLine as $detail)
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
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="text" value="{{ $lineNumber }}"  name="nourut" readonly>
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="hidden" value="{{ $document->docno }}"  name="nodok" readonly>
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
							<select class="form-control" style="width: 100% !important;" name="sanper" id="sanper"></select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<select class="form-control" style="width: 100% !important;" name="bagian" id="search-bagian"></select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Perintah Kerja</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<input  class="form-control" type="text" value="000000"  name="pk" size="6" maxlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div  class="col-9">
							<select class="form-control" style="width: 100% !important;" name="jb" id="search-jenis-biaya"></select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<select class="form-control" style="width: 100% !important;" name="cj" id="search-cash-judex"></select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jumlah<span class="text-danger">*</span></label>
						<label for="example-text-input" class="col-1 col-form-label">:</label>
						<div class="col-9">
							<input  class="form-control" type="text" value="" id="nilai-line" name="nilai" size="16" maxlength="16"  required oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete="off">
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
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="text" value="" name="nourut" id="nourut" readonly>
							<input style="background-color:#DCDCDC; cursor:not-allowed"  class="form-control" type="hidden" value="" name="nodok" id="nodok" readonly>
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
							<select name="sanper" id="select-sanper" class="cariaccount form-control" style="width: 100% !important;">
								<option value="">- Pilih -</option>
								@foreach($data_account as $data_acc)
								<option value="{{ $data_acc->kodeacct}}">{{ $data_acc->kodeacct}} - {{ $data_acc->descacct}}</option>
								@endforeach
								
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Kode Bagian</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div  class="col-8">
							<select name="bagian" id="select-bagian" class="caribagian form-control" style="width: 100% !important;" >
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
							<input  class="form-control" type="text" value="000000"  name="pk" id="pk" size="6" maxlength="6">
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">Jenis Biaya</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div  class="col-8">
							<select name="jb" id="select-jb"  class="carijb form-control" style="width: 100% !important;" >
								<option value="">- Pilih -</option>
								@foreach($data_jenis as $data_jen)
								<option value="{{ $data_jen->kode }}">{{ $data_jen->kode }} - {{ $data_jen->keterangan}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="example-text-input" class="col-2 col-form-label">C. Judex</label>
						<label for="example-text-input" class=" col-form-label">:</label>
						<div class="col-8">
							<select name="cj" id="select-cj" class="caricj form-control" style="width: 100% !important;" >
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
							<input  class="form-control" type="text" value="" name="nilai" id="nilai1"  size="16" maxlength="16"  required oninput="this.value = this.value.replace(/[^0-9\-]+/g, ',');" autocomplete="off">
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

        $('#sanper').select2({
            placeholder: 'Ketikkan account.',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.ajax-account') }}",
				type : "POST",
				dataType : "JSON",
				headers: {
				    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.descacct ? (item.kodeacct + ' -- ' + item.descacct) : item.kodeacct,
                                id: item.kodeacct
                            }
                        })
				    };
                },
	    		cache: true,
			}
		});

        $('#search-bagian').select2({
			placeholder: '- Pilih -',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.ajax-bagian') }}",
				type : "POST",
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

        $('#search-jenis-biaya').select2({
			placeholder: '- Pilih -',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.ajax-jenis-biaya') }}",
				type : "POST",
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


        $('#search-cash-judex').select2({
			placeholder: '- Pilih -',
			allowClear: true,
			ajax: {
				url: "{{ route('penerimaan_kas.ajax-cash-judex') }}",
				type : "POST",
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

    });
</script>
@endpush