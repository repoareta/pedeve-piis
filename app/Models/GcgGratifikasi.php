<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcgGratifikasi extends Model
{
    use HasFactory;

    protected $table = "gcg_gratifikasi";

    public function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'nopeg');
    }

    public function userpdv()
    {
        return $this->belongsTo('App\Models\Userpdv', 'nopeg', 'nopeg');
    }
}
