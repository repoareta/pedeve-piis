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
                CoC (Code of Conduct)
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
			<div class="col-md-12 text-center">
				<a class="btn btn-primary btn-sm" href="{{ route('modul_sdm_payroll.gcg.coc.lampiran_satu') }}" role="button">Lampiran 1</a>
				<a class="btn btn-primary btn-sm active" href="{{ route('modul_sdm_payroll.gcg.coc.lampiran_dua') }}" role="button">Lampiran 2</a>
			</div>
		</div>
		<div class="row">
			<form class="kt-form" id="formPrint" 
			@if(Request::get('orang')) action="{{ route('modul_sdm_payroll.gcg.coc.lampiran_dua.print') }}" @endif
			@if(Request::get('orang')) method="POST" @else method="GET" @endif>
			@csrf
				<div class="col-md-12">
					<p>
						<center>
							<b>
								SURAT PERNYATAAN PEJABAT YANG BERTANGGUNG JAWAB
								<br>
								ATAS PENERAPAN ATAS ETIKA USAHA DAN TATA PERILAKU (CODE OF CONDUCT)
							</b>
						</center>
					</p>
					<p>
						Sehubungan dengan pemberitahuan Etika Usaha dan Tata Perilaku (Code of Conduct) PT. PERTAMINA PEDEVE INDONESIA

						<br>
						<br>

						Tanggal (Efektif) 
						<b>{{ date('Y-m-d H:i:s') }}</b> 
						yang telah saya terima dan pahami sepenuhnya saya menyatakan bahwa pada tahun
						<b>{{ date('Y') }}</b> 

						<br>
						<br>

						1. telah mendistribusikan Etika Usaha dan Tata Perilaku (Code of Conduct) telah diterima dan ditandatangani oleh seluruh insan PERTAMINA PEDEVE INDONESIA di fungsi krja yang menjadi tanggung jawab saya;

						<br>

						2. setelah mengkoordinasikan pelaksanaan sosialisasi dan internalisasi dengan Sekretaris Perseroan untuk 
						@if (Request::get('orang'))
							{{ Request::get('orang') }}
						@else
						<input class="form-control col-1" style="display:inline" type="text" name="orang" placeholder="jumlah" required> 
						@endif
						(orang) insan PERTAMINA PEDEVE INDONESIA dengan daftar terlampir;

						<br>

						3. telah melaporkan upaya-upaya untuk menjamin kepatuhan terhadap Etika Usaha dan Tata Perilaku (Code of Conduct) di fungsi kerja yang menjadi tanggung jawab saya;

						<br>

						4. telah melaporkan semua pelanggaran secara lengkap kepada Sekretaris Perseroan 
						<b>Jakarta, {{ date('Y-m-d H:i:s') }}</b> 

						<br>

						5. telah melaksanakan semua pemberian sanksi disiplin dan tindakan pembinaan/perbaikan yang harus dilakukan unit kerja yang menjadi tanggung jawab saya.

						<br>
						<br>

						Nama: {{ ucwords(strtolower(Auth::user()->pekerja->nama)) }}

						<br>

						Jabatan: {{ ucwords(strtolower(Auth::user()->fungsi->nama)) }} - {{ ucwords(strtolower(Auth::user()->fungsi_jabatan->nama)) }}
						
						<br>
						<br>
						<br>

						@if (Request::get('orang'))
							<input type="hidden" name="orang" value="{{ Request::get('orang') }}" required>
							<input type="hidden" name="tanggal_efektif" value="{{ Request::get('tanggal_efektif') }}" required>
							<button type="submit" onclick="printPDF()" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
						@else
							<input type="hidden" name="tanggal_efektif" value="{{ date('Y-m-d H:i:s') }}" required>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
						@endif
					</p>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection

@push('page-scripts')
<script type="text/javascript">
    function printPDF() {
        $("#formPrint").attr("target", "_blank");
    }
</script>
@endpush
