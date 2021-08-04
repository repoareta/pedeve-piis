@extends('layouts.app')

@push('page-styles')

@endpush

@section('content')
<div class="card card-custom" id="kt_page_sticky_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-line-chart text-primary"></i>
            </span>
            <h3 class="card-label">
                Cetak Kas Bank Pembayaran Uang Muka Kerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" action="{{ route('pembayaran_umk.export') }}" method="POST">
			@csrf
			<div class="portlet__body">
			@if($mp == "P")
				<div class="form-group row">
					<label class="col-2 col-form-label"></label>
					<div class="col-8">
						Penandatangan Kas Putih
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label"></label>
					<div class="col-4">
						Nama
					</div>
					<div class="col-4">
						Jabatan
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Verifikasi</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $verifikasi1}}" name="verifikasi1"  <?php if($verifikasi1 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nverifikasi1}}" name="nverifikasi1"  <?php if($nverifikasi1 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Menyetujui</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $setuju1}}" name="setuju1"  <?php if($setuju1 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nsetuju1}}" name="nsetuju1"  <?php if($nsetuju1 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Membukukan</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $buku1}}" name="buku1"  <?php if($buku1 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nbuku1}}" name="nbuku1"  <?php if($nbuku1 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Permintaan</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $minta1}}" name="minta1"  <?php if($minta1 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nminta1}}" name="nminta1"  <?php if($nminta1 == ""){ echo "readonly"; } ?>>
					</div>
				</div>

			@else
				<div class="form-group row">
					<label class="col-2 col-form-label"></label>
					<div class="col-8">
					<font color="#FF0000">Penandatangan Kas Merah</font>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label"></label>
					<div class="col-4">
						Nama
					</div>
					<div class="col-4">
						Jabatan
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Pemeriksaan</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $setuju2}}" name="setuju2"  <?php if($setuju2 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nsetuju2}}" name="nsetuju2"  <?php if($nsetuju2 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Membukukan</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $buku2}}" name="buku2"  <?php if($buku2 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nbuku2}}" name="nbuku2"  <?php if($nbuku2 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Kas/Bank</label>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $kas2}}" name="kas2"  <?php if($kas2 == ""){ echo "readonly"; } ?>>
					</div>
					<div class="col-4">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $nkas2}}" name="nkas2"  <?php if($nkas2 == ""){ echo "readonly"; } ?>>
					</div>
				</div>
				@endif
                <input type="hidden" value="{{ $docno}}" name="docno">
                <input type="hidden" value="{{ $nilai_dok}}" name="nilai">
                <input type="hidden" value="{{ $ci}}" name="ci">
                <input type="hidden" value="{{ $kd_kepada}}" name="kd_kepada">
                <input type="hidden" value="Daftar Transfer" name="cetaktrans">
                <input type="hidden" value="Cetak RC" name="cetak">
				<div class="form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a href="{{route('pembayaran_umk.index')}}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
							<a href="{{url('perbendaharaan/pembayaran-umk/rekaprc')}}/{{ $docs}}" class="btn btn-primary"><i class="fa fa-print"></i>Cetak RC</a>
						</div>
					</div>
				</div>
			</div>
		</form>
    </div>
</div>
@endsection

@push('page-scripts')
<script>
    $(document).ready(function () {
   
        $('#tanggal').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            autoclose: true,
            language : 'id',
            format   : 'yyyy-mm-dd'
        });
    });
</script>
@endpush