<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmuDebetNota extends Model
{
    use HasFactory;

    protected $table = "umu_debet_nota";
    public $timestamps = false;
    public $incrementing = false;
}
