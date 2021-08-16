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
                    <td align="left" style="padding-left:100px;font-family: sans-serif">
                        <table>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR REKENING HONORARIUM KOMISARIS </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA (PDV) </font></td>
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
        <table width="100%"  style="padding-top:6%;font-family: sans-serif">
                <tr>
                    <td>
                        <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center;font-size: 8pt;">
                                <td rowspan="2">NO</td>
                                <td rowspan="2">NOPEK</td>
                                <td rowspan="2">NAMA</td>
                                <td rowspan="2">HONORARIUM<br>(Rp)</td>
                                <td rowspan="2">JML DI TRANSFER<br>(Rp)</td>
                                <td colspan="2">KEPADA</td>
                            </tr>
                            <tr style="text-align:center;font-size: 8pt;">
                                <td>NO. REKENING</td>
                                <td>NAMA BANK</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:center;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->namapegawai}}</td>
                                <?php 
                                    $jumpajak = $data->tunpajak+$data->potpajak;
                                    $hon = $data->allin+$jumpajak+$data->jumkoreksi;
                                    $jumtransfer = $data->allin+$jumpajak+$data->jumkoreksi;
                                    $subtotala1[$a] = $hon;
                                    $subtotala2[$a] = $jumtransfer;
                                ?>                                
                                <td style="text-align:right;">{{ number_format($hon,0)}}</td>
                                <td style="text-align:right;">{{ number_format($jumtransfer,0)}}</td>
                                <td style="text-align:center;">{{ $data->rekening}}</td>
                                <td style="text-align:left;">{{ $data->namabank}}</td>
                            </tr>
                            @endforeach
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td style="text-align:right;" colspan="3">JUMLAH</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala2),0)}}</td>              
                                <td style="text-align:right;" colspan="2"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table width="100%"  style=" padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt; padding-left:75%;">
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">JAKARTA, {{strtoupper($request->tanggal)}}</td><br>
                            </tr>
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">PT.PERTAMINA PEDEVE INDONESIA</td><br>
                            </tr>
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">{{strtoupper($request->jabatan)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:75%">
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
