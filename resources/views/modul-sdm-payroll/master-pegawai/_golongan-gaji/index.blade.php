<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Golongan Gaji
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.golongan_gaji.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowGolonganGaji"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowGolonganGaji"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_golongan_gaji">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>GOLONGAN GAJI</th>
                            <th>TANGGAL</th>
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

        var t = $('#table_golongan_gaji').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.golongan_gaji.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'golgaji', name: 'golgaji'},
                {data: 'tanggal', name: 'tanggal'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#editRowGolonganGaji').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    const golongan_gaji = $(this).data('golgaji');
                    const tanggal = $(this).data('tanggal');

                    var url = `{{ route("modul_sdm_payroll.master_pegawai.golongan_gaji.edit", ['pegawai' => $pegawai->nopeg, 'golongan_gaji' => ':golongan_gaji', 'tanggal' => ':tanggal']) }}`;
                    // go to page edit
                    window.location.href = url.replace(':golongan_gaji', golongan_gaji)
                                                .replace(':tanggal', tanggal);
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deleteRowGolonganGaji').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_golongan_gaji]').is(':checked')) {
                $("input[name=radio_golongan_gaji]:checked").each(function() {
                    var nopeg = "{{ $pegawai->nopeg }}";
                    var golongan_gaji = $(this).data('golgaji');
                    var tanggal = $(this).data('tanggal');

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Nama Golongan Gaji: " + golongan_gaji,
                        type: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.golongan_gaji.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "nopeg": nopeg,
                                    "golongan_gaji": golongan_gaji,
                                    "tanggal": tanggal,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        type  : 'success',
                                        title : 'Hapus Detail Golongan Gaji ' + golongan_gaji,
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
