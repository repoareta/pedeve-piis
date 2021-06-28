<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurumLine extends Model
{
    use HasFactory;

    protected $table = "jurumline";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
