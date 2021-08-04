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
                Cetak RC Pembayaran Gaji Pekerja
            </h3>
        </div>
    </div>

    <div class="card-body">
        <form class="form" action="{{route('pembayaran_gaji.export_rc')}}" method="POST">
			@csrf
			<div class="portlet__body">
				<div class="form-group row">
					<label class="col-2 col-form-label">No.Dokumen</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $docno}}" name="docno" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Lampiran</label>
					<div class="col-3">
						<input size="3" maxlength="3"  class="form-control" type="text" value="{{ $lampiran }}" name="lampiran" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $total}}" name="total" >
						<input size="30" maxlength="30" type="hidden" value="{{ $bulan }}" name="bulan" >
						<input size="30" maxlength="30" type="hidden" value="{{ $tahun }}" name="tahun" >
						<input size="30" maxlength="30" type="hidden" value="{{ $ci}}" name="ci" >
					</div>
					<label class="col-2 col-form-label">No.Bilyet Giro</label>
					<div class="col-3">
						<input size="10" maxlength="10"  class="form-control" type="text" value="{{ $reg}}" name="reg" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $transfer}}" name="transfer" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Perihal</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $perihal }}" name="perihal" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $pkpp}}" name="pkpp" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Nama Bank</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $bank}}" name="bank" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $bazma}}" name="bazma" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Cabang</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $cabang}}" name="cabang" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $koperasi}}" name="koperasi" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">No. Rekening</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $norek }}" name="norek" autocomplete="off">
						<input size="30" maxlength="30" type="hidden" value="{{ $sukaduka}}" name="sukaduka" >
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Alamat</label>
					<div class="col-8">
						<input size="50" maxlength="50"  class="form-control" type="text" value="{{ $alamat}}" name="alamat" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Kota</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $kota}}" name="kota" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Up</label>
					<div class="col-8">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $up}}" name="up" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Jabatan Kiri</label>
					<div class="col-3">
						<input size="20" maxlength="20"  class="form-control" type="text" value="{{ $jabkir }}" name="jabkir" autocomplete="off">
					</div>
					<label class="col-2 col-form-label">Nama</label>
					<div class="col-3">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $namkir }}" name="namkir" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-2 col-form-label">Jabatan Kanan</label>
					<div class="col-3">
						<input size="20" maxlength="20"  class="form-control" type="text" value="{{ $jabkan }}" name="jabkan" autocomplete="off">
					</div>
					<label class="col-2 col-form-label">Nama</label>
					<div class="col-3">
						<input size="30" maxlength="30"  class="form-control" type="text" value="{{ $namkan }}" name="namkan" autocomplete="off">
					</div>
				</div>
				<input type="hidden" value="{{ $kdkepada}}" name="kdkepada">
				<div class="form__actions">
					<div class="row">
						<div class="col-2"></div>
						<div class="col-10">
							<a href="{{route('pembayaran_gaji.index')}}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
							<button type="submit" id="btn-save" onclick="$('form').attr('target', '_blank')" class="btn btn-primary"><i class="fa fa-print"></i>Cetak</button>
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