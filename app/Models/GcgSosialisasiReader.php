<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcgSosialisasiReader extends Model
{
    use HasFactory;

    protected $table = "gcg_sosialisasi_reader";

    public function pekerja()
    {
        return $this->belongsTo(MasterPegawai::class, 'nopeg', 'nopeg');
    }
}
