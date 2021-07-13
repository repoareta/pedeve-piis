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

            </h3>
            <div class="text-right">
                @php
                $data_akses = DB::table('usermenu')->where('userid',auth()->user()->userid)->where('menuid',502)->limit(1)->first();
                @endphp
                @if($data_akses->tambah == 1)
                <a href="{{ route('pembayaran_gaji.create') }}">
                    <span style="font-size: 2em;" class="kt-font-success" data-toggle="kt-tooltip" data-placement="top"
                        title="Tambah Data">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                </a>
                @endif
                @if($data_akses->rubah == 1 or $data_akses->lihat == 1)
                <span style="font-size: 2em;" class="kt-font-warning pointer-link" data-toggle="kt-tooltip" data-placement="top"
                    title="Ubah Data Atau Lihat Data">
                    <i class="fas fa-edit" id="editRow"></i>
                </span>
                @endif
                @if($data_akses->hapus == 1)
                <span style="font-size: 2em;" class="kt-font-danger pointer-link" data-toggle="kt-tooltip" data-placement="top"
                    title="Hapus Data">
                    <i class="fas fa-times-circle" id="deleteRow"></i>
                </span>
                @endif
                @if($data_akses->cetak == 1)
                <span style="font-size: 2em;" class="kt-font-info pointer-link" data-toggle="kt-tooltip" data-placement="top"
                    title="Cetak Data">
                    <i class="fas fa-print" id="exportRow"></i>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>