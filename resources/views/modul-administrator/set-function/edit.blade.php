@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Tambah Set Function
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <div class="form-group mb-8">
                    <div class="alert alert-custom alert-default" role="alert">
                        <div class="alert-text">Header Set Function</div>
                    </div>
                </div>
                <form class="form" id="formSetFunction" action="{{ route('modul_administrator.set_function.update', $user_pdv->userid) }}" method="POST">
					@csrf
					<div class="form-group row">
						<label for="userid-input" class="col-2 col-form-label">User ID</label>
						<div class="col-10">
							<input class="form-control" type="text" name="userid" id="userid" value="{{ $user_pdv->userid }}" style="background-color:#DCDCDC; cursor:not-allowed" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label for="usernm-input" class="col-2 col-form-label">User Name</label>
						<div class="col-10">
							<input class="form-control" type="text" name="usernm" id="usernm" value="{{ $user_pdv->usernm }}" style="background-color:#DCDCDC; cursor:not-allowed" readonly>
						</div>
					</div>
                    <div class="form-group row">
                        <label for="gcg-jabatan-input" class="col-2 col-form-label">Menu ID</label>
                        <div class="col-10">
                            <select class="form-control select2" name="menuid" id="menuid">	
                                <option value="">- Pilih Data -</option>							
                                @foreach ($user_menus as $menu)
                                    <option value="{{ $menu->menuid }}">{{ $menu->menuid }} - {{ $menu->menunm }} - Tambah[{{ $menu->tambah }}] Ubah[{{ $menu->rubah }}] Hapus[{{ $menu->hapus }}] Cetak[{{ $menu->cetak }}] Lihat[{{ $menu->lihat }}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user-app-input" class="col-2 col-form-label">Privileges</label>
                        <div class="col-10 col-form-label">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="tambah" id="tambah" value="1">
                                <span></span>Tambah</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="ubah" id="ubah" value="1">
                                <span></span>Ubah</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="hapus" id="hapus" value="1">
                                <span></span>Perbendaharaan</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="cetak" id="cetak" value="1">
                                <span></span>Umum</label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="lihat" id="lihat" value="1">
                                <span></span>SDM</label>
                            </div>
                        </div>
                    </div>

					<div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a href="{{ url()->previous() }}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i> Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                        </div>
                    </div>
				</form>
            </div>
        </div>        
    </div>
</div>

@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\SetFunctionUpdate', '#formSetFunction'); !!}
<script>
    $(document).ready(function () {
        

        $("#formSetFunction").on('submit', function(e){            
                e.preventDefault();

                if($(this).valid()) {
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: "Apakah anda yakin mau menyimpan data ini?",
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value == true) {
                        console.log(result);
                        $(this).unbind('submit').submit();
                    }
                });
            }
        });

        $("#menuid").on("change", function(){
			var userid = $('#userid').val();
			var menuid = $(this).val();

			$.ajax({
				url : "{{ route('modul_administrator.set_function.menuid.json') }}",
				type : "POST",
				dataType: 'json',
				data : {
					menuid:menuid,
					userid:userid
					},
				headers: {
					'X-CSRF-Token': '{{ csrf_token() }}',
					},
				success : function(data){
					if (data.tambah == 1) {
						$("#tambah").each(function() {
							this.checked=true;
						});
					}else{
						$("#tambah").each(function() {
							this.checked=false;
						});
					}
					if (data.rubah == 1) {
						$("#ubah").each(function() {
							this.checked=true;
						});
					}else{
						$("#ubah").each(function() {
							this.checked=false;
						});
					}
					if (data.hapus == 1) {
						$("#hapus").each(function() {
							this.checked=true;
						});
					}else{
						$("#hapus").each(function() {
							this.checked=false;
						});
					}
					if (data.cetak == 1) {
						$("#cetak").each(function() {
							this.checked=true;
						});
					}else{
						$("#cetak").each(function() {
							this.checked=false;
						});
					}
					if (data.lihat == 1) {
						$("#lihat").each(function() {
							this.checked=true;
						});
					}else{
						$("#lihat").each(function() {
							this.checked=false;
						});
					}
				},
				error : function(){
					alert("Ada kesalahan controller!");
				}
			})
		});

    });
    
</script>
@endpush
