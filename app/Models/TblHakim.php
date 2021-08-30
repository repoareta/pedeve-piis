<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblHakim extends Model
{
    use HasFactory;

    protected $table = "tbl_hakim";
    protected $primaryKey = 'kd_hakim';
    public $timestamps = false;

    /**
     * Get the post that owns the comment.
     */
    public function pihak()
    {
        return $this->belongsTo(TblPihak::class, 'kd_pihak', 'kd_pihak');
    }
}
