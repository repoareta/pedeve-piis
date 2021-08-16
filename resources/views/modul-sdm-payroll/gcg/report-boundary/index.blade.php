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
                Report Boundary
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_sdm_payroll.gcg.lhkpn.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <form class="form" action="{{ route('modul_sdm_payroll.gcg.report_boundary.export') }}" method="GET" target="_blank">
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Bulan<span class="text-danger">*</span></label>
                        <div class="col-4">
                                <select class="form-control select2" style="width: 100% !important;" name="bulan_mulai">
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
                        <label for="" class="col-2 col-form-label text-center">Sampai Dengan</label>
                        <div class="col-4">
                                <select class="form-control select2" style="width: 100% !important;" name="bulan_sampai">
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
                    <label for="" class="col-2 col-form-label">Tahun<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control tahun" type="text" value="{{ date('Y') }}" name="tahun"> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
                        </div>
                    </div>
                </form>
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
