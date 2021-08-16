@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

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
                Batalkan Opening Balance
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" id="form-batal">
            <div class="form-group row">
                <label for="" class="col-2 col-form-label text-right">Tahun<span class="text-danger">*</span></label>
                <div class="col-8">
                    <input class="form-control tahun" type="text" value="{{ $tahun }}" name="tahun" style="background-color:#DCDCDC; cursor:not-allowed" readonly>
                </div>
            </div>
            
            <div class="form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <a href="{{ route('opening_balance.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Proses</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('page-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tabel-detail-permintaan').DataTable({
                scrollX   : true,
                processing: true,
                serverSide: false,
            });
            $('#form-batal').submit(function(){
                $.ajax({
                    url  : "{{ route('opening_balance.update') }}",
                    type : "POST",
                    data : $('#form-batal').serialize(),
                    dataType : "JSON",
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                    success : function(data){
                        if(data == 1){
                            Swal.fire({
                                icon  : 'info',
                                title : '~Opening Balance tidak bisa di batalkan, Opening Balance bulan terakhir harus dibatalkan terlebih dahulu',
                                text  : 'Info',
                            });
                        } else {
                            Swal.fire({
                                icon  : 'success',
                                title : 'Data Berhasil Dibatalkan Dan Opening Balance Terakhir Adalah!~~' +data,
                                text  : 'Berhasil',
                            }).then(function(data) {
                                location.href = "{{ route('opening_balance.index') }}";
                            });
                        }
                    }, 
                    error : function(){
                        alert("Terjadi kesalahan, coba lagi nanti");
                    }
                });	
                return false;
            });
            $('#tanggal').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                autoclose: true,
                language : 'id',
                format   : 'yyyy-mm-dd'
            });
            $('#tanggal2').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                autoclose: true,
                language : 'id',
                format   : 'yyyy-mm-dd'
            });
            $('#tanggal3').datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                autoclose: true,
                language : 'id',
                format   : 'yyyy-mm-dd'
            });
        });
    </script>
@endpush