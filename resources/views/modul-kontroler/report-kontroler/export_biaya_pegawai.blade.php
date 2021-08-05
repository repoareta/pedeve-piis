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
                <tr>
                <td align="center" style="padding-left:200px;">
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="120px" height="60px"  style="padding-right:30px;"><br>
                   <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                   <font style="font-size: 10pt;font-weight: bold ">RINCIAN BIAYA PEGAWAI DAN KANTOR</font><br>
                   <font style="font-size: 10pt;"> PERIODE : {{ $request->bulan1}} S/D {{ $request->bulan2}} {{ $request->tahun }} </font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <!-- <font style="font-size: 8pt;font-weight: bold"> -->
            <table width="100%" style="font-family: sans-serif;table-layout: fixed;width: 100%; border-collapse: collapse;border: 1px solid black;">
                <thead>
                    <tr style="font-size: 9pt;">
                        <th width="70%" style="text-align:right;padding-right:40%x;">KETERANGAN</th>
                        <td width="5%" style="text-align:right;"></td>
                        <th width="20%" style="text-align:right;">MD</th>
                        <th width="30%" style="text-align:right;">MS</th>
                        <th width="30%" style="text-align:right;padding-right:20px;">KONSOLIDASI</th>
                    </tr>
                <thead>
            </table>
            <table width="100%" >
                <thead>
                <?php $a=0; ?>
                @foreach($data_list as $data)
                <?php
                $a++;
                    $biayapegawai[$a] =$data->duadigit == 50 ? $data->duadigit : "";
                    $biayakantor[$a] =$data->duadigit == 51 ? $data->duadigit : "";

                    if($data->tigadigit == 500 and $data->lapangan=='MD'){
                        $mdupah[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah[$a] = "0";
                    }
                    if($data->tigadigit == 500 and $data->lapangan=='MS'){
                        $msupah[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah[$a] = "0";
                    }

                    if($data->tigadigit == 501 and $data->lapangan=='MD'){
                        $mdupah1[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah1[$a] = "0";
                    }
                    if($data->tigadigit == 501 and $data->lapangan=='MS'){
                        $msupah1[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah1[$a] = "0";
                    }

                    if($data->tigadigit == 502 and $data->lapangan=='MD'){
                        $mdupah2[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah2[$a] = "0";
                    }
                    if($data->tigadigit == 502 and $data->lapangan=='MS'){
                        $msupah2[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah2[$a] = "0";
                    }

                    if($data->tigadigit == 503 and $data->lapangan=='MD'){
                        $mdupah3[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah3[$a] = "0";
                    }
                    if($data->tigadigit == 503 and $data->lapangan=='MS'){
                        $msupah3[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah3[$a] = "0";
                    }
                    
                    if($data->tigadigit == 504 and $data->lapangan=='MD'){
                        $mdupah4[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah4[$a] = "0";
                    }
                    if($data->tigadigit == 504 and $data->lapangan=='MS'){
                        $msupah4[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah4[$a] = "0";
                    }

                    if($data->tigadigit == 505 and $data->lapangan=='MD'){
                        $mdupah5[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah5[$a] = "0";
                    }
                    if($data->tigadigit == 505 and $data->lapangan=='MS'){
                        $msupah5[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah5[$a] = "0";
                    }

                    if($data->tigadigit == 506 and $data->lapangan=='MD'){
                        $mdupah6[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah6[$a] = "0";
                    }
                    if($data->tigadigit == 506 and $data->lapangan=='MS'){
                        $msupah6[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah6[$a] = "0";
                    }

                    if($data->tigadigit == 507 and $data->lapangan=='MD'){
                        $mdupah7[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah7[$a] = "0";
                    }
                    if($data->tigadigit == 507 and $data->lapangan=='MS'){
                        $msupah7[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah7[$a] = "0";
                    }

                    if($data->tigadigit == 508 and $data->lapangan=='MD'){
                        $mdupah8[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah8[$a] = "0";
                    }
                    if($data->tigadigit == 508 and $data->lapangan=='MS'){
                        $msupah8[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah8[$a] = "0";
                    }

                    if($data->tigadigit == 509 and $data->lapangan=='MD'){
                        $mdupah9[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah9[$a] = "0";
                    }
                    if($data->tigadigit == 509 and $data->lapangan=='MS'){
                        $msupah9[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah9[$a] = "0";
                    }

                    if($data->tigadigit == 510 and $data->lapangan=='MD'){
                        $mdupah10[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah10[$a] = "0";
                    }
                    if($data->tigadigit == 510 and $data->lapangan=='MS'){
                        $msupah10[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah10[$a] = "0";
                    }

                    if($data->tigadigit == 511 and $data->lapangan=='MD'){
                        $mdupah11[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah11[$a] = "0";
                    }
                    if($data->tigadigit == 511 and $data->lapangan=='MS'){
                        $msupah11[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah11[$a] = "0";
                    }

                    if($data->tigadigit == 512 and $data->lapangan=='MD'){
                        $mdupah12[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah12[$a] = "0";
                    }
                    if($data->tigadigit == 512 and $data->lapangan=='MS'){
                        $msupah12[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah12[$a] = "0";
                    }
                    
                    if($data->tigadigit == 513 and $data->lapangan=='MD'){
                        $mdupah13[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah13[$a] = "0";
                    }
                    if($data->tigadigit == 513 and $data->lapangan=='MS'){
                        $msupah13[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah13[$a] = "0";
                    }

                    if($data->tigadigit == 514 and $data->lapangan=='MD'){
                        $mdupah14[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah14[$a] = "0";
                    }
                    if($data->tigadigit == 514 and $data->lapangan=='MS'){
                        $msupah14[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah14[$a] = "0";
                    }

                    if($data->tigadigit == 515 and $data->lapangan=='MD'){
                        $mdupah15[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah15[$a] = "0";
                    }
                    if($data->tigadigit == 515 and $data->lapangan=='MS'){
                        $msupah15[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah15[$a] = "0";
                    }

                    if($data->tigadigit == 516 and $data->lapangan=='MD'){
                        $mdupah16[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah16[$a] = "0";
                    }
                    if($data->tigadigit == 516 and $data->lapangan=='MS'){
                        $msupah16[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah16[$a] = "0";
                    }

                    if($data->tigadigit == 517 and $data->lapangan=='MD'){
                        $mdupah17[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah17[$a] = "0";
                    }
                    if($data->tigadigit == 517 and $data->lapangan=='MS'){
                        $msupah17[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah17[$a] = "0";
                    }

                    if($data->tigadigit == 518 and $data->lapangan=='MD'){
                        $mdupah18[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah18[$a] = "0";
                    }
                    if($data->tigadigit == 518 and $data->lapangan=='MS'){
                        $msupah18[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah18[$a] = "0";
                    }

                    if($data->tigadigit == 519 and $data->lapangan=='MD'){
                        $mdupah19[$a] =  $data->cum_rp ;
                    } else { 
                        $mdupah19[$a] = "0";
                    }
                    if($data->tigadigit == 519 and $data->lapangan=='MS'){
                        $msupah19[$a] =  $data->cum_rp ;
                    } else { 
                        $msupah19[$a] = "0";
                    }



                 ?>
                @endforeach
                    <tr >
                        <th width="70%" style="text-align:left;font-size: 9pt;font-weight: bold">{{array_sum($biayapegawai) > 0 ? 'BIAYA PEGAWAI' : "BIAYA PEGAWAI"}}</th>
                        <td width="5%" style="text-align:right;" ></td>
                        <th width="20%" ></th>
                        <th width="30%" ></th>
                        <th width="30%" ></th>
                    </tr>
                    <tr style="font-size:9pt;">
                        <td width="70%" style="text-align:left;padding-left:20px;">UPAH TETAP</td>
                        <td width="5%" style="text-align:right;" >500</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah) == 0 ? '0.00' : number_format(array_sum($mdupah),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah) == 0 ? '0.00' : number_format(array_sum($msupah),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah) + array_sum($msupah),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">TUNJANGAN NON PAJAK</td>
                        <td width="5%" style="text-align:right;" >501</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah1) == 0 ? '0.00' : number_format(array_sum($mdupah1),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah1) == 0 ? '0.00' : number_format(array_sum($msupah1),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah1) + array_sum($msupah1),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">TUNJANGAN PAJAK PENGHASILAN</td>
                        <td width="5%" style="text-align:right;" >502</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah2) == 0 ? '0.00' : number_format(array_sum($mdupah2),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah2) == 0 ? '0.00' : number_format(array_sum($msupah2),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah2) + array_sum($msupah2),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">UANG CUTI,LEMBUR,BIAYA HAJI,THR & UTD</td>
                        <td width="5%" style="text-align:right;" >503</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah3) == 0 ? '0.00' : number_format(array_sum($mdupah3),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah3) == 0 ? '0.00' : number_format(array_sum($msupah3),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah3) + array_sum($msupah3),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">BONUS/INSENTIF DAN TANTIEM</td>
                        <td width="5%" style="text-align:right;" >504</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah4) == 0 ? '0.00' : number_format(array_sum($mdupah4),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah4) == 0 ? '0.00' : number_format(array_sum($msupah4),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah4) + array_sum($msupah4),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">BIAYA KESEHATAN</td>
                        <td width="5%" style="text-align:right;" >505</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah5) == 0 ? '0.00' : number_format(array_sum($mdupah5),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah5) == 0 ? '0.00' : number_format(array_sum($msupah5),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah5) + array_sum($msupah5),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">BIAYA PENDIDIKAN</td>
                        <td width="5%" style="text-align:right;" >506</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah6) == 0 ? '0.00' : number_format(array_sum($mdupah6),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah6) == 0 ? '0.00' : number_format(array_sum($msupah6),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah6) + array_sum($msupah6),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">PESANGON DAN IMBALAN MASA KERJA</td>
                        <td width="5%" style="text-align:right;" >507</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah7) == 0 ? '0.00' : number_format(array_sum($mdupah7),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah7) == 0 ? '0.00' : number_format(array_sum($msupah7),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah7) + array_sum($msupah7),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">HONOR DEKOM DAN KOMITE</td>
                        <td width="5%" style="text-align:right;" >508</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah8) == 0 ? '0.00' : number_format(array_sum($mdupah8),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah8) == 0 ? '0.00' : number_format(array_sum($msupah8),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah8) + array_sum($msupah8),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">PERJALANAN DINAS</td>
                        <td width="5%" style="text-align:right;" >509</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah9) == 0 ? '0.00' : number_format(array_sum($mdupah9),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah9) == 0 ? '0.00' : number_format(array_sum($msupah9),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah9) + array_sum($msupah9),2)}}</td>
                    </tr>


                    <tr >
                        <td width="5%" style="text-align:right;font-size: 9pt;font-weight: bold" colspan="2">SUB TOTAL:</td>
                        <?php
                            $subtotalmd = array_sum($mdupah)+array_sum($mdupah1)+array_sum($mdupah2)+array_sum($mdupah3)+array_sum($mdupah4)+array_sum($mdupah5)+array_sum($mdupah6)+array_sum($mdupah7)+array_sum($mdupah8)+array_sum($mdupah9);
                            $subtotalms = array_sum($msupah)+array_sum($msupah1)+array_sum($msupah2)+array_sum($msupah3)+array_sum($msupah4)+array_sum($msupah5)+array_sum($msupah6)+array_sum($msupah7)+array_sum($msupah8)+array_sum($msupah9);
                        ?>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalmd == 0 ? '0.00' : number_format($subtotalmd,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalms == 0 ? '0.00' : number_format($subtotalms,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalmd+$subtotalms == 0 ? '0.00' : number_format($subtotalmd+$subtotalms,2)}}</th>
                    </tr>

                    <!-- kantor -->
                    <tr >
                        <th width="70%" style="text-align:left;font-size: 9pt;font-weight: bold">{{array_sum($biayakantor) > 0 ? 'BIAYA KANTOR' : "BIAYA KANTOR"}}</th>
                        <td width="5%" style="text-align:right;" ></td>
                        <th width="20%" ></th>
                        <th width="30%" ></th>
                        <th width="30%" ></th>
                    </tr>
                    <tr style="font-size:9pt;">
                        <td width="70%" style="text-align:left;padding-left:20px;">SEWA KANTOR</td>
                        <td width="5%" style="text-align:right;" >510</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah10) == 0 ? '0.00' : number_format(array_sum($mdupah10),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah10) == 0 ? '0.00' : number_format(array_sum($msupah10),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah10) + array_sum($msupah10),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">INVENTARIS KANTOR</td>
                        <td width="5%" style="text-align:right;" >511</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah11) == 0 ? '0.00' : number_format(array_sum($mdupah11),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah11) == 0 ? '0.00' : number_format(array_sum($msupah11),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah11) + array_sum($msupah11),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">KONSULTAN</td>
                        <td width="5%" style="text-align:right;" >512</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah12) == 0 ? '0.00' : number_format(array_sum($mdupah12),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah12) == 0 ? '0.00' : number_format(array_sum($msupah12),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah12) + array_sum($msupah12),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">LISTRIK,AIR,TELP DAN INTERNET</td>
                        <td width="5%" style="text-align:right;" >513</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah13) == 0 ? '0.00' : number_format(array_sum($mdupah13),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah13) == 0 ? '0.00' : number_format(array_sum($msupah13),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah13) + array_sum($msupah13),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">OPERASI DAN PEMELIHARAAN KENDARAAN</td>
                        <td width="5%" style="text-align:right;" >514</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah14) == 0 ? '0.00' : number_format(array_sum($mdupah14),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah14) == 0 ? '0.00' : number_format(array_sum($msupah14),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah14) + array_sum($msupah14),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">OLAHRAGA,REKREASI DAN SERAGAM</td>
                        <td width="5%" style="text-align:right;" >515</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah15) == 0 ? '0.00' : number_format(array_sum($mdupah15),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah15) == 0 ? '0.00' : number_format(array_sum($msupah15),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah15) + array_sum($msupah15),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">BIAYA PENYUSUTAN</td>
                        <td width="5%" style="text-align:right;" >516</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah16) == 0 ? '0.00' : number_format(array_sum($mdupah16),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah16) == 0 ? '0.00' : number_format(array_sum($msupah16),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah16) + array_sum($msupah16),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">BIAYA BANK</td>
                        <td width="5%" style="text-align:right;" >517</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah17) == 0 ? '0.00' : number_format(array_sum($mdupah17),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah17) == 0 ? '0.00' : number_format(array_sum($msupah17),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah17) + array_sum($msupah17),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">SUPPLIES</td>
                        <td width="5%" style="text-align:right;" >518</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah18) == 0 ? '0.00' : number_format(array_sum($mdupah18),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah18) == 0 ? '0.00' : number_format(array_sum($msupah18),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah18) + array_sum($msupah18),2)}}</td>
                    </tr>
                    <tr style="font-size:9pt">
                        <td width="70%" style="text-align:left;padding-left:20px;">LAIN-LAIN</td>
                        <td width="5%" style="text-align:right;" >519</td>
                        <td width="20%" style="text-align:right;">{{array_sum($mdupah19) == 0 ? '0.00' : number_format(array_sum($mdupah19),2)}}</td>
                        <td width="30%" style="text-align:right;">{{array_sum($msupah19) == 0 ? '0.00' : number_format(array_sum($msupah19),2)}}</td>
                        <td width="30%" style="text-align:right;">{{number_format(array_sum($mdupah19) + array_sum($msupah19),2)}}</td>
                    </tr>


                    <tr >
                        <td width="5%" style="text-align:right;font-size: 9pt;font-weight: bold" colspan="2">SUB TOTAL:</td>
                        <?php
                            $subtotalmd1 = array_sum($mdupah10)+array_sum($mdupah11)+array_sum($mdupah12)+array_sum($mdupah13)+array_sum($mdupah14)+array_sum($mdupah15)+array_sum($mdupah16)+array_sum($mdupah17)+array_sum($mdupah18)+array_sum($mdupah19);
                            $subtotalms1 = array_sum($msupah10)+array_sum($msupah11)+array_sum($msupah12)+array_sum($msupah13)+array_sum($msupah14)+array_sum($msupah15)+array_sum($msupah16)+array_sum($msupah17)+array_sum($msupah18)+array_sum($msupah19);
                        ?>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalmd1 == 0 ? '0.00' : number_format($subtotalmd1,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalms1 == 0 ? '0.00' : number_format($subtotalms1,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $subtotalmd1+$subtotalms1 == 0 ? '0.00' : number_format($subtotalmd1+$subtotalms1,2)}}</th>
                    </tr>
                    <tr >
                        <td width="5%" style="text-align:right;font-size: 9pt;font-weight: bold" colspan="2">TOTAL:</td>
                        <?php
                            $totalmd = $subtotalmd+$subtotalmd1;
                            $totalms = $subtotalms+$subtotalms1;
                        ?>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $totalmd == 0 ? '0.00' : number_format($totalmd,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $totalms == 0 ? '0.00' : number_format($totalms,2)}}</th>
                        <th width="20%" style="text-align:right;font-size: 9pt;font-weight: bold">{{ $totalmd+$totalms == 0 ? '0.00' : number_format($totalmd+$totalms,2)}}</th>
                    </tr>
                <thead>
            </table>
        </main>
        
    </body>
</html>
