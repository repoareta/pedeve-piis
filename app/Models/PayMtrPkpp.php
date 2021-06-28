<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMtrPkpp extends Model
{
    use HasFactory;

    protected $table="pay_mtrpkpp";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
