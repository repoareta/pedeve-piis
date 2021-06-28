<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBayarDetail extends Model
{
    use HasFactory;

    protected $table="umu_bayar_detail";
    public $timestamps = false;
    public $incrementing = false;
}
