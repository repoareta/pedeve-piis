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
            /* header {
                position: fixed;
                top: 1cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
            } */
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
                <tr>
                    <td align="center" style="padding-left:200px;">
                        <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:30px;"><br>
                        <font style="font-size: 10pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br>
                        <font style="font-size: 10pt;font-weight: bold ">(PEDEVE)</font><br>
                        <font style="font-size: 10pt;"> JL. RADEN SALEH NO.44 - CIKINI, JAKARTA PUSAT</font><br>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
        <table width="100%" style="font-family: sans-serif;border-collapse: collapse;">
                <thead>
                    <tr style="text-align:center;font-size: 8pt;">
                        <td colspan="3">
                            <table>
                            <?php 
                                foreach($data_list as $data)
                                {
                                    $no_rekap = $data->no_rekap;
                                    $tanggal_rekap = $data->tanggal_rekap;
                                }
                            ?>
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6">BUKU TAMBAHAN KAS / BANK</td>
                                </tr>
                                <tr>
                                    <td >NO. REKAP</td>
                                    <td>:</td>
                                    <td>{{ $no_rekap}}</td>
                                </tr>
                                <tr>
                                    <td >TANGGAL REKAP</td>
                                    <td>:</td>
                                    <td>{{ $tanggal_rekap}}</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="3">
                            <table width="100%" style="border: 1px solid black;padding-left:10px;font-size: 8pt;">
                            <?php 
                                foreach($data_list as $data)
                                {
                                    $jenis_kartu = $data->jenis_kartu;
                                    $lokasi_kas_bank = $data->lokasi_kas_bank;
                                    $no_rekening = $data->no_rekening;
                                    $mata_uang = $data->mata_uang;
                                }
                            ?>
                                <tr>
                                    <td width="30%">HALAMAN</td>
                                    <td width="5%">:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td width="15%">JENIS KARTU</td>
                                    <td width="5%">:</td>
                                    <td>{{ $jenis_kartu}}</td>
                                </tr>
                                <tr>
                                    <td width="15%">LOKASI</td>
                                    <td width="5%">:</td>
                                    <td>{{ $lokasi_kas_bank}}</td>
                                </tr>
                                <tr>
                                    <td width="15%">NO. REKENING</td>
                                    <td width="5%">:</td>
                                    <td>{{ $no_rekening}}</td>
                                </tr>
                                <tr>
                                    <td width="15%">MATA UANG</td>
                                    <td width="5%">:</td>
                                    <td>{{ $mata_uang}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </thead>
            </table>
            <table width="100%" style="font-family: sans-serif;border-collapse: collapse;">
                <thead>
                    <tr style="text-align:center;font-size: 8pt;border: 1px solid black;">
                        <th width="5%" style="text-align:center;border:1px solid black;">NO.<br>URUT</th>
                        <th style="text-align:center;border:1px solid black;">NO. DOKUMEN</th>
                        <th style="text-align:center;border:1px solid black;">NO. BUKTI</th>
                        <th width="35%" style="text-align:center;border:1px solid black;">URAIAN PENJELASAN</th>
                        <th style="text-align:center;border:1px solid black;">PENERIMAAN</th>
                        <th style="text-align:center;border:1px solid black;">PENGELUARAN</th>
                    </tr>
                <thead>
                <tbody>
                <?php $no=0; ?>
                @foreach($data_list as $data)
                <?php $no++; 
                    $debet[$no]=$data->debet;
                    $kredit[$no]=$data->kredit;
                    $saldo_awal[$no]=$data->saldo_awal;
                ?>
                    <tr style="text-align:center;font-size: 8pt;border: 1px solid black;">
                        <td width="5%" style="text-align:center;border:1px solid black;">{{ $no}}</td>
                        <td style="text-align:center;border:1px solid black;">{{ $data->no_dokumen}}</td>
                        <td style="text-align:center;border:1px solid black;">{{ $data->no_bukti}}</td>
                        <td style="text-align:left;border:1px solid black;">{{ $data->uraian_penjelasan}}</td>
                        <td style="text-align:right;border:1px solid black;">{{ number_format($data->debet,2) < 0 ? "(".number_format($data->debet*-1,2).")" : number_format($data->debet,2) }}</td>
                        <td style="text-align:right;border:1px solid black;">{{ number_format($data->kredit,2) < 0 ? "(".number_format($data->kredit*-1,2).")" : number_format($data->kredit,2) }}</td>
                    </tr>
                @endforeach
                    <tr style="text-align:center;font-size: 8pt;border: 1px solid black;">
                        <th colspan="4" style="text-align:center;border:1px solid black;">TOTAL</th>
                        <th style="text-align:right;border:1px solid black;">{{ number_format(array_sum($debet),2) < 0 ? "(".number_format(array_sum($debet)*-1,2).")" : number_format(array_sum($debet),2) }}</th>
                        <th style="text-align:right;border:1px solid black;">{{ number_format(array_sum($kredit),2) < 0 ? "(".number_format(array_sum($kredit)*-1,2).")" : number_format(array_sum($kredit),2) }}</th>
                    </tr>
                <tbody>
            </table>
            <table  width="100%" style="font-family: sans-serif;border-collapse: collapse;">
                <tbody>
                    <tr style="text-align:center;font-size: 8pt;border: 1px solid black;">
                        <th colspan="2" style="text-align:center;border:1px solid black;">SALDO AWAL</th>
                        <th style="text-align:right;border:1px solid black;">PENERIMAAN</th>
                        <th style="text-align:center;border:1px solid black;">PENGELUARAN</th>
                        <th style="text-align:center;border:1px solid black;">PERUBAHAN</th>
                        <th style="text-align:center;border:1px solid black;">SALDO AKHIR</th>
                    </tr>
                    <tr style="text-align:center;font-size: 8pt;border: 1px solid black;">
                        <th colspan="2" style="text-align:right;border:1px solid black;">{{ number_format(abs(array_sum($saldo_awal)),2) }}</th>
                        <th style="text-align:right;border:1px solid black;">{{ number_format(array_sum($debet),2) < 0 ? "(".number_format(array_sum($debet)*-1,2).")" : number_format(array_sum($debet),2) }}</th>
                        <th style="text-align:right;border:1px solid black;">{{ number_format(array_sum($kredit),2) < 0 ? "(".number_format(array_sum($kredit)*-1,2).")" : number_format(array_sum($kredit),2) }}</th>
                        <th style="text-align:right;border:1px solid black;">
                        @if((array_sum($debet)-array_sum($kredit)) < 0)
                                <?php echo number_format((array_sum($debet)-array_sum($kredit))*-1,2) ."CR"; ?>
                        @else
                                <?php echo number_format((array_sum($debet)-array_sum($kredit)),2); ?>

                        @endif
                        </th>
                        <th style="text-align:right;border:1px solid black;">{{ number_format((array_sum($debet)-array_sum($kredit))+array_sum($saldo_awal),2) < 0 ? "(".number_format(((array_sum($debet)-array_sum($kredit))+array_sum($saldo_awal))*-1,2).")" : number_format((array_sum($debet)-array_sum($kredit))+array_sum($saldo_awal),2) }}</th>
                    </tr>
                </tbody>
            </table>
            
            <table width="100%" style="font-size: 10pt; padding-top:10px;">
                    <tr>
                        <td align="center"></td><td align="center" width="200">JAKARTA, {{date('d/m/Y') }}</td>
                    </tr>
                    <tr style="font-size: 10pt;">
                        <td align="center" width="200">DIBUAT OLEH,</td><td align="center" width="200">DISETUJUI OLEH,</td><br>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
            </table>
            <table width="100%" style="font-size: 10pt; padding-top:10px;">
                    <tr style="font-size: 10pt;">
                        <td align="center" width="200"><u>{{strtoupper($request->dibuat) }}</u></td><td align="center" width="200"><u>{{strtoupper($request->setuju) }}</u></td><br>
                    </tr>
            </table>
        </main>
        
    </body>
</html>