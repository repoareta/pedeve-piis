<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akta extends Model
{
    use HasFactory;

    protected $table = "cm_perusahaan_afiliasi_akta";

    public function files()
    {
        return $this->hasMany(AktaFile::class, 'akta_id');
    }
}
