<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PanjarHeader extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "panjar_header";
    protected $primaryKey = 'no_panjar'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    const CREATED_AT = 'tgl_panjar';
    
    protected $dates = ['deleted_at'];
    
    /**
     * Panjar Header hasMany Panjar Detail
     *
     * @return void
     */
    public function panjar_detail()
    {
        return $this->hasMany('App\Models\PanjarDetail', 'no_panjar');
    }

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function ppanjar_header()
    {
        return $this->hasOne('App\Models\PPanjarHeader', 'no_panjar');
    }
}
