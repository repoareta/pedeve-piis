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
                <i class="flaticon2-pen text-primary"></i>
            </span>
            <h3 class="card-label">
                Menu Edit Perbendaharaan - Data Pajak Tahunan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" id="form-edit">
            <div class="portlet__body">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            <h5 class="portlet__head-title">
                                Header Menu Edit - Data Pajak Tahunan
                            </h5>	
                        </div>
                    </div>
                
                    <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Bulan/Tahun<span class="text-danger">*</span></label>
                    <div class="col-4">
                        <input class="form-control disabled bg-secondary" type="text" value="{{ $bulan }}" name="bulan" size="2" maxlength="2" readonly>
                    </div>
                        <div class="col-6">
                            <input class="form-control disabled bg-secondary tahun" type="text" name="tahun" readonly value="{{ $tahun }}">
                            <input class="form-control" type="hidden" value="{{ Auth::user()->userid }}" name="userid">
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pegawai<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" required disabled>
                                <option value="">- Pilih -</option>
                                @foreach($data_pegawai as $data)
                                <option value="{{ $data->nopeg }}" {{ $nopek == $data->nopeg ? 'selected' : null }}>{{ $data->nopeg }} -- {{ $data->nama }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="nopek" value="{{ $nopek }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Jenis<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" required disabled>
                                <option value="">-Pilih Jenis-</option>
                                <option value="24" @if ($jenis == 24) selected @endif>Bonus</option>
                                <option value="25" @if ($jenis == 25) selected @endif>THR</option>
                                <option value="39" @if ($jenis == 39) selected @endif>UTD</option>
                                <option value="40" @if ($jenis == 40) selected @endif>Tantiem</option>
                                <option value="41" @if ($jenis == 41) selected @endif>Tab.Akhir Kontrak</option>
                                <option value="42" @if ($jenis == 42) selected @endif>ONH</option>
                                <option value="43" @if ($jenis == 43) selected @endif>Dinas</option>
                            </select>
                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Nilai</label>
                        <div class="col-10">
                            <input class="form-control money" name="nilai" type="text" value="{{ $nilai }}" size="25" maxlength="25" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pajak</label>
                        <div class="col-10">
                            <input class="form-control money" name="pajak" type="text" value="{{ $pajak }}" size="25" maxlength="25" autocomplete="off">
                        </div>
                    </div>
                    <div class="form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a href="{{ route('data_pajak.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                            </div>
                        </div>
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
        

        $('#form-edit').submit(function(){
            $.ajax({
                url  : "{{ route('data_pajak.update') }}",
                type : "POST",
                data : $('#form-edit').serialize(),
                dataType : "JSON",
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success : function(data){
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Diubah',
                        text: 'Berhasil',
                        timer: 2000
                    }).then(function() {
                        location.href = "{{ route('data_pajak.index') }}";
                    });
                }, 
                error : function(){
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });	
            return false;
        });
    });
</script>
@endpush