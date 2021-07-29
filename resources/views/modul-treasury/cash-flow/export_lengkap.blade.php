<!DOCTYPE html>
<html>
    <title>LAPORAN - ARUS KAS LENGKAP</title>
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
                padding-left:5%;
            }

            .tab-2 {
                padding-left:10%;
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
                            LAPORAN - ARUS KAS LENGKAP
                        </b>
                        <br>
                        <b>
                            PERIODE: {{ strtoupper(bulan($bulan_mulai))." ".$tahun." - ".strtoupper(bulan($bulan_sampai))." ".$tahun }}
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
                            <th style="border-bottom:2px solid black;">KETERANGAN</th>
                            <th >TOTAL RUPIAH</th>
                        </tr>
                    <thead>
                        <tbody>
                            {{-- ARUS KAS DARI AKTIVITAS OPERASI START --}}
                            <tr>
                                <td nowrap>
                                    <b>
                                        A. ARUS KAS DARI AKTIVITAS OPERASI
                                    </b>
                                </td>
                                <td></td>
                            </tr>
                            @php
                                $aktivitas_operasi = $data_list->filter(function ($value, $key) {
                                    return $value->status == 1;
                                });
                            @endphp
                            @foreach ($aktivitas_operasi as $row)
                            <tr>
                                <td class="tab-1 border-less-top-bottom">
                                    <b><i>{{ $row->jenis }}</i></b>
                                </td>
                                <td class="text-right border-less-top-bottom">
                                    {{ nominal_abs($row->totpricerp) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="tab-2 border-less-top-bottom" valign="top">
                                    <b>
                                        Arus Kas Bersih dari (untuk) Aktivitas Operasi
                                    </b>
                                </td>
                                <td class="text-right border-less-top-bottom" valign="top">
                                    {{ nominal_abs($aktivitas_operasi->sum('totpricerp')) }}
                                </td>
                            </tr>
                            {{-- ARUS KAS DARI AKTIVITAS OPERASI END --}}

                            {{-- ARUS KAS DARI AKTIVITAS INVESTASI START --}}
                            <tr>
                                <td nowrap>
                                    <b>
                                        B. ARUS KAS DARI AKTIVITAS INVESTASI
                                    </b>
                                </td>
                                <td></td>
                            </tr>
                            @php
                                $aktivitas_investasi = $data_list->filter(function ($value, $key) {
                                    return $value->status == 2;
                                });
                            @endphp
                            @foreach ($aktivitas_investasi as $row)
                            <tr>
                                <td class="tab-1 border-less-top-bottom">
                                    <b><i>{{ $row->jenis }}</i></b>
                                </td>
                                <td class="text-right border-less-top-bottom">
                                    {{ nominal_abs($row->totpricerp) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="tab-2 border-less-top-bottom" valign="top">
                                    <b>
                                        Arus Kas Bersih Dari (untuk) Aktivitas Investasi
                                    </b>
                                </td>
                                <td class="text-right border-less-top-bottom" valign="top">
                                    {{ nominal_abs($aktivitas_investasi->sum('totpricerp')) }}
                                </td>
                            </tr>
                            {{-- ARUS KAS DARI AKTIVITAS INVESTASI END --}}

                            {{-- ARUS KAS DARI AKTIVITAS PENDANAAN START --}}
                            <tr>
                                <td nowrap>
                                    <b>
                                        C. ARUS KAS DARI AKTIVITAS PENDANAAN
                                    </b>
                                </td>
                                <td></td>
                            </tr>
                            @php
                                $aktivitas_pendanaan = $data_list->filter(function ($value, $key) {
                                    return $value->status == 3;
                                });
                            @endphp
                            @foreach ($aktivitas_pendanaan as $row)
                            <tr>
                                <td class="tab-1 border-less-top-bottom">
                                    <b><i>{{ $row->jenis }}</i></b>
                                </td>
                                <td class="text-right border-less-top-bottom">
                                    {{ nominal_abs($row->totpricerp) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="tab-2 border-less-top-bottom" valign="top">
                                    <b>
                                        Arus Kas Bersih Dari (untuk) Aktivitas Investasi
                                    </b>
                                </td>
                                <td class="text-right border-less-top-bottom" valign="top">
                                    {{ nominal_abs($aktivitas_pendanaan->sum('totpricerp')) }}
                                </td>
                            </tr>
                            {{-- ARUS KAS DARI AKTIVITAS PENDANAAN END --}}

                            <tr>
                                <td>
                                    KENAIKAN (PENURUNAN) KAS BERSIH
                                </td>
                                <td class="text-right">
                                    {{ nominal_abs($data_list->sum('totpricerp')) }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    KAS DAN SETARA KAS AWAL TAHUN
                                </td>
                                <td class="text-right">
                                    {{ nominal_abs(12000) }}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    KAS DAN SETARA KAS AKHIR TAHUN
                                </td>
                                <td class="text-right">
                                    {{ nominal_abs($data_list->sum('totpricerp') + 120000) }}
                                </td>
                            </tr>
                        </tbody>
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
