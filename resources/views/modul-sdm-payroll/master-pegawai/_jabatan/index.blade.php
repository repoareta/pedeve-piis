<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Jabatan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.jabatan.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowJabatan"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowJabatan"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_jabatan">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>BAGIAN</th>
                            <th>JABATAN</th>
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>NO. SKEP</th>
                            <th>TANGGAL SKEP</th>
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
        var t = $('#table_jabatan').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.jabatan.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'bagian', name: 'bagian'},
                {data: 'jabatan', name: 'jabatan'},
                {data: 'mulai', name: 'mulai'},
                {data: 'sampai', name: 'sampai'},
                {data: 'noskep', name: 'noskep'},
                {data: 'tglskep', name: 'tglskep'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#editRowJabatan').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    const mulai = $(this).data('mulai');
                    const kode_bagian = $(this).data('kdbagian');
                    const kode_jabatan = $(this).data('kdjabatan');

                    var url = `{{ route("modul_sdm_payroll.master_pegawai.jabatan.edit", ['pegawai' => $pegawai->nopeg, 'mulai' => ':mulai', 'kode_bagian' => ':kode_bagian', 'kode_jabatan' => ':kode_jabatan']) }}`;
                    // go to page edit
                    window.location.href = url.replace(':mulai', mulai)
                                                .replace(':kode_bagian', kode_bagian)
                                                .replace(':kode_jabatan', kode_jabatan);
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deleteRowJabatan').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_jabatan]').is(':checked')) {
                $("input[name=radio_jabatan]:checked").each(function() {
                    var mulai = $(this).data('mulai');
                    var kdbagian = $(this).data('kdbagian');
                    var kdjabatan = $(this).data('kdjabatan');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Nama Jabatan : " + kdjabatan,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.jabatan.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "mulai": mulai,
                                    "kdbagian": kdbagian,
                                    "kdjabatan": kdjabatan,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Jabatan ' + kdjabatan,
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
