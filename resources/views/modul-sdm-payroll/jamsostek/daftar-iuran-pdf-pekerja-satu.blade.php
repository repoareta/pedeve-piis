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
            <table width="100%">
                <tr>
                    <td align="left" style="padding-left:40px;">
                        <table>
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
                                <td><font style="font-size: 12pt;font-weight: bold ">PT PERTAMINA PEDEVE INDONESIA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR IURAN BPJSTK PEKERJA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">BULAN {{ $bulan }} {{ $request->tahun }}</font></td>
                            </tr>
                        </table>
                    </td>

                    <td align="center" style="">
                        <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:40px;">
                    </td>
                </tr>
            </table>

            <table width="100%" style="padding-top:6%; padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt;border-collapse: collapse;" border="1">
                            <tr style="text-align:center; font-weight: bold">
                                <td rowspan="2">NO</td>
                                <td rowspan="2">NO. ASTEK</td>
                                <td rowspan="2">NO. PEK</td>
                                <td rowspan="2">NAMA</td>
                                <td rowspan="2">UPAH TETAP</td>
                                <td rowspan="2">JAMINAN KEC. KERJA</td>
                                <td colspan="2">JAMINAN HARI TUA</td>
                                <td rowspan="2">JAMINAN KEMATIAN</td>
                                <td rowspan="2">TOTAL</td>
                            </tr>
                            <tr style="text-align:center; font-weight: bold">
                                <td >PT PDV</td>
                                <td >PEGAWAI</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php $a++; ?>
                            <tr>
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->noastek}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->namapegawai}}</td>
                                <td style="text-align:right;">{{ number_format(round($data->gapok,0))}}</td>
                                <td style="text-align:right;">{{ number_format(round($data->jkk,0))}}</td>
                                <td style="text-align:right;">{{ number_format(round($data->pensiun,0))}}</td>
                                <td style="text-align:right;">{{ number_format(round($data->pribadi,0))}}</td>
                                <td style="text-align:right;">{{ number_format(round($data->life,0))}}</td>
                            <?php
                                $total = round($data->jkk,0)+round($data->pensiun,0)+round($data->pribadi,0)+round($data->life,0);
                                $totalgapok[$a] = round($data->gapok,0);
                                $totaljkk[$a] = round($data->jkk,0);
                                $totalpensiun[$a] = round($data->pensiun,0);
                                $totalpribadi[$a] = round($data->pribadi,0);
                                $totallife[$a] = round($data->life,0);
                                $totaltotal[$a] = $total;
                            ?>
                                <td style="text-align:right;">{{ number_format(round($total,0))}}</td>
                            </tr>
                            @endforeach
                            <tr style="font-weight: bold;">
                               <td style="text-align:right;" colspan="4">TOTAL</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totalgapok),0)}}</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totaljkk),0)}}</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totalpensiun),0)}}</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totalpribadi),0)}}</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totallife),0)}}</td>
                               <td style="text-align:right;">{{ number_format(array_sum($totaltotal),0)}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table width="100%" style=" padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt; padding-left:50%;">
                            <tr style="font-size: 10pt;">
                                <td align="center" width="200">JAKARTA, {{strtoupper($request->tanggal)}}</td><br>
                            </tr>
                            <tr style="font-size: 10pt; font-weight: bold">
                                <td align="center" width="200">{{strtoupper($request->jabatan)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:50%">
                            <tr style="font-size: 10pt; font-weight: bold">
                                <td align="center" width="200">{{strtoupper($request->nama)}}</td><br>
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
