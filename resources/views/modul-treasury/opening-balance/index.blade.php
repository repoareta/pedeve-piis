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
                Tabel Opening Balance
            </h3>
            <div class="text-right">
                @if($data_akses->tambah == 1)
                <a href="{{ route('opening_balance.create') }}" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas icon-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->rubah == 1)
                <button id="editRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
                        <i class="fas icon-2x fa-trash text-danger"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th width="50"></th>
					<th>BULAN</th>
					<th>TAHUN</th>
					<th>SUPLESI</th>
					<th>TANGGAL</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
    </div>
</div>

@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
		var t = $('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax: {
                url: "{{ route('opening_balance.index.json') }}",
                type : "POST",
                dataType : "JSON",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: function (d) {
                    d.pencarian = $('input[name=pencarian]').val();
                }
            },
			columns: [
				{data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
				{data: 'bulan', name: 'bulan'},
				{data: 'tahun', name: 'tahun'},
				{data: 'suplesi', name: 'suplesi'},
				{data: 'tanggal', name: 'tanggal'},
			]
		});
		$('#search-form').on('submit', function(e) {
			t.draw();
			e.preventDefault();
		});
		$('#kt_table tbody').on( 'click', 'tr', function (event) {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			} else {
				t.$('tr.selected').removeClass('selected');	
				if (event.target.type !== 'radio') {
					$(':radio', this).trigger('click');
				}
				$(this).addClass('selected');
			}
		} );
		//edit 
		$('#editRow').click(function(e) {
			e.preventDefault();
			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function(){
					var no = $(this).attr('kode');
					location.href = "{{url('perbendaharaan/opening-balance/edit')}}" + '/' + no;
				});
			} else {
				swalAlertInit('batal');
			}
		});
    });

    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
</script>
@endpush