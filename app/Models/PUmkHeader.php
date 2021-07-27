<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PUmkHeader extends Model
{
    use HasFactory;

    protected $table = "pumk_header";
    protected $primaryKey = 'no_pumk'; // or null
    public $timestamps = false;
    public $incrementing = false;

    public function pumk_detail()
    {
        return $this->hasMany('App\Models\PUmkDetail', 'no_pumk');
    }

    public function umk_header()
    {
        return $this->belongsTo('App\Models\UmkHeader', 'no_umk');
    }

    public function pekerja()
    {
        return $this->belongsTo('App\Models\MasterPegawai', 'nopek');
    }
}
