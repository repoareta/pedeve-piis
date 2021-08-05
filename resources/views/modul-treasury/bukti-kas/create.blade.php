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
                <form action="{{ route('penerimaan_kas.store') }}" method="POST" id="form-create">
                    @csrf
                    @method('POST')
                    <input class="form-control" type="hidden" name="user_id" value="{{ auth()->user()->userid }}">
                    <input type="hidden" name="nomor" id="nomor">
                    <input class="form-control" type="hidden" value="{{ $tahun_buku . $bulan_buku }}" name="tanggal_buku" id="tanggal_buku">
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label text-right">No.Dokumen</label>
                        <div class="col-10">
                            <input type="hidden" class="form-control" value="{{ date('Y-m-d') }}" size="1" maxlength="1" name="tanggal" id="tanggal" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                            <input type="text" class="form-control" value="{{ request()->mp }}" size="1" maxlength="1" name="mp" id="mp" readonly style="background-color:#DCDCDC; cursor:not-allowed"></td>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label text-right">Bulan/Tahun <span class="text-danger">*</span></label>
                        <div class="col-4">
                            <input class="form-control" type="text" value="{{ $bulan_buku }}" name="bulan_buku" id="bulan_buku" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="text" value="{{ $tahun_buku }}" name="tahun_buku" id="tahun_buku" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label text-right">Bagian <span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select name="bagian" id="bagian" class="form-control">
                                <option>- Pilih -</option>
                                @foreach ($semuaBagian as $bagian)
                                <option value="{{ $bagian->kode }}">{{ $bagian->kode }} &mdash; {{ $bagian->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label text-right">Jenis Kartu <span class="text-danger">*</span></label>
                        <div class="col-3">
                            <select name="jenis_kartu" id="jenis_kartu" class="form-control">
                                <option value="">- Pilih -</option>
                                <option value="10">Kas(Rupiah)</option>
                                <option value="11">Bank(Rupiah)</option>
                                <option value="13">Bank(Dollar)</option>
                            </select>
                        </div>
                        <label class="col-2 col-form-label text-right">Currency Index</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="currency_index" id="currency_index" size="6" maxlength="6" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label text-right">Kurs <span class="text-danger">*</span></label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="kurs" id="kurs" size="7" maxlength="7" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label text-right">Lokasi <span class="text-danger">*</span></label>
                        <div class="col-4">
                            <select name="lokasi" id="lokasi" class="form-control select2" style="width: 100% !important;">
                                <option value="">- Pilih -</option>
                            </select>
                        </div>
                        <label class="col-1 col-form-label text-right">No Bukti</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="no_bukti" id="no_bukti" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                        <label class="col-1 col-form-label text-right">No Ver</label>
                        <div class="col-2" >
                            <input class="form-control" type="text" name="no_ver" value="{{ $noVer }}"  id="nover" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">
                        {{ request()->mp == 'M' ? 'Dari' : 'Kepada' }} <span class="text-danger">*</span>
                        </label>
                        <div class="col-10">
                        <select class="form-control" style="width: 100% !important;" id="kepada" name="kepada"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Sejumlah</label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nilai" id="nilai" value="0" size="16" maxlength="16" autocomplete="off" readonly>
                            <input class="form-control" type="hidden" name="iklan" id="iklan" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Catatan 1</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="keterangan-1" id="keterangan-1"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Catatan 2</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="keterangan-2" id="keterangan-2"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Catatan 3</label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="keterangan-3" id="keterangan-3"></textarea>
                        </div>
                    </div>
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

</div>
@endsection

@push('page-scripts')
<script>

    function disableInput(instance) {
        instance.prop("disabled", true);
        instance.prop("readonly", true);
        instance.css("background-color", "#DCDCDC");
        instance.css("cursor", "not-allowed");
    }

    $(document).ready(function () {
        

        $('#bagian').select2();
        $('#lokasi').select2();

        $('#form-create').on('submit', function () {
            let mp = $("#mp").val();
            let bagian = $("#bagian").val();
            let nomor = $("#nomor").val();
            let currentDocumentNumber = `${mp}-${bagian}-${nomor}`;
            let dataSerialized = $(this).serialize();
            $('#btn-save').prop('disabled', true);

            $.ajax({
                url  : "{{ route('penerimaan_kas.store') }}",
                type : "POST",
                data : dataSerialized,
                dataType : "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function (result) {
                    Swal.fire({
                        icon: result.type,
                        title: result.message,
                        text: result.text
                    }).then(function () {
                        if (result.status == 1) {
                            location.href = `{{ url('perbendaharaan/penerimaan-kas/') }}/${currentDocumentNumber}/input-detail`;
                        }
                    });
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR! Ada kesalahan pada server!',
                        text: 'ERROR'
                    });
                }
            })

            return false;
        });

        $('#bagian').on('change', function() {
            let bagian = $(this).val();
            let bulan = $('#bulan_buku').val();
            let tahun = $('#tahun_buku').val();
            let tanggalBuku = tahun + bulan;
            let mp = '{{ request()->mp }}';

            $.ajax({
                url : "{{ route('penerimaan_kas.ajax-create') }}",
                type : "POST",
                dataType: 'json',
                data : {
                    bagian: bagian,
                    bulanbuku: tanggalBuku,
                    mp: mp,
                    },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                success : function(data){
                    var nodata = tahun.substr(2, 2)+''+bulan+''+data;
                    var nomor = parseInt(nodata)+parseInt(1);
                    $('#nomor').val(nomor);
                },
                error : function(){
                    alert("Ada kesalahan controller!");
                }
            });
        });

        $('#jenis_kartu').on('change', function () {
            let jenisKartu = $(this).val();
            let kurs = $("#kurs");
            
            switch (jenisKartu) {
                case '13':
                    $("#currency_index").val('2');
                    kurs.val('0')
                    kurs.prop("required", true);
                    kurs.prop("readonly", false);
                    kurs.css("background-color", "#ffffff");
                    kurs.css("cursor", "text");
                    break;
                case '11':
                    $("#currency_index").val('1');
                    kurs.val('1');
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#DCDCDC");
                    kurs.css("cursor", "not-allowed");
                    break;
                case '10':
                    $("#currency_index").val('1');
                    kurs.val('1');
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#DCDCDC");
                    kurs.css("cursor", "not-allowed");
                    break;
                default:
                    $("#currency_index").val(null);
                    kurs.val(null);
                    kurs.prop("required", false);
                    kurs.prop("readonly", true);
                    kurs.css("background-color", "#DCDCDC");
                    kurs.css("cursor", "not-allowed");
                    break;
            }

            let currencyIndex = $('#currency_index').val();

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

        $('#lokasi').on('change', function () {
            let lokasi = $(this).val();
            let mp = '{{ request()->mp }}';
            let tahun = $('tahun_buku').val();

            $.ajax({
                url : "{{ route('penerimaan_kas.ajax-bukti') }}",
                type : "POST",
                dataType: 'json',
                data : {
                    lokasi: lokasi,
                    mp: mp,
                    tahun: tahun,
                },
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success : function (data){
                    $("#no_bukti").val(data);
                },
                error : function(){
                    alert("Ada kesalahan di system!");
                }
            });
        });

        $('#kepada').select2({
            placeholder: 'Cari...',
            allowClear: true,
            tags: true,
            ajax: {
                url: `{{ route('penerimaan_kas.ajax-kepada') }}`,
                type: 'POST',
                dataType: 'JSON',
                delay: 250,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.kepada,
                                id: item.kepada,
                            }
                        })
                    };
                },
                cache: true
            },
        });

        $('#nilai').on('keyup', function () {
            var nilai = $(this).val();

            if(nilai < '0'){
                $("#iklan").val('CR');
            }else if(nilai > '0'){
                $("#iklan").val('DR');
            } else {
                $("#iklan").val('');
            }
        });

    });
</script>
@endpush