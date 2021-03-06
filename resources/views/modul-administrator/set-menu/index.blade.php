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
            Set Menu
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="#">
                        <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                            <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                        </span>
                    </a>
                </div>
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
                            <th>USER ID</th>
                            <th>USER NAME</th>
                            <th>USER GROUP</th>
                            <th>USER LEVEL</th>
                            <th>USER APPLICATION</th>
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
                    url: "{{ route('modul_administrator.set_menu.index.json') }}",
                    data: function (d) {
                        d.pencarian = $('input[name=pencarian]').val();
                    }
                },
                columns: [
                    {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                    {data: 'userid', name: 'userid'},
                    {data: 'usernm', name: 'usernm'},
                    {data: 'kode', name: 'kode'},
                    {data: 'userlv', name: 'userlv'},
                    {data: 'userap', name: 'userap'},
                ]
            });
            $('#search-form').on('submit', function(e) {
                t.draw();
                e.preventDefault();
            });
    
            //edit 
            $('#editRow').click(function(e) {
                e.preventDefault();
                if($('input[type=radio]').is(':checked')) { 
                    $("input[type=radio]:checked").each(function() {
                        var id = $('input[type=radio]:checked').val();
                        var url = '{{ route("modul_administrator.set_menu.edit", ":userid") }}';
                        // go to page edit
                        window.location.href = url.replace(':userid',id);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    
        });
    
    </script>
@endpush
