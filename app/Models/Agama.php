<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;

    protected $table = "sdm_tbl_agama";
    protected $primaryKey = 'kode'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
}
