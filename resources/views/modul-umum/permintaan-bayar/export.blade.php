<!DOCTYPE html>
<html>

<head>
    <style>
        /**
                Set the margins of the page to 2, so the footer and the header
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
    @if($data_report->ci == 2)
    <header>
        <table width="100%">
            <tr>
                <td align="center" style="padding-left:150px;">
                    <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"
                        style="padding-right:30px;"><br>
                    <font style="font-size: 12pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br><br>
                    <font style="font-size: 12pt;font-weight: bold "><u>SURAT PERMINTAAN PROSES PEMBAYARAN</u></font>
                    <br>
                    <font style="font-size: 10pt;">NOMOR :{{$data_report->no_bayar}}</font>
                </td>
            </tr>
        </table>
    </header>
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <table width="100%" style="padding-top:10px;">
            <tr style="font-size: 10pt;">
                <td width="100px">KEPADA</td>
                <td width="20px">:</td>
                <td>{{strtoupper($request->kepada)}}</td><br>
            </tr>

            <tr style="font-size: 10pt;">
                <td width="100px">DARI</td>
                <td width="20px">:</td>
                <td>{{strtoupper($request->dari)}}</td>
                <hr>
            </tr>
        </table>
        <table width="100%" style="padding-top:-20px;">
            <tr style="font-size: 10pt;">
                <td width="600px">TERLAMPIR DIKIRIMKAN DOKUMEN PENUNJANG :</td><br>
            </tr>
            <tr style="font-size: 10pt;">
                <td width="200px">{{strtoupper($data_report->lampiran)}}</td>
            </tr>
        </table>
        <table width="100%" style="padding-top:10px;">
            <tr style="font-size: 10pt;">
                <td width="200px">UNTUK PEMBAYARAN</td>
                <td width="20px">:</td>
                <td>{{strtoupper($data_report->keterangan)}}</td>
            </tr>
        </table>
        <table width="100%" style="padding-top:10px;">
            <tr style="font-size: 10pt;">
                <td width="200px">SEBESAR</td>
                <td width="20px">:</td>
                <td>USD
                    <?php echo number_format($list_acount, 0, ',', '.'); ?>
                </td>
            </tr>
        </table>
        <table width="100%" style="padding-top:5px;">
            <tr style="font-size: 10pt;">
                <td width="200px">DIBAYARKAN KEPADA</td>
                <td width="20px">:</td>
                <td>{{strtoupper($data_report->kepada)}}</td>
            </tr>
        </table>
        <table width="100%" style="padding-top:15px;">
            <tr style="font-size: 10pt;">
                <td width="200px">NO REKENING </td>
                <td width="20px">:</td>
                <td>
                    @foreach($data_rek as $data_r)
                    {{strtoupper($data_r->norek)}}
                    @endforeach
                </td>
            </tr>
        </table>


        <table width="100%" style="padding-top:10px;">
            <tr style="font-size: 10pt;">
                <td width="600px">PERINCIAN :</td>
            </tr>
        </table>
        <table width="100%" border="none">
            <tr style="font-size: 10pt;border-style: groove" bgcolor="#DCDCDC">
                <td width="1" align="center">NO</td>
                <td width="100">KETERANGAN</td>
                <td width="10PX" align="center">SANDI</td>
                <td width="10PX" align="center">JUMLAH</td>
            </tr>
        </table>
        <?php $no=0; ?>
        @foreach($bayar_detail_list as $data_detail)
        <?php $no++; ?>
        <table width="100%">
            <tr style="font-size: 10pt;">
                <td style="border-bottom:2px dotted black;" width="70px" align="center">{{$no}}</td>
                <td style="border-bottom:2px dotted black;" width="275">{{strtoupper($data_detail->keterangan)}}</td>
                <td width="70" align="center">{{$data_detail->account}}</td>
                <td width="50">USD</td>
                <td>
                    <?php echo number_format($data_detail->nilai, 0, ',', '.'); ?>
                </td>
            </tr>
        </table>
        @endforeach
        <table width="100%">
            <tr style="font-size: 10pt;">
                <td align="right" width="400"><b>TOTAL </b></td>
                <td width="50"><b>USD</b></td>
                <td><b>
                        <?php echo number_format($list_acount, 0, ',', '.'); ?>
                    </b></td>
            </tr>
        </table>
        <table width="100%" style="font-size: 10pt; padding-top:50px;">
            <tr style="font-size: 10pt;">
                <td align="right" width="400">JAKARTA</td>
                <td width="10">, </td>
                <td>{{$request->tglsurat}}</td><br>
            </tr>
        </table>
        <table width="100%" style="font-size: 10pt; padding-top:-10px;">
            <tr style="font-size: 10pt;">
                <td align="center" width="200">MENYETUJUI,</td>
                <td align="center" width="200">PEMOHON,</td><br>
            </tr>
            <tr style="font-size: 10pt;">
                <td align="center" width="200">{{strtoupper($data_report->menyetujuijb)}}</td>
                <td align="center" width="200">{{strtoupper($data_report->pemohonjb)}}</td><br>
            </tr>
        </table>
        <table width="100%" style="font-size: 10pt; padding-top:10px;">
            <tr style="font-size: 10pt;">
                <td align="center" width="200"><u>{{strtoupper($data_report->menyetujui)}}</u></td>
                <td align="center" width="200"><u>{{strtoupper($data_report->pemohon)}}</u></td><br>
            </tr>
        </table>
        @else
        <header>
            <table width="100%">
                <tr>
                    <td align="center" style="padding-left:150px;">
                        <img align="right" src="{{public_path() . '/images/pertamina.jpg'}}" width="160px" height="80px"
                            style="padding-right:30px;"><br>
                        <font style="font-size: 12pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br><br>
                        <font style="font-size: 12pt;font-weight: bold "><u>SURAT PERMINTAAN PROSES PEMBAYARAN</u>
                        </font><br>
                        <font style="font-size: 10pt;">NOMOR :{{$data_report->no_bayar}}</font>
                    </td>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table width="100%" style="padding-top:10px;">
                <tr style="font-size: 10pt;">
                    <td width="100px">KEPADA</td>
                    <td width="20px">:</td>
                    <td>{{strtoupper($request->kepada)}}</td><br>
                </tr>

                <tr style="font-size: 10pt;">
                    <td width="100px">DARI</td>
                    <td width="20px">:</td>
                    <td>{{strtoupper($request->dari)}}</td>
                    <hr>
                </tr>
            </table>
            <table width="100%" style="padding-top:-20px;">
                <tr style="font-size: 10pt;">
                    <td width="600px">TERLAMPIR DIKIRIMKAN DOKUMEN PENUNJANG :</td><br>
                </tr>
                <tr style="font-size: 10pt;">
                    <td width="200px">{{strtoupper($data_report->lampiran)}}</td>
                </tr>
            </table>
            <table width="100%" style="padding-top:10px;">
                <tr style="font-size: 10pt;">
                    <td width="200px">UNTUK PEMBAYARAN</td>
                    <td width="20px">:</td>
                    <td>{{strtoupper($data_report->keterangan)}}</td>
                </tr>
            </table>
            <table width="100%" style="padding-top:10px;">
                <tr style="font-size: 10pt;">
                    <td width="200px">SEBESAR</td>
                    <td width="20px">:</td>
                    <td>
                        <?php echo currency_idr($list_acount);  $count=number_format($list_acount,0,'','')?>
                    </td>
                </tr>
                <tr style="font-size: 9pt;">
                    <td width="200px"></td>
                    <td width="20px"></td>
                    <td>{{ strtoupper(terbilang($count)) }} {{strtoupper('rupiah')}}</td>
                </tr>
            </table>
            <table width="100%" style="padding-top:5px;">
                <tr style="font-size: 10pt;">
                    <td width="200px">DIBAYARKAN KEPADA</td>
                    <td width="20px">:</td>
                    <td>{{strtoupper($data_report->kepada)}}</td>
                </tr>
            </table>
            <table width="100%" style="padding-top:15px;">
                <tr style="font-size: 10pt;">
                    <td width="200px">NO REKENING </td>
                    <td width="20px">:</td>
                    <td>
                        @foreach($data_rek as $data_r)
                        {{strtoupper($data_r->norek)}} - {{$data_r->nama_bank}}
                        @endforeach
                    </td>
                </tr>
            </table>


            <table width="100%" style="padding-top:10px;">
                <tr style="font-size: 10pt;">
                    <td width="600px">PERINCIAN :</td>
                </tr>
            </table>
            <table width="100%" border="none">
                <tr style="font-size: 10pt;border-style: groove" bgcolor="#DCDCDC">
                    <td width="1" align="center">NO</td>
                    <td width="100">KETERANGAN</td>
                    <td width="10PX" align="center">SANDI</td>
                    <td width="10PX" align="center">JUMLAH</td>
                </tr>
            </table>
            <?php $no=0; ?>
            @foreach($bayar_detail_list as $data_detail)
            <?php $no++; ?>
            <table width="100%">
                <tr style="font-size: 10pt;">
                    <td style="border-bottom:2px dotted black;" width="70px" align="center">{{$no}}</td>
                    <td style="border-bottom:2px dotted black;" width="275">{{strtoupper($data_detail->keterangan)}}
                    </td>
                    <td width="70" align="center">{{$data_detail->account}}</td>
                    <td width="50">Rp.</td>
                    <td>
                        <?php echo number_format($data_detail->nilai, 2, ',', '.'); ?>
                    </td>
                </tr>
            </table>
            @endforeach
            <table width="100%">
                <tr style="font-size: 10pt;">
                    <td align="right" width="400"><b>TOTAL </b></td>
                    <td width="50"><b>Rp.</b></td>
                    <td><b>
                            <?php echo number_format($list_acount, 2, ',', '.'); ?>
                        </b></td>
                </tr>
            </table>
            <table width="100%" style="font-size: 10pt; padding-top:50px;">
                <tr style="font-size: 10pt;">
                    <td align="right" width="400">JAKARTA</td>
                    <td width="10">, </td>
                    <td>{{$request->tglsurat}}</td><br>
                </tr>
            </table>
            <table width="100%" style="font-size: 10pt; padding-top:-10px;">
                <tr style="font-size: 10pt;">
                    <td align="center" width="200">MENYETUJUI,</td>
                    <td align="center" width="200">PEMOHON,</td><br>
                </tr>
                <tr style="font-size: 10pt;">
                    <td align="center" width="200">{{strtoupper($request->menyetujuijb)}}</td>
                    <td align="center" width="200">{{strtoupper($request->pemohonjb)}}</td><br>
                </tr>
            </table>
            <table width="100%" style="font-size: 10pt; padding-top:10px;">
                <tr style="font-size: 10pt;">
                    <td align="center" width="200"><u>{{strtoupper($data_report->menyetujui)}}</u></td>
                    <td align="center" width="200"><u>{{strtoupper($data_report->pemohon)}}</u></td><br>
                </tr>
            </table>
            @endif
</body>

</html>
