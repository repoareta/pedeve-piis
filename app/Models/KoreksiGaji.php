<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoreksiGaji extends Model
{
    use HasFactory;

    protected $table = "pay_koreksigaji";
    // protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;

    // public function sdmmasterpegawai()
    // {
    //     return $this->belongsTo('App\Models\SdmMasterPegawai', 'nopeg');
    // }
}
