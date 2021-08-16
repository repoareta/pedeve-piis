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
                Tabel Kas Bank
            </h3>
        </div>
        <div class="card-toolbar">
            <div class="float-left">
				<a href="#">
					<span class="text-info pointer-link" data-toggle="tooltip" data-placement="top" title="Cetak Data">
						<i class="fas fa-2x fa-print text-info" id="exportRow"></i>
					</span>                    
				</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="col-12">
			<form class="kt-form" id="search-form" >
				<div class="form-group row col-12">
					<label for="" class="col-form-label">No.Bukti</label>
					<div class="col-2">
						<input class="form-control" type="text" name="nodok" value="" size="5" maxlength="5">
					</div>
					<label for="" class="col-form-label">Bulan</label>
					<div class="col-2">
						<select name="bulan" class="form-control selectpicker" data-live-search="true">
							<option value="" >-- Pilih --</option>
							<option value="01" <?php if($bulan  == '01') echo 'selected' ; ?>>Januari</option>
							<option value="02" <?php if($bulan  == '02') echo 'selected' ; ?>>Februari</option>
							<option value="03" <?php if($bulan  == '03') echo 'selected' ; ?>>Maret</option>
							<option value="04" <?php if($bulan  == '04') echo 'selected' ; ?>>April</option>
							<option value="05" <?php if($bulan  == '05') echo 'selected' ; ?>>Mei</option>
							<option value="06" <?php if($bulan  == '06') echo 'selected' ; ?>>Juni</option>
							<option value="07" <?php if($bulan  == '07') echo 'selected' ; ?>>Juli</option>
							<option value="08" <?php if($bulan  == '08') echo 'selected' ; ?>>Agustus</option>
							<option value="09" <?php if($bulan  == '09') echo 'selected' ; ?>>September</option>
							<option value="10" <?php if($bulan  == '10') echo 'selected' ; ?>>Oktober</option>
							<option value="11" <?php if($bulan  == '11') echo 'selected' ; ?>>November</option>
							<option value="12" <?php if($bulan  == '12') echo 'selected' ; ?>>Desember</option>
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
        
        <div class="row">
            <div class="col-xl-12">
                <table class="table table-bordered" id="kt_table" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>STAT.BYR</th>
                            <th>NO.DOKUMEN</th>
                            <th>TAHUN-BULAN</th>
                            <th>NO.BUKTI</th>
                            <th>KEPADA</th>
                            <th>JK</th>
                            <th>NO.KAS</th>
                            <th>CI</th>
                            <th>KURS</th>
                            <th>NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var t = $('#kt_table').DataTable({
            scrollX   : true,
            processing: true,
            serverSide: true,
            ajax : {
                url: "{{ route('modul_kontroler.cetak_kas_bank.index.json') }}",
                data: function (d) {
                    d.nodok = $('input[name=nodok]').val();
                    d.bulan = $('select[name=bulan]').val();
                    d.tahun = $('input[name=tahun]').val();
                }
            },
            columns: [
                {data: 'radio', name: 'radio', class:'text-center', width: '10'},
                {data: 'action', name: 'action', class: 'text-center'},
                {data: 'docno', name: 'docno'},
                {data: 'tahun', name: 'tahun'},
                {data: 'nobukti', name: 'nobukti'},
                {data: 'kepada', name: 'kepada'},
                {data: 'jk', name: 'jk'},
                {data: 'nokas', name: 'nokas'},
                {data: 'ci', name: 'ci'},
                {data: 'kurs', name: 'kurs'},
                {data: 'nilai', name: 'nilai'},
            ]
        });

        $('#search-form').on('submit', function(e) {
            t.draw();
            e.preventDefault();
        });
        
        //report
        $('#exportRow').on('click', function(e) {
            e.preventDefault();

            if($('input[class=btn-radio]').is(':checked')) { 
                $("input[class=btn-radio]:checked").each(function() {  
                    e.preventDefault();
                    var dataid = $(this).attr('kode');
                        location.replace("{{ url('kontroler/cetak-kas-bank/rekap') }}"+ '/' +dataid);
                });
            } else{
                swalAlertInit('cetak');
            }
            
        });
    
    });
</script>
@endpush
