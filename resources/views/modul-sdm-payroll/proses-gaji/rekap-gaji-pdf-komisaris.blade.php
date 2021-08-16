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
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR PEMBAYARAN GAJI PENGURUS </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT.PERTAMINA PEDEVE INDONESIA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 11pt;font-weight: bold ">BULAN {{strtoupper($bulan)}} {{ $request->tahun }}</font></td>
                            </tr>
                        </table>
                    </td>
                   
                    <td align="center" style="">
                        <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:40px;">
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        <table width="100%"  style="padding-top:6%;font-family: sans-serif">
                <tr>
                    <td>
                        <font style="font-size: 8pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center;font-size: 6pt;">
                                <td rowspan="2">NO</td>
                                <td rowspan="2">NO <br>PEGAWAI</td>
                                <td rowspan="2">NAMA</td>
                                <td colspan="4">PERINCIAN GAJI PENGURUS</td>
                                <td rowspan="2">GAJI<br> BRUTO</td>
                                <td colspan="3">POTONGAN</td>
                            </tr>
                            <tr style="text-align:center;font-size: 6pt;">
                                <td>ALL IN</td>
                                <td>KOREKSI</td>
                                <td>KODE<br> PAJAK</td>
                                <td>TUNJANGAN<br> PAJAK</td>
                                <td>IURAN<br> PENSIUN</td>
                                <td>IURAN<br> JAMSOSTEK</td>
                                <td>ANGSURAN</td>
                            </tr>
                            <tr>
                                <td style="padding-left:12px;font-size: 8pt;font-weight: bold" colspan="11">DEWAN KOMISARIS</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->nama }}</td>
                                <td style="text-align:right;">{{ number_format($data->a_upah,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_koreksi,0)}}</td>
                                <td style="text-align:center;">{{ $data->a_kdkeluarga}}</td>
                                <td style="text-align:right;">{{ number_format($data->tunpj,0)}}</td>
                                <?php
                                $a = $data->a_upah;
                                $a1 = $data->a_koreksi;
                                $a2 = $data->tunpj;
                                $pot_pajak = $data->pot_pajak;
                                $pembulatan = $data->pembulatan;
                                $total=$a+$a1+$a2;
                                $potongan =$pot_pajak+$pembulatan;
                                $gajihbersih =$total+$potongan;
                                $subtotala[$a] = $a;
                                 $subtotala1[$a] = $a1;
                                 $subtotala2[$a] = $a2;
                                 $subtotala3[$a] = $pot_pajak;
                                 $subtotala4[$a] = $pembulatan;
                                 $subtotala5[$a] = $gajihbersih;
                                 $subtotala6[$a] = $total;
                                ?>
                                <td style="text-align:right;">{{ number_format($total,0)}}</td>
                                <td style="text-align:right;">{{ $data->pot_pajak <= 0 ? '('.number_format($data->pot_pajak*-1,0).')' : number_format($data->pot_pajak,0)}}</td>
                                <td style="text-align:right;">{{ $data->pembulatan <= 0 ? '('.number_format($data->pembulatan*-1,0).')' : number_format($data->pembulatan,0)}}</td>
                                <td style="text-align:right;">{{ number_format($gajihbersih,0)}}</td>
                            </tr>
                            @endforeach
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">SUB TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala6),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala3) <= 0 ? '('.number_format(array_sum($subtotala3)*-1,0).')' : number_format(array_sum($subtotala3),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala4) <= 0 ? '('.number_format(array_sum($subtotala4)*-1,0).')' : number_format(array_sum($subtotala4),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala5) <= 0 ? '('.number_format(array_sum($subtotala5)*-1,0).')' : number_format(array_sum($subtotala5),0)}}</td>
                            </tr>
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">GRAND TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala6),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala3) <= 0 ? '('.number_format(array_sum($subtotala3)*-1,0).')' : number_format(array_sum($subtotala3),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala4) <= 0 ? '('.number_format(array_sum($subtotala4)*-1,0).')' : number_format(array_sum($subtotala4),0)}}</td>
                                <td style="text-align:right;">{{ array_sum($subtotala5) <= 0 ? '('.number_format(array_sum($subtotala5)*-1,0).')' : number_format(array_sum($subtotala5),0)}}</td>
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
