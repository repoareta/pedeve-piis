<!DOCTYPE html>
<html>

<head>
    <style>
        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 4cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <table width="100%">
            <tr>
                <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px" style="padding-right:30px;"><br>
                    <font style="font-size: 12pt;font-weight: bold "><u>BUKTI PENERIMAAN KAS/BANK</u></font><br>
                </td>
            </tr>
        </table>
    </header>
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <table width="100%" style="font-size: 8pt;border-collapse: collapse;">
            <tr style="text-align:center;" class="text-center">
                <td width="70%">
                    <table style="padding-top:-20;">
                        <tr>
                            <td>HARAP DIBAYAR KEPADA</td>
                            <td>:</td>
                            <td>{{$kepada}}</td>
                        </tr>
                        <tr>
                            <td>UANG SEJUMLAH </td>
                            <td>: </td>
                            <td>
                                @if($ci == 1)
                                Rp. {{number_format($nilai_dok) < 0 ? "(".number_format($nilai_dok*-1,2).")" : number_format($nilai_dok,2)}}
                                @else
                                US$. {{number_format($nilai_dok) < 0 ? "(".number_format($nilai_dok*-1,2).")" : number_format($nilai_dok,2)}}
                                @endif
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                @if($ci == 1)
                                {{number_format($nilai_dok) < 0 ? strtoupper(terbilang($nilai_dok*-1)) : strtoupper(terbilang($nilai_dok)) }} {{strtoupper('rupiah')}}
                                @else
                                {{number_format($nilai_dok) < 0 ? strtoupper(terbilang($nilai_dok*-1)) : strtoupper(terbilang($nilai_dok)) }} {{strtoupper('DOLLAR')}}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="45%">JENIS KARTU</td>
                            <td>: </td>
                            <td>{{$jk}}</td>
                        </tr>
                        <tr>
                            <td width="45%">BLN/THN </td>
                            <td>: </td>
                            <td>{{ $bulan }}/{{ $tahun }}</td>
                        </tr>
                        <tr>
                            <td width="45%">NO. KAS/BANK </td>
                            <td>: </td>
                            <td>{{$store}}</td>
                        </tr>
                        <tr>
                            <td width="45%">NO. BUKTI </td>
                            <td>: </td>
                            <td>{{$voucher}}</td>
                        </tr>
                        <tr>
                            <td width="45%">CURRENCY IDX </td>
                            <td>: </td>
                            <td>@if($ci == 1)
                                Rp.
                                @else
                                US$
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td width="45%">KURS</td>
                            <td>: </td>
                            <td>{{number_format($rate,0)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table width="100%" style="padding-top:-5px;">
            <tr>
                <td>
                    <table width="100%" style="font-size: 8pt;border-collapse: collapse;" border='1'>
                        <tr style="text-align:center; font-weight: bold;" class="text-center">
                            <th width="30%">MENURUT RINCIAN BERIKUT</th>
                            <th>K/L</th>
                            <th>KODE<br>PERKIRAAN</th>
                            <th>KODE<br>BAGIAN</th>
                            <th>PERINTAH<BR>KERJA</th>
                            <th>J/B</th>
                            <th>JUMLAH</th>
                            <th>C/J</th>
                        </tr>
                        <?php $no = 0; ?>
                        @foreach($data_list as $data)
                        <?php $no++;
                        $total[$no] = $data->totprice;
                        ?>
                        <tr>
                            <td>{{$data->keterangan}}</td>
                            <td style="text-align:center;">{{$data->lokasi}}</td>
                            <td style="text-align:center;">{{$data->account}}</td>
                            <td style="text-align:center;">{{$data->bagian}}</td>
                            <td style="text-align:center;">{{$data->pk}}</td>
                            <td style="text-align:center;">{{$data->jb}}</td>
                            <td style="text-align:right;">{{number_format($data->totprice,2) < 0 ? number_format($data->totprice*-1,2)." CR" : number_format($data->totprice,2)}}</td>
                            <td style="text-align:center;">{{$data->cj}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>
                                <table width="100%" style="text-align:left;">
                                    <tr>
                                        <td><b><u>KETERANGAN</u></b></td>
                                    </tr>
                                    <tr>
                                        <td>{{$ket1}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$ket2}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$ket3}}</td>
                                    </tr>
                                </table>
                            </td>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align:right;"><b>TOTAL</b></td>
                            <td style="text-align:right;"><b>{{number_format(array_sum($total),2) < 0 ? number_format(array_sum($total)*-1,2)." CR" : number_format(array_sum($total),2)}}</b></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" style="font-size: 8pt;border-collapse: collapse;" border='1'>
            <tr>
                <td>
                    <table width="100%" style="border-collapse: collapse;">
                        <tr style="text-align:center;" class="text-center">
                            <td>
                                <table width="100%" style="text-align:center;">
                                    <tr>
                                        <td width="25%">Pemeriksaan kas,</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">{{$request->nsetuju2}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:3%;padding-bottom:2%;" width="25%">{{$request->setuju2}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%" style="border-collapse: collapse;">
                        <tr style="text-align:center;" class="text-center">
                            <td>
                                <table width="100%" style="text-align:center;">
                                    <tr>
                                        <td width="25%">Pembukuan,</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">{{$request->nbuku2}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:3%;padding-bottom:2%;" width="25%">{{$request->buku2}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%" style="border-collapse: collapse;">
                        <tr style="text-align:center;" class="text-center">
                            <td>
                                <table width="100%" style="text-align:center;">
                                    <?php
                                    $tgl = date_create($tgl_kurs);
                                    $tgl_k = date_format($tgl, 'd-m-Y');
                                    ?>
                                    <tr>
                                        <td width="25%">Jakarta, {{$tgl_k}}</td>
                                    </tr>
                                    <tr>
                                        <td width="25%">{{$request->nkas2}} </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:3%;padding-bottom:2%;" width="25%">{{$request->kas2}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </main>
    <footer>
    </footer>
</body>

</html>