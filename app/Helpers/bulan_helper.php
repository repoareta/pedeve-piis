<?php

function bulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function stbbuku($sthnbln, $ssup)
{
    $data_rsbulan = DB::select("SELECT * from timetrans where thnbln='$sthnbln' and suplesi='$ssup'");
    if (!empty($data_rsbulan)) {
        foreach ($data_rsbulan as $data_rs) {
            if ($data_rs->status == 1) {
                return $stbbuku = 1;
            } elseif ($data_rs->status == 2) {
                return $stbbuku = 2;
            } elseif ($data_rs->status == 3) {
                return $stbbuku = 3;
            } else {
                return $stbbuku = 0;
            }
        }
    } else {
        return $stbbuku = 0;
    }
}