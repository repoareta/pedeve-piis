<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        BUKTI KAS MERAH
    </title>
</head>
<style media="screen">
    .table {
        font: normal 12px Verdana, Arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid black;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
    }

    .table-no-border-all td {
        font: normal 12px Verdana, Arial, sans-serif;
        border: 0px;
        padding: 0px;
    }

    .table-no-border td,
    .table-no-border tr {
        font: normal 12px Verdana, Arial, sans-serif;
        border: 0px;
        padding: 0px;
    }

    h4 {
        font-size: 15px;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
    }

    .content {
        width: 100%;
        padding: 0px;
        overflow: hidden;
    }

    .content img {
        margin-right: 15px;
        float: left;
    }

    .content h4 {
        margin-left: 15px;
        display: block;
        margin: 2px 0 15px 0;
    }

    .content p {
        margin-left: 15px;
        display: block;
        margin: 0px 0 10px 0;
        font-size: 12px;
        padding-bottom: 10px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    #container {
        position: relative;
        font: normal 12px Verdana, Arial, sans-serif;
    }

    #bottom-right {
        position: absolute;
        bottom: 0;
    }

    .pagecount:before {
        content: counter(pages);
    }

    /* header {
        position: fixed;
        left: 0px;
        top: -110px;
        right: 0px;
        height: 0px;
    } */

    @page {
        margin: 130px 50px 50px 50px;
    }

    .border-top-less {
        border-top: 2px solid white;
    }
</style>

<body>
    <header id="header">
        <div class="row">
            <div class="text-center" style="width: 100%;">
                <p>
                    <b>PT PERTAMINA PEDEVE INDONESIA
                        <br>
                        BUKTI PENERIMAAN KAS/BANK
                    </b>
                </p>
            </div>

            <div class="row">
                <div class="text-right" style="width: 100%;">
                    <img src="{{ public_path() . '/images/pertamina.jpg' }}" width="120px" height="60px" style="padding-right: 20px;">
                </div>
            </div>
        </div>
    </header>

    <main>

        <div class="text-right">{{ $kasdoc->docno }}</div>
        <div class="row">
            <table style="width:100%;" class="table">
                <thead>
                    <tr>
                        <td colspan="6">
                            <p>
                                SUDAH TERIMA DARI : {{ $kasdoc->kepada }}
                                <br>
                                UANG SEJUMLAH &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                @if ($kasdoc->ci == 1)
                                Rp.
                                @else
                                US$
                                @endif
                                {{ number_format(abs($kasdoc->kasline_sum_totprice), 2) }}
                                <br>
                                <div style="border: 1px solid black; padding: 10px;">
                                    {{ strtoupper(terbilang(abs($kasdoc->kasline_sum_totprice))) }}

                                    @if ($kasdoc->ci == 1)
                                    RUPIAH
                                    @else
                                    US DOLLAR
                                    @endif
                                </div>
                            </p>
                        </td>
                        <td colspan="2" nowrap>
                            JENIS KARTU &nbsp;&nbsp;&nbsp;&nbsp;: {{ $kasdoc->jk }}
                            <br>
                            BLN/THN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ substr($kasdoc->thnbln, 0, 4) }} / {{ substr($kasdoc->thnbln, -2, 2) }}
                            <br>
                            NO. KAS/BANK &nbsp;&nbsp;: {{ $kasdoc->store }}
                            <br>
                            NO. BUKTI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $kasdoc->voucher }}
                            <br>
                            CURRENCY IDX :
                            @if ($kasdoc->ci == 1)
                            1. Rp.
                            @else
                            2. US$
                            @endif
                            <br>
                            KURS
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $kasdoc->rate }}
                        </td>
                    </tr>
                    <tr>
                        <th nowrap colspan="2">MENURUT RINCIAN BERIKUT</th>
                        <th>SANDI PERKIRAAN</th>
                        <th>KODE BAGIAN</th>
                        <th>PERINTAH KERJA</th>
                        <th>J/B</th>
                        <th>JUMLAH</th>
                        <th>C/J</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    $total_row = 0;
                    @endphp
                    @foreach ($kasdoc->kasline as $kasline)
                    <tr>
                        <td valign="top" colspan="2">{{ $kasline->keterangan }}</td>
                        <td valign="top" class="text-center">{{ $kasline->account }}</td>
                        <td valign="top" class="text-center">{{ $kasline->bagian }}</td>
                        <td valign="top" class="text-center">{{ $kasline->pk }}</td>
                        <td valign="top" class="text-center">{{ $kasline->jb }}</td>
                        <td valign="top" class="text-right" nowrap>
                            {{ number_format(abs($kasline->totprice) , 2) }}
                            @if ($kasline->totprice < 0) CR @endif
                                @php $total +=abs($kasline->totprice);
                                $total_row++;
                                @endphp
                        </td>
                        <td valign="top" class="text-center">{{ $kasline->cj }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="border-top-less" valign="top" style="height:{{ 565 - ($total_row*50) }}px" colspan="2">
                            <b><u>KETERANGAN :</u></b>
                            <br>
                            {{ $kasdoc->ket1 }}
                            <br>
                            {{ $kasdoc->ket2 }}
                            <br>
                            {{ $kasdoc->ket3 }}
                        </td>
                        <td class="border-top-less"></td>
                        <td class="border-top-less"></td>
                        <td class="border-top-less"></td>
                        <td class="border-top-less"></td>
                        <td class="border-top-less"></td>
                        <td class="border-top-less"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Jumlah</td>
                        <td colspan="2" class="text-right">
                            {{ number_format(abs($total), 2) }}
                            @if ($total < 0) CR @endif </td> </tr> <tr>
                        <td colspan="4" class="text-center">
                            <b>TANDA TANGAN</b>
                        </td>
                        <td colspan="4" class="text-right">
                            JAKARTA, {{ date('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center" valign="top" style="border-bottom: 2px solid #FFFFFF;">
                            Pemeriksaan Kas,
                            <br>
                            {{ request('pemeriksaan_jabatan') }}
                        </td>
                        <td colspan="2" class="text-center" valign="top" style="border-bottom: 2px solid #FFFFFF;">
                            Pembukuan,
                            <br>
                            {{ request('membukukan_jabatan') }}
                        </td>
                        <td colspan="4" class="text-center" valign="top"
                           style="border-top: 2px solid #FFFFFF; border-bottom: 2px solid #FFFFFF;">
                            <br>
                            {{ request('kasbank_jabatan') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center border-less">
                            <br>
                            <br>
                            <br>
                            <br>
                            {{ strtoupper(request('pemeriksaan_nama')) }}
                        </td>
                        <td colspan="2" class="text-center border-less">
                            <br>
                            <br>
                            <br>
                            <br>
                            {{ strtoupper(request('membukukan_nama')) }}
                        </td>
                        <td colspan="4" class="text-center border-less">
                            <br>
                            <br>
                            <br>
                            <br>
                            {{ strtoupper(request('kasbank_nama')) }}
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
