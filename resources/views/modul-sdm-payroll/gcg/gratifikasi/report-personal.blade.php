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
            <form action="{{ route('modul_sdm_payroll.gcg.gratifikasi.report.personal.export') }}" target="_blank" class="col-12 kt-form" id="search-form" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Bentuk Gratifikasi</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100% !important;" name="bentuk_gratifikasi" id="bentuk_gratifikasi">
                            <option value="">- Pilih -</option>
                            <option value="penerimaan">Penerimaan</option>
                            <option value="pemberian">Pemberian</option>
                            <option value="permintaan">Permintaan</option>
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Bulan</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100% !important;" name="bulan" id="bulan">
                            <option value="">- Pilih Bulan -</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Tahun</label>
                    <div class="col-4">
                        <select class="form-control select2" style="width: 100% !important;" name="tahun" id="tahun">
                            <option value="">- Pilih Tahun -</option>
                            @foreach ($gratifikasi_tahun as $tahun)
                            <option value="{{ $tahun->year }}">{{ $tahun->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="form-group row">
                    <div class="col-2"></div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tampilkan</button>
                        <button type="button" onclick="this.form.submit()" class="btn btn-danger"><i class="fa fa-print"></i> Cetak .PDF</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>TANGGAL</th>
                            <th>JENIS</th>
                            <th>JUMLAH</th>
                            <th>PEMBERI</th>
                            <th>KETERANGAN</th>
                            <th>TANGGAL SUBMIT</th>
                            <th>STATUS</th>
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
				url: "{{ route('modul_sdm_payroll.gcg.gratifikasi.report.personal.json') }}",
				data: function (d) {
					d.bentuk_gratifikasi = $('select[name=bentuk_gratifikasi]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('select[name=tahun]').val();
				}
			},
			columns: [
				{data: 'tanggal_gratifikasi', name: 'tgl_gratifikasi', class:'no-wrap'},
				{data: 'bentuk', name: 'bentuk', class:'no-wrap'},
				{data: 'jumlah', name: 'jumlah', class:'no-wrap'},
				{data: 'pemberi', name: 'pemberi', class:'no-wrap'},
				{data: 'keterangan', name: 'keterangan'},
				{data: 'tanggal_submit', name: 'created_at', class:'no-wrap'},
				{data: 'status', name: 'status', class:'no-wrap'}
			]
		});

		$('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});
	});
</script>
@endpush
