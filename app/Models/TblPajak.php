<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblPajak extends Model
{
    use HasFactory;

    protected $table="tbl_pajak";
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;//TBL_PAJAK
}
