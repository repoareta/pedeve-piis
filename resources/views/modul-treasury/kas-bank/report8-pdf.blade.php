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
                    
                    // $bulan= strtoupper($array_bln[ltrim($bulan,0)]);
                ?>
                <tr>
                <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:30px;"><br>
                   <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 10pt;font-weight: bold ">LAPORAN - ARUS KAS</font><br>
                   <font style="font-size: 10pt;font-weight: bold "> PERIODE: {{ Carbon\Carbon::parse($mulai)->format('d F Y')." s/d ".Carbon\Carbon::parse($sampai)->format('d F Y') }} </font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ Carbon\Carbon::now()->toDateString() }}</font>
            <table width="100%" style="font-family: sans-serif;border-collapse: collapse;" border="1">
                <thead>
                    <tr>
                        <th rowspan="2">Keterangan</th>
                        <th colspan="4">Total</th>
                    </tr>
                    <tr>
                        <th>RUPIAH</th>
                        <th>US$</th>
                        <th>EKIVALEN US$</th>
                        <th>JML RP + EKIV US$</th>
                    </tr>
                <thead>
                <tbody>
                    <tr>
                        <td>
                            A. ARUS KAS DARI AKTIVITAS OPERASI
                        </td>
                        <td>
                            B. ARUS KAS DARI AKTIVITAS INVESTASI
                        </td>
                        <td>
                            C. ARUS KAS DARI AKTIVITAS PENDANAAN
                        </td>
                    </tr>
                <tbody>
            </table>
        </main>
    </body>
</html>
