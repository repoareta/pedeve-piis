<?php

/**
 * Undocumented function
 *
 * @param [type] $angka
 * @return void
 */
function abs_thousands($angka)
{
    return number_format((float) $angka, 0, '.', '.');
}
