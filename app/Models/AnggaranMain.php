<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranMain extends Model
{
    use HasFactory;

    protected $table = "anggaran_main";
    protected $primaryKey = 'kode_main'; // or null
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;

    public function anggaran_submain()
    {
        return $this->hasMany('App\Models\AnggaranSubMain', 'kode_main');
    }

    public function anggaran_detail()
    {
        return $this->hasManyThrough('App\Models\AnggaranDetail', 'App\Models\AnggaranSubmain', 'kode_main', 'kode_submain');
    }
}
