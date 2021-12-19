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
                LHKPN
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_gcg.lhkpn.create') }}">
					<span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
						<i class="fas fa-2x fa-plus-circle text-success"></i>
					</span>
				</a>
                <a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
						<i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
					</span>
				</a>
				<a href="#">
					<span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
						<i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
					</span>
				</a>
            </div>
            <a class="btn btn-outline-secondary btn-sm ml-10" href="#" role="button"><i class="fas fa-eye"></i> View as Admin</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>
                                TANGGAL LHKPN
                            </th>
                            <th>
                                DOKUMEN LHKPN
                            </th>
                            <th>
                                TANGGAL DIBUAT
                            </th>
                            <th>
                                STATUS LAPORAN LHKPN
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lhkpn_list as $lhkpn)
                            <tr>
                                <td>
                                    <label class="radio radio-outline radio-outline-2x radio-primary">
                                        <input type="radio" name="radio_gaji_pokok" value="{{ $lhkpn->id }}">
                                        <span></span>
                                    </label>
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($lhkpn->tanggal)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    @foreach ($lhkpn->dokumen as $file)
                                        <a href="{{ asset('lhkpn/'.$file->dokumen) }}" target="_blank"><span class="badge badge-primary mb-3">{{ $file->dokumen }}</span></a>
                                    @endforeach
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($lhkpn->created_at)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    {{ ucfirst($lhkpn->status) }}
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

        $('#editRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var id = $(this).val();
					var url = "{{ route('modul_gcg.lhkpn.edit', ['lhkpn' => ':id']) }}";
					// go to page edit
					window.location.href = url.replace(':id', id);
				});
			} else {
				swalAlertInit('ubah');
			}
		});

        $('#deleteRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var id = $(this).val();
					// delete stuff
					const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-primary',
						cancelButton: 'btn btn-danger'
					},
						buttonsStyling: false
					})

					swalWithBootstrapButtons.fire({
						title: "Hapus data ini?",
						icon: 'warning',
						showCancelButton: true,
						reverseButtons: true,
						confirmButtonText: 'Ya, hapus',
						cancelButtonText: 'Batalkan'
					})
					.then((result) => {
						if (result.value) {
							$.ajax({
								url: "{{ route('modul_gcg.lhkpn.destroy', ['lhkpn' => ':id']) }}".replace(':id', id),
								type: 'DELETE',
								dataType: 'json',
								data: {
									"id": id,
									"_token": "{{ csrf_token() }}",
								},
								success: function () {
									Swal.fire({
										icon  : 'success',
										title : 'Data berhasil dihapus',
										text  : 'Berhasil',
										timer : 2000
									}).then(function() {
										document.location.reload(true);
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
