<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\CompositeKey;

class Jabatan extends Model
{
    use HasFactory, CompositeKey;
    use \Awobaz\Compoships\Compoships;

    protected $table = "sdm_jabatan";
    protected $primaryKey = ['nopeg', 'kdbag', 'kdjab'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';

    /**
     * Jabatan dimiliki KodeBagian
     *
     * @return void
     */
    public function kode_bagian()
    {
        return $this->belongsTo('App\Models\KodeBagian', 'kdbag');
    }

    public function kode_jabatan()
    {
        return $this->belongsTo('App\Models\KodeJabatan', 'kdjab', 'kdbag');
    }

    public function kode_jabatan_new()
    {
        return $this->belongsTo('App\Models\KodeJabatan', ['kdjab', 'kdbag'], ['kdjab', 'kdbag']);
    }
}
