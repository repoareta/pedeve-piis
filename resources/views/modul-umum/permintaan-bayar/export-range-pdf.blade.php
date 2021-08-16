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
                margin-top: 5cm;
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
            <table width="100%"  >
                <tr>
                    <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:50px;"><br>
                   <font style="font-size: 12pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 12pt;font-weight: bold ">REKAP PERMINTAAN BAYAR</font><br>
                   <?php 
                    foreach ($bayar_header_list as $bayar){
                        $tglbayar=$bayar->tgl_bayar;
                    }
                   ?>
                   <font style="font-size: 12pt;font-weight: bold ">BULAN {{ $bulan }} {{ $tahun }}</font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table border="1" style="margin-top:10px;width:100%;border-collapse: collapse;font-size: 10pt;" class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO. BAYAR</th>
                    <th>NO. KAS</th>
                    <th>KEPADA</th>
                    <th>KETERANGAN</th>
                    <th>LAMPIRAN</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=0; ?>
                @foreach ($bayar_header_list as $bayar)
                <?php $no++; ?>
                    <tr>
                        <td align="center">{{ $no }}</td>
                        <td>{{ $bayar->no_bayar }}</td>
                        <td>{{ $bayar->no_kas }}</td>
                        <td>{{ $bayar->kepada }}</td>
                        <td>{{ $bayar->keterangan }}</td>
                        <td>{{ $bayar->lampiran }}</td>
                        <td>Rp.  <?php echo number_format($bayar->nilai, 0, ',', '.'); ?></td>
                    
                    </tr>
                @endforeach
            </tbody>
            </table>
        </main>
        <table  width="100%" style="font-weight: bold;font-size: 10pt;">
            <thead>
                <tr>
                    <td align="right">TOTAL : Rp. </td>
                    @foreach ($bayar_header_list_total as $bayar)
                    <td align="center" width="65"><?php echo number_format($bayar->nilai, 0, ',', '.'); ?></td>
                    @endforeach
                </tr>
            </thead>
        </table>
    </body>
</html>
