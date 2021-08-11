<?php

namespace App\Exports;

use App\Models\Umk;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekapUMKExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Umk::all();
    }
}
