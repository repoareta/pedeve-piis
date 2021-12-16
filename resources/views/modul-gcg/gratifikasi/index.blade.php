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

        @include('modul-gcg.gratifikasi.menu')

    </div>
    <div class="card-body">
        <div class="col-12">
			<form class="form" id="search-form" method="POST">
				<div class="form-group row">
					<label for="" class="col-form-label">Pegawai</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="pegawai" id="pegawai">
							<option value="">- Pilih Pegawai -</option>
							<option value="1">Januari</option>
						</select>
					</div>

                    <label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="bulan" id="bulan">
							<option value="">- Pilih Bulan -</option>
							<option value="1">Januari</option>
							<option value="2">Februari</option>
							<option value="3">Maret</option>
							<option value="4">April</option>
							<option value="5">Mei</option>
							<option value="6">Juni</option>
							<option value="7">Juli</option>
							<option value="8">Agustus</option>
							<option value="9">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
						</select>
					</div>

					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="tahun" id="tahun">
							<option value="">- Pilih Tahun -</option>
						</select>
					</div>

                    <label for="" class="col-form-label">Type</label>
					<div class="col-2">
						<select class="form-control select2" style="width: 100% !important;" name="type" id="type">
							<option value="">- Pilih Type -</option>
							<option value="penerimaan">Penerimaan</option>
							<option value="pemberian">Pemberian</option>
							<option value="permintaan">Permintaan</option>
						</select>
					</div>

					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>Nopek</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Pemberi</th>
                            <th>Penerima</th>
                            <th>Peminta</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gratifikasi_list as $gratifikasi)
                        <tr>
                            <td>{{ $gratifikasi->nopeg }}</td>
                            <td>{{ $gratifikasi->pekerja->nama }}</td>
                            <td>{{ Carbon\Carbon::parse($gratifikasi->tgl_gratifikasi)->translatedFormat('d F Y') }}</td>
                            <td>{{ $gratifikasi->bentuk ? $gratifikasi->bentuk : '-' }}</td>
                            <td>{{ $gratifikasi->jumlah ? $gratifikasi->jumlah : '-' }}</td>
                            <td>{{ $gratifikasi->pemberi ? $gratifikasi->pemberi : '-' }}</td>
                            <td>{{ $gratifikasi->penerima ? $gratifikasi->penerima : '-' }}</td>
                            <td>{{ $gratifikasi->peminta ? $gratifikasi->peminta : '-' }}</td>
                            <td>{{ $gratifikasi->keterangan ? $gratifikasi->keterangan : '-' }}</td>
                            <td>{{ $gratifikasi->gift_last_month ? 'NIHIL' : '-' }}</td>
                            <td>{{ $gratifikasi->status }}</td>
                            <td>{{ ucwords($gratifikasi->jenis_gratifikasi) }}</td>
                            <td class="text-nowrap">
                                @if (!$gratifikasi->gift_last_month && !$gratifikasi->status)
                                    <a href="{{ route('modul_gcg.gratifikasi.edit', ['gratifikasi' => $gratifikasi->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Ubah</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
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
		$('#kt_table').DataTable();
	});
</script>
@endpush
