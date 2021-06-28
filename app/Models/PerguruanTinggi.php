<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerguruanTinggi extends Model
{
    use HasFactory;

    protected $table = "sdm_tbl_pt";
    protected $primaryKey = 'kode'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
