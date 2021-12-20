<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcgGratifikasi extends Model
{
    use HasFactory;

    protected $table = "gcg_gratifikasi";

    protected $casts = [
        'tgl_gratifikasi' => 'datetime',
    ];

    public function pekerja()
    {
        return $this->belongsTo('App\Models\MasterPegawai', 'nopeg');
    }

    public function userpdv()
    {
        return $this->belongsTo('App\Models\UserPdv', 'nopeg', 'nopeg');
    }
}
