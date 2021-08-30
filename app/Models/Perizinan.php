<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = "cm_perusahaan_afiliasi_perizinan";

    public function files()
    {
        return $this->hasMany(PerizinanFile::class, 'perizinan_id');
    }
}
