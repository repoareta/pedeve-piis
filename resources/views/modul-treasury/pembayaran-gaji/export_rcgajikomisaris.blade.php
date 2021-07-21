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
            height: 1cm;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
    </header>
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <table width="100%">
            <tbody>
                <tr>
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
                    
                    $bulan = ($array_bln[ltrim(date('m'),0)]);
            ?>
                    <td colspan="3" style="padding-top:-5%;padding-bottom:2%;">Jakarta, <font style="padding-left:5%;">
                            {{$bulan}} {{date('Y')}}</font>
                    </td>
                </tr>
                <tr>
                    <td width="10%">No</td>
                    <td width="3%">:</td>
                    <td>RC <font style="padding-left:5%;">/{{date('m')}}/PDV/{{date('Y')}}</font>
                    </td>
                </tr>
                <tr>
                    <td width="10%">Lampiran</td>
                    <td width="3%">:</td>
                    <td>{{$request->lampiran}}</td>
                </tr>
                <tr>
                    <td width="10%">Perihal</td>
                    <td width="3%">:</td>
                    <td>{{$request->perihal}}</td>
                </tr>
                <tr>
                    <td colspan="3">Kepada Yth.</td>
                </tr>
            </tbody>
        </table>
        <table width="100%">
            <tr>
                <td style="padding-top:-2%;padding-bottom:10%;">Di-</td>
            </tr>
            <tr>
                <td>Dengan Hormat,</td>
            </tr>
            <tr>
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
                
                $bulan_ = ($array_bln[ltrim($request->bulan,0)]);
            ?>
                <td style="text-align: justify;">Mohon bantuan Saudara untuk mendebet dari Rekening PT Pertamina Pedeve
                    Indonesia No. {{$request->norek}} sebesar {{number_format($request->total,2)}}
                    {{ucwords(terbilang(number_format($request->total,0))) }} @if($request->ci == 1) Rupiah @else Dollar
                    @endif dan melaksanakan transfer tanggal 25/{{$request->bulan}}/{{$request->tahun}} kepada :</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="padding-top:2%;padding-left:5%;text-align: justify;">Rekening Tabungan masing-masing Pekerja
                    PT. Pertamina Pedeve Indonesia sesuai daftar terlampir, sebesar Rp.
                    {{number_format($request->transfer,2)}} {{ucwords(terbilang(number_format($request->transfer,0))) }}
                    @if($request->ci == 1) Rupiah @else Dollar @endif untuk pembayaran gaji bulan {{$bulan_}}
                    {{$request->tahun}}.</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="padding-bottom:3%;">No. Cek :{{$request->reg}}</td>
            </tr>
            <tr>
                <td style="padding-bottom:3%;">Atas perhatian dan kerjasama Saudara kami ucapkan terima kasih.</td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="padding-top:2%;padding-bottom:10%;text-align:center;"><b>PT. PERTAMINA PEDEVE INDONESIA</b>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td style="text-align:center;">{{$request->jabkir}}</td>
                <td></td>
                <td style="text-align:center;">{{$request->jabkan}}</td>
            </tr>
            <tr>
                <td style="text-align:center;padding-top:5%;">{{$request->namkir}}</td>
                <td></td>
                <td style="text-align:center;padding-top:5%;">{{$request->namkan}}</td>
            </tr>
        </table>


    </main>
    <footer>
    </footer>
</body>

</html>