<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AktaFile extends Model
{
    protected $table = 'cm_perusahaan_afiliasi_akta_file';

    public function akta()
    {
        return $this->belongsTo(Akta::class, 'akta_id');
    }
}
