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
                    
                    $bulan= strtoupper($array_bln[$request->bulan]);
                ?>
                <tr>
                    <td align="left" style="padding-left:100px;font-family: sans-serif">
                        <table>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR PEMBAYARAN GAJI PEGAWAI KONTRAK </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT.PERTAMINA PEDEVE INDONESIA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 11pt;font-weight: bold ">BULAN {{strtoupper($bulan)}} {{ $request->tahun}}</font></td>
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
                        <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center;font-size: 8pt;">
                                <td rowspan="2">NO</td>
                                <td rowspan="2">NO <br>PEGAWAI</td>
                                <td rowspan="2">NAMA</td>
                                <td colspan="9">PERINCIAN GAJI PEGAWAI TETAP</td>
                                <td rowspan="2">GAJI<br> BRUTO</td>
                                <td colspan="3">POTONGAN</td>
                                <td rowspan="2">GAJI<br> NETTO</td>
                            </tr>
                            <tr style="text-align:center;font-size: 8pt;">
                                <td >ALL IN</td>
                                <td >TUNJ. JABATAN</td>
                                <td >TUNJ<br> DAERAH</td>
                                <td >FASILITAS <br>CUTI</td>
                                <td >LEMBUR</td>
                                <td >SISA<br> BULAN<br> LALU</td>
                                <td >KODE<br> PAJAK</td>
                                <td >KOREKSI<br> GAJI</td>
                                <td >TUNJANGAN<br> PAJAK</td>
                                <td>POT.<br> PAJAK</td>
                                <td>IURAN<br> JAMSOSTEK</td>
                                <td>PEMBULATAN</td>
                            </tr>
                            <tr>
                                <td style="padding-left:12px;font-size: 8pt;" colspan="17">CS & BUSINESS SUPPORT</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php if($data->kode == 'D0000'){ ?>
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->nama }}</td>
                                <td style="text-align:right;">{{ number_format($data->a_upah,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_jb,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_bh,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_fc,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_lem,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_sbl,0)}}</td>
                                <td style="text-align:center;">{{ $data->a_kdkeluarga}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_koreksi,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->tunpj,0)}}</td>
                                <?php
                                $a = $data->a_upah;
                                $a1 = $data->a_jb;
                                $a2 = $data->a_bh;
                                $a3 = $data->a_fc;
                                $a4 = $data->a_lem;
                                $a5 = $data->a_sbl;
                                $a6 = $data->a_koreksi;
                                $a7 = $data->tunpj;
                                $a_005 = $data->a_005;
                                $a_011 = $data->a_011;
                                $a_012 = $data->a_012;
                                $iuranjm = $data->iuranjm;
                                $pot_pajak = $data->pot_pajak;
                                $pembulatan = $data->pembulatan;
                                $pot_pinjaman = $data->pot_pinjaman;
                                $pot_koperasi = $data->pot_koperasi;
                                $total=$a+$a1+$a2+$a3+$a4+$a5+$a6+$a7;
                                $potongan =$pot_pajak+$pembulatan+$pot_pinjaman+$pot_koperasi;
                                $gajihbersih =$total+$potongan;
                                $subtotala[$a] = $a;
                                 $subtotala1[$a] = $a1;
                                 $subtotala2[$a] = $a2;
                                 $subtotala3[$a] = $a3;
                                 $subtotala4[$a] = $a4;
                                 $subtotala5[$a] = $a5;
                                 $subtotala6[$a] = $a6;
                                 $subtotala7[$a] = $a7;
                                 $subtotala8[$a] = $pot_pajak;
                                 $subtotala9[$a] = $iuranjm;
                                 $subtotala10[$a] = $pembulatan;
                                 $subtotala11[$a] = $gajihbersih;
                                 $subtotala12[$a] = $total;
                                ?>
                                <td style="text-align:right;">{{ number_format($total,0)}}</td>
                                <td style="text-align:right;">{{ $data->pot_pajak <= 0 ? '('.number_format($data->pot_pajak*-1,0).')' : number_format($data->pot_pajak,0)}}</td>
                                <td style="text-align:right;">{{ $data->iuranjm <= 0 ? '('.number_format($data->iuranjm*-1,0).')' : number_format($data->iuranjm,0)}}</td>
                                <td style="text-align:right;">{{ $data->pembulatan <= 0 ? '('.number_format($data->pembulatan*-1,0).')' : number_format($data->pembulatan,0)}}</td>
                                <td style="text-align:right;">{{ number_format($gajihbersih,0)}}</td>
                            </tr>
                            <?php } ?>

                            @endforeach
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">SUB TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala3),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala4),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala5),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala6),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala7),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala12) <= 0 ? '('.number_format(array_sum($subtotala12)*-1,0).')' : number_format(array_sum($subtotala12),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala8) <= 0 ? '('.number_format(array_sum($subtotala8)*-1,0).')' : number_format(array_sum($subtotala8),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala9) <= 0 ? '('.number_format(array_sum($subtotala9)*-1,0).')' : number_format(array_sum($subtotala9),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala10) <= 0 ? '('.number_format(array_sum($subtotala10)*-1,0).')' : number_format(array_sum($subtotala10),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala11),0)}}</td>
                            </tr>

                            <tr>
                                <td style="padding-left:12px;font-size: 8pt;" colspan="17">FINANCE</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php if($data->kode == 'B0000'){ ?>
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->nama }}</td>
                                <td style="text-align:right;">{{ number_format($data->a_upah,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_jb,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_bh,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_fc,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_lem,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_sbl,0)}}</td>
                                <td style="text-align:center;">{{ $data->a_kdkeluarga}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_koreksi,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->tunpj,0)}}</td>
                                <?php
                                $b = $data->a_upah;
                                $b1 = $data->a_jb;
                                $b2 = $data->a_bh;
                                $b3 = $data->a_fc;
                                $b4 = $data->a_lem;
                                $b5 = $data->a_sbl;
                                $b6 = $data->a_koreksi;
                                $b7 = $data->tunpj;
                                $b_005 = $data->a_005;
                                $b_011 = $data->a_011;
                                $b_012 = $data->a_012;
                                $iuranjm = $data->iuranjm;
                                $pot_pajak = $data->pot_pajak;
                                $pembulatan = $data->pembulatan;
                                $pot_pinjaman = $data->pot_pinjaman;
                                $pot_koperasi = $data->pot_koperasi;
                                $total=$b+$b1+$b2+$b3+$b4+$b5+$b6+$b7;
                                $potongan =$pot_pajak+$pembulatan+$pot_pinjaman+$pot_koperasi;
                                $gajihbersih =$total+$potongan;
                                $subtotalb[$b] = $b;
                                 $subtotalb1[$b] = $b1;
                                 $subtotalb2[$b] = $b2;
                                 $subtotalb3[$b] = $b3;
                                 $subtotalb4[$b] = $b4;
                                 $subtotalb5[$b] = $b5;
                                 $subtotalb6[$b] = $b6;
                                 $subtotalb7[$b] = $b7;
                                 $subtotalb8[$b] = $pot_pajak;
                                 $subtotalb9[$b] = $iuranjm;
                                 $subtotalb10[$b] = $pembulatan;
                                 $subtotalb11[$b] = $gajihbersih;
                                 $subtotalb12[$b] = $total;
                                ?>
                                <td style="text-align:right;">{{ number_format($total,0)}}</td>
                                <td style="text-align:right;">{{ $data->pot_pajak <= 0 ? '('.number_format($data->pot_pajak*-1,0).')' : number_format($data->pot_pajak,0)}}</td>
                                <td style="text-align:right;">{{ $data->iuranjm <= 0 ? '('.number_format($data->iuranjm*-1,0).')' : number_format($data->iuranjm,0)}}</td>
                                <td style="text-align:right;">{{ $data->pembulatan <= 0 ? '('.number_format($data->pembulatan*-1,0).')' : number_format($data->pembulatan,0)}}</td>
                                <td style="text-align:right;">{{ number_format($gajihbersih,0)}}</td>
                            </tr>
                            <?php } ?>

                            @endforeach
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">SUB TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb1),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb3),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb4),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb5),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb6),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb7),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalb12) <= 0 ? '('.number_format(array_sum($subtotalb12)*-1,0).')' : number_format(array_sum($subtotalb12),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalb8) <= 0 ? '('.number_format(array_sum($subtotalb8)*-1,0).')' : number_format(array_sum($subtotalb8),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalb9) <= 0 ? '('.number_format(array_sum($subtotalb9)*-1,0).')' : number_format(array_sum($subtotalb9),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalb10) <= 0 ? '('.number_format(array_sum($subtotalb10)*-1,0).')' : number_format(array_sum($subtotalb10),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalb11),0)}}</td>
                            </tr>


                            <tr>
                                <td style="padding-left:12px;font-size: 8pt;" colspan="17">INTERNAL AUDIT & RISK MGT</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php if($data->kode == 'C0000'){ ?>
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{ $a}}</td>
                                <td style="text-align:left;">{{ $data->nopek}}</td>
                                <td style="text-align:left;">{{ $data->nama }}</td>
                                <td style="text-align:right;">{{ number_format($data->a_upah,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_jb,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_bh,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_fc,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_lem,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_sbl,0)}}</td>
                                <td style="text-align:center;">{{ $data->a_kdkeluarga}}</td>
                                <td style="text-align:right;">{{ number_format($data->a_koreksi,0)}}</td>
                                <td style="text-align:right;">{{ number_format($data->tunpj,0)}}</td>
                                <?php
                                $c = $data->a_upah;
                                $c1 = $data->a_jb;
                                $c2 = $data->a_bh;
                                $c3 = $data->a_fc;
                                $c4 = $data->a_lem;
                                $c5 = $data->a_sbl;
                                $c6 = $data->a_koreksi;
                                $c7 = $data->tunpj;
                                $c_005 = $data->a_005;
                                $c_011 = $data->a_011;
                                $c_012 = $data->a_012;
                                $iuranjm = $data->iuranjm;
                                $pot_pajak = $data->pot_pajak;
                                $pembulatan = $data->pembulatan;
                                $pot_pinjaman = $data->pot_pinjaman;
                                $pot_koperasi = $data->pot_koperasi;
                                $total=$c+$c1+$c2+$c3+$c4+$c5+$c6+$c7;
                                $potongan =$pot_pajak+$pembulatan+$pot_pinjaman+$pot_koperasi;
                                $gajihbersih =$total+$potongan;
                                $subtotalc[$c] = $c;
                                 $subtotalc1[$c] = $c1;
                                 $subtotalc2[$c] = $c2;
                                 $subtotalc3[$c] = $c3;
                                 $subtotalc4[$c] = $c4;
                                 $subtotalc5[$c] = $c5;
                                 $subtotalc6[$c] = $c6;
                                 $subtotalc7[$c] = $c7;
                                 $subtotalc8[$c] = $pot_pajak;
                                 $subtotalc9[$c] = $iuranjm;
                                 $subtotalc10[$c] = $pembulatan;
                                 $subtotalc11[$c] = $gajihbersih;
                                 $subtotalc12[$c] = $total;
                                ?>
                                <td style="text-align:right;">{{ number_format($total,0)}}</td>
                                <td style="text-align:right;">{{ $data->pot_pajak <= 0 ? '('.number_format($data->pot_pajak*-1,0).')' : number_format($data->pot_pajak,0)}}</td>
                                <td style="text-align:right;">{{ $data->iuranjm <= 0 ? '('.number_format($data->iuranjm*-1,0).')' : number_format($data->iuranjm,0)}}</td>
                                <td style="text-align:right;">{{ $data->pembulatan <= 0 ? '('.number_format($data->pembulatan*-1,0).')' : number_format($data->pembulatan,0)}}</td>
                                <td style="text-align:right;">{{ number_format($gajihbersih,0)}}</td>
                            </tr>
                            <?php } ?>

                            @endforeach
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">SUB TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc1),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc3),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc4),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc5),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc6),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc7),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalc12) <= 0 ? '('.number_format(array_sum($subtotalc12)*-1,0).')' : number_format(array_sum($subtotalc12),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalc8) <= 0 ? '('.number_format(array_sum($subtotalc8)*-1,0).')' : number_format(array_sum($subtotalc8),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalc9) <= 0 ? '('.number_format(array_sum($subtotalc9)*-1,0).')' : number_format(array_sum($subtotalc9),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotalc10) <= 0 ? '('.number_format(array_sum($subtotalc10)*-1,0).')' : number_format(array_sum($subtotalc10),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotalc11),0)}}</td>
                            </tr>
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">TOTAL</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala)+array_sum($subtotalb)+array_sum($subtotalc),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala1)+array_sum($subtotalb1)+array_sum($subtotalc1),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala2)+array_sum($subtotalb2)+array_sum($subtotalc2),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala3)+array_sum($subtotalb3)+array_sum($subtotalc3),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala4)+array_sum($subtotalb4)+array_sum($subtotalc4),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala5)+array_sum($subtotalb5)+array_sum($subtotalc5),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala6)+array_sum($subtotalb6)+array_sum($subtotalc6),0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala7)+array_sum($subtotalb7)+array_sum($subtotalc7),0)}}</td>
                                <?php
                                    $suba8 = array_sum($subtotala8)+array_sum($subtotalb8)+array_sum($subtotalc8);
                                    $suba9 = array_sum($subtotala9)+array_sum($subtotalb9)+array_sum($subtotalc9);
                                    $suba10 = array_sum($subtotala10)+array_sum($subtotalb10)+array_sum($subtotalc10);
                                    $suba12 = array_sum($subtotala12)+array_sum($subtotalb12)+array_sum($subtotalc12);
                                ?>
                                <td style="text-align:right;">{{ $suba12 <= 0 ? '('.number_format($suba12*-1,0).')' : number_format($suba12,0)}}</td>
                                <td style="text-align:right;">{{ $suba8 <= 0 ? '('.number_format($suba8*-1,0).')' : number_format($suba8,0)}}</td>
                                <td style="text-align:right;">{{ $suba9 <= 0 ? '('.number_format($suba9*-1,0).')' : number_format($suba9,0)}}</td>
                                <td style="text-align:right;">{{ $suba10 <= 0 ? '('.number_format($suba10*-1,0).')' : number_format($suba10,0)}}</td>
                                <td style="text-align:right;">{{ number_format(array_sum($subtotala11)+array_sum($subtotalb11)+array_sum($subtotalc11),0)}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <table width="100%"  style=" padding-left:30px;;padding-right:30px;">
                <tr>
                    <td>
                        <table width="100%" style="font-size: 10pt; padding-left:75%;">
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">JAKARTA, {{strtoupper($request->tanggal)}}</td><br>
                            </tr>
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">PT.PERTAMINA PEDEVE INDONESIA</td><br>
                            </tr>
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">{{strtoupper($request->jabatan)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:75%">
                            <tr style="font-size: 10pt;">
                                <td align="left" width="200">{{strtoupper($request->nama)}}</td><br>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </main>
        
    </body>
</html>
