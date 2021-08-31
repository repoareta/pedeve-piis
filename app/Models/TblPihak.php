<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblPihak extends Model
{
    use HasFactory;

    protected $table = "tbl_pihak";
    protected $primaryKey = 'kd_pihak';
    public $timestamps = false;

    /**
     * Get the post that owns the comment.
     */
    public function perkara()
    {
        return $this->belongsTo(TblPerkara::class, 'no_perkara', 'no_perkara');
    }
}
