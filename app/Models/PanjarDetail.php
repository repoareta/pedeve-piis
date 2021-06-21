<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanjarDetail extends Model
{
    use HasFactory;

    protected $table = "panjar_detail";
    protected $primaryKey = null; // or null
    public $timestamps = false;
    public $incrementing = false;

    /**
     * Panjar Detail dimiliki Panjar Header
     *
     * @return void
     */
    public function panjar_header()
    {
        return $this->belongsTo('App\Models\PanjarHeader', 'no_panjar');
    }
}
