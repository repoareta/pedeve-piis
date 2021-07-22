<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        RINCIAN TRANSAKSI (D-2)
    </title>
</head>
<style media="screen">

table {
    font: normal 12px Verdana, Arial, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-left {
    text-align: left;
}

td {
    vertical-align: top;
    padding: 5px;
}

th {
    padding: 7px;
}

thead { 
    display: table-header-group;
    border-top: 1px solid black; 
    border-bottom: 1px solid black;
}

tr { 
    page-break-inside: avoid 
}

.th-small {
    width: 40px;
}

.th-medium {
    width: 70px;
}

.th-large {
    width: 120px;
}

</style>
<body style="margin:0px;">
    <main>
        <div class="row">
            <table class="table tree">
                <thead>
                    <tr>
                        <th class="th-small text-left">TANGGAL</th>
                        <th class="th-small text-left">NO.DOC</th>
                        <th class="th-small">JK</th>
                        <th class="th-small">ST</th>
                        <th class="th-small">VC</th>
                        <th class="th-small">CI</th>
                        <th class="th-medium">LP</th>
                        <th class="th-medium">SANDI</th>
                        <th class="th-medium">CJ</th>
                        <th class="th-large">JUMLAH RUPIAH</th>
                        <th class="th-large">JUMLAH DOLLAR</th>
                        <th class="th-medium">KURS</th>
                        <th class="th-large text-left">KETERANGAN</th>
                        <th class="th-large text-left">TGL.BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                 // TOTAL CI
                 $total_ci_1_rp = $total_ci_2_rp =  0;
                
                 // TOTAL SANDI
                 $total_sandi_1_rp = $total_sandi_2_rp =  0;
                 // SUB DEBET
                 $sub_debet_1_rp = $sub_debet_2_rp =  0;
                 // TOTAL DEBET
                 $total_debet_1_rp = $total_debet_2_rp =  0;
                 // SUB KREDIT
                 $sub_kredit_1_rp = $sub_kredit_2_rp =  0;
                 // TOTAL KREDIT
                 $total_kredit_1_rp = $total_kredit_2_rp =  0;
                 // SUB MAIN
                 $total_main_1_rp = $total_main_2_rp =  0;
                 // SUB CLASS
                 $total_class_1_rp = $total_class_2_rp =  0;
                 
                foreach ($data_list as $key=>$row) {
                    //TOTAL CI
                    if ($row->ci == 1) {
                        $total_ci_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_ci_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_ci_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_ci_2_rp += $row['totprice'];
                    }else{
                        $total_ci_2_rp = 0;
                    }

                    //TOTAL SANDI
                    if ($row->ci == 1) {
                        $total_sandi_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_sandi_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_sandi_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_sandi_2_rp += $row['totprice'];
                    }else{
                        $total_sandi_2_rp = 0;
                    }

                    //SUB DEBET
                    if ($row->ci == 1) {
                        $sub_debet_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $sub_debet_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $sub_debet_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $sub_debet_2_rp += $row['totprice'];
                    }else{
                        $sub_debet_2_rp = 0;
                    }
                    //TOTAL DEBET
                    if ($row->ci == 1) {
                        $total_debet_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_debet_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_debet_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_debet_2_rp += $row['totprice'];
                    }else{
                        $total_debet_2_rp = 0;
                    }
                    
                    //SUB KREDIT
                    if ($row->ci == 1) {
                        $sub_kredit_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $sub_kredit_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $sub_kredit_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $sub_kredit_2_rp += $row['totprice'];
                    }else{
                        $sub_kredit_2_rp = 0;
                    }
                    //TOTAL KREDIT
                    if ($row->ci == 1) {
                        $total_kredit_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_kredit_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_kredit_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_kredit_2_rp += $row['totprice'];
                    }else{
                        $total_kredit_2_rp = 0;
                    }
                    
                    //TOTAL MAIN
                    if ($row->ci == 1) {
                        $total_main_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_main_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_main_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_main_2_rp += $row['totprice'];
                    }else{
                        $total_main_2_rp = 0;
                    }
                    
                    //TOTAL CLASS
                    if ($row->ci == 1) {
                        $total_class_1_rp += $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $total_class_1_rp += $row['totprice']*$row['rate'];
                    }else{
                        $total_class_1_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $total_class_2_rp += $row['totprice'];
                    }else{
                        $total_class_2_rp = 0;
                    }

                    $tglbay= date_create($row->tglbayar);
                    $tglbayar = date_format($tglbay, 'd/m/Y');
                    $tglbayar_1 = date_format($tglbay, 'd-M-Y');
                    if ($row->ci == 1) {
                        $jml_rp = $row['totprice'];
                    }elseif ($row->ci == 2) {
                        $jml_rp = $row['totprice']*$row['rate'];
                    }else{
                        $jml_rp = 0;
                    }
                    if ($row->ci == 2) {
                        $jml_dl = $row['totprice'];
                    }else{
                        $jml_dl = 0;
                    }

                    if($row->ci == '1'){
                        $kurs = "";
                    }else{
                        $kurs = number_format($row->rate,2);
                    }

                    $jml_1_rp =$jml_rp < 0 ? '('.number_format($jml_rp*-1,2) .')' : number_format($jml_rp,2);
                    $jml_2_dl =$jml_dl < 0 ? '('.number_format($jml_dl*-1,2) .')' : number_format($jml_dl,2);
                    echo '<tr>
                            <td class="th-small text-left">'.$tglbayar.'</td>
                            <td class="th-small text-left">'.$row->docno.'</td>
                            <td class="th-small text-center">'.$row->jk.'</td>
                            <td class="th-small text-center">'.$row->store.'</td>
                            <td class="th-small text-left">'.$row->voucher.'</td>
                            <td class="th-small text-center">'.$row->ci.'</td>
                            <td class="th-medium text-center">'.$row->lokasi.'</td>
                            <td class="th-medium text-center">'.$row->account.'</td>
                            <td class="th-medium text-center">'.$row->cj.'</td>
                            <td class="th-large text-right">'.$jml_1_rp.'</td>
                            <td class="th-large text-right">'.$jml_2_dl.'</td>
                            <td class="th-medium text-right">'.$kurs.'</td>
                            <td class="th-large text-left">'.$row->keterangan.'</td>
                            <td class="th-large text-left">'.$tglbayar_1.'</td>
                        </tr>';

                        //TOTAL CI
                        if(isset($data_list[$key+1]['account']))
                        {
                            $sandi =  $data_list[$key+1]['account'];
                            $mu =  $data_list[$key+1]['ci'];
                            $lapangan =  $data_list[$key+1]['lokasi'];
                            $sanmain =  substr($data_list[$key+1]['account'],0,3);
                            $sanclass =  substr($data_list[$key+1]['account'],0,1);
                        }else{
                            $sandi =  substr($data_list[$key]['account'],0,2);
                            $mu =  $data_list[$key]['ci']*2;
                            $lapangan =  substr($data_list[$key]['lokasi'],0,1);
                            $sanmain =  substr($data_list[$key]['account'],0,4);
                            $sanclass =  substr($data_list[$key]['account'],0,3);
                        }

                        //TOTAL CI
                        if (($sandi != $row->account or $mu != $row->ci) or $row->lokasi != $lapangan) {
                            $sub_total_ci_1_rp =$total_ci_1_rp < 0 ? '('.number_format($total_ci_1_rp*-1,2) .')' : number_format($total_ci_1_rp,2);
                            $sub_total_ci_2_rp =$total_ci_2_rp < 0 ? '('.number_format($total_ci_2_rp*-1,2) .')' : number_format($total_ci_2_rp,2);

                            echo '<tr>
                                <td class="text-right"></td>
                                <td colspan="4" class="text-let">TOTAL CI :</td>
                                <td class="text-right">'.$row->ci.'</td>
                                <td colspan="2" class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right">'.$sub_total_ci_1_rp.'</td>
                                <td class="text-right">'.$sub_total_ci_2_rp.'</td>
                                <td colspan="3" class="text-right"></td>
                            </tr>';
                            $total_ci_1_rp = 0;
                            $total_ci_2_rp = 0;
                        }

                        //TOTAL SANDI
                        if ($sandi != $row->account) {
                            $sub_total_sandi_1_rp =$total_sandi_1_rp < 0 ? '('.number_format($total_sandi_1_rp*-1,2) .')' : number_format($total_sandi_1_rp,2);
                            $sub_total_sandi_2_rp =$total_sandi_2_rp < 0 ? '('.number_format($total_sandi_2_rp*-1,2) .')' : number_format($total_sandi_2_rp,2);
                            echo '<tr>
                                <td class="text-right"></td>
                                <td colspan="5" class="text-left">TOTAL SANDI :</td>
                                <td colspan="2" class="text-right">'.$row->account.'</td>
                                <td class="text-right"></td>
                                <td class="text-right">'.$sub_total_sandi_1_rp.'</td>
                                <td class="text-right">'.$sub_total_sandi_2_rp.'</td>
                                <td colspan="3" class="text-right"></td>
                            </tr>';
                            $total_sandi_1_rp = 0;
                            $total_sandi_2_rp = 0;

                            //SUB DEBET
                            $sub_debet_1_1_rp =$sub_debet_1_rp > 0 ? number_format($sub_debet_1_rp,2) : 0.00;
                            $sub_debet_2_1_rp =$sub_debet_2_rp > 0 ? number_format($sub_debet_2_rp,2) : 0.00;
                            echo '<tr>
                                <td colspan="6" class="text-left"></td>
                                <td colspan="2" class="text-right">SUB TOTAL DEBET</td>
                                <td class="text-right"></td>
                                <td class="text-right">'.$sub_debet_1_1_rp.'</td>
                                <td class="text-right">'.$sub_debet_2_1_rp.'</td>
                                <td colspan="3" class="text-right"></td>
                            </tr>';
                            $sub_debet_1_rp = 0;
                            $sub_debet_2_rp = 0;

                            //SUB KREDIT
                            $sub_kredit_1_1_rp =$sub_kredit_1_rp < 0 ? '('.number_format($sub_kredit_1_rp*-1,2).')' : 0.00;
                            $sub_kredit_2_1_rp =$sub_kredit_2_rp < 0 ? '('.number_format($sub_kredit_2_rp*-1,2).')' : 0.00;
                            echo '<tr>
                            <td colspan="6" class="text-left"></td>
                            <td colspan="2" class="text-right">SUB TOTAL KREDIT</td>
                            <td class="text-right"></td>
                            <td class="text-right">'.$sub_kredit_1_1_rp.'</td>
                            <td class="text-right">'.$sub_kredit_2_1_rp.'</td>
                            <td colspan="3" class="text-right"></td>
                            </tr>';
                            $sub_kredit_1_rp = 0;
                            $sub_kredit_2_rp = 0;
                        }

                        //TOTAL MAIN
                        if ($sanmain != substr($row->account, 0, 3)) {
                            $sub_total_main_1_rp =$total_main_1_rp < 0 ? '('.number_format($total_main_1_rp*-1,2) .')' : number_format($total_main_1_rp,2);
                            $sub_total_main_2_rp =$total_main_2_rp < 0 ? '('.number_format($total_main_2_rp*-1,2) .')' : number_format($total_main_2_rp,2);
                            echo '<tr>
                                <td class="text-right"></td>
                                <td colspan="5" class="text-left">TOTAL MAIN :</td>
                                <td colspan="2" class="text-right">'.substr($row->account, 0, 3).'</td>
                                <td class="text-right"></td>
                                <td class="text-right">'.$sub_total_main_1_rp.'</td>
                                <td class="text-right">'.$sub_total_main_2_rp.'</td>
                                <td colspan="3" class="text-right"></td>
                            </tr>';
                            $total_main_1_rp = 0;
                            $total_main_2_rp = 0;
                        }

                        //TOTAL CLASS
                        if ($sanclass != substr($row->account, 0, 1)) {
                            $sub_total_class_1_rp =$total_class_1_rp < 0 ? '('.number_format($total_class_1_rp*-1,2) .')' : number_format($total_class_1_rp,2);
                            $sub_total_class_2_rp =$total_class_2_rp < 0 ? '('.number_format($total_class_2_rp*-1,2) .')' : number_format($total_class_2_rp,2);
                            echo '<tr>
                                <td class="text-right"></td>
                                <td colspan="5" class="text-left">TOTAL CLASS :</td>
                                <td colspan="2" class="text-right">'.substr($row->account, 0, 1).'</td>
                                <td class="text-right"></td>
                                <td class="text-right">'.$sub_total_class_1_rp.'</td>
                                <td class="text-right">'.$sub_total_class_2_rp.'</td>
                                <td colspan="3" class="text-right"></td>
                            </tr>';
                            $total_class_1_rp = 0;
                            $total_class_2_rp = 0;
                        }
                        //TOTAL DEBET
                        $total_debet_1_1_rp =$total_debet_1_rp > 0 ? number_format($total_debet_1_rp,2) : 0.00;
                        $total_debet_2_1_rp =$total_debet_2_rp > 0 ? number_format($total_debet_2_rp,2) : 0.00;
                        //TOTAL KREDIT
                        $total_kredit_1_1_rp =$total_kredit_1_rp < 0 ? '('.number_format($total_kredit_1_rp*-1,2).')': 0.00;
                        $total_kredit_2_1_rp =$total_kredit_2_rp < 0 ? '('.number_format($total_kredit_2_rp*-1,2).')' : 0.00;
                
                    }  ?>
                    <tr>
                         <td colspan="6" class="text-left"></td>
                         <td colspan="2" class="text-right">TOTAL DEBET</td>
                         <td class="text-right"></td>
                         <td class="text-right">{{$total_debet_1_1_rp}}</td>
                         <td class="text-right">{{$total_debet_2_1_rp}}</td>
                         <td colspan="3" class="text-right"></td>
                     </tr>
                     <tr>
                         <td colspan="6" class="text-left"></td>
                         <td colspan="2" class="text-right">TOTAL KREDIT</td>
                         <td class="text-right"></td>
                         <td class="text-right">{{$total_kredit_1_1_rp}}</td>
                         <td class="text-right">{{$total_kredit_2_1_rp}}</td>
                         <td colspan="3" class="text-right"></td>
                     </tr>
                </tbody>
            </table>
        </div>
    </main>
    
    {{-- <script type='text/php'>
    if ( isset($pdf) ) { 
        $font = null;
        $size = 9;
        $y = $pdf->get_height() - 30;
        $x = $pdf->get_width() - 103;
        $pdf->page_text($x, $y, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, $size);
    }
    </script> --}}
  
</body>
</html>