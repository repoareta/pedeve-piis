<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VParamPajak extends Model
{
    use HasFactory;

    protected $table = "v_reportpajak";
    public $incrementing = false;
    public $timestamps = false;
}
