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
                Tabel Postingan Kas Bank
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Proses Posting">
						<i class="fas fa-2x fa-database text-success" id="prsposting"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Batal Posting">
						<i class="fas fa-2x fa-reply text-warning" id="btlposting"></i>
					</span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="search-form">
            <div class="form-group row">
                <label class="col-xl-1 col-lg-1 col-form-label">Bulan {{ $bulan }}</label>
                <div class="col-lg-3 col-xl-3">
                    <select class="form-control select2" style="width: 100% !important;" name="bulan" id="bulan">	
                        <option value="">- Pilih Data -</option>								                        
                        <option value="01" {{ $bulan  == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="02" {{ $bulan  == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="03" {{ $bulan  == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="04" {{ $bulan  == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ $bulan  == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="06" {{ $bulan  == '06' ? 'selected' : '' }}>Juni</option>
                        <option value="07" {{ $bulan  == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="08" {{ $bulan  == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="09" {{ $bulan  == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $bulan  == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ $bulan  == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $bulan  == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
                <label class="col-xl-1 col-lg-1 col-form-label">Tahun</label>
                <div class="col-lg-3 col-xl-3">                    
                    <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">                    
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>TANGGAL</th>
                            <th>NO.DOKUMEN</th>
                            <th>THN-BLN</th>
                            <th>KETERANGAN</th>
                            <th>JK</th>
                            <th>STORE</th>
                            <th>NOBUKTI</th>
                            <th>JUMLAH</th>
                            <th>VERIFIKASI</th>
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
        ajax: {
            url: "{{ route('modul_kontroler.postingan_kas_bank.index.json') }}",
            data: function (d) {
                d.bulan = $('select[name=bulan]').val();
                d.tahun = $('input[name=tahun]').val();
            }
        },
        columns: [
            {data: 'paiddate', name: 'paiddate'},
            {data: 'docno', name: 'docno'},
            {data: 'thnbln', name: 'thnbln'},
            {data: 'keterangan', name: 'keterangan'},
            {data: 'jk', name: 'jk'},
            {data: 'store', name: 'store'},
            {data: 'voucher', name: 'voucher'},
            {data: 'nilai', name: 'nilai'},
            {data: 'action', name: 'action'},
        ]
    });
    
    $('#search-form').on('submit', function(e) {
        t.draw();
        e.preventDefault();
    });

    $('#prsposting').on('click', function(e) {
        e.preventDefault();
        location.replace("{{ route('modul_kontroler.postingan_kas_bank.prsposting') }}");
    });

    $('#btlposting').on('click', function(e) {
        e.preventDefault();
        location.replace("{{ route('modul_kontroler.postingan_kas_bank.btlposting') }}");
    });
});

</script>
@endpush
