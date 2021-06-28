<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBiaya extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="jenisbiaya";
    protected $fillable=['kode','keterangan','kode_sub','nilai','nilai_real','inputdate','inputuser'];

    // public function detailumk()
    // {
    //     return $this->hasMany('App\DetailUmk');
    // }
}
