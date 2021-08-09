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
                                <td><font style="font-size: 12pt;font-weight: bold ">DAFTAR PEMBAYARAN GAJI PEGAWAI PERBANTUAN </font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 12pt;font-weight: bold ">PT.PERTAMINA PEDEVE INDONESIA</font></td>
                            </tr>
                            <tr>
                                <td><font style="font-size: 11pt;font-weight: bold ">BULAN {{strtoupper($bulan)}} {{$request->tahun}}</font></td>
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

            <table width="100%"  style="padding-top:6%; font-family: sans-serif">
                <tr>
                    <td>
                        <font style="font-size: 8pt;font-style: italic">Tanggal Cetak: {{$request->tanggal}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" style="border-collapse: collapse;" border="1">
                            <tr style="text-align:center;font-size: 6pt;">
                                <td rowspan="4">NO</td>
                                <td rowspan="4">NO <br>PEGAWAI</td>
                                <td rowspan="4">NAMA</td>
                                <td colspan="6">PERINCIAN GAJI PEGAWAI PERBANTUAN</td>
                                <td rowspan="4">GAJI<br> BRUTO</td>
                                <td colspan="10">POTONGAN</td>
                                <td rowspan="4">GAJI<br> NETTO</td>
                            </tr>
                            <tr style="text-align:center;font-size: 6pt;">
                                <td rowspan="3">ALL IN</td>
                                <td rowspan="3">FASILITAS <br>CUTI</td>
                                <td rowspan="3">SISA<br> BULAN<br> LALU</td>
                                <td rowspan="3">KODE<br> PAJAK</td>
                                <td rowspan="3">KOREKSI/<br> LAIN-LAIN</td>
                                <td rowspan="3">TUNJANGAN<br> PAJAK</td>
                                <td rowspan="3">IURAN<br> PENSIUN</td>
                                <td rowspan="3">IURAN<br> JAMSOSTEK</td>
                                <td colspan="4">ANGSURAN</td>
                                <td rowspan="3">POT.<br> PAJAK</td>
                                <td rowspan="3">POT.<br> BAZMA</td>
                                <td rowspan="3">POTONGAN.<br> KOPERASI</td>
                                <td rowspan="3">PEMBULATAN</td>
                            </tr>
                            <tr style="text-align:center;font-size: 6pt;">
                                <td colspan="2">PKPP</td>
                                <td colspan="2">PJR. PESANGON</td>
                            </tr>
                            <tr style="text-align:center;font-size: 6pt;">
                                <td>JUMLAH</td>
                                <td>KE</td>
                                <td>JUMLAH</td>
                                <td>KE</td>
                            </tr>
                            <tr>
                                <td style="padding-left:12px;font-size: 8pt;font-weight: bold" colspan="21">DIREKTUR UTAMA</td>
                            </tr>
                            <?php $a=0; ?>
                            @foreach($data_list as $data)
                            <?php $a++; ?>
                            <tr style="font-size: 7pt;">
                                <td style="text-align:center;">{{$a}}</td>
                                <td style="text-align:left;">{{$data->nopek}}</td>
                                <td style="text-align:left;">{{$data->nama}}</td>
                                <td style="text-align:right;">{{number_format($data->a_upah,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->a_fc,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->a_sbl,0)}}</td>
                                <td style="text-align:center;">{{$data->a_kdkeluarga}}</td>
                                <td style="text-align:right;">{{number_format($data->a_koreksi,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->tunpj,0)}}</td>
                                <?php
                                $a = $data->a_upah;
                                $a1 = $data->a_fc;
                                $a2 = $data->a_sbl;
                                $a3 = $data->a_koreksi;
                                $a4 = $data->tunpj;
                                $iuranjm = $data->iuranjm;
                                $iuranpensiun = $data->iuranpensiun;
                                $jumlah1 = $data->jumlah1;
                                $jumlah2 = $data->jumlah2;
                                $ccl1 = $data->ccl1;
                                $ccl2 = $data->ccl2;
                                $pot_bazma = $data->pot_bazma;
                                $pot_pajak = $data->pot_pajak;
                                $pembulatan = $data->pembulatan;
                                $pot_pinjaman = $data->pot_pinjaman;
                                $pot_koperasi = $data->pot_koperasi;
                                $total=$a+$a1+$a2+$a3+$a4;
                                $potongan =$pot_pajak+$pembulatan+$pot_pinjaman+$pot_koperasi;
                                $gajihbersih =$total+$potongan;
                                $subtotala[$a] = $a;
                                 $subtotala1[$a] = $a1;
                                 $subtotala2[$a] = $a2;
                                 $subtotala3[$a] = $a3;
                                 $subtotala4[$a] = $a4;
                                 $subtotala5[$a] = $iuranpensiun;
                                 $subtotala6[$a] = $iuranjm;
                                 $subtotala7[$a] = $jumlah1;
                                 $subtotala8[$a] = $ccl1;
                                 $subtotala9[$a] = $jumlah2;
                                 $subtotala10[$a] = $ccl2;
                                 $subtotala11[$a] = $pot_pajak;
                                 $subtotala12[$a] = $pot_bazma;
                                 $subtotala13[$a] = $pot_koperasi;
                                 $subtotala14[$a] = $pembulatan;
                                 $subtotala15[$a] = $gajihbersih;
                                 $subtotala16[$a] = $total;
                                ?>
                                <td style="text-align:right;">{{number_format($total,0)}}</td>
                                <td style="text-align:right;">{{$data->iuranpensiun <= 0 ? '('.number_format($data->iuranpensiun*-1,0).')' : number_format($data->iuranpensiun,0)}}</td>
                                <td style="text-align:right;">{{$data->iuranjm <= 0 ? '('.number_format($data->iuranjm*-1,0).')' : number_format($data->iuranjm,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->jumlah1,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->ccl1,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->jumlah2,0)}}</td>
                                <td style="text-align:right;">{{number_format($data->ccl2,0)}}</td>
                                <td style="text-align:right;">{{$data->pot_pajak <= 0 ? '('.number_format($data->pot_pajak*-1,0).')' : number_format($data->pot_pajak,0)}}</td>
                                <td style="text-align:right;">{{$data->pot_bazma <= 0 ? '('.number_format($data->pot_bazma*-1,0).')' : number_format($data->pot_bazma,0)}}</td>
                                <td style="text-align:right;">{{$data->pot_koperasi <= 0 ? '('.number_format($data->pot_koperasi*-1,0).')' : number_format($data->pot_koperasi,0)}}</td>
                                <td style="text-align:right;">{{$data->pembulatan <= 0 ? '('.number_format($data->pembulatan*-1,0).')' : number_format($data->pembulatan,0)}}</td>
                                <td style="text-align:right;">{{number_format($gajihbersih,0)}}</td>
                            </tr>
                            @endforeach

                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">SUB TOTAL</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala2),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala3),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala4),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala16),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala5) <= 0 ? '('.number_format(array_sum($subtotala5)*-1,0).')' : number_format(array_sum($subtotala5),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala6) <= 0 ? '('.number_format(array_sum($subtotala6)*-1,0).')' : number_format(array_sum($subtotala6),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala7),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala8),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala9),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala10),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala11) <= 0 ? '('.number_format(array_sum($subtotala11)*-1,0).')' : number_format(array_sum($subtotala11),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala12) <= 0 ? '('.number_format(array_sum($subtotala12)*-1,0).')' : number_format(array_sum($subtotala12),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala13) <= 0 ? '('.number_format(array_sum($subtotala13)*-1,0).')' : number_format(array_sum($subtotala13),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala14) <= 0 ? '('.number_format(array_sum($subtotala14)*-1,0).')' : number_format(array_sum($subtotala14),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala15) <= 0 ? '('.number_format(array_sum($subtotala15)*-1,0).')' : number_format(array_sum($subtotala15),0)}}</td>
                            </tr>
                            <tr style="font-size: 7pt;font-weight: bold">
                                <td colspan="3" style="text-align:right;">GRAND TOTAL</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala1),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala2),0)}}</td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala3),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala4),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala16),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala5) <= 0 ? '('.number_format(array_sum($subtotala5)*-1,0).')' : number_format(array_sum($subtotala5),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala6) <= 0 ? '('.number_format(array_sum($subtotala6)*-1,0).')' : number_format(array_sum($subtotala6),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala7),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala8),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala9),0)}}</td>
                                <td style="text-align:right;">{{number_format(array_sum($subtotala10),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala11) <= 0 ? '('.number_format(array_sum($subtotala11)*-1,0).')' : number_format(array_sum($subtotala11),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala12) <= 0 ? '('.number_format(array_sum($subtotala12)*-1,0).')' : number_format(array_sum($subtotala12),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala13) <= 0 ? '('.number_format(array_sum($subtotala13)*-1,0).')' : number_format(array_sum($subtotala13),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala14) <= 0 ? '('.number_format(array_sum($subtotala14)*-1,0).')' : number_format(array_sum($subtotala14),0)}}</td>
                                <td style="text-align:right;">{{array_sum($subtotala15) <= 0 ? '('.number_format(array_sum($subtotala15)*-1,0).')' : number_format(array_sum($subtotala15),0)}}</td>
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
                            <tr style="font-size: 10pt; ">
                                <td align="left" width="200">PT.PERTAMINA PEDEVE INDONESIA</td><br>
                            </tr>
                            <tr style="font-size: 10pt; ">
                                <td align="left" width="200">{{strtoupper($request->jabatan)}}</td><br>
                            </tr>
                        </table>
                        <table width="100%" style="font-size: 10pt; padding-left:75%">
                            <tr style="font-size: 10pt; ">
                                <td align="left" width="200">{{strtoupper($request->nama)}}</td><br>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </main>
        
    </body>
</html>
