<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umk extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_umk';
    public $incrementing = false;
    public $timestamps = false;
    protected $table="kerja_header";

    public function detailumk()
    {
        return $this->hasMany('App\Models\DetailUmk');
    }
}
