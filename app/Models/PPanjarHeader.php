<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PPanjarHeader extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ppanjar_header";
    protected $primaryKey = 'no_ppanjar'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    const CREATED_AT = 'tgl_ppanjar';
    
    protected $dates = ['deleted_at'];

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function panjar_header()
    {
        return $this->belongsTo('App\Models\PanjarHeader', 'no_panjar');
    }

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function ppanjar_detail()
    {
        return $this->hasMany('App\Models\PPanjarDetail', 'no_ppanjar');
    }
}
