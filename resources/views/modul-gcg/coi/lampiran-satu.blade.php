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
				<a class="btn btn-primary btn-sm active" href="{{ route('modul_gcg.coi.lampiran_satu') }}" role="button">Lampiran 1</a>
				<a class="btn btn-primary btn-sm" href="{{ route('modul_gcg.coi.lampiran_dua') }}" role="button">Lampiran 2</a>
			</div>
		</div>
		<div class="row">
			<form class="form" id="formPrint" 
			@if(Request::get('tempat'))action="{{ route('modul_gcg.coi.lampiran_satu.print') }}" @endif
			@if(Request::get('tempat')) method="POST" @else method="GET" @endif>
			@csrf
				<div class="col-md-12">
					<p>
						<center>
							<b>
								SURAT PERNYATAAN INSAN PERTAMINA PEDEVE INDONESIA
							</b>
						</center>
					</p>
					<p>
						Yang bertanda tangan dibawah ini, Saya 
						<b>{{ Auth::user()->pekerja->nama }}</b> 
						Nomor Pekerja 
						<b>{{ Auth::user()->nopeg }}</b>
						, menyatakan bahwa :
					</p>
					<p>
						1. Atasan saya telah menjelaskan mengenai apa yang dimaksud dengan Konflik Kepentingan.

						<br>

						2. Saya juga telah membaca dan mengerti bahwa berikut ini merupakan Konflik kepentingan yaitu sebagai berikut : 

						<ol type="a">
							<li>
								Melaksanakan jasa apapun atau memainkan peran apapun dalam perusahaan atau usaha pesaing yang memalukan atau ingin melakukan usaha dengan PT. Pertamina Pedeve Indonesia;
							</li>
							<li>
								Memiliki kepentingan apapun (komersial atau lainnya) dalam perusahaan atau organisasi manapun yang saat ini sedang melakukan usaha dengan PT. Pertamina Pedeve Indonesia atau ingin melakukan usaha dengan PT. Pertamina Pedeve Indonesia;
							</li>
							<li>
								Memiliki anggota keluarga atau teman yang memiliki kepentingan dalam perusahaan atau organisasi yang saat ini melakukan usaha dengan PT. Pertamina Pedeve Indonesia; 
							</li>
							<li>
								Melakukan transaksi dan/atau menggunakan harga/fasilitas PT. Pertamina Pedeve Indonesia untuk kepentingan diri sendiri, keluarga, atau golongan;
							</li>
							<li>
								Mewakili PT Pertamina Pedeve Indonesia dalam transaksi dengan perusahaan lain dimana saya atau anggota keluarga saya atau teman saya memiliki kepentingan;
							</li>
							<li>
								Menerima hadiah, uang atau hiburan dan pemasok atau mitra usaha, atau dari agen manapun atau bertindak sebagai atau mewakili pemasok atau mitra usaha dalam transaksinya dengan PT. Pertamina Pedeve Indonesia, selain daripada yang diuraikan dalam kebijakan Hadiah dan Hiburan;
							</li>
							<li>
								Menggunakan informasi rahasia dan data bisnis PT. Pertamina Pedeve Indonesia untuk kepentingan pribadi atau dengan cara yang merugikan kepentingan PT. Pertamina Pedeve Indonesia;  
							</li>
							<li>
								Mengungkapkan kepada individu atau organisasi manapun di luar PT. Pertamina Pedeve Indonesia setiap informasi, program, data keuangan, formula, proses atau "Know-How" rahasia milik PT. Pertamina Pedeve Indonesia atau yang dikembangkan oleh saya dalam memenuhi tanggung jawab saya terhadap PT. Pertamina Pedeve Indonesia.
							</li>
						</ol>

						3. Saya juga ingin mengambil kesempatan ini untuk menyatakan bahwa saya mempunyai Potensial Konflik Kepentingan sebagai berikut :

						@if (Request::get('konflik'))
							<textarea name="konflik" class="form-control col-4">{{ Request::get('konflik') }}</textarea>
						@else
							<textarea name="konflik" class="form-control col-4"></textarea>
						@endif
						
						<br>
						4. Saya mengerti bahwa apabila PT. Pertamina Pedeve Indonesia mengetahui bahwa saya memiliki benturan kepentingan dan sebelumnya saya tidak melaporkan hal tersebut kepada atasan atau pihak yang berwenang, saya dapat dikenakan tindakan disiplin yang tercantum dalam peraturan perusahaan PT. Pertamina Pedeve Indonesia. Saya juga sudah membaca dan memahami peraturan tsb.

						<br>
						<br>

						Demikian Deklarasi ini saya buat dengan sebenarnya dalam keadaan sehat baik jasmani dan rohani dan tanpa ada paksaan dari pihak manapun.
					</p>

					<br>
					<br>

					@if (Request::get('tempat'))
						<b>{{ Request::get('tempat') }}</b>
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
