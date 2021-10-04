<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtBantu extends Model
{
    use HasFactory;

    protected $table="ut_bantu";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
