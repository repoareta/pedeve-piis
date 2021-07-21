<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapKas extends Model
{
    use HasFactory;

    protected $table = "rekapkas";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
