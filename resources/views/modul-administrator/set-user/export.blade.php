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
        <header>
            <table width="100%"  >
                <tr>
                    <td align="center" style="padding-left:150px;">
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="80px" style="padding-right:30px;"><br>
                    <font style="font-size: 12pt;font-weight: bold "> PT. PERTAMINA PEDEVE INDONESIA</font><br><br>
                    <font style="font-size: 12pt;font-weight: bold ">USER APPLICATION</font><br>
                    </td>
                    <hr>
                </tr>
            </table>
        </header>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table width="100%" style=" border-collapse: collapse;padding-top:10px;" border="1">
                <tr style="font-size: 11pt;">
                    <th width="10%">USER ID</th>
                    <th width="20%">USER NAME</th>
                    <th width="20%">USER GROUP</th>
                    <th width="20%">USER LEVEL</th>
                    <th width="30%">USER APPLICATION</th>
                </tr>
                @foreach($data_user as $row)
                <tr style="font-size: 9pt;">
                    <td>{{ $row->userid }}</td>
                    <td>{{ $row->usernm }}</td>
                    <td>{{ $row->kode }}</td>
                    <td>
                    <?php
                        if ($row->userlv == 0) {
                            echo "ADMINISTRATOR";
                        } else {
                            echo "USER";
                        }
                    ?>
                    </td>
                    <td>
                    <?php
                        if (substr_count($row->userap, "A") > 0) {
                            $userp1 = "[ KONTROLER ]";
                        } else {
                            $userp1="";
                        }
                        if (substr_count($row->userap, "G") > 0) {
                            $userp2 = "[ CUSTOMER MANAGEMENT ]";
                        } else {
                            $userp2="";
                        }
                        if (substr_count($row->userap, "D") > 0) {
                            $userp4 = "[ PERBENDAHARAAN ]";
                        } else {
                            $userp4="";
                        }
                        if (substr_count($row->userap, "E") > 0) {
                            $userp5 = "[ UMUM ]";
                        } else {
                            $userp5="";
                        }
                        if (substr_count($row->userap, "F") > 0) {
                            $userp6 = "[ SDM ]";
                        } else {
                            $userp6="";
                        }
                        echo $userp1.' '.$userp2.' '.$userp4.' '.$userp5.' '.$userp6;
                    ?>
                    </td>
                </tr>
                @endforeach
            </table>
        </main>
    </body>
</html>
