@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@push('page-styles')
    <style>
        .picker-switch{
            display: none !important;
        }
        .switch{ visibility: hidden !important; }
        .col-form-label {
            padding-top: unset !important;
            padding-bottom: unset !important;
            margin-bottom: 0;
            font-size: inherit;
            line-height: 1.5;
            margin: auto;
            margin-left: 0;
        }
    </style>
@endpush

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header d-block mt-5">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Log User
            </h3>
        </div>
        <form id="search-form">
            <div class="form-group row">
                <label class="col-xl-1 col-lg-1 col-form-label">Bulan</label>
                <div class="col-lg-3 col-xl-3">
                    <select class="form-control selectpicker" name="bulan" id="bulan" data-live-search="true">	
                        <option value="">- Pilih Data -</option>								                        
                        <option value="1" {{ date('m')  == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ date('m')  == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ date('m')  == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ date('m')  == '04' ? 'selected' : '' }}>April</option>
                        <option value="5" {{ date('m')  == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ date('m')  == '05' ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ date('m')  == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ date('m')  == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ date('m')  == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ date('m')  == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ date('m')  == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ date('m')  == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
                <label class="col-xl-1 col-lg-1 col-form-label">Tahun</label>
                <div class="col-lg-3 col-xl-3">                    
                    <input class="form-control tahun" type="text" name="tahun" value="{{ date('Y') }}" autocomplete="off">                    
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>USER ID</th>
                            <th>USER NAME</th>
                            <th>LOGIN DATE</th>
                            <th>LOGOUT DATE</th>
                            <th>TERMINAL</th>
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
        var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('modul_administrator.log.index.json') }}",
                data: function (d) {
                    d.login_month = $('select[name=bulan]').val();
                    d.login_year = $('input[name=tahun]').val();
                }
            },
            columns: [
                {data: 'userid', name: 'userid'},
                {data: 'usernm', name: 'usernm'},
                {data: 'login', name: 'login'},
                {data: 'logout', name: 'logout'},
                {data: 'terminal', name: 'terminal'},
            ]
        });

        $('#search-form').on('submit', function(e) {
            t.draw();
            e.preventDefault();
        });
    });

</script>
@endpush
