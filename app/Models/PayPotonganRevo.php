<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPotonganRevo extends Model
{
    use HasFactory;

    protected $table = "pay_potongan_revo";
    // protected $primaryKey = 'nopek'; // or null
    public $timestamps = false;
    public $incrementing = false;
}
