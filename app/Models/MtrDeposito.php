<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtrDeposito extends Model
{
    use HasFactory;

    protected $table="mtrdeposito";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
