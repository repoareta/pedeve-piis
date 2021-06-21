<?php

/**
 * membuat format mata uang rupiah
 * @param  [type] $angka [description]
 * @return [type]        [description]
 */
function currency_idr(float $angka)
{
    return "Rp. ".number_format($angka, 2, ',', '.');
}
