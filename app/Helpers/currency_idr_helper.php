<?php

/**
 * membuat format mata uang rupiah
 * @param  [type] $angka [description]
 * @return [type]        [description]
 */
function currency_idr($angka)
{
    return "Rp. ".number_format((float) $angka, 2, ',', '.');
}
