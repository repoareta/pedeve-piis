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

            .text-right{
                text-align:right;
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
                <?php 
                    $array_bln	 = array (
                        1 =>   'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    
                    $bulan= strtoupper($array_bln[$request->bulan]);
                ?>
                <tr>
                    <td align="left" style="padding-left:50px;font-family: sans-serif">
                        <table>
                            <tr>
                                <td><font style="font-size: 10pt;font-weight: bold ">PANJAR INSENTIF 1 TAHUN {{ $request->tahun}} </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 10pt;font-weight: bold ">PEKERJA WAKTU TERTENTU (PWTT) DAN PEKERJA WAKTU TERTENTU (PWT) </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 10pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA (PDV) </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 11pt;font-weight: bold ">BULAN {{strtoupper($bulan)}} {{ $request->tahun}}</font></td>
                            </tr>
                        </table>
                    </td>
                   
                    <td align="center" style="">
                        <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:45px;">
                    </td>
                </tr>
            </table>          
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        <table width="100%"  style="padding-top:2%;">
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse; " border="1">
                            <tr style="font-size: 10pt;text-align:center;font-weight: bold ">
                                <td>NO</td>
                                <td>NOPEK</td>
                                <td>NAMA</td>
                                <td>UPAH TETAP</td>
                                <td>INSENTIF</td>
                                <td>TUNJ. PAJAK</td>
                                <td>BRUTO</td>
                            </tr>
                            <tr>
                                <td style="font-size: 10pt;font-weight: bold" colspan="7">PWTT</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php  if($data->status == 'C') { 
                            $a++; ?>
                            <tr style="font-size: 10pt;">
                                <td>{{ $a}}</td>
                                <td>{{ $data->nopek}}</td>
                                <td>{{ $data->namapegawai}}</td>
                                <?php
                                    $bruto = $data->pajakins+$data->nilai;
                                    $subtotala[$a] = $data->ut;
                                    $subtotala1[$a] = $data->nilai;
                                    $subtotala2[$a] = $data->pajakins;
                                    $subtotala3[$a] = $bruto;
                                ?>
                                <td class="text-right;">{{ number_format($data->ut,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($data->nilai,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($data->pajakins,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($bruto,2,'.',',') }}</td>
                            </tr>
                            <?php } ?>
                            @endforeach
                            <tr style="font-size: 10pt;font-weight: bold">
                                <td class="text-right;" colspan="3">SUB TOTAL</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotala),2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotala1),2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotala2),2,'.',',') }}</td>              
                                <td class="text-right;">{{ number_format(array_sum($subtotala3),2,'.',',') }}</td>              
                            </tr>
                            <tr>
                                <td style="font-size: 10pt;font-weight: bold" colspan="7">PWT</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php  if($data->status == 'K') { 
                            $a++; ?>
                            <tr style="font-size: 10pt;">
                                <td>{{ $a}}</td>
                                <td>{{ $data->nopek}}</td>
                                <td>{{ $data->namapegawai}}</td>
                                <?php
                                   $bruto = $data->pajakins+$data->nilai;
                                   $subtotalb[$a] = $data->ut;
                                   $subtotalb1[$a] = $data->nilai;
                                   $subtotalb2[$a] = $data->pajakins;
                                   $subtotalb3[$a] = $bruto;
                                ?>
                                <td class="text-right;">{{ number_format($data->ut,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($data->nilai,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($data->pajakins,2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format($bruto,2,'.',',') }}</td>
                            </tr>
                            <?php } ?>
                            @endforeach
                            <tr style="font-size: 10pt;font-weight: bold">
                                <td class="text-right;" colspan="3">SUB TOTAL</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotalb),2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotalb1),2,'.',',') }}</td>
                                <td class="text-right;">{{ number_format(array_sum($subtotalb2),2,'.',',') }}</td>              
                                <td class="text-right;">{{ number_format(array_sum($subtotalb3),2,'.',',') }}</td>              
                            </tr>
                            <tr style="font-size: 10pt;font-weight: bold">
                                <td class="text-right;" colspan="3">TOTAL</td>
                                <?php
                                    $suba1 = array_sum($subtotala)+array_sum($subtotalb);
                                    $suba2 = array_sum($subtotala1)+array_sum($subtotalb1);
                                    $suba3 = array_sum($subtotala2)+array_sum($subtotalb2);
                                    $suba4 = array_sum($subtotala3)+array_sum($subtotalb3);
                                ?>
                                <td class="text-right;">{{ number_format($suba1,2,'.',',') }}</td>             
                                <td class="text-right;">{{ number_format($suba2,2,'.',',') }}</td>             
                                <td class="text-right;">{{ number_format($suba3,2,'.',',') }}</td>             
                                <td class="text-right;">{{ number_format($suba4,2,'.',',') }}</td>             
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>  
            <table width="100%"  style=" padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt; padding-left:70%;">
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">Jakarta, {{strtoupper($request->tanggal)}}</td><br>
                            </tr>
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">{{strtoupper($request->jabatan)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:70%">
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">{{strtoupper($request->nama)}}</td><br>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </main>
        
    </body>
</html>
