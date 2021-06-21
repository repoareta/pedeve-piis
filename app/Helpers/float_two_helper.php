<?php

/**
 * Undocumented function
 *
 * @param [type] $angka
 * @return void
 */
function float_two(float $angka)
{
    return str_replace(',', '', number_format($angka, 2));
}
