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

        <title>REKAP UANG MUKA KERJA</title>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <table width="100%"  >
                <tr>
                    <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:70px;"><br>
                   <font style="font-size: 12pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 12pt;font-weight: bold ">REKAP UANG MUKA KERJA</font><br>
                   <?php 
                    foreach ($umk_header_list as $umk){
                        $tglpanjar=$umk->tgl_panjar;
                    }
                   ?>
                   <font style="font-size: 12pt;font-weight: bold ">BULAN {{$bulan}} {{$tahun}}</font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table width="100%"  border="1" style="margin-top:30px;width:100%;border-collapse: collapse;font-size: 10pt;" class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO. UMK</th>
                    <th>NO. KAS</th>
                    <th>KEPADA</th>
                    <th>KETERANGAN</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
            <?php $no=0; ?>
                @foreach ($umk_header_list as $umk)
                <?php $no++; ?>
                    <tr>
                        <td align="center">{{ $no }}</td>
                        <td>{{ $umk->no_umk }}</td>
                        <td>{{ $umk->no_kas }}</td>
                        <td>{{ $umk->kepada }}</td>
                        <td>{{ $umk->keterangan }}</td>
                        <td>Rp.  <?php echo number_format($umk->jumlah, 0, ',', '.'); ?></td>
                    
                    </tr>
                @endforeach
            </tbody>
            </table>
        </main>
        <table  width="100%" style="font-weight: bold;font-size: 10pt;">
            <thead>
                <tr>
                    <td align="right">TOTAL : Rp. </td>
                    <td align="center" width="65"><?php echo number_format($list_acount, 0, ',', '.'); ?></td>
                </tr>
            </thead>
        </table>
    </body>
</html>