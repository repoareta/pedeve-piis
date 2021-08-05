<!DOCTYPE html>
<html lang="en">
<head>
    <title>
       (D-5)
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
            <table class="table tree" style="font: normal 10px Verdana, Arial, sans-serif;">
                <thead>
                    <tr>
                        <th rowspan="2" class="th-small text-center">SANDI <br> PERKIRA</th>
                        <th rowspan="2" class="th-small text-left">CI</th>
                        <th rowspan="2" class="th-small">JB</th>
                        <th rowspan="2" class="th-small">LP</th>
                        <th rowspan="2" class="th-small"></th>
                        <th colspan="2" class="th-small">KUMULATIV - BULAN LALU</th>
                        <th colspan="2" class="th-medium">TRANSAKSI - BULAN INI</th>
                        <th colspan="2" class="th-medium">KUMULATIV - BULAN INI</th>
                    </tr>
                    <tr>
                        <th class="th-small">RUPIAH</th>
                        <th class="th-medium">DOLAR</th>
                        <th class="th-small">RUPIAH</th>
                        <th class="th-medium">DOLAR</th>
                        <th class="th-small">RUPIAH</th>
                        <th class="th-medium">DOLAR</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no=0;
                // TOTAL CI
                $total_ci_1_rp = $total_ci_1_dl = $total_ci_2_rp = $total_ci_2_dl = $total_ci_3_rp = $total_ci_3_dl  = 0;
                //TOTAL SANDI 1
                $total_san_1_rp = $total_san_1_dl = $total_san_2_rp = $total_san_2_dl = $total_san_3_rp = $total_san_3_dl  = 0;
                //TOTAL SANDI 2
                $total_san_1_2_rp = $total_san_1_2_dl = $total_san_2_2_rp = $total_san_2_2_dl = $total_san_3_2_rp = $total_san_3_2_dl  = 0;
                
                //TOTAL MAIN 1
                $total_main_1_rp = $total_main_1_dl = $total_main_2_rp = $total_main_2_dl = $total_main_3_rp = $total_main_3_dl  = 0;
                //TOTAL MAIN 2
                $total_main_1_2_rp = $total_main_1_2_dl = $total_main_2_2_rp = $total_main_2_2_dl = $total_main_3_2_rp = $total_main_3_2_dl  = 0;
                
                //TOTAL CLASS 1
                $total_class_1_rp = $total_class_1_dl = $total_class_2_rp = $total_class_2_dl = $total_class_3_rp = $total_class_3_dl  = 0;
                //TOTAL CLASS 2
                $total_class_1_2_rp = $total_class_1_2_dl = $total_class_2_2_rp = $total_class_2_2_dl = $total_class_3_2_rp = $total_class_3_2_dl  = 0;
                
                //TOTAL SALDO
                $total_saldo_1_rp = $total_saldo_1_dl = $total_saldo_2_rp = $total_saldo_2_dl = $total_saldo_3_rp = $total_saldo_3_dl  = 0;
                //TOTAL SALDO 2
                $total_saldo_1_2_rp = $total_saldo_1_2_dl = $total_saldo_2_2_rp = $total_saldo_2_2_dl = $total_saldo_3_2_rp = $total_saldo_3_2_dl  = 0;
               
                    foreach($data_list as $key=>$row)
                    {
                        //TOTAL CI
                        if ($row->mu == 1) {
                            $total_ci_1_rp += $row['last_rp'];
                            $total_ci_2_rp += $row['cur_rp'];
                            $total_ci_3_rp += $row['cum_rp'];
                        }
                        if ($row->mu == 2) {
                            $total_ci_1_dl += $row['last_dl'];
                            $total_ci_2_dl += $row['cur_dl'];
                            $total_ci_3_dl += $row['cum_dl'];
                        }
                        //TOTAL SANDI 1
                        if ($row->mu == 1) {
                            $total_san_1_rp += $row['last_rp'];
                            $total_san_2_rp += $row['cur_rp'];
                            $total_san_3_rp += $row['cum_rp'];
                        }
                        //TOTAL SANDI 2
                        if ($row->mu == 2) {
                            $total_san_1_dl += $row['last_dl'];
                            $total_san_2_dl += $row['cur_dl'];
                            $total_san_3_dl += $row['cum_dl'];
                            $total_san_1_2_rp += $row['last_rp'];
                            $total_san_1_2_dl += $row['last_dl'];
                            $total_san_2_2_rp += $row['cur_rp'];
                            $total_san_2_2_dl += $row['cur_dl'];
                            $total_san_3_2_rp += $row['cum_rp'];
                            $total_san_3_2_dl += $row['cum_dl'];
                        }

                        //TOTAL MAIN 1
                        if ($row->mu == 1) {
                            $total_main_1_rp += $row['last_rp'];
                            $total_main_2_rp += $row['cur_rp'];
                            $total_main_3_rp += $row['cum_rp'];
                        }
                        //TOTAL MAIN 2
                        if ($row->mu == 2) {
                            $total_main_1_dl += $row['last_dl'];
                            $total_main_2_dl += $row['cur_dl'];
                            $total_main_3_dl += $row['cum_dl'];
                            $total_main_1_2_rp += $row['last_rp'];
                            $total_main_1_2_dl += $row['last_dl'];
                            $total_main_2_2_rp += $row['cur_rp'];
                            $total_main_2_2_dl += $row['cur_dl'];
                            $total_main_3_2_rp += $row['cum_rp'];
                            $total_main_3_2_dl += $row['cum_dl'];
                        }

                        //TOTAL CLASS 1
                        if ($row->mu == 1) {
                            $total_class_1_rp += $row['last_rp'];
                            $total_class_2_rp += $row['cur_rp'];
                            $total_class_3_rp += $row['cum_rp'];
                        }
                        //TOTAL CLASS 2
                        if ($row->mu == 2) {
                            $total_class_1_dl += $row['last_dl'];
                            $total_class_2_dl += $row['cur_dl'];
                            $total_class_3_dl += $row['cum_dl'];
                            $total_class_1_2_rp += $row['last_rp'];
                            $total_class_1_2_dl += $row['last_dl'];
                            $total_class_2_2_rp += $row['cur_rp'];
                            $total_class_2_2_dl += $row['cur_dl'];
                            $total_class_3_2_rp += $row['cum_rp'];
                            $total_class_3_2_dl += $row['cum_dl'];
                        }

                        //TOTAL SALDO 1
                        if ($row->mu == 1) {
                            $total_saldo_1_rp += $row['last_rp'];
                            $total_saldo_2_rp += $row['cur_rp'];
                            $total_saldo_3_rp += $row['cum_rp'];
                        }
                        //TOTAL SALDO 2
                        if ($row->mu == 2) {
                            $total_saldo_1_dl += $row['last_dl'];
                            $total_saldo_2_dl += $row['cur_dl'];
                            $total_saldo_3_dl += $row['cum_dl'];
                            $total_saldo_1_2_rp += $row['last_rp'];
                            $total_saldo_1_2_dl += $row['last_dl'];
                            $total_saldo_2_2_rp += $row['cur_rp'];
                            $total_saldo_2_2_dl += $row['cur_dl'];
                            $total_saldo_3_2_rp += $row['cum_rp'];
                            $total_saldo_3_2_dl += $row['cum_dl'];
                        }


                        //TOTAL SANDI 3
                        $total_sub_1_rp = $total_san_1_rp + $total_san_1_2_rp;
                        $total_sub_2_rp = $total_san_2_rp + $total_san_2_2_rp;
                        $total_sub_3_rp = $total_san_3_rp + $total_san_3_2_rp;
                        $sub_total_san_1_3_rp =$total_sub_1_rp < 0 ? '('.number_format($total_sub_1_rp*-1,2) .')' : number_format($total_sub_1_rp,2);
                        $sub_total_san_2_3_rp =$total_sub_2_rp < 0 ? '('.number_format($total_sub_2_rp*-1,2) .')' : number_format($total_sub_2_rp,2);
                        $sub_total_san_3_3_rp =$total_sub_3_rp < 0 ? '('.number_format($total_sub_3_rp*-1,2) .')' : number_format($total_sub_3_rp,2);
                        
                        //TOTAL MAIN 3
                        $total_sub_main_1_rp = $total_main_1_rp + $total_main_1_2_rp;
                        $total_sub_main_2_rp = $total_main_2_rp + $total_main_2_2_rp;
                        $total_sub_main_3_rp = $total_main_3_rp + $total_main_3_2_rp;
                        $sub_total_main_1_3_rp =$total_sub_main_1_rp < 0 ? '('.number_format($total_sub_main_1_rp*-1,2) .')' : number_format($total_sub_main_1_rp,2);
                        $sub_total_main_2_3_rp =$total_sub_main_2_rp < 0 ? '('.number_format($total_sub_main_2_rp*-1,2) .')' : number_format($total_sub_main_2_rp,2);
                        $sub_total_main_3_3_rp =$total_sub_main_3_rp < 0 ? '('.number_format($total_sub_main_3_rp*-1,2) .')' : number_format($total_sub_main_3_rp,2);
                        
                        //TOTAL CLASS 3
                        $total_sub_class_1_rp = $total_class_1_rp + $total_class_1_2_rp;
                        $total_sub_class_2_rp = $total_class_2_rp + $total_class_2_2_rp;
                        $total_sub_class_3_rp = $total_class_3_rp + $total_class_3_2_rp;
                        $sub_total_class_1_3_rp =$total_sub_class_1_rp < 0 ? '('.number_format($total_sub_class_1_rp*-1,2) .')' : number_format($total_sub_class_1_rp,2);
                        $sub_total_class_2_3_rp =$total_sub_class_2_rp < 0 ? '('.number_format($total_sub_class_2_rp*-1,2) .')' : number_format($total_sub_class_2_rp,2);
                        $sub_total_class_3_3_rp =$total_sub_class_3_rp < 0 ? '('.number_format($total_sub_class_3_rp*-1,2) .')' : number_format($total_sub_class_3_rp,2);
                        
                        //TOTAL SALDO 3
                        $total_sub_saldo_1_rp = $total_saldo_1_rp + $total_saldo_1_2_rp;
                        $total_sub_saldo_2_rp = $total_saldo_2_rp + $total_saldo_2_2_rp;
                        $total_sub_saldo_3_rp = $total_saldo_3_rp + $total_saldo_3_2_rp;
                        $sub_total_saldo_1_3_rp =$total_sub_saldo_1_rp < 0 ? '('.number_format($total_sub_saldo_1_rp*-1,2) .')' : number_format($total_sub_saldo_1_rp,2);
                        $sub_total_saldo_2_3_rp =$total_sub_saldo_2_rp < 0 ? '('.number_format($total_sub_saldo_2_rp*-1,2) .')' : number_format($total_sub_saldo_2_rp,2);
                        $sub_total_saldo_3_3_rp =$total_sub_saldo_3_rp < 0 ? '('.number_format($total_sub_saldo_3_rp*-1,2) .')' : number_format($total_sub_saldo_3_rp,2);
                        $sub_total_saldo_4_3_rp =$total_saldo_1_dl < 0 ? '('.number_format($total_saldo_1_dl*-1,2) .')' : number_format($total_saldo_1_dl,2);
                        $sub_total_saldo_5_3_rp =$total_saldo_2_dl < 0 ? '('.number_format($total_saldo_2_dl*-1,2) .')' : number_format($total_saldo_2_dl,2);
                        $sub_total_saldo_6_3_rp =$total_saldo_3_dl < 0 ? '('.number_format($total_saldo_3_dl*-1,2) .')' : number_format($total_saldo_3_dl,2);

                        //KBL
                            //RP
                        if($row->mu == 1){
                            if($row->mu == 1){
                                $kbl_1_rp = $row->last_rp;
                            } else {
                                $kbl_1_rp = 0;
                            }
                            $kbl_rp = $kbl_1_rp < 0 ? '('.number_format($kbl_1_rp*-1,2) .')' : number_format($kbl_1_rp,2) ;
                        } else {
                            if($row->mu == 2){
                                $kbl_1_rp = $row->last_rp;
                            } else {
                                $kbl_1_rp = 0;
                            }                            
                            $kbl_rp = $kbl_1_rp < 0 ? '('.number_format($kbl_1_rp*-1,2) .')' : number_format($kbl_1_rp,2) ;
                        }
                        //KBL
                        //DL
                        $kbl_last = $row->mu == 2 ? $row->last_dl : 0 ;
                        if($kbl_last < 0){
                            if($row->mu == 2){
                                $kbl_1_dl = $row->last_dl;
                            } else {
                                $kbl_1_dl = 0;
                            }
                            $kbl_dl = $kbl_1_dl < 0 ? '('.number_format($kbl_1_dl*-1,2) .')' : number_format($kbl_1_dl,2) ;
                        } else {
                            if($row->mu == 2){
                                $kbl_1_dl = $row->last_dl;
                            } else {
                                $kbl_1_dl = 0;
                            }                            
                            $kbl_dl = $kbl_1_dl < 0 ? '('.number_format($kbl_1_dl*-1,2) .')' : number_format($kbl_1_dl,2) ;
                        }
                        
                        //TBI
                            //RP
                        if($row->mu == 1){
                            if($row->mu == 1){
                                $tbi_1_rp = $row->cur_rp;
                            } else {
                                $tbi_1_rp = 0;
                            }
                            $tbi_rp = $tbi_1_rp < 0 ? '('.number_format($tbi_1_rp*-1,2) .')' : number_format($tbi_1_rp,2) ;
                        } else {
                            if($row->mu == 2){
                                $tbi_1_rp = $row->cur_rp;
                            } else {
                                $tbi_1_rp = 0;
                            }                            
                            $tbi_rp = $tbi_1_rp < 0 ? '('.number_format($tbi_1_rp*-1,2) .')' : number_format($tbi_1_rp,2) ;
                        }
                        
                        //TBI
                            //DL
                        $tbi_cur = $row->mu == 2 ? $row->cur_dl : 0 ;
                        if($tbi_cur < 0){
                            if($row->mu == 2){
                                $tbi_1_dl = $row->cur_dl;
                            } else {
                                $tbi_1_dl = 0;
                            }
                            $tbi_dl = $tbi_1_dl < 0 ? '('.number_format($tbi_1_dl*-1,2) .')' : number_format($tbi_1_dl,2) ;
                        } else {
                            if($row->mu == 2){
                                $tbi_1_dl = $row->cur_dl;
                            } else {
                                $tbi_1_dl = 0;
                            }                            
                            $tbi_dl = $tbi_1_dl < 0 ? '('.number_format($tbi_1_dl*-1,2) .')' : number_format($tbi_1_dl,2) ;
                        }

                        //KBI
                            //RP
                        if($row->mu == 1){
                            if($row->mu == 1){
                                $kbi_1_rp = $row->cum_rp;
                            } else {
                                $kbi_1_rp = 0;
                            }
                            $kbi_rp = $kbi_1_rp < 0 ? '('.number_format($kbi_1_rp*-1,2) .')' : number_format($kbi_1_rp,2) ;
                        } else {
                            if($row->mu == 2){
                                $kbi_1_rp = $row->cum_rp;
                            } else {
                                $kbi_1_rp = 0;
                            }                            
                            $kbi_rp = $kbi_1_rp < 0 ? '('.number_format($kbi_1_rp*-1,2) .')' : number_format($kbi_1_rp,2) ;
                        }

                        //TBI
                            //DL
                        $kbi_cum = $row->mu == 2 ? $row->cum_dl : 0 ;
                        if($kbi_cum < 0){
                            if($row->mu == 2){
                                $kbi_1_dl = $row->cum_dl;
                            } else {
                                $kbi_1_dl = 0;
                            }
                            $kbi_dl = $kbi_1_dl < 0 ? '('.number_format($kbi_1_dl*-1,2) .')' : number_format($kbi_1_dl,2) ;
                        } else {
                            if($row->mu == 2){
                                $kbi_1_dl = $row->cum_dl;
                            } else {
                                $kbi_1_dl = 0;
                            }                            
                            $kbi_dl = $kbi_1_dl < 0 ? '('.number_format($kbi_1_dl*-1,2) .')' : number_format($kbi_1_dl,2) ;
                        }

                        echo '<tr>
                                    <td class="th-small text-center">'.$row->sandi.'</td>
                                    <td class="th-small text-left">'.$row->mu.'</td>
                                    <td class="th-small text-right">'.$row->jb.'</td>
                                    <td class="th-medium text-center">'.$row->lapangan.'</td>
                                    <td class="th-medium text-center"></td>
                                    <td class="th-medium text-right">'.$kbl_rp.'</td>
                                    <td class="th-medium text-right">'.$kbl_dl.'</td>
                                    <td class="th-medium text-right">'.$tbi_rp.'</td>
                                    <td class="th-medium text-right">'.$tbi_dl.'</td>
                                    <td class="th-medium text-right">'.$kbi_rp.'</td>
                                    <td class="th-medium text-right">'.$kbi_dl.'</td>
                                </tr>';
                        // SUB TOTAL per sandi
                        if(isset($data_list[$key+1]['sandi']))
                        {
                            $sandi =  $data_list[$key+1]['sandi'];
                            $san =  $data_list[$key]['sandi'];
                            $sanmain =  substr($data_list[$key+1]['sandi'],0,3);
                            $sanclass =  substr($data_list[$key+1]['sandi'],0,1);
                            $mu =  $data_list[$key+1]['mu'];
                            $lapangan =  $data_list[$key+1]['lapangan'];
                        } else {
                            $sandi =  substr($data_list[$key]['sandi'],0,2);
                            $san =  $data_list[$key]['sandi'];
                            $mu =  $data_list[$key]['mu']*2;
                            $lapangan =  substr($data_list[$key]['lapangan'],0,1);
                            $sanmain =  substr($data_list[$key]['sandi'],0,4);
                            $sanclass =  substr($data_list[$key]['sandi'],0,2);
                        }

                        
                        if (($sandi != $row->sandi or $mu != $row->mu) or $row->lapangan != $lapangan) {
                            //TOTAL CI
                             $sub_total_1_rp =$total_ci_1_rp < 0 ? '('.number_format($total_ci_1_rp*-1,2) .')' : number_format($total_ci_1_rp,2);
                             $sub_total_1_dl =$total_ci_1_dl < 0 ? '('.number_format($total_ci_1_dl*-1,2) .')' : number_format($total_ci_1_dl,2);
                             $sub_total_2_rp =$total_ci_2_rp < 0 ? '('.number_format($total_ci_2_rp*-1,2) .')' : number_format($total_ci_2_rp,2);
                             $sub_total_2_dl =$total_ci_2_dl < 0 ? '('.number_format($total_ci_2_dl*-1,2) .')' : number_format($total_ci_2_dl,2);
                             $sub_total_3_rp =$total_ci_3_rp < 0 ? '('.number_format($total_ci_3_rp*-1,2) .')' : number_format($total_ci_3_rp,2);
                             $sub_total_3_dl =$total_ci_3_dl < 0 ? '('.number_format($total_ci_3_dl*-1,2) .')' : number_format($total_ci_3_dl,2);
                           
                            echo '<tr>
                                    <td width="10%"></td>
                                    <td colspan="4" class="th-medium text-left">TOTAL CI : '.$row->mu.'</td>
                                    <td class="th-medium text-right">'.$sub_total_1_rp.'</td>
                                    <td class="th-medium text-right">'.$sub_total_1_dl.'</td>
                                    <td class="th-medium text-right">'.$sub_total_2_rp.'</td>
                                    <td class="th-medium text-right">'.$sub_total_2_dl.'</td>
                                    <td class="th-medium text-right">'.$sub_total_3_rp.'</td>
                                    <td class="th-medium text-right">'.$sub_total_3_dl.'</td>
                                    </tr>';
                                    $total_ci_1_rp=0;
                                    $total_ci_1_dl=0;
                                    $total_ci_2_rp=0;
                                    $total_ci_2_dl=0;
                                    $total_ci_3_rp=0;
                                    $total_ci_3_dl=0;
                                }
                        if ($sandi != $row->sandi) {
                             //TOTAL SANDI 1
                             $sub_total_san_1_rp =$total_san_1_rp < 0 ? '('.number_format($total_san_1_rp*-1,2) .')' : number_format($total_san_1_rp,2);
                             $sub_total_san_1_dl =$total_san_1_dl < 0 ? '('.number_format($total_san_1_dl*-1,2) .')' : number_format($total_san_1_dl,2);
                             $sub_total_san_2_rp =$total_san_2_rp < 0 ? '('.number_format($total_san_2_rp*-1,2) .')' : number_format($total_san_2_rp,2);
                             $sub_total_san_2_dl =$total_san_2_dl < 0 ? '('.number_format($total_san_2_dl*-1,2) .')' : number_format($total_san_2_dl,2);
                             $sub_total_san_3_rp =$total_san_3_rp < 0 ? '('.number_format($total_san_3_rp*-1,2) .')' : number_format($total_san_3_rp,2);
                             $sub_total_san_3_dl =$total_san_3_dl < 0 ? '('.number_format($total_san_3_dl*-1,2) .')' : number_format($total_san_3_dl,2);
                            echo '<tr>
                                    <td width="10%"></td>
                                    <td colspan="3" class="th-medium text-left">TOTAL SP : '.$row->sandi.'</td>
                                    <td class="th-medium text-left">(1)</td>
                                    <td class="th-medium text-right">'.$sub_total_san_1_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                    <td class="th-medium text-right">'.$sub_total_san_2_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                    <td class="th-medium text-right">'.$sub_total_san_3_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                </tr>';
                                $total_san_1_rp=0;
                                $total_san_2_rp=0;
                                $total_san_3_rp=0;
                                
                                // 1 2 3 
                                //TOTAL SANDI 2
                                $sub_total_san_1_2_rp =$total_san_1_2_rp < 0 ? '('.number_format($total_san_1_2_rp*-1,2) .')' : number_format($total_san_1_2_rp,2);
                                $sub_total_san_2_2_rp =$total_san_2_2_rp < 0 ? '('.number_format($total_san_2_2_rp*-1,2) .')' : number_format($total_san_2_2_rp,2);
                                $sub_total_san_3_2_rp =$total_san_3_2_rp < 0 ? '('.number_format($total_san_3_2_rp*-1,2) .')' : number_format($total_san_3_2_rp,2);
                                echo '<tr>
                                    <td width="10%"></td>
                                    <td colspan="3" class="th-medium text-left"></td>
                                    <td class="th-medium text-left">(2)</td>
                                    <td class="th-small text-right">'.$sub_total_san_1_2_rp.'</td>
                                    <td rowspan="2" class="th-large text-right">'.$sub_total_san_1_dl.'</td>
                                    <td class="th-large text-right">'.$sub_total_san_2_2_rp.'</td>
                                    <td rowspan="2" class="th-medium text-right">'.$sub_total_san_2_dl.'</td>
                                    <td class="th-large text-right">'.$sub_total_san_3_2_rp.'</td>
                                    <td rowspan="2" class="th-large text-right">'.$sub_total_san_3_dl.'</td>
                                    </tr>';
                                $total_san_1_2_dl=0;
                                $total_san_2_2_dl=0;
                                $total_san_3_2_dl=0;

                                
                                
                                echo '<tr>
                                        <td width="10%"></td>
                                        <td colspan="3" class="th-medium text-left"></td>
                                        <td class="th-medium text-left">(#)</td>
                                        <td class="th-small text-right">'.$sub_total_san_1_3_rp.'</td>
                                        <td class="th-small text-right">'.$sub_total_san_2_3_rp.'</td>
                                        <td class="th-small text-right">'.$sub_total_san_3_3_rp.'</td>
                                    </tr>';
                        }

                        //main
                        if ($sanmain != substr($row->sandi, 0, 3)) {
                             //TOTAL MAIN 1
                                $sub_total_main_1_rp =$total_main_1_rp < 0 ? '('.number_format($total_main_1_rp*-1,2) .')' : number_format($total_main_1_rp,2);
                                $sub_total_main_1_dl =$total_main_1_dl < 0 ? '('.number_format($total_main_1_dl*-1,2) .')' : number_format($total_main_1_dl,2);
                                $sub_total_main_2_rp =$total_main_2_rp < 0 ? '('.number_format($total_main_2_rp*-1,2) .')' : number_format($total_main_2_rp,2);
                                $sub_total_main_2_dl =$total_main_2_dl < 0 ? '('.number_format($total_main_2_dl*-1,2) .')' : number_format($total_main_2_dl,2);
                                $sub_total_main_3_rp =$total_main_3_rp < 0 ? '('.number_format($total_main_3_rp*-1,2) .')' : number_format($total_main_3_rp,2);
                                $sub_total_main_3_dl =$total_main_3_dl < 0 ? '('.number_format($total_main_3_dl*-1,2) .')' : number_format($total_main_3_dl,2);
                                echo '<tr>
                                        <td width="10%"></td>
                                        <td colspan="3" class="th-medium text-left">TOTAL MAIN : '.substr($row->sandi, 0, 3).'</td>
                                        <td class="th-medium text-left">(1)</td>
                                        <td class="th-medium text-right">'.$sub_total_main_1_rp.'</td>
                                        <td class="th-medium text-right"></td>
                                        <td class="th-medium text-right">'.$sub_total_main_2_rp.'</td>
                                        <td class="th-medium text-right"></td>
                                        <td class="th-medium text-right">'.$sub_total_main_3_rp.'</td>
                                        <td class="th-medium text-right"></td>
                                    </tr>';
                                    $total_main_1_rp=0;
                                    $total_main_2_rp=0;
                                    $total_main_3_rp=0;
                                    
                                    // 1 2 3 
                                    //TOTAL MAIN 2
                                    $sub_total_main_1_2_rp =$total_main_1_2_rp < 0 ? '('.number_format($total_main_1_2_rp*-1,2) .')' : number_format($total_main_1_2_rp,2);
                                    $sub_total_main_2_2_rp =$total_main_2_2_rp < 0 ? '('.number_format($total_main_2_2_rp*-1,2) .')' : number_format($total_main_2_2_rp,2);
                                    $sub_total_main_3_2_rp =$total_main_3_2_rp < 0 ? '('.number_format($total_main_3_2_rp*-1,2) .')' : number_format($total_main_3_2_rp,2);
                                    echo '<tr>
                                        <td width="10%"></td>
                                        <td colspan="3" class="th-medium text-left"></td>
                                        <td class="th-medium text-left">(2)</td>
                                        <td class="th-small text-right">'.$sub_total_main_1_2_rp.'</td>
                                        <td rowspan="2" class="th-large text-right">'.$sub_total_main_1_dl.'</td>
                                        <td class="th-large text-right">'.$sub_total_main_2_2_rp.'</td>
                                        <td rowspan="2" class="th-medium text-right">'.$sub_total_main_2_dl.'</td>
                                        <td class="th-large text-right">'.$sub_total_main_3_2_rp.'</td>
                                        <td rowspan="2" class="th-large text-right">'.$sub_total_main_3_dl.'</td>
                                        </tr>';
                                    $total_main_1_2_dl=0;
                                    $total_main_2_2_dl=0;
                                    $total_main_3_2_dl=0;

                                    
                                    
                                    echo '<tr>
                                            <td width="10%"></td>
                                            <td colspan="3" class="th-medium text-left"></td>
                                            <td class="th-medium text-left">(#)</td>
                                            <td class="th-small text-right">'.$sub_total_main_1_3_rp.'</td>
                                            <td class="th-small text-right">'.$sub_total_main_2_3_rp.'</td>
                                            <td class="th-small text-right">'.$sub_total_main_3_3_rp.'</td>
                                        </tr>';
                        }

                            //class
                        if ($sanclass != substr($row->sandi, 0, 1)) {
                            //TOTAL CLASS 1
                            $sub_total_class_1_rp =$total_class_1_rp < 0 ? '('.number_format($total_class_1_rp*-1,2) .')' : number_format($total_class_1_rp,2);
                            $sub_total_class_1_dl =$total_class_1_dl < 0 ? '('.number_format($total_class_1_dl*-1,2) .')' : number_format($total_class_1_dl,2);
                            $sub_total_class_2_rp =$total_class_2_rp < 0 ? '('.number_format($total_class_2_rp*-1,2) .')' : number_format($total_class_2_rp,2);
                            $sub_total_class_2_dl =$total_class_2_dl < 0 ? '('.number_format($total_class_2_dl*-1,2) .')' : number_format($total_class_2_dl,2);
                            $sub_total_class_3_rp =$total_class_3_rp < 0 ? '('.number_format($total_class_3_rp*-1,2) .')' : number_format($total_class_3_rp,2);
                            $sub_total_class_3_dl =$total_class_3_dl < 0 ? '('.number_format($total_class_3_dl*-1,2) .')' : number_format($total_class_3_dl,2);
                            echo '<tr>
                                    <td width="10%"></td>
                                    <td colspan="3" class="th-medium text-left">TOTAL CLASS : '.substr($row->sandi, 0, 1).'</td>
                                    <td class="th-medium text-left">(1)</td>
                                    <td class="th-medium text-right">'.$sub_total_class_1_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                    <td class="th-medium text-right">'.$sub_total_class_2_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                    <td class="th-medium text-right">'.$sub_total_class_3_rp.'</td>
                                    <td class="th-medium text-right"></td>
                                </tr>';
                                $total_class_1_rp=0;
                                $total_class_2_rp=0;
                                $total_class_3_rp=0;
                                
                                // 1 2 3 
                                //TOTAL CLASS 2
                                $sub_total_class_1_2_rp =$total_class_1_2_rp < 0 ? '('.number_format($total_class_1_2_rp*-1,2) .')' : number_format($total_class_1_2_rp,2);
                                $sub_total_class_2_2_rp =$total_class_2_2_rp < 0 ? '('.number_format($total_class_2_2_rp*-1,2) .')' : number_format($total_class_2_2_rp,2);
                                $sub_total_class_3_2_rp =$total_class_3_2_rp < 0 ? '('.number_format($total_class_3_2_rp*-1,2) .')' : number_format($total_class_3_2_rp,2);
                                echo '<tr>
                                    <td width="10%"></td>
                                    <td colspan="3" class="th-medium text-left"></td>
                                    <td class="th-medium text-left">(2)</td>
                                    <td class="th-small text-right">'.$sub_total_class_1_2_rp.'</td>
                                    <td rowspan="2" class="th-large text-right">'.$sub_total_class_1_dl.'</td>
                                    <td class="th-large text-right">'.$sub_total_class_2_2_rp.'</td>
                                    <td rowspan="2" class="th-medium text-right">'.$sub_total_class_2_dl.'</td>
                                    <td class="th-large text-right">'.$sub_total_class_3_2_rp.'</td>
                                    <td rowspan="2" class="th-large text-right">'.$sub_total_class_3_dl.'</td>
                                    </tr>';
                                $total_class_1_2_dl=0;
                                $total_class_2_2_dl=0;
                                $total_class_3_2_dl=0;

                                
                                
                                echo '<tr>
                                        <td width="10%"></td>
                                        <td colspan="3" class="th-medium text-left"></td>
                                        <td class="th-medium text-left">(#)</td>
                                        <td class="th-small text-right">'.$sub_total_class_1_3_rp.'</td>
                                        <td class="th-small text-right">'.$sub_total_class_2_3_rp.'</td>
                                        <td class="th-small text-right">'.$sub_total_class_3_3_rp.'</td>
                                    </tr>';
                        }
                    }
                ?>
                </tbody>
                <thead>
                    <tr>
                    
                        <th colspan="5" class="th-small text-center">SALDO</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_1_3_rp}}</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_4_3_rp}}</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_2_3_rp}}</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_5_3_rp}}</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_3_3_rp}}</th>
                        <th class="th-medium text-right">{{ $sub_total_saldo_6_3_rp}}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>
    
    {{-- <script type='text/php'>
    if ( isset($pdf) ) { 
        $font = null;
        $size = 2;
        $y = $pdf->get_height() - 30;
        $x = $pdf->get_width() - 103;
        $pdf->page_text($x, $y, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, $size);
    }
    </script> --}}
  
</body>
</html>