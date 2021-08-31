<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblDokumenPerkara extends Model
{
    use HasFactory;

    protected $table = "tbl_dokumen_perkara";
    protected $primaryKey = 'kd_dok';
    public $timestamps = false;
}
