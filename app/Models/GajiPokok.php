<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\CompositeKey;

class GajiPokok extends Model
{
    use HasFactory;

    use CompositeKey;

    protected $table = "sdm_gapok";
    protected $primaryKey = ['nopeg', 'id'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';
}
