@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')
<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Tabel Posisi Saldo Deposito
            </h3>
            <div class="text-right">
                @if($data_akses->hapus == 1)
                <button id="deleteRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
                        <i class="fas icon-2x fa-trash text-danger"></i>
                    </span>
                </button>
                @endif
                @if($data_akses->cetak == 1)
                <button id="exportRow" class="btn p-0">
                    <span class="text-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ubah atau Lihat Data">
                        <i class="fas icon-2x fa-print text-secondary"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body">
        <form class="kt-form" method="post" action="{{ route('perhitungan_bagihasil.index.search')}}" >
			{{csrf_field()}}
            <div class="form-group row col-12">	
                <label for="" class="col-form-label">Tanggal</label>
                <div class="col-2">
                    <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{$date}}" size="10" maxlength="10" onkeypress="return hanyaAngka(event)" autocomplete='off'>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered table-hover table-checkable" id="kt_table" width="100%">
			<thead class="thead-light">
				<tr>
					<th></th>
					<th>NAMA BANK</th>
					<th>NO SERI/REKENING</th>
					<th>ASAL DANA</th>
					<th>CURRENCY INDEX</th>
					<th>NOM DEPOSITO(Rp.)</th>
					<th>KURS</th>
					<th>TGL. DEP</th>
					<th>TGL. J.T</th>
					<th>BUNGA %/THN</th>
					<th>RATA TERTIMBANG</th>
				</tr>
			</thead>
			<tbody>
			@foreach($data_list as $data)
				<tr>
					<td><label class="radio radio-outline radio-outline-2x radio-primary"><input type="radio" class="btn-radio" name="btn-radio" nodok="{{$data->docno}}" lineno="{{$data->lineno}}"><span></span></label></td>
					<td>{{ $data->nmbank }}</td>
					<td>{{ $data->noseri }}</td>
					<td>{{ $data->asal }}</td>
					<?php
						 if ($data->kurs > "1") {
							$nmkurs = "DOLLAR";
						}else{
							$nmkurs = "RUPIAH";
						}
						$tgldep = date_create($data->tgldepo);
						$tgldepo = date_format($tgldep, 'd/m/Y');
						$tgltem = date_create($data->tgltempo);
						$tgltempo = date_format($tgltem, 'd/m/Y');
					?>
					<td>{{ $nmkurs }}</td>
					<td>{{ number_format($data->asli,2) }}</td>
					<td>{{ number_format($data->kurs,2) }}</td>
					<td>{{ $tgldepo }}</td>
					<td>{{ $tgltempo }}</td>
					<td>{{ number_format($data->bungatahun,2) }}</td>
					<td>{{ number_format($data->rtimbang,2) }}</td>
				</tr>
			@endforeach
			</tbody>
			<?php 
				$a=0;
				foreach($data_list as $dat)
				{
					$a++;
					$totalrupiah[$a] = $dat->totalrupiah;
					$totaldollar[$a] = $dat->totaldollar;
					$totalrata[$a] = $dat->totalrata;
					$total[$a] = $dat->total;
					$ekivalen[$a] = $dat->ekivalen;
				}
			?>
			@if(!empty($data_list))
			<tr><td colspan="5"><b>Total Rupiah : Rp.</b></td><td align="right" bgcolor="#CCFF99">{{number_format(array_sum($totalrupiah),2)}}</td><td colspan="4"><b>Total Rata Tertimbang:</b><td align="center" bgcolor="#CCFF99"><b>{{number_format(array_sum($totalrata),2)}}</b></td></tr>
			<tr><td colspan="5"><b>Total Dollar   : $.</b></td><td align="right" bgcolor="#CCFF99"> {{number_format(array_sum($totaldollar),2)}}</td><td colspan="5"></td></tr>
			<tr><td colspan="5"><b>Ekivalen       : Rp.</b></td><td align="right" bgcolor="#CCFF99">{{number_format(array_sum($ekivalen),2)}}</td><td colspan="5"></td></tr>
			<tr><td colspan="5"><b>Total          : Rp.</b></td><td align="right" bgcolor="#CCFF99"><b>{{number_format(array_sum($total),2)}}</b></td><td colspan="5"></td></tr>
			@endif
		</table>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {

		var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: false,
            searching: false,
            lengthChange: false,
            language: {
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i> <br> Loading...'
            },
        });

	$('#search-form').on('submit', function(e) {
		
	});

	$('#kt_table tbody').on( 'click', 'tr', function (event) {
		if ( $(this).hasClass('selected') ) {
			$(this).removeClass('selected');
		} else {
			t.$('tr.selected').removeClass('selected');
			// $(':radio', this).trigger('click');
			if (event.target.type !== 'radio') {
				$(':radio', this).trigger('click');
			}
			$(this).addClass('selected');
		}
	});
	
		
    // minimum setup
    $('#tanggal').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        autoclose: true,
        // language : 'id',
        format   : 'yyyy-mm-dd'
    });

    //delete Posisi Saldo Deposito PT.Pertamina Dana Ventura
    $('#deleteRow').click(function(e) {
        e.preventDefault();
        if($('input[type=radio]').is(':checked')) { 
            $("input[type=radio]:checked").each(function() {
                var nodok = $(this).attr('nodok').split("/").join("-");
                var lineno = $(this).attr('lineno');
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
                        text: "Detail data No. dokumen : "+nodok+ ' nomer lineno : '  +lineno,
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batalkan'
                    })
                    .then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('perhitungan_bagihasil.delete') }}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "nodok": nodok,
                                "lineno": lineno,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function () {
                                Swal.fire({
                                    icon  : 'success',
                                    title : "Detail data No. dokumen : "+nodok+ ' nomer lineno : '  +lineno,
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
    $('#exportRow').click(function(e) {
        e.preventDefault();
        location.href = "{{ route('perhitungan_bagihasil.rekap') }}";
    });
});

function hanyaAngka(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

</script>
@endpush