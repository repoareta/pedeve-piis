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
        return $this->belongsTo('App\Models\MasterPegawai', 'nopeg', 'nopeg');
    }

    public function dokumen()
    {
        return $this->hasMany(GcgLhkpnDokumen::class, 'lhkpn_id', 'id');
    }
}
