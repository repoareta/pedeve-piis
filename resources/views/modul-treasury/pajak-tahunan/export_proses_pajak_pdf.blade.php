<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Form Cetak 1721-A1
    </title>
</head>
<style media="screen">
    table {
        width: 100%;
        border-collapse: collapse;
        padding-top: 40%;
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

    .row-td {
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

    .hidden {
        page-break-before: always;
    }

    thead {
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
        width: 120px;
    }
</style>

<body style="">
    <main>
        <?php 
            $bulan_a_1 = 0;
            $total_a_1 = $total_a_2 = $total_a_3 =  $total_a_4 = $total_a_5 = $total_a_6 = $total_a_7 = $total_a_8 = 0;
            foreach ($data_list as $key=>$row) {
                if (isset($data_list[$key+1]['nopek'])) {
                    $nopek =  $data_list[$key+1]['nopek'];
                    $nopek_b =  $data_list[$key]['nopek'];
                    $bulan = $data_list[$key]['bulan'];
                } else {
                    $nopek = substr($data_list[$key]['nopek'],0,2);
                    $nopek_b = substr($data_list[$key]['nopek'],0,2);
                    $bulan = $data_list[$key]['bulan'];
                }
                if (isset($data_list[$key+(-1)]['nopek'])) {
                    $nopek_a =  $data_list[$key+(-1)]['nopek'];
                } else {
                    $nopek_a =  substr($data_list[$key]['nopek'],0,2);
                }
                    $total_a_1 += $row['data_1'];
                    $total_a_2 += $row['data_2'];
                    $total_a_3 += $row['data_3'];
                    $total_a_4 += $row['data_4'];
                    $total_a_5 += $row['data_5'];
                    $total_a_6 += $row['data_6'];
                    $total_a_7 += $row['data_7'];
                    $total_a_8 += $row['data_8'];
                
            if ($row->nopek != $nopek or $bulan) {
        
                    $array_bln	 = array (
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
                    
                    $bulan_ = strtoupper($array_bln[ltrim($row->bulan,0)]);
        ?>
        @if ($row->nopek != $nopek_a)
        @foreach(DB::table('sdm_master_pegawai')->where('nopeg',$row->nopek)->get() as $data_peg)
        <div class="hidden"></div>
        <table>
            <tr>
                <td style="text-align: left; padding-left:20px;font: normal 14px Verdana, Arial, sans-serif">
                    <table>
                        <tr>
                            <td width="30%"><b>FORM 1721 - A1 </b></td>
                            <td width="5%">:</td>
                            <td><b>{{$row->tahun}}</b></td>
                        </tr>
                        <tr>
                            <td><b>No. NPWP Pemotong Pajak</b></td>
                            <td>:</td>
                            <td>02.097.576.9-073.000</td>
                        </tr>
                        <tr>
                            <td><b>Nama Pemotong Pajak</b></td>
                            <td>:</td>
                            <td>PT. PERTAMINA PEDEVE INDONESIA</td>
                        </tr>
                        <tr>
                            <td><b>Nama Pegawai</b></td>
                            <td>:</td>
                            <td>{{$data_peg->nama}}</td>
                        </tr>
                        <tr>
                            <td><b>NPWP Pegawai</b></td>
                            <td>:</td>
                            <td>{{$data_peg->npwp}}</td>
                        </tr>
                        <tr>
                            <td><b>Alamat</b></td>
                            <td>:</td>
                            <td>{{$data_peg->alamat1}}</td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td>:</td>
                            <td>{{$data_peg->kodekeluarga}}</td>
                        </tr>
                        <tr>
                            <td><b>Jabatan</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Masa Penghasilan</b></td>
                            <td>:</td>
                            <td>JANUARI S/D DESEMBER</td>
                        </tr>
                    </table>
                    @endforeach
                </td>
                <td>
                    <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="160px" height="100px">
                </td>
            </tr>
        </table>
        @endif
        <table>
            <thead>
                @if($row->nopek != $nopek_a)
                <tr>
                    <th class="th-small text-center">Masa</th>
                    <th class="th-small text-center">UT/ All In</th>
                    <th class="th-small">Tunj. PPH</th>
                    <th class="th-small">Tunj. Lainnya<br> Lembur, dsb</th>
                    <th class="th-small">Honorarium<br> Lainnya</th>
                    <th class="th-small">Premi Asuransi</th>
                    <th class="th-medium">Bonus, THR,UTD</th>
                    <th class="th-medium">Tunj. Pajak<br> Bonus + THR</th>
                    <th class="th-medium">Iuran Karyawan<br> Pensiun + JHT</th>
                </tr>
                @endif
            </thead>
            <tbody>
                <tr>
                    <td class="row-td">{{$bulan_}}</td>
                    <td class="row-td text-right">
                        {{$row->data_1 < 0 ? "(".number_format($row->data_1*-1,2).")" : number_format($row->data_1,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_2 < 0 ? "(".number_format($row->data_2*-1,2).")" : number_format($row->data_2,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_3 < 0 ? "(".number_format($row->data_3*-1,2).")" : number_format($row->data_3,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_4 < 0 ? "(".number_format($row->data_4*-1,2).")" : number_format($row->data_4,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_5 < 0 ? "(".number_format($row->data_5*-1,2).")" : number_format($row->data_5,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_6 < 0 ? "(".number_format($row->data_6*-1,2).")" : number_format($row->data_6,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_7 < 0 ? "(".number_format($row->data_7*-1,2).")" : number_format($row->data_7,2)}}
                    </td>
                    <td class="row-td text-right">
                        {{$row->data_8 < 0 ? "(".number_format($row->data_8*-1,2).")" : number_format($row->data_8,2)}}
                    </td>
                </tr>
            </tbody>
            <?php
                if ($nopek_b == $row->nopek) {
                    $sub_total_saldo_4_3_rp =$total_a_1 < 0 ? "(".number_format($total_a_1*-1, 2).")" : number_format($total_a_1, 2);
                }
?>
            @if ($row->nopek != $nopek)
            @foreach(DB::table('v_reportpajak_total')->where('nopek',$row->nopek)->get() as $data_peg)
            <tr style="text-align: left; padding-left:20px;font: normal 12px Verdana, Arial, sans-serif">
                <th class="text-left">TOTA</th>
                <th class="text-right">
                    {{$data_peg->data_1 < 0 ? "(".number_format($data_peg->data_1*-1,2).")" : number_format($data_peg->data_1,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_2 < 0 ? "(".number_format($data_peg->data_2*-1,2).")" : number_format($data_peg->data_2,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_3 < 0 ? "(".number_format($data_peg->data_3*-1,2).")" : number_format($data_peg->data_3,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_4 < 0 ? "(".number_format($data_peg->data_4*-1,2).")" : number_format($data_peg->data_4,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_5 < 0 ? "(".number_format($data_peg->data_5*-1,2).")" : number_format($data_peg->data_5,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_6 < 0 ? "(".number_format($data_peg->data_6*-1,2).")" : number_format($data_peg->data_6,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_7 < 0 ? "(".number_format($data_peg->data_7*-1,2).")" : number_format($data_peg->data_7,2)}}
                </th>
                <th class="text-right">
                    {{$data_peg->data_8 < 0 ? "(".number_format($data_peg->data_8*-1,2).")" : number_format($data_peg->data_8,2)}}
                </th>
            </tr>
            @endforeach
            @endif
        </table>
        <?php
                }
            } ?>

    </main>
</body>

</html>