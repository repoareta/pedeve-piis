<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayHonor extends Model
{
    use HasFactory;

    protected $table = "pay_honorarium";
    // protected $primaryKey = 'nopek'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
