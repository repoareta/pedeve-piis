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
    <?php 
    if($bulan == "00" OR $bulan == "OB"){
        $bln = "OPENING BALANCE $tahun";
    }else{
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
        $bul= strtoupper($array_bln[ltrim($bulan,0)]);
        $bln = strtoupper($bul).' '.$tahun;
    }
    ?>
        <thead style="border-bottom:1px solid black;">
            <tr>
                <td style="text-align: center; padding-left:270px;">
                    <p>
                        <b>
                        PT. PERTAMINA PEDEVE INDONESIA
                        <br>
                        LAPORAN D2 KAS/BANK
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