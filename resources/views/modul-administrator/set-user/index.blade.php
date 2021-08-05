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
            Set User
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="{{ route('modul_administrator.set_user.create') }}">
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
                    <a href="#">
                        <span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
                            <i class="fas icon-2x fa-print text-info" id="exportRow"></i>
                        </span>                    
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>USER ID</th>
                            <th>USER NAME  </th>
                            <th>USER GROUP </th>
                            <th>USER LEVEL</th>
                            <th>USER APPLICATION</th>
                            <th>RESET PASSWORD</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cetak Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form" action="{{ route('modul_administrator.set_user.export') }}" method="post" target="_blank">
			@csrf
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-12">
							<div class="radio-inline">
								<label class="radio radio-outline radio-primary">
									<input type="radio" name="cetak" value="A" onclick="displayResult(1)" checked/> Cetak All
									<span></span>
								</label>
								<label class="radio radio-outline radio-primary">
									<input type="radio" name="cetak" value="B" onclick="displayResult(2)" /> Cetak Per User
									<span></span>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-8" id="userid">
							<select name="userid"  class="form-control selectpicker" data-live-search="true" oninvalid="this.setCustomValidity('Dibayar Kepada Harus Diisi..')" onchange="setCustomValidity('')">
								@foreach ($data as $row)
								<option value="{{ $row->userid }}">{{ $row->userid }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply" aria-hidden="true"></i> Batal</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Cetak Data</button>
					</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal End -->
@endsection
@push('page-scripts')
<script type="text/javascript">
    $(document).ready(function () {
            // Datatable
            var t = $('#kt_table').DataTable({
                scrollX   : true,
                processing: true,
                serverSide: true,
                ajax      : {
                            url: "{{ route('modul_administrator.set_user.index.json') }}",
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
                    {data: 'userid', name: 'userid'},
                    {data: 'usernm', name: 'usernm'},
                    {data: 'kode', name: 'kode'},
                    {data: 'userlv', name: 'userlv'},
                    {data: 'userap', name: 'userap'},
                    {data: 'reset', name: 'reset'},
                ]
            });

            // delete
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
                                text: "Jenis  : " +kode,
                                icon: 'warning',
                                showCancelButton: true,
                                reverseButtons: true,
                                confirmButtonText: 'Ya, hapus',
                                cancelButtonText: 'Batalkan'
                            })
                            .then((result) => {
                            if (result.value) {
                                $.ajax({
                                    url: "{{ route('modul_administrator.set_user.delete') }}",
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        "kode": kode,
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            icon  : 'success',
                                            text : "Data Set User dengan jenis  : " +kode+" Berhasil Dihapus.",
                                            title  : 'Berhasil',
                                            
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
    
            //edit 
            $('#editRow').click(function(e) {
                e.preventDefault();
    
                if($('input[class=btn-radio]').is(':checked')) { 
                    $("input[class=btn-radio]:checked").each(function(){
                        var no = $(this).attr('kode');
                        location.replace("{{url('administrator/set-user/edit')}}"+ '/' +no);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    
            $('#exportRow').click(function(e) {
                e.preventDefault();
                    $('#cetakModal').modal('show');
                    $('#userid').hide();
            });
    
        });
        function displayResult(cetak){ 
            if(cetak == 1)
            {
                $('#userid').val(1);
                $('#userid').hide();
            }else{
                $('#userid').val("");
                $('#userid').show();
            }
        }    
    </script>
@endpush
