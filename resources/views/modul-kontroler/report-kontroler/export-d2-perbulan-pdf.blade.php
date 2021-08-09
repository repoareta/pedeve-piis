<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        RINCIAN TRANSAKSI (D-2)
    </title>
</head>
<style media="screen">

table {
    font: normal 12px Verdana, Arial, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-left {
    text-align: left;
}

td {
    vertical-align: top;
    padding: 5px;
}

th {
    padding: 7px;
}

thead { 
    display: table-header-group;
    border-top: 1px solid black; 
    border-bottom: 1px solid black;
}

tr { 
    page-break-inside: avoid 
}

.th-small {
    width: 40px;
}

.th-medium {
    width: 70px;
}

.th-large {
    width: 120px;
}

</style>
<body style="margin:0px;">
    <main>
        <div class="row">
            <table class="table tree">
                <thead>
                    <tr>
                        <th class="th-small text-left">JK</th>
                        <th class="th-small text-left">ST</th>
                        <th class="th-small">VC</th>
                        <th class="th-small">CI</th>
                        <th class="th-small">LP</th>
                        <th class="th-small">SANDI</th>
                        <th class="th-medium">BAGIAN</th>
                        <th class="th-medium">PK</th>
                        <th class="th-medium">JB</th>
                        <th class="th-small text-left">CJ</th>
                        <th class="th-large">JUMLAH RUPIAH</th>
                        <th class="th-large">JUMLAH DOLLAR</th>
                        <th class="th-medium">KURS</th>
                        <th class="th-large text-left">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($d2_list as $d2)
                    <tr>
                        <td>{{ $d2->jk }}</td>
                        <td>{{ $d2->lokasi }}</td>
                        <td class="text-center">{{ $d2->voucher }}</td>
                        <td class="text-center">{{ $d2->mu }}</td>
                        <td>{{ $d2->lapangan }}</td>
                        <td>{{ $d2->sandi }}</td>
                        <td>{{ $d2->bagian }}</td>
                        <td>{{ $d2->pk }}</td>
                        <td>{{ $d2->jb }}</td>
                        <td>{{ $d2->kk }}</td>
                        <td class="text-right">
                            @if ($d2->totpricerp < 0)
                            ({{ number_format(float_two(abs($d2->totpricerp)), 2) }})
                            @else
                            {{ number_format(float_two($d2->totpricerp), 2) }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($d2->totpricedl < 0)
                            ({{ number_format(float_two(abs($d2->totpricedl)), 2) }})
                            @else
                            {{ number_format(float_two($d2->totpricedl), 2) }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($d2->mu != 1)
                            {{ number_format(float_two($d2->kurs), 2) }}
                            @endif
                        </td>
                        <td>{{ $d2->keterangan }}</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="6" class="text-right">Total CI :</td>
                        <td colspan="4">{{ $d2->mu }}</td>
                        <td class="text-right">jml_rupiah</td>
                        <td class="text-right">jml_rupiah_dollar</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total JB :</td>
                        <td colspan="4">{{ $d2->jb }}</td>
                        <td class="text-right">jml_rupiah</td>
                        <td class="text-right">jml_rupiah_dollar</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total SANDI :</td>
                        <td colspan="4">{{ $d2->sandi }}</td>
                        <td class="text-right">jml_rupiah</td>
                        <td class="text-right">jml_rupiah_dollar</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total MAIN :</td>
                        <td colspan="4">{{ substr($d2->sandi, 0, 3) }}</td>
                        <td class="text-right">jml_rupiah</td>
                        <td class="text-right">jml_rupiah_dollar</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total CLASS :</td>
                        <td colspan="4">{{ substr($d2->sandi, 0, 1) }}</td>
                        <td class="text-right">jml_rupiah</td>
                        <td class="text-right">jml_rupiah_dollar</td>
                    </tr> --}}
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-right">Total Debet :</td>
                        <td colspan="4"></td>
                        <td class="text-right">{{ number_format($d2_total->total_debet_rp, 2) }}</td>
                        <td class="text-right">{{ number_format($d2_total->total_debet_dl, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total Kredit :</td>
                        <td colspan="4"></td>
                        <td class="text-right">({{ number_format(abs($d2_total->total_kredit_rp), 2) }})</td>
                        <td class="text-right">({{ number_format(abs($d2_total->total_kredit_dl), 2) }})</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Saldo :</td>
                        <td colspan="4"></td>
                        <td class="text-right">
                            @if ($d2_total->saldo_rp < 0)
                            ({{ number_format(abs($d2_total->saldo_rp), 2) }})
                            @else
                            {{ number_format($d2_total->saldo_rp, 2) }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if ($d2_total->saldo_dl < 0)
                            ({{ number_format(abs($d2_total->saldo_dl), 2) }})
                            @else
                            {{ number_format($d2_total->saldo_dl, 2) }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    
    {{-- <script type='text/php'>
    if ( isset($pdf) ) { 
        $font = null;
        $size = 9;
        $y = $pdf->get_height() - 30;
        $x = $pdf->get_width() - 103;
        $pdf->page_text($x, $y, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, $size);
    }
    </script> --}}
</body>
</html>