<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SdmMasterPegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sdm_master_pegawai";
    protected $primaryKey = 'nopeg'; // or null
    public $timestamps = false;
    public $incrementing = false;

    protected $dates = ['deleted_at'];

    public function koreksigaji()
    {
        return $this->hasMany('App\Models\KoreksiGaji', 'nopek');
    }
}
