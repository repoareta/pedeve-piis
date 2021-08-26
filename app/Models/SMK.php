<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMK extends Model
{
    use HasFactory;

    protected $table = "sdm_smk";
    protected $primaryKey = ['nopeg', 'tahun'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';
}
