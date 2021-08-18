<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-avatar text-primary"></i>
        </span>
        <h3 class="card-label">
            Direksi
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <a href="{{ route('modul_cm.perusahaan_afiliasi.create') }}">
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                    <i class="fas fa-2x fa-plus-circle text-success"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                    <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                    <i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="kt_table_direksi">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>TMT Dinas</th>
                        <th>Akhir Masa Dinas</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('direksi_script')
<script type="text/javascript">
	$(document).ready(function () {

        var t = $('#kt_table_direksi').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_cm.perusahaan_afiliasi.direksi.index.json', ['perusahaan_afiliasi' => $perusahaan_afiliasi]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button'},
                {data: 'nama', name: 'nama'},
                {data: 'tmt_dinas', name: 'tmt_dinas'},
                {data: 'akhir_masa_dinas', name: 'akhir_masa_dinas'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#deleteDireksi').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_direksi]').is(':checked')) { 
                $("input[name=radio_direksi]:checked").each(function() {
                    var id = $(this).val();
                    var nama = $(this).attr('nama');

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.direksi.delete', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'direksi' => ':id',
                        ]) }}";
                    url = url
                    .replace(':id', id);

                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Direksi : " + nama,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function () {
                                    Swal.fire({
                                        icon  : 'success',
                                        title : 'Hapus Detail Direksi ' + nama,
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
@endsection