<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUmk extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table="kerja_detail";

    public function umk()
    {
        return $this->belongsTo('App\Models\Umk');
    }
}