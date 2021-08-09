<!DOCTYPE html>
<html lang="en">
<body>  
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
                    <td>{{ date('Y-m-d', strtotime($panjar->mulai)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($panjar->sampai)) }}</td>
                    <td>{{ $panjar->dari }}</td>
                    <td>{{ $panjar->tujuan }}</td>
                    <td>{{ $panjar->nopek.' - '.$panjar->nama }}</td>
                    <td>{{ $panjar->keterangan }}</td>
                    <td class="text-right">{{ $panjar->jm_panjar < 1 ? 0 : $panjar->jm_panjar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>