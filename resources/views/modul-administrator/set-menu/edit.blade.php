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
            User ID : {{ $id }}
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <div class="">
                    <button id="saveForm" class="btn btn-success" data-id="{{ $id }}">
                        <i class="fa fa-check" aria-text="true"></i> Save
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-warning">
                        <i class="fa fa-reply" aria-text="true"></i> Cancel
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
                            <th>
                                Ability All<br>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" id="checkBoxAll">
                                    <span></span>
                                </label>
                            </th>
                            <th>MENU ID</th>
                            <th>MENU NAME</th>
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
                    url : '{!! url()->current() !!}'
                },
                columns: [
                    {data: 'checkbox', name: 'checkbox'},
                    {data: 'menuid', name: 'menuid'},
                    {data: 'menunm', name: 'menunm'},
                    {data: 'userap', name: 'userap'},
                ]
            });

            $('#kt_table tbody').on('click', 'tr',function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                } else {
                    t.$('tr.selected').removeClass('selected');
                    
                    if (event.target.type !== 'checkbox') {
                        $(':checkbox', this).trigger('click');
                    }
                    $(this).addClass('selected');
                }
            } );
    
            //edit 
            $("#checkBoxAll").click(function () {
                $('#kt_table tbody .checkbox-menuid').prop('checked', this.checked);
            });
            
            $("#saveForm").click(function(e){            
                e.preventDefault();
                let id = $(this).data("id");
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
                        var checked = $('.checkbox-menuid:checked').map(function() {
                            return this.value;
                        }).get();
                        $.ajax({
                            method: "POST",
                            url:"{{ url('administrator/set-menu/update') }}" + '/' + id,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'menus': checked,                                    
                            },
                            success: function(response){
                                // console.log('aaa');
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil',
                                    text: "Data Berhasil Disimpan",
                                    icon: 'success',
                                    timer: 3000,
                                    confirmButtonText: 'Ya',
                                    reverseButtons: true
                                })
                                // console.log(response);
                                window.location.replace(response);
                            }
                        });
                    }
                });
        });
        });
    
    </script>
@endpush
