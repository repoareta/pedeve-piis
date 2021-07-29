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
                Tabel Pencapaian Kinerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
				<a href="#">
					<span class="text-danger pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas icon-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
			<form class="kt-form" action="{{ route('modul_cm.pencapaian_kinerja.search') }}" method="GET">
				<div class="form-group row">
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<?php 
							$tgl = date_create(now());
							$bulan = date_format($tgl, 'm'); 
							$tahun = date_format($tgl, 'Y'); 
							$array_bln	 = array (
								1 =>   'Januari',
								'Februari',
								'Maret',
								'April',
								'Mei',
								'Juni',
								'Juli',
								'Agustus',
								'September',
								'Oktober',
								'November',
								'Desember'
							);
							
							$bulan_1 = ($array_bln[ltrim($bulan,0)]);
						?>
						<select class="form-control select2" style="width: 100%;" name="bulan">
							<option value="01" <?php if($bulan  == '01' ) echo 'selected' ; ?>>Januari</option>
							<option value="02" <?php if($bulan  == '02' ) echo 'selected' ; ?>>Februari</option>
							<option value="03" <?php if($bulan  == '03' ) echo 'selected' ; ?>>Maret</option>
							<option value="04" <?php if($bulan  == '04' ) echo 'selected' ; ?>>April</option>
							<option value="05" <?php if($bulan  == '05' ) echo 'selected' ; ?>>Mei</option>
							<option value="06" <?php if($bulan  == '06' ) echo 'selected' ; ?>>Juni</option>
							<option value="07" <?php if($bulan  == '07' ) echo 'selected' ; ?>>Juli</option>
							<option value="08" <?php if($bulan  == '08' ) echo 'selected' ; ?>>Agustus</option>
							<option value="09" <?php if($bulan  == '09' ) echo 'selected' ; ?>>September</option>
							<option value="10" <?php if($bulan  =='10'  ) echo 'selected' ; ?>>Oktober</option>
							<option value="11" <?php if($bulan  == '11' ) echo 'selected' ; ?>>November</option>
							<option value="12" <?php if($bulan  == '12' ) echo 'selected' ; ?>>Desember</option>
						</select>
					</div>
	
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
					</div>
					<label for="" class="col-form-label">Perusahaan</label>
					<div class="col-4">
						<select name="perusahaan" class="form-control select2">
							<option value="">- Pilih -</option>
							@foreach ($data_perusahaan as $row)
							<option value="{{ $row->id }}">{{ $row->nama }}</option>
							@endforeach
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
                <table id="kt_table" class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>RENCANA KERJA</th>
                            <th>REALISASI</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($data as $row)					
                        <tr>
                            <th>Perusahaan</th>
                            <th>{{ $row->nama }}</th>
                            <th>{{ $row->nama }}</th>
                        </tr>
                        <tr>
                            <td>Aset</td>
                            <td class="text-right">{{ currency_format($row->aset_r) }}</td>
                            <td class="text-right">{{ currency_format($row->aset) }}</td>
                        </tr>
                        <tr>
                            <td>Revenue</td>
                            <td class="text-right">{{ currency_format($row->revenue_r) }}</td>
                            <td class="text-right">{{ currency_format($row->revenue) }}</td>
                        </tr>
                        <tr>
                            <td>Beban Pokok</td>
                            <td class="text-right">{{ currency_format($row->beban_pokok_r) }}</td>
                            <td class="text-right">{{ currency_format($row->beban_pokok) }}</td>
                        </tr>
                        <tr>
                            <td>Laba Kotor</td>
                            <td class="text-right">{{ currency_format($row->beban_pokok_r+$row->revenue_r) }}</td>
                            <td class="text-right">{{ currency_format($row->beban_pokok+$row->revenue) }}</td>
                        </tr>
                        <tr>
                            <td>Biaya Operasi</td>
                            <td class="text-right">{{ currency_format($row->biaya_operasi_r) }}</td>
                            <td class="text-right">{{ currency_format($row->biaya_operasi) }}</td>
                        </tr>
                        <tr>
                            <td>Laba Operasi</td>
                            <td class="text-right">{{ currency_format($row->biaya_operasi_r+($row->beban_pokok_r+$row->revenue_r)) }}</td>
                            <td class="text-right">{{ currency_format($row->biaya_operasi+($row->beban_pokok+$row->revenue)) }}</td>
                        </tr>
                        <tr>
                            <td>Laba Bersih</td>
                            <td class="text-right">{{ currency_format($row->laba_bersih_r) }}</td>
                            <td class="text-right">{{ currency_format($row->laba_bersih) }}</td>
                        </tr>
                        <tr>
                            <td>TKP</td>
                            <td class="text-right">{{ currency_format($row->tkp_r) }}</td>
                            <td class="text-right">{{ currency_format($row->tkp) }}</td>
                        </tr>
                        <tr>
                            <td>KPI</th>
                            <td class="text-right">{{ currency_format($row->kpi_r) }}</td>
                            <td class="text-right">{{ currency_format($row->kpi) }}</td>
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
@endpush
