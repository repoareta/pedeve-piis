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
                    
                    $bulan= strtoupper($array_bln[ltrim($request->bulan,0)]);
                ?>
                <tr>
                <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:30px;"><br>
                   <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 10pt;font-weight: bold ">LAPORAN D2 KAS/BANK</font><br>
                   <font style="font-size: 10pt;font-weight: bold "> BULAN  {{strtoupper($bulan) }} {{ $request->tahun }} </font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
            <table width="100%" style="font-family: sans-serif;border-collapse: collapse;" border="1">
                <thead>
                    <tr style="text-align:center;font-size: 8pt;">
                        <td>TANGGAL</td>
                        <td>NODOK</td>
                        <td>JK</td>
                        <td>ST</td>
                        <td>VC</td>
                        <td>CI</td>
                        <td>LP</td>
                        <td>SANDI</td>
                        <td>CJ</td>
                        <td>JUMLAH RUPIAH</td>
                        <td>JUMLAH DOLAR</td>
                        <td>KURS</td>
                        <td>KETERANGAN</td>
                        <td>TANGGL BAYAR</td>
                    </tr>
                <thead>
                <tbody>
                    <?php $a=0; ?>
                    @foreach($data_list as $data)
                    <?php $a++ ?>
                    <tr style="text-align:center;font-size: 8pt;">
                        <td>{{ $data->tglbayar}}</td>
                        <td>{{ $data->docno }}</td>
                        <td>{{ $data->jk}}</td>
                        <td>{{ $data->store }}</td>
                        <td>{{ $data->voucher }}</td>
                        <td>{{ $data->ci}}</td>
                        <td>{{ $data->lokasi}}</td>
                        <td>{{ $data->account}}</td>
                        <td>{{ $data->cj}}</td>
                        <?php
                            if($data->ci == 1){ 
                                 $jmlrp = number_format($data->totprice,0); 
                            }elseif($data->ci == 2){ 
                                $jmlrp = number_format($data->totprice * $data->rate); 
                            } else { 
                                $jmlrp = '0'; 
                            }
                            if($data->ci == 2){ 
                                 $jmldl = number_format($data->totprice,0); 
                            } else { 
                                $jmldl = '0'; 
                            }
                        ?>
                        <td style="text-align:right;">{{ $jmlrp < 0 ? $jmlrp : $jmlrp}}</td>
                        <td style="text-align:right;">{{ $jmldl < 0 ? $jmldl : $jmldl}}</td>
                        <td style="text-align:right;">{{ $data->ci == 1 ? '' : $data->rate}}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{ $data->tglbayar}}</td>

                    </tr>
                    <?php 
                        // $rup[$a] = $data->rate <= 0 ? number_format($data->totprice,0) : number_format($data->totprice);
                        // $dol[$a] = $data->ci == 2 ? number_format($data->totprice) : '0';
                      ?>
                    @endforeach
                <tbody>
            </table>
        </main>
        
    </body>
</html>
