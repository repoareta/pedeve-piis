<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerizinanFile extends Model
{
    protected $table = 'cm_perusahaan_afiliasi_perizinan_file';

    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class, 'perizinan_id');
    }
}
