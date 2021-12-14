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
        return $this->belongsTo('App\Models\MasterPegawai', 'nopeg', 'nopeg');
    }

    public function dokumen()
    {
        return $this->hasMany(GcgSosialisasiDokumen::class, 'sosialisasi_id', 'id');
    }

    public function reader()
    {
        return $this->hasMany(GcgSosialisasiReader::class, 'nopeg', 'nopeg');
    }
}
