<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKerja extends Model
{
    use HasFactory;

    protected $table = "tbl_rencana_kerja";
    protected $primaryKey = 'kd_rencana_kerja'; // or null
    public $timestamps = false;
}
