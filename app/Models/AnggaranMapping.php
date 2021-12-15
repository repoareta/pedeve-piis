<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranMapping extends Model
{
    use HasFactory;

    protected $table = "anggaran_mapping";

    public function sanper()
    {
        return $this->hasMany(Account::class, 'kode', 'kodeacct');
    }
}
