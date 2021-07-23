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
                Tabel Master Pekerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_kontroler.master_pekerja.create') }}">
					<span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
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
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NOPEK</th>
                            <th>NAMA PEKERJA </th>
                            <th>Perusahaan </th>
                            <th>UNIT</th>
                            <th>STATUS</th>
                            <th>TGL. LAHIR </th>
                            <th>TGL. PENSIUN </th>
                            <th>UNIT LALU </th>
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
	$('#kt_table').DataTable({
			scrollX   : true,
			processing: true,
			serverSide: true,
			searching: true,
			lengthChange: true,
			language: {
			processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
			},
			ajax      : "{{ route('modul_kontroler.master_pekerja.index.json') }}",
			columns: [
				{data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
				{data: 'nopek', name: 'nopek'},
				{data: 'namaprshn', name: 'namaprshn'},
				{data: 'nama', name: 'nama'},
				{data: 'unit', name: 'unit'},
				{data: 'status', name: 'status'},
				{data: 'tgllahir', name: 'tgllahir'},
				{data: 'tglpensiun', name: 'tglpensiun'},
				{data: 'unitlalu', name: 'unitlalu'}
			]
			
	});
	

	//edit 
	$('#editRow').click(function(e) {
		e.preventDefault();

		if($('input[class=btn-radio]').is(':checked')) { 
			$("input[class=btn-radio]:checked").each(function(){
				var kode = $(this).attr('kode');
				location.replace("{{url('kontroler/master_pekerja/edit')}}"+ '/' +kode);
			});
		} else {
			swalAlertInit('ubah');
		}
	});

	//delete
	$('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[class=btn-radio]').is(':checked')) { 
				$("input[class=btn-radio]:checked").each(function() {
					var kode = $(this).attr('kode');
					// delete stuff
					const swalWithBootstrapButtons = Swal.mixin({
						customClass: {
							confirmButton: 'btn btn-primary',
							cancelButton: 'btn btn-danger'
						},
							buttonsStyling: false
						})
						swalWithBootstrapButtons.fire({
							title: "Data yang akan dihapus?",
							text: "Kode Perusahaan: " + kode,
							type: 'warning',
							showCancelButton: true,
							reverseButtons: true,
							confirmButtonText: 'Ya, hapus',
							cancelButtonText: 'Batalkan'
						})
						.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_kontroler.master_pekerja.delete') }}",
								type: 'DELETE',
								dataType: 'json',
								data: {
									"kode": kode,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										type  : 'success',
										title : 'Hapus data Perusahaan Dengan Kode : ' + kode,
										text  : 'Berhasil',
										timer : 2000
									}).then(function() {
										location.reload();
									});
								},
								error: function () {
									alert("Terjadi kesalahan, coba lagi nanti");
								}
								});
							}
						});
				});
			} else {
				swalAlertInit('hapus');
			}
			
		});


});
</script>
@endpush