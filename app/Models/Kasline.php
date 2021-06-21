<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasline extends Model
{
    use HasFactory;

    protected $table="kasline";
    protected $primaryKey = ['docno', 'lineno'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
