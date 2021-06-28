<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranSubMain extends Model
{
    use HasFactory;

    protected $table = "anggaran_submain";
    protected $primaryKey = 'kode_submain'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function anggaran_main()
    {
        return $this->belongsTo('App\Models\AnggaranMain', 'kode_main');
    }

    public function anggaran_detail()
    {
        return $this->hasMany('App\Models\AnggaranDetail', 'kode_submain');
    }
}
