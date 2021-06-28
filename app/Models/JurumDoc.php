<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurumDoc extends Model
{
    use HasFactory;

    protected $table = "jurumdoc";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
