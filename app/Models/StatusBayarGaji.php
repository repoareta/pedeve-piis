<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBayarGaji extends Model
{
    use HasFactory;

    protected $table = "statusbayargaji";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
