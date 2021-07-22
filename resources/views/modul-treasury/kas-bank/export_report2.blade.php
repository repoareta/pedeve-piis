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
                                <td><font style="font-size: 10pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 10pt;font-weight: bold ">DAFTAR RINCIAN PER NO. BUKTI</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 10pt;font-weight: bold ">BULAN {{strtoupper($bulan)}} {{$request->tahun}}</font></td>
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
                        <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{$request->tanggal}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center;font-size: 8pt;">
                                <td>BULAN</td>
                                <td>JK</td>
                                <td>NOKAS</td>
                                <td>CI</td>
                                <td>NO.BUKTI</td>
                                <td>REKAP</td>
                                <td>DEBET</td>
                                <td>KREDIT</td>
                                <td>SELISIH</td>
                            </tr>
                            @foreach($data_list as $data)
                            <tr>
                                <td>{{$data->bulan}}</td>
                                <td>{{$data->jk}}</td>
                                <td>{{$data->store}}</td>
                                <td>{{$data->ci}}</td>
                                <td>{{$data->voucher}}</td>
                                <td>{{$data->rekap}}</td>
                                <td>{{$data->totprice > 0 ? number_format($data->totprice,0) : '0'}}</td>
                                <td>{{$data->totprice < 0 ? number_format($data->totprice,0) : '0'}}</td>
                                
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
        </main>
        
    </body>
</html>
