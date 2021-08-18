<div class="card-header justify-content-start">
    <div class="card-title">
        <span class="card-icon">
            <i class="flaticon2-chart2 text-primary"></i>
        </span>
        <h3 class="card-label">
            Pemegang Saham
        </h3>
    </div>
    <div class="card-toolbar">
        <div class="float-left">
            <a href="{{ route('modul_cm.perusahaan_afiliasi.pemegang_saham.create', ['perusahaan_afiliasi' => $perusahaan_afiliasi->id]) }}">
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                    <i class="fas fa-2x fa-plus-circle text-success"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                    <i class="fas fa-2x fa-edit text-warning" id="editPemegangSaham"></i>
                </span>
            </a>
            <a href="#">
                <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                    <i class="fas fa-2x fa-times-circle text-danger" id="deletePemegangSaham"></i>
                </span>
            </a>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xl-12">
            <table class="table table-bordered" id="kt_table_pemegang_saham">
                <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Nama PT</th>
                        <th>% Kepemilikan</th>
                        <th>Jumlah Lembar Saham</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>


@section('pemegang_saham_script')
<script type="text/javascript">
	$(document).ready(function () {
        var t = $('#kt_table_pemegang_saham').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('modul_cm.perusahaan_afiliasi.pemegang_saham.index.json', ['perusahaan_afiliasi' => $perusahaan_afiliasi]) }}",
            columns: [
                {data: 'radio', name: 'radio', class:'radio-button'},
                {data: 'nama', name: 'nama'},
                {data: 'kepemilikan', name: 'kepemilikan'},
                {data: 'jumlah_lembar_saham', name: 'jumlah_lembar_saham'}
            ],
            order: [[ 0, "asc" ], [ 1, "asc" ]]
        });

        $('#kt_table_pemegang_saham tbody').on( 'click', 'tr', function (event) {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
                $('#kt_table_pemegang_saham tbody tr.selected').removeClass('selected');
                // $(':radio', this).trigger('click');
                if (event.target.type !== 'radio') {
                    $(':radio', this).trigger('click');
                }
                $(this).addClass('selected');
            }
        });

        $('#editPemegangSaham').click(function(e) {
            e.preventDefault();

            if($('input[name=radio_pemegang_saham]').is(':checked')) { 
                $("input[name=radio_pemegang_saham]:checked").each(function() {
                    // get value from row					
                    var id = $(this).val();

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.pemegang_saham.edit', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'pemegang_saham' => ':id',
                        ]) }}";
                    window.location.href = url.replace(':id', id);				
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deletePemegangSaham').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_pemegang_saham]').is(':checked')) { 
                $("input[name=radio_pemegang_saham]:checked").each(function() {
                    var id = $(this).val();
                    var nama = $(this).attr('nama');

                    var url = "{{ route('modul_cm.perusahaan_afiliasi.pemegang_saham.delete', 
                        [
                            'perusahaan_afiliasi' => $perusahaan_afiliasi,
                            'pemegang_saham' => ':id',
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
                        text: "Pemegang Saham : " + nama,
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
                                        title : 'Hapus Detail Pemegang Saham ' + nama,
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