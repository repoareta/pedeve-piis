<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeJabatan extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = "sdm_tbl_kdjab";
    protected $primaryKey = ['kdbag', 'kdjab'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * Kode Jabatan dimiliki Kode Bagian
     *
     * @return void
     */
    public function kode_bagian()
    {
        return $this->belongsTo('App\Models\KodeBagian', 'kdbag', 'kode');
    }
}
