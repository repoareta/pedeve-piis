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
            Set Function
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <a href="#">
                        <span class="text-warning pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                            <i class="fas icon-2x fa-edit text-warning" id="editRow"></i>
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
                searching: true,
                lengthChange: true,
                pageLength: 200,
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
                },
                ajax      : {
                            url: "{{ route('modul_administrator.set_menu.index.json') }}",
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
                ]
            });
            $('#search-form').on('submit', function(e) {
                t.draw();
                e.preventDefault();
            });
            $('#kt_table tbody').on( 'click', 'tr', function (event) {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                } else {
                    t.$('tr.selected').removeClass('selected');
                    // $(':radio', this).trigger('click');
                    if (event.target.type !== 'radio') {
                        $(':radio', this).trigger('click');
                    }
                    $(this).addClass('selected');
                }
            } );
    
            //edit 
            $('#editRow').click(function(e) {
                e.preventDefault();
    
                if($('input[class=btn-radio]').is(':checked')) { 
                    $("input[class=btn-radio]:checked").each(function(){
                        var no = $(this).attr('kode');
                        location.replace("{{url('administrator/set-function/edit')}}"+ '/' +no);
                    });
                } else {
                    swalAlertInit('ubah');
                }
            });
    
        });
    
    </script>
@endpush
