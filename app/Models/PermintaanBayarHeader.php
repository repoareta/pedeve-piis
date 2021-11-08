<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBayarHeader extends Model
{
    use HasFactory;

    protected $table="umu_bayar_header";
    protected $primaryKey = 'no_bayar';
    protected $guarded = [];
    public $incrementing = false;
    public $timestamps = false;

    public function permintaandetail()
    {
        return $this->hasMany('App\Models\PermintaanBayarDetail', 'no_bayar');
    }
}
