<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTunjangan extends Model
{
    use HasFactory;

    protected $table = "pay_tbl_tunjangan";
    protected $primaryKey = 'golongan'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
