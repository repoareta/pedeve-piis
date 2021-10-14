<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Keluarga
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_sdm_payroll.master_pegawai.keluarga.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editKeluarga"></i>
                    </span>
                </a>
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteKeluarga"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_keluarga">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NAMA KELUARGA</th>
                            <th>STATUS</th>
                            <th>TEMPAT LAHIR</th>
                            <th>TANGGAL LAHIR</th>
                            <th>AGAMA</th>
                            <th>GOLONGAN DARAH</th>
                            <th>PENDIDIKAN (TEMPAT)</th>
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
        var t = $('#table_keluarga').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.keluarga.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'nama', name: 'nama'},
                {data: 'status', name: 'status'},
                {data: 'tempatlahir', name: 'tempatlahir'},
                {data: 'tgllahir', name: 'tgllahir'},
                {data: 'agama', name: 'agama'},
                {data: 'goldarah', name: 'goldarah'},
                {data: 'pendidikan', name: 'pendidikan'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#deleteKeluarga').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_keluarga]').is(':checked')) {
                $("input[name=radio_keluarga]:checked").each(function() {
                    var status = $(this).data('status');
                    var nama = $(this).data('nama');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Nama : " + nama,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.keluarga.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "status": status,
                                    "nama": nama,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Keluarga ' + nama,
                                        text  : 'Berhasil',
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
