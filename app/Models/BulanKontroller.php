<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulanKontroller extends Model
{
    use HasFactory;

    protected $table = "bulankontroller";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
