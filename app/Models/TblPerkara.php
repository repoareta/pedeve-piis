<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblPerkara extends Model
{
    use HasFactory;

    protected $table = "tbl_perkara";
    protected $primaryKey = 'no_perkara';
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
}
