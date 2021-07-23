@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-print text-primary"></i>
            </span>
            <h3 class="card-label">
                Form Cetak 1721-A1 Tahunan
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form action="{{route('laporan_pajak.export.laporan')}}" method="post">
            {{csrf_field()}}
            <div class="form-group form-group-last">
                <div class="form-group row">
                    <label for="jenis-dinas-input" class="col-2 col-form-label">Tahun<span style="color:red;">*</span></label>
                    <div class="col-8">
                        <select name="tahun" class="form-control kt-select2" required oninvalid="this.setCustomValidity('Tahun Harus Diisi..')" onchange="setCustomValidity('')">
                            <option value="">- Pilih -</option>
                            @for ($i = 2004; $i <= date('Y'); $i++)
                            <option value="{{$i}}" <?php if($i == date('Y')) echo 'selected'; ?>>{{$i}}</option>
                            @endfor
                            
                            
                        </select>
                    </div>
                </div>

                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a  href="{{route('data_pajak.index')}}" class="btn btn-warning"><i class="fa fa-reply" aria-hidden="true"></i>Kembali</a>
                            <button type="submit" class="btn btn-primary" onclick="$('form').attr('target', '_blank')"><i class="fa fa-print" aria-hidden="true"></i>Cetak</button>
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

</script>
@endpush