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
                   <font style="font-size: 10pt;"> BULAN BUKU : {{strtoupper($bulan)}} {{$request->tahun}} </font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <!-- <font style="font-size: 8pt;font-weight: bold"> -->
            <table style="font-size: 8pt;font-weight: bold">
                <tr>
                    <td>NO. REPORT</td>
                    <td>:</td>
                    <td>CTR002-01</td>
                </tr>
                <tr>
                    <td>TANGGAL REPORT</td>
                    <td>:</td>
                    <td>{{$request->tanggal}}</td>
                </tr>
            </table>
            <table width="100%" style="font-family: sans-serif;table-layout: fixed;width: 100%; border-collapse: collapse;border: 1px solid black;">
                <thead>
                    <tr style="font-size: 9pt;">
                        <th width="70%" style="text-align:right;padding-right:40%x;border-right:1px solid black;">KETERANGAN</th>
                        <tH width="15%" style="text-align:center;border-right:1px solid black;">SUB<br> AKUN</tH>
                        <th width="30%" style="text-align:center;border-right:1px solid black;">KOMULASI<br> LALU</th>
                        <th width="30%" style="text-align:center;border-right:1px solid black;">TRANSAKSI<br> BERJALAN</th>
                        <th width="30%" style="text-align:right;padding-right:20px;border-right:1px solid black;">KOMULASI<br> BERJALAN</th>
                    </tr>
                <thead>
            </table>
            <table width="100%" style="font-family: sans-serif;table-layout: fixed;width: 100%; border-collapse: collapse;border: 1px solid black;">
                <tbody>
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 9pt;font-weight: bold;padding-top:20px;border-left:1px solid black;">HASIL HASIL</td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                    </tr>
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 9pt;padding-left:20px;border-left:1px solid black;"><u>PENDAPATAN OPERASI</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <?php $a=0; ?>
                    @foreach($data_list as $data)
                    <?php $a++; ?>
                        <?php
                            if(substr($data->sandi, 0, 3) == 400 and $data->lapangan=='MD'){
                                $mdupah1[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah1[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 400 and $data->lapangan=='MS'){
                                $msupah1[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah1[$a] = "0";
                            }
                            
                            if(substr($data->sandi, 0, 3) == 409 and $data->lapangan=='MD'){
                                $mdupah2[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah2[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 409 and $data->lapangan=='MS'){
                                $msupah2[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah2[$a] = "0";
                            }

                            if(substr($data->sandi, 0, 3) == 420 and $data->lapangan=='MD'){
                                $mdupah3[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah3[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 420 and $data->lapangan=='MS'){
                                $msupah3[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah3[$a] = "0";
                            }
                        ?>
                    @endforeach
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">BUNGA DEPOSITO</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">400</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah1) < 0 ? "(".number_format(array_sum($mdupah1)*-1,2).")" : number_format(array_sum($mdupah1),2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah1) < 0 ? "(".number_format(array_sum($msupah1)*-1,2).")" : number_format(array_sum($msupah1),2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah1) + array_sum($msupah1),2) < 0  ? "(".number_format((array_sum($mdupah1) + array_sum($msupah1)*-1),2).")" : number_format(array_sum($mdupah1) + array_sum($msupah1),2)}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x; border-left:1px solid black;">JASA GIRO</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">409</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah2) < 0 ? "(".number_format(array_sum($mdupah2)*-1,2).")" : number_format(array_sum($mdupah2),2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah2) < 0 ? "(".number_format(array_sum($msupah2)*-1,2).")" : number_format(array_sum($msupah2),2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah2) + array_sum($msupah2),2) < 0 ? "(".number_format((array_sum($mdupah2) + array_sum($msupah2))*-1,2).")" : number_format(array_sum($mdupah2) + array_sum($msupah2),2)}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;padding-bottom:10px;">HASIL LAIN-LAIN</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;padding-bottom:10px;">420</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah3) < 0 ? "(".number_format(array_sum($mdupah3)*-1,2).")" : number_format(array_sum($mdupah3),2)}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah3) < 0 ? "(".number_format(array_sum($msupah3)*-1,2).")" : number_format(array_sum($msupah3),2)}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah3) + array_sum($msupah3),2) < 0 ? "(".number_format((array_sum($mdupah3) + array_sum($msupah3))*-1,2).")" : number_format(array_sum($mdupah3) + array_sum($msupah3),2)}}</td>
                    </tr>
                    <tr >
                    <?php
                            $subtotalmd = array_sum($mdupah1)+array_sum($mdupah2)+array_sum($mdupah3);
                            $subtotalms = array_sum($msupah1)+array_sum($msupah2)+array_sum($msupah3);
                        ?>
                        <td width="70%" style="text-align:left;font-size: 9pt;font-weight: bold; border:1px solid black;padding-left:10px;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalmd < 0 ? "(".number_format($subtotalmd*-1,2).")" : number_format($subtotalmd,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalms < 0 ? "(".number_format($subtotalms*-1,2).")" : number_format($subtotalms,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalmd+$subtotalms < 0 ? "(".number_format(($subtotalmd+$subtotalms)*-1,2).")" : number_format($subtotalmd+$subtotalms,2)}}</th>
                    </tr>

                    <?php $a=0; ?>
                    @foreach($data_list as $data)
                    <?php $a++; ?>
                        <?php
                            if(substr($data->sandi, 0, 3) == 500 and $data->lapangan=='MD'){
                                $mdupah4[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah4[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 500 and $data->lapangan=='MS'){
                                $msupah4[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah4[$a] = "0";
                            }

                            if(substr($data->sandi, 0, 3) == 510 and $data->lapangan=='MD'){
                                $mdupah5[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah5[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 510 and $data->lapangan=='MS'){
                                $msupah5[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah5[$a] = "0";
                            }
                            
                            if (substr($data->sandi, 0, 3) == 512 and $data->sub_akun== 510 and $data->lapangan=='MD') {
                                if ($data->sandi =='512011') {
                                    $mdupah6[$a] =  $data->pengali_tampil*$data->last_rp ;
                                } else {
                                    $mdupah6[$a] =  "0" ;
                                }
                            }elseif(substr($data->sandi, 0, 3) == 512 and $data->sub_akun== 512 and $data->lapangan=='MD'){
                                    if ($data->sandi =='512011') {
                                        $mdupah6[$a] =  "0" ;
                                    } else {
                                        $mdupah6[$a] =  $data->pengali_tampil*$data->last_rp ;
                                    }
                            }else{ 
                                $mdupah6[$a] = "0";
                            }
                            if (substr($data->sandi, 0, 3) == 512 and $data->sub_akun== 510 and $data->lapangan=='MS') {
                                if ($data->sandi =='512011') {
                                    $msupah6[$a] =  $data->pengali_tampil*$data->cur_rp ;
                                } else {
                                    $msupah6[$a] =  "0" ;
                                }
                            }elseif(substr($data->sandi, 0, 3) == 512 and $data->sub_akun== 512 and $data->lapangan=='MS'){
                                    if ($data->sandi =='512011') {
                                        $msupah6[$a] =  "0" ;
                                    } else {
                                        $msupah6[$a] =  $data->pengali_tampil*$data->cur_rp ;
                                    }

                            }else{ 
                                $msupah6[$a] = "0";
                            }
                            
                            if(substr($data->sandi, 0, 3) == 516 and $data->lapangan=='MD'){
                                $mdupah7[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah7[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 516 and $data->lapangan=='MS'){
                                $msupah7[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah7[$a] = "0";
                            }

                            if(substr($data->sandi, 0, 3) == 530 and $data->lapangan=='MD'){
                                $mdupah8[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah8[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 530 and $data->lapangan=='MS'){
                                $msupah8[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah8[$a] = "0";
                            }

                            if(substr($data->sandi, 0, 3) == 540 and $data->lapangan=='MD'){
                                $mdupah9[$a] =  $data->pengali_tampil*$data->last_rp ;
                            }else{ 
                                $mdupah9[$a] = "0";
                            }
                            if(substr($data->sandi, 0, 3) == 540 and $data->lapangan=='MS'){
                                $msupah9[$a] =  $data->pengali_tampil*$data->cur_rp ;
                            }else{ 
                                $msupah9[$a] = "0";
                            }
                            
                            
                        ?>
                    @endforeach
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 9pt;font-weight: bold;padding-top:20px;border-left:1px solid black;">BIAYA-BIAYA</td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                        <td width="30%"  style="border-left:1px solid black;"></td>
                    </tr>
                    <tr >
                        <td width="70%" style="text-align:left;font-size: 9pt;padding-left:20px;border-left:1px solid black;"><u>BIAYA OPERASI</u></td>
                        <td width="15%" style="text-align:right;border-left:1px solid black;" ></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                        <td width="30%" style="border-left:1px solid black;"></td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">BIAYA PEGAWAI</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">500</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah4) >= 0 ? number_format(array_sum($mdupah4),2) : "(".number_format(array_sum($mdupah4)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah4) >= 0 ? number_format(array_sum($msupah4),2) : "(".number_format(array_sum($msupah4)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah4) + array_sum($msupah4),2) >= 0 ? number_format(array_sum($mdupah4) + array_sum($msupah4),2) : "(".number_format(array_sum($mdupah4) + array_sum($msupah4)*-1,2).")"}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x; border-left:1px solid black;">BIAYA KANTOR</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">510</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah5) >= 0 ? number_format(array_sum($mdupah5),2) : "(".number_format(array_sum($mdupah5)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah5) >= 0 ? number_format(array_sum($msupah5),2) : "(".number_format(array_sum($msupah5)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah5) + array_sum($msupah5),2) >= 0 ? number_format(array_sum($mdupah5) + array_sum($msupah5),2) : "(".number_format(array_sum($mdupah5) + array_sum($msupah5)*-1,2).")"}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">BIAYA JASA PIHAK KETIGA</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">512</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah6) >= 0 ? number_format(array_sum($mdupah6),2) : "(".number_format(array_sum($mdupah6)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah6) >= 0 ? number_format(array_sum($msupah6),2) : "(".number_format(array_sum($msupah6)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah6) + array_sum($msupah6),2) >= 0 ? number_format(array_sum($mdupah6) + array_sum($msupah6),2) : "(".number_format(array_sum($mdupah6) + array_sum($msupah6)*-1,2).")"}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;">BIAYA PENYUSUTAN</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">516</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah7) >= 0 ? number_format(array_sum($mdupah7),2) : "(".number_format(array_sum($mdupah7)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah7) >= 0 ? number_format(array_sum($msupah7),2) : "(".number_format(array_sum($msupah7)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah7) + array_sum($msupah7),2) >= 0 ? number_format(array_sum($mdupah7) + array_sum($msupah7),2) : "(".number_format(array_sum($mdupah7) + array_sum($msupah7)*-1,2).")"}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x; border-left:1px solid black;">BEBAN ALOKASI</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;">530</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($mdupah8) >= 0 ? number_format(array_sum($mdupah8),2) : "(".number_format(array_sum($mdupah8)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;">{{array_sum($msupah8) >= 0 ? number_format(array_sum($msupah8),2) : "(".number_format(array_sum($msupah8)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah8) + array_sum($msupah8),2) >= 0 ? number_format(array_sum($mdupah8) + array_sum($msupah8),2) : "(".number_format(array_sum($mdupah8) + array_sum($msupah8)*-1,2).")"}}</td>
                    </tr>
                    <tr style="font-size: 9pt;">
                        <td width="70%" style="padding-left:25%x;border-left:1px solid black;padding-bottom:10px;">SELISIH KURS</td>
                        <td width="15%" style="text-align:center;border-left:1px solid black;padding-bottom:10px;">540</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;padding-bottom:10px;">{{array_sum($mdupah9) >= 0 ? number_format(array_sum($mdupah9),2) : "(".number_format(array_sum($mdupah9)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;border-left:1px solid black;padding-bottom:10px;">{{array_sum($msupah9) >= 0 ? number_format(array_sum($msupah9),2) : "(".number_format(array_sum($msupah9)*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;padding-left:20px;border-left:1px solid black;">{{number_format(array_sum($mdupah9) + array_sum($msupah9),2) >= 0 ? number_format(array_sum($mdupah9) + array_sum($msupah9),2) : "(".number_format(array_sum($mdupah9) + array_sum($msupah9)*-1,2).")"}}</td>
                    </tr>
                    <tr >
                    <?php
                            $subtotalmd1 = array_sum($mdupah4)+array_sum($mdupah5)+array_sum($mdupah6)+array_sum($mdupah7)+array_sum($mdupah8)+array_sum($mdupah9);
                            $subtotalms1 = array_sum($msupah4)+array_sum($msupah5)+array_sum($msupah6)+array_sum($msupah7)+array_sum($msupah8)+array_sum($msupah9);
                        ?>
                        <td width="70%" style="text-align:left;font-size: 9pt;font-weight: bold; border:1px solid black;padding-left:10px;"><u>JUMLAH</u></td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalmd1 >= 0 ? number_format($subtotalmd1,2) : "(".number_format($subtotalmd1*-1,2).")"}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalms1 >= 0 ? number_format($subtotalms1,2) : "(".number_format($subtotalms1*-1,2).")"}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$subtotalmd1+$subtotalms1 >= 0 ? number_format($subtotalmd1+$subtotalms1,2) : "(".number_format(($subtotalmd1+$subtotalms1)*-1,2).")"}}</th>
                    </tr>
                    <tr >
                    <?php
                            $totalmd = $subtotalmd+$subtotalmd1;
                            $totalms = $subtotalms+$subtotalms1;
                        ?>
                        <td width="70%" style="text-align:left;font-size: 9pt;font-weight: bold; border:1px solid black;">JUMLAH</td>
                        <td width="15%" style="text-align:right;border:1px solid black;" ></td>
                        <td width="30%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$totalmd >= 0 ? number_format($totalmd,2) : "(".number_format($totalmd*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$totalms >= 0 ? number_format($totalms,2) : "(".number_format($totalms*-1,2).")"}}</td>
                        <td width="30%" style="text-align:right;font-size: 9pt;font-weight: bold;border:1px solid black;">{{$totalmd+$totalms >= 0 ?  number_format($totalmd+$totalms,2) : "(".number_format(($totalmd+$totalms)*-1,2).")"}}</td>
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
