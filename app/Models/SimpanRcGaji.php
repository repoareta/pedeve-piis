<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpanRcGaji extends Model
{
    use HasFactory;

    protected $table = "simpan_rcgaji";
    protected $primaryKey = null;
    public $timestamps = false;
    public $incrementing = false;
}
