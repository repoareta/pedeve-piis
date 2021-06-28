<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcgLhkpn extends Model
{
    use HasFactory;

    protected $table = "gcg_lhkpn";

    public function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'nopeg', 'nopeg');
    }
}
