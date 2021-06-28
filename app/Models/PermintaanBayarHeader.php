<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBayarHeader extends Model
{
    use HasFactory;

    protected $table="umu_bayar_header";
    protected $primaryKey = 'no_bayar';
    public $incrementing = false;
    public $timestamps = false;

    public function permintaandetail()
    {
        return $this->hasMany('App\Models\PermintaanDetail', 'no_bayar');
    }
}
