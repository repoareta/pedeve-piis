<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Pendidikan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.pendidikan.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowPendidikan"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowPendidikan"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_pendidikan">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>PENDIDIKAN</th>
                            <th>TEMPAT PENDIDIKAN</th>
                            <th>NAMA PT</th>
                            <th>CATATAN</th>
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
        var t = $('#table_pendidikan').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.pendidikan.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'mulai', name: 'mulai'},
                {data: 'tgllulus', name: 'tgllulus'},
                {data: 'kodedidik', name: 'kodedidik'},
                {data: 'tempatdidik', name: 'tempatdidik'},
                {data: 'namapt', name: 'namapt'},
                {data: 'catatan', name: 'catatan'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#deleteRowPendidikan').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_pekerja_pendidikan]').is(':checked')) {
                $("input[name=radio_pekerja_pendidikan]:checked").each(function() {
                    var mulai = $(this).data('mulai');
                    var tempatdidik = $(this).data('tempatdidik');
                    var kodedidik = $(this).data('kodedidik');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Nama : " + tempatdidik,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.pendidikan.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "mulai"      : mulai,
                                    "tempatdidik": tempatdidik,
                                    "kodedidik"  : kodedidik,
                                    "_token"     : "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Pendidikan ' + tempatdidik,
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

    });
</script>
@endpush
