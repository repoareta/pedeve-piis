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
				<a class="btn btn-primary btn-sm active" href="{{ route('modul_gcg.coc.lampiran_satu') }}" role="button">Lampiran 1</a>
				<a class="btn btn-primary btn-sm" href="{{ route('modul_gcg.coc.lampiran_dua') }}" role="button">Lampiran 2</a>
			</div>
		</div>
		<div class="row">
			<form class="form" id="formPrint" 
			@if(Request::get('tempat'))action="{{ route('modul_gcg.coc.lampiran_satu.print') }}" @endif
			@if(Request::get('tempat')) method="POST" @else method="GET" @endif>
			@csrf
				<div class="col-md-12">
					<p>
						<center><b>SURAT PERNYATAAN INSAN PERTAMINA PEDEVE INDONESIA</b></center>
					</p>

					<p class="text-justify">
						Dengan ini saya menyatakan telah menerima, membaca dan memahami
		
						Etika Usaha dan Tata Perilaku (Code of Conduct) PT. Pertamina Pedeve Indonesia
		
						Tanggal (Efektif) 
						@if(Request::get('tanggal_efektif'))
							<b>{{ Request::get('tanggal_efektif') }}</b>
						@else
							<b>{{ date('Y-m-d H:i:s') }}</b>
						@endif
						dan bersedia untuk mematuhi semua ketentuan yang tercantum di dalamnya dan menerima sanksi atas pelanggaran (jika ada) yang saya lakukan.
						
						<br>
						<br>
						<br>
						
						@if (Request::get('tempat'))
							{{ Request::get('tempat') }}
						@else
							(Tempat)
							<br>
							
							<input class="form-control col-2" style="display:inline" type="text" name="tempat" placeholder="lokasi kerja anda">
							
							<input type="hidden" name="tanggal_efektif" value="{{ date('Y-m-d H:i:s') }}">
						@endif
						, 
						@if(Request::get('tanggal_efektif'))
							<b>{{ Request::get('tanggal_efektif') }}</b>
						@else
							<b>{{ date('Y-m-d H:i:s') }}</b>
						@endif

						<br>
						<br>
						
						{{ ucwords(strtolower(Auth::user()->pekerja->nama)).' - '. ucwords(strtolower(Auth::user()->pekerja->jabatan[0]->kode_bagian->nama)) }}
						
						<br>
						<br>

						@if (Request::get('tempat'))
							<input type="hidden" name="tempat" value="{{ Request::get('tempat') }}">
							<input type="hidden" name="tanggal_efektif" value="{{ Request::get('tanggal_efektif') }}">
							<button type="submit" onclick="printPDF()" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
						@else
							<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
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
