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
            <table class="table tree" border="1">
                <thead>
                    <tr>
                        <th class="th-small text-center">NO</th>
                        <th class="th-large text-left">NAMA BANK</th>
                        <th class="th-small text-center">ASAL<br>DANA</th>
                        <th class="th-small text-center">NOMINAL<br>EKIVALEN</th>
                        <th class="th-small text-center">TANGGAL<br>DEPOSITO</th>
                        <th class="th-small text-center">TGL<br>JTH TEMPO</th>
                        <th class="th-medium text-center">HARI<br>BUNGA</th>
                        <th class="th-medium text-center">BUNGA<br>%/THN</th>
                        <th class="th-medium text-center">BUNGA<br>per BLN</th>
                        <th class="th-medium text-center">PPH20%<br>per BLN</th>
                        <th class="th-medium text-center">BUNGA NET<br>per BLN</th>
                        <th class="th-medium text-center">ACCRD<br>HARI</th>
                        <th class="th-small text-left text-center">ACCRUED<br>NOMINAL</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data_list as $key=>$row)
                    <tr>
                        <td class="text-center">{{ $key+1}}</td>
                        <td>{{ $row->descacct}}</td>
                        <td class="text-center">{{ $row->asal}}</td>
                        <td class="text-right">
                           <?php
                            if($row->ci == 2){
                                echo number_format($request->kurs * $row->nominal,2);
                                $total_1[$key+1] = $request->kurs * $row->nominal;
                            } else {
                                echo number_format($row->nominal,2);
                                $total_1[$key+1] = $row->nominal;
                            }
                            ?>
                        </td>
                        <td class="text-center">
                        <?php
                            $tgldep = date_create($row->tgldep);
                            echo date_format($tgldep, 'd/m/Y');
                        ?>
                        </td>
                        <td class="text-center">
                        <?php
                            $tgltempo = date_create($row->tgltempo);
                            echo date_format($tgltempo, 'd/m/Y');
                        ?>
                        </td>
                        <td class="text-center">{{ number_format($row->haribunga,0) }}</td>
                        <td class="text-center">{{ number_format($row->bungatahun,2) }}</td>
                        <td class="text-right">
                            <?php 
                            if($row->ci == 2){
                                echo number_format($request->kurs * $row->bungabulan,2);
                                $total_2[$key+1] = $request->kurs * $row->bungabulan;
                            } else {
                                echo number_format($row->bungabulan,2);
                                $total_2[$key+1] = $row->bungabulan;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <?php
                            if($row->ci == 2){
                                echo number_format($request->kurs * $row->pph20,2);
                                $total_3[$key+1] = $request->kurs * $row->pph20;
                            } else {
                                echo number_format($row->pph20,2);
                                $total_3[$key+1] = $row->pph20;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <?php
                            if($row->ci == 2){
                                echo number_format($request->kurs * $row->netbulan,2);
                                $total_4[$key+1] = $request->kurs * $row->netbulan;
                            } else {
                                echo number_format($row->netbulan,2);
                                $total_4[$key+1] = $row->netbulan;
                            }
                            ?>
                        </td>
                        <td class="text-center">{{ $row->accharibunga}}</td>
                        <td class="text-right">
                            <?php
                            if($row->ci == 2){
                                echo number_format($request->kurs * $row->accnetbulan,2);
                                $total_5[$key+1] = $request->kurs * $row->accnetbulan;
                            } else {
                                echo number_format($row->accnetbulan,2);
                                $total_5[$key+1] = $row->accnetbulan;
                            }
                            ?>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <th class="text-left" colspan="3">TOTAL {{ $lapangan}}</th>
                        <th class="text-right">{{ number_format(array_sum($total_1),2) }}</th>
                        <th colspan="4"></th>
                        <th class="text-right">{{ number_format(array_sum($total_2),2) }}</th>
                        <th class="text-right">{{ number_format(array_sum($total_3),2) }}</th>
                        <th class="text-right">{{ number_format(array_sum($total_4),2) }}</th>
                        <th></th>
                        <th class="text-right">{{ number_format(array_sum($total_5),2) }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="3">GRAND TOTAL MD + MS</th>
                        <th class="text-right">{{ number_format(array_sum($total_1),2) }}</th>
                        <th colspan="4"></th>
                        <th class="text-right">{{ number_format(array_sum($total_2),2) }}</th>
                        <th class="text-right">{{ number_format(array_sum($total_3),2) }}</th>
                        <th class="text-right">{{ number_format(array_sum($total_4),2) }}</th>
                        <th></th>
                        <th class="text-right">{{ number_format(array_sum($total_5),2) }}</th>
                    </tr>
                    <tr>
                        <th class="text-left" colspan="13">KURS : {{ number_format($request->kurs,0) }}</th>
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