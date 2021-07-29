<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTblJenisUpah extends Model
{
    use HasFactory;

    protected $table="pay_tbl_jenisupah";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
