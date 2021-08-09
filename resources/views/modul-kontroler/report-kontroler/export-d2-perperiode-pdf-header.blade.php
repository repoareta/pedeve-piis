<!DOCTYPE HTML>
<html lang='en-US'>
<head>
</head>
<style>
    table {
        font: Verdana, Arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
    }
</style>
<body style="margin:0px;">
    <table>
        <thead style="border-bottom:1px solid black;">
            <tr>
                <td style="text-align: center; padding-left:270px;">
                    <p>
                        <b>
                        PT. PERTAMINA PEDEVE INDONESIA
                        <br>
                        RINCIAN TRANSAKSI (D-2) PER PERIODE
                        <br>
                        BULAN {{ strtoupper(bulan($bulan_mulai))." S/D ".strtoupper(bulan($bulan_sampai))." ".$tahun }}
                        </b>
                    </p>
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="120px" height="60px">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font: normal 10px Verdana, Arial, sans-serif;">
                    NO. REPORT : CTR-D2
                    <br>
                    TANGGAL REPORT: {{ date('d/m/y') }}
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>