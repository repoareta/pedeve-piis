<div class="card card-custom">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-user text-primary"></i>
            </span>
            <h3 class="card-label">
                Penghargaan
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(600)->tambah == 1)
                <a href="{{ route('modul_sdm_payroll.master_pegawai.penghargaan.create', ['pegawai' => $pegawai->nopeg]) }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRowPenghargaan"></i>
                    </span>
                </a>
                @endif
                @if (permission(600)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRowPenghargaan"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="table_penghargaan">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NAMA</th>
                            <th>TANGGAL</th>
                            <th>PEMBERI</th>
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
        var t = $('#table_penghargaan').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_sdm_payroll.master_pegawai.penghargaan.index.json', ['pegawai' => $pegawai->nopeg]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button text-center', width: '10'},
                {data: 'nama', name: 'nama'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'pemberi', name: 'pemberi'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#editRowPenghargaan').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    const tanggal = $(this).data('tanggal');
                    const nama = $(this).data('nama');

                    var url = `{{ route("modul_sdm_payroll.master_pegawai.penghargaan.edit", ['pegawai' => $pegawai->nopeg, 'tanggal' => ':tanggal', 'nama' => ':nama']) }}`;
                    // go to page edit
                    window.location.href = url.replace(':tanggal', tanggal).replace(':nama', nama);
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deleteRowPenghargaan').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_penghargaan]').is(':checked')) {
                $("input[name=radio_penghargaan]:checked").each(function() {
                    var tanggal = $(this).data('tanggal');
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
                        text: "Nama Penghargaan: " + nama,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('modul_sdm_payroll.master_pegawai.penghargaan.delete', ['pegawai' => $pegawai->nopeg]) }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "tanggal": tanggal,
                                    "nama": nama,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Penghargaan ' + nama,
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
