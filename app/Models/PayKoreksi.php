<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayKoreksi extends Model
{
    use HasFactory;

    protected $table="pay_koreksi";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
