<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpahTetapPensiun extends Model
{
    use HasFactory;

    protected $table = "sdm_ut_pensiun";
    protected $primaryKey = ['nopeg', 'ut'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';
}
