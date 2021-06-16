<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPdv extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey   = "userid";
    protected $keyType      = 'string';
    public $incrementing = false;
    public $timestamps   = false;
    protected $table        = "userpdv";
    protected $fillable     = [
        'userid',
        'usernm',
        'userlv',
        'userap',
        'userpw',
        'tglupl',
        'usrpd',
        'kode',
        'passexp',
        'host',
        'nopeg'
    ];

    public function getAuthPassword()
    {
        return $this->userpw;
    }

    public function pekerja()
    {
        return $this->belongsTo('App\Models\Pekerja', 'nopeg', 'nopeg');
    }

    public function jabatan_latest()
    {
        return $this->hasMany('App\Models\Jabatan', 'nopeg')->latest()->first();
    }

    public function fungsi()
    {
        return $this->belongsTo('App\Models\GcgFungsi', 'gcg_fungsi_id', 'id');
    }

    public function fungsi_jabatan()
    {
        return $this->belongsTo('App\Models\GcgJabatan', 'gcg_jabatan_id', 'id');
    }
}
