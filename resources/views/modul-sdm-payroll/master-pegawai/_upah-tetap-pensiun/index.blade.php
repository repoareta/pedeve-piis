<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Upah Tetap Pensiun
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.upah_tetap_pensiun.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowUpahTetapPensiun"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowUpahTetapPensiun"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_upah_tetap_pensiun">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>UPAH PENSIUN</th>
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('detail-scripts')
<script type="text/javascript">
	$(document).ready(function () {

        var t = $('#table_upah_tetap_pensiun').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.upah_tetap_pensiun.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'ut', name: 'ut'},
                {data: 'mulai', name: 'mulai'},
                {data: 'sampai', name: 'sampai'},
                {data: 'keterangan', name: 'keterangan'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#deleteRowUpahTetapPensiun').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_upah_tetap_pensiun]').is(':checked')) {
                $("input[name=radio_upah_tetap_pensiun]:checked").each(function() {
                    var ut = $(this).data('ut');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Upah Tetap Pensiun: " + ut,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.upah_tetap_pensiun.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "ut": ut,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Upah Tetap Pensiun ' + ut,
                                        text  : 'Success',
                                        timer : 2000
                                    }).then(function() {
                                        t.ajax.reload();
                                    });
                                },
                                error: function () {
                                    alert("Terjadi kesalahan, coba lagi nanti");
                                }
                            });
                        }
                    });
                });
            } else {
                swalAlertInit('hapus');
            }
        });

        $('#editRowUpahTetapPensiun').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) { 
                $("input[type=radio]:checked").each(function() {
                    var nilai = $(this).data('ut');
                    var url = "{{ route('modul_sdm_payroll.master_pegawai.upah_tetap_pensiun.edit', ['pegawai' => $pegawai->nopeg, ':nilai']) }}";
                    // go to page edit
                    window.location.href = url.replace(":nilai", nilai);
                });
            } else {
                swalAlertInit('ubah');
            }
        });

    });
</script>
@endpush
