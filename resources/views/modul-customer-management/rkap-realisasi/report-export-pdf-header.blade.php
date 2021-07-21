<!DOCTYPE html>
<html lang="en">
<body>
    <div class="">
        <span style="float:left;">
            <b>
                LAPORAN RKAP & REALISASI
                <br>
                PT. PERTAMINA PEDEVE INDONESIA
                <br>
                Perusahaan {{ $perusahaan_pdf }}
                <br>
                Tahun: {{ $tahun_pdf }}
            </b>
            <br>
            @php
                setlocale (LC_TIME, 'id_ID');
                echo "Tanggal Cetak: ".strftime( "%d %B %Y");
            @endphp
        </span>
    
        <span style="float:right">
            <img src="{{ public_path() . '/images/pertamina.jpg' }}" width="120px" height="60px">
        </span>
    </div>
</body>
</html>