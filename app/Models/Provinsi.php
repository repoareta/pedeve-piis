<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = "sdm_tbl_propinsi";
    protected $primaryKey = 'kode'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
