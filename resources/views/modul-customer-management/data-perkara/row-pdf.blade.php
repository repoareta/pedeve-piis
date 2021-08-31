<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Data Perkara - {{ $dataPerkara->no_perkara }}
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
    padding: 2px;
}

.table-no-border td, .table-no-border tr {
    font: normal 12px Verdana, Arial, sans-serif;
    border:0px;
    padding: 2px;
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

.no-wrap {
    white-space: nowrap;
}

.table-bordered {
    border: 1px solid #ddd;
    border-collapse: collapse;
    width: 100%;

    font: normal 11px Verdana, Arial, sans-serif;
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
                    Nomor Perkara: {{ $dataPerkara->no_perkara }}
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
            <table class="table-no-border-all">
                <tr>
                    <td class="no-wrap">Nomor Perkara</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->no_perkara }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Jenis Perkara</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->jenis_perkara }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Klasifikasi Perkara</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->klasifikasi_perkara }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Status Perkara</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->status_perkara }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Tanggal</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($dataPerkara->tgl_perkara)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Ringkasan Perkara</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->r_perkara }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Ringkasan Petitum</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->r_patitum }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Ringkasan Putusan</td>
                    <td>:</td>
                    <td>{{ $dataPerkara->r_putusan }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Nilai Perkara</td>
                    <td>:</td>
                    <td>
                        @if ($dataPerkara->ci == 1)
                            {{ currency_idr($dataPerkara->nilai_perkara) }}
                        @else
                            {{ currency_format($dataPerkara->nilai_perkara) }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <h4>
            Pihak
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataPihakList as $dataPihak)
                        <tr>
                            <td>{{ $dataPihak->nama }}</td>
                            <td>{{ $dataPihak->alamat }}</td>
                            <td>{{ $dataPihak->telp }}</td>
                            <td>{{ $dataPihak->keterangan }}</td>
                            <td>
                                @if ($dataPihak->status == 1)
                                    Penggugat
                                @elseif($dataPihak->status == 2)
                                    Tergugat
                                @elseif($dataPihak->status == 3)
                                    Turut Tergugat
                                @endif
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Kuasa Hukum
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pihak</th>
                        <th>Nama Kuasa Hukum</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kuasaHukumList as $kuasaHukum)
                        <tr>
                            <td>{{ $kuasaHukum->pihak->nama }}</td>
                            <td>{{ $kuasaHukum->nama }}</td>
                            <td>{{ $kuasaHukum->alamat }}</td>
                            <td>{{ $kuasaHukum->telp }}</td>
                            <td>{{ $kuasaHukum->keterangan }}</td>
                            <td>
                                @if ($kuasaHukum->status == 1)
                                    Penggugat
                                @elseif($kuasaHukum->status == 2)
                                    Tergugat
                                @elseif($kuasaHukum->status == 3)
                                    Turut Tergugat
                                @endif
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Dokumen Perkara
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokumenPerkaraList as $dokumenPerkara)
                        <tr>
                            <td>{{ $dokumenPerkara->file }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="1" class="text-center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>