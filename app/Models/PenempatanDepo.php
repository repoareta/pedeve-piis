<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanDepo extends Model
{
    use HasFactory;

    protected $table = "penempatandepo";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
