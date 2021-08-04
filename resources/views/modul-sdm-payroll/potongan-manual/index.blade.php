@extends('layouts.app')

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
                Tabel Potongan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_umum.perjalanan_dinas.create') }}">
					<span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas icon-2x fa-plus-circle text-success"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas icon-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas icon-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form class="form" id="search-form" >
                    <div class="form-group row col-12">
                        <label for="" class="col-form-label">Pegawai</label>
                        <div class="col-4">
                            <select name="nopek" class="form-control select2">
                            <option value="">- Pilih -</option>
                                @foreach($data_pegawai as $data)
                                <option value="{{ $data->nopeg }}">{{ $data->nopeg }} - {{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="" class="col-form-label">Bulan</label>
                        <div class="col-2">
                            <select name="bulan" class="form-control select2">
                                <option value="">- Pilih -</option>
                                <option value="01" <?php if($bulan == '01' ) echo 'selected' ; ?>>Januari</option>
                                <option value="02" <?php if($bulan == '02' ) echo 'selected' ; ?>>Februari</option>
                                <option value="03" <?php if($bulan == '03' ) echo 'selected' ; ?>>Maret</option>
                                <option value="04" <?php if($bulan == '04' ) echo 'selected' ; ?>>April</option>
                                <option value="05" <?php if($bulan == '05' ) echo 'selected' ; ?>>Mei</option>
                                <option value="06" <?php if($bulan == '06' ) echo 'selected' ; ?>>Juni</option>
                                <option value="07" <?php if($bulan == '07' ) echo 'selected' ; ?>>Juli</option>
                                <option value="08" <?php if($bulan == '08' ) echo 'selected' ; ?>>Agustus</option>
                                <option value="09" <?php if($bulan == '09' ) echo 'selected' ; ?>>September</option>
                                <option value="10" <?php if($bulan == '10' ) echo 'selected' ; ?>>Oktober</option>
                                <option value="11" <?php if($bulan == '11' ) echo 'selected' ; ?>>November</option>
                                <option value="12" <?php if($bulan == '12' ) echo 'selected' ; ?>>Desember</option>
                            </select>
                        </div>
        
                        <label for="" class="col-form-label">Tahun</label>
                        <div class="col-2">
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>TAHUN</th>
                            <th>BULAN</th>
                            <th>PEGAWAI</th>
                            <th>AARD</th>
                            <th>CICILAN KE-</th>
                            <th>JUMLAH CICILAN</th>
                            <th>NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
$(document).ready(function () {
    var t = $('#kt_table').DataTable({
        scrollX   : true,
        processing: true,
        serverSide: true,
        ajax      : {
            url: "{{ route('modul_sdm_payroll.potongan_manual.index.json') }}",
            data: function (d) {
                d.nopek = $('select[name=nopek]').val();
                d.bulan = $('select[name=bulan]').val();
                d.tahun = $('input[name=tahun]').val();
            }
        },
        columns: [
            {data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
            {data: 'tahun', name: 'tahun'},
            {data: 'bulan', name: 'bulan'},
            {data: 'nopek', name: 'nopek'},
            {data: 'aard', name: 'aard'},
            {data: 'ccl', name: 'ccl', class: 'text-right'},
            {data: 'jmlcc', name: 'jmlcc', class: 'text-right no-wrap'},
            {data: 'nilai', name: 'nilai', class: 'text-right no-wrap'},
        ]
            
    });

    $('#search-form').on('submit', function(e) {
        t.draw();
        e.preventDefault();
    });

    // edit potongan Otomatis
    $('#editRow').click(function(e) {
        e.preventDefault();
    
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function(){
                var tahun = $(this).attr('tahun');
                var bulan = $(this).attr('bulan');
                var nopek = $(this).attr('nopek');
                var aard  = $(this).attr('aard');
                var nama  = $(this).attr('nama');
                location.replace("{{ url('sdm-payroll/potongan-manual/edit') }}"+ '/' +bulan+'/' +tahun+'/'+aard+ '/' +nopek);
            });
        } else {
            swalAlertInit('ubah');
        }
    });
    
    // delete potongan otomatis
    $('#deleteRow').click(function(e) {
        e.preventDefault();
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function() {
                var tahun = $(this).attr('tahun');
                var bulan = $(this).attr('bulan');
                var nopek = $(this).attr('nopek');
                var aard  = $(this).attr('aard');
                var nama  = $(this).attr('nama');
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
                        text: "Detail data Bulan: "+bulan+ ' Tahun '  + tahun+' Nama ' +nama,
                        type: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('modul_sdm_payroll.potongan_manual.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "bulan": bulan,
                                "tahun": tahun,
                                "nopek": nopek,
                                "aard": aard,
                                "nama": nama,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire({
                                    type  : 'success',
                                    title : "Detail data Bulan: "+bulan+ ' Tahun '  + tahun+' Nama ' +nama,
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
        } else {
            swalAlertInit('hapus');
        }
    });
});
</script>
@endpush
