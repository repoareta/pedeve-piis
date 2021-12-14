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
                                <td>{{ $sosialisasi->keterangan }}</td>
                                <td>
                                    @foreach ($sosialisasi->dokumen as $file)
                                        <span class="badge badge-primary mb-3" onclick="getReader({{ auth()->user()->nopeg }})">{{ $file->dokumen }}</span>
                                    @endforeach
                                </td>
                                <td>{{ Carbon\Carbon::parse($sosialisasi->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ $sosialisasi->pekerja->nama }}</td>
                                <td>
                                    @foreach ($sosialisasi->reader as $reader)
                                        {{ $reader->nopeg }}
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pernyataan Sosialisasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Dengan ini saya menyatakan akan dan telah membaca serta memahami isi dari materi yang disampaikan.
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="setReader()">Konfirmasi</button>
        </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
	$(document).ready(function () {
		$('#kt_table').DataTable();
	});

    function getReader(nopeg) {
        $('#myModal').modal('show');
    }
</script>
@endpush
