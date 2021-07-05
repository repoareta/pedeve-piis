<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoStore extends Model
{
    use HasFactory;

    protected $table = 'saldostore';
    protected $primaryKey = null;
    protected $fillable = [
        'saldoakhir',
        'debet',
        'kredit',
    ];

    public $incrementing = false;
    public $timestamps = false;
}
