<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOb extends Model
{
    use HasFactory;

    protected $table = "history_ob";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;
}
