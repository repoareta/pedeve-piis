<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashJudex extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table="cashjudex";
    protected $fillable=['kode','nama'];

    public function detailumk()
    {
        return $this->belongToMany('App\DetailUmk');
    }
}
