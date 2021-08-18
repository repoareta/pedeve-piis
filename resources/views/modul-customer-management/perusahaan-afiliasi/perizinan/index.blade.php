<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-files-and-folders text-primary"></i>
        </span>
        <h3 class="card-label">
            Perizinan
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <a href="{{ route('modul_cm.perusahaan_afiliasi.perizinan.create', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}">
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                    <i class="fas fa-2x fa-plus-circle text-success"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                    <i class="fas fa-2x fa-edit text-warning" id="editPerizinan"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                    <i class="fas fa-2x fa-times-circle text-danger" id="deletePerizinan"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="kt_table_perizinan">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Keterangan</th>
                        <th>Nomor</th>
                        <th>Masa Berlaku Akhir</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('perizinan_script')
<script type="text/javascript">
	$(document).ready(function () {
        var t = $('#kt_table_perizinan').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_cm.perusahaan_afiliasi.perizinan.index.json', ['perusahaan_afiliasi' => $perusahaan_afiliasi]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'nomor', name: 'tmt_dinas'},
                {data: 'masa_berlaku_akhir', name: 'masa_berlaku_akhir'},
                {data: 'dokumen', name: 'dokumen'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#editPerizinan').click(function(e) {
            e.preventDefault();

            if($('input[name=radio_perizinan]').is(':checked')) { 
                $("input[name=radio_perizinan]:checked").each(function() {
                    // get value from row					
                    var id = $(this).val();

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.perizinan.edit', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'perizinan' => ':id',
                        ]) }}";

                    location.href = url.replace(':id', id);	
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deletePerizinan').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_perizinan]').is(':checked')) { 
                $("input[name=radio_perizinan]:checked").each(function() {
                    var id = $(this).val();
                    var nama = $(this).attr('nama');

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.perizinan.delete', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'perizinan' => ':id',
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
                        text: "Perizinan : " + nama,
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
                                        title : 'Hapus Detail Perizinan ' + nama,
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