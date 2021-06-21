<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasdoc extends Model
{
    use HasFactory;

    protected $table = "kasdoc";
    protected $primaryKey = 'docno'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function storejk()
    {
        return $this->belongsTo(Storejk::class);
    }

    public function kasline()
    {
        return $this->hasMany(Kasline::class, 'docno', 'docno');
    }
}
