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
        <table width="100%">
            <tr>
                <td align="left" style="padding-left:80px;">
                    <table>
                        <tr>
                            <td>
                                <font style="font-size: 12pt;font-weight: bold ">PT. PERTAMINA DANA VENTURA</font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font style="font-size: 12pt;font-weight: bold ">REKAP IURAN DANA JAMSOSTEK </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font style="font-size: 12pt;font-weight: bold ">TAHUN {{ $request->tahun }}</font>
                            </td>
                        </tr>
                    </table>
                </td>

                <td align="center" style="">
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px"
                       style="padding-right:40px;">
                </td>
            </tr>
        </table>
        <table width="100%" style="padding-top:4%; padding-left:30px;;padding-right:30px;">
            <tr>
                <td>
                    <font style="font-size: 10pt;font-style: italic">Tanggal Cetak: {{ $request->tanggal}}</font>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" style="font-size: 10pt;border-collapse: collapse;" border="1">
                        <tr style="text-align:center; font-weight: bold">
                            <td>NO</td>
                            <td>NOPEK</td>
                            <td>NAMA</td>
                            <td>JAN</td>
                            <td>FEB</td>
                            <td>MARET</td>
                            <td>APRIL</td>
                            <td>MEI</td>
                            <td>JUNI</td>
                            <td>JULI</td>
                            <td>AGUSTUS</td>
                            <td>SEPT</td>
                            <td>OKT</td>
                            <td>NOV</td>
                            <td>DES</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">1</td>
                            <td style="text-align:center;">-</td>
                            <td style="text-align:left;">NAMA</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right;">Total:</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                            <td style="text-align:right;">10</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>

</body>

</html>