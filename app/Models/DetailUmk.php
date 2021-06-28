<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailUmk extends Model
{
    protected $table="kerja_detail";
    public $incrementing = false;
    public $timestamps = false;

    public function umk()
    {
        return $this->belongsTo('App\Models\Umk');
    }
}
