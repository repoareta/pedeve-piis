<!DOCTYPE html>
<html>
    <title>LAPORAN - ARUS KAS INTERNAL</title>
    <head>
        <style>
            .row {
              display: -ms-flexbox;
              display: flex;
              -ms-flex-wrap: wrap;
              flex-wrap: wrap;
              margin-right: -5px;
              margin-left: -5px;
            }
            
            .table {
                font: normal 10px Verdana, Arial, sans-serif;
                border-collapse: collapse;
                border: 1px solid black;
            }

            th, td {
                border: 1px solid black;
                padding: 5px;
            }

            td.container {
                height: 110px;
            }

            .table-no-border-all td {
                font: normal 12px Verdana, Arial, sans-serif;
                border: 0px;
                padding: 0px;
            }

            .table-no-border td, .table-no-border tr {
                font: normal 12px Verdana, Arial, sans-serif;
                border:0px;
                padding: 0px;
            }

            .text-center {
              text-align: center;
            }

            .text-right {
              text-align: right;
            }

            td.border-less {
              border-top: 2px solid #FFFFFF;
            }

            td.border-less-top-bottom {
              border-top: 2px solid #FFFFFF;
              border-bottom: 2px solid #FFFFFF;
            }

            td.border-less-dashed {
                border-bottom: dashed; 
                border-top: dashed; 
                border-width: 1.5px;
                border-left: 1px solid black;
                border-right: 1px solid black;
            }

            .tab-1 {
                padding-left:10%;
            }

            .tab-2 {
                padding-left:15%;
            }

            header { 
                position: fixed; 
                left: 0px; 
                top: -110px;
                right: 0px;
                height: 0px;
            }

            @page { 
                margin: 130px 50px 50px 50px;
            }
        </style>
    </head>
    <body>
        <header id="header">
            <div class="row">
                <div class="text-center">
                    <p>
                        <b>
                            PT. PERTAMINA PEDEVE INDONESIA
                        </b>
                        <br>
                        <b>
                            LAPORAN - ARUS KAS
                        </b>
                        <br>
                        <b>
                            PERIODE: {{ strtoupper(bulan($bulan))." ".$tahun }}
                        </b>
                    </p>
                </div>
        
                <div>
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="120px" height="60px" style="padding-top:10px">
                </div>
            </div>
        </header>
    
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="row">
                <table width="100%" class="table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="border-bottom:2px solid black;">KETERANGAN</th>
                            <th colspan="4">TOTAL</th>
                        </tr>
                        <tr>
                            <th style="border-bottom:2px solid black;">RUPIAH</th>
                            <th style="border-bottom:2px solid black;">US$</th>
                            <th style="border-bottom:2px solid black;">EKIV US$</th>
                            <th style="border-bottom:2px solid black;">JML RP + EKIV US$</th>
                        </tr>
                    <thead>
                    <tbody>
                        {{-- A. ARUS KAS DARI AKTIVITAS OPERASI START --}}
                        @if ($arus_kas_aktivitas_koperasi)
                        <tr>
                            <td nowrap>
                                <b>
                                    A. ARUS KAS DARI AKTIVITAS OPERASI
                                </b>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        {{-- PENERIMAAN START --}}
                        @php
                            $total_akak_penerimaan_nilai = 0;
                            $total_akak_penerimaan_nilai_dl = 0;
                            $total_akak_penerimaan_nilai_dl_rp = 0;
                            $total_akak_penerimaan_ekiv = 0;
                        @endphp
                        @if ($arus_kas_aktivitas_koperasi_penerimaan !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENERIMAAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @foreach ($arus_kas_aktivitas_koperasi_penerimaan as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai + $value->nilai_dl_rp), 2) }}
                            </td>
                        </tr>
                        @php
                            $total_akak_penerimaan_nilai += abs($value->nilai);
                            $total_akak_penerimaan_nilai_dl += abs($value->nilai_dl);
                            $total_akak_penerimaan_nilai_dl_rp += abs($value->nilai_dl_rp);
                            $total_akak_penerimaan_ekiv += abs(($value->nilai + $value->nilai_dl_rp));
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENERIMAAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akak_penerimaan_nilai < 0)
                                ({{ number_format(abs($total_akak_penerimaan_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akak_penerimaan_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">{{ number_format(abs($total_akak_penerimaan_nilai_dl), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akak_penerimaan_nilai_dl_rp), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akak_penerimaan_ekiv), 2) }}</td>
                        </tr>
                        @endif
                        {{-- PENERIMAAN END --}}
                        
                        {{-- PENGELUARAN START --}}
                        @if ($arus_kas_aktivitas_koperasi_pengeluaran !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENGELUARAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @php
                            $total_akak_pengeluaran_nilai = 0;
                            $total_akak_pengeluaran_nilai_dl = 0;
                            $total_akak_pengeluaran_nilai_dl_rp = 0;
                            $total_akak_pengeluaran_ekiv = 0;
                        @endphp
                        @foreach ($arus_kas_aktivitas_koperasi_pengeluaran as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai < 0)
                                ({{ number_format(abs($value->nilai), 2) }})
                                @else
                                {{ number_format($value->nilai, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl < 0)
                                ({{ number_format(abs($value->nilai_dl), 2) }})
                                @else
                                {{ number_format($value->nilai_dl, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl_rp < 0)
                                ({{ number_format(abs($value->nilai_dl_rp), 2) }})
                                @else
                                {{ number_format($value->nilai_dl_rp, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if (($value->nilai + $value->nilai_dl_rp) < 0)
                                ({{ number_format(abs(($value->nilai + $value->nilai_dl_rp)), 2) }})
                                @else
                                {{ number_format(($value->nilai + $value->nilai_dl_rp), 2) }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $total_akak_pengeluaran_nilai += $value->nilai;
                            $total_akak_pengeluaran_nilai_dl += $value->nilai_dl;
                            $total_akak_pengeluaran_nilai_dl_rp += $value->nilai_dl_rp;
                            $total_akak_pengeluaran_ekiv += ($value->nilai + $value->nilai_dl_rp);
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENGELUARAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akak_pengeluaran_nilai < 0)
                                ({{ number_format(abs($total_akak_pengeluaran_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akak_pengeluaran_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akak_pengeluaran_nilai_dl < 0)
                                ({{ number_format(abs($total_akak_pengeluaran_nilai_dl), 2) }})
                                @else
                                {{ number_format(abs($total_akak_pengeluaran_nilai_dl), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akak_pengeluaran_nilai_dl_rp < 0)
                                ({{ number_format(abs($total_akak_pengeluaran_nilai_dl_rp), 2) }})
                                @else
                                {{ number_format(abs($total_akak_pengeluaran_nilai_dl_rp), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akak_pengeluaran_ekiv < 0)
                                ({{ number_format(abs($total_akak_pengeluaran_ekiv), 2) }})
                                @else
                                {{ number_format(abs($total_akak_pengeluaran_ekiv), 2) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        {{-- PENGELUARAN END --}}
                        <tr>
                            <td class="border-less-top-bottom">
                                <b>
                                    A. ARUS KAS DARI AKTIVITAS OPERASI
                                </b>
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akak_pengeluaran_nilai - $total_akak_penerimaan_nilai), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akak_pengeluaran_nilai_dl - $total_akak_penerimaan_nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akak_pengeluaran_nilai_dl_rp - $total_akak_penerimaan_nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akak_pengeluaran_ekiv - $total_akak_penerimaan_ekiv), 2) }}
                            </td>
                        </tr>
                        @endif
                        {{-- A. ARUS KAS DARI AKTIVITAS OPERASI END --}}

                        {{-- B. ARUS KAS DARI AKTIVITAS INVESTASI START --}}
                        @if ($arus_kas_aktivitas_investasi)
                        <tr>
                            <td nowrap>
                                <b>
                                    B. ARUS KAS DARI AKTIVITAS INVESTASI
                                </b>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        {{-- PENERIMAAN START --}}
                        @php
                            $total_akai_penerimaan_nilai = 0;
                            $total_akai_penerimaan_nilai_dl = 0;
                            $total_akai_penerimaan_nilai_dl_rp = 0;
                            $total_akai_penerimaan_ekiv = 0;
                        @endphp
                        @if ($arus_kas_aktivitas_investasi_penerimaan !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENERIMAAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @foreach ($arus_kas_aktivitas_investasi_penerimaan as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai + $value->nilai_dl_rp), 2) }}
                            </td>
                        </tr>
                        @php
                            $total_akai_penerimaan_nilai += abs($value->nilai);
                            $total_akai_penerimaan_nilai_dl += abs($value->nilai_dl);
                            $total_akai_penerimaan_nilai_dl_rp += abs($value->nilai_dl_rp);
                            $total_akai_penerimaan_ekiv += abs(($value->nilai + $value->nilai_dl_rp));
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENERIMAAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akai_penerimaan_nilai < 0)
                                ({{ number_format(abs($total_akai_penerimaan_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akai_penerimaan_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">{{ number_format(abs($total_akai_penerimaan_nilai_dl), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akai_penerimaan_nilai_dl_rp), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akai_penerimaan_ekiv), 2) }}</td>
                        </tr>
                        @endif
                        {{-- PENERIMAAN END --}}
                        
                        {{-- PENGELUARAN START --}}
                        @if ($arus_kas_aktivitas_investasi_pengeluaran !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENGELUARAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @php
                            $total_akai_pengeluaran_nilai = 0;
                            $total_akai_pengeluaran_nilai_dl = 0;
                            $total_akai_pengeluaran_nilai_dl_rp = 0;
                            $total_akai_pengeluaran_ekiv = 0;
                        @endphp
                        @foreach ($arus_kas_aktivitas_investasi_pengeluaran as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai < 0)
                                ({{ number_format(abs($value->nilai), 2) }})
                                @else
                                {{ number_format($value->nilai, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl < 0)
                                ({{ number_format(abs($value->nilai_dl), 2) }})
                                @else
                                {{ number_format($value->nilai_dl, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl_rp < 0)
                                ({{ number_format(abs($value->nilai_dl_rp), 2) }})
                                @else
                                {{ number_format($value->nilai_dl_rp, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if (($value->nilai + $value->nilai_dl_rp) < 0)
                                ({{ number_format(abs(($value->nilai + $value->nilai_dl_rp)), 2) }})
                                @else
                                {{ number_format(($value->nilai + $value->nilai_dl_rp), 2) }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $total_akai_pengeluaran_nilai += $value->nilai;
                            $total_akai_pengeluaran_nilai_dl += $value->nilai_dl;
                            $total_akai_pengeluaran_nilai_dl_rp += $value->nilai_dl_rp;
                            $total_akai_pengeluaran_ekiv += ($value->nilai + $value->nilai_dl_rp);
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENGELUARAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akai_pengeluaran_nilai < 0)
                                ({{ number_format(abs($total_akai_pengeluaran_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akai_pengeluaran_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akai_pengeluaran_nilai_dl < 0)
                                ({{ number_format(abs($total_akai_pengeluaran_nilai_dl), 2) }})
                                @else
                                {{ number_format(abs($total_akai_pengeluaran_nilai_dl), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akai_pengeluaran_nilai_dl_rp < 0)
                                ({{ number_format(abs($total_akai_pengeluaran_nilai_dl_rp), 2) }})
                                @else
                                {{ number_format(abs($total_akai_pengeluaran_nilai_dl_rp), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akai_pengeluaran_ekiv < 0)
                                ({{ number_format(abs($total_akai_pengeluaran_ekiv), 2) }})
                                @else
                                {{ number_format(abs($total_akai_pengeluaran_ekiv), 2) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        {{-- PENGELUARAN END --}}
                        <tr>
                            <td class="border-less-top-bottom">
                                <b>
                                    B. ARUS KAS DARI AKTIVITAS INVESTASI
                                </b>
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akai_pengeluaran_nilai - $total_akai_penerimaan_nilai), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akai_pengeluaran_nilai_dl - $total_akai_penerimaan_nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akai_pengeluaran_nilai_dl_rp - $total_akai_penerimaan_nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akai_pengeluaran_ekiv - $total_akai_penerimaan_ekiv), 2) }}
                            </td>
                        </tr>
                        @endif
                        {{-- B. ARUS KAS DARI AKTIVITAS INVESTASI END --}}


                        {{-- C. ARUS KAS DARI AKTIVITAS PENDANAAN START --}}
                        @if ($arus_kas_aktivitas_pendanaan)
                        <tr>
                            <td nowrap>
                                <b>
                                    C. ARUS KAS DARI AKTIVITAS PENDANAAN
                                </b>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        {{-- PENERIMAAN START --}}
                        @php
                            $total_akap_penerimaan_nilai = 0;
                            $total_akap_penerimaan_nilai_dl = 0;
                            $total_akap_penerimaan_nilai_dl_rp = 0;
                            $total_akap_penerimaan_ekiv = 0;
                        @endphp
                        @if ($arus_kas_aktivitas_pendanaan_penerimaan !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENERIMAAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @foreach ($arus_kas_aktivitas_pendanaan_penerimaan as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                {{ number_format(abs($value->nilai + $value->nilai_dl_rp), 2) }}
                            </td>
                        </tr>
                        @php
                            $total_akap_penerimaan_nilai += abs($value->nilai);
                            $total_akap_penerimaan_nilai_dl += abs($value->nilai_dl);
                            $total_akap_penerimaan_nilai_dl_rp += abs($value->nilai_dl_rp);
                            $total_akap_penerimaan_ekiv += abs(($value->nilai + $value->nilai_dl_rp));
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENERIMAAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akap_penerimaan_nilai < 0)
                                ({{ number_format(abs($total_akap_penerimaan_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akap_penerimaan_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">{{ number_format(abs($total_akap_penerimaan_nilai_dl), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akap_penerimaan_nilai_dl_rp), 2) }}</td>
                            <td class="text-right">{{ number_format(abs($total_akap_penerimaan_ekiv), 2) }}</td>
                        </tr>
                        @endif
                        {{-- PENERIMAAN END --}}
                        
                        {{-- PENGELUARAN START --}}
                        @if ($arus_kas_aktivitas_pendanaan_pengeluaran !== null)
                        <tr>
                            <td class="tab-1 border-less-top-bottom">
                                <b><i>PENGELUARAN</i></b>
                            </td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                            <td class="border-less-top-bottom"></td>
                        </tr>
                        @php
                            $total_akap_pengeluaran_nilai = 0;
                            $total_akap_pengeluaran_nilai_dl = 0;
                            $total_akap_pengeluaran_nilai_dl_rp = 0;
                            $total_akap_pengeluaran_ekiv = 0;
                        @endphp
                        @foreach ($arus_kas_aktivitas_pendanaan_pengeluaran as $value)
                        <tr>
                            <td class="tab-2 border-less-dashed" valign="top">
                                {{ $value->keterangan }}
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai < 0)
                                ({{ number_format(abs($value->nilai), 2) }})
                                @else
                                {{ number_format($value->nilai, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl < 0)
                                ({{ number_format(abs($value->nilai_dl), 2) }})
                                @else
                                {{ number_format($value->nilai_dl, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if ($value->nilai_dl_rp < 0)
                                ({{ number_format(abs($value->nilai_dl_rp), 2) }})
                                @else
                                {{ number_format($value->nilai_dl_rp, 2) }}
                                @endif
                            </td>
                            <td class="text-right border-less-dashed" valign="top">
                                @if (($value->nilai + $value->nilai_dl_rp) < 0)
                                ({{ number_format(abs(($value->nilai + $value->nilai_dl_rp)), 2) }})
                                @else
                                {{ number_format(($value->nilai + $value->nilai_dl_rp), 2) }}
                                @endif
                            </td>
                        </tr>
                        @php
                            $total_akap_pengeluaran_nilai += $value->nilai;
                            $total_akap_pengeluaran_nilai_dl += $value->nilai_dl;
                            $total_akap_pengeluaran_nilai_dl_rp += $value->nilai_dl_rp;
                            $total_akap_pengeluaran_ekiv += ($value->nilai + $value->nilai_dl_rp);
                        @endphp
                        @endforeach
                        <tr>
                            <td class="tab-1">
                                <b><i>JUMLAH PENGELUARAN</i></b>
                            </td>
                            <td class="text-right">
                                @if ($total_akap_pengeluaran_nilai < 0)
                                ({{ number_format(abs($total_akap_pengeluaran_nilai), 2) }})
                                @else
                                {{ number_format(abs($total_akap_pengeluaran_nilai), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akap_pengeluaran_nilai_dl < 0)
                                ({{ number_format(abs($total_akap_pengeluaran_nilai_dl), 2) }})
                                @else
                                {{ number_format(abs($total_akap_pengeluaran_nilai_dl), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akap_pengeluaran_nilai_dl_rp < 0)
                                ({{ number_format(abs($total_akap_pengeluaran_nilai_dl_rp), 2) }})
                                @else
                                {{ number_format(abs($total_akap_pengeluaran_nilai_dl_rp), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($total_akap_pengeluaran_ekiv < 0)
                                ({{ number_format(abs($total_akap_pengeluaran_ekiv), 2) }})
                                @else
                                {{ number_format(abs($total_akap_pengeluaran_ekiv), 2) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        {{-- PENGELUARAN END --}}
                        <tr>
                            <td class="border-less-top-bottom">
                                <b>
                                    C. ARUS KAS DARI AKTIVITAS PENDANAAN
                                </b>
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akap_pengeluaran_nilai - $total_akap_penerimaan_nilai), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akap_pengeluaran_nilai_dl - $total_akap_penerimaan_nilai_dl), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akap_pengeluaran_nilai_dl_rp - $total_akap_penerimaan_nilai_dl_rp), 2) }}
                            </td>
                            <td class="text-right border-less-top-bottom">
                                {{ number_format(abs($total_akap_pengeluaran_ekiv - $total_akap_penerimaan_ekiv), 2) }}
                            </td>
                        </tr>
                        @endif
                        {{-- C. ARUS KAS DARI AKTIVITAS PENDANAAN END --}}
    
                        <tr>
                            <td>
                                KENAIKAN (PENURUNAN) KAS BERSIH
                            </td>
                            <td class="text-right">
                                @php
                                    $kpkb_rp = $data_list->sum('nilai');
                                @endphp
                                @if ($kpkb_rp < 0)
                                ({{ number_format(abs($kpkb_rp), 2) }})
                                @else
                                {{ number_format(abs($kpkb_rp), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $kpkb_dl = $data_list->sum('nilai_dl');
                                @endphp
                                @if ($kpkb_dl < 0)
                                ({{ number_format(abs($kpkb_dl), 2) }})
                                @else
                                {{ number_format(abs($kpkb_dl), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $kpkb_dl_rp = $data_list->sum('nilai_dl_rp');
                                @endphp
                                @if ($kpkb_dl_rp < 0)
                                ({{ number_format(abs($kpkb_dl_rp), 2) }})
                                @else
                                {{ number_format(abs($kpkb_dl_rp), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $kpkb_total_ekiv = $kpkb_rp + $kpkb_dl_rp;
                                @endphp
                                @if ($kpkb_total_ekiv < 0)
                                ({{ number_format(abs($kpkb_total_ekiv), 2) }})
                                @else
                                {{ number_format(abs($kpkb_total_ekiv), 2) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border-less">
                                SALDO KAS & BANK - AWAL PERIODE
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbawp_rp = abs($data_list->sum('saldo_awal'));
                                @endphp
                                {{ number_format($skbawp_rp, 2) }}
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbawp_dl = abs($data_list->sum('saldo_awal_dl'));
                                @endphp
                                {{ number_format($skbawp_dl, 2) }}
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbawp_dl_rp = abs($data_list->sum('saldo_awal_dl_rp'));
                                @endphp
                                {{ number_format($skbawp_dl_rp, 2) }}
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbawp_total_ekiv = abs($skbawp_rp + $skbawp_dl_rp);
                                @endphp
                                {{ number_format($skbawp_total_ekiv, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-less">
                                SALDO KAS & BANK - AKHIR PERIODE
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbap = $kpkb_rp + $skbawp_rp;
                                @endphp
                                @if ($skbap < 0)
                                ({{ number_format(abs($skbap), 2) }})
                                @else
                                {{ number_format(abs($skbap), 2) }}
                                @endif
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbap_dl = $kpkb_dl + $skbawp_dl;
                                @endphp
                                @if ($skbap_dl < 0)
                                ({{ number_format(abs($skbap_dl), 2) }})
                                @else
                                {{ number_format(abs($skbap_dl), 2) }}
                                @endif
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbap_dl_rp = $kpkb_dl_rp + $skbawp_dl_rp;
                                @endphp
                                @if ($skbap_dl_rp < 0)
                                ({{ number_format(abs($skbap_dl_rp), 2) }})
                                @else
                                {{ number_format(abs($skbap_dl_rp), 2) }}
                                @endif
                            </td>
                            <td class="border-less text-right">
                                @php
                                    $skbap_total_ekiv = $kpkb_total_ekiv + $skbawp_total_ekiv;
                                @endphp
                                @if ($skbap_total_ekiv < 0)
                                ({{ number_format(abs($skbap_total_ekiv), 2) }})
                                @else
                                {{ number_format(abs($skbap_total_ekiv), 2) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                SELISIH KURS :
                                @if (request('kurs'))
                                Rp. {{ number_format(request('kurs'), 2) }}
                                @else
                                Rp. 0.00
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                            <td class="text-right">
                                @php
                                    $kurs_ekiv = request('kurs') * $skbap_dl - $skbap_dl_rp;
                                @endphp
                                @if ($kurs_ekiv < 0)
                                ({{ number_format(abs($kurs_ekiv), 2) }})
                                @else
                                {{ number_format(abs($kurs_ekiv), 2) }}
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                SALDO AKHIR SETELAH SELISIH KURS
                            </td>
                            <td class="text-right">
                                @if ($skbap < 0)
                                ({{ number_format(abs($skbap), 2) }})
                                @else
                                {{ number_format(abs($skbap), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($skbap_dl < 0)
                                ({{ number_format(abs($skbap_dl), 2) }})
                                @else
                                {{ number_format(abs($skbap_dl), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $total_ekiv_us = $kurs_ekiv + $skbap_dl_rp;
                                @endphp
                                @if ($total_ekiv_us < 0)
                                ({{ number_format(abs($total_ekiv_us), 2) }})
                                @else
                                {{ number_format(abs($total_ekiv_us), 2) }}
                                @endif
                            </td>
                            <td class="text-right">
                                @php
                                    $total_ekivalen = $kurs_ekiv + $skbap_total_ekiv;
                                @endphp
                                @if ($total_ekivalen < 0)
                                ({{ number_format(abs($total_ekivalen), 2) }})
                                @else
                                {{ number_format(abs($total_ekivalen), 2) }}
                                @endif
                            </td>
                        </tr>
                    <tbody>
                </table>
            </div>
        </main>

        <script type='text/php'>
            if ( isset($pdf) ) { 
                $font = null;
                $size = 9;
                $y = $pdf->get_height() - 30;
                $x = $pdf->get_width() - 103;
                $pdf->page_text($x, $y, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, $size);
            }
        </script>
    </body>
</html>
