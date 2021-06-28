<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPotonganInsentif extends Model
{
    use HasFactory;

    protected $table = "pay_potongan_insentif";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
