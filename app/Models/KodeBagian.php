<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBagian extends Model
{
    use HasFactory;

    protected $table = "sdm_tbl_kdbag";
    protected $primaryKey = 'kode'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'kode',
        'nama',
        'nopeg',
    ];

    public function pimpinan()
    {
        return $this->belongsTo(MasterPegawai::class, 'nopeg', 'nopeg');
    }
}
