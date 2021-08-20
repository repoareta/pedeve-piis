<?php

/**
 * Undocumented function
 *
 * @param [type] $angka
 * @return void
 */
function sanitize_nominal($angka)
{
    return str_replace(
        ',', 
        '', 
        number_format((float) $angka, 2)
    );
}
