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
                    <td align="left" style="padding-left:50px;">
                        <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"  style="padding-right:30px;"><br>
                        <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                        <font style="font-size: 10pt;font-weight: bold ">POSISI SALDO PENEMPATAN DEPOSITO</font><br>
                        <?php 
                            $tgl  = date_create($request->tanggal);
                            $tgl_per = date_format($tgl, 'd/M/Y');
                        ?>
                        <font style="font-size: 10pt; "> PER {{strtoupper($tgl_per)}}</font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table width="100%" style="font-family: sans-serif;border-collapse: collapse;" >
                <thead>
                    <tr>
                        <td colspan="10" style="text-align:left;font-size: 8pt">Tgl. Cetak : {{date('d-M-Y')}}</td>
                    </tr>
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <th width="25%" style="text-align:center;border:1px solid black;">NAMA BANK</th>
                        <th style="text-align:center;border:1px solid black;">NO. SERI</th>
                        <th style="text-align:center;border:1px solid black;">LOKASI</th>
                        <th style="text-align:center;border:1px solid black;">CI</th>
                        <th style="text-align:center;border:1px solid black;">NOMINAL</th>
                        <th style="text-align:center;border:1px solid black;">KURS</th>
                        <th style="text-align:center;border:1px solid black;">TGL DEP</th>
                        <th style="text-align:center;border:1px solid black;">TGL J.T</th>
                        <th style="text-align:center;border:1px solid black;">BUNGAN %<br>TAHUN </th>
                        <th style="text-align:center;border:1px solid black;">RATA </th>
                    </tr>
                <thead>
                <tbody>
                <?php $no=0; ?>
                @foreach($data_list as $data)
                <?php $no++; ?>
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td width="20%" style="text-align:left;border:1px solid black;">{{$data->namabank}}</td>
                        <td style="text-align:left;border:1px solid black;">{{$data->noseri}}</td>
                        <td style="text-align:center;border:1px solid black;">{{$data->lokasi}}</td>
                        <td style="text-align:center;border:1px solid black;">
                        @if($data->kurs > 1 )
                            <?php echo "Dollar"; ?>
                        @else
                        <?php echo "Rupiah"; ?>
                        @endif
                        </td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->nominal,2)}}</td>
                        <td style="text-align:center;border:1px solid black;">{{number_format($data->kurs,0)}}</td>
                        <td style="text-align:center;border:1px solid black;">
                        <?php
                            $a=date_create($data->tgldepo);
                            echo date_format($a, 'd/m/Y');
                        ?></td>
                        <td style="text-align:center;border:1px solid black;">
                        <?php
                            $a=date_create($data->tglcair);
                            echo date_format($a, 'd/m/Y');
                        ?></td>
                        <td style="text-align:center;border:1px solid black;">{{number_format($data->bungatahun,2)}} </td>
                        <td style="text-align:center;border:1px solid black;">
                        <?php
                            //identrupiah
                            if($data->kurs == 1){
                                 $idenrup = $data->nominal;
                            }else{
                                $idenrup = 0;
                            }
                            //identdolar
                            if($data->kurs <> 1){
                                 $idendl = $data->nominal;
                            }else{
                                $idendl = 0;
                            }
                            //identekivalen
                            if($data->kurs <> 1){
                                $ideneki = $data->nominal * $data->kurs;
                            }else{
                                $ideneki = 0;
                            }
                            $tato = $ideneki + $idenrup;
                            $sumtot = $tato <= 0 ? 1 : $tato;
                            $total_rupiah[$no] = $idenrup;
                            $total_dolar[$no] = $idendl;
                            $total_eki[$no] = $ideneki;
                                if($data->jenis == 'T'){ 
                                    if($data->kurs == 1 ){ 
                                       $rata = ($data->nominal/$sumtot)*$data->bungatahun;
                                    }else{
                                       $rata = (($data->nominal*$data->kurs)/$sumtot)*$data->bungatahun;
                                    }
                                }else{
                                    $rata = 0;
                                }
                                echo $rata;
                                $tertim[$no] =$rata; 
                        ?>
                        </td>
                    </tr>
                @endforeach
                <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <th colspan="9" style="text-align:right;border:1px solid black;">TOTAL RATA TERTIMBANG :</th>
                        <th style="text-align:center;border:1px solid black;">{{array_sum($tertim)}} </th>
                    </tr>
                </tbody>
            </table>
            <table width="100%" style="font-family: sans-serif;border-collapse: collapse;" >
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <th  style="text-align:center;border:1px solid black;">RP</th>
                        <th style="text-align:center;border:1px solid black;">BRI</th>
                        <th style="text-align:center;border:1px solid black;">BNI</th>
                        <th style="text-align:center;border:1px solid black;">MANDIRI</th>
                        <th style="text-align:center;border:1px solid black;">BTN</th>
                        <th style="text-align:center;border:1px solid black;">BRI AGRO</th>
                        <th style="text-align:center;border:1px solid black;">MANTAP</th>
                        <th style="text-align:center;border:1px solid black;">BNI SYARIAH </th>
                    </tr>
                    @foreach($data_bankrp as $data)
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td style="text-align:center;border:1px solid black;">MD</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->brimd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnimd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mandirimd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->btnmd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->agromd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mantapmd,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnisyamd,2)}}</td>
                    </tr>
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td style="text-align:center;border:1px solid black;">MS</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->brims,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnims,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mandirims,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->btnms,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->agroms,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mantapms,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnisyams,2)}}</td>
                    </tr>
                    @endforeach
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <th  style="text-align:center;border:1px solid black;">USD</th>
                        <th style="text-align:center;border:1px solid black;">BRI</th>
                        <th style="text-align:center;border:1px solid black;">BNI</th>
                        <th style="text-align:center;border:1px solid black;">MANDIRI</th>
                        <th style="text-align:center;border:1px solid black;">BTN</th>
                        <th style="text-align:center;border:1px solid black;">BRI AGRO</th>
                        <th style="text-align:center;border:1px solid black;">MANTAP</th>
                        <th style="text-align:center;border:1px solid black;">BNI SYARIAH </th>
                    </tr>
                    @foreach($data_bankrp as $data)
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td style="text-align:center;border:1px solid black;">MD</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->brimd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnimd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mandirimd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->btnmd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->agromd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mantapmd1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnisyamd1,2)}}</td>
                    </tr>
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td style="text-align:center;border:1px solid black;">MS</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->brims1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnims1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mandirims1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->btnms1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->agroms1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mantapms1,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnisyams1,2)}}</td>
                    </tr>
                    @endforeach
                    @foreach($data_bankrp as $data)
                    <tr style="text-align:center;font-size: 7pt;border: 1px solid black;">
                        <td style="text-align:center;border:1px solid black;">Total</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->brimd+$data->brimd1+$data->brimd2+$data->brims+$data->brims1+$data->brims2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnimd+$data->bnimd1+$data->bnimd2+$data->bnims+$data->bnims1+$data->bnims2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mandirimd+$data->mandirimd1+$data->mandirimd2+$data->mandirims+$data->mandirims1+$data->mandirims2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->btnmd+$data->btnmd1+$data->btnmd2+$data->btnms+$data->btnms1+$data->btnms2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->agromd+$data->agromd1+$data->agromd2+$data->agroms+$data->agroms1+$data->agroms2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->mantapmd+$data->mantapmd1+$data->mantapmd2+$data->mantapms+$data->mantapms1+$data->mantapms2,2)}}</td>
                        <td style="text-align:right;border:1px solid black;">{{number_format($data->bnisyamd+$data->bnisyamd1+$data->bnisyamd2+$data->bnisyams+$data->bnisyams1+$data->bnisyams2,2)}}</td>
                    </tr>
                    @endforeach
            </table>
            <table width="100%" style="font-size: 8pt; padding-top:10px;font-weight: bold">
                    <tr style="font-size: 8pt;">
                        <td width="50%" colspa="5"></td>
                        <td align="right" >TOTAL RUPIAH </td>
                        <td align="right">:</td>
                        <td align="right">{{number_format(array_sum($total_rupiah),2)}}</td>
                    </tr>
                    <tr style="font-size: 8pt;">
                        <td colspa="5"></td>
                        <td align="right" >TOTAL DOLAR </td>
                        <td align="right">:</td>
                        <td align="right">{{number_format(array_sum($total_dolar),2)}}</td>
                    </tr>
                    <tr style="font-size: 8pt;">
                        <td colspa="5"></td>
                        <td align="right" >EKIVALEN </td>
                        <td align="right">:</td>
                        <td align="right">{{number_format(array_sum($total_eki),2)}}</td>
                    </tr>
                    <tr style="font-size: 8pt;">
                        <td colspa="5"></td>
                        <td align="right" >TOTAL </td>
                        <td align="right">:</td>
                        <td align="right">{{number_format(array_sum($total_eki)+array_sum($total_rupiah),2)}}</td>
                    </tr>
            </table>
            
        </main>
        
    </body>
</html>