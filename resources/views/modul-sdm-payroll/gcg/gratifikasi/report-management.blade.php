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
                Gratifikasi
            </h3>
        </div>

        @include('modul-sdm-payroll.gcg.gratifikasi.menu')
    </div>
    <div class="card-body">

        <div class="col-12">
            <form action="{{ route('modul_sdm_payroll.gcg.gratifikasi.report.management.export') }}" class="col-12 kt-form" method="GET" id="search-form" target="_blank">
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Bentuk Gratifikasi</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100%;" name="bentuk_gratifikasi" id="bentuk_gratifikasi">
                            <option value="">- Pilih -</option>
                            <option value="penerimaan" @if (request('bentuk_gratifikasi') == 'penerimaan') {{ 'selected' }} @endif>Penerimaan</option>
                            <option value="pemberian" @if (request('bentuk_gratifikasi') == 'pemberian') {{ 'selected' }} @endif>Pemberian</option>
                            <option value="permintaan" @if (request('bentuk_gratifikasi') == 'permintaan') {{ 'selected' }} @endif>Permintaan</option>
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Pilih Fungsi</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100%;" name="fungsi" id="fungsi">
                            <option value="">- Pilih -</option>
                            @foreach ($fungsi_list as $fungsi)
                            <option value="{{ $fungsi->id }}" @if (request('fungsi') == $fungsi->id) {{ 'selected' }} @endif>{{ $fungsi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Bulan</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100%;" name="bulan" id="bulan">
                            <option value="">- Pilih Bulan -</option>
                            <option value="01" @if (request('bulan') == '01') {{ 'selected' }} @endif>Januari</option>
                            <option value="02" @if (request('bulan') == '02') {{ 'selected' }} @endif>Februari</option>
                            <option value="03" @if (request('bulan') == '03') {{ 'selected' }} @endif>Maret</option>
                            <option value="04" @if (request('bulan') == '04') {{ 'selected' }} @endif>April</option>
                            <option value="05" @if (request('bulan') == '05') {{ 'selected' }} @endif>Mei</option>
                            <option value="06" @if (request('bulan') == '06') {{ 'selected' }} @endif>Juni</option>
                            <option value="07" @if (request('bulan') == '07') {{ 'selected' }} @endif>Juli</option>
                            <option value="08" @if (request('bulan') == '08') {{ 'selected' }} @endif>Agustus</option>
                            <option value="09" @if (request('bulan') == '09') {{ 'selected' }} @endif>September</option>
                            <option value="10" @if (request('bulan') == '10') {{ 'selected' }} @endif>Oktober</option>
                            <option value="11" @if (request('bulan') == '11') {{ 'selected' }} @endif>November</option>
                            <option value="12" @if (request('bulan') == '12') {{ 'selected' }} @endif>Desember</option>
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Tahun</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100%;" name="tahun" id="tahun">
                            <option value="">- Pilih Tahun -</option>
                            @foreach ($gratifikasi_tahun as $tahun)
                            <option value="{{ $tahun->year }}" @if (request('tahun') == $tahun->year) {{ 'selected' }} @endif>{{ $tahun->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <div class="col-2">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tampilkan</button>
                        <button type="button" onclick="this.form.submit()" class="btn btn-danger"><i class="fa fa-print" aria-hidden="true"></i> Cetak .PDF</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th>TANGGAL PENERIMAAN</th>
                            <th>JENIS</th>
                            <th>JUMLAH</th>
                            <th>PEMBERI</th>
                            <th>KETERANGAN</th>
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
				url: "{{ route('modul_sdm_payroll.gcg.gratifikasi.report.management.json') }}",
				data: function (d) {
					d.bentuk_gratifikasi = $('select[name=bentuk_gratifikasi]').val();
					d.fungsi = $('select[name=fungsi]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('select[name=tahun]').val();
				}
			},
			columns: [
				{data: 'nama', name: 'nama', class:'no-wrap'},
				{data: 'fungsi_jabatan', name: 'fungsi_jabatan', class:'no-wrap'},
				{data: 'tanggal_gratifikasi', name: 'tgl_gratifikasi', class:'no-wrap'},
				{data: 'bentuk', name: 'bentuk', class:'no-wrap'},
				{data: 'jumlah', name: 'jumlah', class:'no-wrap'},
				{data: 'pemberi', name: 'pemberi', class:'no-wrap'},
				{data: 'keterangan', name: 'keterangan'}
			]
		});

		$('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});
	});
</script>
@endpush
