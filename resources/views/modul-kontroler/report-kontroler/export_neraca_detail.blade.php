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
                    
                    $bulan= strtoupper($array_bln[ltrim($request->bulan,0)]);
                ?>
                <tr>
                <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:30px;"><br>
                   <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 10pt;font-weight: bold ">LAPORAN RUGI LABA</font><br>
                   <font style="font-size: 10pt;"> BULAN BUKU : {{strtoupper($bulan)}} {{ $request->tahun }} </font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <!-- <font style="font-size: 8pt;font-weight: bold"> -->
            
            <table width="100%" style="font-family: sans-serif;table-layout: fixed;width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>
                            <table style="font-size: 8pt;font-weight: bold">
                                <tr>
                                    <td>NO. REPORT</td>
                                    <td>:</td>
                                    <td>CTR002-01</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL REPORT</td>
                                    <td>:</td>
                                    <td>{{ $request->tanggal}}</td>
                                </tr>
                            </table>    
                        </th>
                    </tr>
                    <tr style="font-size: 8pt;">
                        <th width="70%" style="text-align:right;padding-right:40%x;border:1px solid black;">KETERANGAN</th>
                        <tH width="15%" style="text-align:center;border:1px solid black;">SUB<br> AKUN</tH>
                        <th width="30%" style="text-align:center;border:1px solid black;">KUMULASI LALU</th>
                        <th width="30%" style="text-align:center;border:1px solid black;">TRANSAKSI BERJALAN</th>
                        <th width="30%" style="text-align:right;padding-right:20px;border:1px solid black;">KUM. BERJALAN</th>
                    </tr>
                <thead>
                <tbody style="border: 1px solid black;">
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;font-weight: bold;padding-top:20px;border-left:1px solid black;">AKTIVA</td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                    </tr>
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>LANCAR</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 100 and $data->sub_akun <= 109)
                    <?php $no++; 
                        $mmd[$no] = $data->mmd;
                        $mms[$no] = $data->mms;
                        $kons[$no] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd) < 0 ? '('.number_format(array_sum($mmd)*-1,2).')':number_format(array_sum($mmd),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms) < 0 ? '('.number_format(array_sum($mms)*-1,2).')':number_format(array_sum($mms),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons) < 0 ? '('.number_format(array_sum($kons)*-1,2).')':number_format(array_sum($kons),2) }}</td>
                    </tr>

                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>INVESTASI</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no1=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 110 and $data->sub_akun <= 128)
                    <?php $no1++; 
                        $mmd1[$no1] = $data->mmd;
                        $mms1[$no1] = $data->mms;
                        $kons1[$no1] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd1) < 0 ? '('.number_format(array_sum($mmd1)*-1,2).')':number_format(array_sum($mmd1),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms1) < 0 ? '('.number_format(array_sum($mms1)*-1,2).')':number_format(array_sum($mms1),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons1) < 0 ? '('.number_format(array_sum($kons1)*-1,2).')':number_format(array_sum($kons1),2) }}</td>
                    </tr>

                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>AKTIVA TETAP</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no2=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun == 00 or $data->sub_akun == 01)
                    <?php $no2++; 
                        $mmd2[$no2] = $data->mmd;
                        $mms2[$no2] = $data->mms;
                        $kons2[$no2] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd2) < 0 ? '('.number_format(array_sum($mmd2)*-1,2).')':number_format(array_sum($mmd2),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms2) < 0 ? '('.number_format(array_sum($mms2)*-1,2).')':number_format(array_sum($mms2),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons2) < 0 ? '('.number_format(array_sum($kons2)*-1,2).')':number_format(array_sum($kons2),2) }}</td>
                    </tr>

                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>AKTIVA LAIN-LAIN</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no3=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 170 and $data->sub_akun <= 191)
                    <?php $no3++; 
                        $mmd3[$no3] = $data->mmd;
                        $mms3[$no3] = $data->mms;
                        $kons3[$no3] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd3) < 0 ? '('.number_format(array_sum($mmd3)*-1,2).')':number_format(array_sum($mmd3),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms3) < 0 ? '('.number_format(array_sum($mms3)*-1,2).')':number_format(array_sum($mms3),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons3) < 0 ? '('.number_format(array_sum($kons3)*-1,2).')':number_format(array_sum($kons3),2) }}</td>
                    </tr>
                    <tr style="font-size: 8pt;">
                    <?php
                        $mmdtotal = array_sum($mmd)+array_sum($mmd1)+array_sum($mmd2)+array_sum($mmd3);
                        $mmstotal = array_sum($mms)+array_sum($mms1)+array_sum($mms2)+array_sum($mms3);
                        $konstotal = array_sum($kons)+array_sum($kons1)+array_sum($kons2)+array_sum($kons3);
                    ?>
                        <td width="70%" style="text-align:left;font-size: 8pt;font-weight: bold; border:1px solid black;padding-left:20px;">JUMLAH</td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmdtotal < 0 ? '('.number_format($mmdtotal*-1,2).')':number_format($mmdtotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmstotal < 0 ? '('.number_format($mmstotal*-1,2).')':number_format($mmstotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $konstotal < 0 ? '('.number_format($konstotal*-1,2).')':number_format($konstotal,2) }}</td>
                    </tr>

                   
//step 2

                   
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;font-weight: bold;padding-top:20px;border-left:1px solid black;">PASIVA</td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                    </tr>
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>KEWAJIBAN LANCAR</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no4=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 200 and $data->sub_akun <= 206)
                    <?php $no4++; 
                        $mmd4[$no4] = $data->mmd;
                        $mms4[$no4] = $data->mms;
                        $kons4[$no4] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd4) < 0 ? '('.number_format(array_sum($mmd4)*-1,2).')':number_format(array_sum($mmd4),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms4) < 0 ? '('.number_format(array_sum($mms4)*-1,2).')':number_format(array_sum($mms4),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons4) < 0 ? '('.number_format(array_sum($kons4)*-1,2).')':number_format(array_sum($kons4),2) }}</td>
                    </tr>

                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>KEWAJIB. MANFAAT MASA DEPAN</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no5=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 220 and $data->sub_akun <= 400)
                    <?php $no5++; 
                        $mmd5[$no5] = $data->mmd;
                        $mms5[$no5] = $data->mms;
                        $kons5[$no5] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd5) < 0 ? '('.number_format(array_sum($mmd5)*-1,2).')':number_format(array_sum($mmd5),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms5) < 0 ? '('.number_format(array_sum($mms5)*-1,2).')':number_format(array_sum($mms5),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons5) < 0 ? '('.number_format(array_sum($kons5)*-1,2).')':number_format(array_sum($kons5),2) }}</td>
                    </tr>

                    <tr >
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>EKUITAS</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $no6=0; ?>
                    @foreach($data_list as $data)
                    @if($data->sub_akun >= 300 and $data->sub_akun < 400)
                    <?php $no6++; 
                        $mmd6[$no6] = $data->mmd;
                        $mms6[$no6] = $data->mms;
                        $kons6[$no6] = $data->kons;
                    ?>
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">{{ $data->jenis}}</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">{{ $data->sub_akun}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mmd,0) < 0 ? '('.number_format($data->mmd*-1,2).')':number_format($data->mmd,2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{number_format($data->mms,0) < 0 ? '('.number_format($data->mms*-1,2).')':number_format($data->mms,2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format($data->kons,0) < 0 ? '('.number_format($data->kons*-1,2).')':number_format($data->kons,2)}}</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr style="font-size: 8pt;">
                        <td width="70%" style="text-align:left;font-size: 8pt;padding-left:20px;border-left:1px solid black;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mmd6) < 0 ? '('.number_format(array_sum($mmd6)*-1,2).')':number_format(array_sum($mmd6),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mms6) < 0 ? '('.number_format(array_sum($mms6)*-1,2).')':number_format(array_sum($mms6),2) }}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($kons6) < 0 ? '('.number_format(array_sum($kons6)*-1,2).')':number_format(array_sum($kons6),2) }}</td>
                    </tr>
                   
                    <tr style="font-size: 8pt;">
                    <?php
                        $mmdtotal =array_sum($mmd4)+array_sum($mmd5)+array_sum($mmd6);
                        $mmstotal =array_sum($mms4)+array_sum($mms5)+array_sum($mms6);
                        $konstotal =array_sum($kons4)+array_sum($kons5)+array_sum($kons6);
                    ?>
                        <td width="70%" style="text-align:left;font-size: 8pt;font-weight: bold; border:1px solid black;padding-left:10px;">JUMLAH</td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmdtotal < 0 ? '('.number_format($mmdtotal*-1,2).')':number_format($mmdtotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmstotal < 0 ? '('.number_format($mmstotal*-1,2).')':number_format($mmstotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $konstotal < 0 ? '('.number_format($konstotal*-1,2).')':number_format($konstotal,2) }}</td>
                    </tr>

                    <tr style="font-size: 8pt;">
                    <?php
                        $mmdtotal = array_sum($mmd)+array_sum($mmd1)+array_sum($mmd2)+array_sum($mmd3)+array_sum($mmd4)+array_sum($mmd5)+array_sum($mmd6);
                        $mmstotal = array_sum($mms)+array_sum($mms1)+array_sum($mms2)+array_sum($mms3)+array_sum($mms4)+array_sum($mms5)+array_sum($mms6);
                        $konstotal = array_sum($kons)+array_sum($kons1)+array_sum($kons2)+array_sum($kons3)+array_sum($kons4)+array_sum($kons5)+array_sum($kons6);
                    ?>
                        <td width="70%" style="text-align:left;font-size: 8pt;font-weight: bold; border:1px solid black;">JUMLAH</td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmdtotal < 0 ? '('.number_format($mmdtotal*-1,2).')':number_format($mmdtotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $mmstotal < 0 ? '('.number_format($mmstotal*-1,2).')':number_format($mmstotal,2) }}</td>
                        <td width="30%" style="text-align:right;font-size: 8pt;font-weight: bold;border:1px solid black;">{{ $konstotal < 0 ? '('.number_format($konstotal*-1,2).')':number_format($konstotal,2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table width="100%"  style=" padding-left:30px;;padding-right:20px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt; padding-left:50%;">
                            <tr style="font-size: 10pt;">
                                <td align="center" width="200" style="padding-bottom:5%;">JAKARTA, {{strtoupper($request->tanggal)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:50%">
                            <tr style="font-size: 10pt; font-weight: bold">
                                <td align="center" width="200"><u>Wasono Hastoatmodjo</u></td>
                            </tr>
                            <tr style="font-size: 10pt; font-weight: bold">
                                <td align="center" width="200">Manajer Kontroler</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </main>
        
    </body>
</html>
