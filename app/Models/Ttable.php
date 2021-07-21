<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttable extends Model
{
    use HasFactory;

    protected $table = "t_table";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
