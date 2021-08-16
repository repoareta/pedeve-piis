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
                height: 2cm;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%" >
                <tr>
                    <td align="left" style="padding-left:40px;">
                        <table>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR LEMBUR</font></td>
                            </tr>
                        </table>
                    </td>
                    <td align="center" style="">
                        <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:40px;">
                    </td>
                </tr>
            </table>

            <table width="100%"  style="padding-top:10%; padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center; ">
                                <td rowspan="2">No</td>
                                <td rowspan="2">No. Peg</td>
                                <td rowspan="2">Nama Pegawai</td>
                                <td colspan="3">Waktu</td>
                                <td rowspan="2">Uang Lembur</td>
                                <td colspan="3">Uang Makan</td>
                                <td rowspan="2">Transpot</td>
                                <td rowspan="2">Total</td>
                            </tr>
                            <tr style="text-align:center;">
                                <td >Tanggal</td>
                                <td >Mulai</td>
                                <td >Sampai</td>
                                <td >Pagi</td>
                                <td >Siang</td>
                                <td >Malam</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php $a++; 
                                $tgl = date_create($data->tanggal);
                                $tanggal = date_format($tgl, 'd/m/Y')
                            ?>
                            <tr>
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->nama }}</td>
                                <td style="text-align:left;">{{ $tanggal}}</td>
                                <td style="text-align:right;">{{ $data->mulai == 0 ? '-' : $data->mulai}}</td>
                                <td style="text-align:right;">{{ $data->sampai == 0 ? '-' : $data->sampai}}</td>
                                <td style="text-align:right;">{{ $data->lembur == 0 ? '-' : number_format($data->lembur,2,',','.') }}</td>
                                <td style="text-align:right;">{{ $data->makanpg == 0 ? '-' : number_format($data->makanpg,2,',','.') }}</td>
                                <td style="text-align:right;">{{ $data->makansg == 0 ? '-' : number_format($data->makansg,2,',','.') }}</td>
                                <td style="text-align:right;">{{ $data->makanml == 0 ? '-' : number_format($data->makanml,2,',','.') }}</td>
                                <td style="text-align:right;">{{ $data->transport == 0 ? '-' : number_format($data->transport,2,',','.') }}</td>
                                <?php 
                                    $lembur = $data->lembur == 0 ? '0' : round($data->lembur,0);
                                    $makanpg = $data->makanpg == 0 ? '0' : round($data->makanpg,0);
                                    $makansg = $data->makansg == 0 ? '0' : round($data->makansg,0);
                                    $makanml = $data->makanml == 0 ? '0' : round($data->makanml,0);
                                    $makantransport = $data->transport == 0 ? '0' : round($data->transport,0);
                                    $total=$lembur+$makanpg+$makansg+$makanml+$makantransport;
                                    $totallembur[$a] = $lembur; 
                                    $totalmakanpg[$a] = $makanpg; 
                                    $totalmakansg[$a] = $makansg; 
                                    $totalmakanml[$a] = $makanml; 
                                    $totaltransport[$a] = $makantransport; 
                                    $totaltotal[$a] = $total; 
                                ?>
                                <td style="text-align:right;">{{ $total == 0 ? '-' : number_format($total,2,',','.') }}</td>
                            </tr>
                            @endforeach
                            <!-- <tr>
                                <td style="text-align:center;"></td>
                                <td style="text-align:left;"></td>
                                <td style="text-align:left;">Sub. Total</td>
                                <td style="text-align:left;"></td>
                                <td style="text-align:right;"></td>
                                <td style="text-align:right;"></td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totallembur),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakanpg),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakansg),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakanml),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totaltransport),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totaltotal),2,',','.') }}</td>

                            </tr> -->
                            <tr style="font-weight: bold">
                                <td style="text-align:right;" colspan="6">Total</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totallembur),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakanpg),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakansg),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totalmakanml),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totaltransport),2,',','.') }}</td>
                                <td style="text-align:right;" > {{ number_format(array_sum($totaltotal),2,',','.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>            
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        
    </body>
</html>
