<?php

/**
 * membuat pekerja status
 *
 * @param [type] $status
 * @return void
 */
function pekerja_status($status)
{
    switch ($status) {
        case "P":
            return "Pensiun";
            break;
        case "C":
            return "Aktif";
            break;
        case "K":
            return "Kontrak";
            break;
        case "B":
            return "Perbantuan";
            break;
        case "D":
            return "Direksi";
            break;
        case "N":
            return "Pekerja Baru";
            break;
        case "U":
            return "Komisaris";
            break;
    }
}