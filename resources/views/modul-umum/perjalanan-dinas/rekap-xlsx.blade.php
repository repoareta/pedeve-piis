<!DOCTYPE html>
<html lang="en">
    <style>   
    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
    </style>
<body>
    <table>
        <tr>
            <td colspan="10">PT PERTAMINA PEDEVE INDONESIA</td>
        </tr>
        <tr>
            <td colspan="10">REKAP PANJAR DINAS</td>
        </tr>
        <tr>
            <td colspan="10">
                Periode 
                {{ Carbon\Carbon::parse($mulai)->translatedFormat('d F Y') }} 
                sampai
                {{ Carbon\Carbon::parse($sampai)->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
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
            @foreach ($panjar_header_list as $panjar)
                <tr>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>