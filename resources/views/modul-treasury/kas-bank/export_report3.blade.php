<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        RINCIAN KAS BANK PER CASH JUDEX
    </title>
</head>
<style media="screen">

table {
    width: 100%;
    border-collapse: collapse;
    padding-top:40%;
    border:1;
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
    border: 1px solid black; 

}
.row-td{
    vertical-align: top;
    padding: 5px;
    border-left: 1px solid black; 
    border-right: 1px solid black; 
    width: 11%;
    font: normal 12px Verdana, Arial, sans-serif;

}

th {
    padding: 7px;
    border: 1px solid black; 
}

thead { 
    border-left: 1px solid black; 
    border-right: 1px solid black; 
    display: table-header-group;
    font: normal 14px Verdana, Arial, sans-serif;
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
    width: 70%;
}

</style>
<body style="margin:0px">
    <main>
        <div class="row">
            <table >
                <thead>
                    <tr>
                        <th>JK</th>
                        <th>BLTH</th>
                        <th>ST</th>
                        <th>BAGIAN</th>
                        <th>SANPER</th>
                        <th>LP</th>
                        <th>WONO</th>
                        <th>CJ</th>
                        <th>NILAI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $a=0; ?>
                    @foreach($data_list as $data)
                    <?php $a++ ?>
                    <tr style="text-align:center;font-size: 8pt;">
                        <td>{{ $data->jk}}</td>
                        <td>{{ $data->bulan.''.$data->tahun }}</td>
                        <td>{{ $data->store}}</td>
                        <td>{{ $data->bagian}}</td>
                        <td>{{ $data->account}}</td>
                        <td>{{ $data->lokasi}}</td>
                        <td>{{ $data->pk}}</td>
                        <td>{{ $data->cj}}</td>
                        <td style="text-align:right;">{{ $data->totprice <= 0 ? '('.number_format($data->totprice*-1,0).')' : number_format($data->totprice,0)}}</td>
                    </tr>
                    <?php 
                        $lokasi[$a] = $data->lokasi;
                        $store[$a] = $data->store;
                        $cj[$a] = $data->cj;
                        $jk[$a] = $data->jk;
                        $bagian[$a] = $data->bagian;
                        $account[$a] = $data->account;
                        $pk[$a] = $data->pk;
                        $cr[$a] = $data->totprice;
                      ?>
                    @endforeach
                    <tr>
                    <?php
                        $cr_jk = array_sum($cr)+array_sum($jk)+array_sum($bagian)+array_sum($account)+array_sum($pk); 
                        $cr_lokasi = array_sum($cr)+array_sum($lokasi); 
                        $cr_store = array_sum($cr)+array_sum($store); 
                        $cr_cj = array_sum($cr)+array_sum($cj); 
                        $cr_total = array_sum($cr); 
                     ?>
                        <td colspan="8"></td>
                        <td style="font-size: 10pt;text-align:right;">{{ $cr_jk < 0 ? '('.number_format($cr_jk*-1,0).')'  : number_format($cr_jk,0)}}-{{ $cr_jk < 0 ? 'CR'  : ''}}</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td style="font-size: 10pt;text-align:right;">{{ $cr_lokasi < 0 ? '('.number_format($cr_lokasi*-1,0).')'  : number_format($cr_lokasi,0)}}-{{ $cr_lokasi < 0 ? 'CR'  : ''}}<span class="text-danger">**</span></td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td style="font-size: 10pt;text-align:right;">{{ $cr_store < 0 ? '('.number_format($cr_store*-1,0).')'  : number_format($cr_store,0)}}-{{ $cr_store < 0 ? 'CR'  : ''}}<span class="text-danger">**</span></td>
                    </tr>
                    <tr>
                        <td colspan="8" style="font-size: 10pt;text-align:right;">Total Per Cash Judex</td>
                        <td style="font-size: 10pt;text-align:right;">{{ $cr_cj < 0 ? '('.number_format($cr_cj*-1,0).')'  : number_format($cr_cj,0)}}-{{ $cr_cj < 0 ? 'CR'  : ''}}<span class="text-danger">***</span></td>
                    </tr>
                    <tr>
                        <td colspan="8" style="font-size: 10pt;text-align:right;">Total</td>
                        <td style="font-size: 10pt;text-align:right;">{{ $cr_total < 0 ? '('.number_format($cr_total*-1,0).')'  : number_format($cr_total,0)}}-{{ $cr_total < 0 ? 'CR'  : ''}}<span class="text-danger">**** </span> <span class="text-danger"> **</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>