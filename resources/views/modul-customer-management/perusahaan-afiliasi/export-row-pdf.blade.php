<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Perusahaan Afiliasi - {{ $perusahaanAfiliasi->nama }}
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
                    {{ $perusahaanAfiliasi->nama }}
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
                    <td class="no-wrap">Nama Perusahaan</td>
                    <td>:</td>
                    <td>{{ $perusahaanAfiliasi->nama }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Alamat</td>
                    <td>:</td>
                    <td>{{ $perusahaanAfiliasi->alamat }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Nomor Telepon</td>
                    <td>:</td>
                    <td>{{ $perusahaanAfiliasi->telepon }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">NPWP</td>
                    <td>:</td>
                    <td>{{ $perusahaanAfiliasi->npwp }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Bidang Usaha</td>
                    <td>:</td>
                    <td>{{ $perusahaanAfiliasi->bidang_usaha }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Modal Dasar</td>
                    <td>:</td>
                    <td>{{ currency_idr($perusahaanAfiliasi->modal_dasar) }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Modal Disetor</td>
                    <td>:</td>
                    <td>{{ currency_idr($perusahaanAfiliasi->modal_disetor) }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Jumlah Lembar Saham</td>
                    <td>:</td>
                    <td>{{ abs_thousands($perusahaanAfiliasi->jumlah_lembar_saham) }}</td>
                </tr>
                <tr>
                    <td class="no-wrap">Nilai Nominal Per Saham</td>
                    <td>:</td>
                    <td>{{ currency_idr($perusahaanAfiliasi->nilai_nominal_per_saham) }}</td>
                </tr>
            </table>
        </div>

        <h4>
            Pemegang Saham
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama PT</th>
                        <th>% Kepemilikan</th>
                        <th>Jumlah Lembar Saham</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemegangSahamList as $pemegangSaham)
                        <tr>
                            <td>{{ $pemegangSaham->nama }}</td>
                            <td class="text-right">{{ float_two($pemegangSaham->kepemilikan) }}</td>
                            <td class="text-right">{{ abs_thousands($pemegangSaham->jumlah_lembar_saham) }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Direksi
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>TMT Dinas</th>
                        <th>Akhir Masa Dinas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($direksiList as $direksi)
                        <tr>
                            <td>{{ $direksi->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($direksi->tmt_dinas)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($direksi->akhir_masa_dinas)->format('d F Y') }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Komisaris
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>TMT Dinas</th>
                        <th>Akhir Masa Dinas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($komisarisList as $komisaris)
                        <tr>
                            <td>{{ $komisaris->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($komisaris->tmt_dinas)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($komisaris->akhir_masa_dinas)->format('d F Y') }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Perizinan
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Nomor</th>
                        <th>Masa Berlaku Akhir</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perizinanList as $perizinan)
                        <tr>
                            <td>{{ $perizinan->keterangan }}</td>
                            <td>{{ $perizinan->nomor }}</td>
                            <td>{{ \Carbon\Carbon::parse($perizinan->masa_berlaku_akhir)->format('d F Y') }}</td>
                            <td>{{ $perizinan->dokumen }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h4>
            Akta
        </h4>

        <div class="row">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Nomor Akta</th>
                        <th>Tanggal</th>
                        <th>Notaris</th>
                        <th>TMT Berlaku</th>
                        <th>TMT Berakhir</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aktaList as $akta)
                        <tr>
                            <td>{{ $akta->jenis }}</td>
                            <td>{{ $akta->nomor_akta }}</td>
                            <td>{{ \Carbon\Carbon::parse($akta->tanggal)->format('d F Y') }}</td>
                            <td>{{ $akta->notaris }}</td>
                            <td>{{ \Carbon\Carbon::parse($akta->tmt_mulai)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($akta->tmt_akhir)->format('d F Y') }}</td>
                            <td>{{ $akta->dokumen }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Data tidak tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>
</body>
</html>