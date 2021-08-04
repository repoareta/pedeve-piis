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
                CoI (Conflict of Interest)
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
			<div class="col-md-12 text-center">
				<a class="btn btn-primary btn-sm" href="{{ route('modul_sdm_payroll.gcg.coi.lampiran_satu') }}" role="button">Lampiran 1</a>
				<a class="btn btn-primary btn-sm active" href="{{ route('modul_sdm_payroll.gcg.coi.lampiran_dua') }}" role="button">Lampiran 2</a>
			</div>
		</div>
		<div class="row">
			<form class="form" id="formPrint" 
			@if(Request::get('tempat'))action="{{ route('modul_sdm_payroll.gcg.coi.lampiran_dua.print') }}" @endif
			@if(Request::get('tempat')) method="POST" @else method="GET" @endif>
			@csrf
				<div class="col-md-12">
					<p>
						<center>
							<b>
								SURAT PERNYATAAAN INSAN PERTAMINA PEDEVE INDONESIA
							</b>
						</center>
					</p>

					<p>
						Yang bertanda tangan dibawah ini:
						<br>
						Nama: {{ Auth::user()->pekerja->nama }}
						<br>
						Nomor Pekerja: {{ Auth::user()->nopeg }}
						<br>
						Jabatan: {{ Auth::user()->fungsi_jabatan->nama }}
						<br>
						Fungsi: {{ Auth::user()->fungsi->nama }}
					</p>

					<p>
						Dengan ini menyatakan dan menjamin bahwa SAYA tidak mempunyai benturan kepentingan terhadap PT. Pertamina Pedeve Indonesia yang membuat SAYA tidak patut untuk melakukan tindakan berikut ini : 
						
						<ul>
							<li>
								Melaksanakan jasa apapun atau memiliki peran apapun dalam perusahaan lain atau usaha pesaing yang sedang atau akan melakukan kerjasama usaha dengan PT. Pertamina Pedeve Indonesia.
							</li>
							<li>
								Memiliki kepentingan ekonomi secara langsung maupun tidak langsunh terhadap persahaan atau organisasi manapun yang saat ini sedang melakukan kerjasama dengan PT. Pertamina Pedeve Indonesia atau ingin melakukan kerjasama dengan PT. Pertamina Pedeve Indonesia.
							</li>
							<li>
								Memiliki anggota keluarga atau teman yang memiliki kepentingan ekonomi secara langsung maupun tidak langsung terhadap perusahaan atau organisasi yang saat ini melakukan usaha dengan PT. Pertamina Pedeve Indonesia.
							</li>
							<li>
								Melakukan transaksi dan/atau menggunakan harta/fasilitas PT. Pertamina Pedeve Indonesia untuk kepentingan diri sendiri, keluarga, atau golongan.
							</li>
							<li>
								Mewakili PT. Pertamina Pedeve Indonesia dalam transaksi dengan perusahaan lain dimana SAYA atau anggota keluarga SAYA atau teman SAYA memiliki kepentingan.
							</li>
							<li>
								Menerima hadiah, uang atau hiburan dari pemasok atau mitra usaha, atau dari agen manapun atau bertindak sebagai atau mewakili pemasok atau mitra usaha dalam transaksinya dengan PT. Pertamina Pedeve Indonesia selain daripada yang diuraikan dalam kebijakan PT. Pertamina Pedeve Indonesia mengenai Hadiah dan Hiburan.
							</li>
							<li>
								Menggunakan informasi rahasia dan data bisnis PT. Pertamina Pedeve Indonesia untuk kepentingan pribadi atau dengan cara yang merugikan kepentingan PT. Pertamina Pedeve Indonesia. 
							</li>
							<li>
								Mengungkapkan kepada individu atau organisasi atau pihak manapun di luar PT. Pertamina Pedeve Indonesia setiap informasi, program, data keuangan, formula, proses atau "Know-How" rahasia milik PT. Pertamina Pedeve Indonesia atau yang dikembangkan oleh SAYA dalam memenuhi tanggung jawab SAYA terhadap PT. Pertamina Pedeve Indonesia.
							</li>
							<li>
								Melaksanakan setiap tindakan lainnya, yang tidak disebutkan secara spesifik diatas ini, yang dianggap merugikan bagi kepentingan PT. Pertamina Pedeve Indonesia. 
							</li>
						</ul>

						SAYA mengerti bahwa apabila SAYA memiliki benturan kepentingan dan sebelumnya SAYA tidak melaporkan hal tersebut kepada atasan atau pihak yang berwenang di PT. Pertamina Pedeve Indonesia. SAYA dapat dikenakan tindakan disiplin sebagaimana yang tercantum dalam peraturan perusahaan PT. Pertamina Pedeve Indonesia yang mana SAYA telah memahami peraturan tersebut.
						
						<br>
						<br>

						Demikian pernyataan ini SAYA buat dengan sebenarnya, dalam keadaan sehat baik jasmani dan rohani dan tanpa ada paksaan dari pihak manapun.

						<br>
					<br>

					@if (Request::get('tempat'))
						<b>{{ Request::get('tempat') }}</b>
					@else						
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

					{{ Auth::user()->pekerja->nama.' - '.Auth::user()->fungsi_jabatan->nama }}

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
