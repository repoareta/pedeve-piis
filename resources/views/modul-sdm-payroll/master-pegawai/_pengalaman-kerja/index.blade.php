<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Pengalaman Kerja
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.pengalaman_kerja.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowPengalamanKerja"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowPengalamanKerja"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_pengalaman_kerja">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>MULAI</th>
                            <th>SAMPAI</th>
                            <th>INSTANSI</th>
                            <th>PANGKAT</th>
                            <th>KOTA</th>
                            <th>NEGARA</th>
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
        var t = $('#table_pengalaman_kerja').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.pengalaman_kerja.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'mulai', name: 'mulai'},
                {data: 'sampai', name: 'sampai'},
                {data: 'instansi', name: 'instansi'},
                {data: 'pangkat', name: 'pangkat'},
                {data: 'kota', name: 'kota'},
                {data: 'negara', name: 'negara'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#deleteRowPengalamanKerja').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_pengalaman_kerja]').is(':checked')) {
                $("input[name=radio_pengalaman_kerja]:checked").each(function() {
                    var mulai = $(this).data('mulai');
                    var pangkat = $(this).data('pangkat');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Nama Pangkat : " + pangkat,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.pengalaman_kerja.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "mulai": mulai,
                                    "pangkat": pangkat,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        type  : 'success',
                                        title : 'Hapus Detail Pengalaman Kerja ' + pangkat,
                                        icon  : 'Success',
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
