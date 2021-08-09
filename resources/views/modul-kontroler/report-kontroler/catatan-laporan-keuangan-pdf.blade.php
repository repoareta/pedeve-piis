<?php ini_set('memory_limit', '2048M'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        CATATAN ATAS LAPORAN KEUANGAN
    </title>
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
</head>
<style media="screen">

table {
    font: normal 10px Verdana, Arial, sans-serif;
    border-collapse: collapse;
    border: 1px solid black;
}

th, td {
    border: 1px solid black;
    padding: 5px;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -5px;
    margin-left: -5px;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
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

.tab-1 {
    padding-left:5%;
}

.tab-2 {
    padding-left:10%;
}

td.border-less-top-bottom {
    border-top: 1.1px solid #FFFFFF;
    border-bottom: 1.1px solid #FFFFFF;
}

td.border-solid-top {
    border-top: 1.2px solid #000000;
}

th {
    border: 1.2px solid black;
    font: normal 13px Verdana, Arial, sans-serif;
}

</style>
<body>
    <header id="header">
        <div class="row">
            <div class="text-center">
                <p>
                    <b>
                    PT. PERTAMINA PEDEVE INDONESIA
                    <br>
                    CATATAN ATAS LAPORAN KEUANGAN
                    </b>
                    <br>
                    BULAN BUKU: {{ strtoupper(bulan($bulan))." ".$tahun }}
                </p>
            </div>
    
            <div>
                <img src="data:image/png;base64,{{ $image }}" width="120px" height="60px" style="padding-top:10px" align="right">
            </div>
        </div>
    </header>
      
    <main>
        <div class="row">
            <table style="width:100%;" class="table">
                <thead>
                    <tr>
                        <th>KETERANGAN</th>
                        <th>SUB AKUN</th>
                        <th>MMD</th>
                        <th>MS</th>
                        <th>KONSOLIDASI</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cum_md_total = 0;
                        $cum_ms_total = 0;
                        $cum_md_ms_total = 0;
                        $cum_md_total_per_sc = 0;
                        $cum_ms_total_per_sc = 0;
                        $cum_md_ms_total_per_sc = 0;
                        $cum_md_total_per_sc_class = 0;
                        $cum_ms_total_per_sc_class = 0;
                        $cum_md_ms_total_per_sc_class = 0;
                    @endphp
                    @foreach ($account_sc as $row_sc)
                    
                    @foreach ($row_sc->class_account as $row_account)
                        @foreach ($row_account->class_account_by_sc as $row_account_class)
                            <tr>
                                <td class="tab-2" style="white-space: nowrap;">
                                    <b>{{ $row_account_class->jenis }}</b>
                                </td>
                                <td class="text-center"><b>{{ $row_account_class->batas_awal }}</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            @foreach ($row_account_class->neraca as $row_neraca)
                                <tr>
                                    <td class="tab-2 border-less-top-bottom" style="white-space: nowrap;">
                                        {{ $row_neraca->andet->descacct }}
                                    </td>
                                    <td class="text-center border-less-top-bottom">
                                        {{ $row_neraca->andet->sandi }}
                                    </td>
                                    <td class="text-right border-less-top-bottom">
                                        @if ($row_neraca->lapangan == 'MD')
                                            @php
                                                $md_row = $row_account_class->pengali_tampil * $row_neraca->cum_rp;
                                            @endphp
                                            @if ($md_row < 0)
                                                ({{ nominal_abs($md_row) }}) 
                                            @else
                                                {{ nominal_abs($md_row) }}
                                            @endif
                                        @else
                                            0,00
                                        @endif
                                    </td>
                                    <td class="text-right border-less-top-bottom">
                                        @if ($row_neraca->lapangan == 'MS')
                                            @php
                                                $ms_row = $row_account_class->pengali_tampil * $row_neraca->cum_rp;
                                            @endphp
                                            @if ($ms_row < 0)
                                                ({{ nominal_abs($ms_row) }}) 
                                            @else
                                                {{ nominal_abs($ms_row) }}
                                            @endif
                                        @else
                                            0,00
                                        @endif
                                    </td>
                                    <td class="text-right border-less-top-bottom">
                                        @if ($row_account_class->pengali_tampil * $row_neraca->cum_rp < 0)
                                            ({{ nominal_abs($row_account_class->pengali_tampil * $row_neraca->cum_rp) }}) 
                                        @else
                                            {{ nominal_abs($row_account_class->pengali_tampil * $row_neraca->cum_rp) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td class="border-solid-top"></td>
                                <td class="text-center border-solid-top">
                                    <b>{{ $row_account_class->batas_awal }}</b>
                                </td>
                                <td class="text-right border-solid-top">
                                    <b>
                                        @php
                                            $cum_md = $row_account_class->neraca->filter(function($value, $key) {
                                                return $value->lapangan == 'MD';
                                            })->sum(function($row_cum_md) {
                                                return $row_cum_md->cum_rp;
                                            });
                                            $cum_md_total += $cum_md;
                                        @endphp
                                        @if ($cum_md < 0)
                                        ({{ nominal_abs($cum_md) }})
                                        @else
                                        {{ nominal_abs($cum_md) }}
                                        @endif
                                    </b>
                                </td>
                                <td class="text-right border-solid-top">
                                    <b>
                                        @php
                                            $cum_ms = $row_account_class->neraca->filter(function($value, $key) {
                                                return $value->lapangan == 'MS';
                                            })->sum('cum_rp');
                                            $cum_ms_total += $cum_ms;
                                        @endphp
                                        @if ($cum_ms < 0)
                                        ({{ nominal_abs($cum_ms) }})
                                        @else
                                        {{ nominal_abs($cum_ms) }}
                                        @endif
                                    </b>
                                </td>
                                <td class="text-right border-solid-top">
                                    <b>
                                        @php
                                            $cum_md_ms = $cum_md + $cum_ms;
                                            $cum_md_ms_total += $cum_md_ms;
                                        @endphp
                                        @if ($cum_md_ms < 0)
                                        ({{ nominal_abs($cum_md_ms) }})
                                        @else
                                        {{ nominal_abs($cum_md_ms) }}
                                        @endif
                                    </b>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="tab-2"><b>JUMLAH</b></td>
                            <td></td>
                            <td class="text-right">
                                <b>
                                    @php
                                        $cum_md_total_per_sc += $cum_md_total;
                                    @endphp
                                    @if ($cum_md_total < 0)
                                        ({{ nominal_abs($cum_md_total) }})
                                    @else
                                        {{ nominal_abs($cum_md_total) }}
                                    @endif
                                </b>
                            </td>
                            <td class="text-right">
                                <b>
                                    @php
                                        $cum_ms_total_per_sc += $cum_ms_total;
                                    @endphp
                                    @if ($cum_ms_total < 0)
                                        ({{ nominal_abs($cum_ms_total) }})
                                    @else
                                        {{ nominal_abs($cum_ms_total) }}
                                    @endif
                                </b>
                            </td>
                            <td class="text-right">
                                <b>
                                    @php
                                        $cum_md_ms_total_per_sc += $cum_md_ms_total;
                                    @endphp
                                    @if ($cum_md_ms_total < 0)
                                        ({{ nominal_abs($cum_md_ms_total) }})
                                    @else
                                        {{ nominal_abs($cum_md_ms_total) }}
                                    @endif
                                </b>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="tab-1"><b>JUMLAH</b></td>
                        <td class="text-center"></td>
                        <td class="text-right">
                            <b>
                                @php
                                    $cum_md_total_per_sc_class += $cum_md_total_per_sc;
                                @endphp
                                @if ($cum_md_total_per_sc < 0)
                                    ({{ nominal_abs($cum_md_total_per_sc) }})
                                @else
                                    {{ nominal_abs($cum_md_total_per_sc) }}
                                @endif
                            </b>
                        </td>
                        <td class="text-right">
                            <b>
                                @php
                                    $cum_ms_total_per_sc_class += $cum_ms_total_per_sc;
                                @endphp
                                @if ($cum_ms_total_per_sc < 0)
                                    ({{ nominal_abs($cum_ms_total_per_sc) }})
                                @else
                                    {{ nominal_abs($cum_ms_total_per_sc) }}
                                @endif
                            </b>
                        </td>
                        <td class="text-right">
                            <b>
                                @php
                                    $cum_md_ms_total_per_sc_class += $cum_md_ms_total_per_sc;
                                @endphp
                                @if ($cum_md_ms_total_per_sc < 0)
                                    ({{ nominal_abs($cum_md_ms_total_per_sc) }})
                                @else
                                    {{ nominal_abs($cum_md_ms_total_per_sc) }}
                                @endif
                            </b>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class=""><b>JUMLAH</b></td>
                        <td></td>
                        <td class="text-right">
                            <b>
                                @if ($cum_md_total_per_sc_class < 0)
                                    ({{ nominal_abs($cum_md_total_per_sc_class) }})
                                @else
                                    {{ nominal_abs($cum_md_total_per_sc_class) }}
                                @endif
                            </b>
                        </td>
                        <td class="text-right">
                            <b>
                                @if ($cum_ms_total_per_sc_class < 0)
                                    ({{ nominal_abs($cum_ms_total_per_sc_class) }})
                                @else
                                    {{ nominal_abs($cum_ms_total_per_sc_class) }}
                                @endif
                            </b>
                        </td>
                        <td class="text-right">
                            <b>
                                @if ($cum_md_ms_total_per_sc_class < 0)
                                    ({{ nominal_abs($cum_md_ms_total_per_sc_class) }})
                                @else
                                    {{ nominal_abs($cum_md_ms_total_per_sc_class) }}
                                @endif
                            </b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        <br>
        <br>
        <div class="text-right">
            <span style="padding-right:18px;">Jakarta, {{ date('d M Y') }}</span>
            <br>
            <br>
            <br>
            <br>
            <u>( Wasono Hastoatmodjo )</u>
            <br>
            <span style="padding-right:25px">Manajer Kontroler</span>
        </div>
    </main>  
</body>
</html>