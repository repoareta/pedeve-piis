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
        $array_bln	 = array(
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
    ?>
        <thead style="border-bottom:1px solid black;">
            <tr>
                <td style="text-align: left; padding-left:20px;font: normal 14px Verdana, Arial, sans-serif;font-weight: bold">
                    <p>
                        <b>
                            <b style="font: normal 18px Verdana, Arial, sans-serif;font-weight: bold">PT. Pertamina Pedeve Indonesia</b>
                        <br>
                        <br>
                            Laporan Transaksi Kas/Bank
                        <br>
                            Per Cash Judex
                        <br>
                        <?php
                            $tgl_1 = date_create($request->tanggal);
                            $thn1 = date_format($tgl_1, 'd/m/Y');
                            $tgl_2 = date_create($request->tanggal2);
                            $thn2 = date_format($tgl_2, 'd/m/Y');
                        ?>
                        </b>
                    </p>
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="100px">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font: normal 14px Verdana, Arial, sans-serif;padding-left:20px">
                    <b>Periode</b> : {{$thn1}} <b>s/d</b> {{$thn2}}
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>