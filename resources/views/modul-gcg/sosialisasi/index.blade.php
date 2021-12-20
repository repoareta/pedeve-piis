@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')

<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Sosialisasi
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                <a href="{{ route('modul_gcg.sosialisasi.create') }}">
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
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th>

                            </th>
                            <th>
                                KETERANGAN
                            </th>
                            <th>
                                DOKUMEN
                            </th>
                            <th>
                                TANGGAL DIBUAT
                            </th>
                            <th>
                                DIBUAT OLEH
                            </th>
                            <th>
                                DIBACA OLEH
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sosialisasi_list as $sosialisasi)
                            <tr>
                                <td>
                                    <label class="radio radio-outline radio-outline-2x radio-primary">
                                        <input type="radio" name="radio_sosialisasi" id="radio_sosialisasi" value="{{ $sosialisasi->id }}"><span></span>
                                    </label>
                                </td>
                                <td>{{ $sosialisasi->keterangan }}</td>
                                <td>
                                    @foreach ($sosialisasi->dokumen as $file)
                                        <span class="badge badge-primary mb-3" onclick="getReader('{{ auth()->user()->nopeg }}', '{{ $sosialisasi->id }}', '{{ asset('sosialisasi/'.$sosialisasi->id.'/'.$file->dokumen) }}')">{{ $file->dokumen }}</span>
                                    @endforeach
                                </td>
                                <td>{{ Carbon\Carbon::parse($sosialisasi->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ $sosialisasi->pekerja->nama }}</td>
                                <td>
                                    @foreach ($sosialisasi->reader as $reader)
                                        <span class="badge badge-success mb-3" data-nopeg="{{ $reader->nopeg }}">
                                            {{ $reader->pekerja->nama }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pernyataan Sosialisasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i aria-hidden="true" class="ki ki-close"></i>
            </button>
        </div>
        <div class="modal-body">
            Dengan ini saya menyatakan telah membaca serta memahami isi dari materi yang disampaikan.
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="setReader()" id="konfirmasi">Konfirmasi</button>
        </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var t = $('#kt_table').DataTable();

        $('#editRow').click(function(e) {
			e.preventDefault();
			if($('input[type=radio]').is(':checked')) {
				$("input[type=radio]:checked").each(function() {
					var sosialisasi = $(this).val();
					var url = '{{ route("modul_gcg.sosialisasi.edit", ":sosialisasi") }}';
					// go to page edit
					window.location.href = url.replace(':sosialisasi',sosialisasi);
				});
			} else {
				swalAlertInit('ubah');
			}
		});

        $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[name=radio_sosialisasi]').is(':checked')) { 
                $("input[name=radio_sosialisasi]:checked").each(function() {
                    var id = $(this).val();

                    var url = "{{ route('modul_gcg.sosialisasi.delete', ':sosialisasi') }}";

                    url = url.replace(":sosialisasi", id);
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                        buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                        title: "Data yang akan dihapus?",
                        text: "Id Sosialiasasi : " + id,
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
                                        title : 'Hapus Detail Sosialisasi : ' + id,
                                        text  : 'Berhasil',
                                        timer : 2000
                                    }).then(function() {
                                        location.reload();
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

    function getReader(nopeg, sosialisasi_id, url) {
        // cek sebelumnya sudah pernah menjadi reader
        // jika sudah langsung download file
        // jika belum maka tampilkan show modal
        $.ajax({
            url: "{{ route('modul_gcg.sosialisasi.reader.check') }}",
            type: "POST",
            data: {
                nopeg: nopeg,
                sosialisasi_id: sosialisasi_id,
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(response){
                if(response.success == true){
                    window.open(url, '_blank');
                } else {
                    $('#myModal').modal('show');
                    $('#konfirmasi').data('nopeg', nopeg);
                    $('#konfirmasi').data('sosialisasi_id', sosialisasi_id);
                    $('#konfirmasi').data('url', url);
                }
            }
        });
    }

    function setReader() {

        var nopeg = $('#konfirmasi').data('nopeg');
        var sosialisasi_id = $('#konfirmasi').data('sosialisasi_id');
        var url = $('#konfirmasi').data('url');

        $.ajax({
            url: "{{ route('modul_gcg.sosialisasi.reader.store') }}",
            type: "POST",
            data: {
                nopeg: nopeg,
                sosialisasi_id: sosialisasi_id,
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(response){
                if(response.success == true){
                    $('#myModal').modal('hide');

                    window.open(url, '_blank');
                } else {
                    alert('error, coba lagi nanti');
                }
            }
        });
    }
</script>
@endpush
