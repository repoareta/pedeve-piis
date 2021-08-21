<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-sheet text-primary"></i>
        </span>
        <h3 class="card-label">
            Akta
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <a href="{{ route('modul_cm.perusahaan_afiliasi.akta.create', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}">
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                    <i class="fas fa-2x fa-plus-circle text-success"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                    <i class="fas fa-2x fa-edit text-warning" id="editAkta"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                    <i class="fas fa-2x fa-times-circle text-danger" id="deleteAkta"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="kt_table_akta">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Jenis</th>
                        <th>Nomor Akta</th>
                        <th>Tanggal</th>
                        <th>Notaris</th>
                        <th>TMT Berlaku</th>
                        <th>TMT Berakhir</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('akta_script')
<script type="text/javascript">
	$(document).ready(function () {

        var t = $('#kt_table_akta').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_cm.perusahaan_afiliasi.akta.index.json', ['perusahaan_afiliasi' => $perusahaan_afiliasi]) }}",
            columns: [
                {data: 'radio', name: 'aksi', orderable: false, searchable: false, class:'radio-button'},
                {data: 'jenis', name: 'jenis'},
                {data: 'nomor_akta', name: 'nomor_akta'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'notaris', name: 'notaris'},
                {data: 'tmt_mulai', name: 'tmt_mulai'},
                {data: 'tmt_akhir', name: 'tmt_akhir'},
                {data: 'dokumen', name: 'dokumen'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#editAkta').click(function(e) {
            e.preventDefault();

            if($('input[name=radio_akta]').is(':checked')) { 
                $("input[name=radio_akta]:checked").each(function() {
                    // get value from row					
                    var id = $(this).val();

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.akta.edit', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'akta' => ':id',
                        ]) }}";

                    location.href = url.replace(':id', id);				
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#kt_table_akta tbody').on( 'click', 'tr', function (event) {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
                $('#kt_table_akta tbody tr.selected').removeClass('selected');
                // $(':radio', this).trigger('click');
                if (event.target.type !== 'radio') {
                    $(':radio', this).trigger('click');
                }
                $(this).addClass('selected');
            }
        });

        $('#deleteAkta').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_akta]').is(':checked')) { 
                $("input[name=radio_akta]:checked").each(function() {
                    var id = $(this).val();
                    var nama = $(this).attr('nama');

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.akta.delete', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'akta' => ':id',
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
                        text: "Akta : " + nama,
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
                                        title : 'Hapus Detail Akta ' + nama,
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