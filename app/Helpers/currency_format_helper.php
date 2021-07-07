<?php

/**
 * Undocumented function
 *
 * @param [type] $angka
 * @return void
 */
function currency_format($angka)
{
    return number_format((float) $angka, 2, ',', '.');
}
