<?php

namespace App\Models;

use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaPendidikan extends Model
{
    use HasFactory;

    use CompositeKey;

    protected $table = "sdm_pendidikan";
    protected $primaryKey = ['nopeg', 'mulai'];
    protected $keyType = 'string';
    public $timestamps = false;
    public $incrementing = false;
    const CREATED_AT = 'tglentry';

    protected $casts = [
        'mulai' => 'datetime',
        'tgllulus' => 'datetime',
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function perguruan_tinggi()
    {
        return $this->belongsTo('App\Models\PerguruanTinggi', 'kodept');
    }
}
