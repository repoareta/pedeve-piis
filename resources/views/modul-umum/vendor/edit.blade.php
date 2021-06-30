@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('set-user') }}
@endsection

@section('content')
<div class="card card-custom gutter-b">
    <div class="card-header justify-content-start">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-plus-1 text-primary"></i>
            </span>
            <h3 class="card-label">
                Ubah Vendor
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form id="formVendor" action="{{ route('modul_umum.vendor.update', ['vendor' => $vendor->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="alert alert-custom alert-default" role="alert">
                            <div class="alert-text">Header Vendor</div>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Vendor<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input  class="form-control" type="text" name="nama" value="{{ $vendor->nama }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">No Rekening<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="no_rekening" value="{{ $vendor->no_rekening }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama Bank<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="nama_bank" value="{{ $vendor->nama_bank }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Cabang Bank<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input  class="form-control" type="text" name="cabang_bank" value="{{ $vendor->cabang_bank }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Alamat Vendor<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <textarea class="form-control" type="text" name="alamat">{{ $vendor->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Telepon Vendor<span class="text-danger">*</span></label>
                        <div class="col-10">
                            <input class="form-control" type="text" name="telepon" value="{{ $vendor->telepon }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-10">
                            <a  href="{{ route('modul_umum.vendor.index') }}" class="btn btn-warning"><i class="fa fa-reply"></i>Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
{!! JsValidator::formRequest('App\Http\Requests\VendorUpdate', '#formVendor'); !!}
@endpush
