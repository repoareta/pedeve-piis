@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">

    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Bukti Kas/Bank
            </h3>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xl-12">
                <form class="kt-form" id="search-form">
                    <div class="form-group row col-12">
                        <label for="" class="col-form-label">No. Bukti</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="bukti" value="" size="18" maxlength="18" autocomplete='off'>
                        </div>
                        <label for="" class="col-form-label">Bulan</label>
                        <div class="col-2">
                            <select name="bulan" class="form-control selectpicker" data-live-search="true">
                                <option value="">-- Pilih --</option>
                                @foreach ($daftarBulan as $month)
                                <option value="{{ $month['month_number'] }}"
                                    {{ $bulan == $month['month_number'] ? 'selected' : null }}>
                                    {{ $month['month_name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="" class="col-form-label">Tahun</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="tahun" value="{{ $tahun }}" size="4" maxlength="4" autocomplete='off'>
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
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table"
                    width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NO. DOKUMEN</th>
                            <th>TANGGAL</th>
                            <th>NO. BUKTI</th>
                            <th>KEPADA</th>
                            <th>JK</th>
                            <th>NO. KAS</th>
                            <th>CI</th>
                            <th>KURS</th>
                            <th>NILAI</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
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
<script>
    function redirectToApproval(id) {
        location.href = `{{ url('perbendaharaan/penerimaan-kas') }}` + `/${id}` + '/approval';
    }

    $(document).ready(function () {
        var keenTable = $('#kt_table').DataTable({
			processing: true,
			serverSide: true,
			searching: false,
			lengthChange: false,
			pageLength: 50,
			scrollX: true,
			language: {
			processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax: {
				url: "{{ route('penerimaan_kas.ajax') }}",
				type : "POST",
				dataType : "JSON",
				headers: {
				    'X-CSRF-Token': '{{ csrf_token() }}',
				},
				data: function (d) {
					d.bukti = $('input[name=bukti]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('input[name=tahun]').val();
				}
			},
			columns: [
				{ data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button' },
                { data: 'no_dok', name: 'no_dok' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'voucher', name: 'voucher' },
                { data: 'kepada', name: 'kepada' },
                { data: 'jk', name: 'jk' },
                { data: 'store', name: 'store' },
                { data: 'ci', name: 'ci' },
                { data: 'rate', name: 'rate' },
                { data: 'nilai_dokumen', name: 'nilai_dokumen' },
                { data: 'status', name: 'status', orderable: false, searchable: false, },
                { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' },
			]
			
	    });

        $('#search-form').on('submit', function(e) {
            keenTable.draw();
            e.preventDefault();
        });
    });
</script>
@endpush