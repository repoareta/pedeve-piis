<?php

namespace App\Models;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganGaji extends Model
{
    use HasFactory;

    use CompositeKey;

    protected $table = "sdm_golgaji";
    protected $primaryKey = ['nopeg', 'tanggal', 'golgaji'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';
}
