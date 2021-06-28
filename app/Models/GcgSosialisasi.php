<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcgSosialisasi extends Model
{
    use HasFactory;

    protected $table = "gcg_sosialisasi";

    public function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'nopeg', 'nopeg');
    }
}
