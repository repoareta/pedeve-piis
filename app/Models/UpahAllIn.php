<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpahAllIn extends Model
{
    use HasFactory;

    protected $table = "sdm_allin";
    protected $primaryKey = ['nopek', 'nilai'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';

    protected $casts = [
        'mulai' => 'datetime',
        'sampai' => 'datetime'
    ];
}
