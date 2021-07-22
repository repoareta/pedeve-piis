<?php

function pph21ok($pokok)
{
    $pphrss=DB::select("select * from sdm_tbl_progressif order by awal asc");
    $pph21ok = 0;
    $sisapokok = $pokok; 
    if ($sisapokok > 0) {
        $sisapokok1 = $sisapokok;
        if (($sisapokok1 > 0) and ($sisapokok1 < 50000000)) {
            $pph21r = $sisapokok1 * (5/100);
            return $pajakbulanpt = ($pph21r/12);
        } elseif (($sisapokok1 > 0) and ($sisapokok1 < 250000000)) {
            $pph21r = $sisapokok1 * (15/100);
            return $pajakbulanpt = ($pph21r/12);
        } elseif (($sisapokok1 > 0) and ($sisapokok1 < 500000000)) {
            $pph21r = $sisapokok1 * (25/100);
            return $pajakbulanpt = ($pph21r/12);
        } elseif (($sisapokok1 > 0) and ($sisapokok1 >= 500000000)) {
            $pph21r = $sisapokok1 * (30/100);
            return $pajakbulanpt = ($pph21r/12);
        } elseif($sisapokok1 < 0) {
            $pph21r = 0;
            return $pajakbulanpt = ($pph21r);
        }
    } else {
        $sisapokok1 = $sisapokok;
        $pph21r = 0;
        return $pajakbulanpt = 0;
    }
}

function vf($tf)
{
    if (is_null($tf)) {
        return   $vf = "0";
    } else {
        return $vf = trim($tf);
    }
}

function stbbuku2($sthnbln, $ssup)
{
    $data_rsbulan = DB::select("select * from bulankontroller where thnbln='$sthnbln' and suplesi='$ssup'");
    if (!empty($data_rsbulan)) {
        foreach ($data_rsbulan as $data) {
            if ($data->status == 1) {
                return 'gtopening';
            } elseif ($data->status == 2) {
                return 'gtstopping';
            } elseif ($data->status == 3) {
                return 'gtclosing';
            } else {
                return 'gtnone';
            }
        }
    } else {
        return 'gtnone';
    }
}