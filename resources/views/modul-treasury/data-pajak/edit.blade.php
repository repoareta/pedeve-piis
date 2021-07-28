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
                Menu Edit Perbendaharaan - Data Pajak Tahunan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="post" id="form-edit">
            <div class="kt-portlet__body">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            <h5 class="kt-portlet__head-title">
                                Header Menu Edit - Data Pajak Tahunan
                            </h5>	
                        </div>
                    </div>
                
                    <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Bulan/Tahun<span style="color:red;">*</span></label>
                    <div class="col-4">
                        <input class="form-control" type="text" value="{{ $bulan }}" name="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                    </div>
                        <div class="col-6" >
                            <input class="form-control" type="text" name="tahun" readonly style="background-color:#DCDCDC; cursor:not-allowed" value="{{ $tahun }}">
                            <input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete="off">
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pegawai<span style="color:red;">*</span></label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Pegawai Harus Diisi..')" onchange="setCustomValidity('')" disabled>
                                <option value="">- Pilih -</option>
                                @foreach($data_pegawai as $data)
                                <option value="{{ $data->nopeg }}" {{ $nopek == $data->nopeg ? 'selected' : null }}>{{ $data->nopeg }} -- {{ $data->nama }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="nopek" value="{{ $nopek }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Jenis<span style="color:red;">*</span></label>
                        <div class="col-10">
                            <select class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Jenis Harus Diisi..')" onchange="setCustomValidity('')" disabled>
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
                            <input class="form-control" name="nilai" type="text" value="{{ number_format($nilai ,2 ,'.' ,'') }}" size="25" maxlength="25" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ','); setCustomValidity('')" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pajak</label>
                        <div class="col-10">
                            <input class="form-control" name="pajak" type="text" value="{{ number_format($pajak, 2,'.' ,'') }}" size="25" maxlength="25" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ','); setCustomValidity('')" autocomplete="off">
                        </div>
                    </div>
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-10">
                                <a  href="{{route('data_pajak.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Cancel</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Save</button>
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
        $('.kt-select2').select2();

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