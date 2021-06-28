<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PajakInput extends Model
{
    use HasFactory;

    protected $table="pajak_input";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
