<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayLembur extends Model
{
    use HasFactory;

    protected $table="pay_lembur";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
