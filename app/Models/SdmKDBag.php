<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SdmKDBag extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "sdm_tbl_kdbag";
    protected $fillable= [
        'kode',
        'nama'
    ];
}
