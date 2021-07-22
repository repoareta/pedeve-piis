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
                <td style="text-align: left; padding-left:20px;">
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
                        $bul= strtoupper($array_bln[ltrim($request->bulan,0)]);
                        $bln = strtoupper($bul).' '.$request->tahun;
                    ?>
                    <p>
                        <b>
                        PT. PERTAMINA DANA VENTURA
                        <br>
                        DAFTAR DEPOSITO 
                        <br>
                        BULAN {{$bln}}
                        </b>
                    </p>
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="120px" height="60px">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font: normal 10px Verdana, Arial, sans-serif;">
                    TANGGAL REPORT: {{ date('d/m/y') }}
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>