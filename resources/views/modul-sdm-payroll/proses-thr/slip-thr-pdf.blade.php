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
            <table width="100%" style="font-family: sans-serif;">
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
                    <td align="left" style="padding-left:30px;">
                        <font style="font-size: 12pt;font-weight: bold "> Slip THR</font><br>
                        <font style="font-size: 12pt;font-weight: bold ">PT.PERTAMINA DANA VENTURA</font><br>
                        <table border="1" style="border-collapse: collapse; font-size: 10pt;text-align:center;" width="95%">
                            <tr bgcolor="#A9A9A9">
                                <td >Slip THR Bulan/Tahun</td>
                                <td>Payroll Area</td>
                            </tr>
                            <tr>
                                <td>{{ $bulan }} {{strtoupper($request->tahun)}}</td>
                                <td>PDV</td>
                            </tr>
                        </table>
                        <table style=" font-size: 10pt;text-align:left;font-weight: bold" width="95%">
                            <?php foreach($data_list as $data_pegawai)
                            {
                                $nama_pegawai = $data_pegawai->nama_pegawai;
                                $nopek = $data_pegawai->nopek;
                            } ?>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{strtoupper($nama_pegawai)}}</td>
                            </tr>
                            <tr>
                                <td>Nopek</td>
                                <td>:</td>
                                <td>{{ $nopek}}</td>
                            </tr>
                        </table>
                            <td align="center" style="padding-left:150px;">
                            <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:30px;">
                    </td>
                </tr>
            </table>


            <table width="100%" style="font-family: sans-serif;padding-left:30px;padding-right:30px;">
                <tr style=" font-size: 10pt;text-align:center;font-weight: bold">
                    <td  colspan="2">LEMBAR RINCIAN</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style=" font-size: 10pt;text-align:center;font-weight: bold">
                                <td>Jenis</td>
                                <td>Komponen Upah</td>
                                <td>Keterangan</td>
                                <td>Jumlah</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)

                            <tr style=" font-size: 8pt;">
                                <td style=" text-align:left;">{{ $data->nama_upah}}</td>
                                <td style=" text-align:center;">{{ $data->aard}}</td>
                                <td style=" text-align:left;">{{ $data->nama_aard}}</td>
                                <td style=" text-align:right;">{{ $data->nilai == 0 ? '-' : number_format($data->nilai,2,',','.') }}</td>
                            </tr>
                                <?php $a++;
                                $total[$a] = $data->nilai; ?>
                            @endforeach
                            <tr>
                                <td style=" font-size: 10pt;text-align:right;" colspan="3"><font style=" text-align:right; padding-right:2%;">Sub Total : </td>
                                <td style=" font-size: 10pt;text-align:right;font-weight: bold"   >{{ number_format(array_sum($total),2,',','.') }} </td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_detail as $data)
                            <tr style=" font-size: 8pt;">
                                <td style=" text-align:left;">{{ $data->nama_upah}}</td>
                                <td style=" text-align:center;">{{ $data->aard}}</td>
                                <td style=" text-align:left;">{{ $data->nama_aard}}</td>
                                <td style=" text-align:right;">{{ $data->nilai == 0 ? '-' : number_format($data->nilai,2,',','.') }}</td>
                            </tr>
                                <?php $a++;
                                $totaldetail[$a] = $data->nilai; ?>
                            @endforeach
                            <tr>
                            <?php $total_bersih = array_sum($total) + array_sum($totaldetail); ?>
                                <td style=" font-size: 10pt;text-align:right;" colspan="3"><font style=" text-align:right; padding-right:2%;">Penghasilan Bersih : </td>
                                <td style=" font-size: 10pt;text-align:right;font-weight: bold"   >{{ number_format($total_bersih,2,',','.') }} </td>
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
