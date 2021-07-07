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
                Tabel RKAP & Realisasi
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_cm.rkap_realisasi.create') }}">
					<span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data RKAP">
						<i class="fas icon-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                <a href="{{ route('modul_cm.rkap_realisasi.realisasi.create') }}">
					<span class="text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Realisasi">
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

		<div class="col-12">
			<form class="kt-form" id="search-form" >
				<div class="form-group row">
					<label for="" class="col-form-label">Tahun</label>
					<div class="col-2">
						<input class="form-control" type="text" name="tahun" value="{{ date('Y') }}">
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
					</div>
				</div>
			</form>
		</div>

        <div class="row">
            <div class="col-xl-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="kt_tablea" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center" scope="col">
                                    Perusahaan
                                </th>
                                <th rowspan="2" class="text-center">
                                    Kategori
                                </th>
                                <th rowspan="2" class="text-center" style="white-space: nowrap;">
                                    RKAP tahun 2021
                                </th>
                                <th rowspan="2" class="text-center">
                                    CI
                                </th>
                                <th colspan="12" class="text-center">
                                    Realisasi tahun 2021
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Jan
                                </th>
                                <th>
                                    Feb
                                </th>
                                <th>
                                    Mar
                                </th>
                                <th>
                                    Apr
                                </th>
                                <th>
                                    Mei
                                </th>
                                <th>
                                    Jun
                                </th>
                                <th>
                                    Jul
                                </th>
                                <th>
                                    Agu
                                </th>
                                <th>
                                    Sep
                                </th>
                                <th>
                                    Okt
                                </th>
                                <th>
                                    Nov
                                </th>
                                <th>
                                    Des
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rkapRealisasiList as $rkapRealiasi)
                            <tr>
                                <td rowspan="9" class="no-wrap align-middle">{{ $rkapRealiasi->nama }}</td>
                                <td class="no-wrap">Aset</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->aset_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_aset_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_aset_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Revenue</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->revenue_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_revenue_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_revenue_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Beban Pokok</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->beban_pokok_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_beban_pokok_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_beban_pokok_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Laba Kotor</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->laba_kotor_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_kotor_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_kotor_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Biaya Operasi</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->biaya_operasi_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_biaya_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_biaya_operasi_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Laba Operasi</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->laba_operasi_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_operasi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_operasi_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">Laba Bersih</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->laba_bersih_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_laba_bersih_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_laba_bersih_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">TKP</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->tkp_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_tkp_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_tkp_r) }}</td>
                            </tr>
                            <tr>
                                <td class="no-wrap">KPI</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->kpi_r) }}</td>
                                <td>{{ $rkapRealiasi->ci_r }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jan_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_feb_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mar_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_apr_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_mei_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jun_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_jul_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_agu_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_sep_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_okt_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_nov_kpi_r) }}</td>
                                <td class="text-right">{{ currency_format($rkapRealiasi->trk_des_kpi_r) }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
    $(document).ready(function(){
    });		
</script>
@endpush
