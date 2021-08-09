<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Rekap Panjar Dinas
    </title>
</head>
<style media="screen">

.table {
    font: normal 12px Verdana, Arial, sans-serif;
    border-collapse: collapse;
    border: 1px solid black;
}

th, td {
    border: 1px solid black;
    padding: 5px;
}

.table-no-border-all td {
    font: normal 12px Verdana, Arial, sans-serif;
    border: 0px;
    padding: 0px;
}

.table-no-border td, .table-no-border tr {
    font: normal 12px Verdana, Arial, sans-serif;
    border:0px;
    padding: 0px;
}

h4 {
    font-size: 15px;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -5px;
    margin-left: -5px;
}

.content {
    width: 100%;
    padding: 0px;
    overflow: hidden;
}

.content img {
    margin-right: 15px;
    float: left;
}

.content h4 {
    margin-left: 15px;
    display: block;
    margin: 2px 0 15px 0;
}

.content p {
    margin-left: 15px;
    display: block;
    margin: 0px 0 10px 0;
    font-size: 12px;
    padding-bottom: 10px;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

th {
    white-space: nowrap;
}

footer .pagenum:before {
    content: counter(page);
}

#container {
    position: relative;
    font: normal 12px Verdana, Arial, sans-serif;
}
#bottom-right {
    position: absolute;
    bottom: 0;
}

.pagecount:before {
content: counter(pages);
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
            <div class="text-center">
                <p>
                    <b>PT PERTAMINA PEDEVE INDONESIA
                    <br>
                    REKAP PANJAR DINAS
                    <br>
                    Periode 
                    {{ Carbon\Carbon::parse($mulai)->translatedFormat('d F Y') }} 
                    sampai
                    {{ Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
                    </b>
                </p>
            </div>
    
            <div>
                <img align="right" src="{{ public_path('/images/pertamina.jpg') }}" width="120px" height="60px" style="padding-top:10px">
            </div>
        </div>
    </header>
      
    <main>
        <div class="row">
            <table style="width:100%;" class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>NO. PANJAR</th>
                        <th>NO. UMK</th>
                        <th>JENIS</th>
                        <th>MULAI</th>
                        <th>SAMPAI</th>
                        <th>DARI</th>
                        <th>TUJUAN</th>
                        <th>NOPEK</th>
                        <th>KETERANGAN</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $total = 0;
                    @endphp
                    @foreach ($panjar_header_list as $panjar)
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td>{{ $panjar->no_panjar }}</td>
                            <td>{{ $panjar->no_umk }}</td>
                            <td class="text-center">{{ $panjar->jenis_dinas }}</td>
                            <td>{{ date('d/m/Y', strtotime($panjar->mulai)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($panjar->sampai)) }}</td>
                            <td>{{ $panjar->dari }}</td>
                            <td>{{ $panjar->tujuan }}</td>
                            <td>{{ $panjar->nopek.' - '.$panjar->nama }}</td>
                            <td>{{ $panjar->keterangan }}</td>
                            <td class="text-right">{{ currency_idr($panjar->jm_panjar) }}</td>
                            @php
                                $total += $panjar->jm_panjar;
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="10" class="text-center">Total</td>
                        <td class="text-right">{{ currency_idr($total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>