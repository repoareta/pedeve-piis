<!DOCTYPE HTML>
<html lang='en-US'>
<head>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>
<body style="margin:0px;">
    <table>
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
        <thead style="border-bottom:1px solid black;">
            <tr>
                <td style="text-align: left; padding-left:20px;font: normal 14px Verdana, Arial, sans-serif;font-weight: bold">
                    <p>
                        <b>
                            <b style="font: normal 14px Verdana, Arial, sans-serif;font-weight: bold">PT. PERTAMINA DANA VENTURA</b>
                        <br>
                            RINCIAN KAS/BANK PER CASH JUDEX
                        <br>
                            BULAN {{strtoupper($bulan)}} {{ $request->tahun }}
                        <br>
                    </p>
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="100px">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>
