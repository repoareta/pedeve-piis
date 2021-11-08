<?php

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } elseif ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function hitunghari($awal, $akhir)
{
    $tglsekarang = strtotime($awal);
    $jatuhtempo = strtotime($akhir);
    // hitung perbedaan  jatuh tempo dengan sekarang
    $beda = $jatuhtempo - $tglsekarang; // unix time
    // konversi $beda kedalam hari
    return $bedahari = ($beda/24/60/60);
}

function vbildb($vvals)
{
    if (is_null($vvals) or $vvals == 0) {
        return $vbildb = 0;
    } else {
        $src = $vvals;
        return $vbildb = $src;
    }
}
