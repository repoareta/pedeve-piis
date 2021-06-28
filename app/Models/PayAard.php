<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayAard extends Model
{
    use HasFactory;

    protected $table = "pay_tbl_aard";
    protected $primaryKey = 'kode'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
