<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        CETAK PROYEKSI CASHFLOW
    </title>
</head>
<style media="screen">

table {
    width: 100%;
    border-collapse: collapse;
    padding-top:30%;
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
.row-td{
    vertical-align: top;
    padding: 5px;
    border-left: 1px solid black; 
    border-right: 1px solid black; 
    width: 11%;
    /* font: normal 12px Verdana, Arial, sans-serif; */

}

th {
    padding: 7px;
    /* border: 1px solid black;  */
}

thead { 
    display: table-header-group;
    /* font: normal 14px Verdana, Arial, sans-serif; */
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
    width: 130px;
}

</style>
<body style="">
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
        $bul= strtoupper($array_bln[ltrim($request->bulan,0)]);
        $bln = strtoupper($bul).' '.$request->tahun;
    ?>
        <thead>
            <tr>
                <td style="text-align: left; padding-left:20px;">
                    <p>
                        <b>
                        PT PERTAMINA PEDEVE INDONESIA
                        <br>
                        PROYEKSI CASH FLOW BULAN {{$bln}} VS REALISASI 
                    </p>
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="100px">
                </td>
            </tr>
        </thead>
    </table>
    <main>
        <div class="row">
            <table >
                <thead>
                    <tr>
                        <th class="th-large text-left"></th>
                        <th class=" text-left th-small"></th>
                        <th class="th-small">PROYEKSI </th>
                        <th class="th-small">REALISASI</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $total_1_1=$total_1_2=$total_all_1_1=0;
                foreach ($data_list as $key=>$row) {
                    if (isset($data_list[$key+(-1)]['status'])) {
                        $status =  $data_list[$key+(-1)]['status'];
                    } else {
                        $status ='009';
                    }
                    if (isset($data_list[$key+1]['status'])) {
                        $status_1 =  $data_list[$key+1]['status'];
                    } else {
                        $status_1 = '009';
                    }
                    $data_02_1 = $row->nilai < 0 ? "(".number_format($row->nilai*-1,2) .")":number_format($row->nilai,2);
                    $data_02_2 = $row->totreal < 0 ? "(".number_format($row->totreal*-1,2) .")":number_format($row->totreal,2);
                    $data_01_1 = $row->nilai < 0 ? "(".number_format($row->nilai*-1,2) .")":number_format($row->nilai,2);
                    $data_01_2 = $row->totreal < 0 ? "(".number_format($row->totreal*-1,2) .")":number_format($row->totreal,2);
                    $total_1_1 += $row->nilai;
                    $total_1_2 += $row->totreal;
                    $total_all_1_1 = $total_1_1 < 0 ? "(".number_format($total_1_1*-1,2).")" : number_format($total_1_1,2);
                    $total_all_1_2 = $total_1_2 < 0 ? "(".number_format($total_1_2*-1,2).")" : number_format($total_1_2,2);

                        if($row->urutan =='01'){
                            $urutan = "Iuran MMD";
                        }else if ($row->urutan =='02'){
                            $urutan = "Bunga Deposito";
                        }else if ($row->urutan =='03'){
                            $urutan = "Bunga FRN";
                        }else if ($row->urutan =='04'){
                            $urutan = "Deviden";
                        }else if ($row->urutan =='05'){
                            $urutan = "Investasi Umum";
                        }else if ($row->urutan =='06'){
                            $urutan = "Investasi Khusus";
                        }else if ($row->urutan =='07'){
                            $urutan = "Lain-Lain";
                        }else if ($row->urutan =='08'){
                            $urutan = "Pembayaran MMD";
                        }else if ($row->urutan =='09'){
                            $urutan = "Pembiayaan Khusus PKPP";
                        }else if ($row->urutan =='10'){
                            $urutan = "Bagi Hasil";
                        }else if ($row->urutan =='11'){
                            $urutan = "Pembiayaan Umum PT AJM";
                        }else if ($row->urutan =='12'){
                            $urutan = "Pembiayaan Umum PT MTT";
                        }else if ($row->urutan =='13'){
                            $urutan = "Pembiayaan Umum PT PTC";
                        }else if ($row->urutan =='14'){
                            $urutan = "Pembiayaan Umum PT CTR";
                        }else if ($row->urutan =='15'){
                            $urutan = "Biaya Operasional";
                        }else if ($row->urutan =='16'){
                            $urutan = "Biaya Pajak";
                        }else if ($row->urutan =='17'){
                            $urutan = "Penyertaan Saham Langsung";
                        }else if ($row->urutan =='18'){
                            $urutan = "Lain-Lain";
                        }else{
                            $urutan = "-";
                        }
                    if ($row->status != $status) {
                        if ($row->status == '1') {
                            echo '<tr style="font-weight: bold;">
                                <td class="th-small text-left">PENERIMAAN</td>
                                <td class=" text-left"></td>
                                <td class="th-small"></td>
                                <td class="th-small"></td>
                            </tr>';
                        }else{
                            echo '<tr style="font-weight: bold;">
                                <td class="th-small text-left">PENGELUARAN</td>
                                <td class=" text-left"></td>
                                <td class="th-small"></td>
                                <td class="th-small"></td>
                            </tr>';
                        }
                    }
                    
                    if ($row->status == '1') {
                        
                        echo '<tr>
                            <td class="th-small text-left" style="padding-left:5%;">- '.$urutan.'</td>
                            <td class="text-right">Rp. </td>
                            <td class="th-small text-right">'.$data_01_1.'</td>
                            <td class="th-small text-right">'.$data_01_2.'</td>
                        </tr>';
                    }else{
                        
                        echo '<tr>
                            <td class="th-small text-left"  style="padding-left:5%;">- '.$urutan.'</td>
                            <td class=" text-right">Rp. </td>
                            <td class="th-small text-right">'.$data_02_1.'</td>
                            <td class="th-small text-right">'.$data_02_2.'</td>
                        </tr>';
                    }
                    if ($row->status != $status_1) {
                        foreach (DB::table('v_cashflowpercjreport')->select(DB::raw("status,SUM(nilai) as nilai,SUM(totreal) as totreal"))->where('tahun', $row->tahun)->where('bulan', $row->bulan)->where('status', $row->status)->groupBy('status')->orderBy('status', 'asc')->get() as $data) {
                            $jumlah_1 = $data->nilai < 0 ? "(".number_format($data->nilai*-1,2) .")":number_format($data->nilai,2);
                            $jumlah_2 = $data->totreal < 0 ? "(".number_format($data->totreal*-1,2) .")":number_format($data->totreal,2);
                            echo '<tr style="font-weight: bold;">
                                <td class="th-small text-center">JUMLAH</td>
                                <td class=" text-left"></td>
                                <td class="th-small text-right">'.$jumlah_1.'</td>
                                <td class="th-small text-right">'.$jumlah_2.'</td>
                            </tr>';
                            
                        }
                    }
                } 
                foreach ($data_total as $data) {
                    $total_jumlah_1 = $data->status_1 < 0 ? "(".number_format($data->status_1*-1,2) .")":number_format($data->status_1,2);
                    $total_jumlah_2 = $data->totreal_1 < 0 ? "(".number_format($data->totreal_1*-1,2) .")":number_format($data->totreal_1,2);
                    
                }
                echo '<tr style="font-weight: bold;">
                    <td class="th-small text-center">Selisih +/- (Penyediaan Dana)</td>
                    <td class=" text-left"></td>
                    <td class="th-small text-right">'.$total_jumlah_1.'</td>
                    <td class="th-small text-right">'.$total_jumlah_2.'</td>
                </tr>';
                
                ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>