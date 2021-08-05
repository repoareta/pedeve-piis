@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Informasi Saldo
            </h3>
            <div class="text-right">
                
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="col-12">

        </div>
        <form class="form" id="search-form">
            <div class="form-group row">
                <label for="" class="col-1 col-form-label">Tanggal</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="tanggal" value="" id="tanggal" autocomplete="off">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th width="50"></th>
					<th>Kas-JK</th>
					<th>Saldo</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
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
                url: "{{ route('informasi_saldo.index.json') }}",
                type: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: function (d) {
                    d.tanggal = $('input[name=tanggal]').val();
                }
            },
            columns: [
                {data: 'action', name: 'aksi', class:'radio-button'},
                {data: 'kodestore', name: 'kodestore'},
                {data: 'ak', name: 'ak'},
            ]
        });

        $('#search-form').on('submit', function(e) {
            t.draw();
            e.preventDefault();
        });
        
        $('#tanggal').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'dd-mm-yyyy'
        });
    });
</script>
@endpush