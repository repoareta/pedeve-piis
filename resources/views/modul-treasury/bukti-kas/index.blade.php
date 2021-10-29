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
                Bukti Kas/Bank
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
                @if (permission(501)->tambah == 1)
                <a href="{{ route('penerimaan_kas.create.kas') }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Tambah Data">
                        <i class="fas fa-2x fa-plus-circle text-success"></i>
                    </span>
                </a>
                @endif
                @if (permission(501)->rubah == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Ubah Data">
                        <i class="fas fa-2x fa-edit text-warning" id="editRow"></i>
                    </span>
                </a>
                @endif
                @if (permission(501)->hapus == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                        <i class="fas fa-2x fa-times-circle text-danger" id="deleteRow"></i>
                    </span>
                </a>
                @endif
                @if (permission(501)->cetak == 1)
                <a href="#">
                    <span class="pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
                        <i class="fas fa-2x fa-print text-info" id="exportRow"></i>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-xl-12">
                <form class="form" id="search-form">
                    <div class="form-group row">
                        <label for="" class="col-1 col-form-label">No. Bukti</label>
                        <div class="col-2">
                            <input class="form-control" type="text" name="bukti" value="" size="18" maxlength="18" autocomplete="off">
                        </div>
                        <label for="" class="col-form-label">Bulan</label>
                        <div class="col-2">
                            <select name="bulan" class="form-control select2">
                                <option value="">-- Pilih --</option>
                                <option value="">Periode (Jan - Des)</option>
                                <option value="01" <?php if($bulan == '01') echo 'selected'; ?>>Januari</option>
                                <option value="02" <?php if($bulan == '02') echo 'selected'; ?>>Februari</option>
                                <option value="03" <?php if($bulan == '03') echo 'selected'; ?>>Maret</option>
                                <option value="04" <?php if($bulan == '04') echo 'selected'; ?>>April</option>
                                <option value="05" <?php if($bulan == '05') echo 'selected'; ?>>Mei</option>
                                <option value="06" <?php if($bulan == '06') echo 'selected'; ?>>Juni</option>
                                <option value="07" <?php if($bulan == '07') echo 'selected'; ?>>Juli</option>
                                <option value="08" <?php if($bulan == '08') echo 'selected'; ?>>Agustus</option>
                                <option value="09" <?php if($bulan == '09') echo 'selected'; ?>>September</option>
                                <option value="10" <?php if($bulan == '10') echo 'selected'; ?>>Oktober</option>
                                <option value="11" <?php if($bulan == '11') echo 'selected'; ?>>November</option>
                                <option value="12" <?php if($bulan == '12') echo 'selected'; ?>>Desember</option>
                            </select>
                        </div>

                        <label for="" class="col-form-label">Tahun</label>
                        <div class="col-2">
                            <input class="form-control tahun" type="text" name="tahun" value="{{ $tahun }}" autocomplete="off">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered table-checkable" id="kt_table"
                    width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>NO. DOKUMEN</th>
                            <th>TANGGAL</th>
                            <th>NO. BUKTI</th>
                            <th>KEPADA</th>
                            <th>JK</th>
                            <th>NO. KAS</th>
                            <th>CI</th>
                            <th>KURS</th>
                            <th>NILAI</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="cetakModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="{{ route('penerimaan_kas.export') }}" method="GET" id="formCetakData" target="_blank">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">No Dokumen</label>
                        <div class="col-10">
                            <input class="form-control" type="text" readonly name="no_dokumen" id="no_dokumen">
                        </div>
                    </div>

                    <div class="form-group row" style="margin:0px;">
                        <label for="" class="col-2 col-form-label"></label>
                        <div class="col-5">Nama</div>
                        <div class="col-5">Jabatan</div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Pemeriksaan</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="pemeriksaan_nama" id="pemeriksaan_nama">
                        </div>
                        <div class="col-5">
                            <input class="form-control" type="text" name="pemeriksaan_jabatan" id="pemeriksaan_jabatan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Membukukan</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="membukukan_nama" id="membukukan_nama">
                        </div>
                        <div class="col-5">
                            <input class="form-control" type="text" name="membukukan_jabatan" id="membukukan_jabatan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Kas/Bank</label>
                        <div class="col-5">
                            <input class="form-control" type="text" name="kasbank_nama" id="kasbank_nama">
                        </div>
                        <div class="col-5">
                            <input class="form-control" type="text" name="kasbank_jabatan" id="kasbank_jabatan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-reply"></i> Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Cetak Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    function redirectToApproval(id, cancelation) {
        let approvalUrl = cancelation ? '/cancel-approval' : '/approval';

        location.href = `{{ url('perbendaharaan/penerimaan-kas') }}` + `/${id}` + approvalUrl;
    }

    $(document).ready(function () {
        var keenTable = $('#kt_table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            scrollX: true,
			ajax: {
				url: "{{ route('penerimaan_kas.search') }}",
				type : "POST",
				dataType : "JSON",
				headers: {
				    'X-CSRF-Token': '{{ csrf_token() }}',
				},
				data: function (d) {
					d.bukti = $('input[name=bukti]').val();
					d.bulan = $('select[name=bulan]').val();
					d.tahun = $('input[name=tahun]').val();
				}
			},
			columns: [
				{ data: 'radio', name: 'radio', class:'radio-button text-center', width: '10' },
                { data: 'no_dok', name: 'no_dok' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'voucher', name: 'voucher' },
                { data: 'kepada', name: 'kepada' },
                { data: 'jk', name: 'jk' },
                { data: 'store', name: 'store' },
                { data: 'ci', name: 'ci' },
                { data: 'rate', name: 'rate' },
                { data: 'nilai_dokumen', name: 'nilai_dokumen' },
                { data: 'status', name: 'status', class: 'text-center' },
                { data: 'action', name: 'action', class: 'text-center' },
			]

	    });

        $('#search-form').on('submit', function(e) {
            keenTable.draw();
            e.preventDefault();
        });

        $('#editRow').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function(){
                    var nodok = $(this).val().split("/").join("-");
                    // var nodok = $(this).attr('nodok');
                    location.href = "{{ url('perbendaharaan/penerimaan-kas') }}"+ '/' + nodok + '/edit';
                });
            } else {
                swalAlertInit('ubah');
            }
        });

        $('#deleteRow').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    var nodok = $(this).val();
                    // delete stuff
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-danger'
                        },
                            buttonsStyling: false
                        })
                        swalWithBootstrapButtons.fire({
                            title: "Data yang akan dihapus?",
                            text: "No Dokumen: "+nodok,
                            icon: 'warning',
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batalkan'
                        })
                        .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('penerimaan_kas.delete') }}",
                                type: 'DELETE',
                                dataType: 'json',
                                data: {
                                    "nodok": nodok,
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (data) {
                                    if(data == 1){
                                        Swal.fire({
                                            icon  : 'success',
                                            title : "No Dokumen: "+nodok,
                                            text  : 'Berhasil',
                                            timer : 2000
                                        }).then(function() {
                                            location.reload();
                                        });
                                    }else if(data == 2){
                                        Swal.fire({
                                            icon  : 'info',
                                            title : 'Penghapusan gagal,data tidak dalam status Opening.',
                                            text  : 'Failed',
                                        });
                                    } else {
                                        Swal.fire({
                                            icon  : 'info',
                                            title : 'Sebelum dihapus,status bayar harus dibatalkan dulu.',
                                            text  : 'Failed',
                                        });
                                    }
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

        $('#exportRow').click(function(e) {
            e.preventDefault();
            if($('input[type=radio]').is(':checked')) {
                $("input[type=radio]:checked").each(function() {
                    var id = $(this).val();
                    // open modal
                    $('#cetakModal').modal('show');
                    // fill no_panjar to no_panjar field
                    $('#no_dokumen').val(id);
                });
            } else {
                swalAlertInit('cetak');
            }
        });
    });
</script>
@endpush
