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

    protected $fillable = [
        'paid',
        'paidby',
        'paiddate',
    ];

    public function storejk()
    {
        return $this->belongsTo(StoreJK::class, 'store', 'kodestore');
    }

    public function kasline()
    {
        return $this->hasMany(Kasline::class, 'docno', 'docno');
    }
}
