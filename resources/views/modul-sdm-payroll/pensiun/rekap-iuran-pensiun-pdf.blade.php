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
                margin-bottom: 1cm;
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

        <title>REKAP IURAN DANA PENSIUN</title>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%" >
                <tr>
                    <td align="left" style="padding-left:80px;">
                        <table>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA</font></td>
                            </tr>
                            <tr>
        <td><font style="font-size: 12pt;font-weight: bold ">REKAP IURAN DANA PENSIUN <?php if($request->dp == 'BK'){ ?> (BEBAN PEKERJA) <?php }else{ ?> (BEBAN PERUSAHAAN) <?php } ?>  </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">TAHUN {{ $request->tahun}}</font></td>
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
            <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
            <table width="100%" style="font-size: 10pt;border-collapse: collapse;" border="1">
                <tr style="text-align:center; font-weight: bold">
                    <td >NO</td>
                    <td >NOPEK</td>
                    <td >NAMA</td>
                    <td >JAN</td>
                    <td >FEB</td>
                    <td >MARET</td>
                    <td >APRIL</td>
                    <td >MEI</td>
                    <td >JUNI</td>
                    <td >JULI</td>
                    <td >AGUSTUS</td>
                    <td >SEPT</td>
                    <td >OKT</td>
                    <td >NOV</td>
                    <td >DES</td>
                </tr>
                <?php $a=0; ?>
                @foreach($data_list as $data)
                    <?php $a++;
                    $JAN[$a] = $data->jan; $FEB[$a] = $data->feb; $MAR[$a] = $data->mar; $APR[$a] = $data->apr; 
                    $MEI[$a] = $data->mei; $JUN[$a] = $data->jun; $JUL[$a] = $data->jul; $AGU[$a] = $data->agu; $SEP[$a] = $data->sep;
                    $OKT[$a] = $data->okt; $NOV[$a] = $data->nov; $DES[$a] = $data->des;?>
                <tr>
                    <td style="text-align:center;">{{ $a}}</td>
                    <td style="text-align:center;">{{ $data->nopek}}</td>
                    <td style="text-align:left;">{{ $data->namapegawai}}</td>
                    <td style="text-align:right;">{{ number_format($data->jan,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->feb,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->mar,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->apr,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->mei,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->jun,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->jul,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->agu,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->sep,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->okt,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->nov,2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format($data->des,2,',','.') }}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold">
                    <td colspan="3" style="text-align:right;">Total:</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($JAN),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($FEB),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($MAR),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($APR),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($MEI),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($JUN),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($JUL),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($AGU),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($SEP),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($OKT),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($NOV),2,',','.') }}</td>
                    <td style="text-align:right;" >{{ number_format(array_sum($DES),2,',','.') }}</td>
                </tr>
            </table>         
        </main>
    </body>
</html>