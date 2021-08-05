<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Report Cash Judex Periode
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
                        <th class="th-small">No. Kas </th>
                        <th class="th-small">Voucher</th>
                        <th class="th-small">Thn/Bln  </th>
                        <th class="th-small">Sandi </th>
                        <th class="th-small">Lokasi</th>
                        <th class="th-small">CJ</th>
                        <th class="th-large">Keterangan </th>
                        <th class="th-small">Jumlah </th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=0; ?>
                @foreach($data_list as $data)
                <?php $no++; 
                    $total[$no] = $data->totprice;
                ?>
                    <tr>
                        <td class="row-td text-left">{{ $data->docno}}</td>
                        <td class="row-td text-center">{{ $data->voucher }}</td>
                        <td class="row-td text-center">{{ $data->thnbln}}</td>
                        <td class="row-td text-center">{{ $data->account}}</td>
                        <td class="row-td text-center">{{ $data->lokasi}}</td>
                        <td class="row-td text-center">{{ $data->cj}}</td>
                        <td class="row-td text-left">{{ $data->keterangan}}</td>
                        <td class="row-td text-right">{{ $data->totprice < 0 ? "(".number_format($data->totprice*-1,2).")" : number_format($data->totprice,2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                    <tr style="font-weight: bold">
                        <td colspan="7" class="text-right">TOTAL</td>
                        <td class="text-right">{{array_sum($total) < 0 ? "(".number_format(array_sum($total)*-1,2).")" : number_format(array_sum($total),2) }}</td>
                    </tr>
            </table>
        </div>
    </main>
</body>
</html>