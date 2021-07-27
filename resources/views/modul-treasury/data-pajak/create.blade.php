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
                Menu Tambah Perbendaharaan - Data Pajak Tahunan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form method="post" id="form-create">
            <div class="kt-portlet__body">
                <div class="form-group form-group-last">
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            <h5 class="kt-portlet__head-title">
                                Header Menu Tambah - Data Pajak Tahunan
                            </h5>	
                        </div>
                    </div>
                
                    <div class="form-group row">
                    <label for="spd-input" class="col-2 col-form-label">Bulan/Tahun<span style="color:red;">*</span></label>
                    <div class="col-4">
                        <input class="form-control" type="text" value="{{date('m')}}"   name="bulan" size="2" maxlength="2" readonly style="background-color:#DCDCDC; cursor:not-allowed">						
                    </div>
                        <div class="col-6" >
                            <input class="form-control" type="text" value="{{date('Y')}}"   name="tahun" size="4" maxlength="4" readonly style="background-color:#DCDCDC; cursor:not-allowed">
                            <input class="form-control" type="hidden" value="{{Auth::user()->userid}}"  name="userid" autocomplete='off'>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pegawai<span style="color:red;">*</span></label>
                        <div class="col-10">
                            <select name="nopek" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Pegawai Harus Diisi..')" onchange="setCustomValidity('')">
                                <option value="">- Pilih -</option>
                                @foreach($data_pegawai as $data)
                                <option value="{{$data->nopeg}}">{{$data->nopeg}} -- {{$data->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Jenis<span style="color:red;">*</span></label>
                        <div class="col-10">
                            <select name="jenis" class="form-control select2" style="width: 100% !important;" required oninvalid="this.setCustomValidity('Jenis Harus Diisi..')" onchange="setCustomValidity('')">
                                <option value="">-Pilih Jenis-</option>
                                <option value="24">Bonus</option>
                                <option value="25">THR</option>
                                <option value="39">UTD</option>
                                <option value="40">Tantiem</option>
                                <option value="41">Tab.Akhir Kontrak</option>
                                <option value="42">ONH</option>
                                <option value="43">Dinas</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Nilai</label>
                        <div class="col-10">
                            <input class="form-control" name="nilai" type="text" value="" size="25" maxlength="25" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ','); setCustomValidity('')" autocomplete='off'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jenis-dinas-input" class="col-2 col-form-label">Pajak</label>
                        <div class="col-10">
                            <input class="form-control" name="pajak" type="text" value="" size="25" maxlength="25" oninput="this.value = this.value.replace(/[^0-9\-]+/g, ','); setCustomValidity('')" autocomplete='off'>
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

        $('#form-create').submit(function(){
            $.ajax({
                url  : "{{route('data_pajak.store')}}",
                type : "POST",
                data : $('#form-create').serialize(),
                dataType : "JSON",
                headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success : function(data){
                console.log(data);
                if(data == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Ditambah',
                        text: 'Berhasil',
                        timer: 2000
                    }).then(function() {
                        window.location.href = "{{ route('data_pajak.index') }}";
                    });
                }else{
                    Swal.fire({
                        icon: 'info',
                        title: 'Data Yang Diinput Sudah Ada.',
                        text: 'Failed',
                    });
                }
                }, 
                error : function(){
                    alert("Terjadi kesalahan, coba lagi nanti");
                }
            });	
            return false;
        });
    });
    
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }

        return true;
    }
</script>
@endpush