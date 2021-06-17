<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pekerja extends Model
{
    use SoftDeletes;

    protected $table = "sdm_master_pegawai";
    protected $primaryKey = 'nopeg'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    
    protected $dates = ['deleted_at'];

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function jabatan()
    {
        return $this->hasMany('App\Models\Jabatan', 'nopeg');
    }

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function jabatan_latest()
    {
        return $this->hasMany('App\Models\Jabatan', 'nopeg')->latest()->first();
    }

    public function jabatan_latest_one()
    {
        return $this->hasOne('App\Models\Jabatan', 'nopeg')->latest();
    }
}
