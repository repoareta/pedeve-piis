<?php ini_set('memory_limit', '2048M'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Rekap Anggaran Umum {{ $tahun }}
    </title>
</head>
<style media="screen">

table {
    font: normal 10px Verdana, Arial, sans-serif;
    border-collapse: collapse;
}

.table-no-border-all td {
    border: 0px;
    padding: 0px;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -5px;
    margin-left: -5px;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

th, tr {
    white-space: nowrap;
}

header { 
    position: fixed; 
    left: 0px; 
    top: -110px;
    right: 0px;
    height: 0px;
}

@page { 
    margin: 130px 50px 50px 50px;
}

</style>
<body>
    <header id="header">
        <div class="row">
            <div class="">
                <p>
                    <b>
                    LAPORAN ANGGARAN
                    <br>
                    PT. PERTAMINA PEDEVE INDONESIA
                    <br>
                    Tahun: {{ $tahun }}
                    </b>
                    <br>
                    Tanggal Cetak: {{ date('d F Y') }}
                </p>
            </div>
    
            <div>
                <img align="right" src="{{ public_path() . '/images/pertamina.jpg' }}" width="120px" height="60px" style="padding-top:10px">
            </div>
        </div>
    </header>
      
    <main>
        <div class="row">
            <table style="width:100%;" class="table">
                <tbody>
                    @foreach ($anggaran_list as $anggaran)
                        <tr style="outline: thin solid">
                            <td><b>{{ $anggaran->kode_main }}</b></td>
                            <td colspan="5"><b>{{ $anggaran->nama_main }}</b></td>
                            <td class="text-right"><b>{{ float_two($anggaran->nilai_real) }}</b></td>
                        </tr>
                        @foreach ($anggaran->anggaran_submain as $anggaran_submain)
                            <tr style="outline: thin solid">
                                <td><b>{{ $anggaran_submain->kode_submain }}</b></td>
                                <td colspan="5"><b>{{ $anggaran_submain->nama_submain }}</b></td>
                                <td class="text-right"><b>{{ float_two($anggaran_submain->nilai) }}</b></td>
                            </tr>
                            @foreach ($anggaran_submain->anggaran_detail as $anggaran_detail)
                                <tr>
                                    <td></td>
                                    <td><b>{{ substr($anggaran_detail->kode, 0, 5) }}</b></td>
                                    <td colspan="5"><b>{{ $anggaran_detail->nama }}</b></td>
                                </tr>
                                @php
                                    $v_anggaran = DB::table('kasdoc AS kas')
                                        ->select(DB::raw("substr(kas.thnbln,1,4)"), 'kas.docno', 'kas.rate', 'k.totprice', 'k.account', DB::raw("substr(k.keterangan,1,48) AS keterangan"), 'k.jb', 'k.cj')
                                        ->join('kasline AS k', 'k.docno', 'kas.docno')
                                        ->where('k.account', 'like', '5%')
                                        ->where('k.account', $anggaran_detail->kode)
                                        ->groupBy('kas.thnbln', 'kas.docno', 'kas.rate', 'k.totprice', 'k.account', 'k.keterangan', 'k.jb', 'k.cj')
                                        ->having(DB::raw("substr(kas.thnbln,1,4)"), '=', $tahun)
                                        ->get()
                                        ->take(1)
                                        ->chunk(50);
                                @endphp
                                @if ($v_anggaran)
                                    @foreach ($v_anggaran as $new_anggaran)
                                        @foreach ($new_anggaran as $item)
                                            <tr>
                                                <td></td>
                                                <td>{{ $item->account }}</td>
                                                <td>{{ $item->docno }}</td>
                                                <td>{{ $item->account }}</td>
                                                <td>{{ $item->jb }}</td>
                                                <td>{{ $item->keterangan }}</td>
                                                <td class="text-right">{{ float_two($item->totprice) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>  
</body>
</html>