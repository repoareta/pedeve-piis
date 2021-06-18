<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DftMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table="dftmenu";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}
